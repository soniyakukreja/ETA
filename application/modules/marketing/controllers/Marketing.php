<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH. 'third_party/Spout/Autoloader/autoload.php';
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;

use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;
class Marketing extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->userdata = $this->session->userdata('userdata');
	}
	public function index()
	{
		
	}

	public function page_ads_form()
	{
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){

			if($this->form_validation->run('add_banner')){

				$createddate = $updatedate = date('Y-m-d h:i:s');
				$createdby = $this->userdata['user_id'];

				if(!empty($_FILES['ba_image']['name'])){
					$fileData = $this->uploadDoc('ba_image','./uploads/banner',array('jpg','jpeg','png','gif'));
					
					if(empty($fileData['error'])){
						$ba_image = $fileData['file_name'];
					}else{
						$return = array('success'=>false,'msg'=>$fileData['error']);
						echo json_encode($return); exit;
					}
				}else{
					$return = array('success'=>false,'msg'=>'Please Upload Banner Image');
					echo json_encode($return); exit;
				}

				$data['ba_name'] = $this->input->post('ba_name');
				$data['ba_image'] = $ba_image;
				$data['ba_roles_id'] = $this->input->post('ba_roles_id');
				$data['ba_link'] = $this->input->post('ba_link');
				$data['ba_status'] = $this->input->post('ba_status');
				$data['ba_target'] = $this->input->post('target');
				$data['ba_createdate'] = $createddate;
				$data['ba_createdby'] = $createdby;
				$data['ba_publish_date'] = get_ymd_format($this->input->post('publish_date'));
				$data['ba_bannertype'] = $this->input->post('ba_bannertype');
				$data['ba_platform'] = $this->input->ip_address();
				$data['ba_browser'] = $this->agent->browser();
				$data['ba_ipaddress'] = $this->agent->platform();

				$query = $this->generalmodel->add('banner_ads',$data);
				if(!empty($query)){

					// if(!empty($ba_image)){
					// 	$src ='./tmp_upload/'.$ba_image;
					// 	$destination= './uploads/banner/'.$ba_image;
					// 	rename($src, $destination);		
					// }

					$return = array('success'=>true,'msg'=>'Banner added successfully');
				}else{
					$return = array('success'=>false,'msg'=>'something went wrong');
				}
			}else{
				$return = array('success'=>false,'msg'=>validation_errors());
			}
			echo json_encode($return); exit;
		}else{
			$data['meta_title'] = "Add Banner Manager";
			$this->load->view('marketing/page_ads_form',$data);
		}
	}

	public function page_manage_form()
	{

		if(!empty($this->input->post()) && $this->input->is_ajax_request()){

			if($this->form_validation->run('add_page')){

				$slug = $this->input->post('pb_slug');
				$slug = str_replace(" ", "-", $slug);

				$slug_duplicay = $this->generalmodel->getparticularData('pb_slug','pagebanner','pb_slug="'.$slug.'"',"row_array");
				if(!empty($slug_duplicay)){
					$return = array('success'=>false,'msg'=>'Page Slug already exist','err_field'=>'slug_err');
					echo json_encode($return); exit;
				}



				$createddate = $updatedate = date('Y-m-d h:i:s');
				$createdby = $this->userdata['user_id'];

				// $featureimage = $this->input->post('pb_featureimage_h');

				if(!empty($_FILES['pb_featureimage']['name'])){
					$fileData = $this->uploadDoc('pb_featureimage','./uploads/page_feature_img',array('jpg','jpeg','png','gif'));
					
					if(empty($fileData['error'])){
						$data['pb_featureimage'] = $fileData['file_name'];
					}else{
						$return = array('success'=>false,'msg'=>$fileData['error']);
						echo json_encode($return); exit;
					}
				}else{
					$return = array('success'=>false,'msg'=>'Please Upload Page Banner Image');
					echo json_encode($return); exit;
				}




				$data['pb_name'] = $this->input->post('pb_name');
				$data['pb_slug'] = $slug;
				$data['pb_role_id'] = $this->input->post('pb_role_id');
				$data['pb_status'] = $this->input->post('pb_status');
				// $data['pb_featureimage'] = $featureimage;
				$data['pb_description']  = $this->input->post('cta_desc');
				$data['pb_cta_label'] = $this->input->post('pb_cta_label');
				$data['pb_cta_text'] = $this->input->post('pb_cta_text');
				$data['pb_target'] = $this->input->post('target');
				// $data['pb_publishdate'] = get_ymd_format($this->input->post('pb_publishdate'));

				// $data['pb_cta_label'] = '';
				// $data['pb_cta_text'] = '';
				$data['pb_publishdate'] = '0000-00-00 00:00:00';

				$data['pb_createdate'] = $createddate;
				$data['pb_createdby'] = $createdby;
				$data['platform'] = $this->input->ip_address();
				$data['browser'] = $this->agent->browser();
				$data['ipaddress'] = $this->agent->platform();

				$query = $this->generalmodel->add('pagebanner',$data);
				if(!empty($query)){

					// if(!empty($featureimage)){
					// 	$src ='./tmp_upload/'.$featureimage;
					// 	$destination= './uploads/page_feature_img/'.$featureimage;
					// 	rename($src, $destination);		
					// }

					$return = array('success'=>true,'msg'=>'Page addedd successfully');
				}else{
					$return = array('success'=>false,'msg'=>'something went wrong');
				}
			}else{
				$return = array('success'=>false,'msg'=>validation_errors());
			}
			echo json_encode($return); exit;
		}else{
			$data['meta_title'] = "Add Page Manager";
			$this->load->view('marketing/page_manage_form',$data);
		}
	}

	
	public function banner()
	{
		$data['meta_title'] = "Banner Manager";
		$this->load->view('banner',$data);
	}


	public function viewbanner()
    {
    	$userid =$this->userdata['user_id'];
        $perms=explode(",",$this->userdata['upermission']);
        $datatables = new Datatables(new CodeigniterAdapter);
        $usertype = $this->input->post('user');

        if($this->userdata['urole_id']==1){
        	$datatables->query('SELECT m.ba_name,u.rolename,m.ba_status,m.ba_id FROM banner_ads as m LEFT JOIN user as b ON m.ba_createdby = b.user_id LEFT JOIN user_role as u ON m.ba_roles_id = u.urole_id WHERE m.ba_status!="2"');
        }
        else if($this->userdata['urole_id']==2){
        	$datatables->query('SELECT m.ba_name,u.rolename,m.ba_status,m.ba_id FROM banner_ads as m LEFT JOIN user as b ON m.ba_createdby = b.user_id LEFT JOIN user_role as u ON m.ba_roles_id = u.urole_id WHERE m.ba_status!="2" AND m.ba_roles_id="'.$this->userdata['urole_id'].'"');
        }
        else{
        	$datatables->query('SELECT m.ba_name,u.rolename,m.ba_status,m.ba_id FROM banner_ads as m LEFT JOIN user as b ON m.ba_createdby = b.user_id LEFT JOIN user_role as u ON m.ba_roles_id = u.urole_id WHERE m.ba_status!="2" AND m.ba_createdby="'.$userid.'"');
        }

        /*if($usertype)
        {
        	 if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
        	$datatables->query('SELECT m.ba_name,u.rolename,m.ba_status,m.ba_id FROM banner_ads as m LEFT JOIN user as b ON m.ba_createdby = b.user_id LEFT JOIN user_role as u ON m.ba_roles_id = u.urole_id WHERE m.ba_status!="2" AND m.ba_roles_id="'.$usertype.'"');
	        }else{
	        	$datatables->query('SELECT m.ba_name,u.rolename,m.ba_status,m.ba_id FROM banner_ads as m LEFT JOIN user as b ON m.ba_createdby = b.user_id LEFT JOIN user_role as u ON m.ba_roles_id = u.urole_id WHERE m.ba_status!="2" AND m.ba_createdby="'.$userid.'" AND m.ba_roles_id="'.$usertype.'"');
			}
        }else{

	        if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
	        	$datatables->query('SELECT m.ba_name,u.rolename,m.ba_status,m.ba_id FROM banner_ads as m LEFT JOIN user as b ON m.ba_createdby = b.user_id LEFT JOIN user_role as u ON m.ba_roles_id = u.urole_id WHERE m.ba_status!="2"');
	        }else{
	        	$datatables->query('SELECT m.ba_name,u.rolename,m.ba_status,m.ba_id FROM banner_ads as m LEFT JOIN user as b ON m.ba_createdby = b.user_id LEFT JOIN user_role as u ON m.ba_roles_id = u.urole_id WHERE m.ba_status!="2" AND m.ba_createdby="'.$userid.'"');
			}
        }*/

        	$datatables->edit('ba_status', function ($data) {
        		if($data['ba_status']==1){
        			$st = "Published";
        		}else{
        			$st = "Draft";
        		}
        		return $st;
        	});

        	
             $datatables->edit('ba_id', function($data) use($perms){
                    
                    $menu='';

                    if(in_array('BN_VD',$perms)){
                        $menu.='<li>
                        <a href="'.site_url('marketing/banner-detail/').encoding($data['ba_id']).'">
                            <span class="glyphicon glyphicon-eye-open"></span> View
                        </a>
                    	</li>';
                	}

                	if(in_array('BN_E',$perms)){
                        $menu.='<li>
                        <a href="'.site_url('marketing/editbanner/').encoding($data['ba_id']).'">
                            <span class="glyphicon glyphicon-pencil"></span> Edit
                        </a>
	                    </li>';
	                }

	                if(in_array('BN_D',$perms)){
                        $menu.='<li>
                        <a  href="javascript:void(0)" link="'.site_url('marketing/deletebanner/').encoding($data['ba_id']).'" class="deleteEntry">
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
    
    public function filter_banner(){
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){

	    	$userid =$this->userdata['user_id'];
	        $perms=explode(",",$this->userdata['upermission']);
	        $datatables = new Datatables(new CodeigniterAdapter);
	        $usertype = $this->input->post('user');
	        
	        $where = "m.ba_status!='2'";

	        if(!empty($usertype)){
	        	$where .= " AND m.ba_roles_id='".$usertype."'";
	        }

	        $query = 'SELECT m.ba_name,u.rolename,m.ba_status,m.ba_id FROM banner_ads as m LEFT JOIN user as b ON m.ba_createdby = b.user_id LEFT JOIN user_role as u ON m.ba_roles_id = u.urole_id WHERE '.$where;
	        $datatables->query($query);

    	$datatables->edit('ba_status', function ($data) {
    		if($data['ba_status']==1){
    			$st = "Published";
    		}else{
    			$st = "Draft";
    		}
    		return $st;
    	});

        	
        $datatables->edit('ba_id', function($data) use($perms){
                    
            $menu='';

            if(in_array('BN_VD',$perms)){
                $menu.='<li>
                <a href="'.site_url('marketing/banner-detail/').encoding($data['ba_id']).'">
                    <span class="glyphicon glyphicon-eye-open"></span> View
                </a>
            	</li>';
        	}

        	if(in_array('BN_E',$perms)){
                $menu.='<li>
                <a href="'.site_url('marketing/editbanner/').encoding($data['ba_id']).'">
                    <span class="glyphicon glyphicon-pencil"></span> Edit
                </a>
                </li>';
            }

            if(in_array('BN_D',$perms)){
                $menu.='<li>
                <a  href="javascript:void(0)" link="'.site_url('marketing/deletebanner/').encoding($data['ba_id']).'" class="deleteEntry">
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
     
		}
        echo $datatables->generate();
    
    }
    public function banner_detail($id)
    {	
    	$id = decoding($id);
        $select = array('m.ba_id','m.ba_name','b.rolename','m.ba_link','m.ba_status','m.ba_bannertype','m.ba_image','m.ba_publish_date','m.ba_visibility');
        $data['ba']=$this->generalmodel->getsingleJoinData($select,'banner_ads as m','user_role as b','m.ba_roles_id= b.urole_id','m.ba_id='.$id);
       $data['meta_title'] = "View Banner Manager";
        $this->load->view('marketing/banner_detail',$data);
    }

    public function editbanner($id)
	{	
		$id = decoding($id);
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){

			if($this->form_validation->run('edit_banner')){

				
				// $createdby = $this->userdata['user_id'];
				$ba_image = $this->input->post('ba_image_h');

				if (!empty($ba_image)) {
					$data['ba_image'] = $ba_image;
				}else if(!empty($_FILES['ba_image']['name'])){
					$fileData = $this->uploadDoc('ba_image','./uploads/banner',array('jpg','jpeg','png','gif'));
					
					if(empty($fileData['error'])){
						$data['ba_image'] = $fileData['file_name'];
					}else{
						$return = array('success'=>false,'msg'=>$fileData['error']);
						echo json_encode($return); exit;
					}
				}

				$ba_id = $this->input->post('ba_id');
				$data['ba_name'] = $this->input->post('ba_name');
				//$data['ba_roles_id'] = $this->input->post('ba_roles_id');
				$data['ba_link'] = $this->input->post('ba_link');
				$data['ba_status'] = $this->input->post('ba_status');
				$data['ba_target'] = $this->input->post('target');
				// $data['ba_createdby'] = $createdby;
				$data['ba_publish_date'] = get_ymd_format($this->input->post('publish_date'));
				$data['ba_bannertype'] = $this->input->post('ba_bannertype');
				// $data['ba_platform'] = $this->input->ip_address();
				// $data['ba_browser'] = $this->agent->browser();
				// $data['ba_ipaddress'] = $this->agent->platform();

				if($this->input->post('ba_visibility')==1)
				{
					$ba = $this->generalmodel->getparticularData('ba_id,ba_bannertype,ba_roles_id','banner_ads','ba_id='.$id,$returnType="row_array");

					$this->generalmodel->updaterecord('banner_ads',array('ba_visibility'=>0),array('ba_id!='=>$ba['ba_id'],'ba_bannertype'=>$ba['ba_bannertype'],'ba_roles_id'=>$ba['ba_roles_id']));

					$data['ba_visibility'] = $this->input->post('ba_visibility');
				}else
				{
					$data['ba_visibility'] = $this->input->post('ba_visibility');
				}

				$query = $this->generalmodel->updaterecord('banner_ads',$data,'ba_id='.$ba_id);
				if(!empty($query)){

					if(!empty($ba_image)){
						$src ='./tmp_upload/'.$ba_image;
						$destination= './uploads/banner/'.$ba_image;
						rename($src, $destination);		
					}

					$return = array('success'=>true,'msg'=>'Banner Updated successfully');
				}else{
					$return = array('success'=>false,'msg'=>'something went wrong');
				}
			}else{
				$return = array('success'=>false,'msg'=>validation_errors());
			}
			echo json_encode($return); exit;
		}else{
			$select = array('m.ba_id','m.ba_name','m.ba_roles_id','m.ba_link','m.ba_status','m.ba_bannertype','m.ba_image','m.ba_publish_date','m.ba_target');
       		//$data['ba']=$this->generalmodel->getsingleJoinData($select,'banner_ads as m','user as b','m.ba_createdby = b.user_id','m.ba_id='.$id);

			$tables[0]['table'] = 'user as b';
			$tables[0]['on'] = 'm.ba_createdby = b.user_id';
			$data['ba']=$this->generalmodel->getfrommultipletables($select,"banner_ads as m", $tables,'m.ba_id='.$id,"","","","","row_array");		
			$data['meta_title'] = "Edit Banner Manager";
			$this->load->view('marketing/editbanner',$data);
		}
	}


    public function page_ads()
	{
		$data['meta_title'] = "Page Manager";
		$this->load->view('page_ads',$data);
	}


	public function viewpage()
    {
    	$userid =$this->userdata['user_id'];
    	$perms=explode(",",$this->userdata['upermission']);
        $datatables = new Datatables(new CodeigniterAdapter);

        if(!in_array('PG_D',$perms)){
	        if($this->userdata['urole_id']==1 ){
	        	$datatables->query('SELECT m.pb_name,m.pb_slug,b.rolename,m.pb_status,m.pb_id FROM pagebanner as m LEFT JOIN user_role as b ON m.pb_role_id = b.urole_id WHERE m.pb_status !="2"');	
	        }
	        else if($this->userdata['urole_id']==2 || $this->userdata['urole_id']==3){
	        	$datatables->query('SELECT m.pb_name,m.pb_slug,b.rolename,m.pb_status,m.pb_id FROM pagebanner as m LEFT JOIN user_role as b ON m.pb_role_id = b.urole_id WHERE m.pb_status !="2" and m.pb_role_id="'.$this->userdata['urole_id'].'"');	
	        }
	        else{
	        	$datatables->query('SELECT m.pb_name,m.pb_slug,b.rolename,m.pb_status,m.pb_id FROM pagebanner as m LEFT JOIN user_role as b ON m.pb_role_id = b.urole_id WHERE m.pb_status !="2" AND m.pb_createdby="'.$userid.'"');

	        }
	    }else{
	    	if($this->userdata['urole_id']==1 ){
	        	$datatables->query('SELECT m.pb_id as ids,m.pb_name,m.pb_slug,b.rolename,m.pb_status,m.pb_id FROM pagebanner as m LEFT JOIN user_role as b ON m.pb_role_id = b.urole_id WHERE m.pb_status !="2"');	
	        }
	        else if($this->userdata['urole_id']==2|| $this->userdata['urole_id']==3){
	        	$datatables->query('SELECT m.pb_id as ids,m.pb_name,m.pb_slug,b.rolename,m.pb_status,m.pb_id FROM pagebanner as m LEFT JOIN user_role as b ON m.pb_role_id = b.urole_id WHERE m.pb_status !="2" and m.pb_role_id="'.$this->userdata['urole_id'].'"');	
	        }
	        else{
	        	$datatables->query('SELECT m.pb_id as ids,m.pb_name,m.pb_slug,b.rolename,m.pb_status,m.pb_id FROM pagebanner as m LEFT JOIN user_role as b ON m.pb_role_id = b.urole_id WHERE m.pb_status !="2" AND m.pb_createdby="'.$userid.'"');

	        }
	    }
        if(in_array('PG_D',$perms)){
        $datatables->edit('ids', function ($data) {
                    return '<input type="checkbox" name="id[]" value="'.$data['pb_id'].'" class="case">';
                });
    	}
        	$datatables->edit('pb_status', function ($data) {
        		if($data['pb_status']==1){
        			$st = "Published";
        		}else{
        			$st = "Draft";
        		}
        		return $st;
        	});

             $datatables->edit('pb_id', function($data) use($perms){
                    $menu='';
                    if(in_array('PG_VD',$perms)){
                        $menu.='<li>
                        <a href="'.site_url('marketing/viewpagedetail/').$data['pb_slug'].'">
                            <span class="glyphicon glyphicon-eye-open"></span> View
                        </a>
	                    </li>';
	                }

	                if(in_array('PG_E',$perms)){
                        $menu.='<li>
                        <a href="'.site_url('marketing/editpage-banner/').encoding($data['pb_id']).'">
                            <span class="glyphicon glyphicon-pencil"></span> Edit
                        </a>
	                    </li>';
	                }

	                if(in_array('PG_D',$perms)){
                        $menu.='<li>
                        <a  href="javascript:void(0)" link="'.site_url('marketing/deletepage/').encoding($data['pb_id']).'" class="deleteEntry">
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

     public function page_detail($id)
    {
        $select = array('m.pb_id','m.pb_name','m.pb_slug','m.pb_role_id','m.pb_description','m.pb_status','m.pb_featureimage','m.pb_cta_label','m.pb_cta_text','m.pb_publishdate');
        $data['pa']=$this->generalmodel->getsingleJoinData($select,'pagebanner as m','user as b','m.pb_createdby = b.user_id','m.pb_id='.$id);
       $data['meta_title'] = "View Page Manager";
        $this->load->view('marketing/pagebanner_detail',$data);
    }


  public function editpage_banner($id)
	{
		$id = decoding($id);
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){

			if($this->form_validation->run('edit_page')){

				// $createddate = $updatedate = date('Y-m-d h:i:s');
				$createdby = $this->userdata['user_id'];

				// $featureimage = $this->input->post('pb_featureimage_h');
				// if (!empty($featureimage)) {
				// $data['pb_featureimage'] = $featureimage;
				// }

				if(!empty($_FILES['pb_featureimage']['name'])){
					$fileData = $this->uploadDoc('pb_featureimage','./uploads/page_feature_img',array('jpg','jpeg','png','gif'));
					
					if(empty($fileData['error'])){
						$data['pb_featureimage'] = $fileData['file_name'];
					}else{
						$return = array('success'=>false,'msg'=>$fileData['error']);
						echo json_encode($return); exit;
					}
				}

				$slug = $this->input->post('pb_slug');
				$slug = str_replace(" ", "-", $slug);

				$id = $this->input->post('pb_id');
				$data['pb_name'] = $this->input->post('pb_name');
				$data['pb_slug'] = $slug;
				$data['pb_role_id'] = $this->input->post('pb_role_id');
				$data['pb_status'] = $this->input->post('pb_status');
				$data['pb_description']  = $this->input->post('cta_desc');
				$data['pb_cta_label'] = $this->input->post('pb_cta_label');
				$data['pb_cta_text'] = $this->input->post('pb_cta_text');
				$data['pb_target'] = $this->input->post('pb_target');
				// $data['pb_publishdate'] = get_ymd_format($this->input->post('pb_publishdate'));
				
				// $data['pb_cta_label'] = '';
				// $data['pb_cta_text'] = '';
				$data['pb_publishdate'] = '0000-00-00 00:00:00';

				$data['pb_createdby'] = $createdby;
				$data['platform'] = $this->input->ip_address();
				$data['browser'] = $this->agent->browser();
				$data['ipaddress'] = $this->agent->platform();

				$user = $this->generalmodel->getparticularData("pb_id",'pagebanner',"`pb_id`=$id","row_array");
				
				$querys = $this->generalmodel->getparticularData("pb_slug",'pagebanner',array('pb_slug'=>$data['pb_slug'],'pb_id!='=>$user['pb_id'],'pb_status!='=>2),"row_array");
				
				if(!empty($querys)){
					$return = array('success'=>false,'msg'=>"Slug is Already Exist!");
					echo json_encode($return); exit;					
				}

				$query = $this->generalmodel->updaterecord('pagebanner',$data,'pb_id='.$id);
				if(!empty($query)){

					if(!empty($featureimage)){
						$src ='./tmp_upload/'.$featureimage;
						$destination= './uploads/page_feature_img/'.$featureimage;
						rename($src, $destination);		
					}

					$return = array('success'=>true,'msg'=>'Page Updated successfully');
				}else{
					$return = array('success'=>false,'msg'=>'something went wrong');
				}
			}else{
				$return = array('success'=>false,'msg'=>validation_errors());
			}
			echo json_encode($return); exit;
		}else{
			$select = array('m.pb_id','m.pb_name','m.pb_slug','m.pb_role_id','m.pb_status','m.pb_featureimage','m.pb_cta_label','m.pb_description','m.pb_cta_text','m.pb_publishdate','m.pb_target');
       		$data['pa']=$this->generalmodel->getsingleJoinData($select,'pagebanner as m','user as b','m.pb_createdby = b.user_id','m.pb_id='.$id);
       		$data['meta_title'] = "Edit Page Manager";
			$this->load->view('marketing/editpage_banner',$data);
		}
	}

	public function deletebanner($id)
	{	
		$id = decoding($id);
		if ($this->input->is_ajax_request()) {
			$data = array('ba_status'=>'2');
			$this->generalmodel->updaterecord('banner_ads',$data,'ba_id='.$id);

			$return = array('success'=>true,'msg'=>'Entry Removed');
		}else{
			$return = array('success'=>false,'msg'=>'Internal Error');
		}
		echo json_encode($return);
	}

	public function deletepage($id)
	{	
		$id = decoding($id);
		if ($this->input->is_ajax_request()) {
			$data = array('pb_status'=>'2');
			$this->generalmodel->updaterecord('pagebanner',$data,'pb_id='.$id);

			$return = array('success'=>true,'msg'=>'Entry Removed');
		}else{
			$return = array('success'=>false,'msg'=>'Internal Error');
		}
		echo json_encode($return);
	}

	public function viewpagedetail($slug)
    {
        $select = array('m.pb_id','m.pb_name','m.pb_slug','m.pb_role_id','m.pb_description','m.pb_status','m.pb_featureimage','m.pb_cta_label','m.pb_cta_text','m.pb_publishdate','b.firstname','b.lastname','m.pb_createdate','m.pb_target');
        $data['pa']=$this->generalmodel->getsingleJoinData($select,'pagebanner as m','user as b','m.pb_createdby = b.user_id',array('pb_slug'=>$slug));
       $data['meta_title'] = "View Page Manager";
        $this->load->view('marketing/viewpage',$data);
    }

	public function bannerbyia($id='')
	{
		$data['id'] = $id;
		$data['meta_title'] = "Banner Manager";
		$this->load->view('bannerbyia',$data);
	}

	public function ajaxbanneria($id= '')
    {
    	$userid =$this->userdata['user_id'];
    	$perms=explode(",",$this->userdata['upermission']);	
        $datatables = new Datatables(new CodeigniterAdapter);

        if($id=='')
        {
        	if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
        	$datatables->query('SELECT m.ba_name,b.firstname,m.ba_status,m.ba_id FROM banner_ads as m LEFT JOIN user as b ON m.ba_createdby = b.user_id WHERE m.ba_status!="2" AND m.ba_roles_id="3"');
	        }else{
	        	$datatables->query('SELECT m.ba_name,b.firstname,m.ba_status,m.ba_id FROM banner_ads as m LEFT JOIN user as b ON m.ba_createdby = b.user_id WHERE m.ba_status!="2" AND m.ba_roles_id="3" AND m.ba_createdby="'.$userid.'"');
			}
        }else
        {
        	
        	$datatables->query('SELECT m.ba_name,b.firstname,m.ba_status,m.ba_id FROM banner_ads as m LEFT JOIN user as b ON m.ba_createdby = b.user_id WHERE m.ba_status!="2" AND m.ba_roles_id="3" AND m.ba_createdby="'.$id.'"');
		
        }
  //       if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
  //       	$datatables->query('SELECT m.ba_name,b.firstname,m.ba_status,m.ba_id FROM banner_ads as m LEFT JOIN user as b ON m.ba_createdby = b.user_id WHERE m.ba_status!="2" AND m.ba_roles_id="3"');
  //       }else{
  //       	$datatables->query('SELECT m.ba_name,b.firstname,m.ba_status,m.ba_id FROM banner_ads as m LEFT JOIN user as b ON m.ba_createdby = b.user_id WHERE m.ba_status!="2" AND m.ba_roles_id="3" AND m.ba_createdby="'.$userid.'"');
		// }
        	$datatables->edit('ba_status', function ($data) {
        		if($data['ba_status']==1){
        			$st = "Published";
        		}else{
        			$st = "Draft";
        		}
        		return $st;
        	});
             $datatables->edit('ba_id', function($data) use($perms){
                    
                    $menu='';

                    if(in_array('BN_VD',$perms)){
                        $menu.='<li>
                        <a href="'.site_url('marketing/banner-detail/').encoding($data['ba_id']).'">
                            <span class="glyphicon glyphicon-eye-open"></span> View
                        </a>
                    	</li>';
                	}

                	if(in_array('BN_E',$perms)){
                        $menu.='<li>
                        <a href="'.site_url('marketing/editbanner/').encoding($data['ba_id']).'">
                            <span class="glyphicon glyphicon-pencil"></span> Edit
                        </a>
	                    </li>';
	                }

	                if(in_array('BN_D',$perms)){
                        $menu.='<li>
                        <a  href="javascript:void(0)" link="'.site_url('marketing/deletebanner/').encoding($data['ba_id']).'" class="deleteEntry">
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

    public function bannerbylic($id='')
	{
		$data['id'] = $id;
		$data['meta_title'] = "Banner Manager";
		$this->load->view('bannerbylic',$data);
	}

    public function ajaxbannerbylic($id='')
    {
    	$userid =$this->userdata['user_id'];	
    	$perms=explode(",",$this->userdata['upermission']);
        $datatables = new Datatables(new CodeigniterAdapter);

        if($id=='')
        {
        	$datatables->query('SELECT m.ba_name,b.firstname,m.ba_status,m.ba_id FROM banner_ads as m LEFT JOIN user as b ON m.ba_createdby = b.user_id WHERE m.ba_status!="2" AND m.ba_roles_id="2"');

        }else{

        	$datatables->query('SELECT m.ba_name,b.firstname,m.ba_status,m.ba_id FROM banner_ads as m LEFT JOIN user as b ON m.ba_createdby = b.user_id WHERE m.ba_status!="2" AND m.ba_roles_id="2" AND m.ba_createdby="'.$id.'"');
        }
        
		// if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
  //       	$datatables->query('SELECT m.ba_name,b.firstname,m.ba_status,m.ba_id FROM banner_ads as m LEFT JOIN user as b ON m.ba_createdby = b.user_id WHERE m.ba_status!="2" AND m.ba_roles_id="2"');
  //       }else{
  //       	$datatables->query('SELECT m.ba_name,b.firstname,m.ba_status,m.ba_id FROM banner_ads as m LEFT JOIN user as b ON m.ba_createdby = b.user_id WHERE m.ba_status!="2" AND m.ba_roles_id="2" AND m.ba_createdby="'.$userid.'"');
		// }
        	$datatables->edit('ba_status', function ($data) {
        		if($data['ba_status']==1){
        			$st = "Published";
        		}else{
        			$st = "Draft";
        		}
        		return $st;
        	});
             $datatables->edit('ba_id', function($data) use($perms){
                    
                    $menu='';

                    if(in_array('BN_VD',$perms)){
                        $menu.='<li>
                        <a href="'.site_url('marketing/banner-detail/').encoding($data['ba_id']).'">
                            <span class="glyphicon glyphicon-eye-open"></span> View
                        </a>
                    	</li>';
                	}

                	if(in_array('BN_E',$perms)){
                        $menu.='<li>
                        <a href="'.site_url('marketing/editbanner/').encoding($data['ba_id']).'">
                            <span class="glyphicon glyphicon-pencil"></span> Edit
                        </a>
	                    </li>';
	                }

	                if(in_array('BN_D',$perms)){
                        $menu.='<li>
                        <a  href="javascript:void(0)" link="'.site_url('marketing/deletebanner/').encoding($data['ba_id']).'" class="deleteEntry">
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

     public function pagebylic($id='')
	{
		$data['id'] = $id;
		$data['meta_title'] = "Page Manager";
		$this->load->view('pagebylic',$data);
	}

    public function ajaxpagelic($id='')
    {
    	$userid =$this->userdata['user_id'];
    	$perms=explode(",",$this->userdata['upermission']);
        $datatables = new Datatables(new CodeigniterAdapter);

        if($id==""){
        	if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
        	$datatables->query('SELECT m.pb_name,m.pb_slug,b.rolename,m.pb_status,m.pb_id FROM pagebanner as m LEFT JOIN user_role as b ON m.pb_role_id = b.urole_id WHERE m.pb_status !="2" AND m.pb_role_id="2"');
	        }else{
	        	$datatables->query('SELECT m.pb_name,m.pb_slug,b.rolename,m.pb_status,m.pb_id FROM pagebanner as m LEFT JOIN user_role as b ON m.pb_role_id = b.urole_id WHERE m.pb_status !="2" AND m.pb_role_id="2" AND m.pb_createdby="'.$userid.'"');

	        }
        }else{

	        	$datatables->query('SELECT m.pb_name,m.pb_slug,b.rolename,m.pb_status,m.pb_id FROM pagebanner as m LEFT JOIN user_role as b ON m.pb_role_id = b.urole_id WHERE m.pb_status !="2" AND m.pb_role_id="2" AND m.pb_createdby="'.$id.'"');

        }
        
        	$datatables->edit('pb_status', function ($data) {
        		if($data['pb_status']==1){
        			$st = "Active";
        		}else{
        			$st = "Inactive";
        		}
        		return $st;
        	});

            $datatables->edit('pb_id', function($data) use($perms){
                    $menu='';
                    if(in_array('PG_VD',$perms)){
                        $menu.='<li>
                        <a href="'.site_url('marketing/viewpagedetail/').$data['pb_slug'].'">
                            <span class="glyphicon glyphicon-eye-open"></span> View
                        </a>
	                    </li>';
	                }

	                if(in_array('PG_E',$perms)){
                        $menu.='<li>
                        <a href="'.site_url('marketing/editpage-banner/').encoding($data['pb_id']).'">
                            <span class="glyphicon glyphicon-pencil"></span> Edit
                        </a>
	                    </li>';
	                }

	                if(in_array('PG_D',$perms)){
                        $menu.='<li>
                        <a  href="javascript:void(0)" link="'.site_url('marketing/deletepage/').encoding($data['pb_id']).'" class="deleteEntry">
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

     public function pagebyia($id='')
	{
		$data['id'] = $id;
		$data['meta_title'] = "Page Manager";
		$this->load->view('pagebyia',$data);
	}

    public function ajaxpagebyia($id='')
    {
    	$userid =$this->userdata['user_id'];
    	$perms=explode(",",$this->userdata['upermission']);
        $datatables = new Datatables(new CodeigniterAdapter);

        if($id=='')
        {
        	if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
        	$datatables->query('SELECT m.pb_name,m.pb_slug,b.rolename,m.pb_status,m.pb_id FROM pagebanner as m LEFT JOIN user_role as b ON m.pb_role_id = b.urole_id WHERE m.pb_status !="2" AND m.pb_role_id="3"');
	        }else{
	        	$datatables->query('SELECT m.pb_name,m.pb_slug,b.rolename,m.pb_status,m.pb_id FROM pagebanner as m LEFT JOIN user_role as b ON m.pb_role_id = b.urole_id WHERE m.pb_status !="2" AND m.pb_role_id="3" AND m.pb_createdby="'.$userid.'"');

	        }
        }else{
	        	$datatables->query('SELECT m.pb_name,m.pb_slug,b.rolename,m.pb_status,m.pb_id FROM pagebanner as m LEFT JOIN user_role as b ON m.pb_role_id = b.urole_id WHERE m.pb_status !="2" AND m.pb_role_id="3" AND m.pb_createdby="'.$id.'"');

        }
        
        	$datatables->edit('pb_status', function ($data) {
        		if($data['pb_status']==1){
        			$st = "Active";
        		}else{
        			$st = "Inactive";
        		}
        		return $st;
        	});

             $datatables->edit('pb_id', function($data) use($perms){
                    $menu='';
                    if(in_array('PG_VD',$perms)){
                        $menu.='<li>
                        <a href="'.site_url('marketing/viewpagedetail/').$data['pb_slug'].'">
                            <span class="glyphicon glyphicon-eye-open"></span> View
                        </a>
	                    </li>';
	                }

	                if(in_array('PG_E',$perms)){
                        $menu.='<li>
                        <a href="'.site_url('marketing/editpage-banner/').encoding($data['pb_id']).'">
                            <span class="glyphicon glyphicon-pencil"></span> Edit
                        </a>
	                    </li>';
	                }

	                if(in_array('PG_D',$perms)){
                        $menu.='<li>
                        <a  href="javascript:void(0)" link="'.site_url('marketing/deletepage/').encoding($data['pb_id']).'" class="deleteEntry">
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

    public function exportbanner()
    {
    	//print_r($_POST); exit;
        set_time_limit(0);
        ini_set('memory_limit', -1);
        $userid =$this->userdata['user_id'];
        $perms=explode(",",$this->userdata['upermission']);
        $q = $this->input->post('search');

        $usertype = $this->input->post('user');
        
        $where = "m.ba_status!='2'";

        if(!empty($usertype)){
        	$where .= " AND m.ba_roles_id='".$usertype."'";
        }

        if($q!=''){

			if($this->userdata['urole_id']==1){
				$where .= " AND (m.ba_name LIKE "%'.$q.'%" OR b.firstname LIKE "%'.$q.'%" OR m.ba_status LIKE "%'.$q.'%")";
        	
        		$items ='SELECT m.ba_name,u.rolename,m.ba_status,m.ba_id FROM banner_ads as m LEFT JOIN user as b ON m.ba_createdby = b.user_id LEFT JOIN user_role as u ON m.ba_roles_id = u.urole_id WHERE '.$where;
	        }
	        else if($this->userdata['urole_id']==2){
	        	$items ='SELECT m.ba_name,u.rolename,m.ba_status,m.ba_id FROM banner_ads as m LEFT JOIN user as b ON m.ba_createdby = b.user_id LEFT JOIN user_role as u ON m.ba_roles_id = u.urole_id WHERE m.ba_status!="2" AND m.ba_roles_id="'.$this->userdata['urole_id'].'" AND (m.ba_name LIKE "%'.$q.'%" OR b.firstname LIKE "%'.$q.'%" OR m.ba_status LIKE "%'.$q.'%")';
	        }
	        else{
	        	$items ='SELECT m.ba_name,u.rolename,m.ba_status,m.ba_id FROM banner_ads as m LEFT JOIN user as b ON m.ba_createdby = b.user_id LEFT JOIN user_role as u ON m.ba_roles_id = u.urole_id WHERE m.ba_status!="2" AND m.ba_createdby="'.$userid.'" AND (m.ba_name LIKE "%'.$q.'%" OR b.firstname LIKE "%'.$q.'%" OR m.ba_status LIKE "%'.$q.'%")';
	        }
		}else{
		    if($this->userdata['urole_id']==1){
	        	$items ='SELECT m.ba_name,u.rolename,m.ba_status,m.ba_id FROM banner_ads as m LEFT JOIN user as b ON m.ba_createdby = b.user_id LEFT JOIN user_role as u ON m.ba_roles_id = u.urole_id WHERE '.$where;
	        }
	        else if($this->userdata['urole_id']==2){
	        	$items ='SELECT m.ba_name,u.rolename,m.ba_status,m.ba_id FROM banner_ads as m LEFT JOIN user as b ON m.ba_createdby = b.user_id LEFT JOIN user_role as u ON m.ba_roles_id = u.urole_id WHERE m.ba_status!="2" AND m.ba_roles_id="'.$this->userdata['urole_id'].'"';
	        }
	        else{
	        	$items ='SELECT m.ba_name,u.rolename,m.ba_status,m.ba_id FROM banner_ads as m LEFT JOIN user as b ON m.ba_createdby = b.user_id LEFT JOIN user_role as u ON m.ba_roles_id = u.urole_id WHERE m.ba_status!="2" AND m.ba_createdby="'.$userid.'"';
	        }

		}
        $query=$this->db->query($items);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'Banner.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser
        $cells = [
                WriterEntityFactory::createCell('Banner Name'),
                WriterEntityFactory::createCell('Intended Type'),
                WriterEntityFactory::createCell('Status'),
                
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
     

        foreach ($obj as $row) {
        	if($row['ba_status']==1){ $st = "Published";}else{ $st = "Draft";}

            $data[0] = $row['ba_name'];
            $data[1] = $row['rolename'];
            $data[2] = $st;
           
            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
        }
        $writer->close();
    }

    public function exportbannerlic()
    {
        set_time_limit(0);
        ini_set('memory_limit', -1);
        $userid =$this->userdata['user_id'];
        $perms=explode(",",$this->userdata['upermission']);
        $q = $this->input->post('search');
        
        if($q!=''){
        	if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
	        	$items = 'SELECT m.ba_name,b.firstname,m.ba_status,m.ba_id FROM banner_ads as m LEFT JOIN user as b ON m.ba_createdby = b.user_id WHERE m.ba_status!="2" AND m.ba_roles_id="2" AND (m.ba_name LIKE "%'.$q.'%" OR b.firstname LIKE "%'.$q.'%" OR m.ba_status LIKE "%'.$q.'%")';
	        }else{
	        	$items = 'SELECT m.ba_name,b.firstname,m.ba_status,m.ba_id FROM banner_ads as m LEFT JOIN user as b ON m.ba_createdby = b.user_id WHERE m.ba_status!="2" AND m.ba_roles_id="2" AND m.ba_createdby="'.$userid.'" AND (m.ba_name LIKE "%'.$q.'%" OR b.firstname LIKE "%'.$q.'%" OR m.ba_status LIKE "%'.$q.'%")';
			}
		}else{
	       if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
	        	$items = 'SELECT m.ba_name,b.firstname,m.ba_status,m.ba_id FROM banner_ads as m LEFT JOIN user as b ON m.ba_createdby = b.user_id WHERE m.ba_status!="2" AND m.ba_roles_id="2"';
	        }else{
	        	$items = 'SELECT m.ba_name,b.firstname,m.ba_status,m.ba_id FROM banner_ads as m LEFT JOIN user as b ON m.ba_createdby = b.user_id WHERE m.ba_status!="2"  AND m.ba_roles_id="2" AND m.ba_createdby="'.$userid.'"';
			}

		}
       

        $query=$this->db->query($items);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'Banner.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser
        $cells = [
                WriterEntityFactory::createCell('Banner Name'),
                WriterEntityFactory::createCell('User'),
                WriterEntityFactory::createCell('Status'),
                
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
     

        foreach ($obj as $row) {
        	if($row['ba_status']==1){ $st = "Published";}else{ $st = "Draft";}

            $data[0] = $row['ba_name'];
            $data[1] = $row['firstname'];
            $data[2] = $st;
           
            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
        }
        $writer->close();
    }

     public function exportbanneria()
    {
        set_time_limit(0);
        ini_set('memory_limit', -1);
        $userid =$this->userdata['user_id'];
        $perms=explode(",",$this->userdata['upermission']);

       $q = $this->input->post('search');
        
        if($q!=''){
        	if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
	        	$items = 'SELECT m.ba_name,b.firstname,m.ba_status,m.ba_id FROM banner_ads as m LEFT JOIN user as b ON m.ba_createdby = b.user_id WHERE m.ba_status!="2" AND m.ba_roles_id="3" AND (m.ba_name LIKE "%'.$q.'%" OR b.firstname LIKE "%'.$q.'%" OR m.ba_status LIKE "%'.$q.'%")';
	        }else{
	        	$items = 'SELECT m.ba_name,b.firstname,m.ba_status,m.ba_id FROM banner_ads as m LEFT JOIN user as b ON m.ba_createdby = b.user_id WHERE m.ba_status!="2" AND m.ba_roles_id="3" AND m.ba_createdby="'.$userid.'" AND (m.ba_name LIKE "%'.$q.'%" OR b.firstname LIKE "%'.$q.'%" OR m.ba_status LIKE "%'.$q.'%")';
			}
		}else{
	       if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
	        	$items = 'SELECT m.ba_name,b.firstname,m.ba_status,m.ba_id FROM banner_ads as m LEFT JOIN user as b ON m.ba_createdby = b.user_id WHERE m.ba_status!="2" AND m.ba_roles_id="3"';
	        }else{
	        	$items = 'SELECT m.ba_name,b.firstname,m.ba_status,m.ba_id FROM banner_ads as m LEFT JOIN user as b ON m.ba_createdby = b.user_id WHERE m.ba_status!="2"  AND m.ba_roles_id="3" AND m.ba_createdby="'.$userid.'"';
			}
		}

        $query=$this->db->query($items);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'Banner.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser
        $cells = [
                WriterEntityFactory::createCell('Banner Name'),
                WriterEntityFactory::createCell('User'),
                WriterEntityFactory::createCell('Status'),
                
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
     

        foreach ($obj as $row) {
        	if($row['ba_status']==1){ $st = "Published";}else{ $st = "Draft";}

            $data[0] = $row['ba_name'];
            $data[1] = $row['firstname'];
            $data[2] = $st;
           
            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
        }
        $writer->close();
    }

    public function exportpage()
    {
        set_time_limit(0);
        ini_set('memory_limit', -1);
        $userid =$this->userdata['user_id'];
        $perms=explode(",",$this->userdata['upermission']);
        $q = $this->input->post('search');
        
        if($q!=''){
        	if($this->userdata['urole_id']==1 ){
        	$items = 'SELECT m.pb_name,m.pb_slug,b.rolename,m.pb_status,m.pb_id FROM pagebanner as m LEFT JOIN user_role as b ON m.pb_role_id = b.urole_id WHERE m.pb_status !="2" AND (m.pb_name LIKE "%'.$q.'%" OR m.pb_slug LIKE "%'.$q.'%" OR b.rolename LIKE "%'.$q.'%" OR m.pb_status LIKE "%'.$q.'%")';	
	        }
	        else if($this->userdata['urole_id']==2|| $this->userdata['urole_id']==3){
	        	$items = 'SELECT m.pb_name,m.pb_slug,b.rolename,m.pb_status,m.pb_id FROM pagebanner as m LEFT JOIN user_role as b ON m.pb_role_id = b.urole_id WHERE m.pb_status !="2" and m.pb_role_id="'.$this->userdata['urole_id'].'" AND (m.pb_name LIKE "%'.$q.'%" OR m.pb_slug LIKE "%'.$q.'%" OR b.rolename LIKE "%'.$q.'%" OR m.pb_status LIKE "%'.$q.'%")';	
	        }
	        else{
	        	$items = 'SELECT m.pb_name,m.pb_slug,b.rolename,m.pb_status,m.pb_id FROM pagebanner as m LEFT JOIN user_role as b ON m.pb_role_id = b.urole_id WHERE m.pb_status !="2" AND m.pb_createdby="'.$userid.'" AND (m.pb_name LIKE "%'.$q.'%" OR m.pb_slug LIKE "%'.$q.'%" OR b.rolename LIKE "%'.$q.'%" OR m.pb_status LIKE "%'.$q.'%")';

	        }
   //      	if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
	  //       	$items = 'SELECT m.pb_name,m.pb_slug,b.rolename,m.pb_status,m.pb_id FROM pagebanner as m LEFT JOIN user_role as b ON m.pb_role_id = b.urole_id WHERE m.pb_status !="2" AND (m.pb_name LIKE "%'.$q.'%" OR m.pb_slug LIKE "%'.$q.'%" OR b.rolename LIKE "%'.$q.'%" OR m.pb_status LIKE "%'.$q.'%")';
	  //       }else{
	  //       	$items = 'SELECT m.pb_name,m.pb_slug,b.rolename,m.pb_status,m.pb_id FROM pagebanner as m LEFT JOIN user_role as b ON m.pb_role_id = b.urole_id WHERE m.pb_status !="2" AND m.pb_createdby="'.$userid.'" AND (m.pb_name LIKE "%'.$q.'%" OR m.pb_slug LIKE "%'.$q.'%" OR b.rolename LIKE "%'.$q.'%" OR m.pb_status LIKE "%'.$q.'%")';
			// }
		}else{
			if($this->userdata['urole_id']==1 ){
        	$items = 'SELECT m.pb_name,m.pb_slug,b.rolename,m.pb_status,m.pb_id FROM pagebanner as m LEFT JOIN user_role as b ON m.pb_role_id = b.urole_id WHERE m.pb_status !="2"';	
	        }
	        else if($this->userdata['urole_id']==2|| $this->userdata['urole_id']==3){
	        	$items = 'SELECT m.pb_name,m.pb_slug,b.rolename,m.pb_status,m.pb_id FROM pagebanner as m LEFT JOIN user_role as b ON m.pb_role_id = b.urole_id WHERE m.pb_status !="2" and m.pb_role_id="'.$this->userdata['urole_id'].'"';	
	        }
	        else{
	        	$items = 'SELECT m.pb_name,m.pb_slug,b.rolename,m.pb_status,m.pb_id FROM pagebanner as m LEFT JOIN user_role as b ON m.pb_role_id = b.urole_id WHERE m.pb_status !="2" AND m.pb_createdby="'.$userid.'"';

	        }
	       // if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
        // 		$items = 'SELECT m.pb_name,m.pb_slug,b.rolename,m.pb_status,m.pb_id FROM pagebanner as m LEFT JOIN user_role as b ON m.pb_role_id = b.urole_id WHERE m.pb_status !="2"';
	       //  }else{
	       //  	$items = 'SELECT m.pb_name,m.pb_slug,b.rolename,m.pb_status,m.pb_id FROM pagebanner as m LEFT JOIN user_role as b ON m.pb_role_id = b.urole_id WHERE m.pb_status !="2" AND m.pb_createdby="'.$userid.'"';

	       //  }

		}
       

        $query=$this->db->query($items);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'Page Manager.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser
        $cells = [
                WriterEntityFactory::createCell('Page Name'),
                WriterEntityFactory::createCell('Slug'),
                WriterEntityFactory::createCell('Intended For'),
                WriterEntityFactory::createCell('Status'),
                
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
     

        foreach ($obj as $row) {
        	if($row['pb_status']==1){ $st = "Active";}else{ $st = "Inactive";}

            $data[0] = $row['pb_name'];
            $data[1] = $row['pb_slug'];
            $data[2] = $row['rolename'];
            $data[3] = $st;
           
            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
        }
        $writer->close();
    }

    public function exportpageia()
    {
        set_time_limit(0);
        ini_set('memory_limit', -1);
        $userid =$this->userdata['user_id'];
        $perms=explode(",",$this->userdata['upermission']);
        $q = $this->input->post('search');
        
        if($q!=''){
        	if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
	        	$items = 'SELECT m.pb_name,m.pb_slug,b.rolename,m.pb_status,m.pb_id FROM pagebanner as m LEFT JOIN user_role as b ON m.pb_role_id = b.urole_id WHERE m.pb_status !="2" AND m.pb_role_id="3" AND (m.pb_name LIKE "%'.$q.'%" OR m.pb_slug LIKE "%'.$q.'%" OR b.rolename LIKE "%'.$q.'%" OR m.pb_status LIKE "%'.$q.'%")';
	        }else{
	        	$items = 'SELECT m.pb_name,m.pb_slug,b.rolename,m.pb_status,m.pb_id FROM pagebanner as m LEFT JOIN user_role as b ON m.pb_role_id = b.urole_id WHERE m.pb_status !="2" AND m.pb_role_id="3" AND m.pb_createdby="'.$userid.'" AND (m.pb_name LIKE "%'.$q.'%" OR m.pb_slug LIKE "%'.$q.'%" OR b.rolename LIKE "%'.$q.'%" OR m.pb_status LIKE "%'.$q.'%")';
			}
		}else{
	       if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
        	$items = 'SELECT m.pb_name,m.pb_slug,b.rolename,m.pb_status,m.pb_id FROM pagebanner as m LEFT JOIN user_role as b ON m.pb_role_id = b.urole_id WHERE m.pb_status !="2" AND m.pb_role_id="3"';
	        }else{
	        	$items = 'SELECT m.pb_name,m.pb_slug,b.rolename,m.pb_status,m.pb_id FROM pagebanner as m LEFT JOIN user_role as b ON m.pb_role_id = b.urole_id WHERE m.pb_status !="2" AND m.pb_role_id="3" AND m.pb_createdby="'.$userid.'"';

	        }

		}
       

        $query=$this->db->query($items);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'Page Manager.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser
        $cells = [
                WriterEntityFactory::createCell('Page Name'),
                WriterEntityFactory::createCell('Slug'),
                WriterEntityFactory::createCell('Intended For'),
                WriterEntityFactory::createCell('Status'),
                
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
     

        foreach ($obj as $row) {
        	if($row['pb_status']==1){ $st = "Active";}else{ $st = "Inactive";}

            $data[0] = $row['pb_name'];
            $data[1] = $row['pb_slug'];
            $data[2] = $row['rolename'];
            $data[3] = $st;
           
            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
        }
        $writer->close();
    }

    public function exportpagelic()
    {
        set_time_limit(0);
        ini_set('memory_limit', -1);
        $userid =$this->userdata['user_id'];
        $perms=explode(",",$this->userdata['upermission']);

       $q = $this->input->post('search');
        
        if($q!=''){
        	if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
	        	$items = 'SELECT m.pb_name,m.pb_slug,b.rolename,m.pb_status,m.pb_id FROM pagebanner as m LEFT JOIN user_role as b ON m.pb_role_id = b.urole_id WHERE m.pb_status !="2" AND m.pb_role_id="2" AND (m.pb_name LIKE "%'.$q.'%" OR m.pb_slug LIKE "%'.$q.'%" OR b.rolename LIKE "%'.$q.'%" OR m.pb_status LIKE "%'.$q.'%")';
	        }else{
	        	$items = 'SELECT m.pb_name,m.pb_slug,b.rolename,m.pb_status,m.pb_id FROM pagebanner as m LEFT JOIN user_role as b ON m.pb_role_id = b.urole_id WHERE m.pb_status !="2" AND m.pb_role_id="2" AND m.pb_createdby="'.$userid.'" AND (m.pb_name LIKE "%'.$q.'%" OR m.pb_slug LIKE "%'.$q.'%" OR b.rolename LIKE "%'.$q.'%" OR m.pb_status LIKE "%'.$q.'%")';
			}
		}else{
	       if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
        	$items = 'SELECT m.pb_name,m.pb_slug,b.rolename,m.pb_status,m.pb_id FROM pagebanner as m LEFT JOIN user_role as b ON m.pb_role_id = b.urole_id WHERE m.pb_status !="2" AND m.pb_role_id="2"';
	        }else{
	        	$items = 'SELECT m.pb_name,m.pb_slug,b.rolename,m.pb_status,m.pb_id FROM pagebanner as m LEFT JOIN user_role as b ON m.pb_role_id = b.urole_id WHERE m.pb_status !="2" AND m.pb_role_id="2" AND m.pb_createdby="'.$userid.'"';

	        }

		}

        $query=$this->db->query($items);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'Page Manager.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser
        $cells = [
                WriterEntityFactory::createCell('Page Name'),
                WriterEntityFactory::createCell('Slug'),
                WriterEntityFactory::createCell('Intended For'),
                WriterEntityFactory::createCell('Status'),
                
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
     

        foreach ($obj as $row) {
        	if($row['pb_status']==1){ $st = "Active";}else{ $st = "Inactive";}

            $data[0] = $row['pb_name'];
            $data[1] = $row['pb_slug'];
            $data[2] = $row['rolename'];
            $data[3] = $st;
           
            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
        }
        $writer->close();
    }

     public function removepage(){
        if ($this->input->is_ajax_request()) {
        
            $ids = $this->input->post('ids');
            $data = array('pb_status'=>'2');
            $this->generalmodel->updaterecord('pagebanner',$data,'pb_id IN('.$ids.')');
          
            $return = array('success'=>true,'msg'=>'Records Removed');
        }else{
            $return = array('success'=>false,'msg'=>'Internal Error');
        }
        echo json_encode($return);
    }

}