<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH. 'third_party/Spout/Autoloader/autoload.php';
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;

use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;

class Whistleblower extends MY_Controller {

   public function __construct(){
        parent::__construct();
        $this->userdata = $this->session->userdata('userdata');
    }
    
    public function index()
    {
        $this->load->view('complianeticket/viewcompliance');
    }

    public function viewticket($id)
    {
        $id  =decoding($id);
       $data['product']= $this->generalmodel->getsingleJoinData('*','complianeticket','ticket_category','complianeticket.tic_category_id=ticket_category.tic_cat_id','comp_tic_id='.$id);
       $data['meta_title'] = "Whistle Blower";
      $this->load->view('viewtickets',$data);
    }

    public function editticket($id)
    {   
        $id  =decoding($id);
        if(!empty($this->input->post()) && $this->input->is_ajax_request()){

            if($this->form_validation->run('edit_whisle')){
               
                // $createddate = date('Y-m-d h:i:s');
                 // $createdby = $this->userdata['user_id'];

                $id = $this->input->post('id');
                $data = array(
                     
                    'comp_tic_status' => $this->input->post('comp_tic_status'), 
                    'comp_tic_message' => $this->input->post('tic_desc'), 
            
                );

                $query = $this->generalmodel->updaterecord('complianeticket',$data,'comp_tic_id='.$id);
                if(!empty($query)){
                   
                    $return = array('success'=>true,'msg'=>'Whistle Blower Updated successfully');
                }else{
                    $return = array('success'=>false,'msg'=>'something went wrong');
                }
            }else{
                $return = array('success'=>false,'msg'=>validation_errors());
            }
            echo json_encode($return); exit;
        }else{
            $data['category'] = $this->generalmodel->get_all_record('ticket_category');
            $data['ticket']= $this->generalmodel->getsingleJoinData('*','complianeticket','ticket_category','complianeticket.tic_category_id=ticket_category.tic_cat_id','comp_tic_id='.$id);
            $data['meta_title'] = "Whistle Blower";
            $this->load->view('editticket',$data);
        }
    }

