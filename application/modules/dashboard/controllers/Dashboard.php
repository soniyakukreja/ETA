<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;
class Dashboard extends MY_Controller {

	public function __construct(){
		parent::__construct();
	}
	public function index()
	{
		$st_date = date('Y-m-01');
		$end_date = date('Y-m-t');
		$data['prod_cat_list'] = $this->generalmodel->prod_cat_list();
		$urole_id = $this->userdata['urole_id'];
		$dept_id = $this->userdata['dept_id'];

		if($dept_id==2){

			if($urole_id==1){
				$this->load->view('cto_eta',$data);
			}elseif($urole_id==2){
				$this->load->view('cto_lic',$data);
			}elseif($urole_id==3){
				$this->load->view('cto_ia',$data);
			}
		}elseif($dept_id==3){
			$this->load->view('account',$data);
		}elseif($dept_id==4){
			$this->load->view('csr',$data);
		}elseif($dept_id==5){
			$this->load->view('kam',$data);
		}elseif($dept_id==7){
			$this->load->view('compliance_officer',$data);
		}elseif($dept_id==8){
			$this->load->view('prod_manager',$data);
		}elseif($dept_id==9){
			$this->load->view('marketing',$data);
		}elseif($dept_id==10){
			$this->load->view('it',$data);
		}elseif($dept_id==11){
			$this->load->view('bde',$data);
		}else{
			$this->load->view('dashboard',$data);
		}

		/*
		if($dept_id==2){
			redirect('cto-dashboard');
		}

		if($urole_id==1){
			if($dept_id==9){
				redirect('licensee/viewlicensee');
			}elseif($dept_id==5){
				redirect('kam-dashboard');
			}elseif($dept_id==11){
				redirect('lead/deal');
			}else{
				$this->load->view('eta_dashboard',$data);
			}
			//$this->load->view('eta_dashboard',$data);
		}elseif($urole_id==2){
			if($dept_id==9){
				redirect('licensee/viewlicensee');
			}elseif($dept_id==5){
				redirect('kam-dashboard');
			}elseif($dept_id==11){
				redirect('lead/deal');
			}else{
				redirect('lic-dashboard');
			}
		}elseif($urole_id==3){
			if($dept_id==9){
				redirect('licensee/viewlicensee');
			}elseif($dept_id==11){
				redirect('lead/deal');
			}elseif($dept_id==5){
				redirect('kam-dashboard');
			}else{
				redirect('ia-dashboard');
			}			
		}else
		*/

		if($urole_id==4){
			redirect('shop');
		}elseif($urole_id==5){
			redirect('audit/audit');
		}
	}


	public function newest_ticket(){

		if($this->input->is_ajax_request()){
            $user_id = $this->userdata['user_id'];
            $perms=explode(",",$this->userdata['upermission']);
            $datatables = new Datatables(new CodeigniterAdapter);

            $where = 'm.status="1"';

            if($this->userdata['dept_id']==5){
                $where .= ' AND (( u.urole_id='.$this->userdata['urole_id'].' AND (m.user_id='.$user_id.' OR FIND_IN_SET('.$user_id.',m.tic_users))) OR (m.upper_level='.$user_id.') AND act.tic_activity_type="comment")';


                $query='SELECT m.tic_number,b.tic_cat_name,m.tic_status,m.tic_id
                FROM ticket as m 
                LEFT JOIN ticket_category as b ON m.tic_cat_id = b.tic_cat_id 
                LEFT JOIN user as u ON m.user_id = u.user_id 
                LEFT JOIN ticket_activity as act ON act.tic_id = m.tic_id

                WHERE  '.$where;

            }elseif($this->userdata['dept_id']==2){
                $where .= ' AND u.urole_id='.$this->userdata['urole_id'];                
            }elseif($this->userdata['dept_id']==8){
                $where .= ' AND (u.urole_id='.$this->userdata['urole_id'].' OR u.urole_id="5" )AND (m.user_id='.$user_id.' OR FIND_IN_SET('.$user_id.',m.tic_users))';
            }
            elseif($this->userdata['dept_id']!=2 && $this->userdata['dept_id']!=5 && $this->userdata['dept_id']!=8){
                $where .= ' AND u.urole_id='.$this->userdata['urole_id'].' AND (m.user_id='.$user_id.' OR FIND_IN_SET('.$user_id.',m.tic_users))';
            }


            if($this->userdata['dept_id']!=5){

            	$query='SELECT m.tic_number,b.tic_cat_name,m.tic_status,m.tic_id 
            	FROM ticket as m 
            	LEFT JOIN ticket_category as b ON m.tic_cat_id = b.tic_cat_id 
            	LEFT JOIN user as u ON m.user_id = u.user_id WHERE  '.$where;

            }

            //echo $query; exit;
            $datatables->query($query);


			$datatables->edit('tic_status', function($data){
				if($data['tic_status']==0){ return "Open"; }
				elseif($data['tic_status']==1){return "Pending"; }
				elseif($data['tic_status']==2){return "Resolved"; }
				elseif($data['tic_status']==3){return "Spam"; }
			});

	        $datatables->edit('tic_id', function($data){

	    		$menu='';
				$menu.='<li>
	            <a target="_blank" href="'.site_url('ticket/viewticket/').encoding($data['tic_id']).'">
	                <span class="glyphicon glyphicon-eye-open"></span> View
	            </a>
	        	</li>';	  
	        	return '<div class="dropdown"><button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
	                    <i class="glyphicon glyphicon-option-vertical"></i>
	                </button>
	                <ul class="dropdown-menu">
	                '.$menu.'    
	                </ul></div>';
	        });
         
            echo $datatables->generate();
        }
	}

