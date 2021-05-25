<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH.'third_party/phonenumber/autoload.php';
use Brick\PhoneNumber\PhoneNumber;
use Brick\PhoneNumber\PhoneNumberFormat;
use Brick\Phonenumber\PhoneNumberParseException;


require_once APPPATH. 'third_party/Spout/Autoloader/autoload.php';
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;



use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;


class Staff extends MY_Controller {
    
  
  

    public function __construct(){
        parent::__construct();
        $this->userdata = $this->session->userdata('userdata');

        
    }

    public function index()
    {

        //$this->load->view('allstaff');
    }

    public function allstaff(){
        $data['meta_title'] = "All Staff";
        $data['page_heading'] = "All Staff";
        $this->load->view('allstaff',$data);    
    }

    public function itstaff(){
        $data['meta_title'] = "IT Staff";
        $data['page_heading'] = "IT Staff";
        $this->load->view('itstaff',$data); 
    }

    public function accountstaff(){
        $data['meta_title'] = "Account Staff";
        $data['page_heading'] = "Account Staff";
        $this->load->view('accountstaff',$data);    
    }

    public function comofficerstaff(){
        $data['meta_title'] = "Compliance Staff";
        $data['page_heading'] = "Compliance Staff";
        $this->load->view('comofficerstaff',$data); 
    }

    public function marketingstaff(){
        $data['meta_title'] = "Marketing Staff";
        $data['page_heading'] = "Marketing Staff";
        $this->load->view('marketingstaff',$data);  
    }

    public function prodmanagerstaff(){
        $data['meta_title'] = "Product Managers Staff";
        $data['page_heading'] = "Product Managers Staff";
        $this->load->view('prodmanagerstaff', $data);   
    }

    public function kamstaff(){
        $data['meta_title'] = "KAMs Staff";
        $data['page_heading'] = "KAMs Staff";
        $this->load->view('kamstaff', $data);   
    }

    public function bdestaff(){
        $data['meta_title'] = "BDEs Staff";
        $data['page_heading'] = "BDEs Staff";
        $this->load->view('bdestaff', $data);   
    }

    public function csrstaff(){
        $data['meta_title'] = "CSRs Staff";
        $data['page_heading'] = "CSRs Staff";
        $this->load->view('csrstaff', $data);   
    }