    public function ajax()
    {
        $userid =$this->userdata['user_id'];
        $perms=explode(",",$this->userdata['upermission']);
        $datatables = new Datatables(new CodeigniterAdapter);
      
       if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
        $datatables->query('SELECT b.business_name, m.comp_tic_num,m.comp_tic_status,m.comp_tic_id FROM complianeticket as m LEFT JOIN business as b ON m.comp_tic_business_id = b.business_id LEFT JOIN country as c ON m.comp_tic_country_id = c.id LEFT JOIN user as u ON m.comp_tic_createdby = u.user_id WHERE b.status ="1"');
    	}else{
    		if($this->userdata['dept_id']==5){
    			if($this->userdata['urole_id']==1){
    				$datatables->query('
    					SELECT b.business_name, m.comp_tic_num,m.comp_tic_status,m.comp_tic_id FROM complianeticket as m 
    					LEFT JOIN licensee as l ON m.comp_tic_business_id = l.business_id 
    					LEFT JOIN business as b ON l.business_id = b.business_id
                        LEFT JOIN user as c ON c.user_id = l.createdby
                        LEFT JOIN user as k ON c.user_id = k.createdby
    					WHERE b.status ="1" AND k.user_id ="'.$userid.'"');
    			}else if($this->userdata['urole_id']==2){
    				$datatables->query('
    					SELECT b.business_name, m.comp_tic_num,m.comp_tic_status,m.comp_tic_id FROM complianeticket as m 
    					LEFT JOIN indassociation as l ON m.comp_tic_business_id = l.business_id 
    					LEFT JOIN business as b ON l.business_id = b.business_id
    					LEFT JOIN licensee as c ON c.user_id = l.createdby
                        LEFT JOIN user as k ON c.user_id = k.createdby
    					WHERE b.status ="1" AND k.user_id ="'.$userid.'"');
    			}else if($this->userdata['urole_id']==3){
    				$datatables->query('
    					SELECT b.business_name, m.comp_tic_num,m.comp_tic_status,m.comp_tic_id FROM complianeticket as m 
    					LEFT JOIN user as u ON m.comp_tic_business_id = u.consumer_business_id
                        LEFT JOIN business as b ON u.consumer_business_id = b.business_id 
                        LEFT JOIN indassociation as i ON i.user_id = u.createdby
                       	LEFT JOIN user as c ON i.user_id = c.createdby
                        WHERE b.status ="1" AND c.user_id = "'.$userid.'"');
    			}
    		}else{
                $datatables->query('SELECT b.business_name, m.comp_tic_num,m.comp_tic_status,m.comp_tic_id FROM complianeticket as m LEFT JOIN business as b ON m.comp_tic_business_id = b.business_id LEFT JOIN country as c ON m.comp_tic_country_id = c.id LEFT JOIN user as u ON m.comp_tic_createdby = u.user_id WHERE b.status ="1" AND u.user_id = "'.$userid.'"');
            }
    		
    	}
    	// echo $this->db->last_query(); exit;

      $datatables->edit('comp_tic_status', function ($data) {
                    if($data['comp_tic_status']=='0'){
                       $st= 'Open';
                    }else if($data['comp_tic_status']=='1'){
                       $st= 'Pending';
                    }else if($data['comp_tic_status']=='2'){
                       $st= 'Resolved';
                    }else{
                       $st= 'Spam';
                    }
                        return $st; 
                });
                // // edit 'id' column
      $datatables->edit('comp_tic_id', function ($data) {
          return '<div class="dropdown"><button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
                <i class="glyphicon glyphicon-option-vertical"></i>
            </button>
            <ul class="dropdown-menu">
                <li>
                    <a href="'.site_url('complianeticket/whistleblower/viewticket/').encoding($data['comp_tic_id']).'">
                        <span class="glyphicon glyphicon-eye-open"></span> View
                    </a>
                </li>
                <li>
                    <a href="'.site_url().'complianeticket/whistleblower/editticket/'.encoding($data['comp_tic_id']).'">
                        <span class="glyphicon glyphicon-pencil"></span> Edit
                    </a>
                </li>
                
            </ul><div>';
      }); 
			

        echo $datatables->generate();
    }

    public function whislelic()
    {
        $data['meta_title'] = "Whistle Blower";
        $this->load->view('complianeticket/whislelic',$data);
    }


    public function ajaxlic()
    {
        $userid =$this->userdata['user_id'];
        $perms=explode(",",$this->userdata['upermission']);
        $datatables = new Datatables(new CodeigniterAdapter);

        // $datatables->query('SELECT b.tic_title,b.tic_number,concat(u.firstname," ",u.lastname) as name,b.business_name,b.tic_status,c.tic_cat_name FROM `ticket_activity` as m LEFT JOIN ticket as b ON m.tic_id = b.tic_id LEFT JOIN ticket_category as c ON c.tic_cat_id = b.tic_cat_id LEFT JOIN user as u ON u.user_id = b.user_id WHERE m.tic_activity_type="Whispers" AND u.urole_id="2"');
        $datatables->query('SELECT concat(u.firstname," ",u.lastname) as name,b.business_name,m.comp_tic_status,count(m.comp_tic_id) as amount FROM complianeticket as m LEFT JOIN business as b ON m.comp_tic_business_id = b.business_id LEFT JOIN licensee as l ON b.business_id = l.business_id LEFT JOIN user as u ON u.user_id = l.user_id WHERE b.status ="1" AND u.status = 1 GROUP BY u.user_id');
        
        $datatables->edit('comp_tic_status', function ($data) {
                    if($data['comp_tic_status']=='0'){
                       $st= 'Open';
                    }else if($data['comp_tic_status']=='1'){
                       $st= 'Pending';
                    }else if($data['comp_tic_status']=='2'){
                       $st= 'Resolved';
                    }else{
                       $st= 'Spam';
                    }
                        return $st; 
                });
            

        echo $datatables->generate();
    }

    public function whistleia()
    {
        $data['meta_title'] = "Whistle Blower";
        $this->load->view('complianeticket/whisleia',$data);
    }


    public function ajaxia()
    {
        $userid =$this->userdata['user_id'];
        $perms=explode(",",$this->userdata['upermission']);
        $datatables = new Datatables(new CodeigniterAdapter);

        $datatables->query('SELECT concat(lu.firstname," ",lu.lastname) as name, concat(u.firstname," ",u.lastname) as iname,b.business_name ,m.comp_tic_status,count(m.comp_tic_id) as amount FROM complianeticket as m LEFT JOIN business as b ON m.comp_tic_business_id = b.business_id LEFT JOIN indassociation as i ON b.business_id = i.business_id LEFT JOIN user as u ON u.user_id = i.user_id LEFT JOIN licensee as l ON l.user_id = i.createdby LEFT JOIN user as lu ON lu.user_id = l.user_id WHERE b.status ="1" AND u.status = 1 GROUP BY i.user_id');
            
         $datatables->edit('comp_tic_status', function ($data) {
                    if($data['comp_tic_status']=='0'){
                       $st= 'Open';
                    }else if($data['comp_tic_status']=='1'){
                       $st= 'Pending';
                    }else if($data['comp_tic_status']=='2'){
                       $st= 'Resolved';
                    }else{
                       $st= 'Spam';
                    }
                        return $st; 
                });  

        echo $datatables->generate();
    }

     public function whistlesup()
    {
        $data['meta_title'] = "Whistle Blower";
        $this->load->view('complianeticket/whislesup',$data);
    }

    public function ajaxsup()
    {
        $userid =$this->userdata['user_id'];
        $perms=explode(",",$this->userdata['upermission']);
        $datatables = new Datatables(new CodeigniterAdapter);

       $datatables->query('SELECT concat(u.firstname," ",u.lastname) as name,b.business_name,m.comp_tic_status,count(m.comp_tic_id) as amount FROM complianeticket as m LEFT JOIN business as b ON m.comp_tic_business_id = b.business_id LEFT JOIN supplier as l ON b.business_id = l.business_id LEFT JOIN user as u ON u.user_id = l.user_id WHERE b.status ="1" AND u.status = 1 GROUP BY u.user_id');
        
        $datatables->edit('comp_tic_status', function ($data) {
                    if($data['comp_tic_status']=='0'){
                       $st= 'Open';
                    }else if($data['comp_tic_status']=='1'){
                       $st= 'Pending';
                    }else if($data['comp_tic_status']=='2'){
                       $st= 'Resolved';
                    }else{
                       $st= 'Spam';
                    }
                        return $st; 
                });
            

        echo $datatables->generate();
    }

    public function whistleconsume()
    {
        $data['meta_title'] = "Whistle Blower";
        $this->load->view('complianeticket/whisleconsume',$data);
    }

    public function ajaxconsume()
    {
        $userid =$this->userdata['user_id'];
        $perms=explode(",",$this->userdata['upermission']);
        $datatables = new Datatables(new CodeigniterAdapter);

        $datatables->query('SELECT concat(c.firstname," ",c.lastname) as cname,concat(lu.firstname," ",lu.lastname) as name, concat(u.firstname," ",u.lastname) as iname,b.business_name ,m.comp_tic_status,count(m.comp_tic_id) as amount FROM complianeticket as m LEFT JOIN business as b ON m.comp_tic_business_id = b.business_id LEFT JOIN user as c ON b.business_createdby = c.user_id LEFT JOIN indassociation as i ON c.createdby = i.user_id LEFT JOIN user as u ON u.user_id = c.user_id LEFT JOIN licensee as l ON l.user_id = i.createdby LEFT JOIN user as lu ON lu.user_id = l.user_id WHERE b.status ="1" AND c.status = 1 AND c.urole_id=4 GROUP BY i.user_id');
        
        

        $datatables->edit('comp_tic_status', function ($data) {
                    if($data['comp_tic_status']=='0'){
                       $st= 'Open';
                    }else if($data['comp_tic_status']=='1'){
                       $st= 'Pending';
                    }else if($data['comp_tic_status']=='2'){
                       $st= 'Resolved';
                    }else{
                       $st= 'Spam';
                    }
                        return $st; 
                });
            

        echo $datatables->generate();
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
  	        	$items = 'SELECT b.business_name, m.comp_tic_num,m.comp_tic_status,m.comp_tic_id FROM complianeticket as m LEFT JOIN business as b ON m.comp_tic_business_id = b.business_id LEFT JOIN country as c ON m.comp_tic_country_id = c.id LEFT JOIN user as u ON m.comp_tic_createdby = u.user_id WHERE b.status ="1"  AND (b.business_name LIKE "%'.$q.'%" OR m.comp_tic_num LIKE "%'.$q.'%" OR m.comp_tic_status LIKE "%'.$q.'%")';
  	        }else{
  	        	if($this->userdata['dept_id']==5){
                        if($this->userdata['urole_id']==1){
                            $items ='
                                SELECT b.business_name, m.comp_tic_num,m.comp_tic_status,m.comp_tic_id FROM complianeticket as m 
                                LEFT JOIN licensee as l ON m.comp_tic_business_id = l.business_id 
                                LEFT JOIN business as b ON l.business_id = b.business_id
                                LEFT JOIN user as c ON c.user_id = l.createdby
                                LEFT JOIN user as k ON c.user_id = k.createdby
                                WHERE b.status ="1" AND k.user_id ="'.$userid.'"  AND (b.business_name LIKE "%'.$q.'%" OR m.comp_tic_num LIKE "%'.$q.'%" OR m.comp_tic_status LIKE "%'.$q.'%")';
                        }else if($this->userdata['urole_id']==2){
                           $items ='
                                SELECT b.business_name, m.comp_tic_num,m.comp_tic_status,m.comp_tic_id FROM complianeticket as m 
                                LEFT JOIN indassociation as l ON m.comp_tic_business_id = l.business_id 
                                LEFT JOIN business as b ON l.business_id = b.business_id
                                LEFT JOIN licensee as c ON c.user_id = l.createdby
                                LEFT JOIN user as k ON c.user_id = k.createdby
                                WHERE b.status ="1" AND k.user_id ="'.$userid.'"  AND (b.business_name LIKE "%'.$q.'%" OR m.comp_tic_num LIKE "%'.$q.'%" OR m.comp_tic_status LIKE "%'.$q.'%")';
                        }else if($this->userdata['urole_id']==3){
                            $items ='
                                SELECT b.business_name, m.comp_tic_num,m.comp_tic_status,m.comp_tic_id FROM complianeticket as m 
                                LEFT JOIN user as u ON m.comp_tic_business_id = u.consumer_business_id
                                LEFT JOIN business as b ON u.consumer_business_id = b.business_id 
                                LEFT JOIN indassociation as i ON i.user_id = u.createdby
                                LEFT JOIN user as c ON i.user_id = c.createdby
                                WHERE b.status ="1" AND c.user_id = "'.$userid.'"  AND (b.business_name LIKE "%'.$q.'%" OR m.comp_tic_num LIKE "%'.$q.'%" OR m.comp_tic_status LIKE "%'.$q.'%")';
                        }
                    }else{
                         $items = 'SELECT b.business_name, m.comp_tic_num,m.comp_tic_status,m.comp_tic_id FROM complianeticket as m LEFT JOIN business as b ON m.comp_tic_business_id = b.business_id LEFT JOIN country as c ON m.comp_tic_country_id = c.id LEFT JOIN user as u ON m.comp_tic_createdby = u.user_id WHERE b.status ="1" AND u.user_id = "'.$userid.'" AND (b.business_name LIKE "%'.$q.'%" OR m.comp_tic_num LIKE "%'.$q.'%" OR m.comp_tic_status LIKE "%'.$q.'%")';
                    }
  			   }
    		}else{
    	       if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
            	 $items = 'SELECT b.business_name, m.comp_tic_num,m.comp_tic_status,m.comp_tic_id FROM complianeticket as m LEFT JOIN business as b ON m.comp_tic_business_id = b.business_id LEFT JOIN country as c ON m.comp_tic_country_id = c.id LEFT JOIN user as u ON m.comp_tic_createdby = u.user_id WHERE b.status ="1"';
    	        }else{
    	        	if($this->userdata['dept_id']==5){
                        if($this->userdata['urole_id']==1){
                            $items ='
                                SELECT b.business_name, m.comp_tic_num,m.comp_tic_status,m.comp_tic_id FROM complianeticket as m 
                                LEFT JOIN licensee as l ON m.comp_tic_business_id = l.business_id 
                                LEFT JOIN business as b ON l.business_id = b.business_id
                                LEFT JOIN user as c ON c.user_id = l.createdby
                                LEFT JOIN user as k ON c.user_id = k.createdby
                                WHERE b.status ="1" AND k.user_id ="'.$userid.'"';
                        }else if($this->userdata['urole_id']==2){
                           $items ='
                                SELECT b.business_name, m.comp_tic_num,m.comp_tic_status,m.comp_tic_id FROM complianeticket as m 
                                LEFT JOIN indassociation as l ON m.comp_tic_business_id = l.business_id 
                                LEFT JOIN business as b ON l.business_id = b.business_id
                                LEFT JOIN licensee as c ON c.user_id = l.createdby
                                LEFT JOIN user as k ON c.user_id = k.createdby
                                WHERE b.status ="1" AND k.user_id ="'.$userid.'"';
                        }else if($this->userdata['urole_id']==3){
                            $items ='
                                SELECT b.business_name, m.comp_tic_num,m.comp_tic_status,m.comp_tic_id FROM complianeticket as m 
                                LEFT JOIN user as u ON m.comp_tic_business_id = u.consumer_business_id
                                LEFT JOIN business as b ON u.consumer_business_id = b.business_id 
                                LEFT JOIN indassociation as i ON i.user_id = u.createdby
                                LEFT JOIN user as c ON i.user_id = c.createdby
                                WHERE b.status ="1" AND c.user_id = "'.$userid.'"';
                        }
                    }else{
                            $items = 'SELECT b.business_name, m.comp_tic_num,m.comp_tic_status,m.comp_tic_id FROM complianeticket as m LEFT JOIN business as b ON m.comp_tic_business_id = b.business_id LEFT JOIN country as c ON m.comp_tic_country_id = c.id LEFT JOIN user as u ON m.comp_tic_createdby = u.user_id WHERE b.status ="1" AND u.user_id = "'.$userid.'"';
                        }

    	        }

    		}