	public function f_newest_ticket(){

		 $user_id = $this->userdata['user_id'];
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
			$st_date = empty($this->input->post('st_date'))?date('Y-m-01'):get_ymd_format($this->input->post('st_date'));
			$end_date = empty($this->input->post('end_date'))?date('Y-m-t'):get_ymd_format($this->input->post('end_date'));
			

			$where = "`m`.`status`= '1' AND `m`.`tic_createdate`>='".$st_date." 00:00:00' AND `m`.`tic_createdate`<='".$end_date." 23:59:59'";
			//$where .= " AND `m`.`tic_status`='1'";
			
			if($this->userdata['dept_id']==5){
                $where .= ' AND (( u.urole_id='.$this->userdata['urole_id'].' AND (m.user_id='.$user_id.' OR FIND_IN_SET('.$user_id.',m.tic_users))) OR (m.upper_level='.$user_id.') AND act.tic_activity_type="comment")';


                $query='SELECT m.tic_number,b.tic_cat_name,m.tic_status,m.tic_id
                FROM ticket as m 
                LEFT JOIN ticket_category as b ON m.tic_cat_id = b.tic_cat_id 
                LEFT JOIN user as u ON m.user_id = u.user_id 
                LEFT JOIN ticket_activity as act ON act.tic_id = m.tic_id

                WHERE  '.$where;

            }elseif($this->userdata['dept_id']==2){
                $where .= ' AND u.urole_id='.$this->userdata['urole_id'];                
            }elseif($this->userdata['dept_id']==8){
                $where .= ' AND (u.urole_id='.$this->userdata['urole_id'].' OR u.urole_id="5" )AND (m.user_id='.$user_id.' OR FIND_IN_SET('.$user_id.',m.tic_users))';
            }elseif($this->userdata['dept_id']!=2 && $this->userdata['dept_id']!=5 && $this->userdata['dept_id']!=8){
                $where .= ' AND u.urole_id='.$this->userdata['urole_id'].' AND (m.user_id='.$user_id.' OR FIND_IN_SET('.$user_id.',m.tic_users))';
            }


            if($this->userdata['dept_id']!=5){

            	$query='SELECT m.tic_number,b.tic_cat_name,m.tic_status,m.tic_id FROM ticket as m LEFT JOIN ticket_category as b ON m.tic_cat_id = b.tic_cat_id LEFT JOIN user as u ON m.user_id = u.user_id WHERE  '.$where;

            }

//echo $query; exit;

	        $datatables = new Datatables(new CodeigniterAdapter);
			$datatables->query($query);

			$datatables->edit('tic_status', function($data){
				if($data['tic_status']==0){ return "Open"; }
				elseif($data['tic_status']==1){return "Pending"; }
				elseif($data['tic_status']==2){return "Resolved"; }
				elseif($data['tic_status']==3){return "Spam"; }
			});

	        $datatables->edit('tic_id', function($data){

	    		$menu='';
				$menu.='<li>
	            <a target="_blank" href="'.site_url('ticket/viewticket/').encoding($data['tic_id']).'" >
	                <span class="glyphicon glyphicon-eye-open"></span> View
	            </a>
	        	</li>';	  
	        	return '<div class="dropdown"><button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
	                    <i class="glyphicon glyphicon-option-vertical"></i>
	                </button>
	                <ul class="dropdown-menu">
	                '.$menu.'    
	                </ul></div>';
	        });
        	echo $datatables->generate();
		}	
	
	}

	public function compliance_count(){

		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
			$st_date = empty($this->input->post('st_date'))?date('Y-m-01'):get_ymd_format($this->input->post('st_date'));
			$end_date = empty($this->input->post('end_date'))?date('Y-m-t'):get_ymd_format($this->input->post('end_date'));
			
			$user_id = $this->userdata['user_id'];
			//$where = "`ticket`.`status`='1' AND `ticket`.`tic_createdate`>='".$st_date."' AND `ticket`.`tic_createdate`<='".$end_date."'";
			
			$where = "`m`.`status`= '1' AND `m`.`tic_createdate`>='".$st_date." 00:00:00' AND `m`.`tic_createdate`<='".$end_date." 23:59:59'";
			//$where .= " AND `m`.`tic_status`='1'";
			

            if($this->userdata['dept_id']==2){
                $where .= ' AND u.urole_id='.$this->userdata['urole_id'];                
            }elseif($this->userdata['dept_id']==5){
                $where .= ' AND (( u.urole_id='.$this->userdata['urole_id'].' AND (m.user_id='.$user_id.' OR FIND_IN_SET('.$user_id.',m.tic_users))) OR (m.upper_level='.$user_id.') AND act.tic_activity_type="comment")';

            }elseif($this->userdata['dept_id']==8){
                $where .= ' AND (u.urole_id='.$this->userdata['urole_id'].' OR u.urole_id="5" )AND (m.user_id='.$user_id.' OR FIND_IN_SET('.$user_id.',m.tic_users))';
            }elseif($this->userdata['dept_id']!=2 && $this->userdata['dept_id']!=5 && $this->userdata['dept_id']!=8){
                $where .= ' AND u.urole_id='.$this->userdata['urole_id'].' AND (m.user_id='.$user_id.' OR FIND_IN_SET('.$user_id.',m.tic_users))';
            }



			// $query = "SELECT COUNT(tic_id) AS total_count,tic_status 
			// FROM `ticket` AS m
			// LEFT JOIN user as u ON m.user_id = u.user_id
			// WHERE ".$where." GROUP BY tic_status";




            if($this->userdata['dept_id']==5){
				
				$query = "SELECT COUNT(m.tic_id) AS total_count,tic_status 
				FROM `ticket` AS m
				LEFT JOIN user as u ON m.user_id = u.user_id
				LEFT JOIN ticket_activity as act ON act.tic_id = m.tic_id
				WHERE ".$where." GROUP BY tic_status";

            }elseif($this->userdata['dept_id']!=5){

				$query = "SELECT COUNT(m.tic_id) AS total_count,tic_status 
				FROM `ticket` AS m
				LEFT JOIN user as u ON m.user_id = u.user_id
				WHERE ".$where." GROUP BY tic_status";
            }




	        $result = $this->generalmodel->customquery($query);

  //                       print_r($this->db->last_query());
  // print_r($result); exit;


			$tic_status = array_column($result, 'tic_status');

			$openComp = $pendingComp = $resolvedComp = $spamComp = 0;

			if(!empty($result)){ foreach($result as $res){
				if($res['tic_status']=="1"){ $pendingComp = $res['total_count']; }
				elseif($res['tic_status']=="2"){ $resolvedComp = $res['total_count']; }
				elseif($res['tic_status']=="0"){ $openComp = $res['total_count']; }
				elseif($res['tic_status']=="3"){ $spamComp = $res['total_count']; }
			} }
		
			$return = array('openComp'=>$openComp,'pendingComp'=>$pendingComp,'resolvedComp'=>$resolvedComp,'spamComp'=>$spamComp);
			echo json_encode($return);
		}		

	}

	public function ticket_percat(){

		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
			$st_date = empty($this->input->post('st_date'))?date('Y-m-01'):get_ymd_format($this->input->post('st_date'));
			$end_date = empty($this->input->post('end_date'))?date('Y-m-t'):get_ymd_format($this->input->post('end_date'));
			$tpc_bg = array();
			$labels = $values= $tcp_ul_li ='';
			$user_id = $this->userdata['user_id'];


			$where = "`tc`.`tic_del_status` = '1' AND `tc`.`tic_cat_status` = '1' AND  `m`.`status`= '1'  AND `m`.`tic_createdate`>='".$st_date." 00:00:00' AND `m`.`tic_createdate`<='".$end_date." 23:59:59'";
			
			//$where .= " AND `m`.`tic_status`='1'";

            if($this->userdata['dept_id']==2){
                $where .= ' AND u.urole_id='.$this->userdata['urole_id'];                
            }elseif($this->userdata['dept_id']==8){
                $where .= ' AND (u.urole_id='.$this->userdata['urole_id'].' OR u.urole_id="5" )AND (m.user_id='.$user_id.' OR FIND_IN_SET('.$user_id.',m.tic_users))';
            }elseif($this->userdata['dept_id']==5){
                $where .= ' AND (( u.urole_id='.$this->userdata['urole_id'].' AND (m.user_id='.$user_id.' OR FIND_IN_SET('.$user_id.',m.tic_users))) OR (m.upper_level='.$user_id.') AND act.tic_activity_type="comment")';

            }elseif($this->userdata['dept_id']!=2 && $this->userdata['dept_id']!=5 && $this->userdata['dept_id']!=8){
                $where .= ' AND u.urole_id='.$this->userdata['urole_id'].' AND (m.user_id='.$user_id.' OR FIND_IN_SET('.$user_id.',m.tic_users))';
            }

            if($this->userdata['dept_id']==5){

				// $a = "SELECT COUNT(`m`.`tic_id`) AS counter,tc.tic_cat_name 
				// FROM `ticket` AS m 
				// LEFT JOIN  ticket_category AS tc ON tc.tic_cat_id = m.tic_cat_id  
    //             LEFT JOIN user as u ON m.user_id = u.user_id 
    //             LEFT JOIN ticket_activity as act ON act.tic_id = m.tic_id				
				// WHERE ".$where." GROUP BY `m`.`tic_cat_id` ORDER BY `tc`.`tic_cat_name` ASC";

				$query = $this->db->query("SELECT COUNT(`m`.`tic_id`) AS counter,tc.tic_cat_name 
				FROM `ticket` AS m 
				LEFT JOIN  ticket_category AS tc ON tc.tic_cat_id = m.tic_cat_id  
                LEFT JOIN user as u ON m.user_id = u.user_id 
                LEFT JOIN ticket_activity as act ON act.tic_id = m.tic_id				
				WHERE ".$where." GROUP BY `m`.`tic_cat_id` ORDER BY `tc`.`tic_cat_name` ASC")->result_array();


            }elseif($this->userdata['dept_id']!=5){

				$query = $this->db->query("SELECT COUNT(`m`.`tic_id`) AS counter,tc.tic_cat_name 
				FROM `ticket` AS m 
				LEFT JOIN  ticket_category AS tc ON tc.tic_cat_id = m.tic_cat_id  
                LEFT JOIN user as u ON m.user_id = u.user_id 
				WHERE ".$where." GROUP BY `m`.`tic_cat_id` ORDER BY `tc`.`tic_cat_name` ASC")->result_array();

            }


			if(!empty($query)){

				$tic_cat = array_column($query, 'tic_cat_name');
				foreach($tic_cat as $key=>$val){ if($key%2==0){ $tpc_bg[] = '#0A4672'; }else{ $tpc_bg[] = '#8DC63F'; } } 
			
				$labels = $tic_cat;
				$values = array_column($query, 'counter');

				$tcp_ul_li = '<ul class="ticket_ul_li">';
				foreach($query as $key=>$val){
					$color = ($key%2==0)?'blueli':'greenli';

					$tcp_ul_li .= '<li class="'.$color.'">'.$val['tic_cat_name'].':'.$val['counter'].'</li>';
					if($key%3==2){ 
						$tcp_ul_li .= '</ul><ul class="ticket_ul_li">';
					}
				}
				$tcp_ul_li .= '</ul>';
			}
			$return = array('labels'=>$labels,'values'=>$values,'tpc_bg'=>$tpc_bg,'tcp_ul_li'=>$tcp_ul_li);
			echo json_encode($return);
		}	

	}

	public function ticket_per_staff(){
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
			$st_date = empty($this->input->post('st_date'))?date('Y-m-01'):get_ymd_format($this->input->post('st_date'));
			$end_date = empty($this->input->post('end_date'))?date('Y-m-t'):get_ymd_format($this->input->post('end_date'));
			$tps_bg = array();
			$labels = $values='';

			$user_id = $this->userdata['user_id'];
			$where = "`m`.`status`= '1' AND `m`.`tic_createdate`>='".$st_date." 00:00:00' AND `m`.`tic_createdate`<='".$end_date." 23:59:59'";

			//$where .= " AND `m`.`tic_status`='1' ";
			

            if($this->userdata['dept_id']==2 || $this->userdata['dept_id']==7){
                $where .= ' AND u.urole_id='.$this->userdata['urole_id'];                
            }elseif($this->userdata['dept_id']!=2 && $this->userdata['dept_id']!=5){
                $where .= ' AND u.urole_id='.$this->userdata['urole_id'].' AND (m.user_id='.$user_id.' OR FIND_IN_SET('.$user_id.',m.tic_users))';
            }elseif($this->userdata['dept_id']==5){
                $where .= ' AND (( u.urole_id='.$this->userdata['urole_id'].' AND (m.user_id='.$user_id.' OR FIND_IN_SET('.$user_id.',m.tic_users))) OR (m.upper_level='.$user_id.') AND act.tic_activity_type="comment")';

            }


			$query = "SELECT d.deptname,COUNT(m.tic_id) AS tcount,u.resource_id,u.user_id 
			FROM `ticket` AS m 
			LEFT JOIN user as u ON m.user_id = u.user_id
			LEFT JOIN `department` as d ON u.dept_id=d.dept_id 
			WHERE ".$where." GROUP BY d.dept_id ORDER BY `resource_id` ASC";
			$result = $this->db->query($query)->result_array();


			if(!empty($result)){ 
				$labels = array_column($result, 'deptname') ;
				$values = array_column($result, 'tcount') ;		

				foreach($result as $key=>$val){ 
				if($key%2==0){ $tps_bg[] = '#0A4672'; }else{ $tps_bg[] = '#8DC63F'; } 

				$tps_ul_li = '<ul class="ticket_ul_li">';
				foreach($result as $key=>$val){

					$color = ($key%2==0)?'blueli':'greenli';
					$tps_ul_li .= '<li class="'.$color.'">'.$val['deptname'].':'.$val['tcount'].'</li>';

					if($key%3==2){ 
						$tps_ul_li .= '</ul><ul class="ticket_ul_li">';
					}

				}
				$tps_ul_li .= '</ul>';


			} }

			$return = array('labels'=>$labels,'values'=>$values,'tps_bg'=>$tps_bg,'tps_ul_li'=>$tps_ul_li);
			echo json_encode($return);
		}	
	}


	/*
	public function newest_ticket(){ 
		if($this->input->is_ajax_request()){
			
			$where = "`t`.`status`= '1' AND (`t`.`tic_status`='0' OR `t`.`tic_status`='1')";
			$query = "SELECT t.tic_number,tc.tic_cat_name,t.tic_status,t.tic_id FROM `ticket` AS t  LEFT JOIN `ticket_category` AS tc ON `t`.`tic_cat_id` = `tc`.`tic_cat_id`
			 WHERE ".$where." ORDER BY `tic_createdate` DESC LIMIT 10";

			// echo $query; exit;
	        $datatables = new Datatables(new CodeigniterAdapter);
			$datatables->query($query);

			$datatables->edit('tic_status', function($data){
				if($data['tic_status']==0){ return "Open"; }
				elseif($data['tic_status']==1){return "Pending"; }
				elseif($data['tic_status']==2){return "Resolved"; }
				elseif($data['tic_status']==3){return "Spam"; }
			});

	        $datatables->edit('tic_id', function($data){

	    		$menu='';
				$menu.='<li>
	            <a target="_blank" href="'.site_url('ticket/viewticket/').encoding($data['tic_id']).'">
	                <span class="glyphicon glyphicon-eye-open"></span> View
	            </a>
	        	</li>';	  
	        	return '<div class="dropdown"><button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
	                    <i class="glyphicon glyphicon-option-vertical"></i>
	                </button>
	                <ul class="dropdown-menu">
	                '.$menu.'    
	                </ul></div>';
	        });
        	echo $datatables->generate();
		}	
	}

	public function f_newest_ticket(){

		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
			$st_date = empty($this->input->post('st_date'))?date('Y-m-01'):get_ymd_format($this->input->post('st_date'));
			$end_date = empty($this->input->post('end_date'))?date('Y-m-t'):get_ymd_format($this->input->post('end_date'));
			
			$where = "`t`.`status`= '1' AND `t`.`tic_status`='1' AND `t`.`tic_createdate`>='".$st_date."' AND `t`.`tic_createdate`<='".$end_date."'";
			$query = "SELECT t.tic_number,tc.tic_cat_name,t.tic_status,t.tic_id FROM `ticket` AS t  LEFT JOIN `ticket_category` AS tc ON `t`.`tic_cat_id` = `tc`.`tic_cat_id`
			 WHERE ".$where." ORDER BY `tic_createdate` DESC";
	        $datatables = new Datatables(new CodeigniterAdapter);
			$datatables->query($query);

	        $datatables->edit('tic_id', function($data){

	    		$menu='';
				$menu.='<li>
	            <a target="_blank" href="'.site_url('ticket/viewticket/').encoding($data['tic_id']).'" >
	                <span class="glyphicon glyphicon-eye-open"></span> View
	            </a>
	        	</li>';	  
	        	return '<div class="dropdown"><button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
	                    <i class="glyphicon glyphicon-option-vertical"></i>
	                </button>
	                <ul class="dropdown-menu">
	                '.$menu.'    
	                </ul></div>';
	        });
        	echo $datatables->generate();
		}	
	
	}

	public function compliance_count(){
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
			$st_date = empty($this->input->post('st_date'))?date('Y-m-01'):get_ymd_format($this->input->post('st_date'));
			$end_date = empty($this->input->post('end_date'))?date('Y-m-t'):get_ymd_format($this->input->post('end_date'));
			
			$where = "`ticket`.`status`='1' AND `ticket`.`tic_createdate`>='".$st_date."' AND `ticket`.`tic_createdate`<='".$end_date."'";
			$query = "SELECT COUNT(tic_id) AS total_count,tic_status FROM `ticket` WHERE ".$where." GROUP BY tic_status";
	        $result = $this->generalmodel->customquery($query);

			$tic_status = array_column($result, 'tic_status');

			$openComp = $pendingComp = $resolvedComp = $spamComp = 0;

			if(!empty($result)){ foreach($result as $res){
				if($res['tic_status']=="1"){ $pendingComp = $res['total_count']; }
				elseif($res['tic_status']=="2"){ $resolvedComp = $res['total_count']; }
				elseif($res['tic_status']=="0"){ $openComp = $res['total_count']; }
				elseif($res['tic_status']=="3"){ $spamComp = $res['total_count']; }
			} }
		
			$return = array('openComp'=>$openComp,'pendingComp'=>$pendingComp,'resolvedComp'=>$resolvedComp,'spamComp'=>$spamComp);
			echo json_encode($return);
		}		
	}

	public function ticket_percat(){
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
			$st_date = empty($this->input->post('st_date'))?date('Y-m-01'):get_ymd_format($this->input->post('st_date'));
			$end_date = empty($this->input->post('end_date'))?date('Y-m-t'):get_ymd_format($this->input->post('end_date'));
			$tpc_bg = array();
			$labels = $values='';
			//$tic_cat_list = $this->generalmodel->ticket_cat_list();

			$where = "`t`.status ='1' AND `tc`.`tic_del_status` = '1' AND `tc`.`tic_cat_status` = '1' AND `t`.tic_createdate >= '".$st_date."' AND `t`.tic_createdate <= '".$end_date."'";
			$query = $this->db->query("SELECT COUNT(`tic_id`) AS counter,tc.tic_cat_name FROM `ticket` AS t LEFT JOIN  ticket_category AS tc ON tc.tic_cat_id = t.tic_cat_id  WHERE ".$where." GROUP BY `t`.`tic_cat_id` ORDER BY `tc`.`tic_cat_name` ASC")->result_array();


			if(!empty($query)){

				$tic_cat = array_column($query, 'tic_cat_name');
				foreach($tic_cat as $key=>$val){ if($key%2==0){ $tpc_bg[] = '#0A4672'; }else{ $tpc_bg[] = '#8DC63F'; } } 
			
				$labels = $tic_cat;
				$values = array_column($query, 'counter');
			}
			$return = array('labels'=>$labels,'values'=>$values,'tpc_bg'=>$tpc_bg);
			echo json_encode($return);
		}		
	}

	public function ticket_per_staff(){
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
			$st_date = empty($this->input->post('st_date'))?date('Y-m-01'):get_ymd_format($this->input->post('st_date'));
			$end_date = empty($this->input->post('end_date'))?date('Y-m-t'):get_ymd_format($this->input->post('end_date'));
			$tps_bg = array();
			$labels = $values='';

			$where = "`t`.status ='1' AND u.status=1 AND u.dept_id!=0 AND `t`.tic_createdate >= '".$st_date."' AND `t`.tic_createdate <= '".$end_date."'";

			$query = "SELECT d.deptname,COUNT(t.tic_id) AS tcount,u.resource_id,u.user_id FROM `ticket` AS t 
			LEFT JOIN user as u ON t.user_id = u.user_id
			LEFT JOIN `department` as d ON u.dept_id=d.dept_id 
			WHERE ".$where." GROUP BY d.dept_id ORDER BY `resource_id` ASC";
			$result = $this->db->query($query)->result_array();


			if(!empty($result)){ 
				$labels = array_column($result, 'deptname') ;
				$values = array_column($result, 'tcount') ;		

				foreach($result as $key=>$val){ 
				if($key%2==0){ $tps_bg[] = '#0A4672'; }else{ $tps_bg[] = '#8DC63F'; } 
			} }

			$return = array('labels'=>$labels,'values'=>$values,'tps_bg'=>$tps_bg);
			echo json_encode($return);
		}		
	}

	*/

	public function pending_audit(){
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
			$st_date = empty($this->input->post('st_date'))?date('Y-m-01'):get_ymd_format($this->input->post('st_date'));
			$end_date = empty($this->input->post('end_date'))?date('Y-m-t'):get_ymd_format($this->input->post('end_date'));
			
			$where = "`au`.`status`IN('0','1')  AND `au`.`createdate`>='".$st_date." 00:00:00' AND `au`.`createdate`<='".$end_date." 23:59:59'";
			$query = "SELECT au.prod_name,pc.prod_cat_name,au.status,au.ord_prod_id FROM `audit` AS au LEFT JOIN `product` AS p ON `p`.`prod_id` = `au`.`prod_id`
			LEFT JOIN `product_category` AS pc ON `p`.`prod_cat_id` = `pc`.`prod_cat_id`
			 WHERE ".$where." ORDER BY `au`.`createdate` DESC LIMIT 5";
	        $datatables = new Datatables(new CodeigniterAdapter);
			$datatables->query($query);

			$datatables->edit('status', function($data){
				if($data['status']=='0'){ return 'Pending';}elseif($data['status']==1){ return 'Review'; } 
			});

	        $datatables->edit('ord_prod_id', function($data){

	    		$menu='';
				$menu.='<li>
	            <a target="_blank" href="'.site_url('audit/viewaudit/').encoding($data['ord_prod_id']).'">
	                <span class="glyphicon glyphicon-eye-open"></span> View
	            </a>
	        	</li>';	  
	        	return '<div class="dropdown"><button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
	                    <i class="glyphicon glyphicon-option-vertical"></i>
	                </button>
	                <ul class="dropdown-menu">
	                '.$menu.'    
	                </ul></div>';
	        });
        	echo $datatables->generate();
		}	
	}


	public function my_newest_ticket(){
		if($this->input->is_ajax_request()){
			
			$user_id = $this->userdata['user_id'];
			$where = "`t`.`status`= '1' AND (`t`.`tic_status`='0' OR `t`.`tic_status`='1') AND `t`.`user_id`=".$user_id;
			$query = "SELECT t.tic_number,tc.tic_cat_name,t.tic_status,t.tic_id FROM `ticket` AS t  LEFT JOIN `ticket_category` AS tc ON `t`.`tic_cat_id` = `tc`.`tic_cat_id`
			 WHERE ".$where." ORDER BY `tic_createdate` DESC LIMIT 10";

			// echo $query; exit;
	        $datatables = new Datatables(new CodeigniterAdapter);
			$datatables->query($query);

			$datatables->edit('tic_status', function($data){
				if($data['tic_status']==0){ return "Open"; }
				elseif($data['tic_status']==1){return "Pending"; }
				elseif($data['tic_status']==2){return "Resolved"; }
				elseif($data['tic_status']==3){return "Spam"; }
			});

	        $datatables->edit('tic_id', function($data){

	    		$menu='';
				$menu.='<li>
	            <a target="_blank" href="'.site_url('ticket/viewticket/').encoding($data['tic_id']).'">
	                <span class="glyphicon glyphicon-eye-open"></span> View
	            </a>
	        	</li>';	  
	        	return '<div class="dropdown"><button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
	                    <i class="glyphicon glyphicon-option-vertical"></i>
	                </button>
	                <ul class="dropdown-menu">
	                '.$menu.'    
	                </ul></div>';
	        });
        	echo $datatables->generate();
		}			
	}

	public function producbycat(){
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
			$st_date = empty($this->input->post('st_date'))?date('Y-m-01'):get_ymd_format($this->input->post('st_date'));
			$end_date = empty($this->input->post('end_date'))?date('Y-m-t'):get_ymd_format($this->input->post('end_date'));
			

			// $prod_cat_list = $this->generalmodel->prod_cat_list();
			// $prod_cat = array_column($prod_cat_list, 'prod_cat_name');

			$where = "op.createdate >='".$st_date." 00:00:00' AND op.createdate <='".$end_date." 23:59:59'";
			$result = $this->db->query("SELECT SUM(op.prod_qty) AS counter,pc.prod_cat_name  FROM `orders_product` AS op
			LEFT JOIN product as p ON op.prod_id= p.prod_id
			LEFT JOIN product_category as pc ON p.prod_cat_id= pc.prod_cat_id WHERE ".$where."
			GROUP BY pc.prod_cat_id ORDER BY pc.prod_cat_name")->result_array();

			$labels = array_column($result, 'prod_cat_name');
			$values = array_column($result, 'counter');
			//$values = array(100,5,5000);
			$return = array('labels'=>$labels,'values'=>$values);
			echo json_encode($return);
		}
	}	
	public function getAccountData(){
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
			$st_date = empty($this->input->post('st_date'))?date('Y-m-01'):get_ymd_format($this->input->post('st_date'));
			$end_date = empty($this->input->post('end_date'))?date('Y-m-t'):get_ymd_format($this->input->post('end_date'));

			$result = $this->db->query("SELECT SUM(o.order_amt) AS reconcile,SUM(o.eta_disburse) AS disburse FROM orders as o WHERE o.createdate >='".$st_date." 00:00:00' AND o.createdate <='".$end_date." 23:59:59'")->row_array();
			$return = array('total_reconcile'=>$result['reconcile'],'total_disburse'=>$result['disburse']);
			echo json_encode($return);
		}
	}

