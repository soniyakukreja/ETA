<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Myprofile extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->userdata = $this->session->userdata('userdata');
	}

	public function index(){

		$data['countrylist'] = $this->generalmodel->countrylist();
        $data['deptlist'] = $this->generalmodel->deptlist();

        $data['data'] = $this->generalmodel->my_profile_data();

        if($this->userdata['urole_id']==4){
	    	$cid =$this->userdata['user_id'];
	    	$lic_ia = $this->generalmodel->lic_ia_ofconsumer($cid);
	    	$data['ia_detail'] = $this->generalmodel->get_iadata($lic_ia['ia_userid']);        	
        }
         $data['meta_title'] = "My Profile";
		$this->load->view('user/myprofile',$data);
	}


	public function updatePasswordForm(){
		if(!empty($_POST) && $this->input->is_ajax_request()){

			$this->form_validation->set_rules('old_password','Old Password','trim|required');
			$this->form_validation->set_rules('password','Password','trim|required');
			$this->form_validation->set_rules('cpassword','Comfirm Password','trim|required');
			
			if($this->form_validation->run()== TRUE)
			{
				$oldPass = $this->input->post('old_password');
				$newPass = $this->input->post('password');
				$cpassword = $this->input->post('cpassword');
				$enc_pass = encrypt_pass($newPass);
				$enc_oldpass = encrypt_pass($oldPass);


				$userId = $this->userdata['user_id'];
				$where = array('user_id'=>$userId);
				$where1 = array('user_id'=>$userId,'password'=>$enc_oldpass);

				$getdata = $this->generalmodel->getparticularData("password","user",$where1,"row_array");
				

				if(empty($getdata)){
					$responce = array('success'=>false,'msg'=>"Old Password is not correct!");
					echo json_encode($responce); exit;
				}elseif($newPass !== $cpassword){
					$responce = array('success'=>false,'msg'=>"Password don't match!");
					echo json_encode($responce); exit;
				}elseif(!pass_strength($newPass)){
					$responce = array('success'=>false,'msg'=>'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.');
					echo json_encode($responce); exit;
				}

				if($enc_oldpass==$enc_pass){
					$responce  = array('success'=>false,'msg'=>'Old and New password cannot be the same');
					echo json_encode($responce);exit;
				}else{

					$updateData['password'] = $enc_pass;
					$updateData['updatedate'] = date('Y-m-d h:i:s');
					$updateData['updatedby'] = $userId;

					$update = $this->generalmodel->updaterecord('user',$updateData,$where);

					if($update){
						$responce = array('success'=>true,'msg'=>'Password Updated');
					}else{
						$responce = array('success'=>false,'msg'=>'Internal Error');
					}
					echo json_encode($responce);exit;
				}
			}else{
				$responce = array('success'=>false,'msg'=>validation_errors());
				echo json_encode($responce);exit;
			}
		}
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
	public function logout(){
		$this->session->unset_userdata('userdata');
		redirect('');
	}
}