<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH. 'third_party/Spout/Autoloader/autoload.php';
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;

use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;
class Business_review extends MY_Controller {

   public function __construct(){
        parent::__construct();
        $this->userdata = $this->session->userdata('userdata');
    }
    
    public function licbusiness_review($id='')
    {
        $data['id'] = $id;
        $data['meta_title'] = "Business Review";
        $this->load->view('viewlicbusiness',$data);
    }

	public function iabusiness_review($id='')
    {
        $data['id']= $id;
        $data['meta_title'] = "Business Review";
        $this->load->view('viewiabusiness',$data);
    }
    public function addnew()
    {
        $data['meta_title'] = "Add Business Review";
        $this->load->view('addnew', $data);
    }

    public function ajaxlic($id='')
    {
        $userid =$this->userdata['user_id'];
        $perms=explode(",",$this->userdata['upermission']);
        $createdby=$this->userdata['createdby'];
        
    	$datatables = new Datatables(new CodeigniterAdapter);
		
        if(!empty($this->session->userdata['licenseeid'])){
            $id=$this->session->userdata['licenseeid'];
            $datatables->query('SELECT m.busrev_title,m.busrev_duedate,m.busrev_status,m.busrev_complete,m.busrev_id,m.lic_id,m.busrev_type,licensee.user_id FROM licbusinessreview as m,licensee where licensee.lic_id=m.lic_id and licensee.user_id='.$id.'');
        }
		
		
		$datatables->edit('busrev_duedate', function ($data) {
                    $localtimzone =$this->userdata['timezone'];
                    $busrev_duedate = gmdate_to_mydate($data['busrev_duedate'],$localtimzone);
        			return date('m/d/Y',strtotime($busrev_duedate));
        		});
		$datatables->edit('busrev_complete', function ($data) {
                    if($data['busrev_complete']=="0000-00-00 00:00:00"){
                        return '-';
                    }else{
                        $localtimzone =$this->userdata['timezone'];
                        $busrev_complete = gmdate_to_mydate($data['busrev_complete'],$localtimzone);
            			return date('m/d/Y',strtotime($busrev_complete));

                    }
        		});
                  // // edit 'id' column
                $datatables->edit('busrev_id', function($data) use($perms){

                    $menu='';
                    if(in_array('BR_VD',$perms)){
                        $menu.='<li>
                        <a href="'.site_url().'business-review/licbusiness-detail/'.encoding($data['busrev_id']).'">
                            <span class="glyphicon glyphicon-eye-open"></span> View
                        </a>
                        </li>';
                    }
                    if(in_array('BR_E',$perms)){
                        
                        if($data['busrev_status']=='Completed'){
                            if($this->userdata['dept_id']==2){
                                $menu.='<li>
                                <a href="'.site_url().'business-review/editlicbusiness/'.encoding($data['busrev_id']).'">
                                    <span class="glyphicon glyphicon-pencil"></span> Edit
                                </a>
                                </li>';
                            }
                        }else{
                            $menu.='<li>
                                <a href="'.site_url().'business-review/editlicbusiness/'.encoding($data['busrev_id']).'">
                                    <span class="glyphicon glyphicon-pencil"></span> Edit
                                </a>
                                </li>';
                        }
                    }

                $doc = 'SELECT doc FROM document_template WHERE user_role="2" AND temp_title="'.$data["busrev_type"].'"';
                $query=$this->db->query($doc);
                $obj= $query->row_array();

                    if(in_array('BR_D',$perms)){
                        $menu.='<li>
                            <a href="'.base_url().'uploads/doc_template/'.$obj['doc'].'">
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


    public function licbusiness_detail($id)
    {
        $id = decoding($id);
    	$data['lic']= $this->generalmodel->getSingleRowById('licbusinessreview', 'busrev_id', $id, $returnType = 'array');
    	$data['doc'] = $this->generalmodel->getparticularData("doc",'document_template',"`user_role`='2'  AND `temp_title`='".$data['lic']['busrev_type']."'","row_array");
        $data['meta_title'] = "View Business Review";
        $this->load->view('licbusiness_detail', $data);
    }

    public function editlicbusiness($id)
    {
        $id = decoding($id);
    	if(!empty($this->input->post()) && $this->input->is_ajax_request()){

			if($this->form_validation->run('edit_licbusiness')){

				$id = $this->input->post('id');
				// $busrev_title = $this->input->post('busrev_title');
				// $busrev_duedate = $this->input->post('busrev_duedate');
				$userData['busrev_status'] = $this->input->post('busrev_status');

				if($this->input->post('busrev_status')=="Completed")
				{
					$userData['busrev_complete'] = date('Y-m-d H:i:s');

				}

				// $busrev_type = $this->input->post('busrev_type');
				if(!empty($_FILES['busrev_file']['name'])){
					$fileData = $this->uploadDoc('busrev_file','./uploads/lic_business',array('pdf'));
					
					if(empty($fileData['error'])){
						$filename = $fileData['file_name'];
					}else{
						$return = array('success'=>false,'msg'=>$fileData['error']);
						echo json_encode($return); exit;
					}
				}else{
					$filename = '';
				}


				$userData['busrev_file'] = $filename;

				
				$query = $this->generalmodel->updaterecord('licbusinessreview',$userData,'busrev_id='.$id);
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
    	$data['lic']= $this->generalmodel->getSingleRowById('licbusinessreview', 'busrev_id', $id, $returnType = 'array');
        $data['meta_title'] = "Edit Business Review";
        $this->load->view('editlicbusiness', $data);
     }
    }

    public function ajaxia($id='')
    {
        $userid =$this->userdata['user_id'];
        $perms=explode(",",$this->userdata['upermission']);
        $createdby=$this->userdata['createdby'];


    	$datatables = new Datatables(new CodeigniterAdapter);

        //echo "<pre>"; print_r($_SESSION); exit;
        if(!empty($this->session->userdata['iaid'])){
            $id=$this->session->userdata['iaid'];
            //$datatables->query('SELECT m.busrev_title,m.busrev_duedate,m.busrev_status,m.busrev_complete,m.busrev_id,m.lic_id,m.busrev_type,licensee.user_id FROM licbusinessreview as m,licensee where licensee.lic_id=m.lic_id and licensee.user_id='.$id.'');
            $datatables->query('SELECT m.busrev_title,m.busrev_duedate,m.busrev_status,m.busrev_complete,m.busrev_id,m.ia_id,m.busrev_type,indassociation.user_id FROM iabusinessreview as m,indassociation where indassociation.ia_id=m.ia_id and indassociation.user_id='.$id);
        }

		
		$datatables->edit('busrev_duedate', function ($data) {
                    $localtimzone =$this->userdata['timezone'];
                    $busrev_duedate = gmdate_to_mydate($data['busrev_duedate'],$localtimzone);
        			return date('m/d/Y',strtotime($busrev_duedate));
        		});
		$datatables->edit('busrev_complete', function ($data) {
                    if($data['busrev_complete']=="0000-00-00 00:00:00"){
                        return '-';
                    }else{
                        $localtimzone =$this->userdata['timezone'];
                        $busrev_complete = gmdate_to_mydate($data['busrev_complete'],$localtimzone);
                        return date('m/d/Y',strtotime($busrev_complete));

                    }
        		});
                  // // edit 'id' column
                $datatables->edit('busrev_id', function($data) use($perms){

                    $menu='';
                    if(in_array('IA_BR_VD',$perms)){
                        $menu.='<li>
                        <a href="'.site_url().'business-review/iabusiness-detail/'.encoding($data['busrev_id']).'">
                            <span class="glyphicon glyphicon-eye-open"></span> View
                        </a>
                        </li>';
                    }
                    if(in_array('IA_BR_E',$perms)){
                        if($data['busrev_status']=='Completed'){
                            if($this->userdata['dept_id']==2){
                                $menu.='<li>
                                    <a href="'.site_url().'business-review/editiabusiness/'.encoding($data['busrev_id']).'">
                                        <span class="glyphicon glyphicon-pencil"></span> Edit
                                    </a>
                                    </li>';
                            }
                        }else{
                           $menu.='<li>
                        <a href="'.site_url().'business-review/editiabusiness/'.encoding($data['busrev_id']).'">
                            <span class="glyphicon glyphicon-pencil"></span> Edit
                        </a>
                        </li>';
                        }
                        
                    }

                $doc = 'SELECT doc FROM document_template WHERE user_role="2" AND temp_title="'.$data["busrev_type"].'"';
                $query=$this->db->query($doc);
                $obj= $query->row_array();

                    if(in_array('IA_BR_D',$perms)){
                        $menu.='<li>
                            <a href="'.base_url().'uploads/doc_template/'.$obj['doc'].'">
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

    public function editiabusiness($id)
    {
        $id = decoding($id);
    	if(!empty($this->input->post()) && $this->input->is_ajax_request()){

			if($this->form_validation->run('edit_iabusiness')){

				$id = $this->input->post('id');
				// $busrev_title = $this->input->post('busrev_title');
				// $busrev_duedate = $this->input->post('busrev_duedate');
				$userData['busrev_status'] = $this->input->post('busrev_status');

				if($this->input->post('busrev_status')=="Completed")
				{
					$userData['busrev_complete'] = date('Y-m-d H:i:s');

				}
				// $busrev_type = $this->input->post('busrev_type');
				if(!empty($_FILES['busrev_file']['name'])){
					$fileData = $this->uploadDoc('busrev_file','./uploads/ia_business',array('pdf'));
					
					if(empty($fileData['error'])){
						$filename = $fileData['file_name'];
					}else{
						$return = array('success'=>false,'msg'=>$fileData['error']);
						echo json_encode($return); exit;
					}
				}else{
					$filename = '';
				}

				$userData['busrev_file'] = $filename;

				
				$query = $this->generalmodel->updaterecord('iabusinessreview',$userData,'busrev_id='.$id);
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
    	$data['lic']= $this->generalmodel->getSingleRowById('iabusinessreview', 'busrev_id', $id, $returnType = 'array');
        $data['meta_title'] = "Edit Business Review";
        $this->load->view('editiabusiness', $data);
     }
    }


    public function iabusiness_detail($id)
    {
        $id = decoding($id);
    	$data['ia']= $this->generalmodel->getSingleRowById('iabusinessreview', 'busrev_id', $id, $returnType = 'array');
    	$data['doc'] = $this->generalmodel->getparticularData("doc",'document_template',"`user_role`='3'  AND `temp_title`='".$data['ia']['busrev_type']."'","row_array");
        $data['meta_title'] = "View Business Review";
        $this->load->view('iabusiness_detail', $data);
    }

    public function addnotelic(){
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
                	'app_activity_createat' => 'LBR', 
                	// 'app_activity_createat' => 'lic-'.$this->input->post('lic_id'), 
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

	public function viewnotelic()
    {
    	$this->load->helper('text');
        $datatables = new Datatables(new CodeigniterAdapter);
        $datatables->query('SELECT m.app_activity_title,b.firstname,b.lastname,m.app_activity_des,m.app_activity_createdate,m.app_activity_id FROM app_activity as m LEFT JOIN user as b ON m.app_activity_createdby = b.user_id WHERE m.app_activity_createat ="LBR" ORDER BY m.app_activity_createdate DESC');
     	 $datatables->edit('app_activity_des', function ($data) {
     	 	$desc = word_limiter($data['app_activity_des'], 10);
     	 	// return $desc.'......<a href="#addDesc" data-toggle="modal" id="addDesc">read more</a>';
     	 	return $desc.'<a class="addDesc" data-id="desc" value="'.$data['app_activity_des'].'"><span class="badge badge-pill badge-secondary">Read More</span></a>';
     	 });
     	 $datatables->edit('app_activity_createdate', function ($data) {
        			return date('m/d/Y',strtotime($data['app_activity_createdate']));
        		});
        echo $datatables->generate();
    }

    public function addnoteia(){
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
                	'app_activity_createat' => 'IBR', 
                	// 'app_activity_createat' => 'lic-'.$this->input->post('lic_id'), 
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

	public function viewnoteia()
    {
    	$this->load->helper('text');
        $datatables = new Datatables(new CodeigniterAdapter);
        $datatables->query('SELECT m.app_activity_title,b.firstname,b.lastname,m.app_activity_des,m.app_activity_createdate,m.app_activity_id FROM app_activity as m LEFT JOIN user as b ON m.app_activity_createdby = b.user_id WHERE m.app_activity_createat ="IBR" ORDER BY m.app_activity_createdate DESC');
     	 $datatables->edit('app_activity_des', function ($data) {
     	 	$desc = word_limiter($data['app_activity_des'], 10);
     	 	// return $desc.'......<a href="#addDesc" data-toggle="modal" id="addDesc">read more</a>';
     	 	return $desc.'<a class="addDesc" data-id="desc" value="'.$data['app_activity_des'].'"><span class="badge badge-pill badge-secondary">Read More</span></a>';
     	 });
     	 $datatables->edit('app_activity_createdate', function ($data) {
        			return date('m/d/Y',strtotime($data['app_activity_createdate']));
        		});
        echo $datatables->generate();
    }

     public function exportia()
    {
        set_time_limit(0);
        ini_set('memory_limit', -1);
        $userid =$this->userdata['user_id'];
        $perms=explode(",",$this->userdata['upermission']);
        $q = $this->input->post('search');
        
        if($q!=''){
            $items = 'SELECT m.busrev_title,m.busrev_duedate,m.busrev_status,m.busrev_complete,m.busrev_id,m.ia_id,m.busrev_type FROM iabusinessreview as m WHERE (m.busrev_title LIKE "%'.$q.'%" OR m.busrev_duedate LIKE "%'.$q.'%" OR m.busrev_status "%'.$q.'%" OR m.busrev_complete "%'.$q.'%")';

        }else{

            $items = 'SELECT m.busrev_title,m.busrev_duedate,m.busrev_status,m.busrev_complete,m.busrev_id,m.ia_id,m.busrev_type FROM iabusinessreview as m';            
        }
        
        $query=$this->db->query($items);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'Business_review.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser
       $cells = [
                WriterEntityFactory::createCell('Title'),
                WriterEntityFactory::createCell('Due Date'),
                WriterEntityFactory::createCell('Status'),
                WriterEntityFactory::createCell('Date Completed'),
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
      
        foreach ($obj as $row) {
            $localtimzone =$this->userdata['timezone'];
            $busrev_duedate = gmdate_to_mydate($row['busrev_duedate'],$localtimzone);
            $busrev_complete = gmdate_to_mydate($row['busrev_complete'],$localtimzone);
            $data[0] = $row['busrev_title'];
            $data[1] = $busrev_duedate;
            $data[2] = $row['busrev_status'];
            $data[3] = $busrev_complete;
            
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
        if($q!=''){
             if(!empty($this->session->userdata['licenseeid'])){
                $id=$this->session->userdata['licenseeid'];
                $items = 'SELECT m.busrev_title,m.busrev_duedate,m.busrev_status,m.busrev_complete,m.busrev_id,m.lic_id,m.busrev_type,licensee.user_id FROM licbusinessreview as m,licensee where licensee.lic_id=m.lic_id and licensee.user_id='.$id.' and (m.busrev_title LIKE "%'.$q.'%" OR m.busrev_duedate LIKE "%'.$q.'%" OR m.busrev_status "%'.$q.'%" OR m.busrev_complete "%'.$q.'%")';
            }
            // $items = 'SELECT m.busrev_title,m.busrev_duedate,m.busrev_status,m.busrev_complete,m.busrev_id,m.ia_id,m.busrev_type FROM licbusinessreview as m WHERE m.busrev_title LIKE "%'.$q.'%" OR m.busrev_duedate LIKE "%'.$q.'%" OR m.busrev_status "%'.$q.'%" OR m.busrev_complete "%'.$q.'%"';

        }else{
            if(!empty($this->session->userdata['licenseeid'])){
                $id=$this->session->userdata['licenseeid'];
               $items = 'SELECT m.busrev_title,m.busrev_duedate,m.busrev_status,m.busrev_complete,m.busrev_id,m.lic_id,m.busrev_type,licensee.user_id FROM licbusinessreview as m,licensee where licensee.lic_id=m.lic_id and licensee.user_id='.$id.'';
            }
            // $items = 'SELECT m.busrev_title,m.busrev_duedate,m.busrev_status,m.busrev_complete,m.busrev_id,m.lic_id,m.busrev_type FROM licbusinessreview as m';            
               
        }
        
        $query=$this->db->query($items);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'Business_review.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser
       $cells = [
                WriterEntityFactory::createCell('Title'),
                WriterEntityFactory::createCell('Due Date'),
                WriterEntityFactory::createCell('Status'),
                WriterEntityFactory::createCell('Date Completed'),
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
      
        foreach ($obj as $row) {
            $localtimzone =$this->userdata['timezone'];
            $busrev_duedate = gmdate_to_mydate($row['busrev_duedate'],$localtimzone);
            $busrev_complete = gmdate_to_mydate($row['busrev_complete'],$localtimzone);
            $data[0] = $row['busrev_title'];
            $data[1] = $busrev_duedate;
            $data[2] = $row['busrev_status'];
            $data[3] = $busrev_complete;
            
            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
        }
        $writer->close();
    }

}
?>