/*	public function topLicensee(){
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
			$st_date = empty($this->input->post('st_date'))?date('Y-m-01'):get_ymd_format($this->input->post('st_date'));
			$end_date = empty($this->input->post('end_date'))?date('Y-m-t'):get_ymd_format($this->input->post('end_date'));
			
			$where = "`createdate`>='".$st_date."' AND `createdate`< ='".$end_date."'";
			$query = "SELECT user.user_id,user.createdby AS ia,order_amt,total_amt FROM `orders` JOIN `user` ON `user`.user_id = `orders`.`createdby` WHERE ".$where." ORDER BY `order_amt` DESC LIMIT 5";
			//=== now get lic of ia and generate table

	        $datatables = new Datatables(new CodeigniterAdapter);
			$datatables->query($query);
			$datatables->edit('busrev_duedate', function ($data) {
    			return date('m/d/Y',strtotime($data['busrev_duedate']));
    		});

			$return = array('total_reconcile'=>1000,'total_disburse'=>1500);
			echo json_encode($return);
		}		
	}*/

	public function get_expiring_licensee(){
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
	        
			if($this->input->post('filter')){
				$st_date = empty($this->input->post('st_date'))?date('Y-m-01'):get_ymd_format($this->input->post('st_date'));
				$end_date = empty($this->input->post('end_date'))?date('Y-m-t'):get_ymd_format($this->input->post('end_date'));

				$where = "l.status='1' AND u.status='1' AND lic_enddate >= '".$st_date." 00:00:00' AND lic_enddate <= '".$end_date." 23:59:59'";
			}else{
				$twomonthLater = date('Y-m-d',strtotime('+2 months'));
				$where = "l.status='1' AND u.status='1' AND lic_enddate <= '".$twomonthLater."'";
			}


	        $datatables = new Datatables(new CodeigniterAdapter);
			$datatables->query('SELECT CONCAT_WS(" ", u.firstname,u.lastname) AS username,l.lic_enddate,u.user_id FROM licensee as l LEFT JOIN user as u ON u.user_id = l.user_id WHERE '.$where);
			
			$datatables->edit('lic_enddate', function ($data) {
                $lic_enddate = gmdate_to_mydate($data['lic_enddate'],$this->localtimzone);
                return date('m/d/Y',strtotime($lic_enddate));
    		});

	        $datatables->edit('user_id', function($data){

	    		$menu='';
				$menu.='<li>
	            <a target="_blank" href="'.site_url('licensee/licenseedetail/').encoding($data['user_id']).'">
	                <span class="glyphicon glyphicon-eye-open"></span> View
	            </a>
	        	</li>';	  
	        	return '<div class="dropdown"><button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
	                    <i class="glyphicon glyphicon-option-vertical"></i>
	                </button>
	                <ul class="dropdown-menu">
	                '.$menu.'    
	                </ul></div>';
	        });
        	echo $datatables->generate();		
		}
	}

	public function upcoming_abrs(){
		$user_id = $this->userdata['user_id'];
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
	        
			if($this->input->post('filter')){
				$st_date = empty($this->input->post('st_date'))?date('Y-m-01'):get_ymd_format($this->input->post('st_date'));
				$end_date = empty($this->input->post('end_date'))?date('Y-m-t'):get_ymd_format($this->input->post('end_date'));

				// $where = "lbrv.busrev_type ='ABR' AND u.status='1' AND l.status='1' AND lbrv.busrev_duedate >= '".$st_date." 00:00:00' AND lbrv.busrev_duedate <= '".$end_date." 23:59:59'";

			
		        	if($this->userdata['dept_id']==5 || $this->userdata['dept_id']==4){

		        		$where = "lbrv.busrev_type ='ABR' AND u.status='1' AND l.status='1' AND lbrv.busrev_duedate >= '".$st_date." 00:00:00' AND lbrv.busrev_duedate <= '".$end_date." 23:59:59' AND u.user_id = '".$user_id."'";
		        	}else{

		        		$where = "lbrv.busrev_type ='ABR' AND u.status='1' AND l.status='1' AND lbrv.busrev_duedate >= '".$st_date." 00:00:00' AND lbrv.busrev_duedate <= '".$end_date." 23:59:59'";
		        	}
		        

			}else{
				$twoweekLater = date('Y-m-d',strtotime('+2 weeks'));

			
		        	if($this->userdata['dept_id']==5 || $this->userdata['dept_id']==4){

		        		$where = "lbrv.busrev_type ='ABR' AND u.status='1' AND l.status='1' AND lbrv.busrev_duedate >= '".date('Y-m-d')."'  AND lbrv.busrev_duedate <= '".$twoweekLater."' AND u.user_id = '".$user_id."'";
		        	}else{

		        		$where = "lbrv.busrev_type ='ABR' AND u.status='1' AND l.status='1' AND lbrv.busrev_duedate >= '".date('Y-m-d')."'  AND lbrv.busrev_duedate <= '".$twoweekLater."'";
		        	}
		        
				// $where = "lbrv.busrev_type ='ABR' AND u.status='1' AND l.status='1' AND lbrv.busrev_duedate >= '".date('Y-m-d')."'  AND lbrv.busrev_duedate <= '".$twoweekLater."'";
			}

			if($this->userdata['urole_id']==1){
	        	if($this->userdata['dept_id']==5 || $this->userdata['dept_id']==4){
	        		$query='SELECT CONCAT_WS(" ", u.firstname,u.lastname) AS username,lbrv.busrev_duedate,lbrv.busrev_id FROM licbusinessreview as lbrv LEFT JOIN licensee as l ON l.lic_id = lbrv.lic_id LEFT JOIN licensee as k ON k.user_id = l.user_id LEFT JOIN user as u ON u.user_id = k.assign_to WHERE '.$where;
	        	}else if($this->userdata['dept_id']==4){
	        		$query='SELECT CONCAT_WS(" ", u.firstname,u.lastname) AS username,lbrv.busrev_duedate,lbrv.busrev_id FROM licbusinessreview as lbrv LEFT JOIN licensee as l ON l.lic_id = lbrv.lic_id LEFT JOIN licensee as k ON k.user_id = l.user_id LEFT JOIN user as c ON c.user_id = k.assign_to LEFT JOIN user as u ON u.user_id =c.assign_to WHERE '.$where;
	        	}else{

	        	$query='SELECT CONCAT_WS(" ", u.firstname,u.lastname) AS username,lbrv.busrev_duedate,lbrv.busrev_id FROM licbusinessreview as lbrv LEFT JOIN licensee as l ON l.lic_id = lbrv.lic_id LEFT JOIN user as u ON u.user_id = l.user_id WHERE '.$where;
	        	}
	        }
			if($this->userdata['urole_id']==2){	        
				if($this->userdata['dept_id']==5 || $this->userdata['dept_id']==4){

					$query='SELECT CONCAT_WS(" ", u.firstname,u.lastname) AS username,lbrv.busrev_duedate,lbrv.busrev_id FROM iabusinessreview as lbrv LEFT JOIN indassociation as l ON l.ia_id = lbrv.ia_id LEFT JOIN indassociation as k ON k.user_id = l.user_id LEFT JOIN user as u ON u.user_id = k.assign_to WHERE '.$where;
				}else if($this->userdata['dept_id']==4){
	        		$query='SELECT CONCAT_WS(" ", u.firstname,u.lastname) AS username,lbrv.busrev_duedate,lbrv.busrev_id FROM iabusinessreview as lbrv LEFT JOIN indassociation as l ON l.ia_id = lbrv.ia_id LEFT JOIN indassociation as k ON k.user_id = l.user_id LEFT JOIN user as c ON c.user_id = k.assign_to LEFT JOIN user as u ON u.user_id =c.assign_to WHERE '.$where;
	        	}else{

					$query='SELECT CONCAT_WS(" ", u.firstname,u.lastname) AS username,lbrv.busrev_duedate,lbrv.busrev_id FROM iabusinessreview as lbrv LEFT JOIN indassociation as l ON l.ia_id = lbrv.ia_id LEFT JOIN user as u ON u.user_id = l.user_id WHERE '.$where;
				}
			}
			// $query='SELECT CONCAT_WS(" ", u.firstname,u.lastname) AS username,lbrv.busrev_duedate,lbrv.busrev_id FROM licbusinessreview as lbrv LEFT JOIN licensee as l ON l.lic_id = lbrv.lic_id LEFT JOIN user as u ON u.user_id = l.user_id WHERE '.$where;
			//echo $query; exit;

	        $datatables = new Datatables(new CodeigniterAdapter);
			$datatables->query($query);
			
			$datatables->edit('busrev_duedate', function ($data) {
    			return date('m/d/Y',strtotime($data['busrev_duedate']));
    		});

	        $datatables->edit('busrev_id', function($data){

	    		$menu='';
				$menu.='<li>
	            <a target="_blank" href="'.site_url('business_review/licbusiness_detail/').encoding($data['busrev_id']).'">
	                <span class="glyphicon glyphicon-eye-open"></span> View
	            </a>
	        	</li>';	  
	        	return '<div class="dropdown"><button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
	                    <i class="glyphicon glyphicon-option-vertical"></i>
	                </button>
	                <ul class="dropdown-menu">
	                '.$menu.'    
	                </ul></div>';
	        });
        	echo $datatables->generate();		
		}
	}


	public function upcoming_mbrs(){
		$user_id = $this->userdata['user_id'];
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
	        
			if($this->input->post('filter')){
				$st_date = empty($this->input->post('st_date'))?date('Y-m-01'):get_ymd_format($this->input->post('st_date'));
				$end_date = empty($this->input->post('end_date'))?date('Y-m-t'):get_ymd_format($this->input->post('end_date'));

		        	if($this->userdata['dept_id']==5 || $this->userdata['dept_id']==4){

		        		$where = "lbrv.busrev_type ='MBR' AND u.status='1' AND l.status='1' AND lbrv.busrev_duedate >= '".$st_date." 00:00:00' AND lbrv.busrev_duedate <= '".$end_date." 23:59:59' AND u.user_id = '".$user_id."'";
		        	}else{

		        		$where = "lbrv.busrev_type ='MBR' AND u.status='1' AND l.status='1' AND lbrv.busrev_duedate >= '".$st_date." 00:00:00' AND lbrv.busrev_duedate <= '".$end_date." 23:59:59'";
		        	}
		     

			}else{
				$twoweekLater = date('Y-m-d',strtotime('+2 weeks'));

				
		        	if($this->userdata['dept_id']==5 || $this->userdata['dept_id']==4){

		        		$where = "lbrv.busrev_type ='MBR' AND u.status='1' AND l.status='1' AND lbrv.busrev_duedate >= '".date('Y-m-d')."'  AND lbrv.busrev_duedate <= '".$twoweekLater."' AND u.user_id = '".$user_id."'";
		        	}else{

		        		$where = "lbrv.busrev_type ='MBR' AND u.status='1' AND l.status='1' AND lbrv.busrev_duedate >= '".date('Y-m-d')."'  AND lbrv.busrev_duedate <= '".$twoweekLater."'";
		        	}
		       
				// $where = "lbrv.busrev_type ='MBR' AND u.status='1' AND l.status='1' AND lbrv.busrev_duedate >= '".date('Y-m-d')."'  AND lbrv.busrev_duedate <= '".$twoweekLater."'";
			}

	        $datatables = new Datatables(new CodeigniterAdapter);

	        if($this->userdata['urole_id']==1){
	        	if($this->userdata['dept_id']==5 || $this->userdata['dept_id']==4){
	        		$datatables->query('SELECT CONCAT_WS(" ", u.firstname,u.lastname) AS username,lbrv.busrev_duedate,lbrv.busrev_id FROM licbusinessreview as lbrv LEFT JOIN licensee as l ON l.lic_id = lbrv.lic_id LEFT JOIN licensee as k ON k.user_id = l.user_id LEFT JOIN user as u ON u.user_id = k.assign_to WHERE '.$where);
	        	}else if($this->userdata['dept_id']==4){
	        		$datatables->query('SELECT CONCAT_WS(" ", u.firstname,u.lastname) AS username,lbrv.busrev_duedate,lbrv.busrev_id FROM licbusinessreview as lbrv LEFT JOIN licensee as l ON l.lic_id = lbrv.lic_id LEFT JOIN licensee as k ON k.user_id = l.user_id LEFT JOIN user as c ON c.user_id = k.assign_to LEFT JOIN user as u ON u.user_id =c.assign_to WHERE '.$where);
	        	}else{

	        	$datatables->query('SELECT CONCAT_WS(" ", u.firstname,u.lastname) AS username,lbrv.busrev_duedate,lbrv.busrev_id FROM licbusinessreview as lbrv LEFT JOIN licensee as l ON l.lic_id = lbrv.lic_id LEFT JOIN user as u ON u.user_id = l.user_id WHERE '.$where);
	        	}
	        }
			if($this->userdata['urole_id']==2){	        
				if($this->userdata['dept_id']==5 || $this->userdata['dept_id']==4){

					$datatables->query('SELECT CONCAT_WS(" ", u.firstname,u.lastname) AS username,lbrv.busrev_duedate,lbrv.busrev_id FROM iabusinessreview as lbrv LEFT JOIN indassociation as l ON l.ia_id = lbrv.ia_id LEFT JOIN indassociation as k ON k.user_id = l.user_id LEFT JOIN user as u ON u.user_id = k.assign_to WHERE '.$where);
				}else if($this->userdata['dept_id']==4){
	        		$datatables->query('SELECT CONCAT_WS(" ", u.firstname,u.lastname) AS username,lbrv.busrev_duedate,lbrv.busrev_id FROM iabusinessreview as lbrv LEFT JOIN indassociation as l ON l.ia_id = lbrv.ia_id LEFT JOIN indassociation as k ON k.user_id = l.user_id LEFT JOIN user as c ON c.user_id = k.assign_to LEFT JOIN user as u ON u.user_id =c.assign_to WHERE '.$where);
	        	}else{

					$datatables->query('SELECT CONCAT_WS(" ", u.firstname,u.lastname) AS username,lbrv.busrev_duedate,lbrv.busrev_id FROM iabusinessreview as lbrv LEFT JOIN indassociation as l ON l.ia_id = lbrv.ia_id LEFT JOIN user as u ON u.user_id = l.user_id WHERE '.$where);
				}
			}

			// $datatables->query('SELECT CONCAT_WS(" ", u.firstname,u.lastname) AS username,lbrv.busrev_duedate,lbrv.busrev_id FROM licbusinessreview as lbrv LEFT JOIN licensee as l ON l.lic_id = lbrv.lic_id LEFT JOIN user as u ON u.user_id = l.user_id WHERE '.$where);
			
			$datatables->edit('busrev_duedate', function ($data) {
    			return date('m/d/Y',strtotime($data['busrev_duedate']));
    		});

	        $datatables->edit('busrev_id', function($data){

	    		$menu='';
				$menu.='<li>
	            <a target="_blank" href="'.site_url('business_review/licbusiness_detail/').encoding($data['busrev_id']).'">
	                <span class="glyphicon glyphicon-eye-open"></span> View
	            </a>
	        	</li>';	  
	        	return '<div class="dropdown"><button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
	                    <i class="glyphicon glyphicon-option-vertical"></i>
	                </button>
	                <ul class="dropdown-menu">
	                '.$menu.'    
	                </ul></div>';
	        });
        	echo $datatables->generate();		
		}
	}


	public function upcoming_qbrs(){
		$user_id = $this->userdata['user_id'];
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){

			if($this->input->post('filter')){
				$st_date = empty($this->input->post('st_date'))?date('Y-m-01'):get_ymd_format($this->input->post('st_date'));
				$end_date = empty($this->input->post('end_date'))?date('Y-m-t'):get_ymd_format($this->input->post('end_date'));

				// $where = "lbrv.busrev_type ='QBR' AND u.status='1' AND l.status='1' AND lbrv.busrev_duedate >= '".$st_date." 00:00:00' AND lbrv.busrev_duedate <= '".$end_date." 23:59:59'";
			
		        	if($this->userdata['dept_id']==5 || $this->userdata['dept_id']==4){

		        		$where = "lbrv.busrev_type ='QBR' AND u.status='1' AND l.status='1' AND lbrv.busrev_duedate >= '".$st_date." 00:00:00' AND lbrv.busrev_duedate <= '".$end_date." 23:59:59' AND u.user_id = '".$user_id."'";
		        	}else{

		        		$where = "lbrv.busrev_type ='QBR' AND u.status='1' AND l.status='1' AND lbrv.busrev_duedate >= '".$st_date." 00:00:00' AND lbrv.busrev_duedate <= '".$end_date." 23:59:59'";
		        	}
		     

			}else{
				$twoweekLater = date('Y-m-d',strtotime('+2 weeks'));

				
		        	if($this->userdata['dept_id']==5 || $this->userdata['dept_id']==4){

		        		$where = "lbrv.busrev_type ='QBR' AND u.status='1' AND l.status='1' AND lbrv.busrev_duedate >= '".date('Y-m-d')."'  AND lbrv.busrev_duedate <= '".$twoweekLater."' AND u.user_id = '".$user_id."'";
		        	}else{

		        		$where = "lbrv.busrev_type ='QBR' AND u.status='1' AND l.status='1' AND lbrv.busrev_duedate >= '".date('Y-m-d')."'  AND lbrv.busrev_duedate <= '".$twoweekLater."'";
		        	}
		      
				// $where = "lbrv.busrev_type ='QBR' AND u.status='1' AND l.status='1' AND lbrv.busrev_duedate >= '".date('Y-m-d')."'  AND lbrv.busrev_duedate <= '".$twoweekLater."'";
			}

	        $datatables = new Datatables(new CodeigniterAdapter);

	        if($this->userdata['urole_id']==1){
	        	if($this->userdata['dept_id']==5 || $this->userdata['dept_id']==4){
	        		$datatables->query('SELECT CONCAT_WS(" ", u.firstname,u.lastname) AS username,lbrv.busrev_duedate,lbrv.busrev_id FROM licbusinessreview as lbrv LEFT JOIN licensee as l ON l.lic_id = lbrv.lic_id LEFT JOIN licensee as k ON k.user_id = l.user_id LEFT JOIN user as u ON u.user_id = k.assign_to WHERE '.$where);
	        	}else if($this->userdata['dept_id']==4){
	        		$datatables->query('SELECT CONCAT_WS(" ", u.firstname,u.lastname) AS username,lbrv.busrev_duedate,lbrv.busrev_id FROM licbusinessreview as lbrv LEFT JOIN licensee as l ON l.lic_id = lbrv.lic_id LEFT JOIN licensee as k ON k.user_id = l.user_id LEFT JOIN user as c ON c.user_id = k.assign_to LEFT JOIN user as u ON u.user_id =c.assign_to WHERE '.$where);
	        	}else{

	        	$datatables->query('SELECT CONCAT_WS(" ", u.firstname,u.lastname) AS username,lbrv.busrev_duedate,lbrv.busrev_id FROM licbusinessreview as lbrv LEFT JOIN licensee as l ON l.lic_id = lbrv.lic_id LEFT JOIN user as u ON u.user_id = l.user_id WHERE '.$where);
	        	}
	        }
			if($this->userdata['urole_id']==2){	        
				if($this->userdata['dept_id']==5 || $this->userdata['dept_id']==4){

					$datatables->query('SELECT CONCAT_WS(" ", u.firstname,u.lastname) AS username,lbrv.busrev_duedate,lbrv.busrev_id FROM iabusinessreview as lbrv LEFT JOIN indassociation as l ON l.ia_id = lbrv.ia_id LEFT JOIN indassociation as k ON k.user_id = l.user_id LEFT JOIN user as u ON u.user_id = k.assign_to WHERE '.$where);
				}else if($this->userdata['dept_id']==4){
	        		$datatables->query('SELECT CONCAT_WS(" ", u.firstname,u.lastname) AS username,lbrv.busrev_duedate,lbrv.busrev_id FROM iabusinessreview as lbrv LEFT JOIN indassociation as l ON l.ia_id = lbrv.ia_id LEFT JOIN indassociation as k ON k.user_id = l.user_id LEFT JOIN user as c ON c.user_id = k.assign_to LEFT JOIN user as u ON u.user_id =c.assign_to WHERE '.$where);
	        	}else{

					$datatables->query('SELECT CONCAT_WS(" ", u.firstname,u.lastname) AS username,lbrv.busrev_duedate,lbrv.busrev_id FROM iabusinessreview as lbrv LEFT JOIN indassociation as l ON l.ia_id = lbrv.ia_id LEFT JOIN user as u ON u.user_id = l.user_id WHERE '.$where);
				}
			}
			// $datatables->query('SELECT CONCAT_WS(" ", u.firstname,u.lastname) AS username,lbrv.busrev_duedate,lbrv.busrev_id FROM licbusinessreview as lbrv LEFT JOIN licensee as l ON l.lic_id = lbrv.lic_id LEFT JOIN user as u ON u.user_id = l.user_id WHERE '.$where);
			
			$datatables->edit('busrev_duedate', function ($data) {
    			return date('m/d/Y',strtotime($data['busrev_duedate']));
    		});

	        $datatables->edit('busrev_id', function($data){

	    		$menu='';
				$menu.='<li>
	            <a target="_blank" href="'.site_url('business_review/licbusiness_detail/').encoding($data['busrev_id']).'">
	                <span class="glyphicon glyphicon-eye-open"></span> View
	            </a>
	        	</li>';	  
	        	return '<div class="dropdown"><button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
	                    <i class="glyphicon glyphicon-option-vertical"></i>
	                </button>
	                <ul class="dropdown-menu">
	                '.$menu.'    
	                </ul></div>';
	        });
        	echo $datatables->generate();		
		}
	}

	public function top_suppliers(){
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){

			$st_date = empty($this->input->post('st_date'))?date('Y-m-01'):get_ymd_format($this->input->post('st_date'));
			$end_date = empty($this->input->post('end_date'))?date('Y-m-t'):get_ymd_format($this->input->post('end_date'));
			
			$where = "s.supplier_status='1' AND u.urole_id='5' AND op.createdate >='".$st_date." 00:00:00' AND  op.createdate <= '".$end_date." 23:59:59'";
	        $datatables = new Datatables(new CodeigniterAdapter);
			$datatables->query('SELECT CONCAT_WS(" ",s.supplier_fname,supplier_lname) AS supplier,SUM(`op`.`prod_total`) AS total_amt,SUM(`op`.`prod_qty`) AS total_products,u.user_id
				FROM `orders_product` as op 
				LEFT JOIN `product` as p ON `p`.`prod_id` = `op`.`prod_id`
				LEFT JOIN `supplier` as s ON `s`.`supplier_id` = `p`.`supplier_id`
				LEFT JOIN `user` as u ON `u`.`user_id` = `s`.`user_id`
				WHERE '.$where.'
				GROUP BY `s`.`supplier_id`  
				ORDER BY `op`.`prod_total`  DESC LIMIT 5');

	        $datatables->edit('user_id', function($data){

	    		$menu='';
				$menu.='<li>
	            <a target="_blank" href="'.site_url('supplier/supplierdetail/').encoding($data['user_id']).'">
	                <span class="glyphicon glyphicon-eye-open"></span> View
	            </a>
	        	</li>';	  
	        	return '<div class="dropdown"><button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
	                    <i class="glyphicon glyphicon-option-vertical"></i>
	                </button>
	                <ul class="dropdown-menu">
	                '.$menu.'    
	                </ul></div>';
	        });
        	echo $datatables->generate();		
		}		
	}

	public function top_consumers(){
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){

			$st_date = empty($this->input->post('st_date'))?date('Y-m-01'):get_ymd_format($this->input->post('st_date'));
			$end_date = empty($this->input->post('end_date'))?date('Y-m-t'):get_ymd_format($this->input->post('end_date'));
			
			$where = "u.status='1' AND u.urole_id='4'  AND o.createdate >='".$st_date." 00:00:00' AND o.createdate <= '".$end_date." 23:59:59'";
	        $datatables = new Datatables(new CodeigniterAdapter);
			$datatables->query('SELECT CONCAT_WS(" ",u.firstname,u.lastname) AS username,SUM(`o`.`order_amt`) AS total_amt,SUM(`op`.`prod_qty`) AS total_products,u.user_id
				FROM `orders` as o 
				LEFT JOIN `orders_product` as op ON `op`.`orders_id` = `o`.`orders_id`
				LEFT JOIN `user` as u ON `u`.`user_id` = `o`.`createdby`
				WHERE '.$where.'
				GROUP BY `u`.`user_id`  
				ORDER BY `total_amt`  DESC LIMIT 5');

	        $datatables->edit('user_id', function($data){

	    		$menu='';
				$menu.='<li>
	            <a target="_blank" href="'.site_url('consumer/consumer_detail/').encoding($data['user_id']).'">
	                <span class="glyphicon glyphicon-eye-open"></span> View
	            </a>
	        	</li>';	  
	        	return '<div class="dropdown"><button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
	                    <i class="glyphicon glyphicon-option-vertical"></i>
	                </button>
	                <ul class="dropdown-menu">
	                '.$menu.'    
	                </ul></div>';
	        });
        	echo $datatables->generate();		
		}		
	}

	public function top_ia(){

		if(!empty($this->input->post()) && $this->input->is_ajax_request()){

			$st_date = empty($this->input->post('st_date'))?date('Y-m-01'):get_ymd_format($this->input->post('st_date'));
			$end_date = empty($this->input->post('end_date'))?date('Y-m-t'):get_ymd_format($this->input->post('end_date'));
			
			$where = "u.status='1' AND u.urole_id='3'  AND o.createdate >='".$st_date." 00:00:00' AND o.createdate <= '".$end_date." 23:59:59'";
	        $datatables = new Datatables(new CodeigniterAdapter);
			$datatables->query('SELECT CONCAT_WS(" ",u.firstname,u.lastname) AS username, SUM(o.order_amt) as order_amt,SUM(op.prod_qty) as total_prod,u.user_id FROM `orders` AS o
			LEFT JOIN `user` as u ON u.user_id=o.ia_id
			LEFT JOIN orders_product as op ON op.orders_id=o.orders_id
			WHERE '.$where.'
			GROUP BY o.ia_id
			ORDER BY order_amt DESC LIMIT 5');

	        $datatables->edit('user_id', function($data){
	    		$menu='';
				$menu.='<li>
	            <a target="_blank" href="'.site_url('industryassociation/industryassociation/industryassociation/').encoding($data['user_id']).'">
	                <span class="glyphicon glyphicon-eye-open"></span> View
	            </a>
	        	</li>';	  
	        	return '<div class="dropdown"><button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
	                    <i class="glyphicon glyphicon-option-vertical"></i>
	                </button>
	                <ul class="dropdown-menu">
	                '.$menu.'    
	                </ul></div>';
	        });
        	echo $datatables->generate();		
		}		

	}

	public function top_lic(){
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){

			$st_date = empty($this->input->post('st_date'))?date('Y-m-01'):get_ymd_format($this->input->post('st_date'));
			$end_date = empty($this->input->post('end_date'))?date('Y-m-t'):get_ymd_format($this->input->post('end_date'));
			
			$where = "u.status='1' AND u.urole_id='2' AND o.createdate >='".$st_date." 00:00:00' AND o.createdate <= '".$end_date." 23:59:59'";
	        $datatables = new Datatables(new CodeigniterAdapter);
			$datatables->query('SELECT CONCAT_WS(" ",u.firstname,u.lastname) AS username, SUM(o.order_amt) as order_amt,SUM(op.prod_qty) as total_prod,u.user_id FROM `orders` AS o
			LEFT JOIN `user` as u ON u.user_id=o.lic_id
			LEFT JOIN orders_product as op ON op.orders_id=o.orders_id
			WHERE '.$where.'
			GROUP BY o.lic_id
			ORDER BY order_amt DESC LIMIT 5');

	        $datatables->edit('user_id', function($data){

	    		$menu='';
				$menu.='<li>
	            <a target="_blank" href="'.site_url('licensee/licenseedetail/').encoding($data['user_id']).'">
	                <span class="glyphicon glyphicon-eye-open"></span> View
	            </a>
	        	</li>';	  
	        	return '<div class="dropdown"><button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
	                    <i class="glyphicon glyphicon-option-vertical"></i>
	                </button>
	                <ul class="dropdown-menu">
	                '.$menu.'    
	                </ul></div>';
	        });
        	echo $datatables->generate();		
		}		
	}

	public function sales_per_user(){

		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
			$st_date = empty($this->input->post('st_date'))?date('Y-m-01'):get_ymd_format($this->input->post('st_date'));
			$end_date = empty($this->input->post('end_date'))?date('Y-m-t'):get_ymd_format($this->input->post('end_date'));
			
			$urole_id = $this->userdata['urole_id'];
			$dept_id = $this->userdata['dept_id'];

			$where = "o.createdate >='".$st_date." 00:00:00' AND o.createdate <='".$end_date." 23:59:59'";

			if($urole_id==1){

				$result = $this->db->query("SELECT SUM(o.order_amt) AS c_amt, SUM(o.lic_disburse) AS lic_amt,SUM(o.ia_disburse) AS ia_amt FROM `orders` AS o
				WHERE ".$where)->row_array();

				$labels = array('Licensee','Industry Association','Consumer');
				if(!empty($result['lic_amt'])){ $values[0] =round($result['lic_amt'],2); }else{ $values[0] =0; }
				if(!empty($result['ia_amt'])){  $values[1] =round($result['ia_amt'],2); }else{ $values[1] =0; }
				if(!empty($result['c_amt'])){   $values[2] =round($result['c_amt'],2); }else{ $values[2] =0; }
			}elseif($urole_id==2){
			
				$lid_id = ($dept_id==2)?$this->userdata['user_id']:$this->userdata['createdby'];
				$where .= " AND o.lic_id=".$lid_id;
				$result = $this->db->query("SELECT SUM(o.order_amt) AS c_amt, SUM(o.ia_disburse) AS ia_amt FROM `orders` AS o
				WHERE ".$where)->row_array();

				$labels = array('Industry Association','Consumer');
				$values = array($result['ia_amt'],$result['c_amt']);
			}elseif($urole_id==3){

				$ia_id = ($dept_id==2)?$this->userdata['user_id']:$this->userdata['createdby'];
				$where .= " AND o.ia_id=".$ia_id;
				$result = $this->db->query("SELECT SUM(o.order_amt) AS c_amt FROM `orders` AS o
				WHERE ".$where)->row_array();

				$labels = array('Consumer');
				$values = array($result['c_amt']);				
			}

			$return = array('labels'=>$labels,'values'=>$values);
			echo json_encode($return);
		}
	}

	public function reconciliation(){

		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
			$st_date = empty($this->input->post('st_date'))?date('Y-m-01'):get_ymd_format($this->input->post('st_date'));
			$end_date = empty($this->input->post('end_date'))?date('Y-m-t'):get_ymd_format($this->input->post('end_date'));

			$where = "o.createdate >='".$st_date." 00:00:00' AND o.createdate <='".$end_date." 23:59:59'";

			$urole_id = $this->userdata['urole_id'];


			if($urole_id==1){

				$query = "SELECT o.lic_id,o.ia_id,CONCAT_WS(' ',u.firstname,u.lastname) AS consumer_name,b.business_name,
				pc.prod_cat_name AS category,p.product_name,p.type,SUM(op.prod_qty) AS total_orders ,SUM(op.prod_total) AS prod_total_amt,
				o.orders_id
				FROM `orders` as o
				LEFT JOIN orders_product as op ON `o`.`orders_id`= `op`.`orders_id` 
				LEFT JOIN product as p ON `op`.`prod_id`= `p`.`prod_id`
				LEFT JOIN product_category as pc ON `pc`.`prod_cat_id`= `p`.`prod_cat_id` 
				LEFT JOIN supplier as s ON `s`.`supplier_id`= `p`.`supplier_id` 
				LEFT JOIN business as b ON `s`.`business_id`= `b`.`business_id` 
				LEFT JOIN user as u ON `u`.`user_id`= `o`.`createdby` 
				WHERE ".$where."
				GROUP BY `op`.`prod_id`,`o`.`createdby`
				ORDER BY prod_total_amt";


				$datatables = new Datatables(new CodeigniterAdapter);

				$datatables->query($query);
				
				
				$datatables->edit('lic_id', function ($data){
					$licData =  $this->generalmodel->getlicdata($data['lic_id']);

					// echo $this->db->last_query();
					// print_r($licData);
					if(!empty($licData)){
						return $licData['business_name'];
					}else{
						return '';
					}
				});

				$datatables->edit('ia_id', function ($data){
					$iaData =  $this->generalmodel->get_iadata($data['ia_id']);

					// 					echo $this->db->last_query();
					// print_r($iaData);

					if(!empty($iaData)){
						return $iaData['business_name'];
					}else{
						return '';
					}				
				});

		        $datatables->edit('prod_total_amt', function ($data) {
		            return numfmt_format_currency($this->fmt,$data['prod_total_amt'], "USD").' USD';
		        });			

			}elseif($urole_id==2){

				$lic=$this->userdata['createdby'];
				$where .= " AND o.`lic_id` =".$lic;

				$query = "SELECT o.ia_id,CONCAT_WS(' ',u.firstname,u.lastname) AS consumer_name,b.business_name,
				pc.prod_cat_name AS category,p.product_name,p.type,SUM(op.prod_qty) AS total_orders,SUM(op.prod_total) AS prod_total_amt

				FROM `orders` as o
				LEFT JOIN orders_product as op ON `o`.`orders_id`= `op`.`orders_id` 
				LEFT JOIN product as p ON `op`.`prod_id`= `p`.`prod_id`
				LEFT JOIN product_category as pc ON `pc`.`prod_cat_id`= `p`.`prod_cat_id` 
				LEFT JOIN supplier as s ON `s`.`supplier_id`= `p`.`supplier_id` 
				LEFT JOIN business as b ON `s`.`business_id`= `b`.`business_id` 		
				LEFT JOIN user as u ON `u`.`user_id`= `o`.`createdby`
				WHERE ".$where."
				GROUP BY `op`.`prod_id`,`o`.`createdby`
				ORDER BY prod_total_amt";


				$datatables = new Datatables(new CodeigniterAdapter);

				$datatables->query($query);

				$datatables->edit('ia_id', function ($data){
					$lic_ia_detail =  $this->generalmodel->get_iadata($data['ia_id']);
					return $lic_ia_detail['business_name'];
				});


		        $datatables->edit('prod_total_amt', function ($data) {
		            return numfmt_format_currency($this->fmt,$data['prod_total_amt'], "USD");
		        });

			}elseif($urole_id==3){

				$ia =$this->userdata['createdby'];

				$where .= " AND o.`ia_id`=".$ia;
				$query = "SELECT CONCAT_WS(' ',u.firstname,u.lastname) AS consumer_name,b.business_name,
				pc.prod_cat_name AS category,p.product_name,p.type,SUM(op.prod_qty) AS total_orders,SUM(op.prod_total) AS prod_total_amt,
				o.orders_id
				FROM `orders` as o
				LEFT JOIN orders_product as op ON `o`.`orders_id`= `op`.`orders_id` 
				LEFT JOIN product as p ON `op`.`prod_id`= `p`.`prod_id`
				LEFT JOIN product_category as pc ON `pc`.`prod_cat_id`= `p`.`prod_cat_id` 
				LEFT JOIN supplier as s ON `s`.`supplier_id`= `p`.`supplier_id` 
				LEFT JOIN business as b ON `s`.`business_id`= `b`.`business_id` 				
				LEFT JOIN user as u ON `u`.`user_id`= `o`.`createdby`
				WHERE ".$where."
				GROUP BY `op`.`prod_id`,`o`.`createdby`
				ORDER BY prod_total_amt";



				$datatables = new Datatables(new CodeigniterAdapter);

				$datatables->query($query);

				$datatables->edit('prod_total_amt', function ($data) {
		            return numfmt_format_currency($this->fmt,$data['prod_total_amt'], "USD").' USD';
		        });

			}

			echo $datatables->generate();
		}
	
	}

	public function lic_disburse(){

		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
			$st_date = empty($this->input->post('st_date'))?date('Y-m-01'):get_ymd_format($this->input->post('st_date'));
			$end_date = empty($this->input->post('end_date'))?date('Y-m-t'):get_ymd_format($this->input->post('end_date'));

			$where = "o.createdate >='".$st_date." 00:00:00' AND o.createdate <='".$end_date." 23:59:59'";

			$urole_id = $this->userdata['urole_id'];
			$user_id = $this->userdata['user_id'];


			
			$where .= " AND u.urole_id =2"; 
				
			if($urole_id==2){
				$where .= " AND o.lic_id=".$user_id ;

			}elseif($urole_id==3){
				$where .= " AND o.ia_id=".$user_id ;
			}

				$query = "SELECT DATE_FORMAT(`o`.`createdate`, '%m-%Y') AS title,u.resource_id,
				CONCAT_WS(' ',u.firstname,u.lastname) AS username,b.business_name,
				COUNT(`o`.`orders_id`) AS total_orders,SUM(o.total_amt) AS total_amount,
				SUM(o.lic_disburse) AS total_eta_dis,d.status,DATE_FORMAT(d.updatedate, '%m/%d/%Y') AS modi,o.lic_id
				FROM `orders` AS o
				LEFT JOIN user AS u ON u.user_id= o.lic_id
				LEFT JOIN licensee AS l ON l.user_id= u.user_id
				LEFT JOIN business AS b ON b.business_id= l.business_id
	            LEFT JOIN lic_disburse_status as d ON ( d.lic_id=o.lic_id AND d.dis_title= DATE_FORMAT(`o`.`createdate`, '%m-%Y'))
	            WHERE $where
				GROUP BY o.lic_id, MONTH(o.createdate), YEAR(o.createdate) DESC  
				ORDER BY u.resource_id ASC,`title`ASC";


				$datatables = new Datatables(new CodeigniterAdapter);

				$datatables->query($query);
				
				$datatables->edit('modi', function ($data) {
					if(!empty($data['modi'])){
						$modi = gmdate_to_mydate($data['modi'],$this->localtimzone);
						return date('m/d/Y',strtotime($modi));
					}else{
						return '';
					}
		        });


		        $datatables->edit('total_amount', function ($data) {
		            return numfmt_format_currency($this->fmt,$data['total_amount'], "USD");
		        });

		        $datatables->edit('total_eta_dis', function ($data) {
		            return numfmt_format_currency($this->fmt,$data['total_eta_dis'], "USD");
		        });

		        $datatables->edit('status', function ($data) {
		            if($data['status']==1){ return 'Paid'; }else{ return 'Unpaid'; }
		        });	



			echo $datatables->generate();
		}
	}

	public function ia_disburse(){

		if(!empty($this->input->post()) && $this->input->is_ajax_request()){

			$st_date = empty($this->input->post('st_date'))?date('Y-m-01'):get_ymd_format($this->input->post('st_date'));
			$end_date = empty($this->input->post('end_date'))?date('Y-m-t'):get_ymd_format($this->input->post('end_date'));

			$where = " o.createdate >='".$st_date." 00:00:00' AND o.createdate <='".$end_date." 23:59:59'";

			$urole_id = $this->userdata['urole_id'];
			$user_id = $this->userdata['user_id'];


			$where .= " AND u.urole_id=3 ";

			if($urole_id==2){
				$where .= " AND o.lic_id=".$user_id ;

			}elseif($urole_id==3){
				$where .= " AND o.ia_id=".$user_id ;
			}


			$query = "SELECT DATE_FORMAT(`o`.`createdate`, '%m-%Y') AS title,u.resource_id,
			CONCAT_WS(' ',u.firstname,u.lastname) AS username,b.business_name,
			COUNT(`o`.`orders_id`) AS total_orders,SUM(o.total_amt) AS total_amount,
			SUM(o.ia_disburse) AS total_eta_dis,d.status,DATE_FORMAT(d.updatedate, '%m/%d/%Y') AS modi,o.ia_id
			FROM `orders` AS o
			LEFT JOIN user AS u ON u.user_id= o.ia_id
			LEFT JOIN indassociation AS ia ON ia.user_id= u.user_id
			LEFT JOIN business AS b ON b.business_id= ia.business_id
            LEFT JOIN ia_disburse_status as d ON ( d.ia_id=o.ia_id AND d.dis_title= DATE_FORMAT(`o`.`createdate`, '%m-%Y'))
            WHERE $where
			GROUP BY o.ia_id, MONTH(o.createdate), YEAR(o.createdate) DESC  
			ORDER BY `title` ASC";


			$datatables = new Datatables(new CodeigniterAdapter);
			$datatables->query($query);
			
			$datatables->edit('modi', function ($data) {
				if(!empty($data['modi'])){
					$modi = gmdate_to_mydate($data['modi'],$this->localtimzone);
					return date('m/d/Y',strtotime($modi));
				}else{
					return '';
				}
			});	
		
			$datatables->edit('total_amount', function ($data) {
	            return numfmt_format_currency($this->fmt,$data['total_amount'], "USD");
	        });

	        $datatables->edit('total_eta_dis', function ($data) {
	            return numfmt_format_currency($this->fmt,$data['total_eta_dis'], "USD");
	        });

	        $datatables->edit('status', function ($data) {
	            if($data['status']==1){ return 'Paid'; }else{ return 'Unpaid'; }
	        });	

			echo $datatables->generate();

		}
	}

}
