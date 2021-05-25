<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;
class Dash_ticket extends MY_Controller {

	public function __construct(){
		parent::__construct();
	}
	public function index()
	{

	}

	public function newest_ticket(){

		if($this->input->is_ajax_request()){
            $user_id = $this->userdata['user_id'];
            $perms=explode(",",$this->userdata['upermission']);
            $datatables = new Datatables(new CodeigniterAdapter);

            $where = 'm.status="1"';

            if($this->userdata['dept_id']==2){
                $where .= ' AND u.urole_id='.$this->userdata['urole_id'];                
            }elseif($this->userdata['dept_id']!=2 && $this->userdata['dept_id']!=5){
                $where .= ' AND u.urole_id='.$this->userdata['urole_id'].' AND (m.user_id='.$user_id.' OR FIND_IN_SET('.$user_id.',m.tic_users))';
            }elseif($this->userdata['dept_id']==5){
                $where .= ' AND (( u.urole_id='.$this->userdata['urole_id'].' AND (m.user_id='.$user_id.' OR FIND_IN_SET('.$user_id.',m.tic_users))) OR (m.upper_level='.$user_id.') AND act.tic_activity_type="comment")';


                $query='SELECT m.tic_number,b.tic_cat_name,m.tic_status,m.tic_id
                FROM ticket as m 
                LEFT JOIN ticket_category as b ON m.tic_cat_id = b.tic_cat_id 
                LEFT JOIN user as u ON m.user_id = u.user_id 
                LEFT JOIN ticket_activity as act ON act.tic_id = m.tic_id

                WHERE  '.$where;

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

		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
			$st_date = empty($this->input->post('st_date'))?date('Y-m-01'):get_ymd_format($this->input->post('st_date'));
			$end_date = empty($this->input->post('end_date'))?date('Y-m-t'):get_ymd_format($this->input->post('end_date'));
			

			$where = "`m`.`status`= '1' AND `m`.`tic_status`='1' AND `m`.`tic_createdate`>='".$st_date."' AND `m`.`tic_createdate`<='".$end_date."'";
			

            if($this->userdata['dept_id']==2){
                $where .= ' AND u.urole_id='.$this->userdata['urole_id'];                
            }elseif($this->userdata['dept_id']!=2 && $this->userdata['dept_id']!=5){
                $where .= ' AND u.urole_id='.$this->userdata['urole_id'].' AND (m.user_id='.$user_id.' OR FIND_IN_SET('.$user_id.',m.tic_users))';
            }elseif($this->userdata['dept_id']==5){
                $where .= ' AND (( u.urole_id='.$this->userdata['urole_id'].' AND (m.user_id='.$user_id.' OR FIND_IN_SET('.$user_id.',m.tic_users))) OR (m.upper_level='.$user_id.') AND act.tic_activity_type="comment")';


                $query='SELECT m.tic_number,b.tic_cat_name,m.tic_status,m.tic_id
                FROM ticket as m 
                LEFT JOIN ticket_category as b ON m.tic_cat_id = b.tic_cat_id 
                LEFT JOIN user as u ON m.user_id = u.user_id 
                LEFT JOIN ticket_activity as act ON act.tic_id = m.tic_id

                WHERE  '.$where;

            }


            if($this->userdata['dept_id']!=5){

            	$query='SELECT m.tic_number,b.tic_cat_name,m.tic_status,m.tic_id FROM ticket as m LEFT JOIN ticket_category as b ON m.tic_cat_id = b.tic_cat_id LEFT JOIN user as u ON m.user_id = u.user_id WHERE  '.$where;

            }



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
			
			//$where = "`ticket`.`status`='1' AND `ticket`.`tic_createdate`>='".$st_date."' AND `ticket`.`tic_createdate`<='".$end_date."'";
			
			$where = "`m`.`status`= '1' AND `m`.`tic_status`='1' AND `m`.`tic_createdate`>='".$st_date."' AND `m`.`tic_createdate`<='".$end_date."'";
			

            if($this->userdata['dept_id']==2){
                $where .= ' AND u.urole_id='.$this->userdata['urole_id'];                
            }elseif($this->userdata['dept_id']!=2 && $this->userdata['dept_id']!=5){
                $where .= ' AND u.urole_id='.$this->userdata['urole_id'].' AND (m.user_id='.$user_id.' OR FIND_IN_SET('.$user_id.',m.tic_users))';
            }elseif($this->userdata['dept_id']==5){
                $where .= ' AND (( u.urole_id='.$this->userdata['urole_id'].' AND (m.user_id='.$user_id.' OR FIND_IN_SET('.$user_id.',m.tic_users))) OR (m.upper_level='.$user_id.') AND act.tic_activity_type="comment")';

            }



			// $query = "SELECT COUNT(tic_id) AS total_count,tic_status 
			// FROM `ticket` AS m
			// LEFT JOIN user as u ON m.user_id = u.user_id
			// WHERE ".$where." GROUP BY tic_status";




            if($this->userdata['dept_id']==5){
				
				$query = "SELECT COUNT(tic_id) AS total_count,tic_status 
				FROM `ticket` AS m
				LEFT JOIN user as u ON m.user_id = u.user_id
				LEFT JOIN ticket_activity as act ON act.tic_id = m.tic_id
				WHERE ".$where." GROUP BY tic_status";

            }elseif($this->userdata['dept_id']!=5){

				$query = "SELECT COUNT(tic_id) AS total_count,tic_status 
				FROM `ticket` AS m
				LEFT JOIN user as u ON m.user_id = u.user_id
				WHERE ".$where." GROUP BY tic_status";
            }



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

	public function ticket_per_cat(){

		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
			$st_date = empty($this->input->post('st_date'))?date('Y-m-01'):get_ymd_format($this->input->post('st_date'));
			$end_date = empty($this->input->post('end_date'))?date('Y-m-t'):get_ymd_format($this->input->post('end_date'));
			$tpc_bg = array();
			$labels = $values='';


			$where = "`tc`.`tic_del_status` = '1' AND `tc`.`tic_cat_status` = '1' AND  `m`.`status`= '1' AND `m`.`tic_status`='1' AND `m`.`tic_createdate`>='".$st_date."' AND `m`.`tic_createdate`<='".$end_date."'";
			

            if($this->userdata['dept_id']==2){
                $where .= ' AND u.urole_id='.$this->userdata['urole_id'];                
            }elseif($this->userdata['dept_id']!=2 && $this->userdata['dept_id']!=5){
                $where .= ' AND u.urole_id='.$this->userdata['urole_id'].' AND (m.user_id='.$user_id.' OR FIND_IN_SET('.$user_id.',m.tic_users))';
            }elseif($this->userdata['dept_id']==5){
                $where .= ' AND (( u.urole_id='.$this->userdata['urole_id'].' AND (m.user_id='.$user_id.' OR FIND_IN_SET('.$user_id.',m.tic_users))) OR (m.upper_level='.$user_id.') AND act.tic_activity_type="comment")';

            }

            if($this->userdata['dept_id']==5){
				
				$query = $this->db->query("SELECT COUNT(`tic_id`) AS counter,tc.tic_cat_name 
				FROM `ticket` AS m 
				LEFT JOIN  ticket_category AS tc ON tc.tic_cat_id = m.tic_cat_id  
                LEFT JOIN user as u ON m.user_id = u.user_id 
                LEFT JOIN ticket_activity as act ON act.tic_id = m.tic_id				
				WHERE ".$where." GROUP BY `m`.`tic_cat_id` ORDER BY `tc`.`tic_cat_name` ASC")->result_array();


            }elseif($this->userdata['dept_id']!=5){

				$query = $this->db->query("SELECT COUNT(`tic_id`) AS counter,tc.tic_cat_name 
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


			$where = "`m`.`status`= '1' AND `m`.`tic_status`='1' AND `m`.`tic_createdate`>='".$st_date."' AND `m`.`tic_createdate`<='".$end_date."'";
			

            if($this->userdata['dept_id']==2){
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
			} }

			$return = array('labels'=>$labels,'values'=>$values,'tps_bg'=>$tps_bg);
			echo json_encode($return);
		}	
	}
}
		