        $query=$this->db->query($items);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'Whistleblower.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser
        $cells = [
               
                WriterEntityFactory::createCell('Business Name'),
                WriterEntityFactory::createCell('Ticket Number'),
                WriterEntityFactory::createCell('Status'),
                
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
     

        foreach ($obj as $row) {
        	if($row['comp_tic_status']=='0'){
                       $st= 'Open';
                    }else if($row['comp_tic_status']=='1'){
                       $st= 'Pending';
                    }else if($row['comp_tic_status']=='2'){
                       $st= 'Resolved';
                    }else{
                       $st= 'Spam';
                    }

            $data[0] = $row['business_name'];
            $data[1] = $row['comp_tic_num'];
            $data[2] = $st;
           
            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
        }
        $writer->close();
    }

    public function exportlic()
    {
        set_time_limit(0);
        ini_set('memory_limit', -1);
        $userid =$this->userdata['user_id'];
        $perms=explode(",",$this->userdata['upermission']);
        $q = $this->input->post('search');
        
        if($q!=''){
             $items = 'SELECT concat(u.firstname," ",u.lastname) as name,b.business_name,m.comp_tic_status,count(m.comp_tic_id) as amount FROM complianeticket as m LEFT JOIN business as b ON m.comp_tic_business_id = b.business_id LEFT JOIN licensee as l ON b.business_id = l.business_id LEFT JOIN user as u ON u.user_id = l.user_id WHERE b.status ="1" AND  (b.tic_number LIKE "%'.$q.'%" OR b.tic_title LIKE "%'.$q.'%" OR c.tic_cat_name LIKE "%'.$q.'%" OR b.business_name LIKE "%'.$q.'%") GROUP BY u.user_id';

        }else{
             $items = 'SELECT concat(u.firstname," ",u.lastname) as name,b.business_name,m.comp_tic_status,count(m.comp_tic_id) as amount FROM complianeticket as m LEFT JOIN business as b ON m.comp_tic_business_id = b.business_id LEFT JOIN licensee as l ON b.business_id = l.business_id LEFT JOIN user as u ON u.user_id = l.user_id WHERE b.status ="1" GROUP BY u.user_id';

        }

        
          
        $query=$this->db->query($items);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'Whistleblower.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser
        $cells = [
                WriterEntityFactory::createCell('Licensee'),
                WriterEntityFactory::createCell('Status'),
                WriterEntityFactory::createCell('Amount'),
                
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
        //$writer->addRow(array('resource_id', 'lic_number', 'business_name', 'user_cat_name', 'Distributor Name','email','end date'));

        foreach ($obj as $row) {

           if($row['comp_tic_status']=='0'){
                       $st= 'Open';
                    }else if($row['comp_tic_status']=='1'){
                       $st= 'Pending';
                    }else if($row['comp_tic_status']=='2'){
                       $st= 'Resolved';
                    }else{
                       $st= 'Spam';
                    }
           
            $data[0] = $row['name'];
            $data[1] = $st;
            $data[2] = $row['amount'];
            
            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
        }
        $writer->close();
    }

    public function exportia()
    {
        set_time_limit(0);
        ini_set('memory_limit', -1);
        $userid =$this->userdata['user_id'];
        $perms=explode(",",$this->userdata['upermission']);
        $q = $this->input->post('search');
        
        if($q!=''){
             $items = 'SELECT concat(lu.firstname," ",lu.lastname) as name, concat(u.firstname," ",u.lastname) as iname,b.business_name ,m.comp_tic_status,count(m.comp_tic_id) as amount FROM complianeticket as m LEFT JOIN business as b ON m.comp_tic_business_id = b.business_id LEFT JOIN indassociation as i ON b.business_id = i.business_id LEFT JOIN user as u ON u.user_id = i.user_id LEFT JOIN licensee as l ON l.user_id = i.createdby LEFT JOIN user as lu ON lu.user_id = l.user_id WHERE b.status ="1" AND (b.tic_number LIKE "%'.$q.'%" OR b.tic_title LIKE "%'.$q.'%" OR c.tic_cat_name LIKE "%'.$q.'%" OR b.business_name LIKE "%'.$q.'%") GROUP BY i.user_id';

        }else{
             $items = 'SELECT concat(lu.firstname," ",lu.lastname) as name, concat(u.firstname," ",u.lastname) as iname,b.business_name ,m.comp_tic_status,count(m.comp_tic_id) as amount FROM complianeticket as m LEFT JOIN business as b ON m.comp_tic_business_id = b.business_id LEFT JOIN indassociation as i ON b.business_id = i.business_id LEFT JOIN user as u ON u.user_id = i.user_id LEFT JOIN licensee as l ON l.user_id = i.createdby LEFT JOIN user as lu ON lu.user_id = l.user_id WHERE b.status ="1" GROUP BY i.user_id';

        }

        
          
        $query=$this->db->query($items);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'Whistleblower.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser
        $cells = [
                WriterEntityFactory::createCell('Licensee'),
                WriterEntityFactory::createCell('Industry Association'),
                WriterEntityFactory::createCell('Status'),
                WriterEntityFactory::createCell('Amount'),
                
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
        //$writer->addRow(array('resource_id', 'lic_number', 'business_name', 'user_cat_name', 'Distributor Name','email','end date'));

        foreach ($obj as $row) {

           if($row['comp_tic_status']=='0'){
                       $st= 'Open';
                    }else if($row['comp_tic_status']=='1'){
                       $st= 'Pending';
                    }else if($row['comp_tic_status']=='2'){
                       $st= 'Resolved';
                    }else{
                       $st= 'Spam';
                    }
           
            $data[0] = $row['name'];
            $data[1] = $row['iname'];
            $data[2] = $st;
            $data[3] = $row['amount'];
            
            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
        }
        $writer->close();
    }

    public function exportsup()
    {
        set_time_limit(0);
        ini_set('memory_limit', -1);
        $userid =$this->userdata['user_id'];
        $perms=explode(",",$this->userdata['upermission']);
        $q = $this->input->post('search');
        
        if($q!=''){
             $items = 'SELECT concat(u.firstname," ",u.lastname) as name,b.business_name,m.comp_tic_status,count(m.comp_tic_id) as amount FROM complianeticket as m LEFT JOIN business as b ON m.comp_tic_business_id = b.business_id LEFT JOIN supplier as l ON b.business_id = l.business_id LEFT JOIN user as u ON u.user_id = l.user_id WHERE b.status ="1" AND (b.tic_number LIKE "%'.$q.'%" OR b.tic_title LIKE "%'.$q.'%" OR c.tic_cat_name LIKE "%'.$q.'%" OR b.business_name LIKE "%'.$q.'%") GROUP BY u.user_id';

        }else{
             $items = 'SELECT concat(u.firstname," ",u.lastname) as name,m.comp_tic_status,count(m.comp_tic_id) as amount FROM complianeticket as m LEFT JOIN business as b ON m.comp_tic_business_id = b.business_id LEFT JOIN supplier as l ON b.business_id = l.business_id LEFT JOIN user as u ON u.user_id = l.user_id WHERE b.status ="1" GROUP BY u.user_id';

        }

        
          
        $query=$this->db->query($items);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'Whistleblower.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser
        $cells = [
                WriterEntityFactory::createCell('Supplier'),
                WriterEntityFactory::createCell('Status'),
                WriterEntityFactory::createCell('Amount'),
                
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
        //$writer->addRow(array('resource_id', 'lic_number', 'business_name', 'user_cat_name', 'Distributor Name','email','end date'));

        foreach ($obj as $row) {

           if($row['comp_tic_status']=='0'){
                       $st= 'Open';
                    }else if($row['comp_tic_status']=='1'){
                       $st= 'Pending';
                    }else if($row['comp_tic_status']=='2'){
                       $st= 'Resolved';
                    }else{
                       $st= 'Spam';
                    }
           

            $data[0] = $row['name'];
            $data[1] = $st;
            $data[2] = $row['amount'];
            
            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
        }
        $writer->close();
    }

    public function exportconsume()
    {
        set_time_limit(0);
        ini_set('memory_limit', -1);
        $userid =$this->userdata['user_id'];
        $perms=explode(",",$this->userdata['upermission']);
        $q = $this->input->post('search');
        
        if($q!=''){
             $items = 'SELECT concat(c.firstname," ",c.lastname) as cname,concat(lu.firstname," ",lu.lastname) as name, concat(u.firstname," ",u.lastname) as iname,b.business_name ,m.comp_tic_status,count(m.comp_tic_id) as amount FROM complianeticket as m LEFT JOIN business as b ON m.comp_tic_business_id = b.business_id LEFT JOIN user as c ON b.business_createdby = c.user_id LEFT JOIN indassociation as i ON c.createdby = i.user_id LEFT JOIN user as u ON u.user_id = c.user_id LEFT JOIN licensee as l ON l.user_id = i.createdby LEFT JOIN user as lu ON lu.user_id = l.user_id WHERE b.status ="1" AND c.urole_id=4 AND (b.tic_number LIKE "%'.$q.'%" OR b.tic_title LIKE "%'.$q.'%" OR c.tic_cat_name LIKE "%'.$q.'%" OR b.business_name LIKE "%'.$q.'%") GROUP BY i.user_id';

        }else{
             $items = 'SELECT concat(c.firstname," ",c.lastname) as cname,concat(lu.firstname," ",lu.lastname) as name, concat(u.firstname," ",u.lastname) as iname,b.business_name ,m.comp_tic_status,count(m.comp_tic_id) as amount FROM complianeticket as m LEFT JOIN business as b ON m.comp_tic_business_id = b.business_id LEFT JOIN user as c ON b.business_createdby = c.user_id LEFT JOIN indassociation as i ON c.createdby = i.user_id LEFT JOIN user as u ON u.user_id = c.user_id LEFT JOIN licensee as l ON l.user_id = i.createdby LEFT JOIN user as lu ON lu.user_id = l.user_id WHERE c.urole_id=4 AND b.status ="1" GROUP BY i.user_id';

        }

        
          
        $query=$this->db->query($items);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'Whistleblower.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser
        $cells = [
                WriterEntityFactory::createCell('Licensee'),
                WriterEntityFactory::createCell('Industry Association'),
                WriterEntityFactory::createCell('Consumer'),
                WriterEntityFactory::createCell('Status'),
                WriterEntityFactory::createCell('Amount'),
                
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
        //$writer->addRow(array('resource_id', 'lic_number', 'business_name', 'user_cat_name', 'Distributor Name','email','end date'));

        foreach ($obj as $row) {

           if($row['comp_tic_status']=='0'){
                       $st= 'Open';
                    }else if($row['comp_tic_status']=='1'){
                       $st= 'Pending';
                    }else if($row['comp_tic_status']=='2'){
                       $st= 'Resolved';
                    }else{
                       $st= 'Spam';
                    }
           
            $data[0] = $row['cname'];
            $data[1] = $row['name'];
            $data[2] = $row['iname'];
            $data[3] = $st;
            $data[4] = $row['amount'];
            
            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
        }
        $writer->close();
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
                    'tic_activity_createat' => 'whisle', 
                    'comp_tic_id' => $this->input->post('comp_tic_id'), 
                    'tic_activity_ipaddress' =>$ipaddress, 
                    'tic_activity_platform' => $this->agent->platform(),
                    'tic_activity_webbrowser' => $this->agent->browser(), 
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

    public function viewnote()
    {
        $type = $this->input->post('type');
        $tic_id = $this->input->post('comp_tic_id');
        $this->load->helper('text');
        $datatables = new Datatables(new CodeigniterAdapter);
        if($type){
            if($type=="All"){
                $datatables->query('SELECT m.tic_activity_title,concat(b.firstname," ",b.lastname) as name,m.tic_activity_des,m.tic_activity_createdate FROM ticket_activity as m LEFT JOIN user as b ON m.tic_activity_createdby = b.user_id WHERE m.tic_activity_createat ="whisle" AND m.comp_tic_id="'.$tic_id.'" ORDER BY m.tic_activity_createdate DESC');
            }else{

            $datatables->query('SELECT m.tic_activity_title,concat(b.firstname," ",b.lastname) as name,m.tic_activity_des,m.tic_activity_createdate FROM ticket_activity as m LEFT JOIN user as b ON m.tic_activity_createdby = b.user_id WHERE m.tic_activity_createat ="whisle" AND m.comp_tic_id="'.$tic_id.'" AND m.tic_activity_type="'.$type.'" ORDER BY m.tic_activity_createdate DESC');
            }
        }else{

        $datatables->query('SELECT m.tic_activity_title,concat(b.firstname," ",b.lastname) as name,m.tic_activity_des,m.tic_activity_createdate FROM ticket_activity as m LEFT JOIN user as b ON m.tic_activity_createdby = b.user_id WHERE m.tic_activity_createat ="whisle" AND m.comp_tic_id="'.$tic_id.'" ORDER BY m.tic_activity_createdate DESC');
        }

         $datatables->edit('tic_activity_createdate', function ($data) {
                    return date('m/d/Y',strtotime($data['tic_activity_createdate']));
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