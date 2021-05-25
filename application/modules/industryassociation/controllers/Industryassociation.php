<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH. 'third_party/Spout/Autoloader/autoload.php';
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;

use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;
class Industryassociation extends MY_Controller {

	public function __construct(){
		parent::__construct();
        $this->userdata = $this->session->userdata('userdata');
        $this->load->model('indus_model');
	}
	public function index()
	{
        $data['meta_title'] = "Industry Association";
		$this->load->view('industryassociation/industry_associations_detail',$data);
	}

    public function industryassociation($id)
    {
        $id = decoding($id);
        $select = array('b.user_id','m.ia_id','m.ia_resource_id','m.category','m.ia_lic_number','m.ia_lic_startdate','m.ia_lic_enddate','b.firstname','b.lastname','m.business_name','b.dept_id','b.country','b.email','b.contactno','m.ia_profilepicture','b.profilepicture');
        $data['ia']=$this->generalmodel->getsingleJoinData($select,'indassociation as m','user as b','m.user_id = b.user_id','m.user_id='.$id);
        $data['iaid'] = $id;
        $data['meta_title'] = "View Industry Association";
        $this->session->set_userdata('iaid',$id);
        $this->load->view('industryassociation/industry_associations_detail',$data);
    }

	public function viewia()
	{
        $data['meta_title'] = "Industry Association";
		$this->load->view('industryassociation/viewia',$data);
	}

    public function viewlicia()
    {
        $data['meta_title'] = "Industry Association";
        $this->load->view('industryassociation/viewlicia',$data);
    }

