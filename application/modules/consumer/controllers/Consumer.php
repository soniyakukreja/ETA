<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH. 'third_party/Spout/Autoloader/autoload.php';
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;

include APPPATH.'third_party/phonenumber/autoload.php';
use Brick\PhoneNumber\PhoneNumber;
use Brick\PhoneNumber\PhoneNumberFormat;
use Brick\Phonenumber\PhoneNumberParseException;


use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;


class Consumer extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->userdata = $this->session->userdata('userdata');
	}
	public function index()
	{
		$data['meta_title'] = "Consumers";
        $data['page_heading'] = "All Consumers";
        $this->load->view('consumer_list',$data);
	}

    public function ajaxallconsumer()
    {
        $userid =$this->userdata['user_id'];
        $createdby=$this->userdata['createdby'];
        $perms=explode(",",$this->userdata['upermission']);
        $datatables = new Datatables(new CodeigniterAdapter);
        // if($this->userdata['urole_id']==1)
        // 	$datatables->query('SELECT m.resource_id,m.profilepicture,CONCAT(m.firstname," ",m.lastname) as fullname,m.email,m.user_id FROM user as m  WHERE m.status="1" AND m.urole_id=4 ');
        // else if($this->userdata['urole_id']==2)
       	// 		$datatables->query('SELECT m.resource_id,m.profilepicture,CONCAT(m.firstname," ",m.lastname) as fullname,m.email,m.user_id FROM user as m  WHERE m.status="1" AND m.urole_id=4 and ( m.createdby IN (select user_id from user where createdby='.$userid.'))');
       	// else if($this->userdata['urole_id']==3)
       	// 		$datatables->query('SELECT m.resource_id,m.profilepicture,CONCAT(m.firstname," ",m.lastname) as fullname,m.email,m.user_id FROM user as m  WHERE m.status="1" AND m.urole_id=4 and m.createdby='.$userid.'');
       				

        if($this->userdata['urole_id']==1){
        	$query = 'SELECT m.resource_id,b.business_name,m.profilepicture,CONCAT(m.firstname," ",m.lastname) as fullname
        	,m.email,m.user_id 
        	FROM user as m  
        	LEFT JOIN business AS b ON b.business_id = m.consumer_business_id AND b.status !="2"
        	WHERE m.status="1" AND m.urole_id=4';
        }else if($this->userdata['urole_id']==2){
       		$query = 'SELECT m.resource_id,b.business_name,m.profilepicture,CONCAT(m.firstname," ",m.lastname) as fullname,m.email,m.user_id 
       		FROM user as m  
        	LEFT JOIN business AS b ON b.business_id = m.consumer_business_id AND b.status !="2"
       		WHERE m.status="1" AND m.urole_id=4 and ( m.createdby IN (select user_id from user where createdby='.$userid.'))';
       	}else if($this->userdata['urole_id']==3){
       		$query = 'SELECT m.resource_id,b.business_name,m.profilepicture,CONCAT(m.firstname," ",m.lastname) as fullname,m.email,m.user_id 
	       	FROM user as m  
        	LEFT JOIN business AS b ON b.business_id = m.consumer_business_id AND b.status !="2"
	       	WHERE m.status="1" AND m.urole_id=4 and m.createdby='.$userid;
		}

       	$datatables->query($query);

        $datatables->edit('profilepicture', function ($data) {
            if($data['profilepicture']){
             return '<img src="'.base_url().'uploads/user/'.$data['profilepicture'].'" style="width: 40px; height: 40px;">';    
            }else{
             return '<img src="'.base_url().'assets/img/avtr.png" style="width: 40px; height: 40px;">';
            }
         });
             $datatables->edit('user_id', function($data) use($perms){
             		$menu='';

             		if(in_array('CON_VD', $perms)){
             			$menu.='<li>
	                        <a href="'.site_url('consumer/consumer-detail/').encoding($data['user_id']).'">
	                            <span class="glyphicon glyphicon-eye-open"></span> View
	                        </a>
                    	</li>';
             		}	
             		
             		if(in_array('CON_E', $perms)){
	                    $menu.='<li>
	                        <a href="'.site_url('consumer/editconsumer/').encoding($data['user_id']).'">
	                            <span class="glyphicon glyphicon-pencil"></span> Edit
	                        </a>
	                    </li>';
                	}

                	if(in_array('CON_D', $perms)){
	                    $menu.='<li>
	                        <a  href="javascript:void(0)" link="'.site_url('consumer/deleteconsumer/').encoding($data['user_id']).'" class="deleteEntry">
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

	public function addnew($dealid='')
	{
        if(!empty($dealid)){ $dealid = decoding($dealid); }


		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
    
			if($this->form_validation->run('add_consumer')){
        
                $phone = $this->input->post('phone');       
                $phonecods = $this->input->post('phonecods');

                $finalnum = validatePhone($phone,$phonecods);
                if(!empty($phone) && $finalnum==false){
                    $return = array('success'=>false,'msg'=>"Invalid Phone number for this country");
                    echo json_encode($return); exit;
                }

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

				$business_id = $this->input->post('business_id');
				$business_name = $this->input->post('business_name');

				$already = $this->generalmodel->getparticulardata('consumer_business_id,user_id','user',array('consumer_business_id'=>$business_id),'row_array');

				if(!empty($already)){
					$return = array('success'=>false,'msg'=>'Business already assigned');
					echo json_encode($return); exit;
				}

				$resource_id = resource_id('consumer');

				$createddate = $updatedate = date('Y-m-d h:i:s');
				$createdby = $this->userdata['user_id'];

				$firstname = $this->input->post('firstname');
				$lastname = $this->input->post('lastname');
				$country = $this->input->post('country');
				$email = $this->input->post('email');
				$timezone = $this->input->post('timezone');
				$assign_to = $this->input->post('assign_to');

				$profilepicture = $this->input->post('profilepicture_h');

				$userData['resource_id'] = $resource_id;
				$userData['firstname'] = $firstname;
				$userData['lastname'] = $lastname;
				$userData['profilepicture'] = $profilepicture;
                $userData['user_level'] = $this->userdata['urole_id']; 
                $userData['urole_id'] = 4;
				$userData['dept_id'] = '0';
				$userData['country'] = $country;
				$userData['email'] = $email;
				$userData['password'] = $enc_pass;
				$userData['contactno'] = $finalnum;
				$userData['createdate'] = $createddate;
                $userData['createdby'] = $createdby;
                $userData['timezone'] = $timezone;
                $userData['consumer_business_id'] = $business_id;
                $userData['assign_to'] = $assign_to;
				
				$userData['status'] = 1;

				$this->db->trans_start();
					$query = $this->generalmodel->add('user',$userData);

			        if(!empty($dealid)){
			            $this->db->update('deal',array('user_id'=>$query,'user_role'=>'4'),array('deal_id'=>$dealid));
			        }				
			    $this->db->trans_complete();
				if(!empty($query)){

					if(!empty($profilepicture)){
						$src ='./tmp_upload/'.$profilepicture;
						$destination= './uploads/user/'.$profilepicture;
						rename($src, $destination);		
					}


					/**************************************Mail***************************************/
							$link = site_url('');

			                $mailContent = $this->generalmodel->mail_template('email_subject,email_body','new_account_created_cto');

			                //$user = $this->generalmodel->getparticularData('firstname,lastname,user_id,email','user',array('user_id'=>$createdby),$returnType="row_array");
			               
							//$to = $user['email'];
							$touser = $email;

			                $cto_name = $this->userdata['firstname'].' '.$this->userdata['lastname'];
			                $username = $firstname.' '.$lastname;
			                
			                $loginlink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">Login</a>';

			                $content = $mailContent['email_body'];
			                $content = str_replace('[name]',$cto_name,$content);
			                $content = str_replace('[user_name]',$username,$content);
			                $content = str_replace('[company_name]',$business_name,$content);
			                $content = str_replace('[user_type]',"Consumer",$content);
			                $content = str_replace('[email]',$email,$content); 

			                $subject = $mailContent['email_subject'];
			                $subject = str_replace('[user_name]',$username,$subject);
			                $subject = str_replace('[company_name]',$business_name,$subject);
			                
							$message = $this->load->view('include/mail_template',array('body'=>$content),true);

//echo $this->userdata['email'].'<br>'.$subject.'<br>'.$message;

							
							$mailresponce = $this->sendGridMail('',$this->userdata['email'],$subject,$message);

							$mailContentN = $this->generalmodel->mail_template('email_subject,email_body','new_account_created');

							$content1 = $mailContentN['email_body'];
			                $content1 = str_replace('[name]',$username,$content1);
			                $content1 = str_replace('[user_name]',$username,$content1);
			                $content1 = str_replace('[cto_name]',$cto_name,$content1);
			                $content1 = str_replace('[company_name]',$business_name,$content1);
			                $content1 = str_replace('[user_type]',"Consumer",$content1);
			                $content1 = str_replace('[email]',$email,$content1); 
			                $content1 = str_replace('[password]',$password,$content1); 
			                $content1 = str_replace('[link]',$loginlink,$content1); 

			                $subject1 = $mailContentN['email_subject'];
			                $subject1 = str_replace('[cto_name]',$cto_name,$subject1);
			                $subject1 = str_replace('[company_name]',$business_name,$subject1);
			                
							$message1 = $this->load->view('include/mail_template',array('body'=>$content1),true);


//echo $touser.'<br>'.$subject1.'<br>'.$message1;

							
							$mailresponce = $this->sendGridMail('',$touser,$subject1,$message1);

					/*****************************************************************************/	


					$return = array('success'=>true,'msg'=>'Consumer addedd successfully');
				}else{
					$return = array('success'=>false,'msg'=>'something went wrong');
				}
			}else{
				$return = array('success'=>false,'msg'=>validation_errors());
			}
			echo json_encode($return); exit;
		}else{
            $data['countrylist'] = $this->generalmodel->countrylist(); 
            $data['kam_list'] = $this->generalmodel->kam_list();
            $data['meta_title'] = "Add Consumer";         
			$this->load->view('consumer/addnew',$data);
		}
	}

    public function consumer_detail($cid)
    {	
		$cid = decoding($cid);
		$this->session->set_userdata('customerid',$cid);	
		$data['data']=$this->generalmodel->get_consumerdata($cid);	
		$data['meta_title'] = "View Consumer";		
		$this->load->view('consumer_detail',$data);
    }

    public function editconsumer($id)
	{	$id = decoding($id);
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){

    		if($this->form_validation->run('edit_consumer')){

                $phone = $this->input->post('phone');           
                $phonecods = $this->input->post('phonecods');

                $finalnum = validatePhone($phone,$phonecods);
                if(!empty($phone) && $finalnum==false){
                    $return = array('success'=>false,'msg'=>"Invalid Phone number for this country");
                    echo json_encode($return); exit;
                }
                $id = $this->input->post('id');

                $enc_pass = '';

                $password = $this->input->post('password');
                $cpassword = $this->input->post('cpassword');
                if(!empty($password)){

                    if($password !== $cpassword){
                        $return = array('success'=>false,'msg'=>"Password don't match!");
                        echo json_encode($return); exit;
                    
                    }elseif(!pass_strength($password)){
                        $return = array('success'=>false,'msg'=>'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.');
                        echo json_encode($return); exit;
                    }else{
                        $enc_pass = encrypt_pass($password);
                    }
                }
				
                $firstname = $this->input->post('firstname');
				$lastname = $this->input->post('lastname');
				$country = $this->input->post('country');
				$email = $this->input->post('email');
				$timezone = $this->input->post('timezone');
				$contactno = $finalnum;
				$business_name = $this->input->post('business_name');
				$business_id = $this->input->post('business_id');
				$assign_to = $this->input->post('assign_to');


				$already = $this->generalmodel->getparticulardata('consumer_business_id,user_id','user',array('consumer_business_id'=>$business_id,'user_id !='=>$id),'row_array');

				if(!empty($already)){
					$return = array('success'=>false,'msg'=>'Business already assigned');
					echo json_encode($return); exit;
				}


				$profilepicture = $this->input->post('profilepicture_h');

				$userData['firstname'] = $firstname;
				$userData['lastname'] = $lastname;
				if(!empty($profilepicture)){ $userData['profilepicture'] = $profilepicture; }
				$userData['country'] = $country;
				$userData['email'] = $email;
				$userData['contactno'] = $contactno;
				$userData['timezone'] = $timezone;
				$userData['status'] = 1;
                $userData['consumer_business_id'] = $business_id;
                $userData['assign_to'] = $assign_to;

                if(!empty($enc_pass)){ $userData['password'] = $enc_pass; }

				$query = $this->generalmodel->updaterecord('user',$userData,'user_id='.$id);
				if(!empty($query)){

					if(!empty($profilepicture)){
						$src ='./tmp_upload/'.$profilepicture;
						$destination= './uploads/user/'.$profilepicture;
						rename($src, $destination);		
					}

					$return = array('success'=>true,'msg'=>'Consumer Updated successfully');
				}else{
					$return = array('success'=>false,'msg'=>'something went wrong');
				}
			}else{
				$return = array('success'=>false,'msg'=>validation_errors());
			}
			echo json_encode($return); exit;
		}else{
			$data['countrylist'] = $this->generalmodel->countrylist();
            $data['data']=$this->generalmodel->get_consumerdata($id);
            $data['kam_list'] = $this->generalmodel->kam_list();

            $data['meta_title'] = "Edit Consumer";			
			$this->load->view('consumer/editconsumer',$data);
		}
	}

	public function deleteconsumer($id)
	{	
		$id = decoding($id);
		if ($this->input->is_ajax_request()) {
			$data = array('status'=>'0');
			$this->generalmodel->updaterecord('user',$data,'user_id='.$id);
			$return = array('success'=>true,'msg'=>'Entry Removed');
		}else{
			$return = array('success'=>false,'msg'=>'Internal Error');
		}
		echo json_encode($return);
	}

	public function check_email_exist(){ 
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
            $email = $this->input->post('email');
			$id = '';
            if(!empty($this->input->post('id'))){
                $id = $this->input->post('id');
            }
			$result = $this->generalmodel->check_user_exist($email,$id);

			if(!empty($result)){
				$return = array('success'=>false,'msg'=>'exist');
			}else{
				$return = array('success'=>true,'msg'=>'not exist');
			}
			echo json_encode($return); exit;
		}
	}

    function orderHistory(){
        $data['meta_title'] = "Order history";
        $data['page_heading'] = "Order history";
        $this->load->view('order_histroy',$data);
    }

    function ajax_orederhistory(){

        $userid =$this->userdata['user_id'];
        $datatables = new Datatables(new CodeigniterAdapter);
        $datatables->query('SELECT m.orders_id,m.createdate,m.order_amt,m.orders_id as id FROM orders as m  WHERE  m.createdby="'.$userid.'" ORDER BY m.createdate DESC');
       
        $datatables->edit('createdate', function ($data) {
        	$localtimzone =$this->userdata['timezone'];
             $createdate = gmdate_to_mydate($data['createdate'],$localtimzone);
             return date('m/d/Y',strtotime($createdate));
        });

        $datatables->edit('order_amt', function ($data) {
            return numfmt_format_currency($this->fmt,$data['order_amt'], "USD");
        });

        $datatables->edit('id', function ($data) {
        return '<a href="'.site_url('order-summary/').encoding($data['id']).'" target="_blank">
        <span class="glyphicon glyphicon-eye"></span> view</a>';
        });
         echo $datatables->generate();
    
    }


    public function order_summary($oid){
    	$oid = decoding($oid);
        $data['order_detail'] = $this->shop_model->order_summary($oid);
        $this->load->view('shop/order_summary',$data);
    }

    public function myprofile(){
    	$userid =$this->userdata['user_id'];
		$data['countrylist'] = $this->generalmodel->countrylist();

        $data['prod_cat'] = $this->generalmodel->getparticularData("*",'product_category',array('prod_cat_parent_category_id'=>'0','prod_cat_status'=>'1'),"result_array","","","prod_cat_name");
        $data['data'] = $this->generalmodel->getparticulardata('*','user',array('user_id'=>$userid),'row_array');
        $data['meta_title'] = "Consumer";
        $this->load->view('consumer/myprofile',$data);	
    }

    public function updateprofile(){

    	if(!empty($this->input->post()) && $this->input->is_ajax_request()){

    		if($this->form_validation->run('update_profile')){
                $phone = $this->input->post('phone');           
                $phonecods = $this->input->post('phonecods');

                $finalnum = validatePhone($phone,$phonecods);
                if(!empty($phone) && $finalnum==false){
                    $return = array('success'=>false,'msg'=>"Invalid Phone number for this country");
                    echo json_encode($return); exit;
                }
                $id = $this->userdata['user_id'];
			
				
				$contactno = $finalnum;
    			$password = $this->input->post('password');
    			$cpassword = $this->input->post('cpassword');
				$profilepicture = $this->input->post('profilepicture_h');



    			//$firstname = $this->input->post('firstname');
				// $lastname = $this->input->post('lastname');
				// $country = $this->input->post('country');
				// $email = $this->input->post('email');
				// $dept_id = $this->input->post('dept');
    			// $assign_to = $this->input->post('assign_to');




				// $userData['firstname'] = $firstname;
				// $userData['lastname'] = $lastname;
				// $userData['country'] = $country;
				// $userData['email'] = $email;
				// $userData['status'] = 1;
				$userData['contactno'] = $contactno;
				if(!empty($profilepicture)){ $userData['profilepicture'] = $profilepicture; }
				if(!empty($password) && !empty($cpassword)){
					if($password !== $cpassword){
						$return = array('success'=>false,'msg'=>"Password don't match!");
						echo json_encode($return); exit;
					
					}elseif(!pass_strength($password)){
						$return = array('success'=>false,'msg'=>'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.');
						echo json_encode($return); exit;
					}else{
						$enc_pass = encrypt_pass($password);
					}	
					$userData['password'] = $enc_pass; 
				}

				$query = $this->generalmodel->updaterecord('user',$userData,'user_id='.$id);
				if(!empty($query)){
					if(!empty($profilepicture)){
						$src ='./tmp_upload/'.$profilepicture;
						$destination= './uploads/user/'.$profilepicture;
						rename($src, $destination);		
					}

					$return = array('success'=>true,'msg'=>'Staff Updated successfully');
				}else{
					$return = array('success'=>false,'msg'=>'something went wrong');
				}
			}else{
				$return = array('success'=>false,'msg'=>validation_errors());
			}
			echo json_encode($return); exit;
		}
    }

/*******************Add Note**********************/
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
                	'app_activity_createat' => 'consumer', 
                	// 'app_activity_createat' => 'lic-'.$this->input->post('lic_id'), 
                	'consumer_id' => $this->input->post('consumer_id'), 
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
    	$consumer_id = $this->input->post('consumer_id');
    	$this->load->helper('text');
        $datatables = new Datatables(new CodeigniterAdapter);
        $datatables->query('SELECT m.app_activity_title,concat(b.firstname," ",b.lastname) as user,m.app_activity_des,m.app_activity_createdate,m.app_activity_id FROM app_activity as m LEFT JOIN user as b ON m.app_activity_createdby = b.user_id WHERE m.app_activity_createat ="consumer" AND m.consumer_id="'.$consumer_id.'"  ORDER BY m.app_activity_createdate DESC');
     	  $datatables->edit('app_activity_des', function ($data) {
     	 	$desc = word_limiter($data['app_activity_des'], 10);
     	 	$readmore ='<a class="addDesc" data-id="desc" value="'.$data['app_activity_des'].'"><span class="badge badge-pill badge-secondary">Read More</span></a>'; 
     	 	if(strlen($data['app_activity_des'])>strlen($desc)){
     	 		return $desc.$readmore;
     	 	}else{ return $desc; }
     	 	
     	 });
     	 $datatables->edit('app_activity_createdate', function ($data) {
     	 			$localtimzone =$this->userdata['timezone'];
            		$createdate = gmdate_to_mydate($data['app_activity_createdate'],$localtimzone);
        			return date('m/d/Y',strtotime($createdate));
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
            
            if($this->userdata['urole_id']==1)
        		$items = 'SELECT m.resource_id,m.profilepicture,m.firstname,m.email,m.user_id FROM user as m  WHERE m.status="1" AND m.urole_id=4 AND (m.resource_id LIKE "%'.$q.'%" OR m.firstname LIKE "%'.$q.'%" OR m.email LIKE "%'.$q.'%")';
	        else if($this->userdata['urole_id']==2)
	       		$items = 'SELECT m.resource_id,m.profilepicture,m.firstname,m.email,m.user_id FROM user as m  WHERE m.status="1" AND m.urole_id=4 and ( m.createdby='.$userid.' OR m.createdby IN (select user_id from user where createdby='.$userid.')) AND (m.resource_id LIKE "%'.$q.'%" OR m.firstname LIKE "%'.$q.'%" OR m.email LIKE  "%'.$q.'%")';
	       	else if($this->userdata['urole_id']==3)
       			$items = 'SELECT m.resource_id,m.profilepicture,m.firstname,m.email,m.user_id FROM user as m  WHERE m.status="1" AND m.urole_id=4 and m.createdby='.$userid.' AND (m.resource_id LIKE "%'.$q.'%" OR m.firstname LIKE "%'.$q.'%" OR m.email LIKE "%'.$q.'%")';

        }else{
        	if($this->userdata['urole_id']==1)
        	 	$items = 'SELECT m.resource_id,m.profilepicture,m.firstname,m.email,m.user_id FROM user as m  WHERE m.status="1" AND m.urole_id=4 ';
		        else if($this->userdata['urole_id']==2)
		       	$items = 'SELECT m.resource_id,m.profilepicture,m.firstname,m.email,m.user_id FROM user as m  WHERE m.status="1" AND m.urole_id=4 and ( m.createdby='.$userid.' OR m.createdby IN (select user_id from user where createdby='.$userid.'))';
		       	else if($this->userdata['urole_id']==3)
       			$items = 'SELECT m.resource_id,m.profilepicture,m.firstname,m.email,m.user_id FROM user as m  WHERE m.status="1" AND m.urole_id=4 and m.createdby='.$userid.'';
            
        }
        // $items = 'SELECT prod_cat_name,prod_cat_parent_category_id,prod_cat_status,prod_cat_id FROM product_category WHERE prod_cat_status!="2"';
          
        $query=$this->db->query($items);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'Consumer.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser
        $cells = [
                WriterEntityFactory::createCell('Resource_id'),
                WriterEntityFactory::createCell('Name'),
                WriterEntityFactory::createCell('Email'),
                
              
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
        //$writer->addRow(array('resource_id', 'lic_number', 'business_name', 'user_cat_name', 'Distributor Name','email','end date'));

        foreach ($obj as $row) {
            
            $data[0] = $row['resource_id'];
            $data[1] = $row['firstname'];
            $data[2] = $row['email'];
          
            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
        }
        $writer->close();
    }
    public function ia_detail(){

    	$cid =$this->userdata['user_id'];
    	$lic_ia = $this->generalmodel->lic_ia_ofconsumer($cid);
    	$data['ia_detail'] = $this->generalmodel->get_iadata($lic_ia['ia_userid']);
    	$data['meta_title'] = "Consumer";
    	$this->load->view('consumer/ia_detail',$data);
    }

    public function auditlist(){
    	$data['page_heading']='My Audit Products';
    	$data['meta_title'] = "Audit";
    	$this->load->view('consumer/audit',$data);
    }

    public function ajax_audit(){

        $userid =$this->userdata['user_id'];
        $datatables = new Datatables(new CodeigniterAdapter);
        $query = 'SELECT au.audit_num,au.businessname,au.status,au.updatedate,au.ord_prod_id 
        FROM audit as au 
        LEFT JOIN orders as o ON au.orders_id=o.orders_id
        WHERE o.createdby ='.$userid;
        $datatables->query($query);

		$datatables->edit('updatedate', function ($data) {
                    if($data['updatedate']=='0000-00-00 00:00:00'){
                        return '-';
                    }else{
                        $localtimzone =$this->userdata['timezone'];
                    $createdate = gmdate_to_mydate($data['updatedate'],$localtimzone);
        			return date('m/d/Y',strtotime($createdate));
                    }
        		});

        $datatables->edit('status', function ($data) {
            if($data['status']==0){ return 'Pending Audit'; }elseif($data['status']==1 || $data['status']==2){ return 'Pending Review'; }
            //else if($data['status']==2){return 'Pending Certificate';}
            else if($data['status']==3){return 'Approved';}elseif($data['status']==4){ return 'Denied'; } 
                   
        });

        $datatables->edit('ord_prod_id', function ($data) {
            return '<div class="dropdown"><button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
                <i class="glyphicon glyphicon-option-vertical"></i>
            </button>
            <ul class="dropdown-menu">
                <li>
                    <a href="'.site_url().'audit/viewaudit/'.encoding($data['ord_prod_id']).'">
                        <span class="glyphicon glyphicon-eye-open"></span> View
                    </a>
                </li>
            </ul></div>';
        });

       				/*		
        $datatables->edit('status', function ($data) {
            if($data['status']=='0'){
             return 'Audit';    
            }elseif($data['status']=='1'){
            	return 'Review'; 
            }else{
             return 'Certificate';
            }
        });
        $datatables->edit('updatedate', function ($data) {
            return date('m/Y/d',strtotime($data['updatedate']));
        });
        
		$datatables->edit('orders_id', function($data) use($perms){
				$menu='';

				$menu.='<li>
		        <a href="'.site_url().'consumer/consumer-detail/'.$data['user_id'].'">
		            <span class="glyphicon glyphicon-eye-open"></span> View
		        </a>
			</li>';
				
				
		     return '<div class="dropdown"><button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
		                                                    <i class="glyphicon glyphicon-option-vertical"></i>
		                                                </button>
		                                                <ul class="dropdown-menu">
		                                                '.$menu.'    
		                                                </ul></div>';


return '<div class="dropdown"><button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
            <i class="glyphicon glyphicon-option-vertical"></i>
        </button>
        <ul class="dropdown-menu">
            <li>
                <a href="'.site_url().'audit/viewaudit/'.$data['ord_prod_id'].'">
                    <span class="glyphicon glyphicon-eye-open"></span> View
                </a>
            </li>
        </ul></div>';
                });

		});
		*/
        echo $datatables->generate();

    }
    public function check_business_already(){
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){    	
			$business_id = $this->input->post('b_id');
			$consumer_id = $this->input->post('consuemrid');
			
			$where = "`consumer_business_id`=$business_id";
			if(!empty($consumer_id)){
				$where .= " AND `user_id` !=$consumer_id";
			}

			$already = $this->generalmodel->getparticulardata('consumer_business_id,user_id','user',$where,'row_array');

			if(!empty($already)){
				$return = array('success'=>true,'msg'=>'assigned');
			}else{
				$return = array('success'=>false,'msg'=>'not assigned');
			}
			echo json_encode($return); exit;
		}
    }

}