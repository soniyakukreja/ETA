<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH. 'third_party/Spout/Autoloader/autoload.php';
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;

use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;
class Ticket extends MX_Controller {

   public function __construct(){
        parent::__construct();
        $this->userdata = $this->session->userdata('userdata');
    }
    
    public function index()
    {
        $data['meta_title'] = "Ticket";
        $this->load->view('consumer/ticket');
    }

    public function ajax()
    {
        $user_id = $this->userdata['user_id'];
        $datatables = new Datatables(new CodeigniterAdapter);

        if($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10)
        {
             $datatables->query('SELECT m.tic_title,m.tic_number,concat(u.firstname," ",u.lastname) as name,m.tic_status,b.tic_cat_name,m.tic_id FROM ticket as m LEFT JOIN ticket_category as b ON m.tic_cat_id = b.tic_cat_id LEFT JOIN user as u ON m.user_id = u.user_id WHERE m.status!="0"');
        }else
        {
             $datatables->query('SELECT m.tic_title,m.tic_number,concat(u.firstname," ",u.lastname) as name,m.tic_status,b.tic_cat_name,m.tic_id FROM ticket as m LEFT JOIN ticket_category as b ON m.tic_cat_id = b.tic_cat_id LEFT JOIN user as u ON m.user_id = u.user_id WHERE m.status!="0" AND m.user_id="'.$user_id.'"');
        }

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
        $datatables->edit('tic_id', function ($data) {
            return '<a href="'.site_url().'consumer/ticket/viewticket/'.encoding($data['tic_id']).'">View</a>';
        });

        echo $datatables->generate();
    }
    
    public function addticket(){

        if(!empty($this->input->post()) && $this->input->is_ajax_request()){
            if($this->form_validation->run('consumer_addticket')){
               
                $createddate = date('Y-m-d h:i:s');
                $createdby = $this->userdata['user_id'];
                $tic_num =  rand(111,999);
                $ipaddress = $this->input->ip_address();

                $data = array(
                    'tic_number' => $tic_num, 
                    'tic_cat_id' => $this->input->post('tic_cat_id'), 
                    'tic_title' => $this->input->post('tic_title'), 
                    'user_id' => $createdby, 
                    'tic_status' =>'0', 
                    'tic_desc' => $this->input->post('tic_desc'), 
                    'tic_createdate' => $createddate, 
              
                );

                $query = $this->generalmodel->add('ticket',$data);
                if(!empty($query)){
                  
                    $return = array('success'=>true,'msg'=>'Ticket addedd successfully');
                }else{
                    $return = array('success'=>false,'msg'=>'something went wrong');
                }
            }else{
                $return = array('success'=>false,'msg'=>validation_errors());
            }
            echo json_encode($return); exit;
        }else{
            $data['category'] = $this->generalmodel->get_all_record('ticket_category');
            $data['meta_title'] = "Add Ticket";
            $this->load->view('ticket_form',$data);
        }
    }

    public function viewticket($id)
    {
        $id = decoding($id);
       $data['product']= $this->generalmodel->getsingleJoinData('*','ticket','ticket_category','ticket.tic_cat_id=ticket_category.tic_cat_id','tic_id='.$id);
       $data['meta_title'] = "View Ticket";
       $this->load->view('viewticket',$data);
    }

/*********** Add Note    ***********/
    public function addnote(){
        if($this->form_validation->run('add_ticnote')){
                
                 $createdate = date('Y-m-d h:i:s');
                $createdby = $this->userdata['user_id'];
                // $resource_id =  rand(111,999);
                $assign_to = $assign_date = '';
               

                $ipaddress = $this->input->ip_address();

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
                 $return = array('success'=>true,'msg'=>'Activity Added Successfully');
                }else{
                   $return = array('success'=>false,'msg'=>'something went wrong');
                }
            }else{
                $return = array('success'=>false,'msg'=>validation_errors());
            }
            echo json_encode($return);
    }

    public function viewnote($t_id)
    {
        $t_id = decoding($t_id)   ; 
        if($this->input->is_ajax_request()){
            $this->load->helper('text');
            $datatables = new Datatables(new CodeigniterAdapter);
            
            $where = "m.tic_activity_createat ='ticket' AND tic_id='".$t_id."'";

            $datatables->query('SELECT m.tic_activity_title,concat(b.firstname," ",b.lastname) as name,m.tic_activity_des,m.tic_activity_createdate FROM ticket_activity as m LEFT JOIN user as b ON m.tic_activity_createdby = b.user_id WHERE '.$where.' ORDER BY m.tic_activity_createdate DESC');

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
    }

    public function export()
    {
        set_time_limit(0);
        ini_set('memory_limit', -1);
        $userid =$this->userdata['user_id'];
        $perms=explode(",",$this->userdata['upermission']);
        $q = $this->input->post('search');
        
        if($q!=''){
             $items = 'SELECT m.tic_number,m.tic_title,b.tic_cat_name,m.tic_id FROM ticket as m LEFT JOIN ticket_category as b ON m.tic_cat_id = b.tic_cat_id WHERE status!="0" AND (m.tic_number LIKE "%'.$q.'%" OR m.tic_title LIKE "%'.$q.'%" OR b.tic_cat_name LIKE "%'.$q.'%")';

        }else{
             $items = 'SELECT m.tic_number,m.tic_title,b.tic_cat_name,m.tic_id FROM ticket as m LEFT JOIN ticket_category as b ON m.tic_cat_id = b.tic_cat_id WHERE status!="0"';

        }
        
          
        $query=$this->db->query($items);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'Ticket.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser
        $cells = [
                WriterEntityFactory::createCell('Ticket Number'),
                WriterEntityFactory::createCell('Ticket Title'),
                WriterEntityFactory::createCell('Category Name'),
                
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
        //$writer->addRow(array('resource_id', 'lic_number', 'business_name', 'user_cat_name', 'Distributor Name','email','end date'));

        foreach ($obj as $row) {
           
            $data[0] = $row['tic_number'];
            $data[1] = $row['tic_title'];
            $data[2] = $row['tic_cat_name'];
            
            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
        }
        $writer->close();
    }
}
