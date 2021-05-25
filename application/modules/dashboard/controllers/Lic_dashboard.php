<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;
class Lic_dashboard extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->userdata = $this->session->userdata('userdata');
		$this->uid = $this->userdata['user_id'];
	}
	public function index()
	{
		$st_date = date('Y-m-01');
		$end_date = date('Y-m-t');
		$data['prod_cat_list'] = $this->generalmodel->prod_cat_list();
		$this->load->view('lic_dashboard',$data);
	}

	public function newest_ticket(){ 
		if($this->input->is_ajax_request()){
			$where = "`t`.`user_id`= '".$this->uid."' AND `t`.`status`= '1' AND `t`.`tic_status` ='1'";
			$query = "SELECT t.tic_number,tc.tic_cat_name,t.tic_status,t.tic_id FROM `ticket` AS t  LEFT JOIN `ticket_category` AS tc ON `t`.`tic_cat_id` = `tc`.`tic_cat_id`
			 WHERE ".$where." ORDER BY `tic_createdate` DESC LIMIT 10";
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
	            <a href="">
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
			
			$where = "`t`.`user_id`= '".$this->uid."' AND  `t`.`status`= '1' AND `t`.`tic_status`='1' AND `t`.`tic_createdate`>='".$st_date."' AND `t`.`tic_createdate`<='".$end_date."'";
			$query = "SELECT t.tic_number,tc.tic_cat_name,t.tic_status,t.tic_id FROM `ticket` AS t  LEFT JOIN `ticket_category` AS tc ON `t`.`tic_cat_id` = `tc`.`tic_cat_id`
			 WHERE ".$where." ORDER BY `tic_createdate` DESC";
	        $datatables = new Datatables(new CodeigniterAdapter);
			$datatables->query($query);

	        $datatables->edit('tic_id', function($data){

	    		$menu='';
				$menu.='<li>
	            <a href="">
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
			
			$where = "`au`.`status`!='2' AND `p`.`prod_del`=1 AND `au`.`createdate`>='".$st_date."' AND `au`.`createdate`<='".$end_date."'";
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
	            <a href="">
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
			
			$where = "`ticket`.`user_id`= '".$this->uid."' AND  `ticket`.`status`='1' AND `ticket`.`tic_createdate`>='".$st_date."' AND `ticket`.`tic_createdate`<='".$end_date."'";
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

			$tic_cat_list = $this->generalmodel->ticket_cat_list();
			$tic_cat = array_column($tic_cat_list, 'tic_cat_name');

			if(!empty($tic_cat)){ foreach($tic_cat as $key=>$val){ if($key%2==0){ $tpc_bg[] = '#0A4672'; }else{ $tpc_bg[] = '#8DC63F'; } } }

			$where = "`t`.`user_id`= '".$this->uid."' AND `t`.status =1 AND `t`.tic_createdate >= '".$st_date."' AND `t`.tic_createdate <= '".$end_date."'";
			$query = $this->db->query("SELECT COUNT(`tic_id`) AS counter,tc.tic_cat_name FROM `ticket` AS t LEFT JOIN  ticket_category AS tc ON tc.tic_cat_id = t.tic_cat_id  WHERE ".$where." GROUP BY `t`.`tic_cat_id` ORDER BY `tc`.`tic_cat_name` ASC")->result_array();

			$labels = $tic_cat;
			
			$values = array_column($query, 'counter');
			$return = array('labels'=>$labels,'values'=>$values,'tpc_bg'=>$tpc_bg);
			echo json_encode($return);
		}		
	}

	public function ticket_per_staff(){
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
			$st_date = empty($this->input->post('st_date'))?date('Y-m-01'):get_ymd_format($this->input->post('st_date'));
			$end_date = empty($this->input->post('end_date'))?date('Y-m-t'):get_ymd_format($this->input->post('end_date'));

			$where = "u.urole_id = 2 AND u.createdby='".$this->uid."' AND `t`.status ='1' AND `t`.tic_createdate >= '".$st_date."' AND `t`.tic_createdate <= '".$end_date."'";

			$query = "SELECT d.deptname,COUNT(t.tic_id) AS tcount,u.resource_id,u.user_id FROM `ticket` AS t 
			LEFT JOIN user as u ON t.user_id = u.user_id
			LEFT JOIN `department` as d ON u.dept_id=d.dept_id 
			WHERE ".$where." GROUP BY d.dept_id ORDER BY `resource_id` ASC";
			$result = $this->db->query($query)->result_array();

			$labels = array_column($result, 'deptname') ;
			$values = array_column($result, 'tcount') ;		

			if(!empty($result)){ foreach($result as $key=>$val){ 
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
			
			// $licData = $this->generalmodel->getlicdata($this->uid);
			// $lic_id = $licData['lic_id'];

			$where = "o.lic_id = '".$this->uid."' AND op.createdate >='".$st_date."' AND op.createdate <='".$end_date."'";
			$result = $this->db->query("SELECT SUM(op.prod_qty) AS counter,pc.prod_cat_name
			FROM `orders` AS o
			LEFT JOIN orders_product as op ON o.orders_id= op.orders_id
			LEFT JOIN product as p ON op.prod_id= p.prod_id
			LEFT JOIN product_category as pc ON p.prod_cat_id= pc.prod_cat_id WHERE ".$where."
			GROUP BY pc.prod_cat_id ORDER BY pc.prod_cat_name")->result_array();
			//LEFT JOIN prodassigntolicensee as lic_prod ON p.prod_id= lic_prod.prod_id


			$labels = array_column($result, 'prod_cat_name');
			$values = array_column($result, 'counter');
			$return = array('labels'=>$labels,'values'=>$values);
			echo json_encode($return);
		}
	}	
	public function getAccountData(){
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
			$st_date = empty($this->input->post('st_date'))?date('Y-m-01'):get_ymd_format($this->input->post('st_date'));
			$end_date = empty($this->input->post('end_date'))?date('Y-m-t'):get_ymd_format($this->input->post('end_date'));
			
			$result = $this->db->query("SELECT SUM(o.order_amt) AS reconcile,SUM(o.lic_disburse) AS disburse FROM orders as o WHERE o.lic_id=".$this->uid." AND o.createdate >='".$st_date."' AND o.createdate <='".$end_date."'")->row_array();
			//echo $this->db->last_query();
			$return = array('total_reconcile'=>$result['reconcile'],'total_disburse'=>$result['disburse']);
			echo json_encode($return);
		}
	}

	public function get_expiring_licensee(){
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){

			$st_date = empty($this->input->post('st_date'))?date('Y-m-01'):get_ymd_format($this->input->post('st_date'));
			$end_date = empty($this->input->post('end_date'))?date('Y-m-t'):get_ymd_format($this->input->post('end_date'));
			
			$twomonthLater = date('Y-m-d',strtotime('+2 months'));
			$where = "u.createdby =".$this->uid." AND ia.status='1' AND u.status='1' AND ia_lic_enddate >= '".date('Y-m-d')."' AND  ia_lic_enddate <= '".$twomonthLater."'";
	        $query = 'SELECT CONCAT_WS(" ", u.firstname,u.lastname) AS username,ia.ia_lic_enddate,u.user_id FROM indassociation as ia LEFT JOIN user as u ON u.user_id = ia.user_id WHERE '.$where;
	        
	        $datatables = new Datatables(new CodeigniterAdapter);
			$datatables->query($query);
			
			$datatables->edit('ia_lic_enddate', function ($data) {
    			return date('m/d/Y',strtotime($data['ia_lic_enddate']));
    		});

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

	public function upcoming_abrs(){
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){

			$st_date = empty($this->input->post('st_date'))?date('Y-m-01'):get_ymd_format($this->input->post('st_date'));
			$end_date = empty($this->input->post('end_date'))?date('Y-m-t'):get_ymd_format($this->input->post('end_date'));
			
			$twoweekLater = date('Y-m-d',strtotime('+2 weeks'));
			$where = "lbrv.busrev_type ='ABR' AND u.status='1' AND l.status='1' AND lbrv.busrev_duedate <= '".$twoweekLater."'";
			$query = 'SELECT CONCAT_WS(" ", u.firstname,u.lastname) AS username,lbrv.busrev_duedate,lbrv.busrev_id FROM iabusinessreview as lbrv LEFT JOIN indassociation as l ON l.ia_id = lbrv.ia_id LEFT JOIN user as u ON u.user_id = l.user_id WHERE '.$where;
	        $datatables = new Datatables(new CodeigniterAdapter);
			$datatables->query($query);

			$datatables->edit('busrev_duedate', function ($data) {
    			return date('m/d/Y',strtotime($data['busrev_duedate']));
    		});

	        $datatables->edit('busrev_id', function($data){

	    		$menu='';
				$menu.='<li>
	            <a target="_blank" href="'.site_url('business_review/iabusiness_detail/').encoding($data['busrev_id']).'">
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

			$st_date = empty($this->input->post('st_date'))?date('Y-m-01'):get_ymd_format($this->input->post('st_date'));
			$end_date = empty($this->input->post('end_date'))?date('Y-m-t'):get_ymd_format($this->input->post('end_date'));
			
			$twoweekLater = date('Y-m-d',strtotime('+2 weeks'));
			$where = "lbrv.busrev_type ='MBR' AND u.status='1' AND ia.status='1' AND lbrv.busrev_duedate <= '".$twoweekLater."'";
	        $query = 'SELECT CONCAT_WS(" ", u.firstname,u.lastname) AS username,lbrv.busrev_duedate,lbrv.busrev_id 
	        FROM iabusinessreview as lbrv 
	        LEFT JOIN indassociation as ia ON ia.ia_id = lbrv.ia_id 
	        LEFT JOIN user as u ON u.user_id = ia.user_id 
	        WHERE '.$where;

	        $datatables = new Datatables(new CodeigniterAdapter);
			$datatables->query($query);
			
			$datatables->edit('busrev_duedate', function ($data) {
    			return date('m/d/Y',strtotime($data['busrev_duedate']));
    		});

	        $datatables->edit('busrev_id', function($data){

	    		$menu='';
				$menu.='<li>
	            <a target="_blank" href="'.site_url('business_review/iabusiness_detail/').encoding($data['busrev_id']).'">
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

			$st_date = empty($this->input->post('st_date'))?date('Y-m-01'):get_ymd_format($this->input->post('st_date'));
			$end_date = empty($this->input->post('end_date'))?date('Y-m-t'):get_ymd_format($this->input->post('end_date'));
			
			$twoweekLater = date('Y-m-d',strtotime('+2 weeks'));
			$where = "lbrv.busrev_type ='QBR' AND u.status='1' AND ia.status='1' AND lbrv.busrev_duedate <= '".$twoweekLater."'";
	        
	        $query = 'SELECT CONCAT_WS(" ", u.firstname,u.lastname) AS username,lbrv.busrev_duedate,lbrv.busrev_id
	        FROM iabusinessreview as lbrv 
	        LEFT JOIN indassociation as ia ON ia.ia_id = lbrv.ia_id 
	        LEFT JOIN user as u ON u.user_id = ia.user_id 
	        WHERE '.$where;       

	        $datatables = new Datatables(new CodeigniterAdapter);
			$datatables->query($query);
			
			$datatables->edit('busrev_duedate', function ($data) {
    			return date('m/d/Y',strtotime($data['busrev_duedate']));
    		});

	        $datatables->edit('busrev_id', function($data){

	    		$menu='';
				$menu.='<li>
	            <a target="_blank" href="'.site_url('business_review/iabusiness_detail/').encoding($data['busrev_id']).'">
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
			
			$where = "o.lic_id='".$this->uid."' AND u.urole_id='5'  AND s.supplier_status='1' AND op.createdate >='".$st_date."' AND  op.createdate <= '".$end_date."'";
	        $datatables = new Datatables(new CodeigniterAdapter);
			$datatables->query('SELECT CONCAT_WS(" ",s.supplier_fname,supplier_lname) AS supplier,SUM(`op`.`prod_total`) AS total_amt,SUM(`op`.`prod_qty`) AS total_products,u.user_id
				FROM `orders_product` as op 
				LEFT JOIN `product` as p ON `p`.`prod_id` = `op`.`prod_id`
				LEFT JOIN `supplier` as s ON `s`.`supplier_id` = `p`.`supplier_id`
				LEFT JOIN `user` as u ON `u`.`user_id` = `s`.`user_id`
				LEFT JOIN `orders` as o ON `o`.`orders_id` = `op`.`orders_id`
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
			
			$where = "o.lic_id='".$this->uid."' AND u.urole_id='4' AND u.status='1'  AND o.createdate >='".$st_date." 00:00:00' AND o.createdate <= '".$end_date." 11:59:59'";
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
			
			$where = "o.lic_id='".$this->uid."' AND u.status='1' AND o.createdate >='".$st_date." 00:00:00' AND o.createdate <= '".$end_date." 11:59:59'";
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

	public function sales_per_user(){

		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
			$st_date = empty($this->input->post('st_date'))?date('Y-m-01'):get_ymd_format($this->input->post('st_date'));
			$end_date = empty($this->input->post('end_date'))?date('Y-m-t'):get_ymd_format($this->input->post('end_date'));
			
			$where = "o.lic_id=".$this->uid." AND o.createdate >='".$st_date."' AND o.createdate <='".$end_date."'";
			$result = $this->db->query("SELECT SUM(o.order_amt) AS c_amt, SUM(o.ia_disburse) AS ia_amt FROM `orders` AS o
			WHERE ".$where)->row_array();

			//print_r($result); exit;
			$labels = array('Industry Association','Consumer');
			$values = array($result['ia_amt'],$result['c_amt']);
			$return = array('labels'=>$labels,'values'=>$values);
			echo json_encode($return);
		}
	
	}
	
}
