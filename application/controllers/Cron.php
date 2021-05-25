<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('generalmodel');
	}
	
	public function sendtestmail(){

		$to ="soniyakukreja091@gmail.com";
		$subject = "Test Subject ";
		$message="Test mail on 45";
		$mailresponce = $this->sendGridMail('',$to,$subject,$message);

		print_r($mailresponce); exit;
	}
	public function testview(){
		$this->load->view('include/header');
		$this->load->view('test');
		$this->load->view('include/footer');
	}

		public function fourth_month_expiery_consumer(){
				$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+4 month" ) );
	            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','4month_before_consumer');
	           
	            // $audit = $this->generalmodel->get_data_by_condition('prod_name,end_date,orders_id','audit',array('end_date'=>$expirydate));
	            $audit = $this->generalmodel->threetables('audit.prod_name,audit.businessname,audit.end_date,audit.orders_id,user.email,user.firstname','audit','orders','user','audit.orders_id=orders.orders_id','orders.createdby=user.user_id',array('audit.end_date'=>$expirydate),'');

	            foreach ($audit as $row) {
	            	$name = $row['firstname'];
	            	$product = $row['prod_name'];
	            	$expiry = date('m-d-Y',strtotime($row['end_date']));
	            	$to = $row['email'];
	            	$businessname = $row['businessname'];
	            	 // $deslink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

		            $content = $mailContent['email_body'];
		            $content = str_replace('[first_name]',$name,$content);
		            $content = str_replace('[audit_product_name]',$product,$content);
		            $content = str_replace('[audit_expiry_date]',$expiry,$content);
		            $content = str_replace('[company_name]',$businessname,$content); 

		            $subject = $mailContent['email_subject'];
		            $subject = str_replace('[company_name]',$businessname,$subject);
		            
		           echo $message = $this->load->view('include/mail_template',array('body'=>$content),true);
		            
		             $mailresponce = $this->sendGridMail('',$to,$subject,$message);

	            }
		
		}

		public function three_month_expiery_consumer(){
				$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+3 month" ) );
	            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','3month_before_consumer');
	           
	            // $audit = $this->generalmodel->get_data_by_condition('prod_name,end_date,orders_id','audit',array('end_date'=>$expirydate));
	            $audit = $this->generalmodel->threetables('audit.prod_name,audit.businessname,audit.end_date,audit.orders_id,user.email,user.firstname','audit','orders','user','audit.orders_id=orders.orders_id','orders.createdby=user.user_id',array('audit.end_date'=>$expirydate),'');

	            foreach ($audit as $row) {
	            	$name = $row['firstname'];
	            	$product = $row['prod_name'];
	            	$expiry = date('m-d-Y',strtotime($row['end_date']));
	            	$to = $row['email'];
	            	$businessname = $row['businessname'];
	            	 // $deslink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

		            $content = $mailContent['email_body'];
		            $content = str_replace('[first_name]',$name,$content);
		            $content = str_replace('[audit_product_name]',$product,$content);
		            $content = str_replace('[audit_expiry_date]',$expiry,$content);
		            $content = str_replace('[company_name]',$businessname,$content); 

		            $subject = $mailContent['email_subject'];
		            $subject = str_replace('[company_name]',$businessname,$subject);
		            
		           echo $message = $this->load->view('include/mail_template',array('body'=>$content),true);
		            
		             $mailresponce = $this->sendGridMail('',$to,$subject,$message);

	            }
		
		}
	    public function fourth_month_expiery_kams(){
				$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+4 month" ) );
	            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','4month_before');
	           
	            // $audit = $this->generalmodel->get_data_by_condition('prod_name,end_date,orders_id','audit',array('end_date'=>$expirydate));
	            $audit = $this->generalmodel->threetables('audit.prod_name,audit.businessname,audit.end_date,audit.orders_id,user.email,user.firstname,orders.lic_id','audit','orders','user','audit.orders_id=orders.orders_id','orders.createdby=user.user_id',array('audit.end_date'=>$expirydate),'');

	            foreach ($audit as $row) {
	            	$kams = $this->generalmodel->getparticularData('assign_to','licensee',array('lic_id'=>$row['lic_id']),"row_array");
	            	$user = $this->generalmodel->getparticularData('firstname,email','user',array('user_id'=>$kams['assign_to']),"row_array");
	            
	            	$name = $user['firstname'];
	            	$product = $row['prod_name'];
	            	$expiry = date('m-d-Y',strtotime($row['end_date']));
	            	$to = $user['email'];
	            	$businessname = $row['businessname'];
	            	 // $deslink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

		            $content = $mailContent['email_body'];
		            $content = str_replace('[first_name]',$name,$content);
		            $content = str_replace('[audit_product_name]',$product,$content);
		            $content = str_replace('[audit_expiry_date]',$expiry,$content);
		            $content = str_replace('[company_name]',$businessname,$content); 

		            $subject = $mailContent['email_subject'];
		            $subject = str_replace('[company_name]',$businessname,$subject);
		            
		           $message = $this->load->view('include/mail_template',array('body'=>$content),true);
		            
		             $mailresponce = $this->sendGridMail('',$to,$subject,$message);
		       }
	    }

	    public function three_month_expiery_kams(){
				$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+3 month" ) );
	            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','3month_before');
	           
	            // $audit = $this->generalmodel->get_data_by_condition('prod_name,end_date,orders_id','audit',array('end_date'=>$expirydate));
	            $audit = $this->generalmodel->threetables('audit.prod_name,audit.businessname,audit.end_date,audit.orders_id,user.email,user.firstname,orders.lic_id','audit','orders','user','audit.orders_id=orders.orders_id','orders.createdby=user.user_id',array('audit.end_date'=>$expirydate),'');

	            foreach ($audit as $row) {
	            	$kams = $this->generalmodel->getparticularData('assign_to','licensee',array('lic_id'=>$row['lic_id']),"row_array");
	            	$user = $this->generalmodel->getparticularData('firstname,email','user',array('user_id'=>$kams['assign_to']),"row_array");
	            
	            	$name = $user['firstname'];
	            	$product = $row['prod_name'];
	            	$expiry = date('m-d-Y',strtotime($row['end_date']));
	            	$to = $user['email'];
	            	$businessname = $row['businessname'];
	            	 // $deslink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

		            $content = $mailContent['email_body'];
		            $content = str_replace('[first_name]',$name,$content);
		            $content = str_replace('[audit_product_name]',$product,$content);
		            $content = str_replace('[audit_expiry_date]',$expiry,$content);
		            $content = str_replace('[company_name]',$businessname,$content); 

		            $subject = $mailContent['email_subject'];
		            $subject = str_replace('[company_name]',$businessname,$subject);
		            
		           $message = $this->load->view('include/mail_template',array('body'=>$content),true);
		            
		             $mailresponce = $this->sendGridMail('',$to,$subject,$message);
		       }
	    }

        public function fourth_month_expiery_csr(){
			$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+4 month" ) );
            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','4month_before');
           
            // $audit = $this->generalmodel->get_data_by_condition('prod_name,end_date,orders_id','audit',array('end_date'=>$expirydate));
            $audit = $this->generalmodel->threetables('audit.prod_name,audit.businessname,audit.end_date,audit.orders_id,user.email,user.firstname,orders.lic_id','audit','orders','user','audit.orders_id=orders.orders_id','orders.createdby=user.user_id',array('audit.end_date'=>$expirydate),'');

            foreach ($audit as $row) {
            	$kams = $this->generalmodel->getparticularData('assign_to','licensee',array('lic_id'=>$row['lic_id']),"row_array");
            	$csr = $this->generalmodel->getparticularData('firstname,email,user_id','user',array('user_id'=>$kams['assign_to']),"row_array");
            	$user = $this->generalmodel->getparticularData('firstname,email,user_id','user',array('assign_to'=>$csr['user_id']),"row_array");

            	$name = $user['firstname'];
            	$product = $row['prod_name'];
            	$expiry = date('m-d-Y',strtotime($row['end_date']));
            	$to = $user['email'];
            	$businessname = $row['businessname'];
            	 // $deslink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

	            $content = $mailContent['email_body'];
	            $content = str_replace('[first_name]',$name,$content);
	            $content = str_replace('[audit_product_name]',$product,$content);
	            $content = str_replace('[audit_expiry_date]',$expiry,$content);
	            $content = str_replace('[company_name]',$businessname,$content); 

	            $subject = $mailContent['email_subject'];
	            $subject = str_replace('[company_name]',$businessname,$subject);
	            
	           $message = $this->load->view('include/mail_template',array('body'=>$content),true);
	            
	             $mailresponce = $this->sendGridMail('',$to,$subject,$message);

            }
           
		}

		public function three_month_expiery_csr(){
			$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+3 month" ) );
            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','3month_before');
           
            // $audit = $this->generalmodel->get_data_by_condition('prod_name,end_date,orders_id','audit',array('end_date'=>$expirydate));
            $audit = $this->generalmodel->threetables('audit.prod_name,audit.businessname,audit.end_date,audit.orders_id,user.email,user.firstname,orders.lic_id','audit','orders','user','audit.orders_id=orders.orders_id','orders.createdby=user.user_id',array('audit.end_date'=>$expirydate),'');

            foreach ($audit as $row) {
            	$kams = $this->generalmodel->getparticularData('assign_to','licensee',array('lic_id'=>$row['lic_id']),"row_array");
            	$csr = $this->generalmodel->getparticularData('firstname,email,user_id','user',array('user_id'=>$kams['assign_to']),"row_array");
            	$user = $this->generalmodel->getparticularData('firstname,email,user_id','user',array('assign_to'=>$csr['user_id']),"row_array");
            
            	$name = $user['firstname'];
            	$product = $row['prod_name'];
            	$expiry = date('m-d-Y',strtotime($row['end_date']));
            	$to = $user['email'];
            	$businessname = $row['businessname'];
            	 // $deslink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

	            $content = $mailContent['email_body'];
	            $content = str_replace('[first_name]',$name,$content);
	            $content = str_replace('[audit_product_name]',$product,$content);
	            $content = str_replace('[audit_expiry_date]',$expiry,$content);
	            $content = str_replace('[company_name]',$businessname,$content); 

	            $subject = $mailContent['email_subject'];
	            $subject = str_replace('[company_name]',$businessname,$subject);
	            
	           $message = $this->load->view('include/mail_template',array('body'=>$content),true);
	            
	             $mailresponce = $this->sendGridMail('',$to,$subject,$message);

            }
           
		}


		public function two_month_expiery_consumer(){
				$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+2 month" ) );
	            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','2month_before_consumer');
	           
	            // $audit = $this->generalmodel->get_data_by_condition('prod_name,end_date,orders_id','audit',array('end_date'=>$expirydate));
	            $audit = $this->generalmodel->threetables('audit.prod_name,audit.businessname,audit.end_date,audit.orders_id,user.email,user.firstname','audit','orders','user','audit.orders_id=orders.orders_id','orders.createdby=user.user_id',array('audit.end_date'=>$expirydate),'');

	            foreach ($audit as $row) {
	            	$name = $row['firstname'];
	            	$product = $row['prod_name'];
	            	$expiry = date('m-d-Y',strtotime($row['end_date']));
	            	$to = $row['email'];
	            	$businessname = $row['businessname'];
	            	 // $deslink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

		            $content = $mailContent['email_body'];
		            $content = str_replace('[first_name]',$name,$content);
		            $content = str_replace('[audit_product_name]',$product,$content);
		            $content = str_replace('[audit_expiry_date]',$expiry,$content);
		            $content = str_replace('[company_name]',$businessname,$content); 

		            $subject = $mailContent['email_subject'];
		            $subject = str_replace('[company_name]',$businessname,$subject);
		            
		           echo $message = $this->load->view('include/mail_template',array('body'=>$content),true);
		            
		             $mailresponce = $this->sendGridMail('',$to,$subject,$message);

	            }
		}

		public function two_month_expiery_kams(){
				$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+2 month" ) );
	            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','2month_before');
	           
	            // $audit = $this->generalmodel->get_data_by_condition('prod_name,end_date,orders_id','audit',array('end_date'=>$expirydate));
	            $audit = $this->generalmodel->threetables('audit.prod_name,audit.businessname,audit.end_date,audit.orders_id,user.email,user.firstname,orders.lic_id','audit','orders','user','audit.orders_id=orders.orders_id','orders.createdby=user.user_id',array('audit.end_date'=>$expirydate),'');

	            foreach ($audit as $row) {
	            	$kams = $this->generalmodel->getparticularData('assign_to','licensee',array('lic_id'=>$row['lic_id']),"row_array");
	            	$user = $this->generalmodel->getparticularData('firstname,email','user',array('user_id'=>$kams['assign_to']),"row_array");
	            
	            	$name = $user['firstname'];
	            	$product = $row['prod_name'];
	            	$expiry = date('m-d-Y',strtotime($row['end_date']));
	            	$to = $user['email'];
	            	$businessname = $row['businessname'];
	            	 // $deslink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

		            $content = $mailContent['email_body'];
		            $content = str_replace('[first_name]',$name,$content);
		            $content = str_replace('[audit_product_name]',$product,$content);
		            $content = str_replace('[audit_expiry_date]',$expiry,$content);
		            $content = str_replace('[company_name]',$businessname,$content); 

		            $subject = $mailContent['email_subject'];
		            $subject = str_replace('[company_name]',$businessname,$subject);
		            
		           $message = $this->load->view('include/mail_template',array('body'=>$content),true);
		            
		             $mailresponce = $this->sendGridMail('',$to,$subject,$message);
		       }
	    }

		public function two_month_expiery_csr(){
			$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+2 month" ) );
            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','2month_before');
           
            // $audit = $this->generalmodel->get_data_by_condition('prod_name,end_date,orders_id','audit',array('end_date'=>$expirydate));
            $audit = $this->generalmodel->threetables('audit.prod_name,audit.businessname,audit.end_date,audit.orders_id,user.email,user.firstname,orders.lic_id','audit','orders','user','audit.orders_id=orders.orders_id','orders.createdby=user.user_id',array('audit.end_date'=>$expirydate),'');

            foreach ($audit as $row) {
            	$kams = $this->generalmodel->getparticularData('assign_to','licensee',array('lic_id'=>$row['lic_id']),"row_array");
            	$csr = $this->generalmodel->getparticularData('firstname,email,user_id','user',array('user_id'=>$kams['assign_to']),"row_array");
            	$user = $this->generalmodel->getparticularData('firstname,email,user_id','user',array('assign_to'=>$csr['user_id']),"row_array");
            
            	$name = $user['firstname'];
            	$product = $row['prod_name'];
            	$expiry = date('m-d-Y',strtotime($row['end_date']));
            	$to = $user['email'];
            	$businessname = $row['businessname'];
            	 // $deslink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

	            $content = $mailContent['email_body'];
	            $content = str_replace('[first_name]',$name,$content);
	            $content = str_replace('[audit_product_name]',$product,$content);
	            $content = str_replace('[audit_expiry_date]',$expiry,$content);
	            $content = str_replace('[company_name]',$businessname,$content); 

	            $subject = $mailContent['email_subject'];
	            $subject = str_replace('[company_name]',$businessname,$subject);
	            
	           $message = $this->load->view('include/mail_template',array('body'=>$content),true);
	            
	             $mailresponce = $this->sendGridMail('',$to,$subject,$message);

            }
           
		}

		public function one_month_expiery_consumer(){
				$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+1 month" ) );
	            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','1month_before_consumer');
	           
	            // $audit = $this->generalmodel->get_data_by_condition('prod_name,end_date,orders_id','audit',array('end_date'=>$expirydate));
	            $audit = $this->generalmodel->threetables('audit.prod_name,audit.businessname,audit.end_date,audit.orders_id,user.email,user.firstname','audit','orders','user','audit.orders_id=orders.orders_id','orders.createdby=user.user_id',array('audit.end_date'=>$expirydate),'');

	            foreach ($audit as $row) {
	            	$name = $row['firstname'];
	            	$product = $row['prod_name'];
	            	$expiry = date('m-d-Y',strtotime($row['end_date']));
	            	$to = $row['email'];
	            	$businessname = $row['businessname'];
	            	 // $deslink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

		            $content = $mailContent['email_body'];
		            $content = str_replace('[first_name]',$name,$content);
		            $content = str_replace('[audit_product_name]',$product,$content);
		            $content = str_replace('[audit_expiry_date]',$expiry,$content);
		            $content = str_replace('[company_name]',$businessname,$content); 

		            $subject = $mailContent['email_subject'];
		            $subject = str_replace('[company_name]',$businessname,$subject);
		            
		           echo $message = $this->load->view('include/mail_template',array('body'=>$content),true);
		            
		             $mailresponce = $this->sendGridMail('',$to,$subject,$message);

	            }
		}

		public function one_month_expiery_kams(){
				$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+1 month" ) );
	            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','1month_before');
	           
	            // $audit = $this->generalmodel->get_data_by_condition('prod_name,end_date,orders_id','audit',array('end_date'=>$expirydate));
	            $audit = $this->generalmodel->threetables('audit.prod_name,audit.businessname,audit.end_date,audit.orders_id,user.email,user.firstname,orders.lic_id','audit','orders','user','audit.orders_id=orders.orders_id','orders.createdby=user.user_id',array('audit.end_date'=>$expirydate),'');

	            foreach ($audit as $row) {
	            	$kams = $this->generalmodel->getparticularData('assign_to','licensee',array('lic_id'=>$row['lic_id']),"row_array");
	            	$user = $this->generalmodel->getparticularData('firstname,email','user',array('user_id'=>$kams['assign_to']),"row_array");
	            
	            	$name = $user['firstname'];
	            	$product = $row['prod_name'];
	            	$expiry = date('m-d-Y',strtotime($row['end_date']));
	            	$to = $user['email'];
	            	$businessname = $row['businessname'];
	            	 // $deslink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

		            $content = $mailContent['email_body'];
		            $content = str_replace('[first_name]',$name,$content);
		            $content = str_replace('[audit_product_name]',$product,$content);
		            $content = str_replace('[audit_expiry_date]',$expiry,$content);
		            $content = str_replace('[company_name]',$businessname,$content); 

		            $subject = $mailContent['email_subject'];
		            $subject = str_replace('[company_name]',$businessname,$subject);
		            
		           $message = $this->load->view('include/mail_template',array('body'=>$content),true);
		            
		             $mailresponce = $this->sendGridMail('',$to,$subject,$message);
		       }
	    }

		public function one_month_expiery_csr(){
			$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+1 month" ) );
            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','1month_before');
           
            // $audit = $this->generalmodel->get_data_by_condition('prod_name,end_date,orders_id','audit',array('end_date'=>$expirydate));
            $audit = $this->generalmodel->threetables('audit.prod_name,audit.businessname,audit.end_date,audit.orders_id,user.email,user.firstname,orders.lic_id','audit','orders','user','audit.orders_id=orders.orders_id','orders.createdby=user.user_id',array('audit.end_date'=>$expirydate),'');

            foreach ($audit as $row) {
            	$kams = $this->generalmodel->getparticularData('assign_to','licensee',array('lic_id'=>$row['lic_id']),"row_array");
            	$csr = $this->generalmodel->getparticularData('firstname,email,user_id','user',array('user_id'=>$kams['assign_to']),"row_array");
            	$user = $this->generalmodel->getparticularData('firstname,email,user_id','user',array('assign_to'=>$csr['user_id']),"row_array");
            
            	$name = $user['firstname'];
            	$product = $row['prod_name'];
            	$expiry = date('m-d-Y',strtotime($row['end_date']));
            	$to = $user['email'];
            	$businessname = $row['businessname'];
            	 // $deslink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

	            $content = $mailContent['email_body'];
	            $content = str_replace('[first_name]',$name,$content);
	            $content = str_replace('[audit_product_name]',$product,$content);
	            $content = str_replace('[audit_expiry_date]',$expiry,$content);
	            $content = str_replace('[company_name]',$businessname,$content); 

	            $subject = $mailContent['email_subject'];
	            $subject = str_replace('[company_name]',$businessname,$subject);
	            
	           $message = $this->load->view('include/mail_template',array('body'=>$content),true);
	            
	             $mailresponce = $this->sendGridMail('',$to,$subject,$message);

            }
           
		}

		public function one_month_one_week_expiry_consumer(){
				$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+1 month +1 week" ) );
	            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','1month_before_consumer');
	           
	            // $audit = $this->generalmodel->get_data_by_condition('prod_name,end_date,orders_id','audit',array('end_date'=>$expirydate));
	            $audit = $this->generalmodel->threetables('audit.prod_name,audit.businessname,audit.end_date,audit.orders_id,user.email,user.firstname','audit','orders','user','audit.orders_id=orders.orders_id','orders.createdby=user.user_id',array('audit.end_date'=>$expirydate),'');

	            foreach ($audit as $row) {
	            	$name = $row['firstname'];
	            	$product = $row['prod_name'];
	            	$expiry = date('m-d-Y',strtotime($row['end_date']));
	            	$to = $row['email'];
	            	$businessname = $row['businessname'];
	            	 // $deslink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

		            $content = $mailContent['email_body'];
		            $content = str_replace('[first_name]',$name,$content);
		            $content = str_replace('[audit_product_name]',$product,$content);
		            $content = str_replace('[audit_expiry_date]',$expiry,$content);
		            $content = str_replace('[company_name]',$businessname,$content); 

		            $subject = $mailContent['email_subject'];
		            $subject = str_replace('[company_name]',$businessname,$subject);
		            
		           echo $message = $this->load->view('include/mail_template',array('body'=>$content),true);
		            
		             $mailresponce = $this->sendGridMail('',$to,$subject,$message);

	            }
		}

		public function one_month_one_week_expiry_kams(){
				$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+1 month +1 week" ) );
	            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','1month_before');
	           
	            // $audit = $this->generalmodel->get_data_by_condition('prod_name,end_date,orders_id','audit',array('end_date'=>$expirydate));
	            $audit = $this->generalmodel->threetables('audit.prod_name,audit.businessname,audit.end_date,audit.orders_id,user.email,user.firstname,orders.lic_id','audit','orders','user','audit.orders_id=orders.orders_id','orders.createdby=user.user_id',array('audit.end_date'=>$expirydate),'');

	            foreach ($audit as $row) {
	            	$kams = $this->generalmodel->getparticularData('assign_to','licensee',array('lic_id'=>$row['lic_id']),"row_array");
	            	$user = $this->generalmodel->getparticularData('firstname,email','user',array('user_id'=>$kams['assign_to']),"row_array");
	            
	            	$name = $user['firstname'];
	            	$product = $row['prod_name'];
	            	$expiry = date('m-d-Y',strtotime($row['end_date']));
	            	$to = $user['email'];
	            	$businessname = $row['businessname'];
	            	 // $deslink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

		            $content = $mailContent['email_body'];
		            $content = str_replace('[first_name]',$name,$content);
		            $content = str_replace('[audit_product_name]',$product,$content);
		            $content = str_replace('[audit_expiry_date]',$expiry,$content);
		            $content = str_replace('[company_name]',$businessname,$content); 

		            $subject = $mailContent['email_subject'];
		            $subject = str_replace('[company_name]',$businessname,$subject);
		            
		           $message = $this->load->view('include/mail_template',array('body'=>$content),true);
		            
		             $mailresponce = $this->sendGridMail('',$to,$subject,$message);
		       }
	    }

		public function one_month_one_week_expiry_csr(){
			$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+1 month +1 week" ) );
            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','1month_before');
           
            // $audit = $this->generalmodel->get_data_by_condition('prod_name,end_date,orders_id','audit',array('end_date'=>$expirydate));
            $audit = $this->generalmodel->threetables('audit.prod_name,audit.businessname,audit.end_date,audit.orders_id,user.email,user.firstname,orders.lic_id','audit','orders','user','audit.orders_id=orders.orders_id','orders.createdby=user.user_id',array('audit.end_date'=>$expirydate),'');

            foreach ($audit as $row) {
            	$kams = $this->generalmodel->getparticularData('assign_to','licensee',array('lic_id'=>$row['lic_id']),"row_array");
            	$csr = $this->generalmodel->getparticularData('firstname,email,user_id','user',array('user_id'=>$kams['assign_to']),"row_array");
            	$user = $this->generalmodel->getparticularData('firstname,email,user_id','user',array('assign_to'=>$csr['user_id']),"row_array");
            
            	$name = $user['firstname'];
            	$product = $row['prod_name'];
            	$expiry = date('m-d-Y',strtotime($row['end_date']));
            	$to = $user['email'];
            	$businessname = $row['businessname'];
            	 // $deslink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

	            $content = $mailContent['email_body'];
	            $content = str_replace('[first_name]',$name,$content);
	            $content = str_replace('[audit_product_name]',$product,$content);
	            $content = str_replace('[audit_expiry_date]',$expiry,$content);
	            $content = str_replace('[company_name]',$businessname,$content); 

	            $subject = $mailContent['email_subject'];
	            $subject = str_replace('[company_name]',$businessname,$subject);
	            
	           $message = $this->load->view('include/mail_template',array('body'=>$content),true);
	            
	             $mailresponce = $this->sendGridMail('',$to,$subject,$message);

            }
           
		}

		public function one_month_one_day_expiry_consumer(){
				$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+1 month +1 day" ) );
	            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','1month_before_consumer');
	           
	            // $audit = $this->generalmodel->get_data_by_condition('prod_name,end_date,orders_id','audit',array('end_date'=>$expirydate));
	            $audit = $this->generalmodel->threetables('audit.prod_name,audit.businessname,audit.end_date,audit.orders_id,user.email,user.firstname','audit','orders','user','audit.orders_id=orders.orders_id','orders.createdby=user.user_id',array('audit.end_date'=>$expirydate),'');

	            foreach ($audit as $row) {
	            	$name = $row['firstname'];
	            	$product = $row['prod_name'];
	            	$expiry = date('m-d-Y',strtotime($row['end_date']));
	            	$to = $row['email'];
	            	$businessname = $row['businessname'];
	            	 // $deslink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

		            $content = $mailContent['email_body'];
		            $content = str_replace('[first_name]',$name,$content);
		            $content = str_replace('[audit_product_name]',$product,$content);
		            $content = str_replace('[audit_expiry_date]',$expiry,$content);
		            $content = str_replace('[company_name]',$businessname,$content); 

		            $subject = $mailContent['email_subject'];
		            $subject = str_replace('[company_name]',$businessname,$subject);
		            
		           echo $message = $this->load->view('include/mail_template',array('body'=>$content),true);
		            
		             $mailresponce = $this->sendGridMail('',$to,$subject,$message);

	            }
		}

		public function one_month_one_day_expiry_kams(){
				$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+1 month +1 day" ) );
	            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','1month_before');
	           
	            // $audit = $this->generalmodel->get_data_by_condition('prod_name,end_date,orders_id','audit',array('end_date'=>$expirydate));
	            $audit = $this->generalmodel->threetables('audit.prod_name,audit.businessname,audit.end_date,audit.orders_id,user.email,user.firstname,orders.lic_id','audit','orders','user','audit.orders_id=orders.orders_id','orders.createdby=user.user_id',array('audit.end_date'=>$expirydate),'');

	            foreach ($audit as $row) {
	            	$kams = $this->generalmodel->getparticularData('assign_to','licensee',array('lic_id'=>$row['lic_id']),"row_array");
	            	$user = $this->generalmodel->getparticularData('firstname,email','user',array('user_id'=>$kams['assign_to']),"row_array");
	            
	            	$name = $user['firstname'];
	            	$product = $row['prod_name'];
	            	$expiry = date('m-d-Y',strtotime($row['end_date']));
	            	$to = $user['email'];
	            	$businessname = $row['businessname'];
	            	 // $deslink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

		            $content = $mailContent['email_body'];
		            $content = str_replace('[first_name]',$name,$content);
		            $content = str_replace('[audit_product_name]',$product,$content);
		            $content = str_replace('[audit_expiry_date]',$expiry,$content);
		            $content = str_replace('[company_name]',$businessname,$content); 

		            $subject = $mailContent['email_subject'];
		            $subject = str_replace('[company_name]',$businessname,$subject);
		            
		           $message = $this->load->view('include/mail_template',array('body'=>$content),true);
		            
		             $mailresponce = $this->sendGridMail('',$to,$subject,$message);
		       }
	    }

		public function one_month_one_day_expiry_csr(){
			$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+1 month +1 day" ) );
            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','1month_before');
           
            // $audit = $this->generalmodel->get_data_by_condition('prod_name,end_date,orders_id','audit',array('end_date'=>$expirydate));
            $audit = $this->generalmodel->threetables('audit.prod_name,audit.businessname,audit.end_date,audit.orders_id,user.email,user.firstname,orders.lic_id','audit','orders','user','audit.orders_id=orders.orders_id','orders.createdby=user.user_id',array('audit.end_date'=>$expirydate),'');

            foreach ($audit as $row) {
            	$kams = $this->generalmodel->getparticularData('assign_to','licensee',array('lic_id'=>$row['lic_id']),"row_array");
            	$csr = $this->generalmodel->getparticularData('firstname,email,user_id','user',array('user_id'=>$kams['assign_to']),"row_array");
            	$user = $this->generalmodel->getparticularData('firstname,email,user_id','user',array('assign_to'=>$csr['user_id']),"row_array");
            
            	$name = $user['firstname'];
            	$product = $row['prod_name'];
            	$expiry = date('m-d-Y',strtotime($row['end_date']));
            	$to = $user['email'];
            	$businessname = $row['businessname'];
            	 // $deslink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

	            $content = $mailContent['email_body'];
	            $content = str_replace('[first_name]',$name,$content);
	            $content = str_replace('[audit_product_name]',$product,$content);
	            $content = str_replace('[audit_expiry_date]',$expiry,$content);
	            $content = str_replace('[company_name]',$businessname,$content); 

	            $subject = $mailContent['email_subject'];
	            $subject = str_replace('[company_name]',$businessname,$subject);
	            
	           $message = $this->load->view('include/mail_template',array('body'=>$content),true);
	            
	             $mailresponce = $this->sendGridMail('',$to,$subject,$message);

            }
           
		}

		// public function one_week_mbr_kms(){
		// 		$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+1 week " ) );
	 //            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','1week_before_date_mbr');
	           
	 //            // $audit = $this->generalmodel->get_data_by_condition('prod_name,end_date,orders_id','audit',array('end_date'=>$expirydate));
	 //            $audit = $this->generalmodel->threetables('audit.prod_name,audit.businessname,audit.end_date,audit.orders_id,user.email,user.firstname','audit','orders','user','audit.orders_id=orders.orders_id','orders.createdby=user.user_id',array('audit.end_date'=>$expirydate),'');
	 //            $audit = $this->generalmodel->getJoinData('licbusinessreview.lic_id,licbusinessreview.busrev_duedate','licbusinessreview','licensee','licbusinessreview.lic_id=licensee.lic_id',array('licbusinessreview.busrev_duedate'=>$expirydate));

	 //            foreach ($audit as $row) {
	 //            	$name = $row['firstname'];
	 //            	$product = $row['prod_name'];
	 //            	$expiry = date('m-d-Y',strtotime($row['end_date']));
	 //            	$to = $row['email'];
	 //            	$businessname = $row['businessname'];
	 //            	 // $deslink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

		//             $content = $mailContent['email_body'];
		//             $content = str_replace('[first_name]',$name,$content);
		//             $content = str_replace('[audit_product_name]',$product,$content);
		//             $content = str_replace('[audit_expiry_date]',$expiry,$content);
		//             $content = str_replace('[company_name]',$businessname,$content); 

		//             $subject = $mailContent['email_subject'];
		//             $subject = str_replace('[company_name]',$businessname,$subject);
		            
		//            echo $message = $this->load->view('include/mail_template',array('body'=>$content),true);
		            
		//              $mailresponce = $this->sendGridMail('',$to,$subject,$message);

	 //            }
		// }
		/************************ MBR **************************************/
		public function one_week_mbr_kams(){
				$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+1 week " ) );

	            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','1week_before_date_mbr');
	           
	            $mbr = $this->generalmodel->get_data_by_condition('busrev_id,lic_id,busrev_duedate','licbusinessreview',array('busrev_duedate'=>$expirydate,'busrev_type'=>'MBR'));
	           
	            foreach ($mbr as $row) {
	            	$kams = $this->generalmodel->getparticularData('assign_to,user_id,business_name','licensee',array('lic_id'=>$row['lic_id']),"row_array"); 
	            	$lic = $this->generalmodel->getparticularData('firstname,lastname,email,contactno','user',array('user_id'=>$kams['user_id']),"row_array");
	            	$user = $this->generalmodel->getparticularData('firstname,email','user',array('user_id'=>$kams['assign_to']),"row_array");
	            
	            	$name = $user['firstname'];
	            	$username = $lic['firstname'].' '.$lic['lastname'];
	            	$duedate = date('m-d-Y',strtotime($row['busrev_duedate']));
	            	$to = $user['email'];
	            	$contactno = $lic['contactno'];
	            	$email = $lic['email'];
	            	$businessname = $kams['business_name'];
	            	 // $deslink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

		            $content = $mailContent['email_body'];
		            $content = str_replace('[name]',$name,$content);
		            $content = str_replace('[user_name]',$username,$content);
		            $content = str_replace('[duedate]',$duedate,$content);
		            $content = str_replace('[contactno]',$contactno,$content);
		            $content = str_replace('[email]',$email,$content);
		            $content = str_replace('[company_name]',$businessname,$content); 

		            $subject = $mailContent['email_subject'];
		            $subject = str_replace('[company_name]',$businessname,$subject);
		            $subject = str_replace('[duedate]',$duedate,$subject);
		            
		            $message = $this->load->view('include/mail_template',array('body'=>$content),true);
		            
		             $mailresponce = $this->sendGridMail('',$to,$subject,$message);
		       }
	    }

		public function one_week_mbr_csr(){
			$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+1 week " ) );

	            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','1week_before_date_mbr');
	           
	            $mbr = $this->generalmodel->get_data_by_condition('busrev_id,lic_id,busrev_duedate','licbusinessreview',array('busrev_duedate'=>$expirydate,'busrev_type'=>'MBR'));
	           
	            foreach ($mbr as $row) {
	            	$kams = $this->generalmodel->getparticularData('assign_to,user_id,business_name','licensee',array('lic_id'=>$row['lic_id']),"row_array"); 
	            	$lic = $this->generalmodel->getparticularData('firstname,lastname,email,contactno','user',array('user_id'=>$kams['user_id']),"row_array");
	            	$csr = $this->generalmodel->getparticularData('firstname,email,user_id','user',array('user_id'=>$kams['assign_to']),"row_array");
	            	$user = $this->generalmodel->getparticularData('firstname,email,user_id','user',array('assign_to'=>$csr['user_id']),"row_array");
	            
	            	$name = $user['firstname'];
	            	$username = $lic['firstname'].' '.$lic['lastname'];
	            	$duedate = date('m-d-Y',strtotime($row['busrev_duedate']));
	            	$to = $user['email'];
	            	$contactno = $lic['contactno'];
	            	$email = $lic['email'];
	            	$businessname = $kams['business_name'];
	            	 // $deslink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

		            $content = $mailContent['email_body'];
		            $content = str_replace('[name]',$name,$content);
		            $content = str_replace('[user_name]',$username,$content);
		            $content = str_replace('[duedate]',$duedate,$content);
		            $content = str_replace('[contactno]',$contactno,$content);
		            $content = str_replace('[email]',$email,$content);
		            $content = str_replace('[company_name]',$businessname,$content); 

		            $subject = $mailContent['email_subject'];
		            $subject = str_replace('[company_name]',$businessname,$subject);
		            $subject = str_replace('[duedate]',$duedate,$subject);
		            
		           $message = $this->load->view('include/mail_template',array('body'=>$content),true);
		            
		             $mailresponce = $this->sendGridMail('',$to,$subject,$message);
		       }
           
		}

		public function one_week_ia_mbr_kams(){
				$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+1 week " ) );

	            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','1week_before_date_mbr');
	           
	            $mbr = $this->generalmodel->get_data_by_condition('busrev_id,ia_id,busrev_duedate','iabusinessreview',array('busrev_duedate'=>$expirydate,'busrev_type'=>'MBR'));
	           
	            foreach ($mbr as $row) {
	            	$kams = $this->generalmodel->getparticularData('assign_to,user_id,business_name','indassociation',array('ia_id'=>$row['ia_id']),"row_array"); 
	            	$lic = $this->generalmodel->getparticularData('firstname,lastname,email,contactno','user',array('user_id'=>$kams['user_id']),"row_array");
	            	$user = $this->generalmodel->getparticularData('firstname,email','user',array('user_id'=>$kams['assign_to']),"row_array");
	            
	            	$name = $user['firstname'];
	            	$username = $lic['firstname'].' '.$lic['lastname'];
	            	$duedate = date('m-d-Y',strtotime($row['busrev_duedate']));
	            	$to = $user['email'];
	            	$contactno = $lic['contactno'];
	            	$email = $lic['email'];
	            	$businessname = $kams['business_name'];
	            	 // $deslink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

		            $content = $mailContent['email_body'];
		            $content = str_replace('[name]',$name,$content);
		            $content = str_replace('[user_name]',$username,$content);
		            $content = str_replace('[duedate]',$duedate,$content);
		            $content = str_replace('[contactno]',$contactno,$content);
		            $content = str_replace('[company_name]',$businessname,$content); 
		            $content = str_replace('[email]',$email,$content);
		            $subject = $mailContent['email_subject'];
		            $subject = str_replace('[company_name]',$businessname,$subject);
		            $subject = str_replace('[duedate]',$duedate,$subject);
		            
		           $message = $this->load->view('include/mail_template',array('body'=>$content),true);
		            
		             $mailresponce = $this->sendGridMail('',$to,$subject,$message);
		       }
	    }

		public function one_week_ia_mbr_csr(){
			$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+1 week " ) );

	            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','1week_before_date_mbr');
	           
	            $mbr = $this->generalmodel->get_data_by_condition('busrev_id,ia_id,busrev_duedate','iabusinessreview',array('busrev_duedate'=>$expirydate,'busrev_type'=>'MBR'));
	           
	            foreach ($mbr as $row) {
	            	$kams = $this->generalmodel->getparticularData('assign_to,user_id,business_name','indassociation',array('ia_id'=>$row['ia_id']),"row_array"); 
	            	$lic = $this->generalmodel->getparticularData('firstname,lastname,email,contactno','user',array('user_id'=>$kams['user_id']),"row_array");
	            	$csr = $this->generalmodel->getparticularData('firstname,email,user_id','user',array('user_id'=>$kams['assign_to']),"row_array");
	            	$user = $this->generalmodel->getparticularData('firstname,email,user_id','user',array('assign_to'=>$csr['user_id']),"row_array");
	            
	            	$name = $user['firstname'];
	            	$username = $lic['firstname'].' '.$lic['lastname'];
	            	$duedate = date('m-d-Y',strtotime($row['busrev_duedate']));
	            	$to = $user['email'];
	            	$contactno = $lic['contactno'];
	            	$email = $lic['email'];
	            	$businessname = $kams['business_name'];
	            	 // $deslink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

		            $content = $mailContent['email_body'];
		            $content = str_replace('[name]',$name,$content);
		            $content = str_replace('[user_name]',$username,$content);
		            $content = str_replace('[duedate]',$duedate,$content);
		            $content = str_replace('[contactno]',$contactno,$content);
		            $content = str_replace('[email]',$email,$content);
		            $content = str_replace('[company_name]',$businessname,$content); 

		            $subject = $mailContent['email_subject'];
		            $subject = str_replace('[company_name]',$businessname,$subject);
		            $subject = str_replace('[duedate]',$duedate,$subject);
		            
		           $message = $this->load->view('include/mail_template',array('body'=>$content),true);
		            
		             $mailresponce = $this->sendGridMail('',$to,$subject,$message);
		       }
           
		}
		/*****************************************************************************************/

		/************************ QBR  **************************************/
		public function one_week_qbr_kams(){
				$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+1 week " ) );

	            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','1week_before_qbr');
	           
	            $mbr = $this->generalmodel->get_data_by_condition('busrev_id,lic_id,busrev_duedate','licbusinessreview',array('busrev_duedate'=>$expirydate,'busrev_type'=>'QBR'));
	           
	            foreach ($mbr as $row) {
	            	$kams = $this->generalmodel->getparticularData('assign_to,user_id,business_name','licensee',array('lic_id'=>$row['lic_id']),"row_array"); 
	            	$lic = $this->generalmodel->getparticularData('firstname,lastname,email,contactno','user',array('user_id'=>$kams['user_id']),"row_array");
	            	$user = $this->generalmodel->getparticularData('firstname,email','user',array('user_id'=>$kams['assign_to']),"row_array");
	            
	            	$name = $user['firstname'];
	            	$username = $lic['firstname'].' '.$lic['lastname'];
	            	$duedate = date('m-d-Y',strtotime($row['busrev_duedate']));
	            	$to = $user['email'];
	            	$contactno = $lic['contactno'];
	            	$email = $lic['email'];
	            	$businessname = $kams['business_name'];
	            	 // $deslink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

		            $content = $mailContent['email_body'];
		            $content = str_replace('[name]',$name,$content);
		            $content = str_replace('[user_name]',$username,$content);
		            $content = str_replace('[duedate]',$duedate,$content);
		            $content = str_replace('[contactno]',$contactno,$content);
		            $content = str_replace('[email]',$email,$content);
		            $content = str_replace('[company_name]',$businessname,$content); 

		            $subject = $mailContent['email_subject'];
		            $subject = str_replace('[company_name]',$businessname,$subject);
		            $subject = str_replace('[duedate]',$duedate,$subject);
		            
		           $message = $this->load->view('include/mail_template',array('body'=>$content),true);
		            
		             $mailresponce = $this->sendGridMail('',$to,$subject,$message);
		       }
	    }

		public function one_week_qbr_csr(){
			$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+1 week " ) );

	            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','1week_before_qbr');
	           
	            $mbr = $this->generalmodel->get_data_by_condition('busrev_id,lic_id,busrev_duedate','licbusinessreview',array('busrev_duedate'=>$expirydate,'busrev_type'=>'QBR'));
	           
	            foreach ($mbr as $row) {
	            	$kams = $this->generalmodel->getparticularData('assign_to,user_id,business_name','licensee',array('lic_id'=>$row['lic_id']),"row_array"); 
	            	$lic = $this->generalmodel->getparticularData('firstname,lastname,email,contactno','user',array('user_id'=>$kams['user_id']),"row_array");
	            	$csr = $this->generalmodel->getparticularData('firstname,email,user_id','user',array('user_id'=>$kams['assign_to']),"row_array");
	            	$user = $this->generalmodel->getparticularData('firstname,email,user_id','user',array('assign_to'=>$csr['user_id']),"row_array");
	            
	            	$name = $user['firstname'];
	            	$username = $lic['firstname'].' '.$lic['lastname'];
	            	$duedate = date('m-d-Y',strtotime($row['busrev_duedate']));
	            	$to = $user['email'];
	            	$contactno = $lic['contactno'];
	            	$email = $lic['email'];
	            	$businessname = $kams['business_name'];
	            	 // $deslink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

		            $content = $mailContent['email_body'];
		            $content = str_replace('[name]',$name,$content);
		            $content = str_replace('[user_name]',$username,$content);
		            $content = str_replace('[duedate]',$duedate,$content);
		            $content = str_replace('[contactno]',$contactno,$content);
		            $content = str_replace('[email]',$email,$content);
		            $content = str_replace('[company_name]',$businessname,$content); 

		            $subject = $mailContent['email_subject'];
		            $subject = str_replace('[company_name]',$businessname,$subject);
		            $subject = str_replace('[duedate]',$duedate,$subject);
		            
		           $message = $this->load->view('include/mail_template',array('body'=>$content),true);
		            
		             $mailresponce = $this->sendGridMail('',$to,$subject,$message);
		       }
           
		}

		public function one_month_qbr_kams(){
				$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+1 month " ) );

	            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','1months_before_qbr');
	           
	            $mbr = $this->generalmodel->get_data_by_condition('busrev_id,lic_id,busrev_duedate','licbusinessreview',array('busrev_duedate'=>$expirydate,'busrev_type'=>'QBR'));
	           
	            foreach ($mbr as $row) {
	            	$kams = $this->generalmodel->getparticularData('assign_to,user_id,business_name','licensee',array('lic_id'=>$row['lic_id']),"row_array"); 
	            	$lic = $this->generalmodel->getparticularData('firstname,lastname,email,contactno','user',array('user_id'=>$kams['user_id']),"row_array");
	            	$user = $this->generalmodel->getparticularData('firstname,email','user',array('user_id'=>$kams['assign_to']),"row_array");
	            
	            	$name = $user['firstname'];
	            	$username = $lic['firstname'].' '.$lic['lastname'];
	            	$duedate = date('m-d-Y',strtotime($row['busrev_duedate']));
	            	$to = $user['email'];
	            	$contactno = $lic['contactno'];
	            	$email = $lic['email'];
	            	$businessname = $kams['business_name'];
	            	 // $deslink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

		            $content = $mailContent['email_body'];
		            $content = str_replace('[name]',$name,$content);
		            $content = str_replace('[user_name]',$username,$content);
		            $content = str_replace('[duedate]',$duedate,$content);
		            $content = str_replace('[contactno]',$contactno,$content);
		            $content = str_replace('[email]',$email,$content);
		            $content = str_replace('[company_name]',$businessname,$content); 

		            $subject = $mailContent['email_subject'];
		            $subject = str_replace('[company_name]',$businessname,$subject);
		            $subject = str_replace('[duedate]',$duedate,$subject);
		            
		           $message = $this->load->view('include/mail_template',array('body'=>$content),true);
		            
		             $mailresponce = $this->sendGridMail('',$to,$subject,$message);
		       }
	    }

		public function one_month_qbr_csr(){
			$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+1 month " ) );

	            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','1months_before_qbr');
	           
	            $mbr = $this->generalmodel->get_data_by_condition('busrev_id,lic_id,busrev_duedate','licbusinessreview',array('busrev_duedate'=>$expirydate,'busrev_type'=>'QBR'));
	           
	            foreach ($mbr as $row) {
	            	$kams = $this->generalmodel->getparticularData('assign_to,user_id,business_name','licensee',array('lic_id'=>$row['lic_id']),"row_array"); 
	            	$lic = $this->generalmodel->getparticularData('firstname,lastname,email,contactno','user',array('user_id'=>$kams['user_id']),"row_array");
	            	$csr = $this->generalmodel->getparticularData('firstname,email,user_id','user',array('user_id'=>$kams['assign_to']),"row_array");
	            	$user = $this->generalmodel->getparticularData('firstname,email,user_id','user',array('assign_to'=>$csr['user_id']),"row_array");
	            
	            	$name = $user['firstname'];
	            	$username = $lic['firstname'].' '.$lic['lastname'];
	            	$duedate = date('m-d-Y',strtotime($row['busrev_duedate']));
	            	$to = $user['email'];
	            	$contactno = $lic['contactno'];
	            	$email = $lic['email'];
	            	$businessname = $kams['business_name'];
	            	 // $deslink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

		            $content = $mailContent['email_body'];
		            $content = str_replace('[name]',$name,$content);
		            $content = str_replace('[user_name]',$username,$content);
		            $content = str_replace('[duedate]',$duedate,$content);
		            $content = str_replace('[contactno]',$contactno,$content);
		            $content = str_replace('[email]',$email,$content);
		            $content = str_replace('[company_name]',$businessname,$content); 

		            $subject = $mailContent['email_subject'];
		            $subject = str_replace('[company_name]',$businessname,$subject);
		            $subject = str_replace('[duedate]',$duedate,$subject);
		            
		           $message = $this->load->view('include/mail_template',array('body'=>$content),true);
		            
		             $mailresponce = $this->sendGridMail('',$to,$subject,$message);
		       }
           
		}

		public function two_month_qbr_kams(){
				$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+1 month " ) );

	            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','2months_before_qbr');
	           
	            $mbr = $this->generalmodel->get_data_by_condition('busrev_id,lic_id,busrev_duedate','licbusinessreview',array('busrev_duedate'=>$expirydate,'busrev_type'=>'QBR'));
	           
	            foreach ($mbr as $row) {
	            	$kams = $this->generalmodel->getparticularData('assign_to,user_id,business_name','licensee',array('lic_id'=>$row['lic_id']),"row_array"); 
	            	$lic = $this->generalmodel->getparticularData('firstname,lastname,email,contactno','user',array('user_id'=>$kams['user_id']),"row_array");
	            	$user = $this->generalmodel->getparticularData('firstname,email','user',array('user_id'=>$kams['assign_to']),"row_array");
	            
	            	$name = $user['firstname'];
	            	$username = $lic['firstname'].' '.$lic['lastname'];
	            	$duedate = date('m-d-Y',strtotime($row['busrev_duedate']));
	            	$to = $user['email'];
	            	$contactno = $lic['contactno'];
	            	$email = $lic['email'];
	            	$businessname = $kams['business_name'];
	            	 // $deslink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

		            $content = $mailContent['email_body'];
		            $content = str_replace('[name]',$name,$content);
		            $content = str_replace('[user_name]',$username,$content);
		            $content = str_replace('[duedate]',$duedate,$content);
		            $content = str_replace('[contactno]',$contactno,$content);
		            $content = str_replace('[email]',$email,$content);
		            $content = str_replace('[company_name]',$businessname,$content); 

		            $subject = $mailContent['email_subject'];
		            $subject = str_replace('[company_name]',$businessname,$subject);
		            $subject = str_replace('[duedate]',$duedate,$subject);
		            
		           $message = $this->load->view('include/mail_template',array('body'=>$content),true);
		            
		             $mailresponce = $this->sendGridMail('',$to,$subject,$message);
		       }
	    }

		public function two_month_qbr_csr(){
			$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+1 month " ) );

	            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','2months_before_qbr');
	           
	            $mbr = $this->generalmodel->get_data_by_condition('busrev_id,lic_id,busrev_duedate','licbusinessreview',array('busrev_duedate'=>$expirydate,'busrev_type'=>'QBR'));
	           
	            foreach ($mbr as $row) {
	            	$kams = $this->generalmodel->getparticularData('assign_to,user_id,business_name','licensee',array('lic_id'=>$row['lic_id']),"row_array"); 
	            	$lic = $this->generalmodel->getparticularData('firstname,lastname,email,contactno','user',array('user_id'=>$kams['user_id']),"row_array");
	            	$csr = $this->generalmodel->getparticularData('firstname,email,user_id','user',array('user_id'=>$kams['assign_to']),"row_array");
	            	$user = $this->generalmodel->getparticularData('firstname,email,user_id','user',array('assign_to'=>$csr['user_id']),"row_array");
	            
	            	$name = $user['firstname'];
	            	$username = $lic['firstname'].' '.$lic['lastname'];
	            	$duedate = date('m-d-Y',strtotime($row['busrev_duedate']));
	            	$to = $user['email'];
	            	$contactno = $lic['contactno'];
	            	$email = $lic['email'];
	            	$businessname = $kams['business_name'];
	            	 // $deslink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

		            $content = $mailContent['email_body'];
		            $content = str_replace('[name]',$name,$content);
		            $content = str_replace('[user_name]',$username,$content);
		            $content = str_replace('[duedate]',$duedate,$content);
		            $content = str_replace('[contactno]',$contactno,$content);
		            $content = str_replace('[email]',$email,$content);
		            $content = str_replace('[company_name]',$businessname,$content); 

		            $subject = $mailContent['email_subject'];
		            $subject = str_replace('[company_name]',$businessname,$subject);
		            $subject = str_replace('[duedate]',$duedate,$subject);
		            
		           $message = $this->load->view('include/mail_template',array('body'=>$content),true);
		            
		             $mailresponce = $this->sendGridMail('',$to,$subject,$message);
		       }
           
		}

		public function one_week_ia_qbr_kams(){
				$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+1 week " ) );

	            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','1week_before_qbr');
	           
	            $mbr = $this->generalmodel->get_data_by_condition('busrev_id,ia_id,busrev_duedate','iabusinessreview',array('busrev_duedate'=>$expirydate,'busrev_type'=>'QBR'));
	           
	            foreach ($mbr as $row) {
	            	$kams = $this->generalmodel->getparticularData('assign_to,user_id,business_name','indassociation',array('ia_id'=>$row['ia_id']),"row_array");  
	            	$lic = $this->generalmodel->getparticularData('firstname,lastname,email,contactno','user',array('user_id'=>$kams['user_id']),"row_array");
	            	$user = $this->generalmodel->getparticularData('firstname,email','user',array('user_id'=>$kams['assign_to']),"row_array");
	            
	            	$name = $user['firstname'];
	            	$username = $lic['firstname'].' '.$lic['lastname'];
	            	$duedate = date('m-d-Y',strtotime($row['busrev_duedate']));
	            	$to = $user['email'];
	            	$contactno = $lic['contactno'];
	            	$email = $lic['email'];
	            	$businessname = $kams['business_name'];
	            	 // $deslink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

		            $content = $mailContent['email_body'];
		            $content = str_replace('[name]',$name,$content);
		            $content = str_replace('[user_name]',$username,$content);
		            $content = str_replace('[duedate]',$duedate,$content);
		            $content = str_replace('[contactno]',$contactno,$content);
		            $content = str_replace('[email]',$email,$content);
		            $content = str_replace('[company_name]',$businessname,$content); 

		            $subject = $mailContent['email_subject'];
		            $subject = str_replace('[company_name]',$businessname,$subject);
		            $subject = str_replace('[duedate]',$duedate,$subject);
		            
		           $message = $this->load->view('include/mail_template',array('body'=>$content),true);
		            
		             $mailresponce = $this->sendGridMail('',$to,$subject,$message);
		       }
	    }

		public function one_week_ia_qbr_csr(){
			$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+1 week " ) );

	            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','1week_before_qbr');
	           
	            $mbr = $this->generalmodel->get_data_by_condition('busrev_id,ia_id,busrev_duedate','iabusinessreview',array('busrev_duedate'=>$expirydate,'busrev_type'=>'QBR'));
	           
	            foreach ($mbr as $row) {
	            	$kams = $this->generalmodel->getparticularData('assign_to,user_id,business_name','indassociation',array('ia_id'=>$row['ia_id']),"row_array");  
	            	$lic = $this->generalmodel->getparticularData('firstname,lastname,email,contactno','user',array('user_id'=>$kams['user_id']),"row_array");
	            	$csr = $this->generalmodel->getparticularData('firstname,email,user_id','user',array('user_id'=>$kams['assign_to']),"row_array");
	            	$user = $this->generalmodel->getparticularData('firstname,email,user_id','user',array('assign_to'=>$csr['user_id']),"row_array");
	            
	            	$name = $user['firstname'];
	            	$username = $lic['firstname'].' '.$lic['lastname'];
	            	$duedate = date('m-d-Y',strtotime($row['busrev_duedate']));
	            	$to = $user['email'];
	            	$contactno = $lic['contactno'];
	            	$email = $lic['email'];
	            	$businessname = $kams['business_name'];
	            	 // $deslink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

		            $content = $mailContent['email_body'];
		            $content = str_replace('[name]',$name,$content);
		            $content = str_replace('[user_name]',$username,$content);
		            $content = str_replace('[duedate]',$duedate,$content);
		            $content = str_replace('[contactno]',$contactno,$content);
		            $content = str_replace('[email]',$email,$content);
		            $content = str_replace('[company_name]',$businessname,$content); 

		            $subject = $mailContent['email_subject'];
		            $subject = str_replace('[company_name]',$businessname,$subject);
		            $subject = str_replace('[duedate]',$duedate,$subject);
		            
		           $message = $this->load->view('include/mail_template',array('body'=>$content),true);
		            
		             $mailresponce = $this->sendGridMail('',$to,$subject,$message);
		       }
           
		}

		public function one_month_ia_qbr_kams(){
				$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+1 month " ) );

	            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','1months_before_qbr');
	           
	            $mbr = $this->generalmodel->get_data_by_condition('busrev_id,ia_id,busrev_duedate','iabusinessreview',array('busrev_duedate'=>$expirydate,'busrev_type'=>'QBR'));
	           
	            foreach ($mbr as $row) {
	            	$kams = $this->generalmodel->getparticularData('assign_to,user_id,business_name','indassociation',array('ia_id'=>$row['ia_id']),"row_array"); 
	            	$lic = $this->generalmodel->getparticularData('firstname,lastname,email,contactno','user',array('user_id'=>$kams['user_id']),"row_array");
	            	$user = $this->generalmodel->getparticularData('firstname,email','user',array('user_id'=>$kams['assign_to']),"row_array");
	            
	            	$name = $user['firstname'];
	            	$username = $lic['firstname'].' '.$lic['lastname'];
	            	$duedate = date('m-d-Y',strtotime($row['busrev_duedate']));
	            	$to = $user['email'];
	            	$contactno = $lic['contactno'];
	            	$email = $lic['email'];
	            	$businessname = $kams['business_name'];
	            	 // $deslink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

		            $content = $mailContent['email_body'];
		            $content = str_replace('[name]',$name,$content);
		            $content = str_replace('[user_name]',$username,$content);
		            $content = str_replace('[duedate]',$duedate,$content);
		            $content = str_replace('[email]',$email,$content);
		            $content = str_replace('[contactno]',$contactno,$content);
		            $content = str_replace('[company_name]',$businessname,$content); 

		            $subject = $mailContent['email_subject'];
		            $subject = str_replace('[company_name]',$businessname,$subject);
		            $subject = str_replace('[duedate]',$duedate,$subject);
		            
		           $message = $this->load->view('include/mail_template',array('body'=>$content),true);
		            
		             $mailresponce = $this->sendGridMail('',$to,$subject,$message);
		       }
	    }

		public function one_month_ia_qbr_csr(){
			$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+1 month " ) );

	            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','1months_before_qbr');
	           
	            $mbr = $this->generalmodel->get_data_by_condition('busrev_id,ia_id,busrev_duedate','iabusinessreview',array('busrev_duedate'=>$expirydate,'busrev_type'=>'QBR'));
	           
	            foreach ($mbr as $row) {
	            	$kams = $this->generalmodel->getparticularData('assign_to,user_id,business_name','indassociation',array('ia_id'=>$row['ia_id']),"row_array"); 
	            	$lic = $this->generalmodel->getparticularData('firstname,lastname,email,contactno','user',array('user_id'=>$kams['user_id']),"row_array");
	            	$csr = $this->generalmodel->getparticularData('firstname,email,user_id','user',array('user_id'=>$kams['assign_to']),"row_array");
	            	$user = $this->generalmodel->getparticularData('firstname,email,user_id','user',array('assign_to'=>$csr['user_id']),"row_array");
	            
	            	$name = $user['firstname'];
	            	$username = $lic['firstname'].' '.$lic['lastname'];
	            	$duedate = date('m-d-Y',strtotime($row['busrev_duedate']));
	            	$to = $user['email'];
	            	$contactno = $lic['contactno'];
	            	$email = $lic['email'];
	            	$businessname = $kams['business_name'];
	            	 // $deslink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

		            $content = $mailContent['email_body'];
		            $content = str_replace('[name]',$name,$content);
		            $content = str_replace('[user_name]',$username,$content);
		            $content = str_replace('[duedate]',$duedate,$content);
		            $content = str_replace('[contactno]',$contactno,$content);
		            $content = str_replace('[email]',$email,$content);
		            $content = str_replace('[company_name]',$businessname,$content); 

		            $subject = $mailContent['email_subject'];
		            $subject = str_replace('[company_name]',$businessname,$subject);
		            $subject = str_replace('[duedate]',$duedate,$subject);
		            
		           $message = $this->load->view('include/mail_template',array('body'=>$content),true);
		            
		             $mailresponce = $this->sendGridMail('',$to,$subject,$message);
		       }
           
		}

		public function two_month_ia_qbr_kams(){
				$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+1 month " ) );

	            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','2months_before_qbr');
	           
	            $mbr = $this->generalmodel->get_data_by_condition('busrev_id,ia_id,busrev_duedate','iabusinessreview',array('busrev_duedate'=>$expirydate,'busrev_type'=>'QBR'));
	           
	            foreach ($mbr as $row) {
	            	$kams = $this->generalmodel->getparticularData('assign_to,user_id,business_name','indassociation',array('ia_id'=>$row['ia_id']),"row_array");  
	            	$lic = $this->generalmodel->getparticularData('firstname,lastname,email,contactno','user',array('user_id'=>$kams['user_id']),"row_array");
	            	$user = $this->generalmodel->getparticularData('firstname,email','user',array('user_id'=>$kams['assign_to']),"row_array");
	            
	            	$name = $user['firstname'];
	            	$username = $lic['firstname'].' '.$lic['lastname'];
	            	$duedate = date('m-d-Y',strtotime($row['busrev_duedate']));
	            	$to = $user['email'];
	            	$contactno = $lic['contactno'];
	            	$email = $lic['email'];
	            	$businessname = $kams['business_name'];
	            	 // $deslink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

		            $content = $mailContent['email_body'];
		            $content = str_replace('[name]',$name,$content);
		            $content = str_replace('[user_name]',$username,$content);
		            $content = str_replace('[duedate]',$duedate,$content);
		            $content = str_replace('[contactno]',$contactno,$content);
		            $content = str_replace('[email]',$email,$content);
		            $content = str_replace('[company_name]',$businessname,$content); 

		            $subject = $mailContent['email_subject'];
		            $subject = str_replace('[company_name]',$businessname,$subject);
		            $subject = str_replace('[duedate]',$duedate,$subject);
		            
		           $message = $this->load->view('include/mail_template',array('body'=>$content),true);
		            
		             $mailresponce = $this->sendGridMail('',$to,$subject,$message);
		       }
	    }

		public function two_month_ia_qbr_csr(){
			$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+1 month " ) );

	            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','2months_before_qbr');
	           
	            $mbr = $this->generalmodel->get_data_by_condition('busrev_id,ia_id,busrev_duedate','iabusinessreview',array('busrev_duedate'=>$expirydate,'busrev_type'=>'QBR'));
	           
	            foreach ($mbr as $row) {
	            	$kams = $this->generalmodel->getparticularData('assign_to,user_id,business_name','indassociation',array('ia_id'=>$row['ia_id']),"row_array");  
	            	$lic = $this->generalmodel->getparticularData('firstname,lastname,email,contactno','user',array('user_id'=>$kams['user_id']),"row_array");
	            	$csr = $this->generalmodel->getparticularData('firstname,email,user_id','user',array('user_id'=>$kams['assign_to']),"row_array");
	            	$user = $this->generalmodel->getparticularData('firstname,email,user_id','user',array('assign_to'=>$csr['user_id']),"row_array");
	            
	            	$name = $user['firstname'];
	            	$username = $lic['firstname'].' '.$lic['lastname'];
	            	$duedate = date('m-d-Y',strtotime($row['busrev_duedate']));
	            	$to = $user['email'];
	            	$contactno = $lic['contactno'];
	            	$contactno = $lic['email'];
	            	$businessname = $kams['business_name'];
	            	 // $deslink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

		            $content = $mailContent['email_body'];
		            $content = str_replace('[name]',$name,$content);
		            $content = str_replace('[user_name]',$username,$content);
		            $content = str_replace('[duedate]',$duedate,$content);
		            $content = str_replace('[contactno]',$contactno,$content);
		            $content = str_replace('[email]',$email,$content);
		            $content = str_replace('[company_name]',$businessname,$content); 

		            $subject = $mailContent['email_subject'];
		            $subject = str_replace('[company_name]',$businessname,$subject);
		            $subject = str_replace('[duedate]',$duedate,$subject);
		            
		           $message = $this->load->view('include/mail_template',array('body'=>$content),true);
		            
		             $mailresponce = $this->sendGridMail('',$to,$subject,$message);
		       }
           
		}
		/*****************************************************************************************/

		/************************ ABR  **************************************/
		public function one_week_abr_kams(){
				$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+1 week " ) );

	            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','1week_before_abr');
	           
	            $mbr = $this->generalmodel->get_data_by_condition('busrev_id,lic_id,busrev_duedate','licbusinessreview',array('busrev_duedate'=>$expirydate,'busrev_type'=>'ABR'));
	           
	            foreach ($mbr as $row) {
	            	$kams = $this->generalmodel->getparticularData('assign_to,user_id,business_name','licensee',array('lic_id'=>$row['lic_id']),"row_array"); 
	            	$lic = $this->generalmodel->getparticularData('firstname,lastname,email,contactno','user',array('user_id'=>$kams['user_id']),"row_array");
	            	$user = $this->generalmodel->getparticularData('firstname,email','user',array('user_id'=>$kams['assign_to']),"row_array");
	            
	            	$name = $user['firstname'];
	            	$username = $lic['firstname'].' '.$lic['lastname'];
	            	$duedate = date('m-d-Y',strtotime($row['busrev_duedate']));
	            	$to = $user['email'];
	            	$contactno = $lic['contactno'];
	            	$businessname = $kams['business_name'];
	            	 // $deslink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

		            $content = $mailContent['email_body'];
		            $content = str_replace('[name]',$name,$content);
		            $content = str_replace('[user_name]',$username,$content);
		            $content = str_replace('[duedate]',$duedate,$content);
		            $content = str_replace('[contactno]',$contactno,$content);
		            $content = str_replace('[company_name]',$businessname,$content); 

		            $subject = $mailContent['email_subject'];
		            $subject = str_replace('[company_name]',$businessname,$subject);
		            $subject = str_replace('[duedate]',$duedate,$subject);
		            
		           $message = $this->load->view('include/mail_template',array('body'=>$content),true);
		            
		             $mailresponce = $this->sendGridMail('',$to,$subject,$message);
		       }
	    }

	    public function one_week_abr_cto(){
				$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+1 week " ) );

	            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','1week_before_abr');
	           
	            $mbr = $this->generalmodel->get_data_by_condition('busrev_id,lic_id,busrev_duedate','licbusinessreview',array('busrev_duedate'=>$expirydate,'busrev_type'=>'ABR'));
	           
	            foreach ($mbr as $row) {
	            	$lic = $this->generalmodel->getparticularData('assign_to,user_id,business_name','licensee',array('lic_id'=>$row['lic_id']),"row_array"); 
	            	$user = $this->generalmodel->getparticularData('firstname,lastname,email,contactno','user',array('user_id'=>$kams['user_id']),"row_array");
	            	
	            
	            	$name = $user['firstname'];
	            	$username = $user['firstname'].' '.$user['lastname'];
	            	$duedate = date('m-d-Y',strtotime($row['busrev_duedate']));
	            	$to = $user['email'];
	            	$contactno = $user['contactno'];
	            	$businessname = $lic['business_name'];
	            	 // $deslink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

		            $content = $mailContent['email_body'];
		            $content = str_replace('[name]',$name,$content);
		            $content = str_replace('[user_name]',$username,$content);
		            $content = str_replace('[duedate]',$duedate,$content);
		            $content = str_replace('[contactno]',$contactno,$content);
		            $content = str_replace('[company_name]',$businessname,$content); 

		            $subject = $mailContent['email_subject'];
		            $subject = str_replace('[company_name]',$businessname,$subject);
		            $subject = str_replace('[duedate]',$duedate,$subject);
		            
		           $message = $this->load->view('include/mail_template',array('body'=>$content),true);
		            
		             $mailresponce = $this->sendGridMail('',$to,$subject,$message);
		       }
	    }

		public function one_week_abr_csr(){
			$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+1 week " ) );

	            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','1week_before_abr');
	           
	            $mbr = $this->generalmodel->get_data_by_condition('busrev_id,lic_id,busrev_duedate','licbusinessreview',array('busrev_duedate'=>$expirydate,'busrev_type'=>'ABR'));
	           
	            foreach ($mbr as $row) {
	            	$kams = $this->generalmodel->getparticularData('assign_to,user_id,business_name','licensee',array('lic_id'=>$row['lic_id']),"row_array"); 
	            	$lic = $this->generalmodel->getparticularData('firstname,lastname,email,contactno','user',array('user_id'=>$kams['user_id']),"row_array");
	            	$csr = $this->generalmodel->getparticularData('firstname,email,user_id','user',array('user_id'=>$kams['assign_to']),"row_array");
	            	$user = $this->generalmodel->getparticularData('firstname,email,user_id','user',array('assign_to'=>$csr['user_id']),"row_array");
	            
	            	$name = $user['firstname'];
	            	$username = $lic['firstname'].' '.$lic['lastname'];
	            	$duedate = date('m-d-Y',strtotime($row['busrev_duedate']));
	            	$to = $user['email'];
	            	$contactno = $lic['contactno'];
	            	$businessname = $kams['business_name'];
	            	 // $deslink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

		            $content = $mailContent['email_body'];
		            $content = str_replace('[name]',$name,$content);
		            $content = str_replace('[user_name]',$username,$content);
		            $content = str_replace('[duedate]',$duedate,$content);
		            $content = str_replace('[contactno]',$contactno,$content);
		            $content = str_replace('[company_name]',$businessname,$content); 

		            $subject = $mailContent['email_subject'];
		            $subject = str_replace('[company_name]',$businessname,$subject);
		            $subject = str_replace('[duedate]',$duedate,$subject);
		            
		           $message = $this->load->view('include/mail_template',array('body'=>$content),true);
		            
		             $mailresponce = $this->sendGridMail('',$to,$subject,$message);
		       }
           
		}

		public function one_month_abr_kams(){
				$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+1 month " ) );

	            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','1months_before_abr');
	           
	            $mbr = $this->generalmodel->get_data_by_condition('busrev_id,lic_id,busrev_duedate','licbusinessreview',array('busrev_duedate'=>$expirydate,'busrev_type'=>'ABR'));
	           
	            foreach ($mbr as $row) {
	            	$kams = $this->generalmodel->getparticularData('assign_to,user_id,business_name','licensee',array('lic_id'=>$row['lic_id']),"row_array"); 
	            	$lic = $this->generalmodel->getparticularData('firstname,lastname,email,contactno','user',array('user_id'=>$kams['user_id']),"row_array");
	            	$user = $this->generalmodel->getparticularData('firstname,email','user',array('user_id'=>$kams['assign_to']),"row_array");
	            
	            	$name = $user['firstname'];
	            	$username = $lic['firstname'].' '.$lic['lastname'];
	            	$duedate = date('m-d-Y',strtotime($row['busrev_duedate']));
	            	$to = $user['email'];
	            	$contactno = $lic['contactno'];
	            	$businessname = $kams['business_name'];
	            	 // $deslink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

		            $content = $mailContent['email_body'];
		            $content = str_replace('[name]',$name,$content);
		            $content = str_replace('[user_name]',$username,$content);
		            $content = str_replace('[duedate]',$duedate,$content);
		            $content = str_replace('[contactno]',$contactno,$content);
		            $content = str_replace('[company_name]',$businessname,$content); 

		            $subject = $mailContent['email_subject'];
		            $subject = str_replace('[company_name]',$businessname,$subject);
		            $subject = str_replace('[duedate]',$duedate,$subject);
		            
		           $message = $this->load->view('include/mail_template',array('body'=>$content),true);
		            
		             $mailresponce = $this->sendGridMail('',$to,$subject,$message);
		       }
	    }

		public function one_month_abr_csr(){
			$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+1 month " ) );

	            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','1months_before_abr');
	           
	            $mbr = $this->generalmodel->get_data_by_condition('busrev_id,lic_id,busrev_duedate','licbusinessreview',array('busrev_duedate'=>$expirydate,'busrev_type'=>'ABR'));
	           
	            foreach ($mbr as $row) {
	            	$kams = $this->generalmodel->getparticularData('assign_to,user_id,business_name','licensee',array('lic_id'=>$row['lic_id']),"row_array"); 
	            	$lic = $this->generalmodel->getparticularData('firstname,lastname,email,contactno','user',array('user_id'=>$kams['user_id']),"row_array");
	            	$csr = $this->generalmodel->getparticularData('firstname,email,user_id','user',array('user_id'=>$kams['assign_to']),"row_array");
	            	$user = $this->generalmodel->getparticularData('firstname,email,user_id','user',array('assign_to'=>$csr['user_id']),"row_array");
	            
	            	$name = $user['firstname'];
	            	$username = $lic['firstname'].' '.$lic['lastname'];
	            	$duedate = date('m-d-Y',strtotime($row['busrev_duedate']));
	            	$to = $user['email'];
	            	$contactno = $lic['contactno'];
	            	$businessname = $kams['business_name'];
	            	 // $deslink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

		            $content = $mailContent['email_body'];
		            $content = str_replace('[name]',$name,$content);
		            $content = str_replace('[user_name]',$username,$content);
		            $content = str_replace('[duedate]',$duedate,$content);
		            $content = str_replace('[contactno]',$contactno,$content);
		            $content = str_replace('[company_name]',$businessname,$content); 

		            $subject = $mailContent['email_subject'];
		            $subject = str_replace('[company_name]',$businessname,$subject);
		            $subject = str_replace('[duedate]',$duedate,$subject);
		            
		           $message = $this->load->view('include/mail_template',array('body'=>$content),true);
		            
		             $mailresponce = $this->sendGridMail('',$to,$subject,$message);
		       }
           
		}

		public function one_month_abr_cto(){
			$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+1 month " ) );

	            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','1months_before_abr');
	           
	            $mbr = $this->generalmodel->get_data_by_condition('busrev_id,lic_id,busrev_duedate','licbusinessreview',array('busrev_duedate'=>$expirydate,'busrev_type'=>'ABR'));
	           
	            foreach ($mbr as $row) {
	            	$kams = $this->generalmodel->getparticularData('assign_to,user_id,business_name','licensee',array('lic_id'=>$row['lic_id']),"row_array"); 
	            	$lic = $this->generalmodel->getparticularData('firstname,lastname,email,contactno','user',array('user_id'=>$kams['user_id']),"row_array");
	            	
	            
	            	$name = $lic['firstname'];
	            	$username = $lic['firstname'].' '.$lic['lastname'];
	            	$duedate = date('m-d-Y',strtotime($row['busrev_duedate']));
	            	$to = $lic['email'];
	            	$contactno = $lic['contactno'];
	            	$businessname = $kams['business_name'];
	            	 // $deslink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

		            $content = $mailContent['email_body'];
		            $content = str_replace('[name]',$name,$content);
		            $content = str_replace('[user_name]',$username,$content);
		            $content = str_replace('[duedate]',$duedate,$content);
		            $content = str_replace('[contactno]',$contactno,$content);
		            $content = str_replace('[company_name]',$businessname,$content); 

		            $subject = $mailContent['email_subject'];
		            $subject = str_replace('[company_name]',$businessname,$subject);
		            $subject = str_replace('[duedate]',$duedate,$subject);
		            
		           $message = $this->load->view('include/mail_template',array('body'=>$content),true);
		            
		             $mailresponce = $this->sendGridMail('',$to,$subject,$message);
		       }
           
		}

		public function two_month_abr_kams(){
				$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+1 month " ) );

	            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','2months_before_abr');
	           
	            $mbr = $this->generalmodel->get_data_by_condition('busrev_id,lic_id,busrev_duedate','licbusinessreview',array('busrev_duedate'=>$expirydate,'busrev_type'=>'ABR'));
	           
	            foreach ($mbr as $row) {
	            	$kams = $this->generalmodel->getparticularData('assign_to,user_id,business_name','licensee',array('lic_id'=>$row['lic_id']),"row_array"); 
	            	$lic = $this->generalmodel->getparticularData('firstname,lastname,email,contactno','user',array('user_id'=>$kams['user_id']),"row_array");
	            	$user = $this->generalmodel->getparticularData('firstname,email','user',array('user_id'=>$kams['assign_to']),"row_array");
	            
	            	$name = $user['firstname'];
	            	$username = $lic['firstname'].' '.$lic['lastname'];
	            	$duedate = date('m-d-Y',strtotime($row['busrev_duedate']));
	            	$to = $user['email'];
	            	$contactno = $lic['contactno'];
	            	$businessname = $kams['business_name'];
	            	 // $deslink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

		            $content = $mailContent['email_body'];
		            $content = str_replace('[name]',$name,$content);
		            $content = str_replace('[user_name]',$username,$content);
		            $content = str_replace('[duedate]',$duedate,$content);
		            $content = str_replace('[contactno]',$contactno,$content);
		            $content = str_replace('[company_name]',$businessname,$content); 

		            $subject = $mailContent['email_subject'];
		            $subject = str_replace('[company_name]',$businessname,$subject);
		            $subject = str_replace('[duedate]',$duedate,$subject);
		            
		           $message = $this->load->view('include/mail_template',array('body'=>$content),true);
		            
		             $mailresponce = $this->sendGridMail('',$to,$subject,$message);
		       }
	    }

		public function two_month_abr_csr(){
			$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+1 month " ) );

	            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','2months_before_abr');
	           
	            $mbr = $this->generalmodel->get_data_by_condition('busrev_id,lic_id,busrev_duedate','licbusinessreview',array('busrev_duedate'=>$expirydate,'busrev_type'=>'ABR'));
	           
	            foreach ($mbr as $row) {
	            	$kams = $this->generalmodel->getparticularData('assign_to,user_id,business_name','licensee',array('lic_id'=>$row['lic_id']),"row_array"); 
	            	$lic = $this->generalmodel->getparticularData('firstname,lastname,email,contactno','user',array('user_id'=>$kams['user_id']),"row_array");
	            	$csr = $this->generalmodel->getparticularData('firstname,email,user_id','user',array('user_id'=>$kams['assign_to']),"row_array");
	            	$user = $this->generalmodel->getparticularData('firstname,email,user_id','user',array('assign_to'=>$csr['user_id']),"row_array");
	            
	            	$name = $user['firstname'];
	            	$username = $lic['firstname'].' '.$lic['lastname'];
	            	$duedate = date('m-d-Y',strtotime($row['busrev_duedate']));
	            	$to = $user['email'];
	            	$contactno = $lic['contactno'];
	            	$businessname = $kams['business_name'];
	            	 // $deslink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

		            $content = $mailContent['email_body'];
		            $content = str_replace('[name]',$name,$content);
		            $content = str_replace('[user_name]',$username,$content);
		            $content = str_replace('[contactno]',$contactno,$content);
		            $content = str_replace('[duedate]',$duedate,$content);
		            $content = str_replace('[company_name]',$businessname,$content); 

		            $subject = $mailContent['email_subject'];
		            $subject = str_replace('[company_name]',$businessname,$subject);
		            $subject = str_replace('[duedate]',$duedate,$subject);
		            
		           $message = $this->load->view('include/mail_template',array('body'=>$content),true);
		            
		             $mailresponce = $this->sendGridMail('',$to,$subject,$message);
		       }
           
		}

		public function two_month_abr_cto(){
			$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+1 month " ) );

	            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','2months_before_abr');
	           
	            $mbr = $this->generalmodel->get_data_by_condition('busrev_id,lic_id,busrev_duedate','licbusinessreview',array('busrev_duedate'=>$expirydate,'busrev_type'=>'ABR'));
	           
	            foreach ($mbr as $row) {
	            	$kams = $this->generalmodel->getparticularData('assign_to,user_id,business_name','licensee',array('lic_id'=>$row['lic_id']),"row_array"); 
	            	$lic = $this->generalmodel->getparticularData('firstname,lastname,email,contactno','user',array('user_id'=>$kams['user_id']),"row_array");
	            	
	            
	            	$name = $lic['firstname'];
	            	$username = $lic['firstname'].' '.$lic['lastname'];
	            	$duedate = date('m-d-Y',strtotime($row['busrev_duedate']));
	            	$to = $lic['email'];
	            	$contactno = $lic['contactno'];
	            	$businessname = $kams['business_name'];
	            	 // $deslink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

		            $content = $mailContent['email_body'];
		            $content = str_replace('[name]',$name,$content);
		            $content = str_replace('[user_name]',$username,$content);
		            $content = str_replace('[duedate]',$duedate,$content);
		            $content = str_replace('[contactno]',$contactno,$content);
		            $content = str_replace('[company_name]',$businessname,$content); 

		            $subject = $mailContent['email_subject'];
		            $subject = str_replace('[company_name]',$businessname,$subject);
		            $subject = str_replace('[duedate]',$duedate,$subject);
		            
		             $message = $this->load->view('include/mail_template',array('body'=>$content),true);
		            
		             $mailresponce = $this->sendGridMail('',$to,$subject,$message);
		       }
           
		}

		public function one_week_ia_abr_kams(){
				$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+1 week " ) );

	            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','1week_before_abr');
	           
	            $mbr = $this->generalmodel->get_data_by_condition('busrev_id,ia_id,busrev_duedate','iabusinessreview',array('busrev_duedate'=>$expirydate,'busrev_type'=>'ABR'));
	           
	            foreach ($mbr as $row) {
	            	$kams = $this->generalmodel->getparticularData('assign_to,user_id,business_name','indassociation',array('ia_id'=>$row['ia_id']),"row_array");
	            	$lic = $this->generalmodel->getparticularData('firstname,lastname,email,contactno','user',array('user_id'=>$kams['user_id']),"row_array");
	            	$user = $this->generalmodel->getparticularData('firstname,email','user',array('user_id'=>$kams['assign_to']),"row_array");
	            
	            	$name = $user['firstname'];
	            	$username = $lic['firstname'].' '.$lic['lastname'];
	            	$duedate = date('m-d-Y',strtotime($row['busrev_duedate']));
	            	$to = $user['email'];
	            	$contactno = $lic['contactno'];
	            	$businessname = $kams['business_name'];
	            	 // $deslink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

		            $content = $mailContent['email_body'];
		            $content = str_replace('[name]',$name,$content);
		            $content = str_replace('[user_name]',$username,$content);
		            $content = str_replace('[contactno]',$contactno,$content);
		            $content = str_replace('[duedate]',$duedate,$content);
		            $content = str_replace('[company_name]',$businessname,$content); 

		            $subject = $mailContent['email_subject'];
		            $subject = str_replace('[company_name]',$businessname,$subject);
		            $subject = str_replace('[duedate]',$duedate,$subject);
		            
		             $message = $this->load->view('include/mail_template',array('body'=>$content),true);
		            
		             $mailresponce = $this->sendGridMail('',$to,$subject,$message);
		       }
	    }

	    public function one_week_ia_abr_cto(){
				$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+1 week " ) );

	            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','1week_before_abr');
	           
	            $mbr = $this->generalmodel->get_data_by_condition('busrev_id,ia_id,busrev_duedate','iabusinessreview',array('busrev_duedate'=>$expirydate,'busrev_type'=>'ABR'));
	           
	            foreach ($mbr as $row) {
	            	$kams = $this->generalmodel->getparticularData('assign_to,user_id,business_name','indassociation',array('ia_id'=>$row['ia_id']),"row_array");
	            	$user = $this->generalmodel->getparticularData('firstname,lastname,email,contactno','user',array('user_id'=>$kams['user_id']),"row_array");
	            	
	            
	            	$name = $user['firstname'];
	            	$username = $user['firstname'].' '.$user['lastname'];
	            	$duedate = date('m-d-Y',strtotime($row['busrev_duedate']));
	            	$to = $user['email'];
	            	$contactno = $user['contactno'];
	            	$businessname = $lic['business_name'];
	            	 // $deslink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

		            $content = $mailContent['email_body'];
		            $content = str_replace('[name]',$name,$content);
		            $content = str_replace('[user_name]',$username,$content);
		            $content = str_replace('[duedate]',$duedate,$content);
		            $content = str_replace('[contactno]',$contactno,$content);
		            $content = str_replace('[company_name]',$businessname,$content); 

		            $subject = $mailContent['email_subject'];
		            $subject = str_replace('[company_name]',$businessname,$subject);
		            $subject = str_replace('[duedate]',$duedate,$subject);
		            
		           $message = $this->load->view('include/mail_template',array('body'=>$content),true);
		            
		             $mailresponce = $this->sendGridMail('',$to,$subject,$message);
		       }
	    }

		public function one_week_ia_abr_csr(){
			$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+1 week " ) );

	            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','1week_before_abr');
	           
	            $mbr = $this->generalmodel->get_data_by_condition('busrev_id,ia_id,busrev_duedate','iabusinessreview',array('busrev_duedate'=>$expirydate,'busrev_type'=>'ABR'));
	           
	            foreach ($mbr as $row) {
	            	$kams = $this->generalmodel->getparticularData('assign_to,user_id,business_name','indassociation',array('ia_id'=>$row['ia_id']),"row_array"); 
	            	$lic = $this->generalmodel->getparticularData('firstname,lastname,email,contactno','user',array('user_id'=>$kams['user_id']),"row_array");
	            	$csr = $this->generalmodel->getparticularData('firstname,email,user_id','user',array('user_id'=>$kams['assign_to']),"row_array");
	            	$user = $this->generalmodel->getparticularData('firstname,email,user_id','user',array('assign_to'=>$csr['user_id']),"row_array");
	            
	            	$name = $user['firstname'];
	            	$username = $lic['firstname'].' '.$lic['lastname'];
	            	$duedate = date('m-d-Y',strtotime($row['busrev_duedate']));
	            	$to = $user['email'];
	            	$contactno = $lic['contactno'];
	            	$businessname = $kams['business_name'];
	            	 // $deslink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

		            $content = $mailContent['email_body'];
		            $content = str_replace('[name]',$name,$content);
		            $content = str_replace('[user_name]',$username,$content);
		            $content = str_replace('[duedate]',$duedate,$content);
		            $content = str_replace('[contactno]',$contactno,$content);
		            $content = str_replace('[company_name]',$businessname,$content); 

		            $subject = $mailContent['email_subject'];
		            $subject = str_replace('[company_name]',$businessname,$subject);
		            $subject = str_replace('[duedate]',$duedate,$subject);
		            
		           $message = $this->load->view('include/mail_template',array('body'=>$content),true);
		            
		             $mailresponce = $this->sendGridMail('',$to,$subject,$message);
		       }
           
		}

		public function one_month_ia_abr_kams(){
				$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+1 month " ) );

	            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','1months_before_abr');
	           
	            $mbr = $this->generalmodel->get_data_by_condition('busrev_id,ia_id,busrev_duedate','iabusinessreview',array('busrev_duedate'=>$expirydate,'busrev_type'=>'ABR'));
	           
	            foreach ($mbr as $row) {
	            	$kams = $this->generalmodel->getparticularData('assign_to,user_id,business_name','indassociation',array('ia_id'=>$row['ia_id']),"row_array"); 
	            	$lic = $this->generalmodel->getparticularData('firstname,lastname,email,contactno','user',array('user_id'=>$kams['user_id']),"row_array");
	            	$user = $this->generalmodel->getparticularData('firstname,email','user',array('user_id'=>$kams['assign_to']),"row_array");
	            
	            	$name = $user['firstname'];
	            	$username = $lic['firstname'].' '.$lic['lastname'];
	            	$duedate = date('m-d-Y',strtotime($row['busrev_duedate']));
	            	$to = $user['email'];
	            	$contactno = $lic['contactno'];
	            	$businessname = $kams['business_name'];
	            	 // $deslink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

		            $content = $mailContent['email_body'];
		            $content = str_replace('[name]',$name,$content);
		            $content = str_replace('[user_name]',$username,$content);
		            $content = str_replace('[duedate]',$duedate,$content);
		            $content = str_replace('[contactno]',$contactno,$content);
		            $content = str_replace('[company_name]',$businessname,$content); 

		            $subject = $mailContent['email_subject'];
		            $subject = str_replace('[company_name]',$businessname,$subject);
		            $subject = str_replace('[duedate]',$duedate,$subject);
		            
		           $message = $this->load->view('include/mail_template',array('body'=>$content),true);
		            
		             $mailresponce = $this->sendGridMail('',$to,$subject,$message);
		       }
	    }

		public function one_month_ia_abr_csr(){
			$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+1 month " ) );

	            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','1months_before_abr');
	           
	           $mbr = $this->generalmodel->get_data_by_condition('busrev_id,ia_id,busrev_duedate','iabusinessreview',array('busrev_duedate'=>$expirydate,'busrev_type'=>'ABR'));
	           
	            foreach ($mbr as $row) {
	            	$kams = $this->generalmodel->getparticularData('assign_to,user_id,business_name','indassociation',array('ia_id'=>$row['ia_id']),"row_array"); 
	            	$lic = $this->generalmodel->getparticularData('firstname,lastname,email,contactno','user',array('user_id'=>$kams['user_id']),"row_array");
	            	$csr = $this->generalmodel->getparticularData('firstname,email,user_id','user',array('user_id'=>$kams['assign_to']),"row_array");
	            	$user = $this->generalmodel->getparticularData('firstname,email,user_id','user',array('assign_to'=>$csr['user_id']),"row_array");
	            
	            	$name = $user['firstname'];
	            	$username = $lic['firstname'].' '.$lic['lastname'];
	            	$duedate = date('m-d-Y',strtotime($row['busrev_duedate']));
	            	$to = $user['email'];
	            	$contactno = $lic['contactno'];
	            	$businessname = $kams['business_name'];
	            	 // $deslink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

		            $content = $mailContent['email_body'];
		            $content = str_replace('[name]',$name,$content);
		            $content = str_replace('[user_name]',$username,$content);
		            $content = str_replace('[duedate]',$duedate,$content);
		            $content = str_replace('[contactno]',$contactno,$content);
		            $content = str_replace('[company_name]',$businessname,$content); 

		            $subject = $mailContent['email_subject'];
		            $subject = str_replace('[company_name]',$businessname,$subject);
		            $subject = str_replace('[duedate]',$duedate,$subject);
		            
		           $message = $this->load->view('include/mail_template',array('body'=>$content),true);
		            
		             $mailresponce = $this->sendGridMail('',$to,$subject,$message);
		       }
           
		}

		public function one_month_ia_abr_cto(){
			$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+1 month " ) );

	            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','1months_before_abr');
	           
	            $mbr = $this->generalmodel->get_data_by_condition('busrev_id,ia_id,busrev_duedate','iabusinessreview',array('busrev_duedate'=>$expirydate,'busrev_type'=>'ABR'));
	           
	            foreach ($mbr as $row) {
	            	$kams = $this->generalmodel->getparticularData('assign_to,user_id,business_name','indassociation',array('ia_id'=>$row['ia_id']),"row_array"); 
	            	$lic = $this->generalmodel->getparticularData('firstname,lastname,email,contactno','user',array('user_id'=>$kams['user_id']),"row_array");
	            	
	            
	            	$name = $lic['firstname'];
	            	$username = $lic['firstname'].' '.$lic['lastname'];
	            	$duedate = date('m-d-Y',strtotime($row['busrev_duedate']));
	            	$to = $lic['email'];
	            	$contactno = $lic['contactno'];
	            	$businessname = $kams['business_name'];
	            	 // $deslink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

		            $content = $mailContent['email_body'];
		            $content = str_replace('[name]',$name,$content);
		            $content = str_replace('[user_name]',$username,$content);
		            $content = str_replace('[duedate]',$duedate,$content);
		            $content = str_replace('[contactno]',$contactno,$content);
		            $content = str_replace('[company_name]',$businessname,$content); 

		            $subject = $mailContent['email_subject'];
		            $subject = str_replace('[company_name]',$businessname,$subject);
		            $subject = str_replace('[duedate]',$duedate,$subject);
		            
		           $message = $this->load->view('include/mail_template',array('body'=>$content),true);
		            
		             $mailresponce = $this->sendGridMail('',$to,$subject,$message);
		       }
           
		}

		public function two_month_ia_abr_kams(){
				$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+1 month " ) );

	            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','2months_before_abr');
	           
	            $mbr = $this->generalmodel->get_data_by_condition('busrev_id,ia_id,busrev_duedate','iabusinessreview',array('busrev_duedate'=>$expirydate,'busrev_type'=>'ABR'));
	           
	            foreach ($mbr as $row) {
	            	$kams = $this->generalmodel->getparticularData('assign_to,user_id,business_name','indassociation',array('ia_id'=>$row['ia_id']),"row_array"); 
	            	$lic = $this->generalmodel->getparticularData('firstname,lastname,email,contactno','user',array('user_id'=>$kams['user_id']),"row_array");
	            	$user = $this->generalmodel->getparticularData('firstname,email','user',array('user_id'=>$kams['assign_to']),"row_array");
	            
	            	$name = $user['firstname'];
	            	$username = $lic['firstname'].' '.$lic['lastname'];
	            	$duedate = date('m-d-Y',strtotime($row['busrev_duedate']));
	            	$to = $user['email'];
	            	$contactno = $lic['contactno'];
	            	$businessname = $kams['business_name'];
	            	 // $deslink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

		            $content = $mailContent['email_body'];
		            $content = str_replace('[name]',$name,$content);
		            $content = str_replace('[user_name]',$username,$content);
		            $content = str_replace('[duedate]',$duedate,$content);
		            $content = str_replace('[contactno]',$contactno,$content);
		            $content = str_replace('[company_name]',$businessname,$content); 

		            $subject = $mailContent['email_subject'];
		            $subject = str_replace('[company_name]',$businessname,$subject);
		            $subject = str_replace('[duedate]',$duedate,$subject);
		            
		           $message = $this->load->view('include/mail_template',array('body'=>$content),true);
		            
		             $mailresponce = $this->sendGridMail('',$to,$subject,$message);
		       }
	    }

		public function two_month_ia_abr_csr(){
			$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+1 month " ) );

	            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','2months_before_abr');
	           
	            $mbr = $this->generalmodel->get_data_by_condition('busrev_id,ia_id,busrev_duedate','iabusinessreview',array('busrev_duedate'=>$expirydate,'busrev_type'=>'ABR'));
	           
	            foreach ($mbr as $row) {
	            	$kams = $this->generalmodel->getparticularData('assign_to,user_id,business_name','indassociation',array('ia_id'=>$row['ia_id']),"row_array"); 
	            	$lic = $this->generalmodel->getparticularData('firstname,lastname,email,contactno','user',array('user_id'=>$kams['user_id']),"row_array");
	            	$csr = $this->generalmodel->getparticularData('firstname,email,user_id','user',array('user_id'=>$kams['assign_to']),"row_array");
	            	$user = $this->generalmodel->getparticularData('firstname,email,user_id','user',array('assign_to'=>$csr['user_id']),"row_array");
	            
	            	$name = $user['firstname'];
	            	$username = $lic['firstname'].' '.$lic['lastname'];
	            	$duedate = date('m-d-Y',strtotime($row['busrev_duedate']));
	            	$to = $user['email'];
	            	$contactno = $lic['contactno'];
	            	$businessname = $kams['business_name'];
	            	 // $deslink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

		            $content = $mailContent['email_body'];
		            $content = str_replace('[name]',$name,$content);
		            $content = str_replace('[user_name]',$username,$content);
		            $content = str_replace('[duedate]',$duedate,$content);
		            $content = str_replace('[contactno]',$contactno,$content);
		            $content = str_replace('[company_name]',$businessname,$content); 

		            $subject = $mailContent['email_subject'];
		            $subject = str_replace('[company_name]',$businessname,$subject);
		            $subject = str_replace('[duedate]',$duedate,$subject);
		            
		           $message = $this->load->view('include/mail_template',array('body'=>$content),true);
		            
		             $mailresponce = $this->sendGridMail('',$to,$subject,$message);
		       }
           
		}

		public function two_month_ia_abr_cto(){
			$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+1 month " ) );

	            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','2months_before_abr');
	           
	           $mbr = $this->generalmodel->get_data_by_condition('busrev_id,ia_id,busrev_duedate','iabusinessreview',array('busrev_duedate'=>$expirydate,'busrev_type'=>'ABR'));
	           
	            foreach ($mbr as $row) {
	            	$kams = $this->generalmodel->getparticularData('assign_to,user_id,business_name','indassociation',array('ia_id'=>$row['ia_id']),"row_array"); 
	            	$lic = $this->generalmodel->getparticularData('firstname,lastname,email,contactno','user',array('user_id'=>$kams['user_id']),"row_array");
	            	
	            
	            	$name = $lic['firstname'];
	            	$username = $lic['firstname'].' '.$lic['lastname'];
	            	$duedate = date('m-d-Y',strtotime($row['busrev_duedate']));
	            	$to = $lic['email'];
	            	$contactno = $lic['contactno'];
	            	$businessname = $kams['business_name'];
	            	 // $deslink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

		            $content = $mailContent['email_body'];
		            $content = str_replace('[name]',$name,$content);
		            $content = str_replace('[user_name]',$username,$content);
		            $content = str_replace('[duedate]',$duedate,$content);
		            $content = str_replace('[contactno]',$contactno,$content);
		            $content = str_replace('[company_name]',$businessname,$content); 

		            $subject = $mailContent['email_subject'];
		            $subject = str_replace('[company_name]',$businessname,$subject);
		            $subject = str_replace('[duedate]',$duedate,$subject);
		            
		           $message = $this->load->view('include/mail_template',array('body'=>$content),true);
		            
		             $mailresponce = $this->sendGridMail('',$to,$subject,$message);
		       }
           
		}
		/*****************************************************************************************/
		
		public function genratebr(){
			$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-1 month " ) );
			$this->db->like('createddate',$expirydate);
			$lic = $this->generalmodel->get_data_by_condition('lic_id,createddate','licensee',array('status!='=>"2"));
			foreach ($lic as $row) {
			
			$busData['lic_id'] = $row['lic_id'];
			$busData['busrev_title'] = date("F Y");
			$busData['busrev_duedate'] = date("Y-m-d H:i:s");
			$busData['busrev_status'] = 'Pending';
			$busData['busrev_type'] = "MBR";

			$query = $this->generalmodel->add('licbusinessreview', $busData);
			$this->generalmodel->updaterecord('licensee', array('br_status'=>0),array('lic_id'=>$row['lic_id']));
			}

			$this->db->like('createddate',$expirydate);
			$ia = $this->generalmodel->get_data_by_condition('ia_id,createddate','indassociation',array('status!='=>"2"));
			foreach ($ia as $row) {
			
			$Data['ia_id'] = $row['ia_id'];
			$Data['busrev_title'] = date("F Y");
			$Data['busrev_duedate'] = date("Y-m-d H:i:s");
			$Data['busrev_status'] = 'Pending';
			$Data['busrev_type'] = "MBR";

			$query = $this->generalmodel->add('iabusinessreview', $Data);
			$this->generalmodel->updaterecord('indassociation', array('br_status'=>0),array('ia_id'=>$row['ia_id']));
			}
		}

		public function updatebsmbr(){
			$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-1 month " ) );
			$this->db->like('busrev_duedate',$expirydate);
		
			$lic = $this->generalmodel->get_data_by_condition('busrev_id,lic_id,busrev_file,busrev_type','licbusinessreview',array('busrev_type IN (MBR,QBR)'));

			foreach ($lic as $row) {
				if($row['busrev_type']=="MBR"){
					if($row['busrev_file']==''){
						$busData['busrev_duedate'] = date("Y-m-d H:i:s");
						$busData['busrev_status'] = 'Late';
						$busData['busrev_type'] = "MBR";
						$query = $this->generalmodel->updaterecord('licbusinessreview', $busData,array('busrev_id'=>$row['busrev_id']));
						$brst = $this->generalmodel->getSingleRowById('licensee', 'lic_id', $row['lic_id'],'array');
					
						if($brst['br_status']==0 || $brst['br_status']==2 || $brst['br_status']==3 || $brst['br_status']== 5 || $brst['br_status']== 6 || $brst['br_status']==8 || $brst['br_status']== 9){
							$Data['lic_id'] = $row['lic_id'];
							$Data['busrev_title'] = date("F Y");
							$Data['busrev_duedate'] = date("Y-m-d H:i:s");
							$Data['busrev_status'] = 'Pending';
							$Data['busrev_type'] = "MBR";

							$query = $this->generalmodel->add('licbusinessreview', $Data);
							$brs = $brst['br_status'] + 1;
							$this->generalmodel->updaterecord('licensee', array('br_status'=>$brs),array('lic_id'=>$row['lic_id']));
						}
					}
				}

				if($row['busrev_type']=="QBR"){
					$expirydates = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-2 month " ) );
						$this->db->like('busrev_duedate',$expirydates);
						$lics = $this->generalmodel->get_data_by_condition('busrev_id,lic_id,busrev_file,busrev_type','licbusinessreview',array('busrev_type IN (MBR)'));
						// echo $this->db->last_query(); print_r($lic); exit;
						foreach ($lics as $rows) {
						if($rows['busrev_type']=="MBR"){
							if($rows['busrev_file']==''){
								$busData['busrev_duedate'] = date("Y-m-d H:i:s");
								$busData['busrev_status'] = 'Late';
								$busData['busrev_type'] = "MBR";
								$query = $this->generalmodel->updaterecord('licbusinessreview', $busData,array('busrev_id'=>$rows['busrev_id']));
								$brst = $this->generalmodel->getSingleRowById('licensee', 'lic_id', $rows['lic_id'],'array');
							// print_r($brst); exit;
								if($brst['br_status']==2 || $brst['br_status']==5 || $brst['br_status']==8){
									$Data['lic_id'] = $rows['lic_id'];
									$Data['busrev_title'] = date("F Y");
									$Data['busrev_duedate'] = date("Y-m-d H:i:s");
									$Data['busrev_status'] = 'Pending';
									$Data['busrev_type'] = "MBR";

									$query = $this->generalmodel->add('licbusinessreview', $Data);
									$brs = $brst['br_status'] + 1;
									$this->generalmodel->updaterecord('licensee', array('br_status'=>$brs),array('lic_id'=>$rows['lic_id']));
								}
							}
						}
				}	
			
			}

			

			$this->db->like('busrev_duedate',$expirydate);
			$ia = $this->generalmodel->get_data_by_condition('busrev_id,ia_id,busrev_file','iabusinessreview',array('busrev_type'=>"MBR"));

			foreach ($ia as $row) {
				if($row['busrev_type']=="MBR"){
					if($row['busrev_file']==''){
						$busData['busrev_duedate'] = date("Y-m-d H:i:s");
						$busData['busrev_status'] = 'Late';
						$busData['busrev_type'] = "MBR";
						$query = $this->generalmodel->updaterecord('iabusinessreview', $busData,array('busrev_id'=>$row['busrev_id']));
						$brst = $this->generalmodel->getSingleRowById('iabusinessreview', 'ia_id', $row['ia_id'],'array');
					
						if($brst['br_status']==0 || $brst['br_status']==2 || $brst['br_status']==3 || $brst['br_status']== 5 || $brst['br_status']== 6 || $brst['br_status']==8 || $brst['br_status']== 9){
							$Data['ia_id'] = $row['ia_id'];
							$Data['busrev_title'] = date("F Y");
							$Data['busrev_duedate'] = date("Y-m-d H:i:s");
							$Data['busrev_status'] = 'Pending';
							$Data['busrev_type'] = "MBR";

							$query = $this->generalmodel->add('iabusinessreview', $Data);
							$brs = $brst['br_status'] + 1;
							$this->generalmodel->updaterecord('iabusinessreview', array('br_status'=>$brs),array('ia_id'=>$row['ia_id']));
						}
					}
				}

				if($row['busrev_type']=="QBR"){
					$expirydates = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-2 month " ) );
						$this->db->like('busrev_duedate',$expirydates);
						$lics = $this->generalmodel->get_data_by_condition('busrev_id,ia_id,busrev_file,busrev_type','iabusinessreview',array('busrev_type IN (MBR)'));
						// echo $this->db->last_query(); print_r($lic); exit;
						foreach ($lics as $rows) {
						if($rows['busrev_type']=="MBR"){
							if($rows['busrev_file']==''){
								$busData['busrev_duedate'] = date("Y-m-d H:i:s");
								$busData['busrev_status'] = 'Late';
								$busData['busrev_type'] = "MBR";
								$query = $this->generalmodel->updaterecord('iabusinessreview', $busData,array('busrev_id'=>$rows['busrev_id']));
								$brst = $this->generalmodel->getSingleRowById('iabusinessreview', 'ia_id', $rows['ia_id'],'array');
							// print_r($brst); exit;
								if($brst['br_status']==2 || $brst['br_status']==5 || $brst['br_status']==8){
									$Data['ia_id'] = $rows['ia_id'];
									$Data['busrev_title'] = date("F Y");
									$Data['busrev_duedate'] = date("Y-m-d H:i:s");
									$Data['busrev_status'] = 'Pending';
									$Data['busrev_type'] = "MBR";

									$query = $this->generalmodel->add('iabusinessreview', $Data);
									$brs = $brst['br_status'] + 1;
									$this->generalmodel->updaterecord('iabusinessreview', array('br_status'=>$brs),array('ia_id'=>$rows['ia_id']));
								}
							}
						}
				}	
			
			}
		}
	}
}


		public function genratebrqbr(){
			$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-3 month " ) );
			$this->db->like('createddate',$expirydate);
			$lic = $this->generalmodel->get_data_by_condition('lic_id,createddate','licensee',array('status!='=>"2", 'br_status IN (1)'));
			// print_r($lic); exit;
			foreach ($lic as $row) {
			
			$busData['lic_id'] = $row['lic_id'];
			$busData['busrev_title'] = date("F Y");
			$busData['busrev_duedate'] = date("Y-m-d H:i:s");
			$busData['busrev_status'] = 'Pending';
			$busData['busrev_type'] = "QBR";

			$query = $this->generalmodel->add('licbusinessreview', $busData);

			$brst = $this->generalmodel->getSingleRowById('licensee', 'lic_id', $row['lic_id'],'array');

			$brs = $brst['br_status'] + 1;
			
			$this->generalmodel->updaterecord('licensee', array('br_status'=>$brs),array('lic_id'=>$row['lic_id']));

			}

			$this->db->like('createddate',$expirydate);
			$ia = $this->generalmodel->get_data_by_condition('ia_id,createddate','indassociation',array('status!='=>"2", 'br_status IN (1)'));
			foreach ($ia as $row) {
			
			$iabusData['ia_id'] = $row['ia_id'];
			$iabusData['busrev_title'] = date("F Y");
			$iabusData['busrev_duedate'] = date("Y-m-d H:i:s");
			$iabusData['busrev_status'] = 'Pending';
			$iabusData['busrev_type'] = "QBR";

			$querys = $this->generalmodel->add('iabusinessreview', $iabusData);

			$brst = $this->generalmodel->getSingleRowById('indassociation', 'ia_id', $row['ia_id'],'array');

			$brs = $brst['br_status'] + 1;
			
			$this->generalmodel->updaterecord('indassociation', array('br_status'=>$brs),array('ia_id'=>$row['ia_id']));

			}
		}
		

		public function updatebsqbr(){
			$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-3 month " ) );
			$this->db->like('busrev_duedate',$expirydate);
			$lic = $this->generalmodel->get_data_by_condition('busrev_id,lic_id,busrev_file','licbusinessreview',array('busrev_type'=>"QBR"));
			foreach ($lic as $row) {
			if($row['busrev_file']==''){
				$busData['busrev_duedate'] = date("Y-m-d H:i:s");
				$busData['busrev_status'] = 'Late';
				$busData['busrev_type'] = "QBR";
				$query = $this->generalmodel->updaterecord('licbusinessreview', $busData,array('busrev_id'=>$row['busrev_id']));
                
				$brst = $this->generalmodel->getSingleRowById('licensee', 'lic_id', $row['lic_id'],'array');

				if($brst['br_status']==4 || $brst['br_status']==7 ){
					$Data['lic_id'] = $row['lic_id'];
					$Data['busrev_title'] = date("F Y");
					$Data['busrev_duedate'] = date("Y-m-d H:i:s");
					$Data['busrev_status'] = 'Pending';
					$Data['busrev_type'] = "QBR";

					$query = $this->generalmodel->add('licbusinessreview', $Data);
					$brs = $brst['br_status'] + 1;
				
					$this->generalmodel->updaterecord('licensee', array('br_status'=>$brs),array('lic_id'=>$row['lic_id']));
				}
				// $brst = $this->generalmodel->get_data_by_condition('lic_id,br_status','licensee',array('lic_id'=>$row['lic_id']));
				
			}

			}

			$this->db->like('busrev_duedate',$expirydate);
			$ia = $this->generalmodel->get_data_by_condition('busrev_id,ia_id,busrev_file','iabusinessreview',array('busrev_type'=>"QBR"));
			foreach ($ia as $row) {
			if($row['busrev_file']==''){
				$iabusData['busrev_duedate'] = date("Y-m-d H:i:s");
				$iabusData['busrev_status'] = 'Late';
				$iabusData['busrev_type'] = "QBR";
				$query = $this->generalmodel->updaterecord('iabusinessreview', $iabusData,array('busrev_id'=>$row['busrev_id']));

				$iaData['ia_id'] = $row['ia_id'];
				$iaData['busrev_title'] = date("F Y");
				$iaData['busrev_duedate'] = date("Y-m-d H:i:s");
				$iaData['busrev_status'] = 'Pending';
				$iaData['busrev_type'] = "QBR";

				$query = $this->generalmodel->add('iabusinessreview', $iaData);
			}

			}

			foreach ($lic as $row) {
			if($row['busrev_file']==''){
				$busData['busrev_duedate'] = date("Y-m-d H:i:s");
				$busData['busrev_status'] = 'Late';
				$busData['busrev_type'] = "QBR";
				$query = $this->generalmodel->updaterecord('iabusinessreview', $busData,array('busrev_id'=>$row['busrev_id']));
                
				$brst = $this->generalmodel->getSingleRowById('iabusinessreview', 'ia_id', $row['ia_id'],'array');

				if($brst['br_status']==4 || $brst['br_status']==7 ){
					$Data['ia_id'] = $row['ia_id'];
					$Data['busrev_title'] = date("F Y");
					$Data['busrev_duedate'] = date("Y-m-d H:i:s");
					$Data['busrev_status'] = 'Pending';
					$Data['busrev_type'] = "QBR";

					$query = $this->generalmodel->add('iabusinessreview', $Data);
					$brs = $brst['br_status'] + 1;
				
					$this->generalmodel->updaterecord('iabusinessreview', array('br_status'=>$brs),array('ia_id'=>$row['ia_id']));
				}
				// $brst = $this->generalmodel->get_data_by_condition('lic_id,br_status','licensee',array('lic_id'=>$row['lic_id']));
				
			}

			}
		}

		public function genratebrabr(){
			$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-1 year " ) );
			$this->db->like('createddate',$expirydate);
			$lic = $this->generalmodel->get_data_by_condition('lic_id,createddate','licensee',array('status!='=>"2",'br_status IN (10)'));
			foreach ($lic as $row) {
			
			$busData['lic_id'] = $row['lic_id'];
			$busData['busrev_title'] = date("F Y");
			$busData['busrev_duedate'] = date("Y-m-d H:i:s");
			$busData['busrev_status'] = 'Pending';
			$busData['busrev_type'] = "ABR";

			$query = $this->generalmodel->add('licbusinessreview', $busData);

			$brst = $this->generalmodel->getSingleRowById('licensee', 'lic_id', $row['lic_id'],'array');
			$brs = $brst['br_status']+1;
			
			$this->generalmodel->updaterecord('licensee', array('br_status'=>$brs),array('lic_id'=>$row['lic_id']));
			}

				$this->db->like('createddate',$expirydate);
				$ia = $this->generalmodel->get_data_by_condition('ia_id,createddate','indassociation',array('status!='=>"2",'br_status IN (10)'));
				foreach ($ia as $row) {
				
				$iabusData['ia_id'] = $row['ia_id'];
				$iabusData['busrev_title'] = date("F Y");
				$iabusData['busrev_duedate'] = date("Y-m-d H:i:s");
				$iabusData['busrev_status'] = 'Pending';
				$iabusData['busrev_type'] = "ABR";

				$query = $this->generalmodel->add('iabusinessreview', $iabusData);

				$brst = $this->generalmodel->getSingleRowById('indassociation', 'ia_id', $row['ia_id'],'array');
				$brs = $brst['br_status']+1;
			
				$this->generalmodel->updaterecord('indassociation', array('br_status'=>$brs),array('ia_id'=>$row['ia_id']));
				}
		}

		public function updatebsabr(){
			$expirydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-1 year " ) );
			$this->db->like('busrev_duedate',$expirydate);
			$lic = $this->generalmodel->get_data_by_condition('busrev_id,lic_id,busrev_file','licbusinessreview',array('busrev_type'=>"ABR"));

			foreach ($lic as $row) {
				if($row['busrev_file']==''){
					$busData['busrev_duedate'] = date("Y-m-d H:i:s");
					$busData['busrev_status'] = 'Late';
					$busData['busrev_type'] = "ABR";
					$query = $this->generalmodel->updaterecord('licbusinessreview', $busData,array('busrev_id'=>$row['busrev_id']));

					$brst = $this->generalmodel->getSingleRowById('licensee', 'lic_id', $row['lic_id'],'array');
					if($brst['br_status']==11){
						$Data['lic_id'] = $row['lic_id'];
						$Data['busrev_title'] = date("F Y");
						$Data['busrev_duedate'] = date("Y-m-d H:i:s");
						$Data['busrev_status'] = 'Pending';
						$Data['busrev_type'] = "ABR";

						$query = $this->generalmodel->add('licbusinessreview', $Data);

						$brst = $this->generalmodel->getSingleRowById('licensee', 'lic_id', $row['lic_id'],'array');
						$brs = $brst['br_status']+1;
						
						$this->generalmodel->updaterecord('licensee', array('br_status'=>$brs),array('lic_id'=>$row['lic_id']));

					}
					// $brst = $this->generalmodel->get_data_by_condition('lic_id,br_status','licensee',array('lic_id'=>$row['lic_id']));
					
					$this->generalmodel->updaterecord('licensee', array('br_status'=>0),array('lic_id'=>$row['lic_id']));
				}
			}

			$this->db->like('busrev_duedate',$expirydate);
			$ia = $this->generalmodel->get_data_by_condition('busrev_id,ia_id,busrev_file','iabusinessreview',array('busrev_type'=>"ABR"));
			
			foreach ($ia as $row) {
				if($row['busrev_file']==''){
					$busData['busrev_duedate'] = date("Y-m-d H:i:s");
					$busData['busrev_status'] = 'Late';
					$busData['busrev_type'] = "ABR";
					$query = $this->generalmodel->updaterecord('iabusinessreview', $busData,array('busrev_id'=>$row['busrev_id']));

					$brst = $this->generalmodel->getSingleRowById('indassociation', 'ia_id', $row['ia_id'],'array');
					if($brst['br_status']==11){
						$Data['ia_id'] = $row['ia_id'];
						$Data['busrev_title'] = date("F Y");
						$Data['busrev_duedate'] = date("Y-m-d H:i:s");
						$Data['busrev_status'] = 'Pending';
						$Data['busrev_type'] = "ABR";

						$query = $this->generalmodel->add('iabusinessreview', $Data);

						$brst = $this->generalmodel->getSingleRowById('indassociation', 'ia_id', $row['ia_id'],'array');
						$brs = $brst['br_status']+1;
						
						$this->generalmodel->updaterecord('indassociation', array('br_status'=>$brs),array('ia_id'=>$row['ia_id']));

					}
					// $brst = $this->generalmodel->get_data_by_condition('lic_id,br_status','licensee',array('lic_id'=>$row['lic_id']));
					
					$this->generalmodel->updaterecord('licensee', array('br_status'=>0),array('lic_id'=>$row['lic_id']));
				}
			}
		}

		public function oneyear(){
			$this->genratebrabr();
			$this->updatebsabr();
		}

		public function onemonth(){
			$this->genratebr();
			$this->updatebsmbr();
		}

		public function threemonth(){
			$this->genratebrqbr();
			$this->updatebsqbr();
		}



}
