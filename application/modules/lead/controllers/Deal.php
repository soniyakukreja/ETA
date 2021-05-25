<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH. 'third_party/Spout/Autoloader/autoload.php';
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;

use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;
class Deal extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->userdata = $this->session->userdata('userdata');
		$this->load->model('lead_model');
	}
	public function index()
	{
		$data['meta_title'] = "Deal";
		$this->load->view('viewdeal',$data);
	}


	public function addnew()
	{
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){

			if($this->form_validation->run('add_deal')){

				$deal_title = $this->input->post('deal_title');
				$contact_id = $this->input->post('cp');
				$business_id = $this->input->post('business_id');				
				$deal_value = $this->input->post('deal_value');
				$stage = $this->input->post('stage');
				$close_date = $this->input->post('close_date');
				$notes = $this->input->post('notes');				
				$createddate = $updatedate = date('Y-m-d h:i:s');
				$createdby = $this->userdata['user_id'];
				$ip_address = $this->input->ip_address();
				$platform = $this->agent->platform();
				$browser = $this->agent->browser();


				$dealData['deal_title'] = $deal_title;
				$dealData['contact_id'] = $contact_id;
				$dealData['business_id'] = $business_id;
				$dealData['deal_value'] = $deal_value;
				$dealData['pstage_id'] = $stage;
				
				if(!empty($close_date)){
					$dealData['deal_exp_closedate'] = get_ymd_format($close_date);
				}else{
					$dealData['deal_exp_closedate'] = "0000-00-00";
				}
					
				$dealData['deal_age'] = '';
				$dealData['deal_notes'] = $notes;
				$dealData['deal_createdby'] = $createdby;
				$dealData['deal_createdate'] = $createddate;
				$dealData['deal_ipaddress'] = $ip_address;
				$dealData['deal_platform'] = $platform;
				$dealData['deal_webbrowser'] = $browser;
				$dealData['stagemodifydate'] = $createddate;

				$query = $this->generalmodel->add('deal',$dealData);
				
				if(!empty($query)){
					$return = array('success'=>true,'msg'=>'Deal addedd successfully');
				}else{
					$return = array('success'=>false,'msg'=>'something went wrong');
				}
			}else{
				$return = array('success'=>false,'msg'=>validation_errors());
			}
			echo json_encode($return); exit;
		}else{
			$data['countrylist'] = $this->generalmodel->countrylist();
			$data['stages'] = $this->lead_model->get_my_stages();
			$data['meta_title'] = "Add Deal";
			$this->load->view('lead/adddeal',$data);
		}
	}
	
