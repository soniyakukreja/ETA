<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH. 'third_party/Spout/Autoloader/autoload.php';
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;

use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;
class Pipeline extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->userdata = $this->session->userdata('userdata');
		$this->load->model('lead_model');
	}
	public function index()
	{	
		$userid = $this->userdata['user_id'];
		/*
		if($this->userdata['urole_id']==1 && ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10)){
        	$query = 'SELECT m.deal_title,c.contact_person,b.business_name,m.deal_value,p.pstage_name,m.deal_exp_closedate,m.deal_id,m.pstage_id,m.stagemodifydate,m.business_id,m.contact_id,m.user_id 
        	FROM deal as m 
        	LEFT JOIN user as u ON m.deal_createdby = u.user_id 
        	LEFT JOIN business as b ON m.business_id = b.business_id 
        	LEFT JOIN contact as c ON m.contact_id = c.contact_id 
        	LEFT JOIN pipelinstage as p ON m.pstage_id = p.pstage_id 
        	WHERE m.status!="2"';

        }else
        */
        if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
        	
        	$query = 'SELECT m.deal_title,c.contact_person,b.business_name,m.deal_value,p.pstage_name,m.deal_exp_closedate,m.deal_id,m.pstage_id,m.stagemodifydate,m.business_id,m.contact_id,m.user_id 
        	FROM deal as m 
        	LEFT JOIN user as u ON m.deal_createdby = u.user_id 
        	LEFT JOIN business as b ON m.business_id = b.business_id 
        	LEFT JOIN contact as c ON m.contact_id = c.contact_id 
        	LEFT JOIN pipelinstage as p ON m.pstage_id = p.pstage_id 
        	WHERE m.status!="2" AND m.user_id=0  AND (u.createdby = "'.$userid.'" OR u.user_id='.$userid.')';

    	}else{
    		$query ='SELECT m.deal_title,c.contact_person,b.business_name,m.deal_value,p.pstage_name,m.deal_exp_closedate,m.deal_id,m.pstage_id,m.stagemodifydate,m.business_id,m.contact_id,m.user_id 
    		FROM deal as m 
    		LEFT JOIN business as b ON m.business_id = b.business_id 
    		LEFT JOIN contact as c ON m.contact_id = c.contact_id 
    		LEFT JOIN pipelinstage as p ON m.pstage_id = p.pstage_id 
    		WHERE m.status!="2" AND m.user_id=0 AND m.deal_createdby="'.$userid.'"';
    	}

    	$data['data'] = $this->db->query($query)->result_array();
