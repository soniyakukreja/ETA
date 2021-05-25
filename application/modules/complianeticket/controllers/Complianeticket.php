<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Complianeticket extends MY_Controller {

   public function __construct(){
        parent::__construct();
        $this->userdata = $this->session->userdata('userdata');
        // if($this->session->userdata('userdata')){ redirect('dashboard'); }
    }

    public function index()
	{
		$data['countrylist'] = $this->generalmodel->countrylist();
		$this->load->view('complianlogin',$data);
	}

	/*
	public function userlogin(){

		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
			
			if($this->form_validation->run('clogin_step2')){
				
				$ip = $this->input->ip_address();
				$lang = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
					//$ip = $_SERVER['REMOTE_ADDR'];
				$email = $this->input->post('email');
				$password = $this->input->post('password');
				$user_pass = encrypt_pass($password); 

				$edata = $this->generalmodel->getparticularData('user_id,email','user',"email='$email'",'row_array');
				if(!empty($edata)){
				 $this->session->set_userdata('user_id',$edata['user_id']);
				 $user_id= $this->session->userdata('user_id');
					// $return = array('success'=>true,'email'=>$email);
				}else{
					$return = array('success'=>false);
				}

				$select = "user_id,user_level,dept_id,urole_id,email,password,permission,createdby, CONCAT_WS(' ',firstname,lastname) AS username";
				$data = $this->generalmodel->getparticularData($select,'login',array("email"=>$email,"password"=>$user_pass),'row_array');
				
				if(!empty($data)){

					$sessData['user_id']=$data['user_id'];
					$sessData['email']=$data['email'];
					$sessData['dept_id']=$data['dept_id'];
					$sessData['urole_id']=$data['urole_id'];
					$sessData['user_level']=$data['user_level'];
					$sessData['username']=$data['username'];
					$sessData['upermission']=$data['permission'];
					$sessData['createdby']=$data['createdby'];
					$this->session->set_userdata('userdata',$sessData);

					if($data['urole_id']==4){
						$cartvalue = $this->generalmodel->user_cartvalue($data['user_id']);
						$this->session->set_userdata('cartvalue',$cartvalue);
					}

					$updata = array('last_login'=>date('Y-m-d h:i:s'),'lastloginipaddress'=>$ip,'attempt'=>0);
					$this->generalmodel->updaterecord('user',$updata,array('user_id'=>$data['user_id']));
					$return = array('success'=>true);
					$logData['success'] = 1;
				}else{

					$logData['success'] = 0;
					$this->generalmodel->customquery("UPDATE `user` SET `attempt` = `attempt`+1 WHERE `user_id` = $user_id");
					//$this->generalmodel->updaterecord('user',array("attempt"=>"+1"),array('user_id'=>$user_id));
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
	*/

	public function addcompliance()
	{
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
			
			if($this->form_validation->run('addcompliance')){

				$ip_address = $this->input->ip_address();
				$platform = $this->agent->platform();
				$browser = $this->agent->browser();
				//$createdby = $this->userdata['user_id'];
				$createdby =0;
				$business = $this->input->post('business_id');
				$business_name = $this->input->post('business_name');
				$country = $this->input->post('l_country');

				$user = $this->generalmodel->getparticularData("business_country",'business',"`business_id`=$business","row_array");
				
				if($user['business_country']!=$country){
					$return = array('success'=>false,'businessErr'=>true,'msg'=>"Wrong Entry Please Check Company Name or location");
					echo json_encode($return); exit;
				}
				$ticket_number = rand(11111,99999);
				$createdate = date('Y-m-d');
				$message = $this->input->post('message');
				$data = array(
					'comp_tic_status'=>1,
					'comp_tic_num'=> $ticket_number,
					'comp_tic_business_id'=>$business,
					'comp_tic_country_id'=>$country,
					'comp_tic_createdby '=>$createdby,
					'comp_tic_createdate '=>$createdate,
					'comp_tic_ipaddress'=>$ip_address,
					'comp_tic_message'=>$message,
					'tic_category_id'=>1,

				); 

				$query = $this->generalmodel->add('complianeticket',$data);
				
				if(!empty($query)){
							
							$link = site_url('complianeticket/whistleblower/viewticket/').encoding($query);

			                $mailContent = $this->generalmodel->mail_template('email_subject,email_body','new_whistle_blower');

			                $users = $this->generalmodel->getparticularData('firstname,lastname,user_id,email,timezone','user',array('urole_id'=>1,'dept_id'=>7,'status'=>1),$returnType="result_array");

			                $status = "Pending";
			                $reset_link = '<br><a href="'.$link.'" style="background: ##a1c76b; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a><br>';

			                $content = $mailContent['email_body'];
			                $content = str_replace('[ticket_number]',$ticket_number,$content);
			                $content = str_replace('[ticket_status]',$status,$content);
			                $content = str_replace('[company_name]',$business_name,$content);
			                $content = str_replace('[message]',$message,$content);
			                $content = str_replace('[description_link]',$reset_link,$content); 

			                $subject = $mailContent['email_subject'];
			                $subject = str_replace('[ticket_number]',$ticket_number,$subject);
			                

			                if(!empty($users)){ foreach($users as $user){

			                	$cont = $content;

			                	$toCompliance_officer = $user['email'];
			                	$name = $user['firstname'].' '.$user['lastname'];

				                $cont = str_replace('[name]',$name,$cont);

								$message = $this->load->view('include/mail_template',array('body'=>$cont),true);
								
								// echo $toCompliance_officer.'<br>'.$subject.'<br>'.$message;

								$mailresponce = $this->sendGridMail('',$user['email'],$subject,$message);
							} }
					$return = array('success'=>true,'businessErr'=>false,'msg'=>'Compliance ticket addedd successfully');
				}else{
					$return = array('success'=>false,'businessErr'=>false,'msg'=>'something went wrong');
				}

			}else{
				$return = array('success'=>false,'businessErr'=>false,'msg'=>validation_errors());
			}
			echo json_encode($return); exit;

		}
	}

	public function busList(){

		$response=array();
		if ($this->input->is_ajax_request()) {
			if(isset($_POST['term'])){
				
				$term=$this->input->post('term');
				$this->load->model('Compliance_model');
				$result=$this->Compliance_model->bus_suggession($term);
				
				$resultData='';
				$recordFound=0;
				if(!empty($result)){
					foreach($result as $cr){
						$user=$this->generalmodel->getSingleRowById('user', 'user_id', $cr['business_createdby'], $returnType = 'array');
							$resultData.='<li class="l_busItem list-group-item" data-val="'.$cr['business_id'].'">';
						if($user['profilepicture']){
							$resultData.='<img src="'.base_url().'uploads/cto_profile/'.$user['profilepicture'].'" style="width: 15px; height:15px;" >'.$cr['business_name'].'</li>';
						}else{
							$resultData.='<img src="'.base_url('assets/img/avtr.png').'" style="width: 15px; height:15px;" >'.$cr['business_name'].'</li>';
						}

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


	public function viewcomplience()
	{
		$this->load->view('complianeticket/viewcomplience');
	}


	public function ajax()
    {
        $userid =$this->userdata['user_id'];
        $perms=explode(",",$this->userdata['upermission']);
        $datatables = new Datatables(new CodeigniterAdapter);
       
        $datatables->query('SELECT b.business_name, concat("u.firstname"," ","u.lastname"),c.country_name,m.comp_tic_message,m.comp_tic_createdate FROM complianeticket as m LEFT JOIN business as b ON m.comp_tic_business_id = b.business_id LEFT JOIN country as c ON m.comp_tic_country_id = c.supplier_id LEFT JOIN user as u ON m.comp_tic_createdby = u.user_id');
                // // edit 'id' column
        $datatables->edit('comp_tic_createdate', function ($data) {
                            
                    return  date('m/d/Y', strtotime($data['comp_tic_createdate']));
                });
       
			

        echo $datatables->generate();
    }

}