<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH. 'third_party/Spout/Autoloader/autoload.php';
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;

use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;
class Ticket extends MY_Controller {

   public function __construct(){
        parent::__construct();
        $this->userdata = $this->session->userdata('userdata');
    }
    
    public function index()
    {
        $data['meta_title'] = "Ticket";
        $this->load->view('ticket/ticket');
    }

    public function ajax()
    {
            $user_id = $this->userdata['user_id'];
            $perms=explode(",",$this->userdata['upermission']);
            $datatables = new Datatables(new CodeigniterAdapter);

            $where = 'm.status="1"';

            if($this->userdata['dept_id']==2){
                $where .= ' AND (u.urole_id='.$this->userdata['urole_id']; 
                if($this->userdata['urole_id']==3){ $where .= ' OR u.createdby='.$this->userdata['user_id'].')';  }else{
                    $where .= ')';
                } 

            }elseif($this->userdata['dept_id']==8 && $this->userdata['urole_id']==1){
                $where .= ' AND (m.user_id='.$user_id.' OR FIND_IN_SET('.$user_id.',m.tic_users))';
            }elseif($this->userdata['dept_id']!=2 && $this->userdata['dept_id']!=5){
                $where .= ' AND u.urole_id='.$this->userdata['urole_id'].' AND (m.user_id='.$user_id.' OR FIND_IN_SET('.$user_id.',m.tic_users))';
            }elseif($this->userdata['dept_id']==5){
                $where .= ' AND (( u.urole_id='.$this->userdata['urole_id'].' AND (m.user_id='.$user_id.' OR FIND_IN_SET('.$user_id.',m.tic_users))) OR (m.upper_level='.$user_id.') AND act.tic_activity_type="comment")';

                $query='SELECT m.tic_title,m.tic_number,concat(u.firstname," ",u.lastname) as name,m.business_name,m.tic_status,b.tic_cat_name,m.tic_id 
                FROM ticket as m 
                LEFT JOIN ticket_category as b ON m.tic_cat_id = b.tic_cat_id 
                LEFT JOIN user as u ON m.user_id = u.user_id 
                LEFT JOIN ticket_activity as act ON act.tic_id = m.tic_id

                WHERE  '.$where;

            }

            if($this->userdata['dept_id']!=5){

                $query='SELECT m.tic_title,m.tic_number,concat(u.firstname," ",u.lastname) as name,m.business_name,m.tic_status,b.tic_cat_name,m.tic_id FROM ticket as m LEFT JOIN ticket_category as b ON m.tic_cat_id = b.tic_cat_id LEFT JOIN user as u ON m.user_id = u.user_id WHERE  '.$where;

            }

            //echo $query; exit;
            $datatables->query($query);
            $datatables->edit('business_name', function ($data) {
                    if($data['business_name']){
                        return $data['business_name']; 
                    }else{
                        return "-"; 
                    }
                });

            $datatables->edit('tic_status', function ($data) {
                    if($data['tic_status']=='0'){
                       $st= 'Open';
                    }else if($data['tic_status']=='1'){
                       $st= 'Pending';
                    }else if($data['tic_status']=='2'){
                       $st= 'Resolved';
                    }else{
                       $st= 'Spam';
                    }
                        return $st; 
                });
                    // // edit 'id' column
             $datatables->edit('tic_id', function($data) use($perms){
                    $uid = encoding($data['tic_id']);
                        $menu='';
                        if(in_array('TIC_VD',$perms)){
                            $menu.='<li>
                            <a href="'.site_url('ticket/viewticket/').encoding($data['tic_id']).'">
                                <span class="glyphicon glyphicon-eye-open"></span> View
                            </a>
                            </li>'; 
                        }

                        if(in_array('TIC_E',$perms)){
                            $menu.='<li>
                           <a href="'.site_url('ticket/editticket/').encoding($data['tic_id']).'">
                                <span class="glyphicon glyphicon-pencil"></span> Edit
                            </a>
                            </li>'; 
                        }

                        if(in_array('TIC_DL',$perms)){
                            $menu.='<li>
                           <a href="'.site_url('ticket/exportnote/').encoding($data['tic_id']).'">
                                <span class="glyphicon glyphicon-download-alt"></span> Download
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
    
    public function addticket(){

        if(!empty($this->input->post()) && $this->input->is_ajax_request()){

            if($this->form_validation->run('add_ticket')){

                $createddate = date('Y-m-d h:i:s');
                $createdby = $this->userdata['user_id'];
                $tic_num =  rand(111,999);
                $ipaddress = $this->input->ip_address();
                $tic_status = $this->input->post('tic_status');
                $tic_cat_id = $this->input->post('tic_cat_id');

                if(empty($this->input->post('tic_users'))){
                    $return = array('success'=>false,'msg'=>'Please select user to assign');
                    echo json_encode($return); exit;
                }else{
                    $tic_users = implode(',',array_filter($this->input->post('tic_users')));
                }

                $data = array(
                    'tic_number' => $tic_num, 
                    'tic_cat_id' => $tic_cat_id, 
                    'tic_title' => $this->input->post('tic_title'), 
                    'user_id' => $createdby, 
                    'tic_users' => $tic_users, 
                    //'tic_status' => $tic_status, 
                    'tic_status' =>'0', 
                    'tic_desc' => $this->input->post('tic_desc'), 
                    'tic_createdate' => $createddate, 
              
                );

                $mycreator = $this->userdata['createdby'];

                if($this->userdata['urole_id']==2 ||$this->userdata['urole_id']==3){
                    $creatorData = $this->generalmodel->getparticularData("assign_to,urole_id,dept_id",'user',"user_id=".$mycreator,"row_array");
                    $data['upper_level'] = $creatorData['assign_to'];
                }

                if($this->userdata['urole_id']==5)
                {
                    $bname = $this->generalmodel->getparticularData('supplier_bname','supplier',array('user_id'=>$this->userdata['user_id']),"row_array");
                   
                    $data['business_name']= $bname['supplier_bname'];
                }

                if($this->userdata['urole_id']==3)
                {
                    $bname = $this->generalmodel->getparticularData('business_name','indassociation',array('user_id'=>$this->userdata['user_id']),"row_array");
                    $data['business_name']= $bname['business_name'];
                }

                if($this->userdata['urole_id']==2)
                {
                    $bname = $this->generalmodel->getparticularData('business_name','licensee',array('user_id'=>$this->userdata['user_id']),"row_array");
                    $data['business_name']= $bname['business_name'];
                }

                $query = $this->generalmodel->add('ticket',$data);
                if(!empty($query)){
                    /**************************************Mail***************************************/
                         $otherusers ='';
                         //==========creator=============  
                    $link = site_url('ticket/viewticket/').encoding($query);
                    $deslink = '<a href="'.$link.'" style="background: #8DC63F; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';


                    $tic = $this->generalmodel->getparticularData('tic_cat_id,tic_cat_name','ticket_category',array('tic_cat_id'=>$tic_cat_id),$returnType="row_array");
                   
                    $to = $this->userdata['email'];
                    $name = $this->userdata['firstname'].' '.$this->userdata['lastname'];
                    if($tic_status=='0'){
                       $st= 'Open';
                    }else if($tic_status=='1'){
                       $st= 'Pending';
                    }else if($tic_status=='2'){
                       $st= 'Resolved';
                    }else{
                       $st= 'Spam';
                    }



                    if(!empty($tic_users)){
                        $assigned_users = $this->generalmodel->getparticularData('CONCAT_WS(" ",firstname,lastname) AS username,email','user',"`user_id` IN(".$tic_users.")","result_array");

                        $f = array_column($assigned_users,'username');
                        $otherusers = implode(', ',$f);
                    }  


                    $mailContent = $this->generalmodel->mail_template('email_subject,email_body','ticket_created');

                    $content = $mailContent['email_body'];
                    $content = str_replace('[name]',$name,$content);
                    $content = str_replace('[ticket_number]',$tic_num,$content);
                    $content = str_replace('[ticket_status]',$st,$content);
                    $content = str_replace('[ticket_category]',$tic['tic_cat_name'],$content);
                    $content = str_replace('[user_name]',$otherusers,$content); 
                    $content = str_replace('[link]',$deslink,$content); 

                    $subject = $mailContent['email_subject'];
                    $subject = str_replace('[ticket_number]',$tic_num,$subject);
                    
                    $message = $this->load->view('include/mail_template',array('body'=>$content),true);


                    $mailresponce = $this->sendGridMail('',$to,$subject,$message);
                            


                    if(!empty($tic_users)){
                         //==========other users=============  

              
                    $mailContentN = $this->generalmodel->mail_template('email_subject,email_body','ticket_created_user');


                    $content1 = $mailContentN['email_body'];
                   
                    $content1 = str_replace('[ticket_number]',$tic_num,$content1);
                    $content1 = str_replace('[ticket_status]',$st,$content1);
                    $content1 = str_replace('[ticket_category]',$tic['tic_cat_name'],$content1);
                    $content1 = str_replace('[link]',$deslink,$content1); 

                    $subject1 = $mailContentN['email_subject'];
                    $subject1 = str_replace('[ticket_number]',$tic_num,$subject1);

                    $message1 = $this->load->view('include/mail_template',array('body'=>$content1),true);

                    foreach ($assigned_users as $value) { 

                        $to_name = $value['username'];
                        $to_email= $value['email'];

                        $cont = $content1;

                        $cont = str_replace('[name]',$value['username'],$cont);
                        $cont = str_replace('[user_name]',$otherusers,$cont);


                        $message1 = $this->load->view('include/mail_template',array('body'=>$cont),true);


                        $mailresponce1 = $this->sendGridMail('',$to_email,$subject1,$message1);

                     }
                    }
                         
                    /*****************************************************************************/ 
                    $return = array('success'=>true,'msg'=>'Ticket addedd successfully');
                }else{
                    $return = array('success'=>false,'msg'=>'something went wrong');
                }
            }else{
                $return = array('success'=>false,'msg'=>validation_errors());
            }
            echo json_encode($return); exit;
        }else{
           
           //echo "<pre>" ; print_r($_SESSION); exit;
            $where = "`status`=1 AND `user_id`!=".$this->userdata['user_id']." AND `user_level`=".$this->userdata['user_level']." AND createdby=".$this->userdata['createdby']." AND `urole_id` NOT IN(4,5)  AND `dept_id` NOT IN(1,2)";
            //$data['user'] = $this->generalmodel->get_data_by_condition('firstname,lastname,user_id','user',$where);
            $data['user'] = $this->generalmodel->getparticularData('firstname,lastname,user_id,urole_id','user',$where,"result_array",$limit="",$start="","firstname");

            $data['category'] = $this->generalmodel->get_data_by_condition('tic_cat_name,tic_parent_id,tic_cat_id','ticket_category',array('tic_del_status'=>1));
            //$data['countrylist'] = $this->generalmodel->countrylist();
            $data['meta_title'] = "Add Ticket";
            $this->load->view('ticket_form',$data);
        }
    }

    public function editticket($id)
    {  $id =  decoding($id);
        if(!empty($this->input->post()) && $this->input->is_ajax_request()){

            if($this->form_validation->run('edit_ticket')){
               
                // $createddate = date('Y-m-d h:i:s');
                 $createdby = $this->userdata['user_id'];
                 $tic_users = implode(',', $this->input->post('tic_users'));
                 $tic_status = $this->input->post('tic_status');
                 $tic_cat_id = $this->input->post('tic_cat_id');

                $id = $this->input->post('id');
                $data = array(
                    'tic_cat_id' => $this->input->post('tic_cat_id'), 
                    'tic_title' => $this->input->post('tic_title'), 
                    'tic_users' => $tic_users, 
                    'tic_status' => $tic_status, 
                    'tic_desc' => $this->input->post('tic_desc'), 
            
                );

                $query = $this->generalmodel->updaterecord('ticket',$data,'tic_id='.$id);
                if(!empty($query)){
                    /**************************************Mail***************************************/
                    // $cstatus = $this->generalmodel->getparticularData('tic_status','ticket',array('tic_status!='=>$tic_status,'tic_id'=>$id),$returnType="result_array");
                    // print_r($cstatus); exit;
                    // if(empty($cstatus)){

                    //         $link = site_url('ticket/viewticket/').encoding($id);

                    //         $mailContent = $this->generalmodel->mail_template('email_subject,email_body','ticket_updated_status');

                    //         $user = $this->generalmodel->getparticularData('firstname,lastname,user_id,email','user',array('user_id'=>$createdby),$returnType="result_array");
                    //         $tic = $this->generalmodel->getparticularData('tic_cat_id,tic_cat_name','ticket_category',array('tic_cat_id'=>$tic_cat_id),$returnType="result_array");
                           
                    //         $to = $user[0]['email'];
                           

                    //         $name = $user[0]['firstname'].' '.$user[0]['lastname'];
                    //         // $username = $firstname.' '.$lastname;
                    //         if($tic_status=='0'){
                    //            $st= 'Open';
                    //         }else if($tic_status=='1'){
                    //            $st= 'Pending';
                    //         }else if($tic_status=='2'){
                    //            $st= 'Resolved';
                    //         }else{
                    //            $st= 'Spam';
                    //         }

                    //         $username=  $this->generalmodel->get_data_by_condition('firstname,lastname','user','user_id IN ('.$tic_users.')'); 
                    //         $uname = "";
                    //             foreach ($username as $row) {
                    //                 $uname.=$row['firstname'].' '.$row['lastname'].', ';
                    //             }
                    //          $uname = rtrim($uname,',');

                    //         $deslink = '<a href="'.$link.'" style="background: #0059b3; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

                    //         $content = $mailContent['email_body'];
                    //         $content = str_replace('[name]',$name,$content);
                    //         $content = str_replace('[ticket_number]',$tic_num,$content);
                    //         $content = str_replace('[ticket_status]',$st,$content);
                    //         $content = str_replace('[ticket_category]',$tic[0]['tic_cat_name'],$content);
                    //         $content = str_replace('[user_name]',$uname,$content); 
                    //         $content = str_replace('[link]',$deslink,$content); 

                    //         $subject = $mailContent['email_subject'];
                    //         $subject = str_replace('[ticket_number]',$username,$subject);
                            
                    //         $message = $this->load->view('include/mail_template',array('body'=>$content),true);
                            
                    //         $mailresponce = $this->sendGridMail('',$to,$subject,$message);
                            
                    //         $users = explode(',',$tic_users);
                    //         for ($i=0; $i < count($users) ; $i++) { 
                    //             $userss = $this->generalmodel->getparticularData('firstname,lastname,user_id,email','user',array('user_id'=>$users[$i]),$returnType="result_array");
                            
                    //         $mailContentN = $this->generalmodel->mail_template('email_subject,email_body','ticket_updated_status_user');
                    //             $uname = $userss[0]['firstname'].' '.$userss[0]['lastname'];
                    //              $touser = $userss[0]['email'];
                    //         $content1 = $mailContentN['email_body'];
                    //         $content1 = str_replace('[name]',$uname,$content1);
                    //         $content1 = str_replace('[ticket_number]',$tic_num,$content1);
                    //         $content1 = str_replace('[ticket_status]',$st,$content1);
                    //         $content1 = str_replace('[ticket_category]',$tic[0]['tic_cat_name'],$content1);
                    //         $content1 = str_replace('[user_name]',$uname,$content1); 
                    //         $content1 = str_replace('[link]',$deslink,$content1); 

                    //         $subject1 = $mailContentN['email_subject'];
                    //         $subject1 = str_replace('[ticket_number]',$username,$subject1);
                            
                    //      echo $message1 = $this->load->view('include/mail_template',array('body'=>$content1),true);
                            
                    //         // $mailresponce1 = $this->sendGridMail('',$touser,$subject1,$message1);
                    //         }
                    //     }
                    /*****************************************************************************/ 
                    $return = array('success'=>true,'msg'=>'Ticket Updated successfully');
                }else{
                    $return = array('success'=>false,'msg'=>'something went wrong');
                }
            }else{
                $return = array('success'=>false,'msg'=>validation_errors());
            }
            echo json_encode($return); exit;
        }else{
            $data['category'] = $this->generalmodel->get_data_by_condition('tic_cat_name,tic_parent_id,tic_cat_id','ticket_category',array('tic_del_status'=>1));
            //$data['user'] = $this->generalmodel->get_data_by_condition('firstname,lastname,user_id','user',array('status'=>1,'user_id!='=>$this->userdata['user_id']));
           $where = "`status`=1 AND `user_id`!=".$this->userdata['user_id']." AND `user_level`=".$this->userdata['user_level']." AND createdby=".$this->userdata['createdby']." AND `urole_id` NOT IN(4,5)  AND `dept_id` NOT IN(1,2)";
            $data['user'] = $this->generalmodel->getparticularData('firstname,lastname,user_id','user',$where,"result_array",$limit="",$start="","firstname");


            $data['ticket']=$this->generalmodel->getSingleRowById('ticket', 'tic_id', $id, $returnType = 'array');
            $data['meta_title'] = "Edit Ticket";
            $this->load->view('editticket',$data);
        }
    }

    public function editlicticket($id)
    {   
        $id= decoding($id);
        if(!empty($this->input->post()) && $this->input->is_ajax_request()){

            if($this->form_validation->run('edit_ticket')){
               
                // $createddate = date('Y-m-d h:i:s');
                 // $createdby = $this->userdata['user_id'];

                $id = $this->input->post('id');
                $data = array(
                    'tic_cat_id' => $this->input->post('tic_cat_id'), 
                    'tic_title' => $this->input->post('tic_title'), 
                    // 'tic_users' => $this->input->post('tic_users'), 
                    'tic_status' => $this->input->post('tic_status'), 
                    'tic_desc' => $this->input->post('tic_desc'), 
            
                );

                $query = $this->generalmodel->updaterecord('ticket',$data,'tic_id='.$id);
                if(!empty($query)){
                   
                    $return = array('success'=>true,'msg'=>'Ticket Updated successfully');
                }else{
                    $return = array('success'=>false,'msg'=>'something went wrong');
                }
            }else{
                $return = array('success'=>false,'msg'=>validation_errors());
            }
            echo json_encode($return); exit;
        }else{
           $data['category'] = $this->generalmodel->get_data_by_condition('tic_cat_name,tic_parent_id,tic_cat_id','ticket_category',array('tic_del_status'=>1));

            $data['ticket']=$this->generalmodel->getSingleRowById('ticket', 'tic_id', $id, $returnType = 'array');
            $data['meta_title'] = "Edit Ticket";
            $this->load->view('editticket',$data);
        }
    }

    public function editiaticket($id)
    {
        $id= decoding($id);
        if(!empty($this->input->post()) && $this->input->is_ajax_request()){

            if($this->form_validation->run('edit_ticket')){
               
                // $createddate = date('Y-m-d h:i:s');
                 // $createdby = $this->userdata['user_id'];

                $id = $this->input->post('id');
                $data = array(
                    'tic_cat_id' => $this->input->post('tic_cat_id'), 
                    'tic_title' => $this->input->post('tic_title'), 
                    // 'tic_users' => $this->input->post('tic_users'), 
                    'tic_status' => $this->input->post('tic_status'), 
                    'tic_desc' => $this->input->post('tic_desc'), 
            
                );

                $query = $this->generalmodel->updaterecord('ticket',$data,'tic_id='.$id);
                if(!empty($query)){
                   
                    $return = array('success'=>true,'msg'=>'Ticket Updated successfully');
                }else{
                    $return = array('success'=>false,'msg'=>'something went wrong');
                }
            }else{
                $return = array('success'=>false,'msg'=>validation_errors());
            }
            echo json_encode($return); exit;
        }else{
            $data['category'] = $this->generalmodel->get_data_by_condition('tic_cat_name,tic_parent_id,tic_cat_id','ticket_category',array('tic_del_status'=>1));
            $data['ticket']=$this->generalmodel->getSingleRowById('ticket', 'tic_id', $id, $returnType = 'array');
            $data['meta_title'] = "Edit Ticket";
            $this->load->view('editticket',$data);
        }
    }

    public function editconticket($id)
    {
        $id= decoding($id);
        if(!empty($this->input->post()) && $this->input->is_ajax_request()){

            if($this->form_validation->run('edit_ticket')){
               
                // $createddate = date('Y-m-d h:i:s');
                 // $createdby = $this->userdata['user_id'];

                $id = $this->input->post('id');
                $data = array(
                    'tic_cat_id' => $this->input->post('tic_cat_id'), 
                    'tic_title' => $this->input->post('tic_title'), 
                    // 'tic_users' => $this->input->post('tic_users'), 
                    'tic_status' => $this->input->post('tic_status'), 
                    'tic_desc' => $this->input->post('tic_desc'), 
            
                );

                $query = $this->generalmodel->updaterecord('ticket',$data,'tic_id='.$id);
                if(!empty($query)){
                   
                    $return = array('success'=>true,'msg'=>'Ticket Updated successfully');
                }else{
                    $return = array('success'=>false,'msg'=>'something went wrong');
                }
            }else{
                $return = array('success'=>false,'msg'=>validation_errors());
            }
            echo json_encode($return); exit;
        }else{
            $data['category'] = $this->generalmodel->get_data_by_condition('tic_cat_name,tic_parent_id,tic_cat_id','ticket_category',array('tic_del_status'=>1));
            $data['ticket']=$this->generalmodel->getSingleRowById('ticket', 'tic_id', $id, $returnType = 'array');
            $data['meta_title'] = "Edit Ticket";
            $this->load->view('editticket',$data);
        }
    }



    public function viewticket($id)
    {
       $id = decoding($id);
       $data['product']= $this->generalmodel->getsingleJoinData('*','ticket','ticket_category','ticket.tic_cat_id=ticket_category.tic_cat_id','tic_id='.$id);
       $data['meta_title'] = "View Ticket";
       $this->load->view('viewticket',$data);
    }

    public function viewlicticket($id)
    {
       $id= decoding($id); 
       $data['product']= $this->generalmodel->getsingleJoinData('*','ticket','ticket_category','ticket.tic_cat_id=ticket_category.tic_cat_id','tic_id='.$id);
       $data['meta_title'] = "View Ticket";
       $this->load->view('viewticket',$data);
    }

    public function viewiaticket($id)
    {
        $id= decoding($id);
       $data['product']= $this->generalmodel->getsingleJoinData('*','ticket','ticket_category','ticket.tic_cat_id=ticket_category.tic_cat_id','tic_id='.$id);
       $data['meta_title'] = "View Ticket";
       $this->load->view('viewticket',$data);
    }

    public function viewconticket($id)
    {
       $id= decoding($id);
       $data['product']= $this->generalmodel->getsingleJoinData('*','ticket','ticket_category','ticket.tic_cat_id=ticket_category.tic_cat_id','tic_id='.$id);
       $data['meta_title'] = "View Ticket";
       $this->load->view('viewticket',$data);
    }

    public function deleteticket($id)
    {   
        $id= decoding($id);
		if ($this->input->is_ajax_request()) {
			$data = array('status'=>'0');
        		$this->generalmodel->updaterecord('ticket',$data,'tic_id='.$id);
			$return = array('success'=>true,'msg'=>'Entry Removed');
		}else{
			$return = array('success'=>false,'msg'=>'Internal Error');
		}
		echo json_encode($return);

    }


/* Ticket Category */

    public function addcategory(){

        if(!empty($this->input->post()) && $this->input->is_ajax_request()){
            if($this->form_validation->run('add_ticcategory')){
               
                $createddate = date('Y-m-d h:i:s');
                $createdby = $this->userdata['user_id'];
                $data = array(
                     
                    'tic_cat_name' => $this->input->post('tic_cat_name'), 
                    'tic_parent_id' => $this->input->post('tic_parent_id'), 
                    'tic_cat_status' => '1', 
                    'tic_del_status' => '1', 
                    'tic_cat_createdby' => $createdby, 
                    'tic_cat_createdate' => $createddate, 
                   
                );

              
                $query = $this->generalmodel->add('ticket_category',$data);
                if(!empty($query)){
                  
                    $return = array('success'=>true,'msg'=>'Ticket Category addedd successfully');
                }else{
                    $return = array('success'=>false,'msg'=>'something went wrong');
                }
            }else{
                $return = array('success'=>false,'msg'=>validation_errors());
            }
            echo json_encode($return); exit;
        }else{
            // $data['category'] = $this->generalmodel->getRowAllById('product_category', 'createdby', '0', $orderby = 'prod_cat_id', $orderformat = 'asc');
            $data['category'] = $this->generalmodel->get_data_by_condition('tic_cat_name,tic_parent_id,tic_cat_id','ticket_category',array('tic_del_status'=>1));
            $data['countrylist'] = $this->generalmodel->countrylist();
            $data['meta_title'] = "Add Ticket Category";
            $this->load->view('ticket_category',$data);
        }
    }

     public function editcategory($id){
        $id= decoding($id);
        if(!empty($this->input->post()) && $this->input->is_ajax_request()){

            if($this->form_validation->run('edit_ticcategory')){
               
                $createddate = date('Y-m-d h:i:s');
                $createdby = $this->userdata['user_id'];
                $id =$this->input->post('id');
                $data = array(
                     
                    'tic_cat_name' => $this->input->post('tic_cat_name'), 
                    'tic_parent_id' => $this->input->post('tic_parent_id'), 
                    'tic_cat_status' => $this->input->post('tic_cat_status'), 
                   
                );

                $query = $this->generalmodel->updaterecord('ticket_category',$data,'tic_cat_id='.$id);
                if(!empty($query)){
                  
                    $return = array('success'=>true,'msg'=>'Ticket Category addedd successfully');
                }else{
                    $return = array('success'=>false,'msg'=>'something went wrong');
                }
            }else{
                $return = array('success'=>false,'msg'=>validation_errors());
            }
            echo json_encode($return); exit;
        }else{
            // $data['category'] = $this->generalmodel->getRowAllById('product_category', 'createdby', '0', $orderby = 'prod_cat_id', $orderformat = 'asc');
             $data['category'] = $this->generalmodel->get_data_by_condition('tic_cat_name,tic_parent_id,tic_cat_id','ticket_category',array('tic_del_status'=>1,'tic_cat_id!='=>$id,'tic_parent_id!='=>$id,));
            $data['cate']=$this->generalmodel->getSingleRowById('ticket_category', 'tic_cat_id', $id, $returnType = 'array');
            $data['countrylist'] = $this->generalmodel->countrylist();
            $data['meta_title'] = "Edit Ticket Category";
            $this->load->view('editcategory',$data);
        }
    }
  
    public function category()
    {
        $data['meta_title'] = "Ticket Category";
        $this->load->view('ticket/category',$data);
    }

    public function ajaxcate()
    {
        $datatables = new Datatables(new CodeigniterAdapter);
         $perms=explode(",",$this->userdata['upermission']);
         // $datatables->query('SELECT tic_cat_name,tic_parent_id,tic_cat_status,tic_cat_id FROM ticket_category WHERE tic_del_status!="0"');
        
         $datatables->query('select t.`tic_cat_id` as ids,t.`tic_cat_name` as category, s.`tic_cat_name` as ticket_category,t.tic_cat_status,t.`tic_cat_id` from ticket_category as t left join ticket_category s on t.`tic_parent_id`=s.`tic_cat_id` where t.`tic_del_status`=1');


         if($this->userdata['urole_id']==1 && $this->userdata['dept_id']==2){

         $datatables->edit('ids', function ($data) {
                    return '<input type="checkbox" name="id[]" value="'.$data['tic_cat_id'].'" class="case">';
                });
         }else{
             $datatables->hide('ids');
         }         

        $datatables->edit('ticket_category', function ($data) {
                if(is_null($data['ticket_category'])){
                   $st= '-';
                }else{
                   $st= $data['ticket_category'];
                }
                    return $st; 
        });
    
        $datatables->edit('tic_cat_status', function ($data) {
            if($data['tic_cat_status']=='1'){
               $st= 'Active';
            }else{
               $st= 'Inactive';
            }
                return $st; 
        });

          if($this->userdata['urole_id']==1 && $this->userdata['dept_id']==2){
                  // // edit 'id' column
                 $datatables->edit('tic_cat_id', function($data) use($perms){
                    $uid = encoding($data['tic_cat_id']);
                        $menu='';
                        if(in_array('TIC_CAT_VD',$perms)){
                            $menu.='<li>
                            <a href="'.site_url('ticket/viewcategory/').encoding($data['tic_cat_id']).'">
                                <span class="glyphicon glyphicon-eye-open"></span> View
                            </a>
                            </li>'; 
                        }

                        if(in_array('TIC_CAT_E',$perms)){
                            $menu.='<li>
                           <a href="'.site_url('ticket/editcategory/').encoding($data['tic_cat_id']).'">
                                <span class="glyphicon glyphicon-pencil"></span> Edit
                            </a>
                            </li>'; 
                        }

                        if(in_array('TIC_CAT_D',$perms)){
                            $menu.='<li>
                          <a  href="javascript:void(0)" link="'.site_url('ticket/deletecate/').encoding($data['tic_cat_id']).'" class="deleteEntry">
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
            }else{
             $datatables->hide('tic_cat_id');
         }     

        echo $datatables->generate();
    }

    public function deletecate($id)
    {   
        $id = decoding($id);
		if ($this->input->is_ajax_request()) {
			$data = array('tic_del_status'=>'0');
        		$this->generalmodel->updaterecord('ticket_category',$data,'tic_cat_id='.$id);
			$return = array('success'=>true,'msg'=>'Entry Removed');
		}else{
			$return = array('success'=>false,'msg'=>'Internal Error');
		}
		echo json_encode($return);

    }

    public function viewcategory($id)
    {
        $id = decoding($id);
       
        $data['cate']=$this->generalmodel->getSingleRowById('ticket_category', 'tic_cat_id', $id, $returnType = 'array');
        $data['meta_title'] = "View Ticket Category";
         $this->load->view('viewcategory',$data);
    }

/*********** Add Note    ***********/
    public function addnote(){
        if($this->form_validation->run('add_ticnote')){
                
                $createdate = date('Y-m-d h:i:s');
                $createdby = $this->userdata['user_id'];
                // $resource_id =  rand(111,999);
                $assign_to = $assign_date = '';
               
                $id = $this->input->post('id');
                $ipaddress = $this->input->ip_address();
                $desc = $this->input->post('tic_activity_des');
                $data = array(
                    'tic_activity_title' => $this->input->post('tic_activity_title'), 
                    'tic_activity_des' => $this->input->post('tic_activity_des'), 
                    'tic_activity_createdate' =>  $createdate, 
                    'tic_activity_createdby' => $createdby, 
                    'tic_activity_createat' => 'ticket', 
                    // 'app_activity_createat' => 'lic-'.$this->input->post('lic_id'), 
                    'tic_activity_ipaddress' =>$ipaddress, 
                    'tic_activity_platform' => $this->agent->platform(),
                    'tic_activity_webbrowser' => $this->agent->browser(), 
                    'tic_id'=>$this->input->post('id'),
                    'tic_activity_type'=>$this->input->post('tic_activity_type'),
                );

              $lastid = $this->generalmodel->add('ticket_activity', $data);
              if ($lastid) {
/*
                  //===============================================//
                            $link = site_url('ticket/viewticket/').encoding($id);

                            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','ticket_updated');

                            $user = $this->generalmodel->getparticularData('firstname,lastname,user_id,email','user',array('user_id'=>$createdby),$returnType="result_array");
                            // $tic = $this->generalmodel->getparticularData('tic_id,tic_number,tic_users,user_id','ticket',array('tic_id'=>$id),$returnType="result_array");
                            $tic = $this->generalmodel->getsingleJoinData('tic_id,tic_number,tic_users,user.user_id','ticket','user','ticket.user_id=user.user_id',array('tic_id'=>$id));
                           
                            $to = $user[0]['email'];
                            
                            $tic_creator = $tic['firstname'].' '.$tic['firstname'];
                            $name = $user[0]['firstname'].' '.$user[0]['lastname'];
                            // $username = $firstname.' '.$lastname

                            $username=  $this->generalmodel->get_data_by_condition('firstname,lastname,user_id','user','user_id IN ('.$tic['tic_users'].')'); 
                            $uname = "";
                                foreach ($username as $row) {
                                    $uname.=$row['firstname'].' '.$row['lastname'].', ';
                                }
                             echo rtrim($uname,', ');

                            $deslink = '<a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

                            $content = $mailContent['email_body'];
                            $content = str_replace('[name]',$name,$content);
                            $content = str_replace('[ticket_number]',$tic['tic_number'],$content);
                            $content = str_replace('[note_description]',$desc,$content);
                            $content = str_replace('[note_createdate]',$createdate,$content);
                            $content = str_replace('[note_creator]',$tic_creator,$content); 
                            $content = str_replace('[view_link]',$deslink,$content); 

                            $subject = $mailContent['email_subject'];
                            $subject = str_replace('[ticket_number]',$username,$subject);
                            
                            $message = $this->load->view('include/mail_template',array('body'=>$content),true);
                            
                            $mailresponce = $this->sendGridMail('',$to,$subject,$message);
                            
                            $users = explode(',',$tic_users);
                            for ($i=0; $i < count($users) ; $i++) { 
                                $userss = $this->generalmodel->getparticularData('firstname,lastname,user_id,email','user',array('user_id'=>$users[$i]),$returnType="result_array");
                            
                            $mailContentN = $this->generalmodel->mail_template('email_subject,email_body','ticket_created_user');
                                $uname = $userss[0]['firstname'].' '.$userss[0]['lastname'];
                                $uemail = $userss[0]['email'];
                            $content1 = $mailContentN['email_body'];
                            $content1 = str_replace('[name]',$uname,$content1);
                            $content1 = str_replace('[ticket_number]',$tic['tic_number'],$content1);
                            $content1 = str_replace('[note_description]',$desc,$content1);
                            $content1 = str_replace('[note_createdate]',$createdate,$content1);
                            $content1 = str_replace('[note_creator]',$tic_creator,$content1); 
                            $content1 = str_replace('[view_link]',$deslink,$content1); 

                            $subject1 = $mailContentN['email_subject'];
                            $subject1 = str_replace('[ticket_number]',$username,$subject1);
                            
                            $message1 = $this->load->view('include/mail_template',array('body'=>$content1),true);
                            
                            $mailresponce1 = $this->sendGridMail('',$uemail,$subject1,$message1);
                            }
                    //==================================================//    
                            */


                 $return = array('success'=>true,'msg'=>'Activity Added Successfully');

                }else{
                   $return = array('success'=>false,'msg'=>'something went wrong');
                }
            }else{
                $return = array('success'=>false,'msg'=>validation_errors());
            }
            echo json_encode($return);
    }

/*
    public function viewnote()
    {
        print_r($_POST); exit;
        $userid = $this->userdata['user_id'];
        $urole_id = $this->userdata['urole_id'];
        $users = $this->input->post('users');
        $type = $this->input->post('type');
        $tic_id = $this->input->post('tic_id');
        $this->load->helper('text');
        $datatables = new Datatables(new CodeigniterAdapter);
        if($type){
            if($type=="All"){
                if($urole_id==1){
                    $datatables->query('SELECT m.tic_activity_title,concat(b.firstname," ",b.lastname) as name,m.tic_activity_des,m.tic_activity_createdate FROM ticket_activity as m LEFT JOIN user as b ON m.tic_activity_createdby = b.user_id WHERE m.tic_activity_createat ="ticket" AND m.tic_id="'.$tic_id.'" ORDER BY m.tic_activity_createdate DESC');

                }else{
                    $datatables->query('SELECT m.tic_activity_title,concat(b.firstname," ",b.lastname) as name,m.tic_activity_des,m.tic_activity_createdate FROM ticket_activity as m LEFT JOIN user as b ON m.tic_activity_createdby = b.user_id LEFT JOIN ticket as t ON t.tic_id = m.tic_id WHERE m.tic_activity_createat ="ticket" AND m.tic_id="'.$tic_id.'" AND m.tic_activity_type= "Whisper" AND FIND_IN_SET("m.tic_users", "'.$userid.'")');
                }
            }else{
                if($urole_id==1){
                        $datatables->query('SELECT m.tic_activity_title,concat(b.firstname," ",b.lastname) as name,m.tic_activity_des,m.tic_activity_createdate FROM ticket_activity as m LEFT JOIN user as b ON m.tic_activity_createdby = b.user_id WHERE m.tic_activity_createat ="ticket" AND m.tic_id="'.$tic_id.'" AND m.tic_activity_type="'.$type.'" ORDER BY m.tic_activity_createdate DESC');

                }else{
                        $datatables->query('SELECT m.tic_activity_title,concat(b.firstname," ",b.lastname) as name,m.tic_activity_des,m.tic_activity_createdate FROM ticket_activity as m LEFT JOIN user as b ON m.tic_activity_createdby = b.user_id WHERE m.tic_activity_createat ="ticket" AND m.tic_id="'.$tic_id.'" AND m.tic_activity_type= "Whisper" AND FIND_IN_SET("m.tic_users", "'.$userid.'")');
                }
            }
        }else{
                if($urole_id==1){

                    $datatables->query('SELECT m.tic_activity_title,concat(b.firstname," ",b.lastname) as name,m.tic_activity_des,m.tic_activity_createdate FROM ticket_activity as m LEFT JOIN user as b ON m.tic_activity_createdby = b.user_id WHERE m.tic_activity_createat ="ticket" AND m.tic_id="'.$tic_id.'" ORDER BY m.tic_activity_createdate DESC');
                }else{
                    $datatables->query('SELECT m.tic_activity_title,concat(b.firstname," ",b.lastname) as name,m.tic_activity_des,m.tic_activity_createdate FROM ticket_activity as m LEFT JOIN user as b ON m.tic_activity_createdby = b.user_id WHERE m.tic_activity_createat ="ticket" AND m.tic_id="'.$tic_id.'" AND m.tic_activity_type= "Whisper" AND FIND_IN_SET("m.tic_users", "'.$userid.'")');

                }
        }

         $datatables->edit('tic_activity_createdate', function ($data) {
                    $localtimzone =$this->userdata['timezone'];
                    $tic_activity_createdate = gmdate_to_mydate($data['tic_activity_createdate'],$localtimzone);
                    return date('m/d/Y',strtotime($tic_activity_createdate));
                });
         $datatables->edit('tic_activity_des', function ($data) {
            $desc = word_limiter($data['tic_activity_des'], 10);
            $readmore ='<a class="addDesc" data-id="desc" value="'.$data['tic_activity_des'].'"><span class="badge badge-pill badge-secondary">Read More</span></a>'; 
            if(strlen($data['tic_activity_des'])>strlen($desc)){
                return $desc.$readmore;
            }else{ return $desc; }
            
         });
     
        echo $datatables->generate();
    }
*/

    public function viewnote($tic_id)
    {
        $detail = $this->generalmodel->ticketDetail($tic_id);

        $userid = $this->userdata['user_id'];
        $urole_id = $this->userdata['urole_id'];
        $dept_id = $this->userdata['dept_id'];

        $assigned_users  = array();

        if(!empty($detail['tic_users'])){

            if((stripos($detail['tic_users'],",")==0 ||stripos($detail['tic_users'],",")>0) && stripos($detail['tic_users'],",")!=''){
                $assigned_users = explode($detail['tic_users'],",");
            }else{
               $assigned_users[0]  = $detail['tic_users'];
            }
        }

            $where = 'm.tic_activity_createat ="ticket" AND m.tic_id='.$tic_id;

        $type = $this->input->post('type');
        if(!empty($type)){
            if($type != "All"){

            $where.= " AND m.tic_activity_type='".$type."'";
            }
         }   


        if($userid == $detail['user_id'] || in_array($userid,$assigned_users) || $dept_id==2){
            

        }elseif($userid != $detail['user_id'] && !in_array($userid,$assigned_users) && $dept_id==5){

            $where .= ' AND m.tic_activity_type LIKE "%comment%" AND t.upper_level='.$userid;
        }

        $query = 'SELECT m.tic_activity_title,concat(u.firstname," ",u.lastname) as name,m.tic_activity_des,m.tic_activity_createdate FROM ticket_activity as m 
        LEFT JOIN ticket as t ON t.tic_id = m.tic_id 
        LEFT JOIN user as u ON m.tic_activity_createdby = u.user_id 
        WHERE '.$where.'   ORDER BY m.tic_activity_createdate DESC';


        $this->load->helper('text');
        $datatables = new Datatables(new CodeigniterAdapter);
      
        $datatables->query($query);

         $datatables->edit('tic_activity_createdate', function ($data) {
                    $localtimzone =$this->userdata['timezone'];
                    $tic_activity_createdate = gmdate_to_mydate($data['tic_activity_createdate'],$localtimzone);
                    return date('m/d/Y',strtotime($tic_activity_createdate));
                });
         $datatables->edit('tic_activity_des', function ($data) {
            $desc = word_limiter($data['tic_activity_des'], 10);
            $readmore ='<a class="addDesc" data-id="desc" value="'.$data['tic_activity_des'].'"><span class="badge badge-pill badge-secondary">Read More</span></a>'; 
            if(strlen($data['tic_activity_des'])>strlen($desc)){
                return $desc.$readmore;
            }else{ return $desc; }
            
         });
     
        echo $datatables->generate();
    }

    public function export()
    {
        set_time_limit(0);
        ini_set('memory_limit', -1);
        $user_id =$this->userdata['user_id'];
        $perms=explode(",",$this->userdata['upermission']);
        $q = $this->input->post('search');

        


        $where = 'm.status="1"';

        if(!empty($q)){ $where .= ' AND (m.tic_number LIKE "%'.$q.'%" OR m.tic_title LIKE "%'.$q.'%" OR b.tic_cat_name LIKE "%'.$q.'%")'; }


        if($this->userdata['dept_id']==2){
            $where .= ' AND u.urole_id='.$this->userdata['urole_id'];                
        }elseif($this->userdata['dept_id']!=2 && $this->userdata['dept_id']!=5){
            $where .= ' AND u.urole_id='.$this->userdata['urole_id'].' AND (m.user_id='.$user_id.' OR FIND_IN_SET('.$user_id.',m.tic_users))';
        }elseif($this->userdata['dept_id']==5){
            $where .= ' AND (( u.urole_id='.$this->userdata['urole_id'].' AND (m.user_id='.$user_id.' OR FIND_IN_SET('.$user_id.',m.tic_users))) OR (m.upper_level='.$user_id.') AND act.tic_activity_type="comment")';

            $query='SELECT m.tic_title,m.tic_number,concat(u.firstname," ",u.lastname) as name,m.business_name,m.tic_status,b.tic_cat_name,m.tic_id 
            FROM ticket as m 
            LEFT JOIN ticket_category as b ON m.tic_cat_id = b.tic_cat_id 
            LEFT JOIN user as u ON m.user_id = u.user_id 
            LEFT JOIN ticket_activity as act ON act.tic_id = m.tic_id

            WHERE  '.$where;

        }


        if($this->userdata['dept_id']!=5){

            $items='SELECT m.tic_title,m.tic_number,concat(u.firstname," ",u.lastname) as name,m.business_name,m.tic_status,b.tic_cat_name,m.tic_id FROM ticket as m LEFT JOIN ticket_category as b ON m.tic_cat_id = b.tic_cat_id LEFT JOIN user as u ON m.user_id = u.user_id WHERE  '.$where;

        }


        /*
        if($q!=''){
             if($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10)
            {
             
             $items = 'SELECT m.tic_title,m.tic_number,concat(u.firstname," ",u.lastname) as name,m.business_name,m.tic_status,b.tic_cat_name,m.tic_id FROM ticket as m LEFT JOIN ticket_category as b ON m.tic_cat_id = b.tic_cat_id LEFT JOIN user as u ON m.user_id = u.user_id WHERE m.status!="0" AND (m.tic_number LIKE "%'.$q.'%" OR m.tic_title LIKE "%'.$q.'%" OR b.tic_cat_name LIKE "%'.$q.'%")';
            }else
            {
                $items = 'SELECT m.tic_title,m.tic_number,concat(u.firstname," ",u.lastname) as name,m.business_name,m.tic_status,b.tic_cat_name,m.tic_id FROM ticket as m LEFT JOIN ticket_category as b ON m.tic_cat_id = b.tic_cat_id LEFT JOIN user as u ON m.user_id = u.user_id WHERE m.status!="0" AND (m.tic_number LIKE "%'.$q.'%" OR m.tic_title LIKE "%'.$q.'%" OR b.tic_cat_name LIKE "%'.$q.'%")  AND m.user_id="'.$userid.'"';
            }

        }else{

            if($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10)
            {
              $items = 'SELECT m.tic_title,m.tic_number,concat(u.firstname," ",u.lastname) as name,m.business_name,m.tic_status,b.tic_cat_name,m.tic_id FROM ticket as m LEFT JOIN ticket_category as b ON m.tic_cat_id = b.tic_cat_id LEFT JOIN user as u ON m.user_id = u.user_id WHERE m.status!="0"';
            }else
            {
             $items = 'SELECT m.tic_title,m.tic_number,concat(u.firstname," ",u.lastname) as name,m.business_name,m.tic_status,b.tic_cat_name,m.tic_id FROM ticket as m LEFT JOIN ticket_category as b ON m.tic_cat_id = b.tic_cat_id LEFT JOIN user as u ON m.user_id = u.user_id WHERE m.status!="0" AND m.user_id="'.$userid.'"';
            }

        }
        */

        
        
          
        $query=$this->db->query($items);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'Ticket.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser
        $cells = [
                WriterEntityFactory::createCell('Ticket Title'),
                WriterEntityFactory::createCell('Ticket Number'),
                WriterEntityFactory::createCell('Made By'),
                WriterEntityFactory::createCell('Business Name'),
                WriterEntityFactory::createCell('Status'),
                WriterEntityFactory::createCell('Category'),
                
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
        //$writer->addRow(array('resource_id', 'lic_number', 'business_name', 'user_cat_name', 'Distributor Name','email','end date'));

        foreach ($obj as $row) {
           if($row['tic_status']=='0'){
                       $st= 'Open';
                    }else if($row['tic_status']=='1'){
                       $st= 'Pending';
                    }else if($row['tic_status']=='2'){
                       $st= 'Resolved';
                    }else{
                       $st= 'Spam';
                    }
            $data[0] = $row['tic_title'];
            $data[1] = $row['tic_number'];
            $data[2] = $row['name'];
            $data[3] = $row['business_name,'];
            $data[4] = $st;
            $data[5] = $row['tic_cat_name'];
            
            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
        }
        $writer->close();
    }

 public function exportcate()
    {
        set_time_limit(0);
        ini_set('memory_limit', -1);
        $userid =$this->userdata['user_id'];
        $perms=explode(",",$this->userdata['upermission']);

        $q = $this->input->post('search');
        
        if($q!=''){
             $items = 'SELECT t.tic_cat_name as category, s.tic_cat_name as ticket_category,t.tic_cat_status,t.tic_cat_id FROM ticket_category as t left join ticket_category as s on t.tic_parent_id=s.tic_cat_id WHERE t.tic_del_status!="0" AND (t.tic_cat_name LIKE "%'.$q.'%" OR s.tic_cat_name LIKE "%'.$q.'%" OR t.tic_cat_status LIKE "%'.$q.'%")';

        }else{
             $items = 'SELECT t.tic_cat_name as category, s.tic_cat_name as ticket_category,t.tic_cat_status,t.tic_cat_id FROM ticket_category as t left join ticket_category as s on t.tic_parent_id=s.tic_cat_id WHERE t.tic_del_status!="0"';

        }
           
        $query=$this->db->query($items);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'Ticket Category.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser
        $cells = [
                WriterEntityFactory::createCell('Category Name'),
                WriterEntityFactory::createCell('Parent Category'),
                WriterEntityFactory::createCell('Status'),
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
        //$writer->addRow(array('resource_id', 'lic_number', 'business_name', 'user_cat_name', 'Distributor Name','email','end date'));

        foreach ($obj as $row) {
            if($row['tic_cat_status']==1){$st= 'Active';}else{$st ='Inactive';}
            if(is_null($row['ticket_category'])){
                   $cat_name= '-';
                }else{
                   $cat_name= $row['ticket_category'];
                }
            $data[0] = $row['category'];
            $data[1] =  $cat_name;
            $data[2] = $st;
           
            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
        }
        $writer->close();
    }


     public function removecate(){
        if ($this->input->is_ajax_request()) {
             $userid =$this->userdata['user_id'];
            $ids = $this->input->post('ids');

           $this->generalmodel->updaterecord('ticket_category',array('tic_del_status'=>0),'tic_cat_id IN('.$ids.')');
            $return = array('success'=>true,'msg'=>'Records Removed');
        }else{
            $return = array('success'=>false,'msg'=>'Internal Error');
        }
        echo json_encode($return);
    }


   public function exportnote($id)
    {
        $id = decoding($id);
        set_time_limit(0);
        ini_set('memory_limit', -1);
        $userid =$this->userdata['user_id'];
        $perms=explode(",",$this->userdata['upermission']);

             $items = 'SELECT m.tic_activity_title,concat(b.firstname," ",b.lastname) as name,m.tic_activity_des,m.tic_activity_createdate FROM ticket_activity as m LEFT JOIN user as b ON m.tic_activity_createdby = b.user_id WHERE m.tic_activity_createat ="ticket" AND m.tic_id="'.$id.'" ORDER BY m.tic_activity_createdate DESC';

       
        
          
        $query=$this->db->query($items);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'Ticket.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser
        $cells = [
                WriterEntityFactory::createCell('Title'),
                WriterEntityFactory::createCell('User'),
                WriterEntityFactory::createCell('Description'),
                WriterEntityFactory::createCell('Date'),
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
        //$writer->addRow(array('resource_id', 'lic_number', 'business_name', 'user_cat_name', 'Distributor Name','email','end date'));

        foreach ($obj as $row) {
                    $localtimzone =$this->userdata['timezone'];
                    $tic_activity_createdate = gmdate_to_mydate($row['tic_activity_createdate'],$localtimzone);
            $data[0] = $row['tic_activity_title'];
            $data[1] = $row['name'];
            $data[2] = $row['tic_activity_des'];
            $data[3] = date('m/d/Y', strtotime($tic_activity_createdate));
           
           
            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
        }
        $writer->close();
    } 


    public function downloadexportnote($id)
    {
        $id = decoding($id);
        set_time_limit(0);
        ini_set('memory_limit', -1);
        
             $items = 'SELECT m.tic_title,m.tic_number,concat(u.firstname," ",u.lastname) as name,m.business_name,m.tic_status,b.tic_cat_name,m.tic_id FROM ticket as m LEFT JOIN ticket_category as b ON m.tic_cat_id = b.tic_cat_id LEFT JOIN user as u ON m.user_id = u.user_id WHERE m.status!="0" AND m.tic_id="'.$id.'"';
        
        $query=$this->db->query($items);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'Ticket.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser
        $cells = [
                WriterEntityFactory::createCell('Ticket Title'),
                WriterEntityFactory::createCell('Ticket Number'),
                WriterEntityFactory::createCell('Made By'),
                WriterEntityFactory::createCell('Business Name'),
                WriterEntityFactory::createCell('Status'),
                WriterEntityFactory::createCell('Category'),
                
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
        //$writer->addRow(array('resource_id', 'lic_number', 'business_name', 'user_cat_name', 'Distributor Name','email','end date'));

        foreach ($obj as $row) {
           if($row['tic_status']=='0'){
                       $st= 'Open';
                    }else if($row['tic_status']=='1'){
                       $st= 'Pending';
                    }else if($row['tic_status']=='2'){
                       $st= 'Resolved';
                    }else{
                       $st= 'Spam';
                    }
                    if($row['business_name']){
                        $bn= $row['business_name']; 
                    }else{
                        $bn= "-"; 
                    }
            $data[0] = $row['tic_title'];
            $data[1] = $row['tic_number'];
            $data[2] = $row['name'];
            $data[3] = $bn;
            $data[4] = $st;
            $data[5] = $row['tic_cat_name'];
            
            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
        }
        $writer->close();
    }

}
