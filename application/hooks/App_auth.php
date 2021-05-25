<?php
if(!defined('BASEPATH'))    exit('No direct script access allowed');

class App_auth  {
	
	private $CI;
	private $controllerclass;
	private $methodCalled;
	public $customer_permission=array();

	public function __construct(){
		$this->CI = &get_instance();
	}
	public function index()
	{
 		$moduleCalled=$this->CI->router->fetch_module();
 		$controllerclass=$this->CI->router->fetch_class();
 		$methodCalled=$this->CI->router->fetch_method();
		$redirect = site_url('dashboard');

 		$cnt_mthd = $controllerclass.'/'.$methodCalled;

 		if($this->CI->session->userdata('userdata') =='' && $controllerclass !='authorize' && $controllerclass !='resetpass' && $controllerclass !='complianeticket'  && $controllerclass !='Cron') 	
		{
			//echo "in valid access";
			redirect(site_url('/'));
		}elseif(!empty($this->CI->session->userdata['userdata'])){
			$dept = $this->CI->session->userdata['userdata']['dept_id'];
			$urole = $this->CI->session->userdata['userdata']['urole_id'];
			$access = explode(',',$this->CI->session->userdata['userdata']['upermission']);


			//=======CTO======
				if($dept==2){

					if($urole==1){
						$modulerArr[0] = 'account';
						$modulerArr[1] = 'audience';				
						$modulerArr[2] = 'audit';				
						$modulerArr[3] = 'authorize';				
						$modulerArr[4] = 'business_review';
						$modulerArr[5] = 'complianeticket';
						$modulerArr[6] = 'consumer';
						$modulerArr[7] = 'dashboard';
						$modulerArr[8] = 'financial';
						$modulerArr[9] = 'industryassociation';
						$modulerArr[10] = 'kams';
						$modulerArr[11] = 'lead';
						$modulerArr[12] = 'licensee';
						$modulerArr[13] = 'marketing';
						$modulerArr[14] = 'product';
						$modulerArr[15] = 'reports';
						//$modulerArr[16] = 'shop';
						$modulerArr[17] = 'staff';
						$modulerArr[18] = 'supplier';
						$modulerArr[19] = 'template-manager';
						$modulerArr[20] = 'ticket';
						$modulerArr[21] = 'user';
						$modulerArr[22] = 'user_category';

						$contArr[0] = 'Disbursement';
						$contArr[1] = 'Reconciliation';
						$contArr[2] = 'Audience';
						$contArr[3] = 'Audit';
						$contArr[4] = 'Authorize';
						$contArr[5] = 'Resetpass';
						$contArr[6] = 'Business_review';
						$contArr[7] = 'Complianeticket';
						$contArr[8] = 'Whistleblower';
						$contArr[9] = 'Consumer';
						$contArr[10] = 'Ticket';
						$contArr[11] = 'Dashboard';
						$contArr[12] = 'Ia_dashboard';
						$contArr[13] = 'Lic_dashboard';
						$contArr[14] = 'Welcomee';
						$contArr[15] = 'Financial';
						$contArr[16] = 'Industryassociation';
						$contArr[17] = 'Kams';
						$contArr[18] = 'Kamsbyid';
						$contArr[19] = 'Business';
						$contArr[20] = 'Contact';
						$contArr[21] = 'Deal';
						$contArr[22] = 'Pipeline';
						$contArr[23] = 'Licensee';
						$contArr[24] = 'Licenseebyid';
						$contArr[25] = 'Marketing';
						$contArr[26] = 'Formtemplate';
						$contArr[27] = 'Product';
						$contArr[28] = 'reports';
						$contArr[29] = 'Shop';
						$contArr[30] = 'Staff';
						$contArr[31] = 'Supplier';
						$contArr[32] = 'Doc_manager';
						$contArr[33] = 'Email_manager';
						$contArr[34] = 'Ticket_account';
						$contArr[35] = 'Myprofile';
						$contArr[36] = 'User';

						//==restricted_controller_method ===// 
						$rcm =array();
						//$rcm[0] = 'ticket/addticket';
						$redirect = site_url('dashboard');

					}elseif($urole==2){
												
						$modulerArr[0] = 'account';
						$modulerArr[1] = 'audience';				
						$modulerArr[2] = 'audit';				
						$modulerArr[3] = 'authorize';				
						$modulerArr[4] = 'business_review';
						$modulerArr[5] = 'complianeticket';
						$modulerArr[6] = 'consumer';
						$modulerArr[7] = 'dashboard';
						$modulerArr[8] = 'financial';
						$modulerArr[9] = 'industryassociation';
						$modulerArr[10] = 'kams';
						$modulerArr[11] = 'lead';
						$modulerArr[12] = 'licensee';
						$modulerArr[13] = 'marketing';
						$modulerArr[14] = 'product';
						$modulerArr[15] = 'reports';
						//$modulerArr[16] = 'shop';
						$modulerArr[17] = 'staff';
						$modulerArr[18] = 'supplier';
						$modulerArr[19] = 'template-manager';
						$modulerArr[20] = 'ticket';
						$modulerArr[21] = 'user';
						$modulerArr[22] = 'user_category';

						$contArr[0] = 'Disbursement';
						$contArr[1] = 'Reconciliation';
						$contArr[2] = 'Audience';
						$contArr[3] = 'Audit';
						$contArr[4] = 'Authorize';
						$contArr[5] = 'Resetpass';
						$contArr[6] = 'Business_review';
						$contArr[7] = 'Complianeticket';
						$contArr[8] = 'Whistleblower';
						$contArr[9] = 'Consumer';
						$contArr[10] = 'Ticket';
						$contArr[11] = 'Dashboard';
						$contArr[12] = 'Ia_dashboard';
						$contArr[13] = 'Lic_dashboard';
						$contArr[14] = 'Welcomee';
						$contArr[15] = 'Financial';
						$contArr[16] = 'Industryassociation';
						$contArr[17] = 'Kams';
						$contArr[18] = 'Kamsbyid';
						$contArr[19] = 'Business';
						$contArr[20] = 'Contact';
						$contArr[21] = 'Deal';
						$contArr[22] = 'Pipeline';
						$contArr[23] = 'Licensee';
						$contArr[24] = 'Licenseebyid';
						$contArr[25] = 'Marketing';
						$contArr[26] = 'Formtemplate';
						$contArr[27] = 'Product';
						$contArr[28] = 'reports';
						$contArr[29] = 'Shop';
						$contArr[30] = 'Staff';
						$contArr[31] = 'Supplier';
						$contArr[32] = 'Doc_manager';
						$contArr[33] = 'Email_manager';
						$contArr[34] = 'Ticket_account';
						$contArr[35] = 'Myprofile';
						$contArr[36] = 'User';

						//==restricted_controller_method ===// 
						$rcm =array();
						//$rcm[0] = 'ticket/addticket';
						
						$redirect = site_url('lic-dashboard');

					}elseif($urole==3){
												
						$modulerArr[0] = 'account';
						$modulerArr[1] = 'audience';				
						$modulerArr[2] = 'audit';				
						$modulerArr[3] = 'authorize';				
						$modulerArr[4] = 'business_review';
						$modulerArr[5] = 'complianeticket';
						$modulerArr[6] = 'consumer';
						$modulerArr[7] = 'dashboard';
						$modulerArr[8] = 'financial';
						$modulerArr[9] = 'industryassociation';
						$modulerArr[10] = 'kams';
						$modulerArr[11] = 'lead';
						$modulerArr[12] = 'licensee';
						$modulerArr[13] = 'marketing';
						$modulerArr[14] = 'product';
						$modulerArr[15] = 'reports';
						//$modulerArr[16] = 'shop';
						$modulerArr[17] = 'staff';
						$modulerArr[18] = 'supplier';
						$modulerArr[19] = 'template-manager';
						$modulerArr[20] = 'ticket';
						$modulerArr[21] = 'user';
						$modulerArr[22] = 'user_category';

						$contArr[0] = 'Disbursement';
						$contArr[1] = 'Reconciliation';
						$contArr[2] = 'Audience';
						$contArr[3] = 'Audit';
						$contArr[4] = 'Authorize';
						$contArr[5] = 'Resetpass';
						$contArr[6] = 'Business_review';
						$contArr[7] = 'Complianeticket';
						$contArr[8] = 'Whistleblower';
						$contArr[9] = 'Consumer';
						$contArr[10] = 'Ticket';
						$contArr[11] = 'Dashboard';
						$contArr[12] = 'Ia_dashboard';
						$contArr[13] = 'Lic_dashboard';
						$contArr[14] = 'Welcomee';
						$contArr[15] = 'Financial';
						$contArr[16] = 'Industryassociation';
						$contArr[17] = 'Kams';
						$contArr[18] = 'Kamsbyid';
						$contArr[19] = 'Business';
						$contArr[20] = 'Contact';
						$contArr[21] = 'Deal';
						$contArr[22] = 'Pipeline';
						$contArr[23] = 'Licensee';
						$contArr[24] = 'Licenseebyid';
						$contArr[25] = 'Marketing';
						$contArr[26] = 'Formtemplate';
						$contArr[27] = 'Product';
						$contArr[28] = 'reports';
						$contArr[29] = 'Shop';
						$contArr[30] = 'Staff';
						$contArr[31] = 'Supplier';
						$contArr[32] = 'Doc_manager';
						$contArr[33] = 'Email_manager';
						$contArr[34] = 'Ticket_account';
						$contArr[35] = 'Myprofile';
						$contArr[36] = 'User';

						//==restricted_controller_method ===// 
						$rcm =array();
						//$rcm[0] = 'ticket/addticket';

						$redirect = site_url('ia-dashboard');
					}
					if(!in_array($moduleCalled,$modulerArr)){ redirect($redirect);}
					elseif(in_array($cnt_mthd,$rcm)){ redirect($redirect); }

				}	
			//=======CTO======
			//=======IT======
				//=======ETA CTO======
				if($dept==10){

					if($urole==1){
						$modulerArr[0] = 'account';
						$modulerArr[1] = 'audience';				
						$modulerArr[2] = 'audit';				
						$modulerArr[3] = 'authorize';				
						$modulerArr[4] = 'business_review';
						$modulerArr[5] = 'complianeticket';
						$modulerArr[6] = 'consumer';
						$modulerArr[7] = 'dashboard';
						$modulerArr[8] = 'financial';
						$modulerArr[9] = 'industryassociation';
						$modulerArr[10] = 'kams';
						$modulerArr[11] = 'lead';
						$modulerArr[12] = 'licensee';
						$modulerArr[13] = 'marketing';
						$modulerArr[14] = 'product';
						$modulerArr[15] = 'reports';
						//$modulerArr[16] = 'shop';
						$modulerArr[17] = 'staff';
						$modulerArr[18] = 'supplier';
						$modulerArr[19] = 'template-manager';
						$modulerArr[20] = 'ticket';
						$modulerArr[21] = 'user';
						$modulerArr[22] = 'user_category';

						$contArr[0] = 'Disbursement';
						$contArr[1] = 'Reconciliation';
						$contArr[2] = 'Audience';
						$contArr[3] = 'Audit';
						$contArr[4] = 'Authorize';
						$contArr[5] = 'Resetpass';
						$contArr[6] = 'Business_review';
						$contArr[7] = 'Complianeticket';
						$contArr[8] = 'Whistleblower';
						$contArr[9] = 'Consumer';
						$contArr[10] = 'Ticket';
						$contArr[11] = 'Dashboard';
						$contArr[12] = 'Ia_dashboard';
						$contArr[13] = 'Lic_dashboard';
						$contArr[14] = 'Welcomee';
						$contArr[15] = 'Financial';
						$contArr[16] = 'Industryassociation';
						$contArr[17] = 'Kams';
						$contArr[18] = 'Kamsbyid';
						$contArr[19] = 'Business';
						$contArr[20] = 'Contact';
						$contArr[21] = 'Deal';
						$contArr[22] = 'Pipeline';
						$contArr[23] = 'Licensee';
						$contArr[24] = 'Licenseebyid';
						$contArr[25] = 'Marketing';
						$contArr[26] = 'Formtemplate';
						$contArr[27] = 'Product';
						$contArr[28] = 'reports';
						$contArr[29] = 'Shop';
						$contArr[30] = 'Staff';
						$contArr[31] = 'Supplier';
						$contArr[32] = 'Doc_manager';
						$contArr[33] = 'Email_manager';
						$contArr[34] = 'Ticket_account';
						$contArr[35] = 'Myprofile';
						$contArr[36] = 'User';

						//==restricted_controller_method ===// 
						$rcm =array();
						//$rcm[0] = 'ticket/addticket';
						$redirect = site_url('dashboard');

					}elseif($urole==2){
												
						$modulerArr[0] = 'account';
						$modulerArr[1] = 'audience';				
						$modulerArr[2] = 'audit';				
						$modulerArr[3] = 'authorize';				
						$modulerArr[4] = 'business_review';
						$modulerArr[5] = 'complianeticket';
						$modulerArr[6] = 'consumer';
						$modulerArr[7] = 'dashboard';
						$modulerArr[8] = 'financial';
						$modulerArr[9] = 'industryassociation';
						$modulerArr[10] = 'kams';
						$modulerArr[11] = 'lead';
						$modulerArr[12] = 'licensee';
						$modulerArr[13] = 'marketing';
						$modulerArr[14] = 'product';
						$modulerArr[15] = 'reports';
						//$modulerArr[16] = 'shop';
						$modulerArr[17] = 'staff';
						$modulerArr[18] = 'supplier';
						$modulerArr[19] = 'template-manager';
						$modulerArr[20] = 'ticket';
						$modulerArr[21] = 'user';
						$modulerArr[22] = 'user_category';

						$contArr[0] = 'Disbursement';
						$contArr[1] = 'Reconciliation';
						$contArr[2] = 'Audience';
						$contArr[3] = 'Audit';
						$contArr[4] = 'Authorize';
						$contArr[5] = 'Resetpass';
						$contArr[6] = 'Business_review';
						$contArr[7] = 'Complianeticket';
						$contArr[8] = 'Whistleblower';
						$contArr[9] = 'Consumer';
						$contArr[10] = 'Ticket';
						$contArr[11] = 'Dashboard';
						$contArr[12] = 'Ia_dashboard';
						$contArr[13] = 'Lic_dashboard';
						$contArr[14] = 'Welcomee';
						$contArr[15] = 'Financial';
						$contArr[16] = 'Industryassociation';
						$contArr[17] = 'Kams';
						$contArr[18] = 'Kamsbyid';
						$contArr[19] = 'Business';
						$contArr[20] = 'Contact';
						$contArr[21] = 'Deal';
						$contArr[22] = 'Pipeline';
						$contArr[23] = 'Licensee';
						$contArr[24] = 'Licenseebyid';
						$contArr[25] = 'Marketing';
						$contArr[26] = 'Formtemplate';
						$contArr[27] = 'Product';
						$contArr[28] = 'reports';
						$contArr[29] = 'Shop';
						$contArr[30] = 'Staff';
						$contArr[31] = 'Supplier';
						$contArr[32] = 'Doc_manager';
						$contArr[33] = 'Email_manager';
						$contArr[34] = 'Ticket_account';
						$contArr[35] = 'Myprofile';
						$contArr[36] = 'User';

						//==restricted_controller_method ===// 
						$rcm =array();
						//$rcm[0] = 'ticket/addticket';
						
						$redirect = site_url('lic-dashboard');

					}elseif($urole==3){
												
						$modulerArr[0] = 'account';
						$modulerArr[1] = 'audience';				
						$modulerArr[2] = 'audit';				
						$modulerArr[3] = 'authorize';				
						$modulerArr[4] = 'business_review';
						$modulerArr[5] = 'complianeticket';
						$modulerArr[6] = 'consumer';
						$modulerArr[7] = 'dashboard';
						$modulerArr[8] = 'financial';
						$modulerArr[9] = 'industryassociation';
						$modulerArr[10] = 'kams';
						$modulerArr[11] = 'lead';
						$modulerArr[12] = 'licensee';
						$modulerArr[13] = 'marketing';
						$modulerArr[14] = 'product';
						$modulerArr[15] = 'reports';
						//$modulerArr[16] = 'shop';
						$modulerArr[17] = 'staff';
						$modulerArr[18] = 'supplier';
						$modulerArr[19] = 'template-manager';
						$modulerArr[20] = 'ticket';
						$modulerArr[21] = 'user';
						$modulerArr[22] = 'user_category';

						$contArr[0] = 'Disbursement';
						$contArr[1] = 'Reconciliation';
						$contArr[2] = 'Audience';
						$contArr[3] = 'Audit';
						$contArr[4] = 'Authorize';
						$contArr[5] = 'Resetpass';
						$contArr[6] = 'Business_review';
						$contArr[7] = 'Complianeticket';
						$contArr[8] = 'Whistleblower';
						$contArr[9] = 'Consumer';
						$contArr[10] = 'Ticket';
						$contArr[11] = 'Dashboard';
						$contArr[12] = 'Ia_dashboard';
						$contArr[13] = 'Lic_dashboard';
						$contArr[14] = 'Welcomee';
						$contArr[15] = 'Financial';
						$contArr[16] = 'Industryassociation';
						$contArr[17] = 'Kams';
						$contArr[18] = 'Kamsbyid';
						$contArr[19] = 'Business';
						$contArr[20] = 'Contact';
						$contArr[21] = 'Deal';
						$contArr[22] = 'Pipeline';
						$contArr[23] = 'Licensee';
						$contArr[24] = 'Licenseebyid';
						$contArr[25] = 'Marketing';
						$contArr[26] = 'Formtemplate';
						$contArr[27] = 'Product';
						$contArr[28] = 'reports';
						$contArr[29] = 'Shop';
						$contArr[30] = 'Staff';
						$contArr[31] = 'Supplier';
						$contArr[32] = 'Doc_manager';
						$contArr[33] = 'Email_manager';
						$contArr[34] = 'Ticket_account';
						$contArr[35] = 'Myprofile';
						$contArr[36] = 'User';

						//==restricted_controller_method ===// 
						$rcm =array();
						//$rcm[0] = 'ticket/addticket';

						$redirect = site_url('ia-dashboard');
					}
		
					if(!in_array($moduleCalled,$modulerArr)){ redirect($redirect);}
					elseif(in_array($cnt_mthd,$rcm)){ redirect($redirect); }

				}					
			//=======IT======
			//=======Accounts======
			if($dept==3){
								
				$modulerArr[0] = 'authorize';				
				$modulerArr[1] = 'user';
				$modulerArr[2] = 'reports';
				$modulerArr[3] = 'complianeticket';
				$modulerArr[4] = 'dashboard';
				$modulerArr[5] = 'licensee';
				$modulerArr[6] = 'industryassociation';
				$modulerArr[7] = 'consumer';
				$modulerArr[8] = 'ticket';

				$redirect = site_url('dashboard');
				if(!in_array($moduleCalled,$modulerArr)){ redirect($redirect);}
			}	

			//=======Accounts======

			//=======CSR======
			if($dept==4){
								
				$modulerArr[0] = 'authorize';				
				$modulerArr[1] = 'user';
				$modulerArr[2] = 'reports';
				$modulerArr[3] = 'complianeticket';
				$modulerArr[4] = 'audit';
				$modulerArr[5] = 'licensee';
				$modulerArr[6] = 'industryassociation';
				$modulerArr[7] = 'consumer';
				$modulerArr[8] = 'ticket';
				$modulerArr[9] = 'product';
				$modulerArr[10] = 'dashboard';

//echo $moduleCalled; exit;

				$redirect = site_url('dashboard');
				if(!in_array($moduleCalled,$modulerArr)){ redirect($redirect);}
			}	

			//=======CSR======


			//=======KAM======
			if($dept==5){
				//==Kam edit =>business_review,only consumer form,csr edit
				//==Kam view only=>complianeticket except suppliers,financial,industryassociation,compliance only view ticket category

				$modulerArr[0] = 'authorize';				
				$modulerArr[1] = 'user';
				$modulerArr[2] = 'reports';
				$modulerArr[3] = 'complianeticket';
				$modulerArr[4] = 'audit';
				$modulerArr[5] = 'licensee';
				$modulerArr[6] = 'industryassociation';
				$modulerArr[7] = 'consumer';
				$modulerArr[8] = 'ticket';
				$modulerArr[9] = 'product';
				$modulerArr[10] = 'dashboard';

				$modulerArr[11] = 'account';
				$modulerArr[12] = 'business_review';
				$modulerArr[13] = 'financial';
				$modulerArr[14] = 'kams';
				$modulerArr[15] = 'user_category';
				$modulerArr[16] = 'staff';
				$redirect = site_url('dashboard');
				if(!in_array($moduleCalled,$modulerArr)){ redirect($redirect);}
			}	
			//=======KAM======

			//=======Compliance officer======
			if($dept==7){
				$modulerArr[0] = 'authorize';				
				$modulerArr[1] = 'user';
				$modulerArr[2] = 'reports';
				$modulerArr[3] = 'complianeticket';
				$modulerArr[4] = 'audit';
				$modulerArr[5] = 'licensee';
				$modulerArr[6] = 'industryassociation';
				$modulerArr[7] = 'consumer';
				$modulerArr[8] = 'ticket';
				$modulerArr[9] = 'product';
				$modulerArr[10] = 'dashboard';
				$modulerArr[11] = 'supplier';
				$modulerArr[12] = 'marketing';
				$modulerArr[13] = 'business_review';
				$redirect = site_url('dashboard');
				if(!in_array($moduleCalled,$modulerArr)){ redirect($redirect);}
			}				
			//=======Compliance officer======
			//=======Product manager======

			if($dept==8){
				$modulerArr[0] = 'authorize';				
				$modulerArr[1] = 'user';
				$modulerArr[2] = 'audit';
				$modulerArr[3] = 'lead';
				$modulerArr[4] = 'complianeticket';
				$modulerArr[5] = 'licensee';
				$modulerArr[6] = 'industryassociation';
				$modulerArr[7] = 'supplier';
				$modulerArr[8] = 'product';
				$modulerArr[9] = 'ticket';
				$modulerArr[10] = 'consumer';
				$modulerArr[11] = 'supplier';
				$modulerArr[12] = 'dashboard';
				$modulerArr[13] = 'reports';

				$redirect = site_url('dashboard');
				if(!in_array($moduleCalled,$modulerArr)){ redirect($redirect);}
			}
			//=======Product manager======

			//=======Marketing======

			if($dept==9){
				$modulerArr[0] = 'authorize';				
				$modulerArr[1] = 'user';
				$modulerArr[2] = 'audit';
				$modulerArr[3] = 'lead';
				$modulerArr[4] = 'complianeticket';
				$modulerArr[5] = 'licensee';
				$modulerArr[6] = 'industryassociation';
				$modulerArr[7] = 'supplier';
				$modulerArr[8] = 'product';
				$modulerArr[9] = 'ticket';
				$modulerArr[10] = 'dashboard';
				$modulerArr[11] = 'marketing';
				$modulerArr[12] = 'consumer';
				$modulerArr[13] = 'audience';


				$methodArr[0] = 'consumer/addnew';

				if(!in_array($moduleCalled,$modulerArr)){ redirect($redirect);}
				elseif(in_array($cnt_mthd,$methodArr)){ redirect($redirect);}
			}
			//=======Product manager======

			/*
			//=======LIC======
			if($urole==2){
				$modulerArr[0] = 'account';
				$modulerArr[1] = 'audience';				
				$modulerArr[2] = 'audit';				
				$modulerArr[3] = 'authorize';				
				$modulerArr[4] = 'business_review';
				$modulerArr[5] = 'complianeticket';
				$modulerArr[6] = 'consumer';
				$modulerArr[7] = 'dashboard';
				$modulerArr[8] = 'financial';
				$modulerArr[9] = 'industryassociation';
				$modulerArr[10] = 'kams';
				$modulerArr[11] = 'lead';
				$modulerArr[12] = 'licensee';
				$modulerArr[13] = 'marketing';
				$modulerArr[14] = 'product';
				$modulerArr[15] = 'reports';
				$modulerArr[17] = 'staff';
				//$modulerArr[18] = 'supplier';
				//$modulerArr[19] = 'template-manager';
				$modulerArr[20] = 'ticket';
				$modulerArr[21] = 'user';
				//$modulerArr[22] = 'user_category';


				$restricted_controller_method = $rcm =array();
				$rcm[0] = 'consumer/addnew';
				$rcm[1] = 'consumer/editconsumer';
				$rcm[2] = 'consumer/deleteconsumer';
				$rcm[3] = 'consumer/export';
				$rcm[4] = 'audit/addaudit';
				$rcm[5] = 'audit/editaudit';

				if(!in_array($moduleCalled,$modulerArr)){ 
					redirect(site_url('audit/audit'));
				}
				// elseif(in_array($cnt_mthd,$rcm)){ redirect(site_url('shop')); }
				//elseif(in_array($controllerclass,$controllerArr)){ redirect(site_url('shop')); }
				// elseif(!in_array($methodCalled,$c_methodArr)){ redirect(site_url('shop')); }

			}	

			//=======IA======
			if($urole==3){
				$modulerArr[0] = 'account';
				$modulerArr[1] = 'audience';				
				$modulerArr[2] = 'audit';				
				$modulerArr[3] = 'authorize';				
				$modulerArr[4] = 'business_review';
				$modulerArr[5] = 'complianeticket';
				$modulerArr[6] = 'consumer';
				$modulerArr[7] = 'dashboard';
				$modulerArr[8] = 'financial';
				$modulerArr[9] = 'industryassociation';
				$modulerArr[10] = 'kams';
				$modulerArr[11] = 'lead';
				$modulerArr[12] = 'licensee';
				$modulerArr[13] = 'marketing';
				$modulerArr[14] = 'product';
				$modulerArr[15] = 'reports';
				$modulerArr[17] = 'staff';
				//$modulerArr[18] = 'supplier';
				//$modulerArr[19] = 'template-manager';
				$modulerArr[20] = 'ticket';
				$modulerArr[21] = 'user';
				//$modulerArr[22] = 'user_category';

				$restricted_controller_method = $rcm =array();
				$rcm[0] = 'consumer/addnew';
				$rcm[1] = 'consumer/editconsumer';
				$rcm[2] = 'consumer/deleteconsumer';
				$rcm[3] = 'consumer/export';
				$rcm[4] = 'audit/addaudit';
				$rcm[5] = 'audit/editaudit';

				if(!in_array($moduleCalled,$modulerArr)){ 
					redirect(site_url('audit/audit'));
				}
				// elseif(in_array($cnt_mthd,$rcm)){ redirect(site_url('shop')); }
				//elseif(in_array($controllerclass,$controllerArr)){ redirect(site_url('shop')); }
				// elseif(!in_array($methodCalled,$c_methodArr)){ redirect(site_url('shop')); }

			}
			*/



			//==ETA & LIC bde==
			if(($urole==1 || $urole==2 ) && $dept==11){

				$modulerArr[0] = 'authorize';				
				$modulerArr[1] = 'user';
				$modulerArr[2] = 'dashboard';
				$modulerArr[3] = 'lead';
				$modulerArr[4] = 'complianeticket';
				$modulerArr[5] = 'ticket';

				if(!in_array($moduleCalled,$modulerArr)){ redirect(site_url('lead/deal'));}

			}		
			//==all level bde==

			// print_r($urole);
			// print_r($dept);
			// exit;
			if($urole==3 && $dept==11){
								
				$modulerArr[0] = 'authorize';				
				$modulerArr[1] = 'user';
				$modulerArr[2] = 'audit';
				$modulerArr[3] = 'lead';
				$modulerArr[4] = 'complianeticket';
				$modulerArr[5] = 'ticket';
				$modulerArr[6] = 'dashboard';

				if(!in_array($moduleCalled,$modulerArr)){ redirect(site_url('lead/deal'));}
			}	

			//=======CONSUMER START ======
			
			if($urole==4){

				$modulerArr[0] = 'authorize';
				$modulerArr[1] = 'consumer';
				$modulerArr[2] = 'shop';
				$modulerArr[3] = 'user';
				$modulerArr[4] = 'audit';
				$modulerArr[5] = 'complianeticket';
				$modulerArr[6] = 'licensee';

				$restricted_controller_method = $rcm =array();
				$rcm[0] = 'consumer/addnew';
				$rcm[1] = 'consumer/editconsumer';
				$rcm[2] = 'consumer/deleteconsumer';
				$rcm[3] = 'consumer/export';
				$rcm[4] = 'audit/addaudit';
				$rcm[5] = 'audit/editaudit';

				if(!in_array($moduleCalled,$modulerArr)){ redirect(site_url('shop'));}
				elseif(in_array($cnt_mthd,$rcm)){ redirect(site_url('shop')); }
			}
			

			//=======CONSUMER END ======

			//=======Supplier======
			if($urole==5){
		
				$modulerArr[0] = 'authorize';
				$modulerArr[1] = 'user';
				$modulerArr[2] = 'audit';
				$modulerArr[3] = 'supplier';

				$restricted_controller_method = $rcm =array();
				// $rcm[0] = 'consumer/addnew';
				// $rcm[1] = 'consumer/editconsumer';
				// $rcm[2] = 'consumer/deleteconsumer';
				// $rcm[3] = 'consumer/export';
				// $rcm[4] = 'audit/addaudit';
				// $rcm[5] = 'audit/editaudit';
				// $rcm[6] = 'complianeticket';

				//echo $moduleCalled; exit;

				if(!in_array($moduleCalled,$modulerArr)){ 
					redirect(site_url('audit/audit'));
				}
			}				
		}
	}
	
}
