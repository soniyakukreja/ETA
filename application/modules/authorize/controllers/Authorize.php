<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authorize extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->session->userdata('userdata');
		if($this->session->userdata('userdata')){ redirect('dashboard'); }
	}
	public function index()
	{
		$this->load->view('login');
	}

	public function checkuser(){
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
			if($this->form_validation->run('login_step1')){
				$email = $this->input->post('email');
				$data = $this->generalmodel->getparticularData('user_id,email','user',"email='$email' AND status='1' ",'row_array');

				//echo 
				if(!empty($data)){
					$this->session->set_userdata('user_id',$data['user_id']);
					$return = array('success'=>true,'email'=>$email);
				}else{
					$return = array('success'=>false);
				}
			}else{
				$return = array('success'=>false,'msg'=>validation_errors());
			}
			echo json_encode($return);
		}
	}

	public function userlogin(){

		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
			
			if($this->form_validation->run('login_step2')){
				$ip = $this->input->ip_address();
				$lang = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
					//$ip = $_SERVER['REMOTE_ADDR'];

				$user_id= $this->session->userdata('user_id');
				$email = $this->input->post('email');
				$password = $this->input->post('password');
				$user_pass = encrypt_pass($password); 
				$select = "user_id,user_level,dept_id,urole_id,email,password,permission,createdby,firstname,lastname, CONCAT_WS(' ',firstname,lastname) AS username,timezone";
				$data = $this->generalmodel->getparticularData($select,'login',array("email"=>$email,"password"=>$user_pass),'row_array');
				
				if(!empty($data)){

					$sessData['user_id']=$data['user_id'];
					$sessData['email']=$data['email'];
					$sessData['dept_id']=$data['dept_id'];
					$sessData['urole_id']=$data['urole_id'];
					$sessData['user_level']=$data['user_level'];
					$sessData['username']=$data['username'];
					$sessData['firstname']=$data['firstname'];
					$sessData['lastname']=$data['lastname'];
					$sessData['upermission']=$data['permission'];
					$sessData['createdby']=$data['createdby'];
					$sessData['timezone']=$data['timezone'];
					$this->session->set_userdata('userdata',$sessData);

					if($data['urole_id']==4){
						$cartData = $this->generalmodel->user_cartData($data['user_id']);
						$this->session->set_userdata('cartvalue',$cartData['pricetotal']);
						$this->session->set_userdata('cartqty',$cartData['qtytotal']);
					}

					$updata = array('last_login'=>date('Y-m-d h:i:s'),'lastloginipaddress'=>$ip,'attempt'=>0);
					$this->generalmodel->updaterecord('user',$updata,array('user_id'=>$data['user_id']));
					
					/*if($data['urole_id']==4){
						$return = array('success'=>true,'redirect'=>'shop');
					}elseif($data['urole_id']==5){
						$return = array('success'=>true,'redirect'=>'audit/audit');
					}elseif($data['dept_id']==2){
						$return = array('success'=>true,'redirect'=>'cto-dashboard');
					}elseif($data['dept_id']==3){
						$return = array('success'=>true,'redirect'=>'accounts-dashboard');
					}elseif($data['dept_id']==4){
						$return = array('success'=>true,'redirect'=>'csr-dashboard');
					}elseif($data['dept_id']==5){
						$return = array('success'=>true,'redirect'=>'kam-dashboard');
					}elseif($data['dept_id']==9){
						$return = array('success'=>true,'redirect'=>'licensee/viewlicensee');
					}elseif($data['dept_id']==10){
						$return = array('success'=>true,'redirect'=>'it-dashboard');
					}elseif($data['dept_id']==11){
						$return = array('success'=>true,'redirect'=>'lead/deal');
					}else{
						$return = array('success'=>true,'redirect'=>'dashboard');
					}*/

					if($data['urole_id']==4){
						$return = array('success'=>true,'redirect'=>'shop');
					}elseif($data['urole_id']==5){
						$return = array('success'=>true,'redirect'=>'audit/audit');
					}else{
						$return = array('success'=>true,'redirect'=>'dashboard');
					}
					


					$logData['success'] = 1;
				}else{

					$logData['success'] = 0;
					$this->db->query("UPDATE `user` SET `attempt` = `attempt`+1 WHERE `user_id` = $user_id");
					//$this->generalmodel->customquery("UPDATE `user` SET `attempt` = `attempt`+1 WHERE `user_id` = $user_id");
					$return = array('success'=>false);
				}

				$logData['user_id'] = $user_id;
				$logData['platform'] = $this->agent->platform();
				$logData['browser'] = $this->agent->browser();
				$logData['ipaddress'] = $ip;
				$logData['language'] = $lang;

				$logData['createdate'] = date('Y-m-d h:i:s');				
				$this->generalmodel->add('app_access_log',$logData);
			}else{
				$return = array('success'=>false,'msg'=>validation_errors());
			}
			echo json_encode($return);
		}
	}

	public function passmd5(){
		if(!empty($this->input->post('pass')) && $this->input->is_ajax_request()){
			$return = array('success'=>true,'msg'=>md5($_POST['pass']));
		}else{
			$return = array('success'=>false,'msg'=>'');
		}
		echo json_encode($return);
	}

	public function forgotPass(){
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
			if($this->form_validation->run('login_step1')){
				$email = $this->input->post('email');
				$data = $this->generalmodel->getparticularData('user_id,email,firstname,lastname','user',"email='$email'",'row_array');
				if(!empty($data)){

				$str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
				$token = substr(str_shuffle($str_result),0,20); 
				$userId = $data['user_id'];

				$user_id = encoding($userId);
				$sendername = 'ETA';
				$to = $data['email'];
				$link = site_url('reset-password/').$user_id."/".$token;

                $mailContent = $this->generalmodel->mail_template('email_subject,email_body','forget_password');


                $username = $data['firstname'].' '.$data['lastname'] ;
                $reset_link = '<br><a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">Reset My Password</a><br>';
                $content = $mailContent['email_body'];
                $content = str_replace('[name]',$username,$content);
                $content = str_replace('[reset_pass_link]',$reset_link,$content); 

				$message = $this->load->view('include/mail_template',array('body'=>$content),true);
				
				$subject = $mailContent['email_subject'];
				$mailresponce = $this->sendGridMail('',$to,$subject,$message);

				if($mailresponce=="TRUE"){	

					$insertdata['user_id'] = $userId;
					$insertdata['token'] = $token;
					$insertdata['created_at']   = date('Y-m-d h:i:s');
					$insertdata['updated_at']  = date('Y-m-d h:i:s');

					$insertQuery = $this->generalmodel->add('forgot_pass_request',$insertdata);

					if($insertQuery >0){
						$return = array('success'=>true,'msg'=>'ETA will send a resent link to <b>'.$email.'</b>','link'=>$link);
					}else{
						$return = array('success'=>false,'msg'=>'Internal Error');
					}
				}else{
					$return = array('success'=>false,'msg'=>'mail failed');
				}
					
				}else{
					$return = array('success'=>false);
				}
			}else{
				$return = array('success'=>false,'msg'=>validation_errors());
			}
			echo json_encode($return);
		}
	}
}