<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Resetpass extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
	}

	public function reset($userId,$token){ 
		$userId = decoding($userId);
		$data['userData'] = $this->generalmodel->getparticulardata('firstname','user',array('user_id'=>$userId),'row_array');

		$this->load->view('resetPasswordPage',$data);
	}

	public function resetPasswordForm(){
		if(!empty($_POST) && $this->input->is_ajax_request()){
			$userId = decoding($_POST['userId']);
			$where = array('user_id'=>$userId,'token'=>$_POST['token'],'valid'=>1);
			$data = $this->generalmodel->getparticulardata('id','forgot_pass_request',$where);

			if(!empty($data)){

				$password = $this->input->post('pass');
				$cpassword = $this->input->post('cpass');

				if($password !== $cpassword){
					$responce = array('success'=>false,'msg'=>"Your Password doesn't match");
					echo json_encode($responce); exit;
				
				}elseif(!pass_strength($password)){
					$responce = array('success'=>false,'msg'=>'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.');
					echo json_encode($responce); exit;
				}else{
					$enc_pass = encrypt_pass($password);
				}

				$updateData['password'] = $enc_pass;
				$updateData['last_login'] = date('Y-m-d h:i:s');
				$updateData['lastloginipaddress'] = $this->input->ip_address();
				$updateData['attempt'] = 0;

				$update = $this->generalmodel->updaterecord('user',$updateData,array('user_id'=>$userId));

				$update = $this->generalmodel->updaterecord('forgot_pass_request',array('valid'=>0),$where);

				$select = "user_id,user_level,dept_id,urole_id,email,password,permission,createdby,firstname,lastname, CONCAT_WS(' ',firstname,lastname) AS username,timezone";
				$userData = $this->generalmodel->getparticulardata($select,'login',array('user_id'=>$userId),'row_array');

				if (!empty($userData)){	

					$sessData['user_id']=$userData['user_id'];
					$sessData['email']=$userData['email'];
					$sessData['dept_id']=$userData['dept_id'];
					$sessData['urole_id']=$userData['urole_id'];
					$sessData['user_level']=$userData['user_level'];
					$sessData['username']=$userData['username'];
					$sessData['firstname']=$userData['firstname'];
					$sessData['lastname']=$userData['lastname'];
					$sessData['upermission']=$userData['permission'];
					$sessData['createdby']=$userData['createdby'];
					$sessData['timezone']=$userData['timezone'];
					$this->session->set_userdata('userdata',$sessData);
					$redirectUrl = site_url();					
				}
				$responce = array('success'=>true,'link'=>$redirectUrl);
			}else{
				$responce = array('success'=>false,'msg'=>'Link Expired!');
			}
		}else{
			$responce = array('success'=>false,'msg'=>'Invalid url');
		}
		echo json_encode($responce);
	}
}