<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;
class Email_manager extends MY_Controller {
    
    public function __construct(){
        parent::__construct();
        $this->userdata = $this->session->userdata('userdata');
    }
    public function index()
    {
        $data['meta_title'] = "Email Template";
        $this->load->view('template-manager/email_templates_list',$data);
    }

    public function loadTableData(){

        $datatables = new Datatables(new CodeigniterAdapter);
        $datatables->query('SELECT m.email_temp_title,m.visual_urole,m.updated_date,m.email_temp_id FROM email_template as m  WHERE m.status !="2" order by m.email_temp_id');
            $datatables->edit('updated_date', function ($data) {
                $localtimzone =$this->userdata['timezone'];
                $updated_date = gmdate_to_mydate($data['updated_date'],$localtimzone);
                return date('m/d/Y',strtotime($updated_date));
            });
            $datatables->edit('email_temp_id', function ($data) {
                 return '<div class="dropdown"><button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
                            <i class="glyphicon glyphicon-option-vertical"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a  href="'.site_url().'template-manager/email_manager/update_mailtemplate/'.encoding($data['email_temp_id']).'">Edit</a>
                            </li>
                        </ul></div>';
            });
                

        echo $datatables->generate();

    }
    
    public function update_mailtemplate($id)
    {
        $id = decoding($id);
        if(!empty($this->input->post()) && $this->input->is_ajax_request()){
           if($this->form_validation->run('email_template')){

                $createddate = $updatedate = date('Y-m-d h:i:s');
                $createdby = $this->userdata['user_id'];
                //$data['user_role'] = $this->input->post('role_id');
                $data['email_subject'] = $this->input->post('subject');
                $data['email_body'] = $this->input->post('email_body');
                $data['updated_date'] = $createddate;
                $data['updated_by'] = $createdby;
                $data['platform'] = $this->input->ip_address();
                $data['browser'] = $this->agent->browser();
                $data['ipaddress'] = $this->agent->platform();
              
                $query = $this->generalmodel->updaterecord('email_template',$data,array('email_temp_id'=>$id));
                
                if(!empty($query)){
                    $return = array('success'=>true,'msg'=>'Email Template updated successfully');
                }else{
                    $return = array('success'=>false,'msg'=>'something went wrong');
                }
            }else{
                $return = array('success'=>false,'msg'=>validation_errors());
            }
            echo json_encode($return); exit;
        }else{
            $data['detail'] = $this->generalmodel->getparticularData("*","email_template",array('email_temp_id'=>$id),"row_array");
            $data['meta_title'] = "Edit Email Template";
            $this->load->view('template-manager/email_template',$data);
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
             $items = 'SELECT m.email_temp_title,m.visual_urole,m.updated_date,m.email_temp_id FROM email_template as m  WHERE m.status !="2" AND (m.tic_number LIKE "%'.$q.'%" OR m.email_temp_title LIKE "%'.$q.'%" OR b.visual_urole LIKE "%'.$q.'%" OR m.updated_date LIKE "%'.$q.'%")';

        }else{
             $items = 'SELECT m.email_temp_title,m.visual_urole,m.updated_date,m.email_temp_id FROM email_template as m  WHERE m.status !="2"';

        }
        
          
        $query=$this->db->query($items);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'Email Manager.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser
        $cells = [
                WriterEntityFactory::createCell('Title'),
                WriterEntityFactory::createCell('Receivers'),
                WriterEntityFactory::createCell('Last Updated'),
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
        //$writer->addRow(array('resource_id', 'lic_number', 'business_name', 'user_cat_name', 'Distributor Name','email','end date'));

        foreach ($obj as $row) {
                $localtimzone =$this->userdata['timezone'];
                $updated_date = gmdate_to_mydate($row['updated_date'],$localtimzone);
               $date= date('m/d/Y',strtotime($updated_date));
            $data[0] = $row['email_temp_title'];
            $data[1] = $row['visual_urole'];
            $data[2] = $date;
            
            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
        }
        $writer->close();
    }

}