// echo $this->db->last_query();
// echo "<pre>"; print_r($data); exit;		
    	$data['stages'] = $this->lead_model->get_my_stages();
		/*if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
			$data['data']= $this->generalmodel->threetablesall('deal.*,business.*,contact.*','deal','business','contact','deal.business_id=business.business_id','deal.contact_id=contact.contact_id',array('deal.status !='=>'2','user_id'=>'0' ));
		}else{
			$data['data']= $this->generalmodel->threetablesall('deal.*,business.*,contact.*','deal','business','contact','deal.business_id=business.business_id','deal.contact_id=contact.contact_id',array('deal.status !='=>'2','user_id'=>'0','deal.deal_createdby'=>$this->userdata['user_id']));
		}
		*/
		//$data['stages'] = $this->generalmodel->get_data_by_condition('pstage_name,pstage_id,last_stage','pipelinstage',array('pstage_status'=>'1','roles_id'=>$this->userdata['urole_id'],'user_id'=>$this->userdata['user_id']));


		$data['meta_title'] = "Pipeline";
		$this->load->view('pipeline', $data);
	}


	public function changestage(){
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){

                $id =$this->input->post('deal_id');
                 
                $stage = $this->generalmodel->getSingleRowById('deal', 'deal_id', $id, $returnType = 'array');
                $stgnm = $this->generalmodel->getSingleRowById('pipelinstage', 'pstage_id', $stage['pstage_id'], $returnType = 'array');
                $stgnm1 = $this->generalmodel->getSingleRowById('pipelinstage', 'pstage_id', $this->input->post('deal_stage'), $returnType = 'array');
                $stage_name = $stgnm['pstage_name'];
                $stage_name1 = $stgnm1['pstage_name'];
                $data = array(
                     
                    'pstage_id' => $this->input->post('deal_stage'), 
                    'stagemodifydate' => date('Y-m-d h:i:s'), 
                 
                );

                $query = $this->generalmodel->updaterecord('deal',$data,'deal_id='.$id);

                if($query>0){

                	if($this->form_validation->run('add_note')){
				
						$createdate = date('Y-m-d h:i:s');
		                $createdby = $this->userdata['user_id'];
		                // $resource_id =  rand(111,999);
		               	$ipaddress = $this->input->ip_address();

		                $data1 = array(
		                	'app_activity_title' => $stage_name.' to '.$stage_name1, 
		                	'app_activity_des' => $this->input->post('app_activity_des'), 
		                	'app_activity_createdate' =>  $createdate, 
		                	'app_activity_createdby' => $createdby, 
		                	'app_activity_createat' => 'Deal', 
		                	// 'app_activity_createat' => 'lic-'.$this->input->post('lic_id'), 
		                	'deal_id' => $id, 
		                	'app_activity_ipaddress' =>$ipaddress, 
		                	'app_activity_platform' => $this->agent->platform(),
		                	'app_activity_webbrowser' => $this->agent->browser(), 
		                );
		                // print_r($data1); exit;
		              $lastid = $this->generalmodel->add('app_activity', $data1);

		              if($lastid){

						$userid = $this->userdata['user_id'];


						/********************* Mail Send ********************/
						if($stgnm1['last_stage']==1){
							$deal= $this->lead_model->deal_detail($id);
							
							$link = site_url('lead/deal/dealdetail/').encoding($id);

			                $mailContent = $this->generalmodel->mail_template('email_subject,email_body','deal_ready_bde');

			                $user = $this->generalmodel->getparticularData('firstname,lastname,user_id,createdby,email','user',array('user_id'=>$userid),$returnType="result_array");
			            
			                $cto = $this->generalmodel->getparticularData('firstname,lastname,user_id,email','user',array('user_id'=>$user[0]['createdby'],'dept_id'=>2),$returnType="result_array");

							$toCTO = $cto[0]['email'];
							$toBDE = $user[0]['email'];

			                $name = $cto[0]['firstname'].' '.$cto[0]['lastname'];
			                $businessname = $deal['business_name'];
			                $contactperson = $deal['contact_person'];
			                $dealvalue = $deal['deal_value'];
			                $username = $user[0]['firstname'].' '.$user[0]['lastname'] ;
			                $reset_link = '<a href="'.$link.'" style="background: #0059b3; color: #fff; padding: 15px 30px;text-decoration: none;border-radius: 5px;">View Detail</a>';

			                $content = $mailContent['email_body'];
			                $content = str_replace('[name]',$username,$content);
			                $content = str_replace('[bde_fname]',$username,$content);
			                $content = str_replace('[contact_fname]',$contactperson,$content);
			                $content = str_replace('[business_name]',$businessname,$content);
			                $content = str_replace('[deal_value]',$dealvalue,$content);
			                $content = str_replace('[description_link]',$reset_link,$content); 

			                $subject = $mailContent['email_subject'];
			                $subject = str_replace('[bde_fname]',$username,$subject);
			                $subject = str_replace('[contact_fname]',$contactperson,$subject);
			                $subject = str_replace('[business_name]',$businessname,$subject);
			                
							$message = $this->load->view('include/mail_template',array('body'=>$content),true);
							
							$mailresponce = $this->sendGridMail('',$toBDE,$subject,$message);

// echo $toBDE."<br>".$subject;
echo $message; exit;

							$mailContentCTO = $this->generalmodel->mail_template('email_subject,email_body','deal_ready_cto');

							$content1 = $mailContentCTO['email_body'];
			                $content1 = str_replace('[name]',$name,$content1);
			                $content1 = str_replace('[bde_fname]',$username,$content1);
			                $content1 = str_replace('[contact_fname]',$contactperson,$content1);
			                $content1 = str_replace('[business_name]',$businessname,$content1);
			                $content1 = str_replace('[deal_value]',$dealvalue,$content1);
			                $content1 = str_replace('[description_link]',$reset_link,$content1); 

			                $subject1 = $mailContentCTO['email_subject'];
			                $subject1 = str_replace('[bde_fname]',$username,$subject1);
			                $subject1 = str_replace('[contact_fname]',$contactperson,$subject1);
			                $subject1 = str_replace('[business_name]',$businessname,$subject1);
			                
							$message1 = $this->load->view('include/mail_template',array('body'=>$content1),true);
							
							$mailresponce = $this->sendGridMail('',$toCTO,$subject1,$message1);
						}
						/*************************************************************************/

				        if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
				        	
				        	$query = 'SELECT m.deal_title,c.contact_person,b.business_name,m.deal_value,p.pstage_name,m.deal_exp_closedate,m.deal_id,m.pstage_id,m.stagemodifydate,m.business_id,m.contact_id,m.user_id 
				        	FROM deal as m 
				        	LEFT JOIN user as u ON m.deal_createdby = u.user_id 
				        	LEFT JOIN business as b ON m.business_id = b.business_id 
				        	LEFT JOIN contact as c ON m.contact_id = c.contact_id 
				        	LEFT JOIN pipelinstage as p ON m.pstage_id = p.pstage_id 
				        	WHERE m.status!="2" AND m.user_id=0 AND (u.createdby = "'.$userid.'" OR u.user_id='.$userid.')';

				    	}else{
				    		$query ='SELECT m.deal_title,c.contact_person,b.business_name,m.deal_value,p.pstage_name,m.deal_exp_closedate,m.deal_id,m.pstage_id,m.stagemodifydate,m.business_id,m.contact_id,m.user_id 
				    		FROM deal as m 
				    		LEFT JOIN business as b ON m.business_id = b.business_id 
				    		LEFT JOIN contact as c ON m.contact_id = c.contact_id 
				    		LEFT JOIN pipelinstage as p ON m.pstage_id = p.pstage_id 
				    		WHERE m.status!="2" AND m.user_id=0 AND m.deal_createdby="'.$userid.'"';
				    	}

				    	$data['data'] = $this->db->query($query)->result_array();
						
				    	$data['stages'] = $this->lead_model->get_my_stages();

                		$view = $this->load->view('testpipe', $data,true);

                    	$return = array('success'=>true,'msg'=>'Deal Stage Changed Successfully','view'=>$view);
		              }

		          }else{
		                $return = array('success'=>false,'msg'=>validation_errors());
		          }

		        
                }else{
                    $return = array('success'=>false,'msg'=>'something went wrong');
                }
            }else{
                $return = array('success'=>false,'msg'=>validation_errors());
            }

            echo json_encode($return);
		}

		public function changename(){
			if(!empty($this->input->post()) && $this->input->is_ajax_request()){

	                $id =$this->input->post('stage_id');
	                $data = array(
                     
                    'pstage_name' => $this->input->post('name'), 
                 
                	);
					$query = $this->generalmodel->updaterecord('pipelinstage',$data,'pstage_id='.$id);
					
					if($query>0){
						$userid = $this->userdata['user_id'];

				        if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
				        	
				        	$query = 'SELECT m.deal_title,c.contact_person,b.business_name,m.deal_value,p.pstage_name,m.deal_exp_closedate,m.deal_id,m.pstage_id,m.stagemodifydate,m.business_id,m.contact_id,m.user_id 
				        	FROM deal as m 
				        	LEFT JOIN user as u ON m.deal_createdby = u.user_id 
				        	LEFT JOIN business as b ON m.business_id = b.business_id 
				        	LEFT JOIN contact as c ON m.contact_id = c.contact_id 
				        	LEFT JOIN pipelinstage as p ON m.pstage_id = p.pstage_id 
				        	WHERE m.status!="2" AND m.user_id=0 AND (u.createdby = "'.$userid.'" OR u.user_id='.$userid.')';

				    	}else{
				    		$query ='SELECT m.deal_title,c.contact_person,b.business_name,m.deal_value,p.pstage_name,m.deal_exp_closedate,m.deal_id,m.pstage_id,m.stagemodifydate,m.business_id,m.contact_id,m.user_id 
				    		FROM deal as m 
				    		LEFT JOIN business as b ON m.business_id = b.business_id 
				    		LEFT JOIN contact as c ON m.contact_id = c.contact_id 
				    		LEFT JOIN pipelinstage as p ON m.pstage_id = p.pstage_id 
				    		WHERE m.status!="2" AND m.user_id=0 AND m.deal_createdby="'.$userid.'"';
				    	}

				    	$data['data'] = $this->db->query($query)->result_array();
						
				    	$data['stages'] = $this->lead_model->get_my_stages();


                		$view = $this->load->view('testpipe', $data,true);
					 	$return = array('success'=>true,'msg'=>'Name Changed Successfully','view'=>$view);
	                }else{
	                    $return = array('success'=>false,'msg'=>'something went wrong');
	                }

	            }else{
	                $return = array('success'=>false,'msg'=>validation_errors());
	            }

	            echo json_encode($return);
			}

		public function piplinereport()
		{
			$data['meta_title'] = "Pipeline Report";
			$this->load->view('pipelinereport', $data);
		}

		public function ajaxpreport()
		{

			$userid =$this->userdata['user_id'];
	        $createdby =$this->userdata['createdby'];
	        $datatables = new Datatables(new CodeigniterAdapter);
	        if($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10 )
				$datatables->query('SELECT m.deal_title,c.contact_person,b.business_name,m.deal_value,p.pstage_name,m.stagemodifydate,m.deal_exp_closedate FROM deal as m LEFT JOIN business as b ON m.business_id=b.business_id LEFT JOIN contact as c ON m.contact_id=c.contact_id LEFT JOIN pipelinstage as p ON m.pstage_id=p.pstage_id WHERE m.status !="2"');
			else if($this->userdata['dept_id']==9 || $this->userdata['dept_id']==11 )
					$datatables->query('SELECT m.deal_title,c.contact_person,b.business_name,m.deal_value,p.pstage_name,m.stagemodifydate,m.deal_exp_closedate FROM deal as m LEFT JOIN business as b ON m.business_id=b.business_id LEFT JOIN contact as c ON m.contact_id=c.contact_id LEFT JOIN pipelinstage as p ON m.pstage_id=p.pstage_id WHERE m.status !="2" and m.deal_createdby='.$userid.'');
			
			$datatables->edit('deal_value', function ($data) {
        					setlocale(LC_MONETARY,"en_US");
        			return  money_format("$%i", $data['deal_value']).' USD';
        		});

			$datatables->edit('stagemodifydate', function ($data) {
	        			$createdate= strtotime($data['stagemodifydate']);
						$today = strtotime(date('Y-m-d H:i:s'));
						$age= ceil((($today-$createdate)/3600)/24);
						return $age.' Day(s)';
	        		});
	                  // // edit 'id' column
	               
	                

	        echo $datatables->generate();
		}


		public function export()
    {
        set_time_limit(0);
        ini_set('memory_limit', -1);
        $userid =$this->userdata['user_id'];
        $perms=explode(",",$this->userdata['upermission']);

       $q = $this->input->post('search');
        if($q!=""){

	    	if($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10)
				$items = 'SELECT m.deal_title,c.contact_person,b.business_name,m.deal_value,p.pstage_name,m.stagemodifydate,m.deal_exp_closedate FROM deal as m LEFT JOIN business as b ON m.business_id=b.business_id LEFT JOIN contact as c ON m.contact_id=c.contact_id LEFT JOIN pipelinstage as p ON m.pstage_id=p.pstage_id WHERE m.status !="2" AND (m.deal_title LIKE "%'.$q.'%" OR c.contact_person LIKE "%'.$q.'%" OR b.business_name LIKE "%'.$q.'%" OR m.deal_value LIKE "%'.$q.'%" OR p.pstage_name LIKE "%'.$q.'%")';
			else if($this->userdata['dept_id']==9 || $this->userdata['dept_id']==11)
					$items = 'SELECT m.deal_title,c.contact_person,b.business_name,m.deal_value,p.pstage_name,m.stagemodifydate,m.deal_exp_closedate FROM deal as m LEFT JOIN business as b ON m.business_id=b.business_id LEFT JOIN contact as c ON m.contact_id=c.contact_id LEFT JOIN pipelinstage as p ON m.pstage_id=p.pstage_id WHERE m.status !="2" and m.deal_createdby='.$userid.' AND (m.deal_title LIKE "%'.$q.'%" OR c.contact_person LIKE "%'.$q.'%" OR b.business_name LIKE "%'.$q.'%" OR m.deal_value LIKE "%'.$q.'%" OR p.pstage_name LIKE "%'.$q.'%")';
        }else{

	       if($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10)
					$items = 'SELECT m.deal_title,c.contact_person,b.business_name,m.deal_value,p.pstage_name,m.stagemodifydate,m.deal_exp_closedate FROM deal as m LEFT JOIN business as b ON m.business_id=b.business_id LEFT JOIN contact as c ON m.contact_id=c.contact_id LEFT JOIN pipelinstage as p ON m.pstage_id=p.pstage_id WHERE m.status !="2"';
				else if($this->userdata['dept_id']==9 || $this->userdata['dept_id']==11)
						$items = 'SELECT m.deal_title,c.contact_person,b.business_name,m.deal_value,p.pstage_name,m.stagemodifydate,m.deal_exp_closedate FROM deal as m LEFT JOIN business as b ON m.business_id=b.business_id LEFT JOIN contact as c ON m.contact_id=c.contact_id LEFT JOIN pipelinstage as p ON m.pstage_id=p.pstage_id WHERE m.status !="2" and m.deal_createdby='.$userid.'';
        }

        $query=$this->db->query($items);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'Pipline Report.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser
        $cells = [
               
                WriterEntityFactory::createCell('Deal Title'),
                WriterEntityFactory::createCell('Person'),
                WriterEntityFactory::createCell('Business'),
                WriterEntityFactory::createCell('Deal Value'),
                WriterEntityFactory::createCell('Stage'),
                WriterEntityFactory::createCell('Age'),
                
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
     

        foreach ($obj as $row) {
        	$createdate= strtotime($row['stagemodifydate']);
						$today = strtotime(date('Y-m-d H:i:s'));
						$age= ceil((($today-$createdate)/3600)/24);
						$ages = $age.' Day(s)';

        		 setlocale(LC_MONETARY,"en_US");
        		$value =  money_format("$%i", $row['deal_value']).' USD';
        			

            $data[0] = $row['deal_title'];
            $data[1] = $row['contact_person'];
            $data[2] = $row['business_name'];
            $data[3] = $value;
            $data[4] = $row['pstage_name'];
            $data[5] = $ages;
           
            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
        }
        $writer->close();
    }

}
?>