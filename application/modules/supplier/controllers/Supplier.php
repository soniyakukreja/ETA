<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH. 'third_party/Spout/Autoloader/autoload.php';
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;

use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;
class Supplier extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->userdata = $this->session->userdata('userdata');
		$this->load->model('Supplier_model');
		$this->session->unset_userdata('licenseeid');
	}
	public function index()
	{
		$data['meta_title'] = "Supplier";
		$this->load->view('suppliers', $data);
	}

	public function ajax()
    {
    	$userid =$this->userdata['user_id'];
    	$perms=explode(",",$this->userdata['upermission']);
        $datatables = new Datatables(new CodeigniterAdapter);
        /*$datatables->query('SELECT supplier_resource_id,supplier_bname,prod_cat_id,supplier_fname,supplier_email,supplier_id FROM supplier ');*/
        $datatables->query('SELECT u.resource_id,m.supplier_bname,b.user_cat_name,CONCAT(m.supplier_fname," ",m.supplier_lname) as fullname,u.email,m.supplier_id,u.user_id FROM supplier as m LEFT JOIN user_category as b ON m.user_cat_id = b.user_cat_id LEFT JOIN user as u ON m.user_id = u.user_id  WHERE m.supplier_status !="0" AND u.urole_id=5');

                // // edit 'id' column
                $datatables->edit('supplier_id',  function($data) use($perms){
                		$menu=''; 
                		if(in_array('SUPP_VD',$perms)){
	                        $menu.='<li>
	                            <a href="'.site_url('supplier/supplierdetail/').encoding($data['user_id']).'">
	                                <span class="glyphicon glyphicon-eye-open"></span> View
	                            </a>
	                        </li>';     
                    	}
                    	if(in_array('SUPP_E',$perms)){
	                        $menu.='<li>
                            <a href="'.site_url('supplier/editsupplier/').encoding($data['supplier_id']).'">
                                <span class="glyphicon glyphicon-pencil"></span> Edit
                            </a>
                        	</li>';     
                    	}
                    	if(in_array('SUPP_D',$perms)){
	                        $menu.='<li>
                            <a href="javascript:void(0)" link="'.site_url('supplier/deletesupplier/').encoding($data['supplier_id']).'" class="deleteEntry">
                                <span class="glyphicon glyphicon-trash"></span> Delete
                            </a>
                        	</li>';     
                    	}

                	 return '<div class="dropdown"><button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
                                                                    <i class="glyphicon glyphicon-option-vertical"></i>
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                '.$menu.'   
                                                                </ul></div>';
                });


        echo $datatables->generate();
    }

	 public function supplierdetail($id)
    {
    	$id = decoding($id);
        $this->session->set_userdata('supplierid',$id);
       	$select = array('m.supplier_id','m.supplier_fname','m.supplier_lname','b.resource_id','m.user_cat_id','m.supplier_bname','b.profilepicture','m.supplier_bname','b.country','b.email','b.user_id','b.contactno','b.profilepicture');
        $data['sup']=$this->generalmodel->getsingleJoinData($select,'supplier as m','user as b','m.user_id = b.user_id','b.user_id='.$id);
       $data['meta_title'] = "View Supplier";
        $this->load->view('supplier/supplier_detail',$data);
    }


	public function addsupplier(){
		
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){

			if($this->form_validation->run('add_supplier')){
				$createddate = date('Y-m-d h:i:s');
				$createdby = $this->userdata['user_id'];
				$urole_id = $this->userdata['urole_id'];
				
				$password = $this->input->post('password');
                $cpassword = $this->input->post('cpassword');

                if($password !== $cpassword){
                    $return = array('success'=>false,'msg'=>"Password don't match!");
                    echo json_encode($return); exit;
                
                }elseif(!pass_strength($password)){
                    $return = array('success'=>false,'msg'=>'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.');
                    echo json_encode($return); exit;
                }else{
                    $enc_pass = encrypt_pass($password);
                }

				$ipaddress = $this->input->ip_address();
				$resource_id = resource_id('supplier');

				$business_id = $this->input->post('business_id');
				$firstname = $this->input->post('supplier_fname');
				$lastname = $this->input->post('supplier_lname');
				$country = $this->input->post('supplier_country');
				$email = $this->input->post('supplier_email');
				$contactno = $this->input->post('phone');
				$timezone = $this->input->post('timezone');
				$business_name = $this->input->post('business_name');
				

				$profilepicture = $this->input->post('supplier_profilepic_h');

				$userData['resource_id'] = $resource_id;
                $userData['firstname'] = $firstname;
                $userData['lastname'] = $lastname;
				$userData['dept_id'] = 0;
                $userData['urole_id'] = 5;
                $userData['user_level'] = $urole_id;
				$userData['email'] = $email;
				$userData['country'] = $country;
                $userData['password'] = $enc_pass;
                $userData['contactno'] = $contactno;
                $userData['profilepicture'] = $profilepicture;
                $userData['createdby'] = $createdby;
                $userData['timezone'] = $timezone;
                $userData['status'] = 1;

				//=========Add Supplier start =========//
				$data = array(
					'supplier_fname'=> $firstname,
					'supplier_lname'=> $lastname,
					// 'prod_cat_id'=> $this->input->post('prod_cat_id'),
					'user_cat_id'=> $this->input->post('user_cat_id'),
					'supplier_bname'=> $business_name,
					'supplier_status'=>1,
					'business_id'=> $business_id						 
				);
			
				
				$query = $this->Supplier_model->add_supplier($userData,$data);
				if(!empty($query)){

				//==========move from temp to actual location start=====//
					if(!empty($profilepicture)){
						$src ='./tmp_upload/'.$profilepicture;
						$destination= './uploads/user/'.$profilepicture;
						rename($src, $destination);	
					}
					

					/**************************************Mail***************************************/
							$link = site_url('');

			                $mailContent = $this->generalmodel->mail_template('email_subject,email_body','new_account_created_cto');

			                $user = $this->generalmodel->getparticularData('firstname,lastname,user_id,email','user',array('user_id'=>$createdby),$returnType="result_array");
			               
							$to = $user[0]['email'];
							$touser = $email;

			                $name = $user[0]['firstname'].' '.$user[0]['lastname'];
			                $username = $firstname.' '.$lastname;
			                
			                $loginlink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">Login</a>';

			                $content = $mailContent['email_body'];
			                $content = str_replace('[name]',$name,$content);
			                $content = str_replace('[user_name]',$username,$content);
			                $content = str_replace('[company_name]',$business_name,$content);
			                $content = str_replace('[user_type]',"Supplier",$content);
			                $content = str_replace('[email]',$email,$content); 

			                $subject = $mailContent['email_subject'];
			                $subject = str_replace('[user_name]',$username,$subject);
			                $subject = str_replace('[company_name]',$business_name,$subject);
			                
							$message = $this->load->view('include/mail_template',array('body'=>$content),true);
							
							$mailresponce = $this->sendGridMail('',$to,$subject,$message);

							$mailContentN = $this->generalmodel->mail_template('email_subject,email_body','new_account_created');

							$content1 = $mailContentN['email_body'];
			                $content1 = str_replace('[name]',$username,$content1);
			                $content1 = str_replace('[user_name]',$username,$content1);
			                $content1 = str_replace('[cto_name]',$name,$content1);
			                $content1 = str_replace('[company_name]',$business_name,$content1);
			                $content1 = str_replace('[user_type]',"Supplier",$content1);
			                $content1 = str_replace('[email]',$email,$content1); 
			                $content1 = str_replace('[password]',$password,$content1); 
			                $content1 = str_replace('[link]',$loginlink,$content1); 

			                $subject1 = $mailContentN['email_subject'];
			                $subject1 = str_replace('[cto_name]',$name,$subject1);
			                $subject1 = str_replace('[company_name]',$business_name,$subject1);
			                
							$message1 = $this->load->view('include/mail_template',array('body'=>$content1),true);
							
							$mailresponce = $this->sendGridMail('',$touser,$subject1,$message1);

					/*****************************************************************************/	
					$return = array('success'=>true,'msg'=>'Supplier addedd successfully','resource_id'=>$resource_id);
				}else{
					$return = array('success'=>false,'msg'=>'something went wrong');
				}

			}else{
				$return = array('success'=>false,'msg'=>validation_errors());
			}
			echo json_encode($return); exit;
		}else{
			$data['countrylist'] = $this->generalmodel->countrylist();
			$data['category'] = $this->generalmodel->get_data_by_condition('user_cat_id,user_cat_name','user_category',array('roles_id'=>$this->userdata['urole_id']));
			// $data['category'] = $this->generalmodel->get_all_record('user_category');
			$data['meta_title'] = "Add Supplier";
			$this->load->view('suppliers_form',$data);
		}

	}

	public function editsupplier($id){
		$id = decoding($id);
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
			//echo "<pre>"; print_r($_POST); exit;
			if($this->form_validation->run('edit_supplier')){
					
				$id = $this->input->post('supplier_id');
				$firstname = $this->input->post('supplier_fname');
				$lastname = $this->input->post('supplier_lname');
				$country = $this->input->post('supplier_country');
				$email = $this->input->post('supplier_email');
				$contactno = $this->input->post('phone');
				$business_name = $this->input->post('business_name');
				$business_id = $this->input->post('business_id');
				$category = $this->input->post('user_cat_id');
				// $category = $this->input->post('prod_cat_id');
				$timezone = $this->input->post('timezone');
				

				//==========move from temp to actual location start=====//
				$profilepicture = $this->input->post('supplier_profilepic_h');

				//==========move from temp to actual location end=====//

				//============check email duplicacy==========//
				$user = $this->generalmodel->getparticularData("user_id",'supplier',"`supplier_id`=$id","row_array");
				
				$query = $this->generalmodel->getparticularData("email",'user',"`email`='$email' AND `user_id` !=".$user['user_id'],"row_array");
				if(!empty($query)){
					$return = array('success'=>false,'msg'=>"Email Address is already registerd!");
					echo json_encode($return); exit;					
				}




	 			$business_id = $this->input->post('business_id');
	 			$sdata = $this->generalmodel->get_supplier_of_business($business_id,$id);
	 			if(!empty($sdata)){
					$return = array('success'=>false,'business_err'=>true,'msg'=>'Business Already assigned');
	 				echo json_encode($return); exit;
	 			}



				$userData['firstname'] = $firstname;
                $userData['lastname'] = $lastname;
				$userData['email'] = $email;
				$userData['country'] = $country;
                $userData['contactno'] = $contactno;
                $userData['timezone'] = $timezone;
                

				//=========Add Supplier start =========//
				$data = array(
					'supplier_fname'=> $firstname,
					'supplier_lname'=> $lastname,
					'supplier_bname'=> $business_name,
					// 'prod_cat_id'=> $category,
					'user_cat_id'=> $category,
					'business_id'=> $business_id				  
							 
				);

				if ($profilepicture) {
					$userData['profilepicture'] = $profilepicture;
				}
				

				// print_r($data); exit;
				$this->generalmodel->updaterecord('user',$userData,'user_id='.$user['user_id']);
				
				$query = $this->generalmodel->updaterecord('supplier',$data,'supplier_id='.$id);
				// echo $this->db->last_query(); exit;
				if($query>0){

					if(!empty($profilepicture)){
						$src ='./tmp_upload/'.$profilepicture;
						$destination= './uploads/user/'.$profilepicture;
						rename($src, $destination);	
					}
				
					$return = array('success'=>true,'msg'=>'Supplier Updated successfully');
				}else{
					$return = array('success'=>false,'msg'=>'something went wrong');
				}

			}else{
				$return = array('success'=>false,'msg'=>validation_errors());
			}
			echo json_encode($return); exit;
		}else{
			$data['deptlist'] = $this->generalmodel->deptlist();
			$data['countrylist'] = $this->generalmodel->countrylist();
			$data['categorylist'] = $this->generalmodel->categorylist();
			// $data['category'] = $this->generalmodel->get_all_record('user_category');
			$data['category'] = $this->generalmodel->get_data_by_condition('user_cat_id,user_cat_name','user_category',array('roles_id'=>$this->userdata['urole_id']));
			$select = array('m.supplier_id','m.business_id','m.supplier_fname','m.supplier_lname','m.user_cat_id','b.profilepicture','m.supplier_bname','b.country','b.email','b.user_id','b.contactno','b.timezone');
       		$data['sup']=$this->generalmodel->getsingleJoinData($select,'supplier as m','user as b','m.user_id = b.user_id','m.supplier_id='.$id);
       		$data['meta_title'] = "Edit Supplier";
			$this->load->view('editsupplier',$data);
		}

	}

	// public function deletesupplier($id)
	// {
		
	// 	$data = array('supplier_status'=>'1');
	// 	$this->generalmodel->updaterecord('supplier',$data,'supplier_id='.$id);
	// 	redirect('Supplier','refresh');
	// }


    public function deletesupplier($id)
    {
    	$id = decoding($id);
        if ($this->input->is_ajax_request()) {
        	$user = $this->generalmodel->getparticularData("user_id",'supplier',"`supplier_id`=$id","row_array");
            $udata = array('status'=>'0');
            $data = array('supplier_status'=>'0');
            
            $this->generalmodel->updaterecord('user',$udata,'user_id='.$user['user_id']);

            $this->generalmodel->updaterecord('supplier',$data,'supplier_id='.$id);

            $return = array('success'=>true,'msg'=>'Entry Removed');
        }else{
            $return = array('success'=>false,'msg'=>'Internal Error');
        }
        echo json_encode($return);

    }


	public function addnote(){
		if($this->form_validation->run('add_note')){
				
				 $createdate = date('Y-m-d h:i:s');
                $createdby = $this->userdata['user_id'];
                // $resource_id =  rand(111,999);
                $assign_to = $assign_date = '';
               

                $ipaddress = $this->input->ip_address();

                $data = array(
                	'app_activity_title' => $this->input->post('app_activity_title'), 
                	'app_activity_des' => $this->input->post('app_activity_des'), 
                	'app_activity_createdate' =>  $createdate, 
                	'app_activity_createdby' => $createdby, 
                	'app_activity_createat' => 'supplier', 
                	// 'app_activity_createat' => 'lic-'.$this->input->post('lic_id'), 
                	'supplier_id' => $this->input->post('supplier_id'), 
                	'app_activity_ipaddress' =>$ipaddress, 
                	'app_activity_platform' => $this->agent->platform(),
                	'app_activity_webbrowser' => $this->agent->browser(), 
                );

              $lastid = $this->generalmodel->add('app_activity', $data);
              if ($lastid) {
              	 $return = array('success'=>true,'msg'=>'Activity Added Successfully');
                }else{
                   $return = array('success'=>false,'msg'=>'something went wrong');
                }
            }else{
                $return = array('success'=>false,'msg'=>validation_errors());
            }
            echo json_encode($return);
	}

	public function viewnote()
    {
    	$supplier_id= $this->input->post('supplier_id');
    	$this->load->helper('text');
        $datatables = new Datatables(new CodeigniterAdapter);
        $datatables->query('SELECT m.app_activity_title,concat(b.firstname," ",b.lastname) as name,m.app_activity_des,m.app_activity_createdate FROM app_activity as m LEFT JOIN user as b ON m.app_activity_createdby = b.user_id WHERE m.app_activity_createat ="supplier" AND m.supplier_id="'.$supplier_id.'"');
     
     	 $datatables->edit('app_activity_des', function ($data) {
     	 	$desc = word_limiter($data['app_activity_des'], 10);
     	 	$readmore ='<a class="addDesc" data-id="desc" value="'.$data['app_activity_des'].'"><span class="badge badge-pill badge-secondary">Read More</span></a>'; 
     	 	if(strlen($data['app_activity_des'])>strlen($desc)){
     	 		return $desc.$readmore;
     	 	}else{ return $desc; }
     	 	
     	 });

     	 $datatables->edit('app_activity_createdate', function ($data) {
     	 			$localtimzone =$this->userdata['timezone'];
                    $tic_activity_createdate = gmdate_to_mydate($data['app_activity_createdate'],$localtimzone);
                    return date('m/d/Y',strtotime($tic_activity_createdate));
        			// return date('m/d/Y',strtotime($data['app_activity_createdate']));
        		});

        echo $datatables->generate();
    }

	public function export()
    {
        set_time_limit(0);
        ini_set('memory_limit', -1);
        $userid =$this->userdata['user_id'];
        $perms=explode(",",$this->userdata['upermission']);
         $q = $this->input->post('search');
        
        if($q!=''){

        	$items = 'SELECT u.resource_id,m.supplier_bname,b.user_cat_name,CONCAT(m.supplier_fname," ",m.supplier_lname) as fullname,u.email,m.supplier_id,u.user_id FROM supplier as m LEFT JOIN user_category as b ON m.user_cat_id = b.user_cat_id LEFT JOIN user as u ON m.user_id = u.user_id  WHERE m.supplier_status !="0" AND u.urole_id=5 AND (u.resource_id LIKE "%'.$q.'%" OR m.supplier_bname LIKE "%'.$q.'%" OR b.prod_cat_name LIKE "%'.$q.'%" OR m.supplier_fname LIKE "%'.$q.'%" OR u.email LIKE "%'.$q.'%")';
		}else{
        	// $items = 'SELECT u.resource_id,m.supplier_bname,b.prod_cat_name,m.supplier_fname,u.email,m.supplier_id FROM supplier as m LEFT JOIN product_category as b ON m.user_cat_id = b.user_cat_id LEFT JOIN user as u ON m.user_id = u.user_id  WHERE m.supplier_status !="0" AND u.urole_id="5"';
        	$items = 'SELECT u.resource_id,m.supplier_bname,b.user_cat_name,CONCAT(m.supplier_fname," ",m.supplier_lname) as fullname,u.email,m.supplier_id,u.user_id FROM supplier as m LEFT JOIN user_category as b ON m.user_cat_id = b.user_cat_id LEFT JOIN user as u ON m.user_id = u.user_id  WHERE m.supplier_status !="0" AND u.urole_id=5';

		}
          
        $query=$this->db->query($items);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'Supplier.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser
        $cells = [
                 WriterEntityFactory::createCell('Resource ID'),
                WriterEntityFactory::createCell('Business Name'),
                WriterEntityFactory::createCell('Category'),
                WriterEntityFactory::createCell('Name'),
                WriterEntityFactory::createCell('Email Address'),
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
        //$writer->addRow(array('resource_id', 'lic_number', 'business_name', 'user_cat_name', 'Distributor Name','email','end date'));

        foreach ($obj as $row) {
            
            $data[0] = $row['resource_id'];
            $data[1] = $row['supplier_bname'];
            $data[2] = $row['prod_cat_name'];
            $data[3] = $row['supplier_fname'];
            $data[4] = $row['email'];
          
            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
        }
        $writer->close();
    }

    public function check_supplier_already_added(){
 		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
 		
 		echo "<pre>"; print_r($_POST); exit;
 			$business_id = $this->input->post('business_id');
 			// $supplier_id = $this->input->post('supplier_id');
 			// $data = $this->generalmodel->get_supplier_of_business($business_id,$supplier_id);
 			$data = $this->generalmodel->get_supplier_of_business($business_id);
 			if(!empty($data)){
				$return = array('success'=>false,'msg'=>'Business Already assigned');
 			}else{
				$return = array('success'=>true,'msg'=>'');
 			}

 			echo json_encode($return);
 		}
    }



}