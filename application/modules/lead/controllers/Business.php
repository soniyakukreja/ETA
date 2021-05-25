<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH. 'third_party/Spout/Autoloader/autoload.php';
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;

use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;
class Business extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->userdata = $this->session->userdata('userdata');
		$this->load->model('lead_model');
	}
	public function index()
	{
		$data['meta_title'] = "Business";
		$this->load->view('viewbusiness',$data);
	}

	public function addnew()
	{
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){

			if($this->form_validation->run('add_business')){

				$bus_name = $this->input->post('bus_name');
				
				$duplicacy = $this->lead_model->check_business_exist($bus_name); 
				if(!empty($duplicacy)){ 
					$return = array('success'=>false,'msg'=>"Business Already exist");
					echo json_encode($return); exit;					
				}

				$phone = $this->input->post('phone');
				$phonecods = $this->input->post('phonecods');
				$website = $this->input->post('website');
				$address = $this->input->post('address');
				$address_two = $this->input->post('address_two');
				$suburb = $this->input->post('suburb');
				$state = $this->input->post('state');
				$postcode = $this->input->post('postcode');
				$country = $this->input->post('country');
				$notes = $this->input->post('notes');
				$assign_to = $this->input->post('assign_to');

				$finalnum = validatePhone($phone,$phonecods);
				if(!empty($phone) && $finalnum==false){
					$return = array('success'=>false,'msg'=>"Invalid Phone number for this country");
					echo json_encode($return); exit;
				}else{
					$phone = $finalnum;
				}				

				$createddate = $updatedate = date('Y-m-d h:i:s');
				$createdby = $this->userdata['user_id'];

				$userData['business_name'] = $bus_name;
				$userData['business_phonenumber'] = $phone;
				$userData['business_website'] = $website;
				$userData['business_street1'] = $address;
				$userData['business_street2'] = $address_two;
				$userData['business_suburb'] = $suburb;
				$userData['business_state'] = $state;
				$userData['business_postalcode'] = $postcode;
				$userData['business_country'] = $country;
				$userData['business_notes'] = $notes;
				$userData['business_createddate'] = $createddate;
				$userData['business_createdby'] = $createdby;
				$userData['business_ipaddress'] = $this->input->ip_address();
				$userData['business_platform'] = $this->agent->platform();
				$userData['business_webbrowser'] = $this->agent->browser();
				if(!empty($assign_to)){ $userData['assign_to'] = $assign_to; }

				$query = $this->generalmodel->add('business',$userData);
				if(!empty($query)){
					$return = array('success'=>true,'msg'=>'Business addedd successfully');
				}else{
					$return = array('success'=>false,'msg'=>'something went wrong');
				}
			}else{
				$return = array('success'=>false,'msg'=>validation_errors());
			}
			echo json_encode($return); exit;
		}else{
			$data['countrylist'] = $this->generalmodel->countrylist();
			$data['bde_list'] = $this->generalmodel->get_my_bde();
			$data['meta_title'] = "Add Business";
			$this->load->view('lead/addbusiness',$data);
		}
	}


	public function ajax()
    {
        $userid =$this->userdata['user_id'];
        $datatables = new Datatables(new CodeigniterAdapter);

        if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
			$query = 'SELECT business_name,business_phonenumber,business_website,business_state ,business_id,business_suburb,country_name 
			FROM business 
			LEFT JOIN country as c ON c.id=business.business_country
			LEFT JOIN user as u ON u.user_id=business.business_createdby
			WHERE business.status!= "2" AND ((u.`createdby`='.$userid.' AND u.urole_id='.$this->userdata['urole_id'].') OR business.business_createdby='.$userid.')';
			
     	}else{
			$query = 'SELECT business_name,business_phonenumber,business_website,business_state ,business_id ,business_suburb,country_name 
			FROM business 
			LEFT JOIN country as c ON c.id=business.business_country
			WHERE status!= "2" AND  (business_createdby='.$userid.' OR `business`.`assign_to`='.$userid.')';
     	}
		$datatables->query($query);
        $datatables->edit('business_state', function ($data) {
        		if($data['business_state']==""){

        			return $data['business_suburb'].', '.$data['country_name'];

        		}else{

        			return $data['business_suburb'].', '.$data['business_state'].', '.$data['country_name'];

        		}
        		
        });
        // // edit 'id' column
        $datatables->edit('business_id', function ($data) {
             return '<div class="dropdown"><button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
                    <i class="glyphicon glyphicon-option-vertical"></i>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a href="'.site_url('lead/business/viewbusiness-detail/').encoding($data['business_id']).'">
                            <span class="glyphicon glyphicon-eye-open"></span> View
                        </a>
                    </li>
                     <li>
                       <a href="'.site_url('lead/business/editbusiness/').encoding($data['business_id']).'">
                            <span class="glyphicon glyphicon-pencil"></span> Edit
                        </a>
                    </li>
                    <li>
                        <a  href="javascript:void(0)" link="'.site_url('lead/business/deletebusiness/').encoding($data['business_id']).'" class="deleteEntry">
                            <span class="glyphicon glyphicon-trash"></span> Delete
                        </a>
                    </li>

                </ul><div>';
        });

        echo $datatables->generate();
    }

    public function viewbusiness_detail($id)
    {
		$id = decoding($id);
		$data['data']=$this->generalmodel->getSingleRowById('business', 'business_id', $id, $returnType = 'array');
		//$data['contact'] = $this->generalmodel->get_data_by_condition('contact_id','contact',array('business_id'=>$id));
		$data['contact'] = $this->lead_model->contact_deals_of_business($id,'current');
		$data['meta_title'] = "View Business";
		$this->load->view('business_detail',$data);
    }

    public function editbusiness($id)
	{
		$id = decoding($id);
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){

			if($this->form_validation->run('edit_business')){

				$id = $this->input->post('id');
				$bus_name = $this->input->post('bus_name');
				$phone = $this->input->post('phone');
				$phonecods = $this->input->post('phonecods');

				$website = $this->input->post('website');
				$address = $this->input->post('address');
				$address_two = $this->input->post('address_two');
				$suburb = $this->input->post('suburb');
				$state = $this->input->post('state');
				$postcode = $this->input->post('postcode');
				$country = $this->input->post('country');
				$notes = $this->input->post('notes');
				$assign_to = $this->input->post('assign_to');

				// $createddate = $updatedate = date('Y-m-d h:i:s');
				// $createdby = $this->userdata['user_id'];

				$finalnum = validatePhone($phone,$phonecods);
				if(!empty($phone) && $finalnum==false){
					$return = array('success'=>false,'msg'=>"Invalid Phone number for this country");
					echo json_encode($return); exit;
				}else{
					$phone = $finalnum;
				}		

				$userData['business_name'] = $bus_name;
				$userData['business_phonenumber'] = $phone;
				$userData['business_website'] = $website;
				$userData['business_street1'] = $address;
				$userData['business_street2'] = $address_two;
				$userData['business_suburb'] = $suburb;
				$userData['business_state'] = $state;
				$userData['business_postalcode'] = $postcode;
				$userData['business_country'] = $country;
				$userData['business_notes'] = $notes;
				// $userData['business_createddate'] = $createddate;
				// $userData['business_createdby'] = $createdby;
				$userData['business_ipaddress'] = $this->input->ip_address();
				$userData['business_platform'] = $this->agent->platform();
				$userData['business_webbrowser'] = $this->agent->browser();
				if(isset($assign_to)){ $userData['assign_to'] = $assign_to;  }

				$query = $this->generalmodel->updaterecord('business',$userData,'business_id='.$id);
				if(!empty($query)){
					$return = array('success'=>true,'msg'=>'Business Updated successfully');
				}else{
					$return = array('success'=>false,'msg'=>'something went wrong');
				}
			}else{
				$return = array('success'=>false,'msg'=>validation_errors());
			}
			echo json_encode($return); exit;
		}else{
			$data['data']=$this->generalmodel->getSingleRowById('business', 'business_id', $id, $returnType = 'array');
			$data['countrylist'] = $this->generalmodel->countrylist();
			$data['bde_list'] = $this->generalmodel->get_my_bde();
			$data['meta_title'] = "Edit Business";
			$this->load->view('lead/editbusiness', $data);
		}
	}


    public function deletebusiness($id)
    {
		$id = decoding($id);  	
      	if ($this->input->is_ajax_request()) {

      		$dealtble = $this->generalmodel->getparticularData("deal_id,deal_title",'deal',"`business_id`='$id' AND `status`='1'","row_array");
      		$contacttble = $this->generalmodel->getparticularData("contact_id,GROUP_CONCAT(' ',contact_person) AS cp",'contact',"`business_id`='$id' AND `status`='1'","row_array");

      		$ia_tble = $this->generalmodel->getparticularData("ia_id,ia_lic_number",'indassociation',"`business_id`='$id'  AND `status`='1'","row_array");
      		// print_r($ia_tble);
      		// echo $this->db->last_query(); 
      		// exit;     		
      		$lictble = $this->generalmodel->getparticularData("lic_id,lic_number",'licensee',"`business_id`='$id' AND `status`='1'","row_array");
			
			if(!empty($dealtble)){
				$return = array('success'=>false,'msg'=>$dealtble['deal_title']." Deal is connected to this Business");
			}elseif(!empty($contacttble['cp'])){
				
				$return = array('success'=>false,'msg'=>"These ".$contacttble['cp']." contact persons are connected to this business");
			}elseif(!empty($ia_tble)){
				$return = array('success'=>false,'msg'=>"This ".$ia_tble['ia_lic_number']." industry association id connected to this business");
			}elseif(!empty($lictble)){
				
				$return = array('success'=>false,'msg'=>"This ".$lictble['lic_number']." License id connected to this business");
			}else{
       			$this->generalmodel->updaterecord('business',array('status'=>'2'),'business_id='.$id);
				$return = array('success'=>true,'msg'=>'Entry Removed');
			}
		}else{
			$return = array('success'=>false,'msg'=>'Internal Error');
		}
		echo json_encode($return);

    }


    public function check_business_exist(){
    	if(!empty($this->input->post()) && $this->input->is_ajax_request()){
			$bus_name = $this->input->post('bus_name');
			if(!empty($this->input->post('bus_id'))){ $bus_id = $this->input->post('bus_id'); }else{ $bus_id = ''; }
			$result = $this->lead_model->check_business_exist($bus_name,$bus_id);
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
        
        if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
			$query = 'SELECT business_name,business_phonenumber,business_website,business_state ,business_id,business_suburb,country_name 
			FROM business 
			LEFT JOIN country as c ON c.id=business.business_country
			LEFT JOIN user as u ON u.user_id=business.business_createdby
			WHERE business.status!= "2" AND ((u.`createdby`='.$userid.' AND u.urole_id='.$this->userdata['urole_id'].') OR business.business_createdby='.$userid.')';
			
     	}else{
			$query = 'SELECT business_name,business_phonenumber,business_website,business_state ,business_id ,business_suburb,country_name 
			FROM business 
			LEFT JOIN country as c ON c.id=business.business_country
			WHERE status!= "2" AND  (business_createdby='.$userid.' OR `business`.`assign_to`='.$userid.')';
     	}

     	if($q!=''){ $query .=' AND (business_name LIKE "%'.$q.'%" OR business_phonenumber LIKE "%'.$q.'%" OR business_website LIKE "%'.$q.'%" OR business_suburb LIKE "%'.$q.'%" OR business_state LIKE "%'.$q.'%")'; }
        
        $query=$this->db->query($query);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'Business.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser
		$cells = [
			WriterEntityFactory::createCell('Business Name'),
			WriterEntityFactory::createCell('Phone Number'),
			WriterEntityFactory::createCell('Website'),
			WriterEntityFactory::createCell('Location'),
		];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
      
        foreach ($obj as $row){
        	$locArr = array();
        	$loc = '';
        	if(!empty($row['business_suburb'])){ $locArr[] =$row['business_suburb']; }
        	if(!empty($row['business_state'])){ $locArr[] =$row['business_state']; }
        	if(!empty($row['country_name'])){ $locArr[] =$row['country_name']; }
        	if(!empty($locArr)){ $loc = implode($locArr,','); }
				

            $data[0] = $row['business_name'];
            $data[1] = $row['business_phonenumber'];
            $data[2] = $row['business_website'];
            $data[3] = $loc;
            
            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
        }
        $writer->close();
    }

    public function uploadcsv(){
    	$data['meta_title'] = "Business";
    	$this->load->view('uploadcsv',$data);
    }

	public function importcsv(){

    	$filename = $_FILES["file"]["tmp_name"];
        if($_FILES["file"]["size"] > 0){
            $file = fopen($filename, "r"); 
            $i=0;
            $return = array();
	        $uploadData = $this->uploadDoc('file','./tmp_upload/',array('csv'));
	       	$filesname =  $uploadData['file_name'];

            while (($csvData = fgetcsv($file, 1000, ",")) !== FALSE) 
            {
 				$html='';
           		if($i==0)
           		{
           			$data['filename'] = $filesname;
           			$data['fields'] = $csvData;
           			$html = $this->load->view('include/contact_csv_map',$data,true);
           			
				$return = array('success'=>true,'data'=>$html);
           		}	
             
            
		 		$i++;
			}
	        //move_uploaded_file($filename, './tmp_upload/'.$filesname);

			echo json_encode($return); exit;
	    }  
	}


	public function import(){
		
		$dbfieldArr = $this->input->post('dbfield');
		$dbvalArr = $this->input->post('dbvalue');
		if(!empty($dbfieldArr)){
			
			foreach($dbfieldArr as $key=>$f){
				
				$fv = $dbvalArr[$key];

				switch($f) {
				  case 'business_name':
				  $b_col = $fv ;
				    break;
				  case 'contact_person':
				  $cp_col = $fv ;
				    break;
				  case 'contact_email':
				  $ce_col = $fv ;
				    break;
				  case 'contact_phone':
				  $cph_col = $fv ;
				    break;
				  case 'business_street1':
				  $bs_col = $fv ;
				    break;
				  case 'business_suburb':
				  $bsu_col = $fv ;
				    break;
				  case 'business_postalcode':
				  $bp_col = $fv ;
				    break;
				 case 'business_country':
				  $bc_col = $fv ;
				    break;
				}	 
			}

			$file = $fname = $this->input->post('csv');
			$filename = './tmp_upload/'.$file;
			$file = fopen($filename, "r"); 

			$i=0;
			$uploadall =true;
			$return = array();
			$bData= $userData=array();
            $createddate = $updatedate = date('Y-m-d h:i:s');
			$createdby = $this->userdata['user_id'];
			$contactCount = 0;
			$busCount = 0;
			$contact = true;
	        while (($csvData = fgetcsv($file, 1000, ",")) !== FALSE){
                if($i!=0){
					$bus_name = trim($csvData[$b_col]);
					$person = trim($csvData[$cp_col]);
					$email = trim($csvData[$ce_col]);
					$phone = trim($csvData[$cph_col]);
					$address = trim($csvData[$bs_col]);
					$suburb = trim($csvData[$bsu_col]);				
					$postcode = trim($csvData[$bp_col]);
					$country = trim($csvData[$bc_col]);	
					if(!empty($bus_name)){

						/* Duplicasy  */

						$duplicacy = $this->lead_model->check_business_exist($bus_name); 

						if(empty($duplicacy)){ 

							$bData['business_name'] = $bus_name;
							$bData['business_street1'] = $address;
							$bData['business_suburb'] = $suburb;
							$bData['business_postalcode'] = $postcode;
							$bData['business_country'] = $country;
							$bData['business_createddate'] = $createddate;
							$bData['business_createdby'] = $createdby;
							$bData['business_ipaddress'] = $this->input->ip_address();
							$bData['business_platform'] = $this->agent->platform();
							$bData['business_webbrowser'] = $this->agent->browser();

							$business_id = $this->generalmodel->add('business',$bData);
							if(empty($business_id)){
								$contact = false;
							}else{
								$busCount++;
							}	
						}else if($duplicacy['assign_to'] ==$createdby || $duplicacy['business_createdby']==$createdby){
							$business_id = $duplicacy['business_id'];
						}

						if($contact && !empty($business_id)){
							if(empty($this->lead_model->check_contact_exist($email,$business_id))){
								$userData['business_id'] = $business_id;
								$userData['contact_person'] = $person;
								$userData['contact_email'] = $email;
								$userData['contact_phone'] = $phone;
								$userData['contact_createdby'] = $createdby;
								$userData['contact_createdate'] = $createddate;
								$userData['contact_ipaddress'] = $this->input->ip_address();
								$userData['contact_platform'] = $this->agent->platform();
								$userData['contact_webbrowser'] = $this->agent->browser();
	
								$last_id = $this->generalmodel->add('contact',$userData);
								if($last_id>0){
									$contactCount++;
								}
							}
						}
					}
				}

				$i++; 
			}

			if($contactCount>0 || $busCount>0){
				unlink('./tmp_upload/'.$fname);
				$return = array('success'=>true,'msg'=>'CSV File Uploaded successfully');
			}else{
				$return = array('success'=>false,'msg'=>'Already Uploaded');
			}
			echo json_encode($return); exit;
		}

	}
}