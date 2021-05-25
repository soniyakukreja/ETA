<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH. 'third_party/Spout/Autoloader/autoload.php';
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;

use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;
class Formtemplate extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->userdata = $this->session->userdata('userdata');
	}

	public function index(){
        $data['meta_title'] = 'Form Template';
		$this->load->view('product/form_temp_manager',$data);
	}

	public function ajax()
    {
        $datatables = new Datatables(new CodeigniterAdapter);
        $datatables->query('SELECT frm_template_name,frm_createdate,frm_status,frm_manager_id FROM  form_manager WHERE frm_status !="2"');
        // edit 'id' column

		$datatables->edit('frm_createdate', function ($data) {
			return date('m/d/Y',strtotime($data['frm_createdate']));
		});

		$datatables->edit('frm_status', function ($data) {
			if($data['frm_status']==1){return 'Active';}else{return 'Inactive';}
		});

        $datatables->edit('frm_manager_id', function ($data) {
			return '<div class="dropdown"><button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
			<i class="glyphicon glyphicon-option-vertical"></i>
			</button>
			<ul class="dropdown-menu">
			<li>
			<a href="'.site_url('product/formtemplate/edit/').encoding($data['frm_manager_id']).'">
			<span class="glyphicon glyphicon-pencil"></span> Edit
			</a>
			</li>
			<li>
			<a href="javascript:void(0)" link="'.site_url('product/formtemplate/delete/').encoding($data['frm_manager_id']).'" class="deleteEntry">
			<span class="glyphicon glyphicon-trash"></span> Delete
			</a>
			</li>
			</ul><div>';
        });

        echo $datatables->generate();
    }

    public function addnew(){
        $data['meta_title'] = 'Add Form Template';
    	$this->load->view('product/add_form_temp',$data);
    }

    public function add_formtemp(){

    	if(!empty($this->input->post()) && $this->input->is_ajax_request()){

    		if($this->form_validation->run('add_formtemp')){

                $frm_template_name = str_replace(' ','_',$this->input->post('temp_name'));
                $tmpdata = $this->generalmodel->getparticularData("frm_template_name","form_manager",array('frm_template_name'=>$frm_template_name,'frm_status !='=>'2'),"row_array");       
                if(!empty($tmpdata)){ $return = array('success'=>false,'msg'=>'Template with this name already exist'); }

    			$data['frm_template_name'] = $this->input->post('temp_name');
    			$data['frm_manager_fields'] = $this->input->post('frm_manager');
    			$data['editable_html'] = $this->input->post('editable_html');
    			$data['frm_status'] = "1";
    			$data['frm_createdate'] = date('Y-m-d h:i:s');

		    	$query = $this->generalmodel->add('form_manager',$data);
				if ($query) {
					$return = array('success'=>true,'msg'=>'Template added successfully');
				} else {
					$return = array('success'=>false,'msg'=>'something went wrong');
				}
			}else{
				$return = array('success'=>false,'msg'=>validation_errors());
			}
			
		}
		echo json_encode($return); exit;
    }

    public function edit($id){
    	$id = decoding($id);
    	$data['data'] = $this->generalmodel->getparticularData("*","form_manager",array('frm_manager_id'=>$id,'frm_status !='=>'2'),"row_array");   	
        $data['meta_title'] = 'Edit Form Template';
        $this->load->view('product/edit_form_temp',$data);
    }

    public function update_frm_template(){
    	//print_r($_POST); exit;


    	if(!empty($this->input->post()) && $this->input->is_ajax_request()){

    		if($this->form_validation->run('update_formtemp')){

    			$tmp_id = $this->input->post('tmp_id');
    			$tmp_name = $this->input->post('temp_name');

    			$where = "`frm_manager_id`!=".$tmp_id." AND `frm_template_name`='".$tmp_name."'";
    			$getData = $this->generalmodel->getparticularData("frm_template_name","form_manager",$where,"row_array");

    			if(!empty($getData)){
    				$return = array('success'=>false,'msg'=>'Template with this name already exist');
    				echo json_encode($return); exit;
    			}

    			$frm_template_name = str_replace(' ','_',$this->input->post('temp_name'));
    			$data['frm_template_name'] = $tmp_name;
    			$data['frm_manager_fields'] = $this->input->post('frm_manager');
    			$data['editable_html'] = $this->input->post('editable_html');
    			$data['frm_status'] = "1";
    			$data['frm_createdate'] = date('Y-m-d h:i:s');


		    	$query = $this->generalmodel->updaterecord('form_manager',$data,array('frm_manager_id'=>$tmp_id));

                if ($query) {
					$return = array('success'=>true,'msg'=>'Template updated successfully');
				} else {
					$return = array('success'=>false,'msg'=>'something went wrong');
				}
			}else{
				$return = array('success'=>false,'msg'=>validation_errors());
			}
		}
		echo json_encode($return); exit;
    }

    public function delete($id){
    	$id = decoding($id);
    	if ($this->input->is_ajax_request()) {

            $data = array('frm_status'=>'2');
        	$this->generalmodel->updaterecord('form_manager',$data,'frm_manager_id='.$id);

            $return = array('success'=>true,'msg'=>'Entry Removed');
        }else{
            $return = array('success'=>false,'msg'=>'Internal Error');
        }
        echo json_encode($return);

    }

    public function export()
    {
        set_time_limit(0);
        ini_set('memory_limit', -1);
        $userid =$this->userdata['user_id'];
        $perms=explode(",",$this->userdata['upermission']);
         $q = $this->input->post('search');
        
        if($q!=''){

            $items = 'SELECT frm_template_name,frm_createdate,frm_status,frm_manager_id FROM  form_manager WHERE frm_status !="2" AND (frm_template_name LIKE "%'.$q.'%" OR frm_createdate LIKE "%'.$q.'%" OR frm_status LIKE "%'.$q.'%")';
        }else{
            // $items = 'SELECT u.resource_id,m.supplier_bname,b.prod_cat_name,m.supplier_fname,u.email,m.supplier_id FROM supplier as m LEFT JOIN product_category as b ON m.user_cat_id = b.user_cat_id LEFT JOIN user as u ON m.user_id = u.user_id  WHERE m.supplier_status !="0" AND u.urole_id="5"';
            $items = 'SELECT frm_template_name,frm_createdate,frm_status,frm_manager_id FROM  form_manager WHERE frm_status !="2"';

        }
          
        $query=$this->db->query($items);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'Formtemplate.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser
        $cells = [
                 WriterEntityFactory::createCell('Template Name'),
                WriterEntityFactory::createCell('Create Date'),
                WriterEntityFactory::createCell('Status'),
               
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
        //$writer->addRow(array('resource_id', 'lic_number', 'business_name', 'user_cat_name', 'Distributor Name','email','end date'));

        foreach ($obj as $row) {
            if($row['frm_status']==1){$st= 'Active';}else{$st ='Inactive';}

            $localtimzone =$this->userdata['timezone'];
            $tic_activity_createdate = gmdate_to_mydate($row['frm_createdate'],$localtimzone);
            $date = date('m/d/Y',strtotime($tic_activity_createdate));

            $data[0] = $row['frm_template_name'];
            $data[1] = $date;
            $data[2] = $st;
          
          
            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
        }
        $writer->close();
    }

}