<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH. 'third_party/Spout/Autoloader/autoload.php';
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;


use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;
class Licensee extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->userdata = $this->session->userdata('userdata');
		$this->load->model('licensee_model');
	}
	public function index()
	{
		
	}

	public function viewlicensee()
	{
		$this->load->view('licensee/viewlicensee');
	}

	public function ajax()
    {
    	
        $userid =$this->userdata['user_id'];
        $createdby =$this->userdata['createdby'];
        $perms=explode(",",$this->userdata['upermission']);
        $datatables = new Datatables(new CodeigniterAdapter);
        if($this->userdata['dept_id']==1){

				$datatables->query('SELECT m.resource_id,m.lic_number,m.business_name,c.user_cat_name,b.firstname,b.email,m.lic_enddate,m.user_id,m.lic_id FROM licensee as m LEFT JOIN user as b ON m.user_id = b.user_id LEFT JOIN user_category as c ON m.category = c.user_cat_id WHERE b.status !="0"');
			
        }else{

	        if($this->userdata['urole_id']==1 || $this->userdata['urole_id']==2)
				$datatables->query('SELECT m.resource_id,m.lic_number,m.business_name,c.user_cat_name,b.firstname,b.email,m.lic_enddate,m.user_id,m.lic_id FROM licensee as m LEFT JOIN user as b ON m.user_id = b.user_id LEFT JOIN user_category as c ON m.category = c.user_cat_id WHERE b.status !="0" AND b.createdby='.$userid.'');
			// else if()
			// 		$datatables->query('SELECT m.resource_id,m.lic_number,m.business_name,c.user_cat_name,b.firstname,b.email,m.lic_enddate,m.user_id,m.lic_id FROM licensee as m LEFT JOIN user as b ON m.user_id = b.user_id LEFT JOIN user_category as c ON m.category = c.user_cat_id WHERE b.status !="0" and b.createdby='.$userid.'');
        }
		
		$datatables->edit('lic_enddate', function ($data) {
        			return date('m/d/Y',strtotime($data['lic_enddate']));
        		});
                  // // edit 'id' column
                $datatables->edit('user_id', function($data) use($perms){

                		$menu='';
                		if(in_array('LIC_VD',$perms)){
                			$menu.='<li>
	                        <a href="'.site_url().'licensee/licenseedetail/'.$data['user_id'].'">
	                            <span class="glyphicon glyphicon-eye-open"></span> View
	                        </a>
	                    	</li>';	
                		}


                		if(in_array('LIC_E',$perms)){
		                    $menu.='<li>
		                        <a href="'.site_url().'licensee/editlicensee/'.$data['user_id'].'">
		                            <span class="glyphicon glyphicon-pencil"></span> Edit
		                        </a>
		                    </li>';
	                	}

	                	if(in_array('PROD_VD',$perms)){
		                    $menu.='<li>
		                        <a href="'.site_url().'product/productassign/'.$data['lic_id'].'">
		                            <span class="glyphicon glyphicon-eye-open"></span> Product
		                        </a>
		                    </li>';
		                 }
		                 
		                 if(in_array('LIC_D',$perms)){
		                	$menu.='<li>
	                        <a  href="javascript:void(0)" link="'.site_url().'licensee/deletelic/'.$data['user_id'].'" class="deleteEntry">
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

     public function licenseedetail($id)
    {
        $select = array('m.user_id','m.lic_id','m.resource_id','m.category','m.lic_number','m.lic_startdate','m.lic_enddate','m.lic_profilepicture','m.license_file','b.firstname','b.lastname','m.business_name','b.dept_id','b.country','b.email','b.contactno','b.profilepicture');
        $data['ia']=$this->generalmodel->getsingleJoinData($select,'licensee as m','user as b','m.user_id = b.user_id','m.user_id='.$id);
        $this->load->view('licensee/licensee_detail',$data);
    }


	public function addlicensee(){
		
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){

			if($this->form_validation->run('add_licensee')){

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
				$ip_address = $this->input->ip_address();
				$platform = $this->agent->platform();
				$browser = $this->agent->browser();
				$createdby = $this->userdata['user_id'];
                $mylevel = $this->userdata['user_level'];

				
				$createddate = $updatedate = date('Y-m-d h:i:s');

				$resource_id =  resource_id('licensee');
				
				$assign_to = $assign_date = '';
				$urole_id = 2;


				$lic_number = $this->input->post('lic_number');
				$lic_startdate = get_ymd_format($this->input->post('lic_startdate'));
				$lic_enddate = get_ymd_format($this->input->post('lic_enddate'));
				if(!compare_dates($lic_startdate,$lic_enddate)){
					$return = array('success'=>false,'msg'=>'Please add correct start and end dates');
					echo json_encode($return); exit;
				}
					
				$firstname = $this->input->post('firstname');
				$lastname = $this->input->post('lastname');
				$country = $this->input->post('l_country');
				$email = $this->input->post('email');
				$contactno = $this->input->post('phone');
				$phonecods = $this->input->post('phonecods');


				$finalnum = validatePhone($contactno,$phonecods);
                if(!empty($contactno) && $finalnum==false){
                    $return = array('success'=>false,'msg'=>"Invalid Phone number for this country");
                    echo json_encode($return); exit;
                }else{
                    $contactno = $finalnum;
                }

				$business_name = $this->input->post('business_name');
				$category_name = $this->input->post('category');
				//$dept_id = $this->input->post('dept');
				$dept_id = '2';

				//==========move from temp to actual location start=====//
				$lic_profilepicture = $this->input->post('lic_profilepicture_h');
				$profilepicture = $this->input->post('profilepicture_h');

				//==========move from temp to actual location end=====//

				//==========upload doc file=====//
				if(!empty($_FILES['license_file']['name'])){
					$fileData = $this->uploadDoc('license_file','./uploads/licensee_file',array('pdf'));
					
					if(empty($fileData['error'])){
						$filename = $fileData['file_name'];
					}else{
						$return = array('success'=>false,'msg'=>$fileData['error']);
						echo json_encode($return); exit;
					}
				}else{
					$filename = '';
				}
				//==========upload doc file=====//

				//=========user table data =========//
               

				$userData['resource_id'] = $resource_id;
				$userData['firstname'] = $firstname;
				$userData['lastname'] = $lastname;
				$userData['profilepicture'] = $profilepicture;
				$userData['dept_id'] = $dept_id;
				$userData['urole_id'] = $urole_id;
				$userData['user_level'] = $mylevel;
				$userData['country'] = $country;
				$userData['email'] = $email;
				$userData['contactno'] = $contactno;
				$userData['createdate'] = $createddate;
				$userData['createdby'] = $createdby;
				$userData['updatedate'] = $updatedate;
				$userData['password'] = $enc_pass;
				$userData['status'] = '1';

				//=========Business Data=========//
				if(!empty($business_id)){
					$busData = array();
					$licData['business_id'] = $business_id;
				}else{

					$rules =array(
		                array(
		                        'field' => 'business_name',
		                        'label' => 'Business name',
		                        'rules' => 'required|trim|xss_clean|is_unique[business.business_name]'
		                ),
		                array(
		                        'field' => 'address',
		                        'label' => 'Street Address',
		                        'rules' => 'required|trim|xss_clean'
		                ),
		                array(
		                        'field' => 'suburb',
		                        'label' => 'Suburb',
		                        'rules' => 'required|trim|xss_clean'
		                ),
		                array(
		                        'field' => 'postcode',
		                        'label' => 'Post Code',
		                        'rules' => 'required|trim|xss_clean'
		                ),
		                array(
		                        'field' => 'country',
		                        'label' => 'Country',
		                        'rules' => 'required|trim|xss_clean'
		                ),
			        );

					$this->form_validation->set_rules($rules);
					if($this->form_validation->run()){
						$address = $this->input->post('address');
						$suburb = $this->input->post('suburb');
						$postcode = $this->input->post('postcode');
						$bcountry = $this->input->post('country');

						$busData['business_name'] = $business_name;
						$busData['business_street1'] = $address;
						$busData['business_suburb'] = $suburb;
						$busData['business_postalcode'] = $postcode;
						$busData['business_country'] = $bcountry;
						$busData['business_createddate'] = $createddate;
						$busData['business_createdby'] = $createdby;
						$busData['business_ipaddress'] = $ip_address;
						$busData['business_platform'] = $platform;
						$busData['business_webbrowser'] = $browser;					
					}else{
						$return = array('success'=>false,'msg'=>validation_errors());
						echo json_encode($return); exit;
					}
				}

				//========= licensee table data=========//

				$licData['resource_id'] = $resource_id;
				$licData['assign_to'] = $assign_to;
				$licData['assign_date'] = $assign_date;				
				$licData['lic_number'] = $lic_number;
				$licData['lic_startdate'] = $lic_startdate;
				$licData['lic_enddate'] = $lic_enddate;
				$licData['license_file'] = $filename;
				$licData['country'] = $country;
				$licData['lic_profilepicture'] = $lic_profilepicture;
				$licData['createdby'] = $createdby;
				$licData['createddate'] = $createddate;
				$licData['ipaddress'] = $ip_address;
				$licData['platform'] = $platform;
				$licData['browser'] = $browser;
				$licData['category'] = $category_name;
				$licData['business_name'] = $business_name;
				$licData['status'] = '1';

				$query = $this->licensee_model->add_licensee($userData,$licData,$busData);
				if(!empty($query)){

					if(!empty($lic_profilepicture)){
						$src ='./tmp_upload/'.$lic_profilepicture;
						$destination= './uploads/licensee_profile/'.$lic_profilepicture;
						rename($src, $destination);		
					}

					if(!empty($profilepicture)){
						$src ='./tmp_upload/'.$profilepicture;
						$destination= './uploads/cto_profile/'.$profilepicture;
						rename($src, $destination);	
					}
					$return = array('success'=>true,'msg'=>'Licensee addedd successfully','resource_id'=>'#'.$resource_id);
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
			$this->load->view('addlicensee',$data);
		}
	}

	public function licensee_busList(){

		$response=array();
		if ($this->input->is_ajax_request()) {
			if(isset($_POST['term'])){
				
				$term=$this->input->post('term');
				$result=$this->licensee_model->lcnsee_bus_suggession($term);

				$resultData='';
				$recordFound=0;
				if(!empty($result)){
					foreach($result as $cr){
						$resultData.='<li class="l_busItem list-group-item" data-val="'.$cr['business_id'].'">'.$cr['business_name'].'</li>';
					}
					$response['status']='success';
					$response['data']=$resultData;
				}else{
					$response['status']='fail';
				}
				
				
				//$response['message']=count($result).' Record Found ';
				
			}else{
				$response['status']='fail';
				$response['message']='Invalid API key 1';
			}
		}else{
			$response['status']='fail';
			$response['message']='Invalid API key 2';
		}
		print_r(json_encode($response));
	
	}

	public function editlicensee($id){
		
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){

			if($this->form_validation->run('edit_lic')){
				
				$updatedate = date('Y-m-d h:i:s');
                $createdby = $this->userdata['user_id'];
                $assign_to = $assign_date = '';
                $ip_address = $this->input->ip_address();
                $platform = $this->agent->platform();
				$browser = $this->agent->browser();
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

                $li_id= $this->input->post('id');
                $lic_number = $this->input->post('lic_number');
             	$lic_startdate = get_ymd_format($this->input->post('lic_startdate'));
				$lic_enddate = get_ymd_format($this->input->post('lic_enddate'));
                $firstname = $this->input->post('firstname');
                $lastname = $this->input->post('lastname');
                $l_country = $this->input->post('l_country');
                $email = $this->input->post('email');
                $contactno = $this->input->post('phone');
				$phonecods = $this->input->post('phonecods');
                $business_name = $this->input->post('business_name');
                $category = $this->input->post('category');
                $address = $this->input->post('address');
                $suburb = $this->input->post('suburb');
                $postcode = $this->input->post('postcode');
                $country = $this->input->post('country');
                $profilepicture = $this->input->post('profilepicture_h');
                $lic_profilepicture = $this->input->post('lic_profilepicture_h');
 				$business_id = $this->input->post('business_id');

				//==========lic date compare=========
				if(!compare_dates($lic_startdate,$lic_enddate)){
					$return = array('success'=>false,'msg'=>'Please add correct start and end dates');
					echo json_encode($return); exit;
				}

				//==========validate contact number=========

				$finalnum = validatePhone($contactno,$phonecods);
                if(!empty($contactno) && $finalnum==false){
                    $return = array('success'=>false,'msg'=>"Invalid Phone number for this country");
                    echo json_encode($return); exit;
                }else{
                    $contactno = $finalnum;
                }

				//============check email duplicacy==========//
				$user = $this->generalmodel->getparticularData("user_id",'licensee',"`lic_id`=$li_id","row_array");
				
				$query = $this->generalmodel->getparticularData("email",'user',"`email`='$email' AND `user_id` !=".$user['user_id'],"row_array");
				if(!empty($query)){
					$return = array('success'=>false,'msg'=>"Email Address is already registerd!");
					echo json_encode($return); exit;					
				}


				//==========upload doc file=====//
				if(!empty($_FILES['license_file']['name'])){
					$fileData = $this->uploadDoc('license_file','./uploads/licensee_file');
					
					if(empty($fileData['error'])){
						$filename = $fileData['file_name'];
					}else{
						$return = array('success'=>false,'msg'=>$fileData['error']);
						echo json_encode($return); exit;
					}
				}else{
					$filename = '';
				}
				//==========upload doc file=====//



				//============check business duplicacy==========//
				$user = $this->generalmodel->getparticularData("user_id",'licensee',"`lic_id`=$li_id","row_array");
				
				$query = $this->generalmodel->getparticularData("email",'user',"`email`='$email' AND `user_id` !=".$user['user_id'],"row_array");
				if(!empty($query)){
					$return = array('success'=>false,'msg'=>"Email Address is already registerd!");
					echo json_encode($return); exit;					
				}



                //=========Add user start =========//

                $userData['firstname'] = $firstname;
                $userData['lastname'] = $lastname;
                if(!empty($profilepicture)){ 
                	$userData['profilepicture'] = $profilepicture;
                }
                $userData['country'] = $country;
                $userData['email'] = $email;
                $userData['contactno'] = $contactno;
                $userData['updatedate'] = $updatedate;
				$userData['updatedate'] = $updatedate;
				if(!empty($enc_pass)){ $userData['password'] = $enc_pass; }

                //=========Add licensee start=========//
                
                $licData['lic_number'] = $lic_number;
                $licData['lic_startdate'] = $lic_startdate;
                $licData['lic_enddate'] = $lic_enddate;
				if(!empty($filename)){ $licData['license_file'] = $filename; }
                $licData['country'] = $l_country;
                if(!empty($lic_profilepicture)){ $licData['lic_profilepicture'] = $lic_profilepicture; }
                $licData['createdby'] = $createdby;
                $licData['ipaddress'] = $ip_address;
                $licData['platform'] = $this->agent->platform();
                $licData['browser'] = $this->agent->browser();
                $licData['business_name'] = $business_name;
				$licData['category'] = $category;


				//=========business Data start=========//
				//$busData['business_name'] = $business_name;
				$busData['business_street1'] = $address;
				$busData['business_suburb'] = $suburb;
				$busData['business_postalcode'] = $postcode;
				$busData['business_country'] = $country;
				$busData['business_ipaddress'] = $ip_address;
				$busData['business_platform'] = $platform;
				$busData['business_webbrowser'] = $browser;		
				$busData['update_business'] = true;     

                $query = $this->licensee_model->update_li($userData,$licData,$busData,$user['user_id'],$business_id);
                if(!empty($query)){

                    if(!empty($profilepicture)){
                        $src ='./tmp_upload/'.$profilepicture;
                        $destination= './uploads/cto_profile/'.$profilepicture;
                        rename($src, $destination);     
                    }

                    if(!empty($lic_profilepicture)){
                        $src ='./tmp_upload/'.$lic_profilepicture;
                        $destination= './uploads/licensee_profile/'.$lic_profilepicture;
                        rename($src, $destination); 
                    }

                    $return = array('success'=>true,'msg'=>'Licensee Updated Successfully');
                }else{
                    $return = array('success'=>false,'msg'=>'something went wrong');
                }
            }else{
                $return = array('success'=>false,'msg'=>validation_errors());
            }
            echo json_encode($return); exit;
		}else{

			$data['ia']=$this->licensee_model->getLicenseeData($id);
			
            $data['deptlist'] = $this->generalmodel->deptlist();
            $data['countrylist'] = $this->generalmodel->countrylist();
            $data['categorylist'] = $this->generalmodel->categorylist();
			$this->load->view('editlicensee',$data);
		}

	}


	public function uploadImage(){
		if ($this->input->is_ajax_request()) {
            if(!empty($_POST["image"])){
            	$data = $_POST["image"];
            	$imageName = $this->uploadTmpImg($data);
                // $return = array('success'=>true,'fileName'=>$imageName);
				$directmove = $this->input->post('directmove');
                
                if($directmove=="true"){
                	$path = $this->input->post('path');
                	$table = $this->input->post('table');
                	$field = $this->input->post('field');
                	$name = $this->input->post('name');
                	$id = $this->input->post('id');

					$src ='./tmp_upload/'.$imageName;
					$destination= './uploads/'.$path.'/'.$imageName;
					rename($src, $destination);		


					$this->generalmodel->updaterecord($table,array($field=>$imageName),array($name=>$id));
					$return = array('success'=>true,'fileName'=>$imageName,'show'=>'update');
					
                }else{
                	$return = array('success'=>true,'fileName'=>$imageName,'show'=>'insert');
                }

                echo json_encode($return);
            }
        }
	}

	public function deletelic($id)
	{
		if ($this->input->is_ajax_request()) {

			$this->licensee_model->delete_lic($id);

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
                	'app_activity_createat' => 'licensee', 
                	// 'app_activity_createat' => 'lic-'.$this->input->post('lic_id'), 
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
    	$this->load->helper('text');
        $datatables = new Datatables(new CodeigniterAdapter);
        $datatables->query('SELECT m.app_activity_title,b.firstname,b.lastname,m.app_activity_des,m.app_activity_createdate,m.app_activity_id FROM app_activity as m LEFT JOIN user as b ON m.app_activity_createdby = b.user_id WHERE m.app_activity_createat ="licensee" ORDER BY m.app_activity_createdate DESC');
     	 $datatables->edit('app_activity_des', function ($data) {
     	 	$desc = word_limiter($data['app_activity_des'], 10);
     	 	// return $desc.'......<a href="#addDesc" data-toggle="modal" id="addDesc">read more</a>';
     	 	return $desc.'<a class="addDesc" data-id="desc" value="'.$data['app_activity_des'].'"><span class="badge badge-pill badge-secondary">Read More</span></a>';
     	 });
     	 $datatables->edit('app_activity_createdate', function ($data) {
        			return date('m/d/Y',strtotime($data['app_activity_createdate']));
        		});
        echo $datatables->generate();
    }

    public function check_email_exist(){
    	if(!empty($this->input->post()) && $this->input->is_ajax_request()){
			$email = $this->input->post('email');
			$id ='';
			if(!empty($this->input->post('id'))){ $id = $this->input->post('id'); }

			$result = $this->generalmodel->check_user_exist($email,$id);

			if(!empty($result)){
				$return = array('success'=>false,'msg'=>'exist');
			}else{
				$return = array('success'=>true,'msg'=>'not exist');
			}
			
			echo json_encode($return); exit;
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
			if($this->userdata['urole_id']==1)
				$items = 'SELECT m.resource_id,m.lic_number,m.business_name,c.user_cat_name,b.firstname,b.email,m.lic_enddate,m.user_id,m.lic_id FROM licensee as m LEFT JOIN user as b ON m.user_id = b.user_id LEFT JOIN user_category as c ON m.category = c.user_cat_id WHERE b.status !="0" AND (m.resource_id LIKE "%'.$q.'%" OR m.lic_number LIKE "%'.$q.'%" OR m.business_name LIKE "%'.$q.'%" OR c.user_cat_name LIKE "%'.$q.'%" OR b.firstname LIKE "%'.$q.'%" OR b.email LIKE "%'.$q.'%" OR m.lic_enddate LIKE "%'.$q.'%")';
			else if($this->userdata['urole_id']==2)
					$items = 'SELECT m.resource_id,m.lic_number,m.business_name,c.user_cat_name,b.firstname,b.email,m.lic_enddate,m.user_id,m.lic_id FROM licensee as m LEFT JOIN user as b ON m.user_id = b.user_id LEFT JOIN user_category as c ON m.category = c.user_cat_id WHERE b.status !="0" and b.createdby='.$userid.'AND (m.resource_id LIKE "%'.$q.'%" OR m.lic_number LIKE "%'.$q.'%" OR m.business_name LIKE "%'.$q.'%" OR c.user_cat_name LIKE "%'.$q.'%" OR b.firstname LIKE "%'.$q.'%" OR b.email LIKE "%'.$q.'%" OR m.lic_enddate LIKE "%'.$q.'%")';
		}else{

	        if($this->userdata['urole_id']==1)
				$items = 'SELECT m.resource_id,m.lic_number,m.business_name,c.user_cat_name,b.firstname,b.email,m.lic_enddate,m.user_id,m.lic_id FROM licensee as m LEFT JOIN user as b ON m.user_id = b.user_id LEFT JOIN user_category as c ON m.category = c.user_cat_id WHERE b.status !="0"';
			else if($this->userdata['urole_id']==2)
					$items = 'SELECT m.resource_id,m.lic_number,m.business_name,c.user_cat_name,b.firstname,b.email,m.lic_enddate,m.user_id,m.lic_id FROM licensee as m LEFT JOIN user as b ON m.user_id = b.user_id LEFT JOIN user_category as c ON m.category = c.user_cat_id WHERE b.status !="0" and b.createdby='.$userid.'';
		}

        $query=$this->db->query($items);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'License.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser
        $cells = [
                WriterEntityFactory::createCell('Resource ID'),
                WriterEntityFactory::createCell('License Number'),
                WriterEntityFactory::createCell('Business Name'),
                WriterEntityFactory::createCell('Category'),
                WriterEntityFactory::createCell('CTO Name'),
                WriterEntityFactory::createCell('CTO Email Address'),
                WriterEntityFactory::createCell('License End Date'),
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
        //$writer->addRow(array('resource_id', 'lic_number', 'business_name', 'user_cat_name', 'Distributor Name','email','end date'));

        foreach ($obj as $row) {
            $data[0] = $row['resource_id'];
            $data[1] = $row['lic_number'];
            $data[2] = $row['business_name'];
            $data[3] = $row['user_cat_name'];
            $data[4] = $row['firstname'];
            $data[5] = $row['email'];
            $data[6] = date('m/d/Y',strtotime($row['lic_enddate']));
            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
        }
        $writer->close();
    }

}