    public function addnew()
    {
        if(!empty($this->input->post()) && $this->input->is_ajax_request()){
    
            if($this->form_validation->run('add_staff')){
        
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

                $resource_id = resource_id('staff');
                $urole_id = $this->userdata['urole_id'];

                $createddate = $updatedate = date('Y-m-d h:i:s');
                $createdby = $this->userdata['user_id'];

                $firstname = $this->input->post('firstname');
                $lastname = $this->input->post('lastname');
                $country = $this->input->post('country');
                $email = $this->input->post('email');
                $dept_id = $this->input->post('dept');
                $assign_to = $this->input->post('assign_to');
                $timezone = $this->input->post('timezone');

                if($dept_id==4 && empty($assign_to)){
                    $return = array('success'=>false,'msg'=>'Please select Assign To');
                    echo json_encode($return); exit;
                }else{
                    $userData['assign_to'] = $assign_to;
                }

                $profilepicture = $this->input->post('profilepicture_h');

                $userData['resource_id'] = $resource_id;
                $userData['firstname'] = $firstname;
                $userData['lastname'] = $lastname;
                $userData['profilepicture'] = $profilepicture;
                $userData['dept_id'] = $dept_id;
                $userData['urole_id'] = $urole_id;
                $userData['user_level'] = $urole_id;
                $userData['country'] = $country;
                $userData['email'] = $email;
                $userData['password'] = $enc_pass;
                $userData['contactno'] = $finalnum;
                $userData['createdate'] = $createddate;
                $userData['createdby'] = $createdby;
                $userData['timezone'] = $timezone;
                
                $userData['status'] = 1;

                $query = $this->generalmodel->add('user',$userData);
                if(!empty($query)){

                    if(!empty($profilepicture)){
                        $src ='./tmp_upload/'.$profilepicture;
                        $destination= './uploads/user/'.$profilepicture;
                        rename($src, $destination);     
                    }

                    /**************************************Mail***************************************/
                        $link = site_url('');
                        //=============CTO=======================
                        $mailContent = $this->generalmodel->mail_template('email_subject,email_body','new_staff_created_cto');

                        $cto_data = $this->generalmodel->getparticularData('firstname,lastname,email','user',array('urole_id'=>$this->userdata['urole_id'],'dept_id'=>2),$returnType="row_array");
                       
                        $to_cto = $cto_data['email'];
                        

                        $cto_name = $cto_data['firstname'].' '.$cto_data['lastname'];

                        // $to = $this->userdata['email'];
                        // $name = $this->userdata['firstname'].' '.$this->userdata['lastname'];
                        $username = $firstname.' '.$lastname;

                            if($dept_id==3){
                                $dept = 'Accounts';
                            }elseif($dept_id==4){
                                $dept = 'CSR';
                            }elseif($dept_id==5){
                                $dept = 'KAM';
                            }elseif($dept_id==7){
                                $dept = 'Compliance Officer';
                            }elseif($dept_id==8){
                                $dept = 'Product Manager';
                            }elseif($dept_id==9){
                                $dept = 'Marketing';
                            }elseif($dept_id==10){
                                $dept = 'I.T';
                            }elseif($dept_id==11){
                                $dept = 'BDE';
                            }
                            
                            
                            $loginlink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">Login</a>';

                            $content = $mailContent['email_body'];
                            $content = str_replace('[name]',$cto_name,$content);
                            $content = str_replace('[user_name]',$username,$content);
                            //$content = str_replace('[department]'," ",$content);
                            $content = str_replace('[department]',$dept,$content);
                            $content = str_replace('[email]',$email,$content); 

                            $subject = $mailContent['email_subject'];
                            $subject = str_replace('[user_name]',$username,$subject);
                            $subject = str_replace('[department]',$dept,$subject);
                            
                            $message = $this->load->view('include/mail_template',array('body'=>$content),true);
                            
                            $mailresponce = $this->sendGridMail('',$to_cto,$subject,$message);

                                    //=============to Staff created=======================

                            $touser = $email;
                            

                            $mailContentN = $this->generalmodel->mail_template('email_subject,email_body','new_staff_created');

                            $content1 = $mailContentN['email_body'];
                            $content1 = str_replace('[name]',$username,$content1);
                            $content1 = str_replace('[user_name]',$username,$content1);
                            $content1 = str_replace('[cto_name]',$cto_name,$content1);
                            //$content1 = str_replace('[department]',' ',$content1);
                            $content1 = str_replace('[department]',$dept,$content1);
                            $content1 = str_replace('[email]',$email,$content1); 
                            $content1 = str_replace('[password]',$password,$content1); 
                            $content1 = str_replace('[link]',$loginlink,$content1); 

                            $subject1 = $mailContentN['email_subject'];
                            $subject1 = str_replace('[cto_name]',$cto_name,$subject1);
                            $subject1 = str_replace('[department]',$dept,$subject1);
                            
                            $message1 = $this->load->view('include/mail_template',array('body'=>$content1),true);
                            

                            $mailresponce = $this->sendGridMail('',$email,$subject1,$message1);

                    /*****************************************************************************/ 

                    $return = array('success'=>true,'msg'=>'Staff addedd successfully');
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
            $data['kam_list'] = $this->generalmodel->kam_list();
             $data['meta_title'] = "Add Staff";
            $this->load->view('staff/addnew',$data);
        }
    }

    public function ajaxallstaff()
    {
        $userid =$this->userdata['user_id'];
        $perms=explode(",",$this->userdata['upermission']);
        $datatables = new Datatables(new CodeigniterAdapter);
        
        if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
            if ($this->userdata['urole_id']==3) {
            
                $datatables->query('SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1" AND m.urole_id="3" AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'"');
            }else if ($this->userdata['urole_id']==2) {
                $datatables->query('SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1" AND m.urole_id="2" AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'"');
            }else{

                $datatables->query('SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1" AND m.urole_id="1" and m.urole_id NOT IN (4,5) AND m.user_id !="'.$userid.'"');
            }
        }else{

        $datatables->query('SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1"  AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'"');
        }
$datatables->edit('profilepicture', function ($data) {

if($data['profilepicture']){
return '<img src="'.base_url().'uploads/user/'.$data['profilepicture'].'" style="width: 40px; height: 40px;">'; 
}else{
return '<img src="'.base_url().'assets/img/avtr.png" style="width: 40px; height: 40px;">';
}
    });
    $datatables->edit('user_id', function($data) use($perms){
        $uid= encoding($data['user_id']);
                        
                    $menu=''; 
                    if(in_array('STAFF_VD',$perms)){
                        $menu.='<li>
                            <a href="'.site_url().'staff/staff_detail/'.$uid.'">
                                <span class="glyphicon glyphicon-eye-open"></span> View
                            </a>
                        </li>';     
                    }
                    
                    if(in_array('STAFF_E',$perms)){
                        $menu.='<li>
                            <a href="'.site_url().'staff/editstaff/'.$uid.'">
                                <span class="glyphicon glyphicon-pencil"></span> Edit
                            </a>
                        </li>';
                    }

                    if(in_array('STAFF_D',$perms)){
                        $menu.='<li>
                            <a  href="javascript:void(0)" link="'.site_url().'staff/deletestaff/'.$uid.'" class="deleteEntry">
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


    public function ajaxitstaff()
    {
        $datatables = new Datatables(new CodeigniterAdapter);
        $urole_id=$this->userdata['urole_id'];
        $userid=$this->userdata['user_id'];
        $perms=explode(",",$this->userdata['upermission']);

        if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
            if ($this->userdata['urole_id']==3) {
            
                $datatables->query('SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=10 AND m.status="1" AND m.urole_id="3" AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'"');
            }else if ($this->userdata['urole_id']==2) {
                $datatables->query('SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=10 AND m.status="1" AND m.urole_id="2" OR m.urole_id="3" AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'"');
            }else{

                $datatables->query('SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=10 AND m.urole_id="1" AND m.status="1" AND m.user_id !="'.$userid.'"');
            }
        }else{

            $datatables->query('SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1" AND b.dept_id=10 AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'"');
        }
        $datatables->edit('profilepicture', function ($data) {
            if($data['profilepicture']){
            // return '<img src="'.base_url().'uploads/user/'.$data['profilepicture']." style="width:40px; height:40px;">'; 
            return '<img src="'.base_url().'uploads/user/'.$data['profilepicture'].'" style="width: 40px; height: 40px;">'; 
            }else{
            // return '<img src="'.base_url().'assets/img/avtr.png'" style="width:40px; height:40px;">';
            return '<img src="'.base_url().'assets/img/avtr.png" style="width: 40px; height: 40px;">';
            }
         });

        $datatables->edit('user_id', function($data) use($perms){
        $uid = encoding($data['user_id']);                        
                    $menu=''; 
                    if(in_array('STAFF_VD',$perms)){
                        $menu.='<li>
                            <a href="'.site_url().'staff/staff_detail/'.$uid.'">
                                <span class="glyphicon glyphicon-eye-open"></span> View
                            </a>
                        </li>';     
                    }
                    
                    if(in_array('STAFF_E',$perms)){
                        $menu.='<li>
                            <a href="'.site_url().'staff/editstaff/'.$uid.'">
                                <span class="glyphicon glyphicon-pencil"></span> Edit
                            </a>
                        </li>';
                    }

                    if(in_array('STAFF_D',$perms)){
                        $menu.='<li>
                            <a  href="javascript:void(0)" link="'.site_url().'staff/deletestaff/'.$uid.'" class="deleteEntry">
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

    public function ajaxprodmanageritstaff()
    {
        $datatables = new Datatables(new CodeigniterAdapter);
        $urole_id=$this->userdata['urole_id'];
        $perms=explode(",",$this->userdata['upermission']);

        $userid=$this->userdata['user_id'];
        if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
            if ($this->userdata['urole_id']==3) {
            
                $datatables->query('SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=8 AND m.status="1" AND m.urole_id="3" AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'"');
            }else if ($this->userdata['urole_id']==2) {
                $datatables->query('SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=8 AND m.status="1" AND m.urole_id="2" AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'"');
            }else{

                $datatables->query('SELECT m.resource_id,m.profilepicture,m.firstname,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=8 AND m.urole_id="1" AND m.status="1" AND m.user_id !="'.$userid.'"');
            }
        }else{

            $datatables->query('SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1" AND b.dept_id=8 AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'"');
        }
        $datatables->edit('profilepicture', function ($data) {
            if($data['profilepicture']){
            // return '<img src="'.base_url().'uploads/user/'.$data['profilepicture']." style="width:40px; height:40px;">'; 
            return '<img src="'.base_url().'uploads/user/'.$data['profilepicture'].'" style="width: 40px; height: 40px;">'; 
            }else{
            // return '<img src="'.base_url().'assets/img/avtr.png'" style="width:40px; height:40px;">';
            return '<img src="'.base_url().'assets/img/avtr.png" style="width: 40px; height: 40px;">';
            }
         });

        $datatables->edit('user_id', function($data) use($perms){
            $uid = encoding($data['user_id']);
                    $menu=''; 
                    if(in_array('STAFF_VD',$perms)){
                        $menu.='<li>
                            <a href="'.site_url().'staff/staff_detail/'.$uid.'">
                                <span class="glyphicon glyphicon-eye-open"></span> View
                            </a>
                        </li>';     
                    }
                    
                    if(in_array('STAFF_E',$perms)){
                        $menu.='<li>
                            <a href="'.site_url().'staff/editstaff/'.$uid.'">
                                <span class="glyphicon glyphicon-pencil"></span> Edit
                            </a>
                        </li>';
                    }

                    if(in_array('STAFF_D',$perms)){
                        $menu.='<li>
                            <a  href="javascript:void(0)" link="'.site_url().'staff/deletestaff/'.$uid.'" class="deleteEntry">
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

    public function ajaxaccountstaff()
    {
        $datatables = new Datatables(new CodeigniterAdapter);
        $urole_id=$this->userdata['urole_id'];
        $perms=explode(",",$this->userdata['upermission']);

        $userid=$this->userdata['user_id'];
        if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
            if ($this->userdata['urole_id']==3) {
            
                $datatables->query('SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=3 AND m.status="1" AND m.urole_id="3"  AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'"');
            }else if ($this->userdata['urole_id']==2) {
                $datatables->query('SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=3 AND m.status="1" AND m.urole_id="2" AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'"');
            }else{

                $datatables->query('SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=3 AND m.urole_id="1" AND m.status="1" AND m.user_id !="'.$userid.'"');
            }
        }else{

            $datatables->query('SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1" AND b.dept_id=3 AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'"');
        }

        $datatables->edit('profilepicture', function ($data) {
            if($data['profilepicture']){
            // return '<img src="'.base_url().'uploads/user/'.$data['profilepicture']." style="width:40px; height:40px;">'; 
            return '<img src="'.base_url().'uploads/user/'.$data['profilepicture'].'" style="width: 40px; height: 40px;">'; 
            }else{
            // return '<img src="'.base_url().'assets/img/avtr.png'" style="width:40px; height:40px;">';
            return '<img src="'.base_url().'assets/img/avtr.png" style="width: 40px; height: 40px;">';
            }
         });

        $datatables->edit('user_id', function($data) use($perms){
            $uid = encoding($data['user_id']);            
                    $menu=''; 
                    if(in_array('STAFF_VD',$perms)){
                        $menu.='<li>
                            <a href="'.site_url().'staff/staff_detail/'.$uid.'">
                                <span class="glyphicon glyphicon-eye-open"></span> View
                            </a>
                        </li>';     
                    }
                    
                    if(in_array('STAFF_E',$perms)){
                        $menu.='<li>
                            <a href="'.site_url().'staff/editstaff/'.$uid.'">
                                <span class="glyphicon glyphicon-pencil"></span> Edit
                            </a>
                        </li>';
                    }

                    if(in_array('STAFF_D',$perms)){
                        $menu.='<li>
                            <a  href="javascript:void(0)" link="'.site_url().'staff/deletestaff/'.$uid.'" class="deleteEntry">
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

    public function ajaxkamstaff()
    {
        $datatables = new Datatables(new CodeigniterAdapter);
        $urole_id=$this->userdata['urole_id'];
        $perms=explode(",",$this->userdata['upermission']);

        
        $userid=$this->userdata['user_id'];
        if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
            if ($this->userdata['urole_id']==3) {
            
                $datatables->query('SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=5 AND m.status="1" AND m.urole_id="3" AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'"');
            }else if ($this->userdata['urole_id']==2) {
                $datatables->query('SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=5 AND m.status="1" AND m.urole_id="2" AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'"');
            }else{

                $datatables->query('SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=5 AND m.urole_id="1" AND m.status="1" AND m.user_id !="'.$userid.'"');
            }
        }else{

            $datatables->query('SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1" AND b.dept_id=5 AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'"');
        }

        $datatables->edit('profilepicture', function ($data) {
            if($data['profilepicture']){
            // return '<img src="'.base_url().'uploads/user/'.$data['profilepicture']." style="width:40px; height:40px;">'; 
            return '<img src="'.base_url().'uploads/user/'.$data['profilepicture'].'" style="width: 40px; height: 40px;">'; 
            }else{
            // return '<img src="'.base_url().'assets/img/avtr.png'" style="width:40px; height:40px;">';
            return '<img src="'.base_url().'assets/img/avtr.png" style="width: 40px; height: 40px;">';
            }
         });

        $datatables->edit('user_id', function($data) use($perms){
            $uid = encoding($data['user_id']);            
                    $menu=''; 
                    if(in_array('STAFF_VD',$perms)){
                        $menu.='<li>
                            <a href="'.site_url().'staff/staff_detail/'.$uid.'">
                                <span class="glyphicon glyphicon-eye-open"></span> View
                            </a>
                        </li>';     
                    }
                    
                    if(in_array('STAFF_E',$perms)){
                        $menu.='<li>
                            <a href="'.site_url().'staff/editstaff/'.$uid.'">
                                <span class="glyphicon glyphicon-pencil"></span> Edit
                            </a>
                        </li>';
                    }

                    if(in_array('STAFF_D',$perms)){
                        $menu.='<li>
                            <a  href="javascript:void(0)" link="'.site_url().'staff/deletestaff/'.$uid.'" class="deleteEntry">
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

    public function ajaxbdestaff()
    {
        $datatables = new Datatables(new CodeigniterAdapter);
        $urole_id=$this->userdata['urole_id'];
        $perms=explode(",",$this->userdata['upermission']);

      
        $userid=$this->userdata['user_id'];
        if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
            if ($this->userdata['urole_id']==3) {
            
                $datatables->query('SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=11 AND m.status="1" AND m.urole_id="3" AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'"');
            }else if ($this->userdata['urole_id']==2) {
                $datatables->query('SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=11 AND m.status="1" AND m.urole_id="2" AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'"');
            }else{

                $datatables->query('SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=11 AND m.urole_id="1" AND m.status="1" AND m.user_id !="'.$userid.'"');
            }
        }else{

            $datatables->query('SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1" AND b.dept_id=11 AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'"');
        }

        $datatables->edit('profilepicture', function ($data) {
            if($data['profilepicture']){
            // return '<img src="'.base_url().'uploads/user/'.$data['profilepicture']." style="width:40px; height:40px;">'; 
            return '<img src="'.base_url().'uploads/user/'.$data['profilepicture'].'" style="width: 40px; height: 40px;">'; 
            }else{
            // return '<img src="'.base_url().'assets/img/avtr.png'" style="width:40px; height:40px;">';
            return '<img src="'.base_url().'assets/img/avtr.png" style="width: 40px; height: 40px;">';
            }
         });

        $datatables->edit('user_id', function($data) use($perms){
                        $uid = encoding($data['user_id']);
                    $menu=''; 
                    if(in_array('STAFF_VD',$perms)){
                        $menu.='<li>
                            <a href="'.site_url().'staff/staff_detail/'.$uid.'">
                                <span class="glyphicon glyphicon-eye-open"></span> View
                            </a>
                        </li>';     
                    }
                    
                    if(in_array('STAFF_E',$perms)){
                        $menu.='<li>
                            <a href="'.site_url().'staff/editstaff/'.$uid.'">
                                <span class="glyphicon glyphicon-pencil"></span> Edit
                            </a>
                        </li>';
                    }

                    if(in_array('STAFF_D',$perms)){
                        $menu.='<li>
                            <a  href="javascript:void(0)" link="'.site_url().'staff/deletestaff/'.$uid.'" class="deleteEntry">
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
    
    public function ajaxofficerstaff()
    {
        $datatables = new Datatables(new CodeigniterAdapter);
        $urole_id=$this->userdata['urole_id'];
        $perms=explode(",",$this->userdata['upermission']);

        $userid=$this->userdata['user_id'];
        if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
            if ($this->userdata['urole_id']==3) {
            
                $datatables->query('SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=7 AND m.status="1" AND m.urole_id="3" OR m.urole_id="2" AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'"');
            }else if ($this->userdata['urole_id']==2) {
                $datatables->query('SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=7 AND m.status="1" AND m.urole_id="2" AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'"');
            }else{

                $datatables->query('SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=7 AND m.urole_id="1" AND m.status="1" AND m.user_id !="'.$userid.'"');
            }
        }else{

            $datatables->query('SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1" AND b.dept_id=7 AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'"');
        }
        
        $datatables->edit('profilepicture', function ($data) {
            if($data['profilepicture']){
            return '<img src="'.base_url().'uploads/user/'.$data['profilepicture'].'" style="width: 40px; height: 40px;">'; 
            }else{
            return '<img src="'.base_url().'assets/img/avtr.png" style="width: 40px; height: 40px;">';
            }
         });

        $datatables->edit('user_id', function($data) use($perms){
            $uid = encoding($data['user_id']);            
                    $menu=''; 
                    if(in_array('STAFF_VD',$perms)){
                        $menu.='<li>
                            <a href="'.site_url().'staff/staff_detail/'.$uid.'">
                                <span class="glyphicon glyphicon-eye-open"></span> View
                            </a>
                        </li>';     
                    }
                    
                    if(in_array('STAFF_E',$perms)){
                        $menu.='<li>
                            <a href="'.site_url().'staff/editstaff/'.$uid.'">
                                <span class="glyphicon glyphicon-pencil"></span> Edit
                            </a>
                        </li>';
                    }

                    if(in_array('STAFF_D',$perms)){
                        $menu.='<li>
                            <a  href="javascript:void(0)" link="'.site_url().'staff/deletestaff/'.$uid.'" class="deleteEntry">
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
    
    public function ajaxmarketingstaff()
    {
        $datatables = new Datatables(new CodeigniterAdapter);
        $urole_id=$this->userdata['urole_id'];
        $perms=explode(",",$this->userdata['upermission']);

        $userid=$this->userdata['user_id'];
        if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
            if ($this->userdata['urole_id']==3) {
            
                $datatables->query('SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=9 AND m.status="1" AND m.urole_id="3" AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'"');
            }else if ($this->userdata['urole_id']==2) {
                $datatables->query('SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=9 AND m.status="1" AND m.urole_id="2" AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'"');
            }else{

                $datatables->query('SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=9 AND m.urole_id="1" AND m.status="1" AND m.user_id !="'.$userid.'"');
            }
        }else{

            $datatables->query('SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1" AND b.dept_id=9 AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'"');
        }

        $datatables->edit('profilepicture', function ($data) {
            if($data['profilepicture']){
            return '<img src="'.base_url().'uploads/user/'.$data['profilepicture'].'" style="width: 40px; height: 40px;">'; 
            }else{
            return '<img src="'.base_url().'assets/img/avtr.png" style="width: 40px; height: 40px;">';
            }
         });

        $datatables->edit('user_id', function($data) use($perms){
                    $uid = encoding($data['user_id']);
                    $menu=''; 
                    if(in_array('STAFF_VD',$perms)){
                        $menu.='<li>
                            <a href="'.site_url().'staff/staff_detail/'.$uid.'">
                                <span class="glyphicon glyphicon-eye-open"></span> View
                            </a>
                        </li>';     
                    }
                    
                    if(in_array('STAFF_E',$perms)){
                        $menu.='<li>
                            <a href="'.site_url().'staff/editstaff/'.$uid.'">
                                <span class="glyphicon glyphicon-pencil"></span> Edit
                            </a>
                        </li>';
                    }

                    if(in_array('STAFF_D',$perms)){
                        $menu.='<li>
                            <a  href="javascript:void(0)" link="'.site_url().'staff/deletestaff/'.$uid.'" class="deleteEntry">
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

    public function ajaxcsrstaff()
    {
        $datatables = new Datatables(new CodeigniterAdapter);
        $urole_id = $this->userdata['urole_id'];
        $perms=explode(",",$this->userdata['upermission']);

        $userid=$this->userdata['user_id'];
        if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
            if ($this->userdata['urole_id']==3) {
            
                $datatables->query('SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=4 AND m.status="1" AND m.urole_id="3" AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'"');
            }else if ($this->userdata['urole_id']==2) {
                $datatables->query('SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=4 AND m.status="1" AND m.urole_id="2" AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'"');
            }else{

                $datatables->query('SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=4 AND m.urole_id="1" AND m.status="1" AND m.user_id !="'.$userid.'"');
            }
        }else{

            $datatables->query('SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1" AND b.dept_id=4 AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'"');
        }
        
        $datatables->edit('profilepicture', function ($data) {
            if($data['profilepicture']){
            // return '<img src="'.base_url().'uploads/user/'.$data['profilepicture']." style="width:40px; height:40px;">'; 
            return '<img src="'.base_url().'uploads/user/'.$data['profilepicture'].'" style="width: 40px; height: 40px;">'; 
            }else{
            // return '<img src="'.base_url().'assets/img/avtr.png'" style="width:40px; height:40px;">';
            return '<img src="'.base_url().'assets/img/avtr.png" style="width: 40px; height: 40px;">';
            }
         });

        $datatables->edit('user_id',function($data) use($perms){
            $uid = encoding($data['user_id']);
                    $menu=''; 
                    if(in_array('STAFF_VD',$perms)){
                        $menu.='<li>
                            <a href="'.site_url().'staff/staff_detail/'.$uid.'">
                                <span class="glyphicon glyphicon-eye-open"></span> View
                            </a>
                        </li>';     
                    }
                    
                    if(in_array('STAFF_E',$perms)){
                        $menu.='<li>
                            <a href="'.site_url().'staff/editstaff/'.$uid.'">
                                <span class="glyphicon glyphicon-pencil"></span> Edit
                            </a>
                        </li>';
                    }

                    if(in_array('STAFF_D',$perms)){
                        $menu.='<li>
                            <a  href="javascript:void(0)" link="'.site_url().'staff/deletestaff/'.$uid.'" class="deleteEntry">
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
    
    public function StaffProfile($id)
    {
        $id = decoding($id);
        $data['data']=$this->generalmodel->getSingleRowById('user', 'user_id', $id, $returnType = 'array');
         $data['meta_title'] = "Staff Profile";
       $this->load->view('profiledetails',$data);
    }

    public function myprofile($id)
    {
        $data['data']=$this->generalmodel->getSingleRowById('user', 'user_id', $id, $returnType = 'array');
         $data['meta_title'] = "My Profile";
       $this->load->view('myprofile',$data);
    }

    public function staff_detail($id)
    {
        $id = decoding($id);
        $data['data']=$this->generalmodel->getSingleRowById('user', 'user_id', $id, $returnType = 'array');
         $data['meta_title'] = "View Staff";
       $this->load->view('staff_detail',$data);
    }

    public function editstaff($id)
    {   
        $id = decoding($id);
        if(!empty($this->input->post()) && $this->input->is_ajax_request()){

            if($this->form_validation->run('edit_staff')){

                $phone = $this->input->post('phone');           
                $phonecods = $this->input->post('phonecods');

                $finalnum = validatePhone($phone,$phonecods);
                if(!empty($phone) && $finalnum==false){
                    $return = array('success'=>false,'msg'=>"Invalid Phone number for this country");
                    echo json_encode($return); exit;
                }

                $id = $this->input->post('id');
            
                
                $firstname = $this->input->post('firstname');
                $lastname = $this->input->post('lastname');
                $country = $this->input->post('country');
                $email = $this->input->post('email');
                $contactno = $finalnum;
                $dept_id = $this->input->post('dept');
                $assign_to = $this->input->post('assign_to');
                $timezone = $this->input->post('timezone');

                //============check email duplicacy==========//
                $user = $this->generalmodel->getparticularData("user_id",'user',"`user_id`=$id","row_array");
                
                $query = $this->generalmodel->getparticularData("email",'user',"`email`='$email' AND `user_id` !=".$user['user_id'],"row_array");
                if(!empty($query)){
                    $return = array('success'=>false,'msg'=>"Email Address is already registerd!");
                    echo json_encode($return); exit;                    
                }

                if($dept_id==4 && empty($assign_to)){
                    $return = array('success'=>false,'msg'=>'Please select Assign To');
                    echo json_encode($return); exit;
                }else{
                    $userData['assign_to'] = $assign_to;
                }

                $profilepicture = $this->input->post('profilepicture_h');

                //$userData['resource_id'] = $resource_id;
                $userData['firstname'] = $firstname;
                $userData['lastname'] = $lastname;
                if(!empty($profilepicture)){ $userData['profilepicture'] = $profilepicture; }
                $userData['dept_id'] = $dept_id;
                //$userData['urole_id'] = $urole_id;
                $userData['country'] = $country;
                $userData['email'] = $email;
                $userData['contactno'] = $contactno;
                $userData['timezone'] = $timezone;
                $userData['status'] = 1;

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
        }else{
            $urole_id=$this->userdata['urole_id'];
            if($urole_id==2 || $urole_id == 3){
                $data['deptlist'] = $this->generalmodel->get_data_by_condition('dept_id,deptname','department','dept_id NOT IN (1,2,7,8,10)');

            }else{

                $data['deptlist'] = $this->generalmodel->deptlist();
            }
            $data['countrylist'] = $this->generalmodel->countrylist();
            $data['kam_list'] = $this->generalmodel->kam_list();
            $data['data']=$this->generalmodel->getSingleRowById('user', 'user_id', $id, $returnType = 'array');  
             $data['meta_title'] = "Edit Staff";       
            $this->load->view('staff/editstaff',$data);
        }
    }

    public function deletestaff($id)
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
            $result = $this->generalmodel->check_user_exist($email);

            if(!empty($result)){
                $return = array('success'=>false,'msg'=>'exist');
            }else{
                $return = array('success'=>true,'msg'=>'not exist');
            }
            
            echo json_encode($return); exit;
        }
        
    }

    private function validatePhone($phone,$phonecods){

        $phone = trim($phone);
        $phone_codes = trim($phonecods);
                    
        try {    
        $phonenumber  = preg_replace('/[^\p{L}\p{N}\s]/u', '', $phone); 
        $phonenumber  = str_replace(' ', '', $phonenumber);

        $phonecodes  = explode("-",$phone_codes);
        $phonecodes = $phonecodes[0];

        $phone_code_lenght = strlen($phonecodes);
        $get_phone  = substr($phonenumber, 0, $phone_code_lenght);

        if($get_phone==$phonecodes){
        $removecode = '+'.$phonenumber;
        }else{
        $removecode = '+'.$phonecodes.$phonenumber;
        }

        $number = PhoneNumber::parse(".$removecode.");
        if (! $number->isValidNumber()) {
        // strict check relying on up-to-date metadata library
        $phonenumbermsg = "invalid";
        }else{
        $finalnum = $number->format(PhoneNumberFormat::INTERNATIONAL);
        $phonenumbermsg = 'defined';
        }
        }
        catch (PhoneNumberParseException $e) {
        $phonenumbermsg = "invalid";
        }

        return $phonenumbermsg;

    } 

    public function export()
    {
        set_time_limit(0);
        ini_set('memory_limit', -1);
        $userid =$this->userdata['user_id'];
        $perms=explode(",",$this->userdata['upermission']);
        $q = $this->input->post('search');
        if($q!=''){
            if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
                if ($this->userdata['urole_id']==3) {
                
                    $items = 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1" AND m.urole_id="3" AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'" AND (m.resource_id LIKE "%'.$q.'%" OR m.firstname LIKE "%'.$q.'%" OR m.email LIKE "%'.$q.'%" OR b.deptname LIKE "%'.$q.'%")';
                }else if ($this->userdata['urole_id']==2) {
                    $items = 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1" AND m.urole_id="2" AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'" AND (m.resource_id LIKE "%'.$q.'%" OR m.firstname LIKE "%'.$q.'%" OR m.email LIKE "%'.$q.'%" OR b.deptname LIKE "%'.$q.'%")';
                }else{

                    $items = 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1" AND m.urole_id="1" and m.urole_id NOT IN (4,5) AND m.user_id !="'.$userid.'" AND (m.resource_id LIKE "%'.$q.'%" OR m.firstname LIKE "%'.$q.'%" OR m.email LIKE "%'.$q.'%" OR b.deptname LIKE "%'.$q.'%")';
                }
            }else{

                    $items= 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1"  AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'" AND (m.resource_id LIKE "%'.$q.'%" OR m.firstname LIKE "%'.$q.'%" OR m.email LIKE "%'.$q.'%" OR b.deptname LIKE "%'.$q.'%")';
            }

        }else{

            if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
                if ($this->userdata['urole_id']==3) {
                
                    $items= 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1" AND m.urole_id="3" AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'"';
                }else if ($this->userdata['urole_id']==2) {
                    $items= 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1" AND m.urole_id="2" AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'"';
                }else{

                    $items= 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1" AND m.urole_id="1" and m.urole_id NOT IN (4,5) AND m.user_id !="'.$userid.'"';
                }
            }else{

            $items= 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1"  AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'"';
            }
        }

        $query=$this->db->query($items);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'Staff.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser
        $cells = [
                WriterEntityFactory::createCell('Resource ID'),
                // WriterEntityFactory::createCell('Profile Picture'),
                WriterEntityFactory::createCell('First Name'),
                WriterEntityFactory::createCell('Email'),
                WriterEntityFactory::createCell('Department Name'),
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
        //$writer->addRow(array('resource_id', 'lic_number', 'business_name', 'user_cat_name', 'Distributor Name','email','end date'));

        foreach ($obj as $row) {
            $data[0] = $row['resource_id'];
            // $data[1] = base_url().'uploads/user/'.$row['profilepicture'];
            $data[1] = $row['username'];
            $data[2] = $row['email'];
            $data[3] = $row['deptname'];
            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
        }
        $writer->close();
    }

    public function exportcsr()
    {
        set_time_limit(0);
        ini_set('memory_limit', -1);
        $userid =$this->userdata['user_id'];
        $perms=explode(",",$this->userdata['upermission']);
        $q = $this->input->post('search');
        
        if($q!=''){
            if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
                if ($this->userdata['urole_id']==3) {
                
                    $items = 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=4 AND m.status="1" AND m.urole_id="3" AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'" AND (m.resource_id LIKE "%'.$q.'%" OR m.firstname LIKE "%'.$q.'%" OR m.email LIKE "%'.$q.'%" OR b.deptname LIKE "%'.$q.'%")';
                }else if ($this->userdata['urole_id']==2) {
                    $items = 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=4 AND m.status="1" AND m.urole_id="2" AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'" AND (m.resource_id LIKE "%'.$q.'%" OR m.firstname LIKE "%'.$q.'%" OR m.email LIKE "%'.$q.'%" OR b.deptname LIKE "%'.$q.'%")';
                }else{

                    $items = 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=4 AND m.urole_id="1" AND m.status="1" AND m.user_id !="'.$userid.'" AND (m.resource_id LIKE "%'.$q.'%" OR m.firstname LIKE "%'.$q.'%" OR m.email LIKE "%'.$q.'%" OR b.deptname LIKE "%'.$q.'%")';
                }
            }else{

                    $items= 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1" AND b.dept_id=4 AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'" AND (m.resource_id LIKE "%'.$q.'%" OR m.firstname LIKE "%'.$q.'%" OR m.email LIKE "%'.$q.'%" OR b.deptname LIKE "%'.$q.'%")';
            }

        }else{

            if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
                if ($this->userdata['urole_id']==3) {
                
                    $items= 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=4 AND m.status="1" AND m.urole_id="3" AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'"';
                }else if ($this->userdata['urole_id']==2) {
                    $items = 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=4 AND m.status="1" AND m.urole_id="2" AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'"';
                }else{

                    $items = 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=4 AND m.urole_id="1" AND m.status="1" AND m.user_id !="'.$userid.'"';
                }
            }else{

                $items = 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1" AND b.dept_id=4 AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'"';
            }
        }


        

        $query=$this->db->query($items);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'Staff.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser
        $cells = [
                WriterEntityFactory::createCell('Resource ID'),
                // WriterEntityFactory::createCell('Profile Picture'),
                WriterEntityFactory::createCell('First Name'),
                WriterEntityFactory::createCell('Email'),
                WriterEntityFactory::createCell('Department Name'),
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
        //$writer->addRow(array('resource_id', 'lic_number', 'business_name', 'user_cat_name', 'Distributor Name','email','end date'));

        foreach ($obj as $row) {
            $data[0] = $row['resource_id'];
            // $data[1] = base_url().'uploads/user/'.$row['profilepicture'];
            $data[1] = $row['username'];
            $data[2] = $row['email'];
            $data[3] = $row['deptname'];
            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
        }
        $writer->close();
    }

    public function exportbde()
    {
        set_time_limit(0);
        ini_set('memory_limit', -1);
        $userid =$this->userdata['user_id'];
        $perms=explode(",",$this->userdata['upermission']);
        $q = $this->input->post('search');
        
        if($q!=''){
            if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
                if ($this->userdata['urole_id']==3) {
                
                    $items = 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=11 AND m.status="1" AND m.urole_id="3" AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'" AND (m.resource_id LIKE "%'.$q.'%" OR m.firstname LIKE "%'.$q.'%" OR m.email LIKE "%'.$q.'%" OR b.deptname LIKE "%'.$q.'%" )';
                }else if ($this->userdata['urole_id']==2) {
                    $items = 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=11 AND m.status="1" AND m.urole_id="2" AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'" AND (m.resource_id LIKE "%'.$q.'%" OR m.firstname LIKE "%'.$q.'%" OR m.email LIKE "%'.$q.'%" OR b.deptname LIKE "%'.$q.'%")';
                }else{

                    $items = 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=11 AND m.urole_id="1" AND m.status="1" AND m.user_id !="'.$userid.'" AND (m.resource_id LIKE "%'.$q.'%" OR m.firstname LIKE "%'.$q.'%" OR m.email LIKE "%'.$q.'%" OR b.deptname LIKE "%'.$q.'%")';
                }
            }else{

                    $items= 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1" AND b.dept_id=11 AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'" AND (m.resource_id LIKE "%'.$q.'%" OR m.firstname LIKE "%'.$q.'%" OR m.email LIKE "%'.$q.'%" OR b.deptname LIKE "%'.$q.'%")';
            }

        }else{

            if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
                if ($this->userdata['urole_id']==3) {
                
                    $items= 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=11 AND m.status="1" AND m.urole_id="3" AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'"';
                }else if ($this->userdata['urole_id']==2) {
                    $items = 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=11 AND m.status="1" AND m.urole_id="2" AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'"';
                }else{

                    $items = 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=11 AND m.urole_id="1" AND m.status="1" AND m.user_id !="'.$userid.'"';
                }
            }else{

                $items = 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1" AND b.dept_id=11 AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'"';
            }
        }
        

        $query=$this->db->query($items);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'Staff.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser
        $cells = [
                WriterEntityFactory::createCell('Resource ID'),
                // WriterEntityFactory::createCell('Profile Picture'),
                WriterEntityFactory::createCell('First Name'),
                WriterEntityFactory::createCell('Email'),
                WriterEntityFactory::createCell('Department Name'),
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
        //$writer->addRow(array('resource_id', 'lic_number', 'business_name', 'user_cat_name', 'Distributor Name','email','end date'));

        foreach ($obj as $row) {
            $data[0] = $row['resource_id'];
            // $data[1] = base_url().'uploads/user/'.$row['profilepicture'];
            $data[1] = $row['username'];
            $data[2] = $row['email'];
            $data[3] = $row['deptname'];
            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
        }
        $writer->close();
    }

     public function exportas()
    {
        set_time_limit(0);
        ini_set('memory_limit', -1);
        $userid =$this->userdata['user_id'];
        $perms=explode(",",$this->userdata['upermission']);
        $q = $this->input->post('search');
        
        if($q!=''){
            if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
                if ($this->userdata['urole_id']==3) {
                
                    $items = 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=3 AND m.status="1" AND m.urole_id="3" AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'" AND (m.resource_id LIKE "%'.$q.'%" OR m.firstname LIKE "%'.$q.'%" OR m.email LIKE "%'.$q.'%" OR b.deptname LIKE "%'.$q.'%" )';
                }else if ($this->userdata['urole_id']==2) {
                    $items = 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=3 AND m.status="1" AND m.urole_id="2" AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'" AND (m.resource_id LIKE "%'.$q.'%" OR m.firstname LIKE "%'.$q.'%" OR m.email LIKE "%'.$q.'%" OR b.deptname LIKE "%'.$q.'%")';
                }else{

                    $items = 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=3 AND m.urole_id="1" AND m.status="1" AND m.user_id !="'.$userid.'" AND (m.resource_id LIKE "%'.$q.'%" OR m.firstname LIKE "%'.$q.'%" OR m.email LIKE "%'.$q.'%" OR b.deptname LIKE "%'.$q.'%")';
                }
            }else{

                    $items= 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1" AND b.dept_id=3 AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'" AND (m.resource_id LIKE "%'.$q.'%" OR m.firstname LIKE "%'.$q.'%" OR m.email LIKE "%'.$q.'%" OR b.deptname LIKE "%'.$q.'%")';
            }

        }else{

            if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
                if ($this->userdata['urole_id']==3) {
                
                    $items= 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=3 AND m.status="1" AND m.urole_id="3" AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'"';
                }else if ($this->userdata['urole_id']==2) {
                    $items = 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=3 AND m.status="1" AND m.urole_id="2" AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'"';
                }else{

                    $items = 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=3 AND m.urole_id="1" AND m.status="1" AND m.user_id !="'.$userid.'"';
                }
            }else{

                $items = 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1" AND b.dept_id=3 AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'"';
            }
        }
        

        $query=$this->db->query($items);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'Staff.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser
        $cells = [
                WriterEntityFactory::createCell('Resource ID'),
                // WriterEntityFactory::createCell('Profile Picture'),
                WriterEntityFactory::createCell('First Name'),
                WriterEntityFactory::createCell('Email'),
                WriterEntityFactory::createCell('Department Name'),
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
        //$writer->addRow(array('resource_id', 'lic_number', 'business_name', 'user_cat_name', 'Distributor Name','email','end date'));

        foreach ($obj as $row) {
            $data[0] = $row['resource_id'];
            // $data[1] = base_url().'uploads/user/'.$row['profilepicture'];
            $data[1] = $row['username'];
            $data[2] = $row['email'];
            $data[3] = $row['deptname'];
            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
        }
        $writer->close();
    }

    public function exportcomofficer()
    {
        set_time_limit(0);
        ini_set('memory_limit', -1);
        $userid =$this->userdata['user_id'];
        $perms=explode(",",$this->userdata['upermission']);
        $q = $this->input->post('search');
        
        if($q!=''){
            if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
                if ($this->userdata['urole_id']==3) {
                
                    $items = 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=7 AND m.status="1" AND m.urole_id="3" AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'" AND (m.resource_id LIKE "%'.$q.'%" OR m.firstname LIKE "%'.$q.'%" OR m.email LIKE "%'.$q.'%" OR b.deptname LIKE "%'.$q.'%")';
                }else if ($this->userdata['urole_id']==2) {
                    $items = 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=7 AND m.status="1" AND m.urole_id="2" AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'" AND (m.resource_id LIKE "%'.$q.'%" OR m.firstname LIKE "%'.$q.'%" OR m.email LIKE "%'.$q.'%" OR b.deptname LIKE "%'.$q.'%")';
                }else{

                    $items = 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=7 AND m.urole_id="1" AND m.status="1" AND m.user_id !="'.$userid.'" AND (m.resource_id LIKE "%'.$q.'%" OR m.firstname LIKE "%'.$q.'%" OR m.email LIKE "%'.$q.'%" OR b.deptname LIKE "%'.$q.'%")';
                }
            }else{

                    $items= 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1" AND b.dept_id=7 AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'" AND (m.resource_id LIKE "%'.$q.'%" OR m.firstname LIKE "%'.$q.'%" OR m.email LIKE "%'.$q.'%" OR b.deptname LIKE "%'.$q.'%")';
            }

        }else{

            if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
                if ($this->userdata['urole_id']==3) {
                
                    $items= 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=7 AND m.status="1" AND m.urole_id="3" AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'"';
                }else if ($this->userdata['urole_id']==2) {
                    $items = 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=7 AND m.status="1" AND m.urole_id="2" AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'"';
                }else{

                    $items = 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=7 AND m.urole_id="1" AND m.status="1" AND m.user_id !="'.$userid.'"';
                }
            }else{

                $items = 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1" AND b.dept_id=7 AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'"';
            }
        }
        

        $query=$this->db->query($items);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'Staff.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser
        $cells = [
                WriterEntityFactory::createCell('Resource ID'),
                // WriterEntityFactory::createCell('Profile Picture'),
                WriterEntityFactory::createCell('First Name'),
                WriterEntityFactory::createCell('Email'),
                WriterEntityFactory::createCell('Department Name'),
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
        //$writer->addRow(array('resource_id', 'lic_number', 'business_name', 'user_cat_name', 'Distributor Name','email','end date'));

        foreach ($obj as $row) {
            $data[0] = $row['resource_id'];
            // $data[1] = base_url().'uploads/user/'.$row['profilepicture'];
            $data[1] = $row['username'];
            $data[2] = $row['email'];
            $data[3] = $row['deptname'];
            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
        }
        $writer->close();
    }

    public function exportit()
    {
        set_time_limit(0);
        ini_set('memory_limit', -1);
        $userid =$this->userdata['user_id'];
        $perms=explode(",",$this->userdata['upermission']);
        $q = $this->input->post('search');
        
        if($q!=''){
            if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
                if ($this->userdata['urole_id']==3) {
                
                    $items = 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=10 AND m.status="1" AND m.urole_id="3" AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'" AND (m.resource_id LIKE "%'.$q.'%" OR m.firstname LIKE "%'.$q.'%" OR m.email LIKE "%'.$q.'%" OR b.deptname LIKE "%'.$q.'%" )';
                }else if ($this->userdata['urole_id']==2) {
                    $items = 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=10 AND m.status="1" AND m.urole_id="2" AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'" AND (m.resource_id LIKE "%'.$q.'%" OR m.firstname LIKE "%'.$q.'%" OR m.email LIKE "%'.$q.'%" OR b.deptname LIKE "%'.$q.'%")';
                }else{

                    $items = 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=10 AND m.urole_id="1" AND m.status="1" AND m.user_id !="'.$userid.'" AND (m.resource_id LIKE "%'.$q.'%" OR m.firstname LIKE "%'.$q.'%" OR m.email LIKE "%'.$q.'%" OR b.deptname LIKE "%'.$q.'%")';
                }
            }else{

                    $items= 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1" AND b.dept_id=10 AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'" AND (m.resource_id LIKE "%'.$q.'%" OR m.firstname LIKE "%'.$q.'%" OR m.email LIKE "%'.$q.'%" OR b.deptname LIKE "%'.$q.'%")';
            }

        }else{

            if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
                if ($this->userdata['urole_id']==3) {
                
                    $items= 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=10 AND m.status="1" AND m.urole_id="3" AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'"';
                }else if ($this->userdata['urole_id']==2) {
                    $items = 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=10 AND m.status="1" AND m.urole_id="2" AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'"';
                }else{

                    $items = 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=10 AND m.urole_id="1" AND m.status="1" AND m.user_id !="'.$userid.'"';
                }
            }else{

                $items = 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1" AND b.dept_id=10 AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'"';
            }
        }
        

        $query=$this->db->query($items);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'Staff.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser
        $cells = [
                WriterEntityFactory::createCell('Resource ID'),
                // WriterEntityFactory::createCell('Profile Picture'),
                WriterEntityFactory::createCell('First Name'),
                WriterEntityFactory::createCell('Email'),
                WriterEntityFactory::createCell('Department Name'),
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
        //$writer->addRow(array('resource_id', 'lic_number', 'business_name', 'user_cat_name', 'Distributor Name','email','end date'));

        foreach ($obj as $row) {
            $data[0] = $row['resource_id'];
            // $data[1] = base_url().'uploads/user/'.$row['profilepicture'];
            $data[1] = $row['username'];
            $data[2] = $row['email'];
            $data[3] = $row['deptname'];
            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
        }
        $writer->close();
    }

    public function exportkams()
    {
        set_time_limit(0);
        ini_set('memory_limit', -1);
        $userid =$this->userdata['user_id'];
        $perms=explode(",",$this->userdata['upermission']);
        $q = $this->input->post('search');
        
        if($q!=''){
            if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
                if ($this->userdata['urole_id']==3) {
                
                    $items = 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=5 AND m.status="1" AND m.urole_id="3" AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'" AND (m.resource_id LIKE "%'.$q.'%" OR m.firstname LIKE "%'.$q.'%" OR m.email LIKE "%'.$q.'%" OR b.deptname LIKE "%'.$q.'%") ';
                }else if ($this->userdata['urole_id']==2) {
                    $items = 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=5 AND m.status="1" AND m.urole_id="2" AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'" AND (m.resource_id LIKE "%'.$q.'%" OR m.firstname LIKE "%'.$q.'%" OR m.email LIKE "%'.$q.'%" OR b.deptname LIKE "%'.$q.'%")';
                }else{

                    $items = 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=5 AND m.urole_id="1" AND m.status="1" AND m.user_id !="'.$userid.'" AND (m.resource_id LIKE "%'.$q.'%" OR m.firstname LIKE "%'.$q.'%" OR m.email LIKE "%'.$q.'%" OR b.deptname LIKE "%'.$q.'%")';
                }
            }else{

                    $items= 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1" AND b.dept_id=5 AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'" AND (m.resource_id LIKE "%'.$q.'%" OR m.firstname LIKE "%'.$q.'%" OR m.email LIKE "%'.$q.'%" OR b.deptname LIKE "%'.$q.'%")';
            }

        }else{

            if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
                if ($this->userdata['urole_id']==3) {
                
                    $items= 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=5 AND m.status="1" AND m.urole_id="3" AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'"';
                }else if ($this->userdata['urole_id']==2) {
                    $items = 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=5 AND m.status="1" AND m.urole_id="2" AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'"';
                }else{

                    $items = 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=5 AND m.urole_id="1" AND m.status="1" AND m.user_id !="'.$userid.'"';
                }
            }else{

                $items = 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1" AND b.dept_id=5 AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'"';
            }
        }
        

        $query=$this->db->query($items);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'Staff.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser
        $cells = [
                WriterEntityFactory::createCell('Resource ID'),
                // WriterEntityFactory::createCell('Profile Picture'),
                WriterEntityFactory::createCell('First Name'),
                WriterEntityFactory::createCell('Email'),
                WriterEntityFactory::createCell('Department Name'),
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
        //$writer->addRow(array('resource_id', 'lic_number', 'business_name', 'user_cat_name', 'Distributor Name','email','end date'));

        foreach ($obj as $row) {
            $data[0] = $row['resource_id'];
            // $data[1] = base_url().'uploads/user/'.$row['profilepicture'];
            $data[1] = $row['username'];
            $data[2] = $row['email'];
            $data[3] = $row['deptname'];
            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
        }
        $writer->close();
    }

    public function exportmarket()
    {
        set_time_limit(0);
        ini_set('memory_limit', -1);
        $userid =$this->userdata['user_id'];
        $perms=explode(",",$this->userdata['upermission']);
        $q = $this->input->post('search');
        
        if($q!=''){
            if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
                if ($this->userdata['urole_id']==3) {
                
                    $items = 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=9 AND m.status="1" AND m.urole_id="3" AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'" AND (m.resource_id LIKE "%'.$q.'%" OR m.firstname LIKE "%'.$q.'%" OR m.email LIKE "%'.$q.'%" OR b.deptname LIKE "%'.$q.'%")';
                }else if ($this->userdata['urole_id']==2) {
                    $items = 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=9 AND m.status="1" AND m.urole_id="2" AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'" AND (m.resource_id LIKE "%'.$q.'%" OR m.firstname LIKE "%'.$q.'%" OR m.email LIKE "%'.$q.'%" OR b.deptname LIKE "%'.$q.'%")';
                }else{

                    $items = 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=9 AND m.urole_id="1" AND m.status="1" AND m.user_id !="'.$userid.'" AND (m.resource_id LIKE "%'.$q.'%" OR m.firstname LIKE "%'.$q.'%" OR m.email LIKE "%'.$q.'%" OR b.deptname LIKE "%'.$q.'%")';
                }
            }else{

                    $items= 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1" AND b.dept_id=9 AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'" AND (m.resource_id LIKE "%'.$q.'%" OR m.firstname LIKE "%'.$q.'%" OR m.email LIKE "%'.$q.'%" OR b.deptname LIKE "%'.$q.'%")';
            }

        }else{

            if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
                if ($this->userdata['urole_id']==3) {
                
                    $items= 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=9 AND m.status="1" AND m.urole_id="3" AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'"';
                }else if ($this->userdata['urole_id']==2) {
                    $items = 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=9 AND m.status="1" AND m.urole_id="2" AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'"';
                }else{

                    $items = 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=9 AND m.urole_id="1" AND m.status="1" AND m.user_id !="'.$userid.'"';
                }
            }else{

                $items = 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1" AND b.dept_id=9 AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'"';
            }
        }
        

        $query=$this->db->query($items);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'Staff.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser
        $cells = [
                WriterEntityFactory::createCell('Resource ID'),
                // WriterEntityFactory::createCell('Profile Picture'),
                WriterEntityFactory::createCell('First Name'),
                WriterEntityFactory::createCell('Email'),
                WriterEntityFactory::createCell('Department Name'),
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
        //$writer->addRow(array('resource_id', 'lic_number', 'business_name', 'user_cat_name', 'Distributor Name','email','end date'));

        foreach ($obj as $row) {
            $data[0] = $row['resource_id'];
            // $data[1] = base_url().'uploads/user/'.$row['profilepicture'];
            $data[1] = $row['username'];
            $data[2] = $row['email'];
            $data[3] = $row['deptname'];
            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
        }
        $writer->close();
    }

    public function exportprod()
    {
        set_time_limit(0);
        ini_set('memory_limit', -1);
        $userid =$this->userdata['user_id'];
        $perms=explode(",",$this->userdata['upermission']);
        $q = $this->input->post('search');
        
        if($q!=''){
            if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
                if ($this->userdata['urole_id']==3) {
                
                    $items = 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=8 AND m.status="1" AND m.urole_id="3" AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'" AND (m.resource_id LIKE "%'.$q.'%" OR m.firstname LIKE "%'.$q.'%" OR m.email LIKE "%'.$q.'%" OR b.deptname LIKE "%'.$q.'%")';
                }else if ($this->userdata['urole_id']==2) {
                    $items = 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=8 AND m.status="1" AND m.urole_id="2" AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'" AND (m.resource_id LIKE "%'.$q.'%" OR m.firstname LIKE "%'.$q.'%" OR m.email LIKE "%'.$q.'%" OR b.deptname LIKE "%'.$q.'%")';
                }else{

                    $items = 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=8 AND m.urole_id="1" AND m.status="1" AND m.user_id !="'.$userid.'" AND (m.resource_id LIKE "%'.$q.'%" OR m.firstname LIKE "%'.$q.'%" OR m.email LIKE "%'.$q.'%" OR b.deptname LIKE "%'.$q.'%")';
                }
            }else{

                    $items= 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1" AND b.dept_id=8 AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'" AND (m.resource_id LIKE "%'.$q.'%" OR m.firstname LIKE "%'.$q.'%" OR m.email LIKE "%'.$q.'%" OR b.deptname LIKE "%'.$q.'%")';
            }

        }else{

            if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
                if ($this->userdata['urole_id']==3) {
                
                    $items= 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=8 AND m.status="1" AND m.urole_id="3" AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'"';
                }else if ($this->userdata['urole_id']==2) {
                    $items = 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=8 AND m.status="1" AND m.urole_id="2" AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'"';
                }else{

                    $items = 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE b.dept_id=8 AND m.urole_id="1" AND m.status="1" AND m.user_id !="'.$userid.'"';
                }
            }else{

                $items = 'SELECT m.resource_id,m.profilepicture,CONCAT_WS(" ",firstname,lastname) AS username,m.email,b.deptname,m.user_id FROM user as m LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1" AND b.dept_id=8 AND m.createdby="'.$userid.'" AND m.user_id !="'.$userid.'"';
            }
        }
        

        $query=$this->db->query($items);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'Staff.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser
        $cells = [
                WriterEntityFactory::createCell('Resource ID'),
                // WriterEntityFactory::createCell('Profile Picture'),
                WriterEntityFactory::createCell('First Name'),
                WriterEntityFactory::createCell('Email'),
                WriterEntityFactory::createCell('Department Name'),
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
        //$writer->addRow(array('resource_id', 'lic_number', 'business_name', 'user_cat_name', 'Distributor Name','email','end date'));

        foreach ($obj as $row) {
            $data[0] = $row['resource_id'];
            // $data[1] = base_url().'uploads/user/'.$row['profilepicture'];
            $data[1] = $row['username'];
            $data[2] = $row['email'];
            $data[3] = $row['deptname'];
            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
        }
        $writer->close();
    }

}