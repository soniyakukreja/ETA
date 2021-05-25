<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH. 'third_party/Spout/Autoloader/autoload.php';
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;

use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;
class Contact extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->userdata = $this->session->userdata('userdata');
		$this->load->model('lead_model');
		//echo "<pre>"; print_r($this->userdata); exit;
	}
	public function index()
	{
		$data['meta_title'] = "Contact";
		$this->load->view('viewcontact' , $data);
	}

	public function addnew()
	{
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){

			if($this->form_validation->run('add_contactperson')){
				$bData = array();
				$business_id = $this->input->post('business_id');
				$email = $this->input->post('email');

				if(!empty($business_id) && !empty($this->lead_model->check_contact_exist($email,$business_id))){
					$return = array('success'=>false,'msg'=>"Contact Person is already added to this business");
					echo json_encode($return); exit;							
				}
				$createddate = $updatedate = date('Y-m-d h:i:s');
				$createdby = $this->userdata['user_id'];

				if(!empty($this->input->post('cp_name'))){
					$person = $this->input->post('cp_name');
				}else{
					$person = $this->input->post('person');
				}
				$phone = $this->input->post('phone');
				$phonecods = $this->input->post('phonecods');

				$notes = $this->input->post('notes');

				$bus_name = $this->input->post('bus_name');
				$address = $this->input->post('address');
				$suburb = $this->input->post('suburb');				
				$postcode = $this->input->post('postcode');
				$country = $this->input->post('country');
				
				$finalnum = validatePhone($phone,$phonecods);
				if(!empty($phone) && $finalnum==false){
					$return = array('success'=>false,'msg'=>"Invalid Phone number for this country");
					echo json_encode($return); exit;
				}else{
					$phone = $finalnum;
				}

				if(empty($business_id)){

					if(!empty($bus_name) && !empty($this->lead_model->check_business_exist($bus_name))){
						$return = array('success'=>false,'msg'=>"Business Name is occupied");
						echo json_encode($return); exit;							
					}
					$rules =array(
		                array(
		                        'field' => 'bus_name',
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

						//$business_id = $this->generalmodel->add('business',$bData);

					}else{
						$return = array('success'=>false,'msg'=>validation_errors());
						echo json_encode($return); exit;
					}
				}

				$userData['contact_person'] = $person;
				$userData['contact_email'] = $email;
				$userData['contact_phone'] = $phone;
				$userData['contact_notes'] = $notes;
				$userData['contact_createdby'] = $createdby;
				$userData['contact_createdate'] = $createddate;
				$userData['contact_ipaddress'] = $this->input->ip_address();
				$userData['contact_platform'] = $this->agent->platform();
				$userData['contact_webbrowser'] = $this->agent->browser();
				if(!empty($business_id)){ $userData['business_id'] = $business_id; }

				//$query = $this->generalmodel->add('contact',$userData);
				// echo "<pre>"; print_r($_POST); 
				// echo "<pre>"; print_r($bData); 
				// echo "<pre>"; print_r($userData); 
				// echo "add contact"; exit;
				$query = $this->lead_model->add_contact($bData,$userData);
				if(!empty($query)){
					$return = array('success'=>true,'msg'=>'Contact Person addedd successfully');
				}else{
					$return = array('success'=>false,'msg'=>'something went wrong');
				}
			}else{
				$return = array('success'=>false,'msg'=>validation_errors());
			}
			echo json_encode($return); exit;
		}else{
  			$data['countrylist'] = $this->generalmodel->countrylist();
  			$data['meta_title'] = "Add Contact";
			$this->load->view('lead/addcontact',$data);
		}
	}


	public function getBusinessList(){
		$response=array();
		if ($this->input->is_ajax_request()) {
			if(isset($_POST['term'])){
				
				$bid=$this->input->post('bid');
				$term=$this->input->post('term');
				$cp_id=$this->input->post('cp_id');

				if(!empty($bid)){
					$cp_of_business = $this->lead_model->contacts_of_business($bid);
					if(in_array($cp_id,array_column($cp_of_business, 'contact_id'))){
						$response['status']='fail';
						$response['message']="duplicate";	
						print_r(json_encode($response)); exit;
					}
				}


				$result=$this->lead_model->contact_business_suggession($term,$bid);
				$resultData='';
				$recordFound=0;
				if(!empty($result)){
					foreach($result as $cr){
						$resultData.='<li class="cp_bus_item list-group-item" data-val="'.$cr['business_id'].'">'.$cr['business_name'].'</li>';
					}
					$response['status']='success';
					$response['data']=$resultData;
				}else{

					$result=$this->lead_model->check_business_exist($term,$bid);
					if(empty($result)){
						$response['status']='fail';
						$response['message']="makenew";
					}else{
						$response['status']='fail';
						$response['message']='exist_under_cto';
					}
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

	public function ajax()
    {
    	$userid =$this->userdata['user_id'];
        $datatables = new Datatables(new CodeigniterAdapter);

        if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
        	$query = 'SELECT m.contact_person,b.business_name,m.contact_email,m.contact_phone,m.contact_id 
        	FROM contact as m 
        	LEFT JOIN business as b ON m.business_id = b.business_id 
			LEFT JOIN user as u ON u.user_id=m.contact_createdby       	
        	WHERE m.status!="2" AND ((u.`createdby`='.$userid.' AND u.`urole_id`='.$this->userdata['urole_id'].') OR m.contact_createdby='.$userid.')';
     	}else{
        	$query = 'SELECT m.contact_person,b.business_name,m.contact_email,m.contact_phone,m.contact_id 
        	FROM contact as m 
        	LEFT JOIN business as b ON m.business_id = b.business_id 
        	WHERE m.status!="2" AND m.contact_createdby='.$userid;
		}

    	$datatables->query($query);
                // // edit 'id' column
                $datatables->edit('contact_id', function ($data) {
                	 return '<div class="dropdown"><button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
                                                                    <i class="glyphicon glyphicon-option-vertical"></i>
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <li>
                                                                        <a href="'.site_url('lead/contact/contactdetail/').encoding($data['contact_id']).'">
                                                                            <span class="glyphicon glyphicon-eye-open"></span> View
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="'.site_url('lead/contact/editcontact/').encoding($data['contact_id']).'">
                                                                            <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a  href="javascript:void(0)" link="'.site_url('lead/contact/deletecontact/').encoding($data['contact_id']).'" class="deleteEntry">
                                                                            <span class="glyphicon glyphicon-trash"></span> Delete
                                                                        </a>
                                                                    </li>

                                                                </ul></div>';
                });


        echo $datatables->generate();
    }

    public function contactdetail($id)
    {
    	$id = decoding($id);
        $data['data']= $this->generalmodel->getsingleJoinData('*','contact','business','contact.business_id=business.business_id','contact.contact_id='.$id);
      $data['meta_title'] = "View Contact";
       $this->load->view('contactdetail',$data);
    }

    public function editcontact($id)
	{
		$id = decoding($id);
		$createddate = $updatedate = date('Y-m-d h:i:s');
		$createdby = $this->userdata['user_id'];
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){

			if($this->form_validation->run('edit_contactperson')){

				$id = $this->input->post('id');
				$person = $this->input->post('person');
				$business_id = $this->input->post('business_id');
				$email = $this->input->post('email');
				$phone = $this->input->post('phone');
				$phonecods = $this->input->post('phonecods');

				//============check email duplicacy==========//

				if(!empty($business_id) && !empty($this->lead_model->check_contact_exist($email,$business_id,$id))){
					$return = array('success'=>false,'msg'=>"Contact Person is already added to this business");
					echo json_encode($return); exit;							
				}
				//============validate phone number==========//
				$finalnum = validatePhone($phone,$phonecods);
				if(!empty($phone) && $finalnum==false){
					$return = array('success'=>false,'msg'=>"Invalid Phone number for this country");
					echo json_encode($return); exit;
				}else{
					$phone = $finalnum;
				}

				$notes = $this->input->post('notes');
				$bus_name = $this->input->post('bus_name');
				$address = $this->input->post('address');
				$suburb = $this->input->post('suburb');				
				$postcode = $this->input->post('postcode');
				$country = $this->input->post('country');

				if(empty($business_id)){


					if(!empty($bus_name) && !empty($this->lead_model->check_business_exist($bus_name))){
						$return = array('success'=>false,'msg'=>"Business Name is occupied");
						echo json_encode($return); exit;							
					}

					$rules =array(
		                array(
		                        'field' => 'bus_name',
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

						//$business_id = $this->generalmodel->updaterecord('business',$bData,'business_id='.$business_id);
						$business_id = $this->generalmodel->add('business',$bData);

					}else{
						$return = array('success'=>false,'msg'=>validation_errors());
						echo json_encode($return); exit;
					}
				}

				$userData['contact_person'] = $person;
				$userData['business_id'] = $business_id;
				$userData['contact_email'] = $email;
				$userData['contact_phone'] = $phone;
				$userData['contact_notes'] = $notes;
				$userData['contact_ipaddress'] = $this->input->ip_address();
				$userData['contact_platform'] = $this->agent->platform();
				$userData['contact_webbrowser'] = $this->agent->browser();

				$query = $this->generalmodel->updaterecord('contact',$userData,'contact_id='.$id);
				if(!empty($query)){
					$return = array('success'=>true,'msg'=>'Contact Person Updated successfully');
				}else{
					$return = array('success'=>false,'msg'=>'something went wrong');
				}
			}else{
				$return = array('success'=>false,'msg'=>validation_errors());
			}
			echo json_encode($return); exit;
		}else{
			$data['data']= $this->generalmodel->getsingleJoinData('*','contact','business','contact.business_id=business.business_id','contact.contact_id='.$id);
			  $data['countrylist'] = $this->generalmodel->countrylist();
			  $data['meta_title'] = "Edit Contact";
			$this->load->view('lead/editcontact', $data);
		}
	}

    public function deletecontact($id)
    {
    	$id = decoding($id);
      	if ($this->input->is_ajax_request()){

      		$query = $this->generalmodel->getparticularData("deal_id,deal_title",'deal',"`contact_id`='$id' AND `status`=1","row_array");
			if(!empty($query)){
				$return = array('success'=>false,'msg'=>"Sorry This contact person is connected with deal ".$query['deal_title']);
			}else{
	        	$this->generalmodel->updaterecord('contact',array('status'=>'2'),'contact_id='.$id);
				$return = array('success'=>true,'msg'=>'Entry Removed');
			}
		}else{
			$return = array('success'=>false,'msg'=>'Internal Error');
		}
		echo json_encode($return);
    }

    public function check_email_exist(){ 
    	if(!empty($this->input->post()) && $this->input->is_ajax_request()){
			$email = $this->input->post('email');
			$business_id = $this->input->post('business_id');
			$contactid = $this->input->post('contactid');
			if(!empty($contactid)){
				$result = $this->lead_model->check_contact_exist($email,$business_id,$contactid);
			}else{
				$result = $this->lead_model->check_contact_exist($email,$business_id);
			}
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
        	$query = 'SELECT m.contact_person,b.business_name,m.contact_email,m.contact_phone,m.contact_id 
        	FROM contact as m 
        	LEFT JOIN business as b ON m.business_id = b.business_id 
			LEFT JOIN user as u ON u.user_id=m.contact_createdby       	
        	WHERE m.status!="2" AND ((u.`createdby`='.$userid.' AND u.`urole_id`='.$this->userdata['urole_id'].') OR m.contact_createdby='.$userid.')';
     	}else{
        	$query = 'SELECT m.contact_person,b.business_name,m.contact_email,m.contact_phone,m.contact_id 
        	FROM contact as m 
        	LEFT JOIN business as b ON m.business_id = b.business_id 
        	WHERE m.status!="2" AND m.contact_createdby='.$userid;
		}

		if($q!=''){
			$query .= ' AND (m.contact_person LIKE "%'.$q.'%" OR b.business_name LIKE "%'.$q.'%" OR m.contact_email LIKE "%'.$q.'%" OR m.contact_phone LIKE "%'.$q.'%")';
		}

        $query=$this->db->query($query);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'Contact.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser
       $cells = [
                WriterEntityFactory::createCell('Name'),
                WriterEntityFactory::createCell('Business'),
                WriterEntityFactory::createCell('Email Address'),
                WriterEntityFactory::createCell('Phone Number'),
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
      
        foreach ($obj as $row) {
            $data[0] = $row['contact_person'];
            $data[1] = $row['business_name'];
            $data[2] = $row['contact_email'];
            $data[3] = $row['contact_phone'];
            
            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
        }
        $writer->close();
    }

    public function getCpList(){

		$response=array();
		if ($this->input->is_ajax_request()) {
			if(isset($_POST['term'])){
				
				$term=$this->input->post('term');
				$result=$this->lead_model->cp_suggession($term);

				$resultData='';
				$recordFound=0;
				if(!empty($result)){
					foreach($result as $cr){
						$resultData.='<li class="cp_item list-group-item" data-val="'.$cr['contact_id'].'" data-email="'.$cr['contact_email'].'" data-phone="'.$cr['contact_phone'].'" cp_business_id="'.$cr['business_id'].'" cp_name="'.$cr['contact_person'].'">'.$cr['contact_person'].'('.$cr['business_name'].')</li>';
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

}