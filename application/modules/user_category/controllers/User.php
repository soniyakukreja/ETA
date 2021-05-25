<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH. 'third_party/Spout/Autoloader/autoload.php';
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;

use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;
class User extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->userdata = $this->session->userdata('userdata');
	}

	public function index()
	{
        $data['meta_title'] = "Award Level";
		$this->load->view('category');
	}

	public function addcategory(){

        if(!empty($this->input->post()) && $this->input->is_ajax_request()){

            if($this->form_validation->run('add_usercategory')){
               
                $createddate = date('Y-m-d h:i:s');
                $createdby = $this->userdata['user_id'];
                $data = array(
                     
                    'user_cat_name' => $this->input->post('user_cat_name'), 
                    'roles_id' => $this->input->post('role_id'), 
                    'user_cat_status' => $this->input->post('user_cat_status'), 
                    'user_cat_createdby' => $createdby, 
                    'user_cat_createdate' => $createddate, 
                   
                );

              
                $query = $this->generalmodel->add('user_category',$data);
                if(!empty($query)){
                  
                    $return = array('success'=>true,'msg'=>'User Category addedd successfully');
                }else{
                    $return = array('success'=>false,'msg'=>'something went wrong');
                }
            }else{
                $return = array('success'=>false,'msg'=>validation_errors());
            }
            echo json_encode($return); exit;
        }else{
            $data['category'] = $this->generalmodel->get_all_record('user_role');
            $data['meta_title'] = "Add Award Level";
            $this->load->view('addcategory',$data);
        }
    }

     public function editcategory($id){
        $id = decoding($id);
        if(!empty($this->input->post()) && $this->input->is_ajax_request()){

            if($this->form_validation->run('edit_usercategory')){
               
               
                $id =$this->input->post('id');
               
                 $data = array(
                     
                    'user_cat_name' => $this->input->post('user_cat_name'), 
                    'roles_id' => $this->input->post('roles_id'), 
                    'user_cat_status' => $this->input->post('user_cat_status'), 
                );

                $query = $this->generalmodel->updaterecord('user_category',$data,'user_cat_id='.$id);
                if(!empty($query)){
                  
                    $return = array('success'=>true,'msg'=>'User Category addedd successfully');
                }else{
                    $return = array('success'=>false,'msg'=>'something went wrong');
                }
            }else{
                $return = array('success'=>false,'msg'=>validation_errors());
            }
            echo json_encode($return); exit;
        }else{
            $data['cate']= $this->generalmodel->getsingleJoinData('*','user_category','user_role','user_category.roles_id=user_role.urole_id','user_category.user_cat_id='.$id);
            $data['category'] = $this->generalmodel->get_all_record('user_role');
            $data['meta_title'] = "Edit Award Level";
            $this->load->view('editcategory',$data);
        }
    }
  
    public function ajaxcate()
    {
        $datatables = new Datatables(new CodeigniterAdapter);
         
        $datatables->query('SELECT m.user_cat_name,b.rolename,m.user_cat_status,m.user_cat_id FROM user_category as m LEFT JOIN user_role as b ON m.roles_id = b.urole_id WHERE m.user_cat_status!="2"');
    
                $datatables->edit('user_cat_status', function ($data) {
                    if($data['user_cat_status']=='1'){
                       $st= 'Active';
                    }else if($data['user_cat_status']=='0'){
                       $st= 'Inactive';
                    }
                        return $st; 
                });

                //  edit 'id' column
                $datatables->edit('user_cat_id', function ($data) {

                     return '<div class="dropdown"><button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
                                                                    <i class="glyphicon glyphicon-option-vertical"></i>
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <li>
                                                                        <a href="'.site_url().'awardlevel/view/'.encoding($data['user_cat_id']).'">
                                                                            <span class="glyphicon glyphicon-eye-open"></span> View
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="'.site_url().'awardlevel/edit/'.encoding($data['user_cat_id']).'">
                                                                            <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                        </a>
                                                                    </li>
								    <li>
                                                                        <a  href="javascript:void(0)" link="'.site_url().'user_category/User/deletecate/'.encoding($data['user_cat_id']).'" class="deleteEntry">
                                                                            <span class="glyphicon glyphicon-trash"></span> Delete
                                                                        </a>
                                                                    </li>

                                                                </ul></div>';
                });

        echo $datatables->generate();
    }

    public function viewcategory($id)
    {
        $id = decoding($id);
       
        $data['cate']= $this->generalmodel->getsingleJoinData('*','user_category','user_role','user_category.roles_id=user_role.urole_id','user_category.user_cat_id='.$id);
        $data['meta_title'] = "View Award Level";
         $this->load->view('viewcategory',$data);
    }

    public function deletecate($id)
    {
        $id= decoding($id);
       	if ($this->input->is_ajax_request()) {
			$data = array('user_cat_status'=>'2');
			$this->generalmodel->updaterecord('user_category',$data,'user_cat_id='.$id);

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
             $items = 'SELECT m.user_cat_name,b.rolename,m.user_cat_status,m.user_cat_id FROM user_category as m LEFT JOIN user_role as b ON m.roles_id = b.urole_id WHERE m.user_cat_status!="2" AND (m.user_cat_name LIKE "%'.$q.'%" OR b.rolename LIKE "%'.$q.'%" OR m.user_cat_status LIKE "%'.$q.'%")';

        }else{
             $items = 'SELECT m.user_cat_name,b.rolename,m.user_cat_status,m.user_cat_id FROM user_category as m LEFT JOIN user_role as b ON m.roles_id = b.urole_id WHERE m.user_cat_status!="2"';

        }
          
        $query=$this->db->query($items);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'Award Levels.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser
        $cells = [
                WriterEntityFactory::createCell('Category Name'),
                WriterEntityFactory::createCell('Intended User'),
                WriterEntityFactory::createCell('Status'),
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
        //$writer->addRow(array('resource_id', 'lic_number', 'business_name', 'user_cat_name', 'Distributor Name','email','end date'));

        foreach ($obj as $row) {
           if($row['user_cat_status']){ $st= 'Active';}else{ $st= 'Inactive';}
            $data[0] = $row['user_cat_name'];
            $data[1] = $row['rolename'];
            $data[2] = $st;
            
            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
        }
        $writer->close();
    }

}
?>