    public function ajax()
    {
        
        $userid =$this->userdata['user_id'];
        $perms=explode(",",$this->userdata['upermission']);
        $createdby=$this->userdata['createdby'];
        $datatables = new Datatables(new CodeigniterAdapter);
        if(!empty($this->session->userdata['licenseeid']))
        {
            $id=$this->session->userdata['licenseeid'];    
            if ($this->userdata['urole_id']==1 || $this->userdata['urole_id']==2)
            $datatables->query('SELECT m.ia_resource_id,m.business_name,m.ia_lic_number,c.user_cat_name,CONCAT(b.firstname," ",b.lastname) as fullname,b.email,m.ia_lic_enddate,m.user_id,m.ia_id FROM indassociation as m LEFT JOIN user as b ON m.user_id = b.user_id LEFT JOIN user_category as c ON m.category = c.user_cat_id  WHERE b.status !="0" and b.createdby="'.$id.'"');
        }else{
          //if($this->userdata['urole_id']==1 || $this->userdata['urole_id']==2)
          if($this->userdata['urole_id']==1 || $this->userdata['urole_id']==2)
          	if($this->userdata['dept_id']==5 || $this->userdata['dept_id']==4){
            	$datatables->query('SELECT m.ia_resource_id,m.business_name,m.ia_lic_number,c.user_cat_name,CONCAT(b.firstname," ",b.lastname) as fullname,b.email,m.ia_lic_enddate,m.user_id,m.ia_id FROM indassociation as m LEFT JOIN user as b ON m.user_id = b.user_id LEFT JOIN user_category as c ON m.category = c.user_cat_id  WHERE b.status !="0" and m.assign_to="'.$userid.'"');

          	}else{
            	$datatables->query('SELECT m.ia_resource_id,m.business_name,m.ia_lic_number,c.user_cat_name,CONCAT(b.firstname," ",b.lastname) as fullname,b.email,m.ia_lic_enddate,m.user_id,m.ia_id FROM indassociation as m LEFT JOIN user as b ON m.user_id = b.user_id LEFT JOIN user_category as c ON m.category = c.user_cat_id  WHERE b.status !="0" ');

          	}
          else
            $datatables->query('SELECT m.ia_resource_id,m.business_name,m.ia_lic_number,c.user_cat_name,CONCAT(b.firstname," ",b.lastname) as fullname,b.email,m.ia_lic_enddate,m.user_id,m.ia_id FROM indassociation as m LEFT JOIN user as b ON m.user_id = b.user_id LEFT JOIN user_category as c ON m.category = c.user_cat_id  WHERE b.status !="0" and b.createdby="'.$userid.'"');
        }

        $datatables->edit('ia_lic_enddate', function ($data) {
                     $localtimzone =$this->userdata['timezone'];
                    $lic_enddate = gmdate_to_mydate($data['ia_lic_enddate'],$localtimzone);
                    return date('m/d/Y',strtotime($lic_enddate));
            // return date('m/d/Y',strtotime($data['ia_lic_enddate']));
        });
                // // edit 'id' column
                $datatables->edit('user_id', function($data) use($perms){
                    $uid = encoding($data['user_id']);
                        $menu='';
                        if(in_array('IA_VD',$perms)){
                            $menu.='<li>
                            <a href="'.site_url().'industryassociation/industryassociation/industryassociation/'.$uid.'">
                                <span class="glyphicon glyphicon-eye-open"></span> View
                            </a>
                            </li>';
                        }

                        if(in_array('IA_E',$perms)){
                            $menu.='<li>
                            <a href="'.site_url().'industryassociation/industryassociation/editia/'.$uid.'">
                                <span class="glyphicon glyphicon-pencil"></span> Edit
                            </a>
                            </li>';
                        }

                        if(in_array('IA_PROD_VD',$perms)){
                            $menu.='<li>
                            <a href="'.site_url().'product/productassignia/'.$data['ia_id'].'">
                                <span class="glyphicon glyphicon-eye-open"></span> Product
                            </a>
                            </li>';
                        }

                        if(in_array('IA_D',$perms)){
                            $menu.='<li>
                            <a  href="javascript:void(0)" class="deleteEntry" link="'.site_url().'industryassociation/Industryassociation/deleteia/'.$uid.'" >
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

    public function addia($dealid=''){
        if(!empty($dealid)){ $dealid = decoding($dealid); }
        if(!empty($this->input->post()) && $this->input->is_ajax_request()){

            if($this->form_validation->run('add_ia')){
                
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
                $assign_date = $createddate = $updatedate = date('Y-m-d h:i:s');
                $createdby = $this->userdata['user_id'];
                $mylevel = $this->userdata['user_level'];

                $resource_id =  resource_id('IA');
                $assign_to = $this->input->post('assign_to');

                $urole_id = 3;

                $lic_number = $this->input->post('lic_number');
                $lic_startdate = get_ymd_format($this->input->post('lic_startdate'));
                $lic_enddate = get_ymd_format($this->input->post('lic_enddate'));
                if(!compare_dates($lic_startdate,$lic_enddate)){
                    $return = array('success'=>false,'msg'=>'Please add correct start and end dates');
                    echo json_encode($return); exit;
                }

                $firstname = $this->input->post('firstname');
                $lastname = $this->input->post('lastname');
                $ia_country = $this->input->post('ia_country');
                $email = $this->input->post('email');
                $contactno = $this->input->post('phone');
                $phonecods = $this->input->post('phonecods');
                $timezone = $this->input->post('timezone');

                $finalnum = validatePhone($contactno,$phonecods);
                if(!empty($contactno) && $finalnum==false){
                    $return = array('success'=>false,'msg'=>"Invalid Phone number for this country");
                    echo json_encode($return); exit;
                }else{
                    $contactno = $finalnum;
                }

                $business_name = $this->input->post('business_name');

                //==========move from temp to actual location start=====//
                $cto_profilepicture = $this->input->post('cto_profilepicture_h');
                $profilepicture = $this->input->post('profilepicture_h');


                //==========move from temp to actual location end=====//


                //=========Add user start =========//

                $userData['resource_id'] = $resource_id;
                $userData['firstname'] = $firstname;
                $userData['lastname'] = $lastname;
                $userData['profilepicture'] = $cto_profilepicture;
                $userData['dept_id'] =  '2';
                $userData['urole_id'] = '3';
                $userData['user_level'] = $this->userdata['urole_id'];
                $userData['country'] = $ia_country;
                $userData['email'] = $email;
                $userData['contactno'] = $contactno;
                $userData['createdate'] = $createddate;
                $userData['createdby'] = $createdby;
                $userData['updatedate'] = $updatedate;
                $userData['password'] = $enc_pass;
                $userData['status'] = '1';
                $userData['assign_to'] = $assign_to;
                $userData['timezone'] = $timezone;


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
                        $state = $this->input->post('state');

                        $busData['business_name'] = $business_name;
                        $busData['business_street1'] = $address;
                        $busData['business_suburb'] = $suburb;
                        $busData['business_postalcode'] = $postcode;
                        $busData['business_country'] = $bcountry;
                        $busData['business_state'] = $state;
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

                //=========Add licensee start=========//
                $category_name = $this->input->post('category');
                $licData['ia_resource_id'] = $resource_id;
                $licData['assign_to'] = $assign_to;
                $licData['assign_date'] = $assign_date;             

                $licData['ia_lic_number'] = $lic_number;
                $licData['ia_lic_startdate'] = $lic_startdate;
                $licData['ia_lic_enddate'] = $lic_enddate;
                $licData['ia_country'] = $ia_country;
                $licData['ia_profilepicture'] = $profilepicture;
                $licData['createdby'] = $createdby;
                $licData['createddate'] = $createddate;
                $licData['ipaddress'] = $ip_address;
                $licData['platform'] = $platform;
                $licData['browser'] = $browser;
                $licData['business_name'] = $business_name;
                $licData['status'] = '1';
                $licData['category'] = $category_name;

                $query = $this->indus_model->add_ia($userData,$licData,$busData,$dealid);
                if(!empty($query)){

                    if(!empty($cto_profilepicture)){
                        $src ='./tmp_upload/'.$cto_profilepicture;
                        $destination= './uploads/cto_profile/'.$cto_profilepicture;
                        rename($src, $destination);     
                    }

                    if(!empty($profilepicture)){
                        $src ='./tmp_upload/'.$profilepicture;
                        $destination= './uploads/ia_profile/'.$profilepicture;
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
                            $content = str_replace('[user_type]',"Industry Association",$content);
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
                            $content1 = str_replace('[user_type]',"Industry Association",$content1);
                            $content1 = str_replace('[email]',$email,$content1); 
                            $content1 = str_replace('[password]',$password,$content1); 
                            $content1 = str_replace('[link]',$loginlink,$content1); 

                            $subject1 = $mailContentN['email_subject'];
                            $subject1 = str_replace('[cto_name]',$name,$subject1);
                            $subject1 = str_replace('[company_name]',$business_name,$subject1);
                            
                            $message1 = $this->load->view('include/mail_template',array('body'=>$content1),true);
                            
                            $mailresponce = $this->sendGridMail('',$touser,$subject1,$message1);

                    /*****************************************************************************/ 
                                    
                    $return = array('success'=>true,'msg'=>'Industrial Association addedd successfully','resource_id'=>$resource_id);
                }else{
                    $return = array('success'=>false,'msg'=>'something went wrong');
                }
            }else{
                $return = array('success'=>false,'msg'=>validation_errors());
            }
            echo json_encode($return); exit;
        }else{
            if(!empty($dealid)){
                $data['businessData']= $this->generalmodel->get_Dealbusiness($dealid);
            }            
            $data['deptlist'] = $this->generalmodel->deptlist();
            $data['countrylist'] = $this->generalmodel->countrylist();
            $data['categorylist'] = $this->generalmodel->iacategorylist();
            $data['kam_list'] = $this->generalmodel->kam_list();
            $data['meta_title'] = "Add Industry Association";
            $this->load->view('addIndustry',$data);
        }
    }
    

    public function busList(){

        $response=array();
        if ($this->input->is_ajax_request()) {
            if(isset($_POST['term'])){
                
                $term=$this->input->post('term');
                if(!empty($this->input->post('id'))){ $id=$this->input->post('id'); }else{ $id=""; }

                $result=$this->indus_model->ia_bus_suggession($term,$id);

                $resultData='';
                $recordFound=0;
                if(!empty($result)){
                    foreach($result as $cr){
                        $resultData.='<li class="ia_busItem list-group-item" data-val="'.$cr['business_id'].'">'.$cr['business_name'].'</li>';
                    }
                    $response['status']='success';
                    $response['data']=$resultData;
                }else{
                    $response['status']='fail';
                }
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
    
    public function editia($id)
    {
        $id = decoding($id);
        if(!empty($this->input->post()) && $this->input->is_ajax_request()){
            if($this->form_validation->run('edit_ia')){
                
                $updatedate = date('Y-m-d h:i:s');               
                $assign_to = $this->input->post('assign_to');

               
                $ip_address = $this->input->ip_address();
                $lic_number = $this->input->post('lic_number');
               
               
                $lic_startdate = get_ymd_format($this->input->post('lic_startdate'));
                $lic_enddate = get_ymd_format($this->input->post('lic_enddate'));
                if(!compare_dates($lic_startdate,$lic_enddate)){
                    $return = array('success'=>false,'msg'=>'Please add correct start and end dates');
                    echo json_encode($return); exit;
                }
                $firstname = $this->input->post('firstname');
                $lastname = $this->input->post('lastname');
                $country = $this->input->post('ia_country');
                $email = $this->input->post('email');
                $contactno = $this->input->post('phone');
                $phonecods = $this->input->post('phonecods');
                $timezone = $this->input->post('timezone');


                $finalnum = validatePhone($contactno,$phonecods);
                if(!empty($contactno) && $finalnum==false){
                    $return = array('success'=>false,'msg'=>"Invalid Phone number for this country");
                    echo json_encode($return); exit;
                }else{
                    $contactno = $finalnum;
                }                

                $business_name = $this->input->post('business_name');
                $business_id = $this->input->post('business_id');
                $state = $this->input->post('state');
                //=======check business assigned to someone else=======

                    $rules =array(
                        array(
                                'field' => 'business_name',
                                'label' => 'Business name',
                                'rules' => 'required|trim|xss_clean'
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
                        $busData['business_state'] = $state;
                        // $busData['business_createddate'] = $createddate;
                        // $busData['business_createdby'] = $createdby;
                        // $busData['business_ipaddress'] = $ip_address;
                        // $busData['business_platform'] = $platform;
                        // $busData['business_webbrowser'] = $browser;                 
                        $busData['update_business'] = true;                 
                    }else{
                        $return = array('success'=>false,'msg'=>validation_errors());
                        echo json_encode($return); exit;
                    }

                    /*
                $businsquery = $this->generalmodel->getparticulardata("business_name","business","business_name LIKE '%$business_name%' ","row_array");
                if(!empty($businsquery)){
                    $return = array('success'=>false,'msg'=>"Business Name already exist ");
                    echo json_encode($return); exit;
                }
                */

                // print_r($businsquery); exit;


                //=======check business assigned to someone else=======



                //=========Add user start =========//
                $cto_profilepicture = $this->input->post('cto_profilepicture_h');

                $userData['firstname'] = $firstname;
                if ($cto_profilepicture!='') {
                     $userData['profilepicture'] = $cto_profilepicture;
                }
                $userData['dept_id'] = '2';
               
                $userData['country'] = $country;
                $userData['firstname'] = $firstname;
                $userData['lastname'] = $lastname;
                $userData['email'] = $email;
                $userData['contactno'] = $contactno;
                $userData['updatedate'] = $updatedate;
                $userData['assign_to'] = $assign_to;
                $userData['timezone'] = $timezone;

                //=========Add licensee start=========//
                $category_name = $this->input->post('category');
                $ia_id= $this->input->post('id');
                $licData['ia_lic_number'] = $lic_number;
                $licData['ia_lic_startdate'] = $lic_startdate;
                $licData['ia_lic_enddate'] = $lic_enddate;
                $licData['ia_country'] = $country;
                $licData['category'] = $category_name;
                $licData['assign_to'] = $assign_to;

                $profilepicture = $this->input->post('profilepicture_h');
                if ($profilepicture !='') {
                    $licData['ia_profilepicture'] = $profilepicture;
                }
                //$licData['business_name'] = $business_name;
              
                $user = $this->generalmodel->getSingleRowById('indassociation', 'ia_id', $ia_id, $returnType = 'array');
              
                // $this->generalmodel->updaterecord('user',$userData,'user_id='.$user['user_id']);

                // $query = $this->generalmodel->updaterecord('indassociation',$licData,'ia_id='.$ia_id);

                $query = $this->indus_model->update_ia($userData,$licData,$busData,$user['user_id'],$business_id);
                if($query>0){

                    //==========move from temp to actual location start=====//
                    if(!empty($cto_profilepicture)){
                        $src ='./tmp_upload/'.$cto_profilepicture;
                        $destination= './uploads/cto_profile/'.$cto_profilepicture;
                        rename($src, $destination);     
                    }

                    if(!empty($profilepicture)){
                        $src ='./tmp_upload/'.$profilepicture;
                        $destination= './uploads/ia_profile/'.$profilepicture;
                        rename($src, $destination); 
                    }

                    //==========move from temp to actual location end=====//

                    $return = array('success'=>true,'msg'=>'Industrial Association Updated successfully');
                }else{
                    $return = array('success'=>false,'msg'=>'something went wrong');
                }
            }else{
                $return = array('success'=>false,'msg'=>validation_errors());
            }
            echo json_encode($return); exit;
        }else{

            //$select = array('m.ia_id','m.ia_lic_number','m.ia_lic_startdate','m.category','m.ia_lic_enddate','m.business_name','b.firstname','b.lastname','m.ia_name','b.dept_id','b.country','b.email','b.contactno','m.business_id');
           // $data['ia']=$this->generalmodel->getsingleJoinData($select,'indassociation as m','user as b','m.user_id = b.user_id','b.user_id='.$id);
           
            $select = array('m.ia_id','ia_profilepicture','profilepicture','m.ia_lic_number','m.ia_lic_startdate','m.category','m.ia_lic_enddate','m.business_name','b.firstname','b.lastname','m.ia_name','b.dept_id','b.country','b.email','b.contactno',
                'm.business_id','business.business_street1','business.business_suburb','business.business_postalcode','business.business_country','business.business_state','m.assign_to');
            $tables[0]['table'] = 'user as b';
            $tables[0]['on'] = 'm.user_id = b.user_id';
            
            $tables[1]['table'] = 'business';
            $tables[1]['on'] = 'business.business_id = m.business_id';

            $data['ia']=$this->generalmodel->getfrommultipletables($select,"indassociation as m", $tables,'b.user_id='.$id,"","","","","row_array");

          // echo "<pre>"; print_r($data); exit;

            $data['deptlist'] = $this->generalmodel->deptlist();
            $data['countrylist'] = $this->generalmodel->countrylist();
            $data['categorylist'] = $this->generalmodel->iacategorylist();
            $data['kam_list'] = $this->generalmodel->kam_list();
            $data['meta_title'] = "Edit Industry Association";
            $this->session->set_userdata('iaid',$id);    
            $this->load->view('industryassociation/editia',$data);
        }
    }

    public function deleteia($id)
    {
        $id = decoding($id);
        if ($this->input->is_ajax_request()) {
            $data = array('status'=>'0');
            $this->generalmodel->updaterecord('user',$data,'user_id='.$id);

            $data = array('status'=>'2');
            $this->generalmodel->updaterecord('indassociation',$data,'user_id='.$id);

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
                    'app_activity_createat' => 'IA', 
                    // 'app_activity_createat' => 'lic-'.$this->input->post('lic_id'), 
                    'ia_id' => $this->input->post('ia_id'), 
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
        $ia_id = $this->input->post('ia_id');
        $this->load->helper('text');
        $datatables = new Datatables(new CodeigniterAdapter);
        $datatables->query('SELECT m.app_activity_title,concat(b.firstname," ",b.lastname) as name,m.app_activity_des,m.app_activity_createdate FROM app_activity as m LEFT JOIN user as b ON m.app_activity_createdby = b.user_id WHERE m.app_activity_createat ="IA" AND m.ia_id="'.$ia_id.'" ORDER BY m.app_activity_createdate DESC');
         $datatables->edit('app_activity_createdate', function ($data) {
                    return date('m/d/Y',strtotime($data['app_activity_createdate']));
                });
          $datatables->edit('app_activity_des', function ($data) {
            $desc = word_limiter($data['app_activity_des'], 10);
            $readmore ='<a class="addDesc" data-id="desc" value="'.$data['app_activity_des'].'"><span class="badge badge-pill badge-secondary">Read More</span></a>'; 
            if(strlen($data['app_activity_des'])>strlen($desc)){
                return $desc.$readmore;
            }else{ return $desc; }
            
         });
        echo $datatables->generate();
    }

    public function check_email_exist(){ 
        if(!empty($this->input->post()) && $this->input->is_ajax_request()){
            $email = $this->input->post('email');
            $result = $this->generalmodel->check_user_exist($email);

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

        // if($q!=''){
        //     if(!empty($this->session->userdata['licenseeid']))
        //     {
        //         $id=$this->session->userdata['licenseeid'];    
        //         if ($this->userdata['urole_id']==1 || $this->userdata['urole_id']==2)
        //         $items = 'SELECT m.ia_resource_id,m.business_name,m.ia_lic_number,c.user_cat_name,b.firstname,b.email,m.ia_lic_enddate,m.user_id,m.ia_id FROM indassociation as m LEFT JOIN user as b ON m.user_id = b.user_id LEFT JOIN user_category as c ON m.category = c.user_cat_id  WHERE b.status !="0" and b.createdby="'.$id.'"  AND (m.ia_resource_id LIKE "%'.$q.'%" OR m.business_name LIKE "%'.$q.'%" OR m.ia_lic_number LIKE "%'.$q.'%" OR c.user_cat_name LIKE "%'.$q.'%" OR b.firstname LIKE "%'.$q.'%" OR b.email LIKE "%'.$q.'%" OR m.ia_lic_enddate LIKE "%'.$q.'%")';
        //     }else{
        //       if ($this->userdata['urole_id']==1 || $this->userdata['urole_id']==2)
        //         $items = 'SELECT m.ia_resource_id,m.business_name,m.ia_lic_number,c.user_cat_name,b.firstname,b.email,m.ia_lic_enddate,m.user_id,m.ia_id FROM indassociation as m LEFT JOIN user as b ON m.user_id = b.user_id LEFT JOIN user_category as c ON m.category = c.user_cat_id  WHERE b.status !="0"  AND (m.ia_resource_id LIKE "%'.$q.'%" OR m.business_name LIKE "%'.$q.'%" OR m.ia_lic_number LIKE "%'.$q.'%" OR c.user_cat_name LIKE "%'.$q.'%" OR b.firstname LIKE "%'.$q.'%" OR b.email LIKE "%'.$q.'%" OR m.ia_lic_enddate LIKE "%'.$q.'%")';
        //       else
        //         $items = 'SELECT m.ia_resource_id,m.business_name,m.ia_lic_number,c.user_cat_name,b.firstname,b.email,m.ia_lic_enddate,m.user_id,m.ia_id FROM indassociation as m LEFT JOIN user as b ON m.user_id = b.user_id LEFT JOIN user_category as c ON m.category = c.user_cat_id  WHERE b.status !="0" and b.createdby="'.$id.'"  AND (m.ia_resource_id LIKE "%'.$q.'%" OR m.business_name LIKE "%'.$q.'%" OR m.ia_lic_number LIKE "%'.$q.'%" OR c.user_cat_name LIKE "%'.$q.'%" OR b.firstname LIKE "%'.$q.'%" OR b.email LIKE "%'.$q.'%" OR m.ia_lic_enddate LIKE "%'.$q.'%")';
        //     }
        // }else{

        //      if(!empty($this->session->userdata['licenseeid']))
        //     {
        //         $id=$this->session->userdata['licenseeid'];    
        //         if ($this->userdata['urole_id']==1 || $this->userdata['urole_id']==2)
        //         $items ='SELECT m.ia_resource_id,m.business_name,m.ia_lic_number,c.user_cat_name,b.firstname,b.email,m.ia_lic_enddate,m.user_id,m.ia_id FROM indassociation as m LEFT JOIN user as b ON m.user_id = b.user_id LEFT JOIN user_category as c ON m.category = c.user_cat_id  WHERE b.status !="0" and b.createdby="'.$id.'"';
        //     }else{
        //       if ($this->userdata['urole_id']==1 || $this->userdata['urole_id']==2)
        //         $items ='SELECT m.ia_resource_id,m.business_name,m.ia_lic_number,c.user_cat_name,b.firstname,b.email,m.ia_lic_enddate,m.user_id,m.ia_id FROM indassociation as m LEFT JOIN user as b ON m.user_id = b.user_id LEFT JOIN user_category as c ON m.category = c.user_cat_id  WHERE b.status !="0" ';
        //       else
        //         $items ='SELECT m.ia_resource_id,m.business_name,m.ia_lic_number,c.user_cat_name,b.firstname,b.email,m.ia_lic_enddate,m.user_id,m.ia_id FROM indassociation as m LEFT JOIN user as b ON m.user_id = b.user_id LEFT JOIN user_category as c ON m.category = c.user_cat_id  WHERE b.status !="0" and b.createdby="'.$id.'"';
        //     }
        // }
        if($q!=""){
            $search = 'AND (m.ia_resource_id LIKE "%'.$q.'%" OR m.business_name LIKE "%'.$q.'%" OR m.ia_lic_number LIKE "%'.$q.'%" OR c.user_cat_name LIKE "%'.$q.'%" OR b.firstname LIKE "%'.$q.'%" OR b.email LIKE "%'.$q.'%" OR m.ia_lic_enddate LIKE "%'.$q.'%")';
        }else{
            $search = '';
        }

        if(!empty($this->session->userdata['licenseeid']))
        {
            $id=$this->session->userdata['licenseeid'];    
            if ($this->userdata['urole_id']==1 || $this->userdata['urole_id']==2)
            $items ='SELECT m.ia_resource_id,m.business_name,m.ia_lic_number,c.user_cat_name,CONCAT(b.firstname," ",b.lastname) as fullname,b.email,m.ia_lic_enddate,m.user_id,m.ia_id FROM indassociation as m LEFT JOIN user as b ON m.user_id = b.user_id LEFT JOIN user_category as c ON m.category = c.user_cat_id  WHERE b.status !="0" and b.createdby="'.$id.'" '.$search.'';
        }else{
          //if($this->userdata['urole_id']==1 || $this->userdata['urole_id']==2)
          if($this->userdata['urole_id']==1)
            if($this->userdata['dept_id']==5 || $this->userdata['dept_id']==4){
                $items ='SELECT m.ia_resource_id,m.business_name,m.ia_lic_number,c.user_cat_name,CONCAT(b.firstname," ",b.lastname) as fullname,b.email,m.ia_lic_enddate,m.user_id,m.ia_id FROM indassociation as m LEFT JOIN user as b ON m.user_id = b.user_id LEFT JOIN user_category as c ON m.category = c.user_cat_id  WHERE b.status !="0" and m.assign_to="'.$userid.'" '.$search.'';

            }else{
                $items ='SELECT m.ia_resource_id,m.business_name,m.ia_lic_number,c.user_cat_name,CONCAT(b.firstname," ",b.lastname) as fullname,b.email,m.ia_lic_enddate,m.user_id,m.ia_id FROM indassociation as m LEFT JOIN user as b ON m.user_id = b.user_id LEFT JOIN user_category as c ON m.category = c.user_cat_id  WHERE b.status !="0" '.$search.'';

            }
          else
            $items ='SELECT m.ia_resource_id,m.business_name,m.ia_lic_number,c.user_cat_name,CONCAT(b.firstname," ",b.lastname) as fullname,b.email,m.ia_lic_enddate,m.user_id,m.ia_id FROM indassociation as m LEFT JOIN user as b ON m.user_id = b.user_id LEFT JOIN user_category as c ON m.category = c.user_cat_id  WHERE b.status !="0" and b.createdby="'.$userid.'" '.$search.'';
        }
      
        // echo $items; exit;
        $query=$this->db->query($items);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'Industryassociation.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser
        $cells = [
                WriterEntityFactory::createCell('Resource ID'),
                WriterEntityFactory::createCell('Business Name'),
                WriterEntityFactory::createCell('License Number'),
                WriterEntityFactory::createCell('Category'),
                WriterEntityFactory::createCell('CTO Name'),
                WriterEntityFactory::createCell('CTO Email Address'),
                WriterEntityFactory::createCell('License End Date'),
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
     
        foreach ($obj as $row) {
            $data[0] = $row['ia_resource_id'];
            $data[2] = $row['business_name'];
            $data[1] = $row['ia_lic_number'];
            $data[3] = $row['user_cat_name'];
            $data[4] = $row['fullname'];
            $data[5] = $row['email'];
            $data[6] = date('m/d/Y',strtotime($row['ia_lic_enddate']));
            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
        }
        $writer->close();
    }

    
    public function int_expression(){
        $this->load->view('industryassociation/int_expression');
    }
    public function int_expression_ajax(){

        
        $userid =$this->userdata['user_id'];
        $userid =45;
        $perms=explode(",",$this->userdata['upermission']);
        

        $datatables = new Datatables(new CodeigniterAdapter);
        $datatables->query('SELECT CONCAT_WS(" ",firstname,lastname) AS username,p.product_name,ie.createdate,ie.int_id FROM `interest_expression` as ie 
        LEFT JOIN product as p ON p.prod_id = ie.prod_id
        LEFT JOIN user as u ON u.user_id = ie.customer_id
        WHERE `ia_id`='.$userid);
        
        
                $datatables->edit('createdate', function ($data) {
                    return date('m/d/Y',strtotime($data['createdate']));
                });
                // edit 'id' column
                $datatables->edit('int_id', function($data){

                    return '<a class="btn sentInterest" href="javascript:void(0)" action="'.site_url().'industryassociation/sendIntofexpression/'.$data['int_id'].'">
                                Send Expression of Interest
                            </a>';

                
                });

        echo $datatables->generate();

    }

    public function sendIntofexpression($intId){
        if($this->input->is_ajax_request()){
            $intDetail = $this->generalmodel->interest_detail($intId);
            
            $licdata = $this->generalmodel->getlicdata($intDetail['lic_id']);

            $mailData = $this->generalmodel->mail_template('email_subject,email_body','int_expression_to_lic');
            $content =$mailData['email_body']; 

            $message = $this->load->view('include/mail_template',array('content'=>$content),true);

            $subject = $mailData['email_subject'];
            $mailresponce = $this->sendGridMail('',$licdata['email'],$subject,$message);
            if($mailresponce=="TRUE"){ 
                $return = array('success'=>true,'msg'=>'Mail of Interest Sent');
            }else{
                $return = array('success'=>false,'msg'=>'mail failed');
            } 
            echo json_encode($return);
        }

    }

     public function removeia(){
        if ($this->input->is_ajax_request()) {
           
            $ids = $this->input->post('ids');
            $data = array('status'=>'0');
            $this->generalmodel->updaterecord('user',$data,'user_id IN('.$ids.')');

            $data = array('status'=>'2');
            $this->generalmodel->updaterecord('indassociation',$data,'user_id IN('.$ids.')');
           // $this->generalmodel->updaterecord('ticket_category',array('tic_del_status'=>0),'tic_cat_id IN('.$ids.')');
            $return = array('success'=>true,'msg'=>'Records Removed');
        }else{
            $return = array('success'=>false,'msg'=>'Internal Error');
        }
        echo json_encode($return);
    }



}