/*
	public function addnew()
	{
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){

			$deal_title = $this->input->post('deal_title');
			$contact_id = $this->input->post('contact_id');
			$cp_name = $this->input->post('cp_name');

			if(empty($contact_id)){

				if($this->form_validation->run('add_deal_with_cp_business')){

					
					$email = $this->input->post('email');
					$phone = $this->input->post('phone');
					$phonecods = $this->input->post('phonecods');


					$finalnum = validatePhone($phone,$phonecods);
					if(!empty($phone) && $finalnum==false){
						$return = array('success'=>false,'msg'=>"Invalid Phone number for this country");
						echo json_encode($return); exit;
					}

					$cpData['contact_email'] = $email;			
					$cpData['contact_phone'] = $finalnum;	
				}else{
					$return = array('success'=>false,'msg'=>validation_errors());
					echo json_encode($return); exit;
				}		
			}

			$business_id = $this->input->post('business_id');
			$bus_name = $this->input->post('bus_name');
			if(empty($bus_name) &&  empty($business_id)){
				$return = array('success'=>false,'msg'=>'Please add Business');
				echo json_encode($return); exit;
			}


			if($this->form_validation->run('add_deal')){

				$createddate = $updatedate = date('Y-m-d h:i:s');
				$createdby = $this->userdata['user_id'];
				$ip_address = $this->input->ip_address();
				$platform = $this->agent->platform();
				$browser = $this->agent->browser();

				$address = $this->input->post('address');
				$suburb = $this->input->post('suburb');
				$postcode = $this->input->post('postcode');
				$country = $this->input->post('country');
				$deal_value = $this->input->post('deal_value');
				$stage = $this->input->post('stage');
				//$age = $this->input->post('age');
				$close_date = $this->input->post('close_date');
				$notes = $this->input->post('notes');

				$dealData['deal_title'] = $deal_title;
				$dealData['deal_value'] = $deal_value;
				$dealData['pstage_id'] = $stage;
				
				if(!empty($close_date)){
					$dealData['deal_exp_closedate'] = get_ymd_format($close_date);
				}else{
					$dealData['deal_exp_closedate'] = "0000-00-00";
				}
					
				$dealData['deal_age'] = '';
				$dealData['deal_notes'] = $notes;
				$dealData['deal_createdby'] = $createdby;
				$dealData['deal_createdate'] = $createddate;
				$dealData['deal_ipaddress'] = $ip_address;
				$dealData['deal_platform'] = $platform;
				$dealData['deal_webbrowser'] = $browser;
				$dealData['stagemodifydate'] = $createddate;
				
				if(!empty($business_id) && !empty($contact_id)){
					$dealData['business_id'] = $business_id;
					$dealData['contact_id'] = $contact_id;					
					$query = $this->generalmodel->add('deal',$dealData);
				}else{
				

					//=====business table data============//
					$busData['business_name'] = $bus_name;
					$busData['business_street1'] = $address;
					$busData['business_suburb'] = $suburb;
					$busData['business_postalcode'] = $postcode;
					$busData['business_country'] = $country;
					$busData['business_createddate'] = $createddate;
					$busData['business_createdby'] = $createdby;
					$busData['business_ipaddress'] = $ip_address;
					$busData['business_platform'] = $platform;
					$busData['business_webbrowser'] = $browser;
					//=====business table data============//

					//=====contact table data============//
					$cpData['contact_person'] = $cp_name;
					
					$cpData['contact_createdby'] = $createdby;
					$cpData['contact_createdate'] = $createddate;
					
					$cpData['contact_ipaddress'] = $ip_address;
					$cpData['contact_platform'] = $platform;
					$cpData['contact_webbrowser'] = $browser;
					//=====contact table data============//

					$query = $this->generalmodel->add_deal($busData,$cpData,$dealData);
				}
				
				if(!empty($query)){
					$return = array('success'=>true,'msg'=>'Deal addedd successfully');
				}else{
					$return = array('success'=>false,'msg'=>'something went wrong');
				}
			}else{
				$return = array('success'=>false,'msg'=>validation_errors());
			}
			echo json_encode($return); exit;
		}else{
			$data['countrylist'] = $this->generalmodel->countrylist();
			//$data['stages'] = $this->generalmodel->get_data_by_condition('pstage_name,pstage_id','pipelinstage',array('pstage_status'=>1,'roles_id'=>$this->userdata['urole_id'],'user_id'=>$this->userdata['createdby']));
			$data['stages'] = $this->lead_model->get_my_stages();
			$this->load->view('lead/adddeal',$data);
		}
	}
*/	

	public function getCP(){
		$response=array();
		if ($this->input->is_ajax_request()) {
			if(isset($_POST['term'])){
				
				$term=$this->input->post('term');
				$business=$this->input->post('business');
				$result=$this->lead_model->cp_suggession($term,$business);

				$resultData='';
				$recordFound=0;
				if(!empty($result)){
					foreach($result as $cr){
						$resultData.='<li class="cpItem list-group-item" cval="'.$cr['contact_id'].'" bval="'.$cr['business_id'].'" bname="'.$cr['business_name'].'" >'.$cr['contact_person'].'</li>';
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


	public function ajaxdeal()
    {
    	$userid =$this->userdata['user_id'];
        $datatables = new Datatables(new CodeigniterAdapter);
        if ($this->userdata['urole_id']==1 && ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10)){
        	$query = 'SELECT m.deal_title,c.contact_person,b.business_name,m.deal_value,p.pstage_name,m.deal_exp_closedate,m.deal_id 
        	FROM deal as m 
        	LEFT JOIN user as u ON m.deal_createdby = u.user_id 
        	LEFT JOIN business as b ON m.business_id = b.business_id 
        	LEFT JOIN contact as c ON m.contact_id = c.contact_id 
        	LEFT JOIN pipelinstage as p ON m.pstage_id = p.pstage_id 
        	WHERE m.status!="2"';

        }elseif ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
        	
        	$query = 'SELECT m.deal_title,c.contact_person,b.business_name,m.deal_value,p.pstage_name,m.deal_exp_closedate,m.deal_id 
        	FROM deal as m 
        	LEFT JOIN user as u ON m.deal_createdby = u.user_id 
        	LEFT JOIN business as b ON m.business_id = b.business_id 
        	LEFT JOIN contact as c ON m.contact_id = c.contact_id 
        	LEFT JOIN pipelinstage as p ON m.pstage_id = p.pstage_id 
        	WHERE m.status!="2" AND (u.createdby = "'.$userid.'" OR u.user_id='.$userid.')';

    	}else{
    		$query ='SELECT m.deal_title,c.contact_person,b.business_name,m.deal_value,p.pstage_name,m.deal_exp_closedate,m.deal_id FROM deal as m LEFT JOIN business as b ON m.business_id = b.business_id LEFT JOIN contact as c ON m.contact_id = c.contact_id LEFT JOIN pipelinstage as p ON m.pstage_id = p.pstage_id WHERE m.status!="2" AND m.deal_createdby="'.$userid.'"';
    	}
        	$datatables->query($query);
        		$datatables->edit('deal_exp_closedate', function ($data) {
        			if($data['deal_exp_closedate'] !='0000-00-00 00:00:00'){ return date('m/d/Y',strtotime($data['deal_exp_closedate'])); }else{ return ''; }
        		});

        		// $datatables->edit('deal_value', function ($data) {
        		// 			setlocale(LC_MONETARY,"en_US");
        		// 	return  money_format("$%i", $data['deal_value']).' USD';
        		// });

        		$datatables->edit('deal_value', function ($data) {
        					
        			return  numfmt_format_currency($this->fmt,$data['deal_value'], "USD").' USD';
        		});
                // // edit 'id' column
                $datatables->edit('deal_id', function ($data) {
                	 return '<div class="dropdown"><button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
                                                                    <i class="glyphicon glyphicon-option-vertical"></i>
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <li>
                                                                        <a href="'.site_url('lead/deal/dealdetail/').encoding($data['deal_id']).'">
                                                                            <span class="glyphicon glyphicon-eye-open"></span> View
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="'.site_url('lead/deal/editdeal/').encoding($data['deal_id']).'">
                                                                            <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:void(0)" link="'.site_url('lead/Deal/deletedeal/').encoding($data['deal_id']).'" class="deleteEntry">
                                                                            <span class="glyphicon glyphicon-trash"></span> Delete
                                                                        </a>
                                                                    </li>
                                                                </ul></div>';
                });


        echo $datatables->generate();
    }

    //==get business suggession to create deal===========//
    public function business_for_deal(){
		$response=array();
		if ($this->input->is_ajax_request()) {
			if(isset($_POST['term'])){
				
				$term=$this->input->post('term');
				$result=$this->lead_model->deal_business_suggession($term);

				$resultData='';
				$recordFound=0;
				if(!empty($result)){
					foreach($result as $cr){
						$resultData.='<li class="deal_busItem list-group-item" data-val="'.$cr['business_id'].'">'.$cr['business_name'].'</li>';
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

	public function contacts_of_business(){
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
			if(!empty($this->input->post('bid'))){
				
				$term=$this->input->post('bid');
				$result=$this->lead_model->contacts_of_business($term);

				$resultData='<option value="0">Please Select</option>';
				$recordFound=0;
				if(!empty($result)){

					foreach($result as $cr){
						$resultData.='<option value="'.$cr['contact_id'].'">'.$cr['contact_person'].'</option>';
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

    public function dealdetail($id)
    {
     	$id=decoding($id);
       $data['data']= $this->lead_model->deal_detail($id);
       $data['meta_title'] = "View Deal";
       $this->load->view('deal_detail',$data);
    }

   public function editdeal($id)
	{	
		$id=decoding($id);
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){

			//print_r($_POST); exit;

			$deal_title = $this->input->post('deal_title');
			$cp_name = $this->input->post('cp_name');
			$contact_id = $this->input->post('contact_id');

			if(empty($cp_name) &&  empty($contact_id)){
				$return = array('success'=>false,'msg'=>'Please add Contact Person');
				echo json_encode($return); exit;
			}

			$business_id = $this->input->post('business_id');
			$bus_name = $this->input->post('bus_name');
			if(empty($bus_name) &&  empty($business_id)){
				$return = array('success'=>false,'msg'=>'Please add Business');
				echo json_encode($return); exit;
			}

			if($this->form_validation->run('edit_deal')){

				$ip_address = $this->input->ip_address();
				$platform = $this->agent->platform();
				$browser = $this->agent->browser();

				$id = $this->input->post('id');
				$address = $this->input->post('address');
				$suburb = $this->input->post('suburb');
				$postcode = $this->input->post('postcode');
				$country = $this->input->post('country');
				$deal_value = $this->input->post('deal_value');
				$stage = $this->input->post('stage');
				$close_date = $this->input->post('close_date');
				$notes = $this->input->post('notes');


				$dealData['deal_title'] = $deal_title;
				$dealData['deal_value'] = $deal_value;
				$dealData['pstage_id'] = $stage;

				if(!empty($close_date)){
					$dealData['deal_exp_closedate'] = get_ymd_format($close_date);
				}else{
					$dealData['deal_exp_closedate'] = "0000-00-00";
				}

				$dealData['deal_age'] = 0;
				$dealData['deal_notes'] = $notes;
				$dealData['deal_ipaddress'] = $ip_address;
				$dealData['deal_platform'] = $platform;
				$dealData['deal_webbrowser'] = $browser;

				/*
				if(!empty($business_id) && !empty($contact_id)){
					//$dealData['business_id'] = $business_id;
					$dealData['contact_id'] = $contact_id;					
					$query = $this->generalmodel->updaterecord('deal',$dealData,'deal_id='.$id);
				}else{
				

					//=====business table data============//
					$busData['business_name'] = $bus_name;
					$busData['business_street1'] = $address;
					$busData['business_suburb'] = $suburb;
					$busData['business_postalcode'] = $postcode;
					$busData['business_country'] = $country;
					$busData['business_createddate'] = $createddate;
					$busData['business_createdby'] = $createdby;
					$busData['business_ipaddress'] = $ip_address;
					$busData['business_platform'] = $platform;
					$busData['business_webbrowser'] = $browser;
					//=====business table data============//

					//=====contact table data============//
					$cpData['contact_person'] = $cp_name;
					$cpData['contact_ipaddress'] = $ip_address;
					$cpData['contact_platform'] = $platform;
					$cpData['contact_webbrowser'] = $browser;
					//=====contact table data============//

					$query = $this->generalmodel->add_deal($busData,$cpData,$dealData);
				}
				*/

				$dealData['contact_id'] = $contact_id;
				$dealData['business_id'] = $business_id;

// echo "<pre>"; print_r($_POST); 
// echo "<pre>"; print_r($dealData); 

				$query = $this->generalmodel->updaterecord('deal',$dealData,'deal_id='.$id);

				if(!empty($query)){
					$return = array('success'=>true,'msg'=>'Deal updated successfully');
				}else{
					$return = array('success'=>false,'msg'=>'something went wrong');
				}
			}else{
				$return = array('success'=>false,'msg'=>validation_errors());
			}
			echo json_encode($return); exit;
		}else{
			$data['countrylist'] = $this->generalmodel->countrylist();
			//$data['data']= $this->generalmodel->threetables('deal.*,business.*,contact.contact_person,contact.contact_id','deal','business','contact','deal.business_id=business.business_id','business.business_id=contact.business_id','deal.deal_id='.$id,'');

			$tables[0]['table'] = 'business';
			$tables[0]['on'] = 'business.business_id = deal.business_id';

			$tables[1]['table'] = 'contact';
			$tables[1]['on'] = 'contact.contact_id = deal.contact_id';

			$data['data']= $this->generalmodel->getfrommultipletables("deal.*,business.*,contact.contact_person,contact.contact_id",'deal',$tables,"deal.deal_id=$id","","","","","row_array");
			//echo "<pre>"; print_r($data); exit;

			$data['stages'] = $this->generalmodel->get_data_by_condition('pstage_name,pstage_id','pipelinstage',array('pstage_status'=>1,'roles_id'=>$this->userdata['urole_id'],'user_id'=>$this->userdata['createdby']));
			$data['meta_title'] = "Edit Deal";
       			$this->load->view('lead/editdeal', $data);
		}
	}

    public function deletedeal($id)
    {
       	if ($this->input->is_ajax_request()) {

       		$dealtble = $this->generalmodel->getparticularData("deal_id,deal_exp_closedate",'deal',"`deal_id`='$id' AND `deal_exp_closedate`< '".date('Y-m-d')."'","row_array");
			if(empty($dealtble)){
				$return = array('success'=>false,'msg'=>"You cann't delete deal before its expiration");
			}else{
        		$this->generalmodel->updaterecord('deal',array('status'=>'2'),'deal_id='.$id);
				$return = array('success'=>true,'msg'=>'Entry Removed');
			}
			
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
                	'app_activity_createat' => 'deal', 
                	// 'app_activity_createat' => 'lic-'.$this->input->post('lic_id'), 
                	'deal_id' => $this->input->post('deal_id'), 
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
    	$deal_id = $this->input->post('deal_id');
    	$this->load->helper('text');
        $datatables = new Datatables(new CodeigniterAdapter);
        $datatables->query('SELECT m.app_activity_title,concat(b.firstname," ",b.lastname) as name,m.app_activity_des,m.app_activity_createdate FROM app_activity as m LEFT JOIN user as b ON m.app_activity_createdby = b.user_id WHERE m.app_activity_createat ="deal" AND m.deal_id="'.$deal_id.'"');
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

    public function export()
    {
        set_time_limit(0);
        ini_set('memory_limit', -1);
        $userid =$this->userdata['user_id'];
        $perms=explode(",",$this->userdata['upermission']);
        $q = $this->input->post('search');

		if($this->userdata['urole_id']==1 && ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10)){
        	$query = 'SELECT m.deal_title,c.contact_person,b.business_name,m.deal_value,p.pstage_name,m.deal_exp_closedate,m.deal_id 
        	FROM deal as m 
        	LEFT JOIN user as u ON m.deal_createdby = u.user_id 
        	LEFT JOIN business as b ON m.business_id = b.business_id 
        	LEFT JOIN contact as c ON m.contact_id = c.contact_id 
        	LEFT JOIN pipelinstage as p ON m.pstage_id = p.pstage_id 
        	WHERE m.status!="2"';

        }elseif ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
        	
        	$query = 'SELECT m.deal_title,c.contact_person,b.business_name,m.deal_value,p.pstage_name,m.deal_exp_closedate,m.deal_id 
        	FROM deal as m 
        	LEFT JOIN user as u ON m.deal_createdby = u.user_id 
        	LEFT JOIN business as b ON m.business_id = b.business_id 
        	LEFT JOIN contact as c ON m.contact_id = c.contact_id 
        	LEFT JOIN pipelinstage as p ON m.pstage_id = p.pstage_id 
        	WHERE m.status!="2" AND (u.createdby = "'.$userid.'" OR u.user_id='.$userid.')';

    	}else{
    		$query ='SELECT m.deal_title,c.contact_person,b.business_name,m.deal_value,p.pstage_name,m.deal_exp_closedate,m.deal_id FROM deal as m LEFT JOIN business as b ON m.business_id = b.business_id LEFT JOIN contact as c ON m.contact_id = c.contact_id LEFT JOIN pipelinstage as p ON m.pstage_id = p.pstage_id WHERE m.status!="2" AND m.deal_createdby="'.$userid.'"';
    	}
		if($q!=''){ $query .=' AND (m.deal_title LIKE "%'.$q.'%" OR c.contact_person LIKE "%'.$q.'%" OR b.business_name LIKE "%'.$q.'%" OR m.deal_value LIKE "%'.$q.'%" OR p.pstage_name LIKE "%'.$q.'%" OR m.deal_exp_closedate LIKE "%'.$q.'%")'; }
        $query .=' ORDER BY m.deal_title';
        /*
        if($q!=''){

			if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
	        	$items = 'SELECT m.deal_title,c.contact_person,b.business_name,m.deal_value,p.pstage_name,m.deal_exp_closedate,m.deal_id FROM deal as m LEFT JOIN business as b ON m.business_id = b.business_id LEFT JOIN contact as c ON m.contact_id = c.contact_id LEFT JOIN pipelinstage as p ON m.pstage_id = p.pstage_id WHERE m.status!="2" AND (m.deal_title LIKE "%'.$q.'%" OR c.contact_person LIKE "%'.$q.'%" OR b.business_name LIKE "%'.$q.'%" OR m.deal_value LIKE "%'.$q.'%" OR p.pstage_name LIKE "%'.$q.'%" OR m.deal_exp_closedate LIKE "%'.$q.'%")';
	    	}else{
	    	    $items = 'SELECT m.deal_title,c.contact_person,b.business_name,m.deal_value,p.pstage_name,m.deal_exp_closedate,m.deal_id FROM deal as m LEFT JOIN business as b ON m.business_id = b.business_id LEFT JOIN contact as c ON m.contact_id = c.contact_id LEFT JOIN pipelinstage as p ON m.pstage_id = p.pstage_id WHERE m.status!="2" AND m.deal_createdby="'.$userid.'" AND (m.deal_title LIKE "%'.$q.'%" OR c.contact_person LIKE "%'.$q.'%" OR b.business_name LIKE "%'.$q.'%" OR m.deal_value LIKE "%'.$q.'%" OR p.pstage_name LIKE "%'.$q.'%" OR m.deal_exp_closedate LIKE "%'.$q.'%")';
	    	}   

		}else{

	    	if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
        		$items = 'SELECT m.deal_title,c.contact_person,b.business_name,m.deal_value,p.pstage_name,m.deal_exp_closedate,m.deal_id FROM deal as m LEFT JOIN business as b ON m.business_id = b.business_id LEFT JOIN contact as c ON m.contact_id = c.contact_id LEFT JOIN pipelinstage as p ON m.pstage_id = p.pstage_id WHERE m.status!="2"';
	    	}else{
	    		$items = 'SELECT m.deal_title,c.contact_person,b.business_name,m.deal_value,p.pstage_name,m.deal_exp_closedate,m.deal_id FROM deal as m LEFT JOIN business as b ON m.business_id = b.business_id LEFT JOIN contact as c ON m.contact_id = c.contact_id LEFT JOIN pipelinstage as p ON m.pstage_id = p.pstage_id WHERE m.status!="2" AND m.deal_createdby="'.$userid.'"';
	    	}
		}
        $query=$this->db->query($items);
        */
        $query=$this->db->query($query);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'Deal.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser
       $cells = [
                WriterEntityFactory::createCell('Deal Title'),
                WriterEntityFactory::createCell('Person'),
                WriterEntityFactory::createCell('Business'),
                WriterEntityFactory::createCell('Deal Value'),
                WriterEntityFactory::createCell('Stage'),
                WriterEntityFactory::createCell('Expected Close Date'),
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
      
        foreach ($obj as $row) {
            $data[0] = $row['deal_title'];
            $data[1] = $row['contact_person'];
            $data[2] = $row['business_name'];
            $data[3] = $row['deal_value'];
            $data[4] = $row['pstage_name'];
            $data[5] = date('m/d/Y',strtotime($row['deal_exp_closedate']));
            
            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
        }
        $writer->close();
    }

}