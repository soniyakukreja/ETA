<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;
class Doc_manager extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->userdata = $this->session->userdata('userdata');
	}
	public function index()
	{
        $data['meta_title'] = "Document Template";
		$this->load->view('template-manager/doc_templates_list',$data);
	}

	public function loadTableData(){

        $datatables = new Datatables(new CodeigniterAdapter);
        $datatables->query('SELECT m.temp_title,b.rolename,m.doc,m.updated_date,m.document_id FROM document_template as m LEFT JOIN user_role as b ON m.user_role = b.urole_id WHERE m.status !="2"');
    		$datatables->edit('doc', function ($data) {
    			return '<a target="_blank" download href="'.base_url().'uploads/doc_template/'.$data['doc'].'" class="downldBtn">Download <span class="glyphicon glyphicon-download-alt"></span></a>';
    		});

    		$datatables->edit('updated_date', function ($data) {
                $localtimzone =$this->userdata['timezone'];
                $updated_date = gmdate_to_mydate($data['updated_date'],$localtimzone);
    			return date('m/d/Y',strtotime($updated_date));
    		});
    		/*
            $datatables->edit('document_id', function ($data) {
            	 return '<div class="dropdown"><button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
                            <i class="glyphicon glyphicon-option-vertical"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a  href="'.site_url().'template-manager/doc_manager/update_document/'.$data['document_id'].'">
                                    <span class="glyphicon glyphicon-trash"></span> Upload
                                </a>
                            </li>
                        </ul></div>';
            });
			*/
            $datatables->edit('document_id', function ($data) {
            	if(!empty($data['document_id'])){
            	 return '<a href="'.site_url('template-manager/doc-manager/update-document/').encoding($data['document_id']).'">
                                    <span class="glyphicon glyphicon-pencil"></span>Upload</a>
                           ';            		
            	}

            });
        echo $datatables->generate();
	}
	
	public function update_document($id)
	{
        $id = decoding($id);
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){

			if($this->form_validation->run('doc_template')){

				if(!empty($_FILES['document']['name'])){
					$fileData = $this->uploadDoc('document','./uploads/doc_template');
					
					if(empty($fileData['error'])){
						$filename = $fileData['file_name'];
					}else{
						$return = array('success'=>false,'msg'=>$fileData['error']);
						echo json_encode($return); exit;
					}
				}else{
					$return = array('success'=>false,'msg'=>'Please upload document');
					echo json_encode($return); exit;
					$filename = '';
				}

				$createddate = $updatedate = date('Y-m-d h:i:s');
				$createdby = $this->userdata['user_id'];

				$data['doc'] = $filename;
				$data['updated_date'] = $createddate;
				$data['updated_by'] = $createdby;
				$data['platform'] = $this->input->ip_address();
				$data['browser'] = $this->agent->browser();
				$data['ipaddress'] = $this->agent->platform();

				$query = $this->generalmodel->updaterecord('document_template',$data,array('document_id'=>$id));
				
				if(!empty($query)){
					$return = array('success'=>true,'msg'=>'Document Updated successfully');
				}else{
					$return = array('success'=>false,'msg'=>'something went wrong');
				}
			}else{
				$return = array('success'=>false,'msg'=>validation_errors());
			}
			echo json_encode($return); exit;
		}else{
			$data['detail'] = $this->generalmodel->getparticularData("*","document_template",array('document_id'=>$id),"row_array");
            $data['meta_title'] = "Edit Document Template";
			$this->load->view('template-manager/upload-doc-form',$data);
		}
	}

	public function export()
    {
        set_time_limit(0);
        ini_set('memory_limit', -1);
        $userid =$this->userdata['user_id'];
        $perms=explode(",",$this->userdata['upermission']);
        $q = $this->input->post('search');
        
        if($q!=''){
             $items = 'SELECT m.temp_title,b.rolename,m.doc,m.updated_date,m.document_id FROM document_template as m LEFT JOIN user_role as b ON m.user_role = b.urole_id WHERE m.status !="2" AND (m.tic_number LIKE "%'.$q.'%" OR m.tic_title LIKE "%'.$q.'%" OR b.tic_cat_name LIKE "%'.$q.'%")';

        }else{
             $items = 'SELECT m.temp_title,b.rolename,m.doc,m.updated_date,m.document_id FROM document_template as m LEFT JOIN user_role as b ON m.user_role = b.urole_id WHERE m.status !="2"';

        }
        
          
        $query=$this->db->query($items);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'Document Manager.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser
        $cells = [
                WriterEntityFactory::createCell('Title'),
                WriterEntityFactory::createCell('User Type'),
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
        //$writer->addRow(array('resource_id', 'lic_number', 'business_name', 'user_cat_name', 'Distributor Name','email','end date'));

        foreach ($obj as $row) {
           
            $data[0] = $row['temp_title'];
            $data[1] = $row['rolename'];
           
            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
        }
        $writer->close();
    }
}