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
		}elseif($urole_id==4){
			redirect('shop');
		}elseif($urole_id==5){
			redirect('audit/audit');
		}
	}

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

	public function pending_audit(){
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
			$st_date = empty($this->input->post('st_date'))?date('Y-m-01'):get_ymd_format($this->input->post('st_date'));
			$end_date = empty($this->input->post('end_date'))?date('Y-m-t'):get_ymd_format($this->input->post('end_date'));
			
			$where = "`au`.`status`IN('0','1')  AND `au`.`createdate`>='".$st_date."' AND `au`.`createdate`<='".$end_date."'";
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


	public function producbycat(){
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
			$st_date = empty($this->input->post('st_date'))?date('Y-m-01'):get_ymd_format($this->input->post('st_date'));
			$end_date = empty($this->input->post('end_date'))?date('Y-m-t'):get_ymd_format($this->input->post('end_date'));
			

			// $prod_cat_list = $this->generalmodel->prod_cat_list();
			// $prod_cat = array_column($prod_cat_list, 'prod_cat_name');

			$where = "op.createdate >='".$st_date."' AND op.createdate <='".$end_date."'";
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

			$result = $this->db->query("SELECT SUM(o.order_amt) AS reconcile,SUM(o.eta_disburse) AS disburse FROM orders as o WHERE o.createdate >='".$st_date."' AND o.createdate <='".$end_date."'")->row_array();
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

				$where = "l.status='1' AND u.status='1' AND lic_enddate >= '".$st_date."' AND lic_enddate <= '".$end_date."'";
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
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
	        
			if($this->input->post('filter')){
				$st_date = empty($this->input->post('st_date'))?date('Y-m-01'):get_ymd_format($this->input->post('st_date'));
				$end_date = empty($this->input->post('end_date'))?date('Y-m-t'):get_ymd_format($this->input->post('end_date'));

				$where = "lbrv.busrev_type ='ABR' AND u.status='1' AND l.status='1' AND lbrv.busrev_duedate >= '".$st_date."' AND lbrv.busrev_duedate <= '".$end_date."'";

			}else{
				$twoweekLater = date('Y-m-d',strtotime('+2 weeks'));
				$where = "lbrv.busrev_type ='ABR' AND u.status='1' AND l.status='1' AND lbrv.busrev_duedate >= '".date('Y-m-d')."'  AND lbrv.busrev_duedate <= '".$twoweekLater."'";
			}

			$query='SELECT CONCAT_WS(" ", u.firstname,u.lastname) AS username,lbrv.busrev_duedate,lbrv.busrev_id FROM licbusinessreview as lbrv LEFT JOIN licensee as l ON l.lic_id = lbrv.lic_id LEFT JOIN user as u ON u.user_id = l.user_id WHERE '.$where;
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
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
	        
			if($this->input->post('filter')){
				$st_date = empty($this->input->post('st_date'))?date('Y-m-01'):get_ymd_format($this->input->post('st_date'));
				$end_date = empty($this->input->post('end_date'))?date('Y-m-t'):get_ymd_format($this->input->post('end_date'));

				$where = "lbrv.busrev_type ='MBR' AND u.status='1' AND l.status='1' AND lbrv.busrev_duedate >= '".$st_date."' AND lbrv.busrev_duedate <= '".$end_date."'";

			}else{
				$twoweekLater = date('Y-m-d',strtotime('+2 weeks'));
				$where = "lbrv.busrev_type ='MBR' AND u.status='1' AND l.status='1' AND lbrv.busrev_duedate >= '".date('Y-m-d')."'  AND lbrv.busrev_duedate <= '".$twoweekLater."'";
			}

	        $datatables = new Datatables(new CodeigniterAdapter);
			$datatables->query('SELECT CONCAT_WS(" ", u.firstname,u.lastname) AS username,lbrv.busrev_duedate,lbrv.busrev_id FROM licbusinessreview as lbrv LEFT JOIN licensee as l ON l.lic_id = lbrv.lic_id LEFT JOIN user as u ON u.user_id = l.user_id WHERE '.$where);
			
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
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){

			if($this->input->post('filter')){
				$st_date = empty($this->input->post('st_date'))?date('Y-m-01'):get_ymd_format($this->input->post('st_date'));
				$end_date = empty($this->input->post('end_date'))?date('Y-m-t'):get_ymd_format($this->input->post('end_date'));

				$where = "lbrv.busrev_type ='QBR' AND u.status='1' AND l.status='1' AND lbrv.busrev_duedate >= '".$st_date."' AND lbrv.busrev_duedate <= '".$end_date."'";

			}else{
				$twoweekLater = date('Y-m-d',strtotime('+2 weeks'));
				$where = "lbrv.busrev_type ='QBR' AND u.status='1' AND l.status='1' AND lbrv.busrev_duedate >= '".date('Y-m-d')."'  AND lbrv.busrev_duedate <= '".$twoweekLater."'";
			}

	        $datatables = new Datatables(new CodeigniterAdapter);
			$datatables->query('SELECT CONCAT_WS(" ", u.firstname,u.lastname) AS username,lbrv.busrev_duedate,lbrv.busrev_id FROM licbusinessreview as lbrv LEFT JOIN licensee as l ON l.lic_id = lbrv.lic_id LEFT JOIN user as u ON u.user_id = l.user_id WHERE '.$where);
			
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
			
			$where = "s.supplier_status='1' AND u.urole_id='5' AND op.createdate >='".$st_date."' AND  op.createdate <= '".$end_date."'";
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
			
			$where = "u.status='1' AND u.urole_id='4'  AND o.createdate >='".$st_date." 00:00:00' AND o.createdate <= '".$end_date." 11:59:59'";
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
			
			$where = "u.status='1' AND u.urole_id='3'  AND o.createdate >='".$st_date." 00:00:00' AND o.createdate <= '".$end_date." 11:59:59'";
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
			
			$where = "u.status='1' AND u.urole_id='2' AND o.createdate >='".$st_date." 00:00:00' AND o.createdate <= '".$end_date." 11:59:59'";
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
			
			$where = "o.createdate >='".$st_date."' AND o.createdate <='".$end_date."'";
			$result = $this->db->query("SELECT SUM(o.order_amt) AS c_amt, SUM(o.lic_disburse) AS lic_amt,SUM(o.ia_disburse) AS ia_amt FROM `orders` AS o
			WHERE ".$where)->row_array();

			$labels = array('Licensee','Industry Association','Consumer');
			if(!empty($result['lic_amt'])){ $values[0] =round($result['lic_amt'],2); }else{ $values[0] =0; }
			if(!empty($result['ia_amt'])){  $values[1] =round($result['ia_amt'],2); }else{ $values[1] =0; }
			if(!empty($result['c_amt'])){   $values[2] =round($result['c_amt'],2); }else{ $values[2] =0; }
			$return = array('labels'=>$labels,'values'=>$values);
			echo json_encode($return);
		}
	}

}
