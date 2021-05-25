<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH. 'third_party/Spout/Autoloader/autoload.php';
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;

use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use Box\Spout\Common\Entity\Style\CellAlignment;
use Box\Spout\Common\Entity\Style\Color;


use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;

class Reports extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->userdata = $this->session->userdata('userdata');
		$this->no_responce = array('draw'=>1,"recordsTotal"=>0,"recordsFiltered"=>0,"data"=>[]);
		$this->localtimzone =$this->userdata['timezone'];

	}
	
	//**========Consumer purchase report ==============**//
	public function purchase_report(){
		$data['supplier'] = $this->generalmodel->all_suppliers();	
		$data['meta_title'] = 'Purchase Report';
		$this->load->view('reports/consumer_purchase',$data);
	}

	//========datatable==============//
	public function consumer_purchase_data(){
		$cid=$this->session->userdata['customerid'];
		$resource_ids = $this->generalmodel->lic_ia_ofconsumer($cid);
		$title = $resource_ids['lic'].'-'.$resource_ids['ia'];

		$datatables = new Datatables(new CodeigniterAdapter);

		$datatables->query('SELECT o.orders_id, p.product_sku,p.product_name,p.type,CONCAT_WS(" ",`s`.`supplier_fname`,`s`.`supplier_lname`) AS supplierName, SUM(op.prod_qty) AS qty,SUM(op.prod_total) AS amount FROM `orders` as o  
			LEFT JOIN orders_product as op ON op.orders_id = o.orders_id 
			LEFT JOIN product as p ON p.prod_id = op.prod_id 
			LEFT JOIN supplier as s ON s.supplier_id = p.supplier_id 
			WHERE o.createdby= '.$cid.' GROUP BY op.prod_id');

	        $datatables->edit('amount', function ($data) {
	            return numfmt_format_currency($this->fmt,$data['amount'], "USD");
	        });

	        $datatables->edit('orders_id', function($data) use($title){
	            return $title;
	        });
		echo $datatables->generate();
	}
	//========datatable==============//

	//========filter==============//
	public function filter_consumer_purchase(){
		
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
			$supplier = $this->input->post('supplier');
			$st_date = $this->input->post('st_date');
			$end_date = $this->input->post('end_date');
			$cid = $this->session->userdata['customerid'];

			$where = "o.createdby= '".$cid."'";
			if(!empty($supplier)){ $where .= " AND p.supplier_id= '".$supplier."'"; }
			if(!empty($st_date)){
				$start = get_ymd_format($st_date);				
				$where .= " AND o.createdate >= '".$start." 00:00:00'"; 
			}

			if(!empty($end_date)){
				$end = get_ymd_format($end_date);				
				$where .= " AND o.createdate <= '".$end." 23:59:59'"; 
			}

			$query = 'SELECT o.orders_id, p.product_sku,p.product_name,p.type,CONCAT_WS(" ",`s`.`supplier_fname`,`s`.`supplier_lname`) AS supplierName, SUM(op.prod_qty) AS qty,SUM(op.prod_total) AS amount 
				FROM `orders` as o  
				LEFT JOIN orders_product as op ON op.orders_id = o.orders_id 
				LEFT JOIN product as p ON p.prod_id = op.prod_id 
				LEFT JOIN supplier as s ON s.supplier_id = p.supplier_id 
				WHERE '.$where.' GROUP BY op.prod_id';
			$datatables = new Datatables(new CodeigniterAdapter);

			$datatables->query($query);
		        $datatables->edit('amount', function ($data) {
		            return numfmt_format_currency($this->fmt,$data['amount'], "USD");
		        });
			echo $datatables->generate();
		}
	}

	public function filter_consumer_purchase_total(){
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
			$supplier = $this->input->post('supplier');
			$st_date = $this->input->post('st_date');
			$end_date = $this->input->post('end_date');
			$cid = $this->session->userdata['customerid'];
			
			$where = "o.createdby= '".$cid."'";
			if(!empty($supplier)){ $where .= " AND p.supplier_id= '".$supplier."'"; }
			if(!empty($st_date)){
				$start = get_ymd_format($st_date);				
				$where .= " AND o.createdate >= '".$start." 00:00:00'"; 
			}

			if(!empty($end_date)){
				$end = get_ymd_format($end_date);				
				$where .= " AND o.createdate <= '".$end." 23:59:59'"; 
			}

			$query = 'SELECT SUM(op.prod_qty) AS qty,SUM(op.prod_total) AS amount 
				FROM `orders` as o  
				LEFT JOIN orders_product as op ON op.orders_id = o.orders_id 
				LEFT JOIN product as p ON p.prod_id = op.prod_id 
				LEFT JOIN supplier as s ON s.supplier_id = p.supplier_id 
				WHERE '.$where;
			$data = $this->generalmodel->customquery($query,'row_array');

			$data['amount'] = numfmt_format_currency($this->fmt,$data['amount'], "USD");
			echo json_encode($data);
		}
	}
	//========filter==============//


	public function export_consumer_purchase_report(){

		$supplier = $this->input->post('supplier');
		$st_date = $this->input->post('st_date');
		$end_date = $this->input->post('end_date');
		$cid = $this->session->userdata['customerid'];

		$resource_ids = $this->generalmodel->lic_ia_ofconsumer($cid);
		$title = $resource_ids['lic'].'-'.$resource_ids['ia'];

		$where = "o.createdby= '".$cid."'";
		if(!empty($supplier)){ $where .= " AND p.supplier_id= '".$supplier."'"; }
		if(!empty($st_date)){
			$start = get_ymd_format($st_date);				
			$where .= " AND o.createdate >= '".$start." 00:00:00'"; 
		}

		if(!empty($end_date)){
			$end = get_ymd_format($end_date);				
			$where .= " AND o.createdate <= '".$end." 23:59:59'"; 
		}

		$queryy = 'SELECT o.orders_id, p.product_sku,p.product_name,p.type,CONCAT_WS(" ",`s`.`supplier_fname`,`s`.`supplier_lname`) AS supplierName, SUM(op.prod_qty) AS qty,SUM(op.prod_total) AS amount 
			FROM `orders` as o  
			LEFT JOIN orders_product as op ON op.orders_id = o.orders_id 
			LEFT JOIN product as p ON p.prod_id = op.prod_id 
			LEFT JOIN supplier as s ON s.supplier_id = p.supplier_id 
			WHERE '.$where.' GROUP BY op.prod_id';

		$query=$this->db->query($queryy);

        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'consumer_purchase_report-'.date('m-d-Y').'.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser

		$style = (new StyleBuilder())
		           ->setFontBold()
		           ->setFontSize(15)
		           ->setCellAlignment(CellAlignment::CENTER)
		           ->build();

		/** Create a row with cells and apply the style to all cells */
		$singleRow = WriterEntityFactory::createRowFromArray(['','','','Consumer Purchase Report','','',''], $style);
		$blankRow = WriterEntityFactory::createRowFromArray(['','','','','','','']);
		/** Add the row to the writer */
		$writer->addRow($singleRow);
		$writer->addRow($blankRow);

        
		$cellstyle = (new StyleBuilder())
           ->setFontBold()
           ->setFontSize(15)
           ->build();

        $cells = [
                WriterEntityFactory::createCell('Title',$cellstyle),
                WriterEntityFactory::createCell('Product SKU',$cellstyle),
                WriterEntityFactory::createCell('Product Name',$cellstyle),
                WriterEntityFactory::createCell('Product Type',$cellstyle),
                WriterEntityFactory::createCell('Supplier',$cellstyle),
                WriterEntityFactory::createCell('Unit Sold',$cellstyle),
                WriterEntityFactory::createCell('Total Amount',$cellstyle),
        ];

        //=== add a row at a time ===//
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
        if(!empty($obj)){
	        
	        foreach ($obj as $row) {

	            $data[1] = $title;
	            $data[2] = $row['product_sku'];
	            $data[3] = $row['product_name'];
	            $data[4] = $row['type'];
	            $data[5] = $row['supplierName'];
	            $data[6] = $row['qty'];
	            $data[7] = numfmt_format_currency($this->fmt,$row['amount'], "USD");
	            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
	        }
        }
        $writer->close();
	}
	//**========Consumer purchase report ==============**//




	//===========LIC module ia sales report start=========

	public function ia_sales_report(){
		$ia_id=$this->session->userdata['iaid'];
		$data['supplier'] = $this->generalmodel->all_suppliers();	
		$data['consumers'] = $this->generalmodel->consumerList($ia_id);	
		$data['meta_title'] = 'Sales Report';
		$this->load->view('reports/ia_sales',$data);
	}

	public function ia_sales_data(){
		$ia_id=$this->session->userdata['iaid'];
		$datatables = new Datatables(new CodeigniterAdapter);
		
		$where = "op.ia_id= '".$ia_id."'";
		$where .= " AND op.createdate >= '".date('Y-m-01')." 00:00:00'"; 
		$where .= " AND op.createdate <= '".date('Y-m-t')." 23:59:59'"; 

		$query = "SELECT op.ord_prod_id,p.product_name,p.product_sku,p.type,CONCAT_WS(' ',s.supplier_fname,s.supplier_lname) AS supplier_name,
			SUM(op.prod_qty) AS unit_sold , SUM(op.prod_total) as sr_total_amount,
			SUM(op.eta_disburse) as revenue, p.prod_id
			FROM `orders_product` as op 
			LEFT JOIN product as p ON p.prod_id = op.prod_id 
			LEFT JOIN supplier as s ON s.supplier_id = p.supplier_id 
			WHERE ".$where." GROUP BY op.supplier_id";

	    $iadata = $this->generalmodel->get_iadata($ia_id);
		$title = $iadata['username'].'-'.date('M Y');

		$datatables->query($query);

        $datatables->edit('ord_prod_id', function($data) use($title){
            return $title;
        });

        $datatables->edit('sr_total_amount', function ($data) {
            return numfmt_format_currency($this->fmt,$data['sr_total_amount'], "USD");
        });

        $datatables->edit('revenue', function ($data) {
            return numfmt_format_currency($this->fmt,$data['revenue'], "USD");
        });

        $datatables->edit('revenue', function ($data) {
            return numfmt_format_currency($this->fmt,$data['revenue'], "USD");
        });

		$datatables->edit('prod_id', function ($data) {
			$menu = '<li>
                    <a  href="javascript:void(0)" link="'.site_url().'">
                        <span class="glyphicon glyphicon-download"></span> Download
                    </a>
                	</li>';

        return '<div class="dropdown">
		<button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
		<i class="glyphicon glyphicon-option-vertical"></i>
		</button>
		<ul class="dropdown-menu">
		'.$menu.'    
		</ul></div>';
			});
		echo $datatables->generate();	
	}

	public function filter_ia_sales_data(){
		
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
			$supplier = $this->input->post('supplier');
			$consumer = $this->input->post('consumer');
			$st_date = $this->input->post('st_date');
			$end_date = $this->input->post('end_date');
			$ia_id = $this->session->userdata['iaid'];
			$titledate = date('M Y');

			$where = "op.ia_id= '".$ia_id."'";
			if(!empty($supplier)){ $where .= " AND op.supplier_id= '".$supplier."'"; }
			if(!empty($consumer)){ $where .= " AND op.consumer_id= '".$consumer."'"; } 

			if(!empty($st_date)){
				
				$start = get_ymd_format($st_date);	
				$where .= " AND op.createdate >= '".$start." 00:00:00'"; 
				$titledate = date('M Y',strtotime($start));
			}else{
				$where .= " AND op.createdate >= '".date('Y-m-01')." 00:00:00'"; 
			}

			if(!empty($end_date)){
				$end = get_ymd_format($end_date);				
				$where .= " AND op.createdate <= '".$end." 23:59:59'"; 
				$titledate = date('M Y',strtotime($end));
			}else{
				$where .= " AND op.createdate <= '".date('Y-m-t')." 23:59:59'"; 
			}

			$datatables = new Datatables(new CodeigniterAdapter);

			$query = "SELECT op.ord_prod_id,p.product_name,p.product_sku,p.type,CONCAT_WS(' ',s.supplier_fname,s.supplier_lname) AS supplier_name,
			SUM(op.prod_qty) AS unit_sold , SUM(op.prod_total) as sr_total_amount,
			SUM(op.eta_disburse) as revenue, p.prod_id
			FROM `orders_product` as op 
			LEFT JOIN product as p ON p.prod_id = op.prod_id 
			LEFT JOIN supplier as s ON s.supplier_id = p.supplier_id 
			WHERE ".$where." GROUP BY op.supplier_id";

			$datatables->query($query);
			
			$iadata = $this->generalmodel->get_iadata($ia_id);

			$title = $iadata['username'].'-'.$titledate;
	        $datatables->edit('ord_prod_id', function($data) use($title){
	            return $title;
	        });

	        $datatables->edit('sr_total_amount', function ($data) {
	            return numfmt_format_currency($this->fmt,$data['sr_total_amount'], "USD");
	        });

	        $datatables->edit('revenue', function ($data) {
	            return numfmt_format_currency($this->fmt,$data['revenue'], "USD");
	        });

	        $datatables->edit('revenue', function ($data) {
	            return numfmt_format_currency($this->fmt,$data['revenue'], "USD");
	        });

			$datatables->edit('prod_id', function ($data) {
				$menu = '<li>
                        <a  href="javascript:void(0)" link="'.site_url().'">
                            <span class="glyphicon glyphicon-download"></span> Download
                        </a>
                    	</li>';

	        return '<div class="dropdown">
			<button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
			<i class="glyphicon glyphicon-option-vertical"></i>
			</button>
			<ul class="dropdown-menu">
			'.$menu.'    
			</ul></div>';
 			});
			echo $datatables->generate();
		}	
	}

	public function filter_ia_sales_total(){
		if($this->input->is_ajax_request()){
			$supplier = $this->input->post('supplier');
			$consumer = $this->input->post('consumer');
			$st_date = $this->input->post('st_date');
			$end_date = $this->input->post('end_date');
			$ia_id = $this->session->userdata['iaid'];

			$where = "op.ia_id= '".$ia_id."'";
			if(!empty($supplier)){ $where .= " AND op.supplier_id= '".$supplier."'"; }
			if(!empty($consumer)){ $where .= " AND op.consumer_id= '".$consumer."'"; } 

			if(!empty($st_date)){
				$start = get_ymd_format($st_date);				
				$where .= " AND op.createdate >= '".$start." 00:00:00'"; 
			}else{
				$where .= " AND op.createdate >= '".date('Y-m-01')." 00:00:00'"; 
			}

			if(!empty($end_date)){
				$end = get_ymd_format($end_date);				
				$where .= " AND op.createdate <= '".$end." 23:59:59'"; 
			}else{
				$where .= " AND op.createdate <= '".date('Y-m-t')." 23:59:59'"; 
			}

			$query = "SELECT SUM(op.prod_qty) AS qty , SUM(op.prod_total) as amount,
			SUM(op.eta_disburse) as revenue
			FROM `orders_product` as op 
			LEFT JOIN product as p ON p.prod_id = op.prod_id 
			LEFT JOIN supplier as s ON s.supplier_id = p.supplier_id 
			WHERE ".$where;

			$data = $this->generalmodel->customquery($query,'row_array');
			$data['amount'] = numfmt_format_currency($this->fmt,$data['amount'], "USD");
			if(empty($data['qty'])){$data['qty']='0.00'; }
			echo json_encode($data);
		}	
	}

	//===========LIC module ia sales report end=========

	//===========supplier sales report start=========


	public function sup_sales_report(){
		$data['licensee'] = $this->generalmodel->all_licensee();	
		$data['meta_title'] = 'Sales Report';
		$this->load->view('reports/supplier_sales',$data);
	}

	public function sup_sales_data(){
		//$sid=$this->session->userdata['supplier_id'];
		$sid='2';
		$sup_resource = $this->generalmodel->get_supplier_resource_id($sid);
		
		$where = " op.supplier_id= '".$sid."'";
		$where .= " AND op.createdate >= '".date('Y-m-01')." 00:00:00'"; 
		$where .= " AND op.createdate <= '".date('Y-m-t')." 23:59:59'"; 

		$query = "SELECT op.ord_prod_id,p.product_sku,p.product_name,p.type,CONCAT_WS(' ',s.supplier_fname,s.supplier_lname) AS supplier_name,
			SUM(op.prod_qty) AS unit_sold , SUM(op.prod_total) as sr_total_amount,
			SUM(op.eta_disburse) as revenue, p.prod_id
			FROM `orders_product` as op 
			LEFT JOIN product as p ON p.prod_id = op.prod_id 
			LEFT JOIN supplier as s ON s.supplier_id = p.supplier_id 
			WHERE ".$where." GROUP BY op.prod_id";

		$title = $sup_resource.'-'.date('M Y');

		$datatables = new Datatables(new CodeigniterAdapter);
		$datatables->query($query);

        $datatables->edit('ord_prod_id', function($data) use($title){
            return $title;
        });


        $datatables->edit('sr_total_amount', function ($data) {
            return numfmt_format_currency($this->fmt,$data['sr_total_amount'], "USD");
        });

        $datatables->edit('revenue', function ($data) {
            return numfmt_format_currency($this->fmt,$data['revenue'], "USD");
        });

        $datatables->edit('revenue', function ($data) {
            return numfmt_format_currency($this->fmt,$data['revenue'], "USD");
        });

		$datatables->edit('prod_id', function ($data) {
			$menu = '<li>
                    <a  href="javascript:void(0)" link="'.site_url().'">
                        <span class="glyphicon glyphicon-download"></span> Download
                    </a>
                	</li>';
	        return '<div class="dropdown">
			<button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
			<i class="glyphicon glyphicon-option-vertical"></i>
			</button>
			<ul class="dropdown-menu">
			'.$menu.'    
			</ul></div>';
		});
		
		echo $datatables->generate();	
	}

	public function filter_sup_sales_data(){
		
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
			
			$consumer = $this->input->post('consumer');
			$st_date = $this->input->post('st_date');
			$end_date = $this->input->post('end_date');
			$ia_id = $this->input->post('ia');
			$lic_id = $this->input->post('lic');
			
			//$sid=$this->session->userdata['supplier_id'];
			$sid='2';
			$sup_resource = $this->generalmodel->get_supplier_resource_id($sid);
					
			$titledate = date('M Y');
			$t1 = $sup_resource;

			$where = "op.supplier_id= '".$sid."'";
			if(!empty($lic_id)){ 
				$where .= " AND op.lic_id= '".$lic_id."'"; 

				$t1 .= '-'.$this->generalmodel->get_user_resource_id($lic_id);
			}
			if(!empty($ia_id)){ $where .= " AND op.ia_id= '".$ia_id."'"; 
				$t1 .= '-'.$this->generalmodel->get_user_resource_id($ia_id);

			}
			if(!empty($consumer)){ $where .= " AND op.consumer_id= '".$consumer."'"; } 

			if(!empty($st_date)){
				
				$start = get_ymd_format($st_date);	
				$where .= " AND op.createdate >= '".$start." 00:00:00'"; 
				$titledate = date('M Y',strtotime($start));
			}else{
				$where .= " AND op.createdate >= '".date('Y-m-01')." 00:00:00'"; 
			}

			if(!empty($end_date)){
				$end = get_ymd_format($end_date);				
				$where .= " AND op.createdate <= '".$end." 23:59:59'"; 
				$titledate = date('M Y',strtotime($end));
			}else{
				$where .= " AND op.createdate <= '".date('Y-m-t')." 23:59:59'"; 
			}

			$datatables = new Datatables(new CodeigniterAdapter);

			//if(!empty($lic_id)|| !empty($ia_id) || !empty($consumer)){
			$select="op.ord_prod_id,p.product_sku,p.product_name,p.type,CONCAT_WS(' ',s.supplier_fname,s.supplier_lname) AS supplier_name,
						SUM(op.prod_qty) AS unit_sold , SUM(op.prod_total) as sr_total_amount,
						SUM(op.eta_disburse) as revenue, p.prod_id";
			
			//}else{
			//$select="op.ord_prod_id,p.product_sku,p.product_name,p.type,
			//			SUM(op.prod_qty) AS unit_sold , SUM(op.prod_total) as sr_total_amount,
			//			SUM(op.eta_disburse) as revenue, p.prod_id";
			//}
			$query = "SELECT ".$select."
			FROM `orders_product` as op 
			LEFT JOIN product as p ON p.prod_id = op.prod_id 
			LEFT JOIN supplier as s ON s.supplier_id = p.supplier_id 
			WHERE ".$where." GROUP BY op.prod_id";

//echo $query; exit;
			$datatables->query($query);
			
			$title = $t1.'-'.$titledate;
	        $datatables->edit('ord_prod_id', function($data) use($title){
	            return $title;
	        });

	        $datatables->edit('sr_total_amount', function ($data) {
	            return numfmt_format_currency($this->fmt,$data['sr_total_amount'], "USD");
	        });

	        $datatables->edit('revenue', function ($data) {
	            return numfmt_format_currency($this->fmt,$data['revenue'], "USD");
	        });

			$datatables->edit('prod_id', function ($data) {
				$menu = '<li>
                        <a  href="javascript:void(0)" link="'.site_url().'">
                            <span class="glyphicon glyphicon-download"></span> Download
                        </a>
                    	</li>';

	        return '<div class="dropdown">
			<button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
			<i class="glyphicon glyphicon-option-vertical"></i>
			</button>
			<ul class="dropdown-menu">
			'.$menu.'    
			</ul></div>';
 			});
			echo $datatables->generate();
		}	
	}

	public function filter_sup_sales_total(){
		if($this->input->is_ajax_request()){

			//$sid=$this->session->userdata['supplier_id'];
			$sid='2';
			$where = " op.supplier_id= '".$sid."'";

			$lic = $this->input->post('lic');
			$ia_id = $this->input->post('ia');
			$consumer = $this->input->post('consumer');
			$st_date = $this->input->post('st_date');
			$end_date = $this->input->post('end_date');

			
			if(!empty($consumer)){ $where .= " AND op.consumer_id= '".$consumer."'"; } 

			if(!empty($lic)){ $where .= " AND op.lic_id= '".$lic."'"; }
			if(!empty($ia_id)){ $where .= " AND op.ia_id= '".$ia_id."'"; }
			
			if(!empty($st_date)){
				$start = get_ymd_format($st_date);				
				$where .= " AND op.createdate >= '".$start." 00:00:00'"; 
			}else{
				$where .= " AND op.createdate >= '".date('Y-m-01')." 00:00:00'"; 
			}

			if(!empty($end_date)){
				$end = get_ymd_format($end_date);				
				$where .= " AND op.createdate <= '".$end." 23:59:59'"; 
			}else{
				$where .= " AND op.createdate <= '".date('Y-m-t')." 23:59:59'"; 
			}

			$query = "SELECT SUM(op.prod_qty) AS qty , SUM(op.prod_total) as amount,
			SUM(op.eta_disburse) as revenue
			FROM `orders_product` as op 
			LEFT JOIN product as p ON p.prod_id = op.prod_id 
			LEFT JOIN supplier as s ON s.supplier_id = p.supplier_id 
			WHERE ".$where;

			$data = $this->generalmodel->customquery($query,'row_array');
			$data['amount'] = numfmt_format_currency($this->fmt,$data['amount'], "USD");
			if(empty($data['qty'])){$data['qty']='0.00'; }
			echo json_encode($data);
		}	
	}

	public function export_sup_salesreport(){
		set_time_limit(0);
        ini_set('memory_limit', -1);
			
		$consumer = $this->input->post('consumer');
		$st_date = $this->input->post('st_date');
		$end_date = $this->input->post('end_date');
		$ia_id = $this->input->post('ia');
		$lic_id = $this->input->post('lic');
		
		//$sid=$this->session->userdata['supplier_id'];
		$sid='2';
		$sup_resource = $this->generalmodel->get_supplier_resource_id($sid);
				
		$titledate = date('M Y');
		$t1 = $sup_resource;

		$where = "op.supplier_id= '".$sid."'";
		if(!empty($lic_id)){ 
			$where .= " AND op.lic_id= '".$lic_id."'"; 

			$t1 .= '-'.$this->generalmodel->get_user_resource_id($lic_id);
		}
		if(!empty($ia_id)){ $where .= " AND op.ia_id= '".$ia_id."'"; 
			$t1 .= '-'.$this->generalmodel->get_user_resource_id($ia_id);

		}
		if(!empty($consumer)){ $where .= " AND op.consumer_id= '".$consumer."'"; } 

		if(!empty($st_date)){
			
			$start = get_ymd_format($st_date);	
			$where .= " AND op.createdate >= '".$start." 00:00:00'"; 
			$titledate = date('M Y',strtotime($start));
		}else{
			$where .= " AND op.createdate >= '".date('Y-m-01')." 00:00:00'"; 
		}

		if(!empty($end_date)){
			$end = get_ymd_format($end_date);				
			$where .= " AND op.createdate <= '".$end." 23:59:59'"; 
			$titledate = date('M Y',strtotime($end));
		}else{
			$where .= " AND op.createdate <= '".date('Y-m-t')." 23:59:59'"; 
		}

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'supplier_sales_report-'.date('m-d-Y').'.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser

		$style = (new StyleBuilder())
		           ->setFontBold()
		           ->setFontSize(15)
		           ->setCellAlignment(CellAlignment::CENTER)
		           ->build();

		/** Create a row with cells and apply the style to all cells */
		$singleRow = WriterEntityFactory::createRowFromArray(['','','','Supplier Sales Report','','',''], $style);
		$blankRow = WriterEntityFactory::createRowFromArray(['','','','','','','']);
		/** Add the row to the writer */
		$writer->addRow($singleRow);
		$writer->addRow($blankRow);

        
		$cellstyle = (new StyleBuilder())
           ->setFontBold()
           ->setFontSize(15)
           ->build();

		if(!empty($lic_id)|| !empty($ia_id) || !empty($consumer)){
			$select="op.ord_prod_id,p.product_sku,p.product_name,p.type,CONCAT_WS(' ',s.supplier_fname,s.supplier_lname) AS supplier_name,
			SUM(op.prod_qty) AS unit_sold , SUM(op.prod_total) as sr_total_amount,
			SUM(op.eta_disburse) as revenue, p.prod_id";

			$query = "SELECT ".$select."
			FROM `orders_product` as op 
			LEFT JOIN product as p ON p.prod_id = op.prod_id 
			LEFT JOIN supplier as s ON s.supplier_id = p.supplier_id 
			WHERE ".$where." GROUP BY op.prod_id";

	        $query=$this->db->query($query);
			$title = $t1.'-'.$titledate;

	        $obj= $query->result_array();

	        $cells = [
	                WriterEntityFactory::createCell('Title',$cellstyle),
	                WriterEntityFactory::createCell('Product SKU',$cellstyle),
	                WriterEntityFactory::createCell('Product Name',$cellstyle),
	                WriterEntityFactory::createCell('Product Type',$cellstyle),                
	                WriterEntityFactory::createCell('Supplier',$cellstyle),                
	                WriterEntityFactory::createCell('Unit Sold',$cellstyle),
	                WriterEntityFactory::createCell('Total Amount',$cellstyle),
	                WriterEntityFactory::createCell('Revenue',$cellstyle),
	        ];

	        /** add a row at a time */
	        $singleRow = WriterEntityFactory::createRow($cells);
	        $writer->addRow($singleRow);

	        foreach ($obj as $row) {
				
	            $data[0] = $title;
	            $data[1] = $row['product_sku'];
	            $data[2] = $row['product_name'];
	            $data[3] = $row['type'];
	            $data[4] = $row['supplier_name'];
	            $data[5] = $row['unit_sold'];
	            $data[6] = numfmt_format_currency($this->fmt,$row['sr_total_amount'], "USD");
	            $data[7] = numfmt_format_currency($this->fmt,$row['revenue'], "USD");
	            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
	        }
	        
	        $writer->close();
    	}else{
			$select="op.ord_prod_id,p.product_sku,p.product_name,p.type,
			SUM(op.prod_qty) AS unit_sold , SUM(op.prod_total) as sr_total_amount,
			SUM(op.eta_disburse) as revenue, p.prod_id";

			$query = "SELECT ".$select."
			FROM `orders_product` as op 
			LEFT JOIN product as p ON p.prod_id = op.prod_id 
			LEFT JOIN supplier as s ON s.supplier_id = p.supplier_id 
			WHERE ".$where." GROUP BY op.prod_id";

	        $query=$this->db->query($query);
			$title = $t1.'-'.$titledate;

	        $obj= $query->result_array();

	        $cells = [
	                WriterEntityFactory::createCell('Title',$cellstyle),
	                WriterEntityFactory::createCell('Product SKU',$cellstyle),
	                WriterEntityFactory::createCell('Product Name',$cellstyle),
	                WriterEntityFactory::createCell('Product Type',$cellstyle),                
	                WriterEntityFactory::createCell('Unit Sold',$cellstyle),
	                WriterEntityFactory::createCell('Total Amount',$cellstyle),
	                WriterEntityFactory::createCell('Revenue',$cellstyle),
	        ];

	        /** add a row at a time */
	        $singleRow = WriterEntityFactory::createRow($cells);
	        $writer->addRow($singleRow);

	        foreach ($obj as $row) {
				
	            $data[0] = $title;
	            $data[1] = $row['product_sku'];
	            $data[2] = $row['product_name'];
	            $data[3] = $row['type'];
	            $data[4] = $row['unit_sold'];
	            $data[5] = numfmt_format_currency($this->fmt,$row['sr_total_amount'], "USD");
	            $data[6] = numfmt_format_currency($this->fmt,$row['revenue'], "USD");
	            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
	        }
	        
	        $writer->close();
		}

	}

	//===========supplier sales report end=========

/*
	public function ia_sales_report(){
		$ia_id=$this->session->userdata['iaid'];
		$data['supplier'] = $this->generalmodel->all_suppliers();	
		$data['consumers'] = $this->generalmodel->consumerList($ia_id);	
		$this->load->view('reports/ia_sales',$data);
	}

	public function ia_sales_data(){
		$ia_id=$this->session->userdata['iaid'];
		$datatables = new Datatables(new CodeigniterAdapter);

		$datatables->query('SELECT s.sr_title, s.sr_product_sku,s.sr_product_name,s.sr_product_type,s.sr_supplier_name,s.sr_qty,s.sr_total_amount,(s.sr_total_amount - p.ia_price*s.sr_qty) AS revenue,sr_id 
			FROM `sales_report` as s  
			LEFT JOIN product as p ON p.prod_id = s.sr_product_id 
			WHERE s.ia_id= '.$ia_id);
	        $datatables->edit('sr_total_amount', function ($data) {
	            return numfmt_format_currency($this->fmt,$data['sr_total_amount'], "USD");
	        });

	        $datatables->edit('revenue', function ($data) {
	            return numfmt_format_currency($this->fmt,$data['revenue'], "USD");
	        });

	        $datatables->edit('revenue', function ($data) {
	            return numfmt_format_currency($this->fmt,$data['revenue'], "USD");
	        });

			$datatables->edit('sr_id', function ($data) {
				$menu = '<li>
                        <a  href="javascript:void(0)" link="'.site_url().'">
                            <span class="glyphicon glyphicon-download"></span> Download
                        </a>
                    	</li>';

	        return '<div class="dropdown">
			<button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
			<i class="glyphicon glyphicon-option-vertical"></i>
			</button>
			<ul class="dropdown-menu">
			'.$menu.'    
			</ul></div>';
 			});
		echo $datatables->generate();	
	}

	public function filter_ia_sales_data(){
		
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
			$supplier = $this->input->post('supplier');
			$consumer = $this->input->post('consumer');
			$st_date = $this->input->post('st_date');
			$end_date = $this->input->post('end_date');
			$ia_id = $this->session->userdata['iaid'];

			$where = "s.ia_id= '".$ia_id."'";
			if(!empty($supplier)){ $where .= " AND s.sr_supplier_id= '".$supplier."'"; }
			if(!empty($consumer)){ $where .= " AND FIND_IN_SET(".$consumer.",sa.sales_associate_consumer_id)"; } 

			if(!empty($st_date)){
				$start = get_ymd_format($st_date);				
				$where .= " AND s.sr_createdate >= '".$start." 00:00:00'"; 
			}

			if(!empty($end_date)){
				$end = get_ymd_format($end_date);				
				$where .= " AND s.sr_createdate <= '".$end." 23:59:59'"; 
			}
			$datatables = new Datatables(new CodeigniterAdapter);

			$datatables->query('SELECT s.sr_title, s.sr_product_sku,s.sr_product_name,s.sr_product_type,s.sr_supplier_name,s.sr_qty,s.sr_total_amount,(s.sr_total_amount - p.ia_price*s.sr_qty) AS revenue,sr_id 
				FROM `sales_report` as s  
				LEFT JOIN product as p ON p.prod_id = s.sr_product_id 
				LEFT JOIN sales_associate as sa ON sa.sales_associate_id = s.sales_associate_id 
				WHERE '.$where);

		        $datatables->edit('sr_total_amount', function ($data) {
		            return numfmt_format_currency($this->fmt,$data['sr_total_amount'], "USD");
		        });

		        $datatables->edit('revenue', function ($data) {
		            return numfmt_format_currency($this->fmt,$data['revenue'], "USD");
		        });

		        $datatables->edit('revenue', function ($data) {
		            return numfmt_format_currency($this->fmt,$data['revenue'], "USD");
		        });

				$datatables->edit('sr_id', function ($data) {
					$menu = '<li>
	                        <a  href="javascript:void(0)" link="'.site_url().'">
	                            <span class="glyphicon glyphicon-download"></span> Download
	                        </a>
	                    	</li>';

		        return '<div class="dropdown">
				<button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
				<i class="glyphicon glyphicon-option-vertical"></i>
				</button>
				<ul class="dropdown-menu">
				'.$menu.'    
				</ul></div>';
	 			});
			echo $datatables->generate();
		}	
	}

	public function filter_ia_sales_total(){
		//echo "<pre>"; print_r($_POST); exit;
		if($this->input->is_ajax_request()){
			$supplier = $this->input->post('supplier');
			$consumer = $this->input->post('consumer');
			$st_date = $this->input->post('st_date');
			$end_date = $this->input->post('end_date');
			$ia_id = $this->session->userdata['iaid'];

			$where = "s.ia_id= '".$ia_id."'";
			if(!empty($supplier)){ $where .= " AND s.sr_supplier_id= '".$supplier."'"; }
			if(!empty($consumer)){ $where .= " AND FIND_IN_SET(".$consumer.",sa.sales_associate_consumer_id)"; } 


			if(!empty($st_date)){
				$start = get_ymd_format($st_date);				
				$where .= " AND s.sr_createdate >= '".$start." 00:00:00'"; 
			}

			if(!empty($end_date)){
				$end = get_ymd_format($end_date);				
				$where .= " AND s.sr_createdate <= '".$end." 23:59:59'"; 
			}

			$query = "SELECT SUM(s.sr_qty) AS qty,SUM(s.sr_total_amount) AS amount 
				FROM `sales_report` as s  
				LEFT JOIN product as p ON p.prod_id = s.sr_product_id 
				LEFT JOIN sales_associate as sa ON sa.sales_associate_id = s.sales_associate_id 
				WHERE ".$where;

			$data = $this->generalmodel->customquery($query,'row_array');
			$data['amount'] = numfmt_format_currency($this->fmt,$data['amount'], "USD");
			if(empty($data['qty'])){$data['qty']='0.00'; }
			echo json_encode($data);
		}	
	}
	*/
	//===========LIC module ia report end=========

	//===========Individual LIC disbursement start=========

	public function lic_disbursment_report(){
		$lic=$this->session->userdata['licenseeid'];
		$data['meta_title'] = 'Disbursement Report';
		$this->load->view('reports/lic_disbursment_report'); 
	}

	public function lic_disbursment_report_ajax(){
		if($this->input->is_ajax_request()){

			$st_date = $this->input->post('st_date');
			$end_date = $this->input->post('end_date');
			$lic = $this->session->userdata['licenseeid'];
			$where = "o.lic_id = '".$lic."'"; 
			$urole = $this->userdata['urole_id'];
			$dept = $this->userdata['dept_id'];
			
			$where .= " AND o.createdate >= '".date('Y-m-01',strtotime('last month'))." 00:00:00'"; 
			$where .= " AND o.createdate <= '".date('Y-m-t',strtotime('last month'))." 23:59:59'"; 

			$query = "SELECT o.lic_id AS licensee,DATE_FORMAT(`o`.`createdate`, '%m-%Y') AS title,u.resource_id,
			CONCAT_WS(' ',u.firstname,u.lastname) AS username,b.business_name,
			COUNT(`o`.`orders_id`) AS total_orders,SUM(o.total_amt) AS total_amount,
			SUM(o.lic_disburse) AS total_eta_dis,d.status,DATE_FORMAT(d.updatedate, '%m/%d/%Y') AS modi,o.lic_id
			FROM `orders` AS o
			LEFT JOIN user AS u ON u.user_id= o.lic_id
			LEFT JOIN licensee AS l ON l.user_id= u.user_id
			LEFT JOIN business AS b ON b.business_id= l.business_id			
            LEFT JOIN lic_disburse_status as d ON ( d.lic_id=o.lic_id AND d.dis_title= DATE_FORMAT(`o`.`createdate`, '%m-%Y'))
            WHERE $where
			GROUP BY  MONTH(o.createdate), YEAR(o.createdate) DESC  
			ORDER BY `title` ASC";

			$datatables = new Datatables(new CodeigniterAdapter);

			$datatables->query($query);

			if($urole==1 && ($dept==2 ||$dept==3 ||$dept==10)){
		        $datatables->edit('licensee', function ($data) {
		        	if($data['status']==1){
		        		return '';
		        	}else{
		            	return '<input type="checkbox" value="'.$data['total_eta_dis'].'" class="check" id="'.$data['licensee'].'" dates="'.$data['title'].'" />';
		        	}
		        });
			}else{
				$datatables->hide('licensee');
			}

	        // $datatables->edit('licensee', function ($data) {
	        // 	if($data['status']==1){
	        // 		return '';
	        // 	}else{
	        //     	return '<input type="checkbox" value="'.$data['total_eta_dis'].'" class="check" id="'.$data['licensee'].'" dates="'.$data['title'].'" />';
	        // 	}
	        // });

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
			$datatables->edit('lic_id', function ($data) {
				$link = site_url('reports/export_lic_dis_detail/').$data['lic_id'].'/'.$data['title'];
				$menu = '<li>
                        <a  href="'.$link.'">
                            <span class="glyphicon glyphicon-download"></span> Download
                        </a>
                    	</li>';

		        return '<div class="dropdown">
				<button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
				<i class="glyphicon glyphicon-option-vertical"></i>
				</button>
				<ul class="dropdown-menu">
				'.$menu.'    
				</ul></div>';
 			});
			echo $datatables->generate();
		}		
	}
	
	public function filter_lic_disburs(){
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){

			$st_date = $this->input->post('st_date');
			$end_date = $this->input->post('end_date');
			$lic = $this->input->post('lic');
			$urole = $this->userdata['urole_id'];
			$dept = $this->userdata['dept_id'];
			
			$where = "o.lic_id = '".$lic."'"; 
			if(!empty($st_date)){
				$start = get_ym_start($st_date);				
				$where .= " AND o.createdate >= '".$start." 00:00:00'"; 
			}
			if(!empty($end_date)){
				$end = get_ym_end($end_date);				
				$where .= " AND o.createdate <= '".$end." 23:59:59'"; 
			}else{
				$where .= " AND o.createdate <= '".date('Y-m-t',strtotime('last month'))." 23:59:59'"; 
			}

			$query = "SELECT o.lic_id AS licensee,DATE_FORMAT(`o`.`createdate`, '%m-%Y') AS title,u.resource_id,
			CONCAT_WS(' ',u.firstname,u.lastname) AS username,b.business_name,
			COUNT(`o`.`orders_id`) AS total_orders,SUM(o.total_amt) AS total_amount,
			SUM(o.lic_disburse) AS total_eta_dis,d.status,DATE_FORMAT(d.updatedate, '%m/%d/%Y') AS modi,o.lic_id
			FROM `orders` AS o
			LEFT JOIN user AS u ON u.user_id= o.lic_id
			LEFT JOIN licensee AS l ON l.user_id= u.user_id
			LEFT JOIN business AS b ON b.business_id= l.business_id				
            LEFT JOIN lic_disburse_status as d ON ( d.lic_id=o.lic_id AND d.dis_title= DATE_FORMAT(`o`.`createdate`, '%m-%Y'))
            WHERE $where
			GROUP BY  MONTH(o.createdate), YEAR(o.createdate) DESC  
			ORDER BY `title` ASC";

			$datatables = new Datatables(new CodeigniterAdapter);

			$datatables->query($query);

			if($urole==1 && ($dept==2 ||$dept==3 ||$dept==10)){
		        $datatables->edit('licensee', function ($data) {
		        	if($data['status']==1){
		        		return '';
		        	}else{
		            	return '<input type="checkbox" value="'.$data['total_eta_dis'].'" class="check" id="'.$data['licensee'].'" dates="'.$data['title'].'" />';
		        	}
		        });
			}else{
				$datatables->hide('licensee');
			}

	        // $datatables->edit('licensee', function ($data) {
	        // 	if($data['status']==1){
	        // 		return '';
	        // 	}else{
		       //      return '<input type="checkbox" value="'.$data['total_eta_dis'].'" class="check" id="'.$data['licensee'].'" dates="'.$data['title'].'" />';
	        // 	}
	        // });

	        $datatables->edit('total_amount', function ($data) {
	            return numfmt_format_currency($this->fmt,$data['total_amount'], "USD");
	        });

	        $datatables->edit('total_eta_dis', function ($data) {
	            return numfmt_format_currency($this->fmt,$data['total_eta_dis'], "USD");
	        });

	        $datatables->edit('status', function ($data) {
	            if($data['status']==1){ return 'Paid'; }else{ return 'Unpaid'; }
	        });	
			$datatables->edit('lic_id', function ($data) {
				$menu = '<li>
                        <a  href"'.site_url('reports/export_lic_dis_detail/').$data['lic_id'].'/'.$data['title'].'">
                            <span class="glyphicon glyphicon-download"></span> Download
                        </a>
                    	</li>';

		        return '<div class="dropdown">
				<button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
				<i class="glyphicon glyphicon-option-vertical"></i>
				</button>
				<ul class="dropdown-menu">
				'.$menu.'    
				</ul></div>';
 			});
			echo $datatables->generate();
		}	
	}
	public function lic_monthly_disbrs_total(){

		if($this->input->is_ajax_request()){
			$st_date = $this->input->post('st_date');
			$end_date = $this->input->post('end_date');
			$lic = $this->input->post('lic');

			$where = " o.lic_id = '".$lic."'"; 
			if(!empty($st_date)){
				$start = get_ym_start($st_date);				
				$where .= " AND o.createdate >= '".$start." 00:00:00'"; 
			}

			if(!empty($end_date)){
				$end = get_ym_end($end_date);				
				$where .= " AND o.createdate <= '".$end." 23:59:59'"; 
			}else{
				$where .= " AND o.createdate <= '".date('Y-m-t',strtotime('last month'))." 23:59:59'"; 
			}

			$query = "SELECT SUM(o.total_amt) AS reconcile,SUM(o.lic_disburse) AS disburse
			FROM `orders` AS o WHERE $where";
			$data = $this->generalmodel->customquery($query,'row_array');

			$data['reconcile'] = numfmt_format_currency($this->fmt,$data['reconcile'], "USD");
			$data['disburse'] = numfmt_format_currency($this->fmt,$data['disburse'], "USD");
			echo json_encode($data);
		}
	}

	public function export_lic_disburse(){
		if(!empty($this->input->post())){
			$st_date = $this->input->post('startdate');
			$end_date = $this->input->post('enddate');
			$lic = $this->session->userdata['licenseeid'];

			$where = "  o.lic_id = '".$lic."'"; 
			
			if(!empty($st_date)){
				$start = get_ym_start($st_date);				
				$where .= " AND o.createdate >= '".$start." 00:00:00'"; 
			}
			if(!empty($end_date)){
				$end = get_ym_end($end_date);				
				$where .= " AND o.createdate <= '".$end." 23:59:59'"; 
			}else{
				$where .= " AND o.createdate <= '".date('Y-m-t',strtotime('last month'))." 23:59:59'"; 
			}


			$queryy = "SELECT DATE_FORMAT(`o`.`createdate`, '%m-%Y') AS title,
			CONCAT_WS(' ',u.firstname,u.lastname) AS username,
			COUNT(`o`.`orders_id`) AS total_orders,SUM(o.total_amt) AS total_amount,
			SUM(o.lic_disburse) AS total_eta_dis,d.status,DATE_FORMAT(d.updatedate, '%m/%d/%Y') AS modi,o.lic_id
			FROM `orders` AS o
			LEFT JOIN user AS u ON u.user_id= o.lic_id
	        LEFT JOIN lic_disburse_status as d ON ( d.lic_id=o.lic_id AND d.dis_title= DATE_FORMAT(`o`.`createdate`, '%m-%Y'))
	        WHERE $where
			GROUP BY o.lic_id, MONTH(o.createdate), YEAR(o.createdate) DESC  
			ORDER BY `title` ASC";


	 		$query=$this->db->query($queryy);

	        $obj= $query->result_array();

	        $writer = WriterEntityFactory::createXLSXWriter();
	        $filePath = base_url().'lic_disbursement_report-'.date('m-d-Y').'.xlsx';
	        $writer->openToBrowser($filePath); // stream data directly to the browser

			$style = (new StyleBuilder())
			           ->setFontBold()
			           ->setFontSize(15)
			           ->setCellAlignment(CellAlignment::CENTER)
			           ->build();

			/** Create a row with cells and apply the style to all cells */
			$singleRow = WriterEntityFactory::createRowFromArray(['','','','Licensee Disbursement Report','','',''], $style);
			$blankRow = WriterEntityFactory::createRowFromArray(['','','','','','','']);
			/** Add the row to the writer */
			$writer->addRow($singleRow);
			$writer->addRow($blankRow);

	        
			$cellstyle = (new StyleBuilder())
	           ->setFontBold()
	           ->setFontSize(15)
	           ->build();

	        $cells = [
	                WriterEntityFactory::createCell('Title',$cellstyle),
	                WriterEntityFactory::createCell('Licensee',$cellstyle),
	                WriterEntityFactory::createCell('Total Order',$cellstyle),
	                WriterEntityFactory::createCell('Total Amount',$cellstyle),
	                WriterEntityFactory::createCell('Order Total to Disburse',$cellstyle),
	                WriterEntityFactory::createCell('Status',$cellstyle),
	                WriterEntityFactory::createCell('Modified Date',$cellstyle),
	        ];

	        //=== add a row at a time ===//
	        $singleRow = WriterEntityFactory::createRow($cells);
	        $writer->addRow($singleRow);
	        if(!empty($obj)){
		        
		        foreach ($obj as $row) {

		            $data[1] = $row['title'];
		            $data[2] = $row['username'];
		            $data[3] = $row['total_orders'];
		            $data[4] = numfmt_format_currency($this->fmt,$row['total_amount'], "USD");
		            $data[5] = numfmt_format_currency($this->fmt,$row['total_eta_dis'], "USD");
		            if($row['status']==1){ $data[6] = 'Paid'; }else{ $data[6] = 'Unpaid'; }
		            $data[7] = $row['modi'];
		            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
		        }
	        }
	        $writer->close();
	    } 	
	}
	//===========Individual LIC disbursement end=========


	//===========Individual IA disbursement start=========

	public function ia_disbursment_report(){
		$lic=$this->session->userdata['iaid'];
		$data['meta_title'] = 'Disbursement Report';
		$this->load->view('reports/ia_disbursment_report'); 
	}

	public function ia_disbursment_report_ajax(){
		if($this->input->is_ajax_request()){

			$st_date = $this->input->post('st_date');
			$end_date = $this->input->post('end_date');
			$ia = $this->session->userdata['iaid'];
			$urole = $this->userdata['urole_id'];
			$dept = $this->userdata['dept_id'];
			
			$where = "o.ia_id = '".$ia."'"; 

			$where .= " AND o.createdate >= '".date('Y-m-01',strtotime('last month'))." 00:00:00'"; 
			$where .= " AND o.createdate <= '".date('Y-m-t',strtotime('last month'))." 23:59:59'"; 

			$query = "SELECT o.ia_id AS licensee,DATE_FORMAT(`o`.`createdate`, '%m-%Y') AS title,u.resource_id,
			CONCAT_WS(' ',u.firstname,u.lastname) AS username,b.business_name,
			COUNT(`o`.`orders_id`) AS total_orders,SUM(o.total_amt) AS total_amount,
			SUM(o.ia_disburse) AS total_eta_dis,d.status,DATE_FORMAT(d.updatedate, '%m/%d/%Y') AS modi,o.ia_id
			FROM `orders` AS o
			LEFT JOIN user AS u ON u.user_id= o.ia_id
			LEFT JOIN indassociation AS ia ON ia.user_id= u.user_id
			LEFT JOIN business AS b ON b.business_id= ia.business_id			
            LEFT JOIN ia_disburse_status as d ON ( d.ia_id=o.ia_id AND d.dis_title= DATE_FORMAT(`o`.`createdate`, '%m-%Y'))
            WHERE $where
			GROUP BY  MONTH(o.createdate), YEAR(o.createdate) DESC  
			ORDER BY `title` ASC";


			$datatables = new Datatables(new CodeigniterAdapter);

			$datatables->query($query);

			if($urole==1 && ($dept==2 ||$dept==3 ||$dept==10)){
		        $datatables->edit('licensee', function ($data) {
		        	if($data['status']==1){ return '';
		        	}else{
		            	return '<input type="checkbox" value="'.$data['total_eta_dis'].'" class="check" id="'.$data['licensee'].'" dates="'.$data['title'].'" />';
		        	}
		        });
			}else{
 				$datatables->hide('licensee');
			}

	        $datatables->edit('modi', function ($data) {
				if(!empty($data['modi'])){
					$modi = gmdate_to_mydate($data['modi'],$this->localtimzone);
					return date('m/d/Y',strtotime($modi));
				}else{
					return '';
				}
	        });

	        $datatables->edit('total_amount', function ($data) {
	            return numfmt_format_currency($this->fmt,$data['total_amount'], "USD").'USD';
	        });

	        $datatables->edit('total_eta_dis', function ($data) {
	            return numfmt_format_currency($this->fmt,$data['total_eta_dis'], "USD").'USD';
	        });

	        $datatables->edit('status', function ($data) {
	            if($data['status']==1){ return 'Paid'; }else{ return 'Unpaid'; }
	        });
	        if($urole!=1){
 				$datatables->hide('ia_id');
			}else{	
				$datatables->edit('ia_id', function ($data) {
					$menu = '<li>
	                        <a  href"'.site_url('reports/export_ia_dis_detail/').$data['ia_id'].'/'.$data['title'].'">
	                            <span class="glyphicon glyphicon-download"></span> Download
	                        </a>
	                    	</li>';

			        return '<div class="dropdown">
					<button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
					<i class="glyphicon glyphicon-option-vertical"></i>
					</button>
					<ul class="dropdown-menu">
					'.$menu.'    
					</ul></div>';
	 			});
			}
			echo $datatables->generate();
		}		
	}
	
	public function filter_ia_disburs(){
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){

			$st_date = $this->input->post('st_date');
			$end_date = $this->input->post('end_date');
			$ia = $this->input->post('ia');
			$urole = $this->userdata['urole_id'];
			$dept = $this->userdata['dept_id'];


			$where = "o.ia_id = '".$ia."'"; 
			if(!empty($st_date)){
				$start = get_ym_start($st_date);				
				$where .= " AND o.createdate >= '".$start." 00:00:00'"; 
			}
			if(!empty($end_date)){
				$end = get_ym_end($end_date);				
				$where .= " AND o.createdate <= '".$end." 23:59:59'"; 
			}else{
				$where .= " AND o.createdate <= '".date('Y-m-t',strtotime('last month'))." 23:59:59'"; 
			}

			$query = "SELECT o.ia_id AS licensee,DATE_FORMAT(`o`.`createdate`, '%m-%Y') AS title,u.resource_id,
			CONCAT_WS(' ',u.firstname,u.lastname) AS username,b.business_name,
			COUNT(`o`.`orders_id`) AS total_orders,SUM(o.total_amt) AS total_amount,
			SUM(o.ia_disburse) AS total_eta_dis,d.status,DATE_FORMAT(d.updatedate, '%m/%d/%Y') AS modi,o.ia_id
			FROM `orders` AS o
			LEFT JOIN user AS u ON u.user_id= o.ia_id
			LEFT JOIN indassociation AS ia ON ia.user_id= u.user_id
			LEFT JOIN business AS b ON b.business_id= ia.business_id				
            LEFT JOIN ia_disburse_status as d ON ( d.ia_id=o.ia_id AND d.dis_title= DATE_FORMAT(`o`.`createdate`, '%m-%Y'))
            WHERE $where
			GROUP BY  MONTH(o.createdate), YEAR(o.createdate) DESC  
			ORDER BY `title` ASC";

			$datatables = new Datatables(new CodeigniterAdapter);

			$datatables->query($query);
			
			if($urole==1 && ($dept==2 ||$dept==3 ||$dept==10)){
		        $datatables->edit('licensee', function ($data) {
		        	if($data['status']==1){ return '';
		        	}else{
		            	return '<input type="checkbox" value="'.$data['total_eta_dis'].'" class="check" id="'.$data['licensee'].'" dates="'.$data['title'].'" />';
		        	}
		        });
			}else{
 				$datatables->hide('licensee');
			}

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

	        if($urole!=1){
 				$datatables->hide('ia_id');
			}else{		        
				$datatables->edit('ia_id', function ($data) {
					$menu = '<li>
	                        <a  href"'.site_url('reports/export_ia_dis_detail/').$data['ia_id'].'/'.$data['title'].'">
	                            <span class="glyphicon glyphicon-download"></span> Download
	                        </a>
	                    	</li>';

			        return '<div class="dropdown">
					<button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
					<i class="glyphicon glyphicon-option-vertical"></i>
					</button>
					<ul class="dropdown-menu">
					'.$menu.'    
					</ul></div>';
	 			});
			}
			echo $datatables->generate();
		}	
	}
	public function ia_monthly_disbrs_total(){

		if($this->input->is_ajax_request()){
			$st_date = $this->input->post('st_date');
			$end_date = $this->input->post('end_date');
			$ia = $this->input->post('ia');

			$where = " o.ia_id = '".$ia."'"; 
			if(!empty($st_date)){
				$start = get_ym_start($st_date);				
				$where .= " AND o.createdate >= '".$start." 00:00:00'"; 
			}

			if(!empty($end_date)){
				$end = get_ym_end($end_date);				
				$where .= " AND o.createdate <= '".$end." 23:59:59'"; 
			}else{
				$where .= " AND o.createdate <= '".date('Y-m-t',strtotime('last month'))." 23:59:59'"; 
			}

			$query = "SELECT SUM(o.total_amt) AS reconcile,SUM(o.ia_disburse) AS disburse
			FROM `orders` AS o WHERE $where";
			$data = $this->generalmodel->customquery($query,'row_array');

			$data['reconcile'] = numfmt_format_currency($this->fmt,$data['reconcile'], "USD");
			$data['disburse'] = numfmt_format_currency($this->fmt,$data['disburse'], "USD");
			echo json_encode($data);
		}
	}

	public function export_ia_disburse(){
		if(!empty($this->input->post())){
			$st_date = $this->input->post('startdate');
			$end_date = $this->input->post('enddate');
			$ia = $this->session->userdata['iaid'];

			$where = " o.ia_id = '".$ia."'"; 
			if(!empty($st_date)){
				$start = get_ym_start($st_date);				
				$where .= " AND o.createdate >= '".$start." 00:00:00'"; 
			}
			if(!empty($end_date)){
				$end = get_ym_end($end_date);				
				$where .= " AND o.createdate <= '".$end." 23:59:59'"; 
			}else{
				$where .= " AND o.createdate <= '".date('Y-m-t',strtotime('last month'))." 23:59:59'"; 
			}


			$queryy = "SELECT DATE_FORMAT(`o`.`createdate`, '%m-%Y') AS title,
			CONCAT_WS(' ',u.firstname,u.lastname) AS username,
			COUNT(`o`.`orders_id`) AS total_orders,SUM(o.total_amt) AS total_amount,
			SUM(o.ia_disburse) AS total_eta_dis,d.status,DATE_FORMAT(d.updatedate, '%m/%d/%Y') AS modi,o.ia_id
			FROM `orders` AS o
			LEFT JOIN user AS u ON u.user_id= o.ia_id
	        LEFT JOIN ia_disburse_status as d ON ( d.ia_id=o.ia_id AND d.dis_title= DATE_FORMAT(`o`.`createdate`, '%m-%Y'))
	        WHERE $where
			GROUP BY o.ia_id, MONTH(o.createdate), YEAR(o.createdate) DESC  
			ORDER BY `title` ASC";


	 		$query=$this->db->query($queryy);

	        $obj= $query->result_array();

	        $writer = WriterEntityFactory::createXLSXWriter();
	        $filePath = base_url().'ia_disbursement_report-'.date('m-d-Y').'.xlsx';
	        $writer->openToBrowser($filePath); // stream data directly to the browser

			$style = (new StyleBuilder())
			           ->setFontBold()
			           ->setFontSize(15)
			           ->setCellAlignment(CellAlignment::CENTER)
			           ->build();

			/** Create a row with cells and apply the style to all cells */
			$singleRow = WriterEntityFactory::createRowFromArray(['','','','Industry Association Disbursement Report','','',''], $style);
			$blankRow = WriterEntityFactory::createRowFromArray(['','','','','','','']);
			/** Add the row to the writer */
			$writer->addRow($singleRow);
			$writer->addRow($blankRow);

	        
			$cellstyle = (new StyleBuilder())
	           ->setFontBold()
	           ->setFontSize(15)
	           ->build();

	        $cells = [
	                WriterEntityFactory::createCell('Title',$cellstyle),
	                WriterEntityFactory::createCell('Industry Association',$cellstyle),
	                WriterEntityFactory::createCell('Total Order',$cellstyle),
	                WriterEntityFactory::createCell('Total Amount',$cellstyle),
	                WriterEntityFactory::createCell('Order Total to Disburse',$cellstyle),
	                WriterEntityFactory::createCell('Status',$cellstyle),
	                WriterEntityFactory::createCell('Modified Date',$cellstyle),
	        ];

	        //=== add a row at a time ===//
	        $singleRow = WriterEntityFactory::createRow($cells);
	        $writer->addRow($singleRow);
	        if(!empty($obj)){
		        
		        foreach ($obj as $row) {


		        	$modi = '';
					if(!empty($row['modi'])){
						$modi = gmdate_to_mydate($row['modi'],$this->localtimzone);
						$modi = date('m/d/Y',strtotime($modi));
					}

		            $data[1] = $row['title'];
		            $data[2] = $row['username'];
		            $data[3] = $row['total_orders'];
		            $data[4] = numfmt_format_currency($this->fmt,$row['total_amount'], "USD");
		            $data[5] = numfmt_format_currency($this->fmt,$row['total_eta_dis'], "USD");
		            if($row['status']==1){ $data[6] = 'Paid'; }else{ $data[6] = 'Unpaid'; }
		            if(!empty($row['modi'])){$data[7] = $modi; }else{ $data[7] = ''; }
		            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
		        }
	        }
	        $writer->close();
	    } 	
	}	
	//===========Individual IA disbursement end=========
/*
	public function lic_disbursment_report_ajax(){
		$user_id=$this->session->userdata['licenseeid'];
		if($this->input->is_ajax_request()){

			$query = "SELECT dis_title,ia.ia_resource_id,dis_total_orders,dis_total_amt,dis_disburs_amount,dis_status as status
			,dis_modified_date ,dis_id
			FROM disbursment_report as d
			LEFT JOIN indassociation as ia ON ia.user_id =d.dis_ia_id 
			WHERE d.dis_lic_id= '".$user_id."'";


			$datatables = new Datatables(new CodeigniterAdapter);

			$datatables->query($query);

	        $datatables->edit('dis_total_amt', function ($data) {
	            return numfmt_format_currency($this->fmt,$data['dis_total_amt'], "USD");
	        });

	        $datatables->edit('dis_disburs_amount', function ($data) {
	            return numfmt_format_currency($this->fmt,$data['dis_disburs_amount'], "USD");
	        });

	        $datatables->edit('status', function ($data){
	        	return ($data['status']==0)?'Unpaid':'Paid';
	        });

	        $datatables->edit('dis_modified_date', function ($data){
	        	return date('m/d/Y',strtotime($data['dis_modified_date']));
	        });

			$datatables->edit('dis_id', function ($data) {
				$menu = '<li>
                        <a  href="javascript:void(0)" link="'.site_url().'">
                            <span class="glyphicon glyphicon-download"></span> View
                        </a>
                    	</li>';
				$menu = '<li>
                        <a  href="javascript:void(0)" link="'.site_url().'">
                            <span class="glyphicon glyphicon-download"></span> Update Status
                        </a>
                    	</li>';                    	
				$menu = '<li>
                        <a  href="javascript:void(0)" link="'.site_url().'">
                            <span class="glyphicon glyphicon-download"></span> Download
                        </a>
                    	</li>';

	        return '<div class="dropdown">
			<button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
			<i class="glyphicon glyphicon-option-vertical"></i>
			</button>
			<ul class="dropdown-menu">
			'.$menu.'    
			</ul></div>';
 			});
			echo $datatables->generate();
		}		
	}

	public function getTotal_monthly_disbrs(){

		if($this->input->is_ajax_request()){
			$st_date = $this->input->post('st_date');
			$end_date = $this->input->post('end_date');
			//$lic_id = $this->input->post('lic_id');
			$lic_id=$this->session->userdata['licenseeid'];
			$where = "d.dis_lic_id= '".$lic_id."'";
			if(!empty($st_date)){
				$start = get_ym_start($st_date);				
				$where .= " AND d.dis_createdate >= '".$start." 00:00:00'"; 
			}

			if(!empty($end_date)){
				$end = get_ym_end($end_date);				
				$where .= " AND d.dis_createdate <= '".$end." 23:59:59'"; 
			}

			$query = "SELECT SUM(dis_total_amt) AS reconcile,SUM(dis_disburs_amount) AS disburse
				FROM disbursment_report as d
				LEFT JOIN indassociation as ia ON ia.user_id =d.dis_ia_id 
				WHERE ".$where;

			$data = $this->generalmodel->customquery($query,'row_array');

			$data['reconcile'] = numfmt_format_currency($this->fmt,$data['reconcile'], "USD");
			$data['disburse'] = numfmt_format_currency($this->fmt,$data['disburse'], "USD");
			echo json_encode($data);
		}

	}

	public function filter_lic_disburs(){
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
			$st_date = $this->input->post('st_date');
			$end_date = $this->input->post('end_date');
			$lic_id=$this->session->userdata['licenseeid'];

			$where = "d.dis_lic_id= '".$lic_id."'";
			if(!empty($st_date)){
				$start = get_ym_start($st_date);				
				$where .= " AND d.dis_createdate >= '".$start." 00:00:00'";
				
			}

			if(!empty($end_date)){
				$end = get_ym_end($end_date);				
				$where .= " AND d.dis_createdate <= '".$end." 23:59:59'"; 
			}

			$query = "SELECT dis_title,ia.ia_resource_id,dis_total_orders,dis_total_amt,dis_disburs_amount,dis_status as status
			,dis_modified_date ,dis_id
			FROM disbursment_report as d
			LEFT JOIN indassociation as ia ON ia.user_id =d.dis_ia_id 
			WHERE ".$where;

			$datatables = new Datatables(new CodeigniterAdapter);

			$datatables->query($query);

	        $datatables->edit('dis_total_amt', function ($data) {
	            return numfmt_format_currency($this->fmt,$data['dis_total_amt'], "USD");
	        });

	        $datatables->edit('dis_disburs_amount', function ($data) {
	            return numfmt_format_currency($this->fmt,$data['dis_disburs_amount'], "USD");
	        });

	        $datatables->edit('status', function ($data){
	        	return ($data['status']==0)?'Unpaid':'Paid';
	        });

	        $datatables->edit('dis_modified_date', function ($data){
	        	return date('m/d/Y',strtotime($data['dis_modified_date']));
	        });

			$datatables->edit('dis_id', function ($data) {
				$menu = '<li>
                        <a  href="javascript:void(0)" link="'.site_url().'">
                            <span class="glyphicon glyphicon-download"></span> View
                        </a>
                    	</li>';
				$menu = '<li>
                        <a  href="javascript:void(0)" link="'.site_url().'">
                            <span class="glyphicon glyphicon-download"></span> Update Status
                        </a>
                    	</li>';                    	
				$menu = '<li>
                        <a  href="javascript:void(0)" link="'.site_url().'">
                            <span class="glyphicon glyphicon-download"></span> Download
                        </a>
                    	</li>';

	        return '<div class="dropdown">
			<button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
			<i class="glyphicon glyphicon-option-vertical"></i>
			</button>
			<ul class="dropdown-menu">
			'.$menu.'    
			</ul></div>';
 			});
			echo $datatables->generate();
		}	
	}

	//===========LIC financial disbursement end=========
	//===========IA financial disbursement start=========

	public function ia_disbursment_report(){
		$ia=$this->session->userdata['iaid'];	
		$data['supplier'] = array();	
		$this->load->view('reports/ia_disbursment_report',$data); 
	}

	public function ia_disbursment_report_ajax(){
		$user_id=$this->session->userdata['iaid'];
		if($this->input->is_ajax_request()){

			$query = "SELECT dis_title,dis_total_orders,dis_total_amt,dis_disburs_amount,dis_status as status
			,dis_modified_date ,dis_id
			FROM disbursment_report as d
			WHERE d.dis_ia_id= '".$user_id."'";


			$datatables = new Datatables(new CodeigniterAdapter);

			$datatables->query($query);

	        $datatables->edit('dis_total_amt', function ($data) {
	            return numfmt_format_currency($this->fmt,$data['dis_total_amt'], "USD");
	        });

	        $datatables->edit('dis_disburs_amount', function ($data) {
	            return numfmt_format_currency($this->fmt,$data['dis_disburs_amount'], "USD");
	        });

	        $datatables->edit('status', function ($data){
	        	return ($data['status']==0)?'Unpaid':'Paid';
	        });

	        $datatables->edit('dis_modified_date', function ($data){
	        	return date('m/d/Y',strtotime($data['dis_modified_date']));
	        });

			$datatables->edit('dis_id', function ($data) {
				$menu = '<li>
                        <a  href="javascript:void(0)" link="'.site_url().'">
                            <span class="glyphicon glyphicon-download"></span> View
                        </a>
                    	</li>';
				$menu = '<li>
                        <a  href="javascript:void(0)" link="'.site_url().'">
                            <span class="glyphicon glyphicon-download"></span> Update Status
                        </a>
                    	</li>';                    	
				$menu = '<li>
                        <a  href="javascript:void(0)" link="'.site_url().'">
                            <span class="glyphicon glyphicon-download"></span> Download
                        </a>
                    	</li>';

	        return '<div class="dropdown">
			<button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
			<i class="glyphicon glyphicon-option-vertical"></i>
			</button>
			<ul class="dropdown-menu">
			'.$menu.'    
			</ul></div>';
 			});
			echo $datatables->generate();
		}		
	}

	public function ia_getTotal_monthly_disbrs(){

		if(!empty($this->input->post()) && $this->input->is_ajax_request()){

			$st_date = $this->input->post('st_date');
			$end_date = $this->input->post('end_date');
			//$ia_id = $this->input->post('ia_id');
			$ia_id = $this->session->userdata['iaid'];

			$where = "d.dis_ia_id= '".$ia_id."'";
			if(!empty($st_date)){
				$start = get_ym_start($st_date);				
				$where .= " AND d.dis_createdate >= '".$start." 00:00:00'"; 
			}

			if(!empty($end_date)){
				$end = get_ym_end($end_date);				
				$where .= " AND d.dis_createdate <= '".$end." 23:59:59'"; 
			}

			$query = "SELECT SUM(dis_total_amt) AS reconcile,SUM(dis_disburs_amount) AS disburse
				FROM disbursment_report as d
				WHERE ".$where;

			$data = $this->generalmodel->customquery($query,'row_array');

			$data['reconcile'] = numfmt_format_currency($this->fmt,$data['reconcile'], "USD");
			$data['disburse'] = numfmt_format_currency($this->fmt,$data['disburse'], "USD");
			echo json_encode($data);
		}
	}

	public function filter_ia_disburs(){
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
			$st_date = $this->input->post('st_date');
			$end_date = $this->input->post('end_date');
			$ia_id = $this->session->userdata['iaid'];

			$where = "d.dis_ia_id= '".$ia_id."'";
			if(!empty($st_date)){
				$start = get_ym_start($st_date);				
				$where .= " AND d.dis_createdate >= '".$start." 00:00:00'"; 
			}

			if(!empty($end_date)){
				$end = get_ym_end($end_date);				
				$where .= " AND d.dis_createdate <= '".$end." 23:59:59'"; 
			}

			$query = "SELECT dis_title,ia.ia_resource_id,dis_total_orders,dis_total_amt,dis_disburs_amount,dis_status as status
			,dis_modified_date ,dis_id
			FROM disbursment_report as d
			LEFT JOIN indassociation as ia ON ia.user_id =d.dis_ia_id 
			WHERE ".$where;

			$datatables = new Datatables(new CodeigniterAdapter);

			$datatables->query($query);

	        $datatables->edit('dis_total_amt', function ($data) {
	            return numfmt_format_currency($this->fmt,$data['dis_total_amt'], "USD");
	        });

	        $datatables->edit('dis_disburs_amount', function ($data) {
	            return numfmt_format_currency($this->fmt,$data['dis_disburs_amount'], "USD");
	        });

	        $datatables->edit('status', function ($data){
	        	return ($data['status']==0)?'Unpaid':'Paid';
	        });

	        $datatables->edit('dis_modified_date', function ($data){
	        	return date('m/d/Y',strtotime($data['dis_modified_date']));
	        });

			$datatables->edit('dis_id', function ($data) {
				$menu = '<li>
                        <a  href="javascript:void(0)" link="'.site_url().'">
                            <span class="glyphicon glyphicon-download"></span> View
                        </a>
                    	</li>';
				$menu = '<li>
                        <a  href="javascript:void(0)" link="'.site_url().'">
                            <span class="glyphicon glyphicon-download"></span> Update Status
                        </a>
                    	</li>';                    	
				$menu = '<li>
                        <a  href="javascript:void(0)" link="'.site_url().'">
                            <span class="glyphicon glyphicon-download"></span> Download
                        </a>
                    	</li>';

	        return '<div class="dropdown">
			<button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
			<i class="glyphicon glyphicon-option-vertical"></i>
			</button>
			<ul class="dropdown-menu">
			'.$menu.'    
			</ul></div>';
 			});
			echo $datatables->generate();
		}	
	}
	//===========IA financial disbursement end=========
*/

	public function lic_reconciliation_report(){

		$lic=$this->session->userdata['licenseeid'];
		if($lic==''){ 
			if($this->userdata['urole_id']==1){
				redirect('licensee/viewlicensee'); 
			}elseif($this->userdata['urole_id']==2){
				redirect('industryassociation/viewia'); 
			}elseif($this->userdata['urole_id']==3){
				redirect('consumer/consumer'); 
			}
		}	
		$data['ialist'] =  $this->generalmodel->iaList($lic);
		
		$licData = $this->generalmodel->getlicdata($lic);
		$data['prod_list'] =  $this->generalmodel->li_assigned_products($licData['lic_id']);
		$data['prod_cat_list'] = $this->generalmodel->prod_cat_list();
		$data['supplier_list'] = $this->generalmodel->all_suppliers();
		$data['meta_title'] = 'Reconciliation Report';

		$this->load->view('reports/lic_reconciliation_report',$data); 
	}

	public function lic_reconciliation_report_ajax(){
		$lic=$this->session->userdata['licenseeid'];

		if($this->input->is_ajax_request()){

			$where = "o.`lic_id` =".$lic;
			
/*			$query = "SELECT o.ia_id,CONCAT_WS(' ',u.firstname,u.lastname) AS consumer_name,CONCAT_WS(' ',s.supplier_fname,s.supplier_lname) AS supplier_name,
			pc.prod_cat_name AS category,p.product_name,p.type,op.prod_qty AS total_orders,op.prod_total AS prod_total_amt

			FROM `orders` as o
			LEFT JOIN orders_product as op ON `o`.`orders_id`= `op`.`orders_id` 
			LEFT JOIN product as p ON `op`.`prod_id`= `p`.`prod_id`
			LEFT JOIN product_category as pc ON `pc`.`prod_cat_id`= `p`.`prod_cat_id` 
			LEFT JOIN supplier as s ON `s`.`supplier_id`= `p`.`supplier_id` 
			LEFT JOIN user as u ON `u`.`user_id`= `o`.`createdby`
			WHERE ".$where;*/

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


			/*	        
			$datatables->edit('prod_id', function ($data) {
				return '<a href="'.site_url('reports/download_lic_reconciliation/').$data['prod_id'].'" class="downldBtn" target="_blank" download="">Download <span class="glyphicon glyphicon-download-alt"></span></a>';
	        });*/

			echo $datatables->generate();
		}
	}

	public function filter_lic_reconciliation_total(){

		if($this->input->is_ajax_request()){

			$lic = $this->session->userdata['licenseeid'];

			$ia_id = $this->input->post('ia_id');
			$cid = $this->input->post('cid');
			$supplier = $this->input->post('supplier');
			$category = $this->input->post('category');
			$prod = $this->input->post('prod');
			$prodType = $this->input->post('prodType');
			$st_date = $this->input->post('st_date');
			$end_date = $this->input->post('end_date');

			$where ="o.`lic_id`=".$lic;
			if(!empty($cid)){
				$where .= " AND o.`createdby`=".$cid;
			}

			if(!empty($ia_id)){
				$where .= " AND o.`ia_id` =".$ia_id;	
			}

			if(!empty($supplier)){
				$where .= " AND  `s`.`supplier_id` = ".$supplier;
			}

			if(!empty($category)){
				$where .= " AND  `pc`.`prod_cat_id` = ".$category;
			}

			if(!empty($prod)){
				$where .= " AND  `p`.`prod_id`= ".$prod;
			}
			if(!empty($prodType)){
				$where .= " AND  `p`.`type`= '".$prodType."'";
			}

			if(!empty($st_date)){
				$start = get_ym_start($st_date);				
				$where .= " AND o.createdate >= '".$start." 00:00:00'"; 
			}

			if(!empty($end_date)){
				$end = get_ym_end($end_date);				
				$where .= " AND o.createdate <= '".$end." 23:59:59'"; 
			}	

			$query = "SELECT SUM(op.prod_qty) AS total_orders ,SUM(op.prod_total) AS prod_total_amt			
			FROM `orders` as o
			LEFT JOIN orders_product as op ON `o`.`orders_id`= `op`.`orders_id` 
			LEFT JOIN product as p ON `op`.`prod_id`= `p`.`prod_id`
			LEFT JOIN product_category as pc ON `pc`.`prod_cat_id`= `p`.`prod_cat_id` 
			LEFT JOIN supplier as s ON `s`.`supplier_id`= `p`.`supplier_id` 
			LEFT JOIN user as u ON `u`.`user_id`= `o`.`createdby`
			WHERE ".$where;

			$data = $this->generalmodel->customquery($query,'row_array');

			$data['total_orders'] = $data['total_orders'];
			$data['total_amount'] = numfmt_format_currency($this->fmt,$data['prod_total_amt'], "USD");
			echo json_encode($data);
		}
	}

	public function filter_lic_reconciliation(){
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){

			$lic = $this->session->userdata['licenseeid'];
			$ia_id = $this->input->post('ia_id');
			$cid = $this->input->post('cid');
			$supplier = $this->input->post('supplier');
			$category = $this->input->post('category');
			$prod = $this->input->post('prod');
			$prodType = $this->input->post('prodType');
			$st_date = $this->input->post('st_date');
			$end_date = $this->input->post('end_date');
			
			$where ="o.`lic_id`=".$lic;

			if(!empty($cid)){
				$where .= " AND o.`createdby`=".$cid;
			}

			if(!empty($ia_id)){
				$where .= " AND o.`ia_id`=".$ia_id;	
			}

			if(!empty($supplier)){
				$where .= " AND  `s`.`supplier_id` = ".$supplier;
			}

			if(!empty($category)){
				$where .= " AND  `pc`.`prod_cat_id` = ".$category;
			}

			if(!empty($prod)){
				$where .= " AND  `p`.`prod_id`= ".$prod;
			}
			if(!empty($prodType)){
				$where .= " AND  `p`.`type`= '".$prodType."'";
			}

			if(!empty($st_date)){
				$start = get_ym_start($st_date);				
				$where .= " AND o.createdate >= '".$start." 00:00:00'"; 
			}

			if(!empty($end_date)){
				$end = get_ym_end($end_date);				
				$where .= " AND o.createdate <= '".$end." 23:59:59'"; 
			}	


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
	            return numfmt_format_currency($this->fmt,$data['prod_total_amt'], "USD").' USD';
	        });
			echo $datatables->generate();
		}
	}
	
	public function export_lic_reconciliation(){
        set_time_limit(0);
        ini_set('memory_limit', -1);
		$lic = $this->session->userdata['licenseeid'];
		$ia_id = $this->input->post('ia');
		$cid = $this->input->post('consumer');
		$supplier = $this->input->post('supplier');
		$category = $this->input->post('prod_cat');
		$prod = $this->input->post('product');
		$prodType = $this->input->post('prod_type');
		$st_date = $this->input->post('startdate');
		$end_date = $this->input->post('enddate');
		
		$where ="o.`lic_id`=".$lic;

		if(!empty($cid)){
			$where .= " AND o.`createdby`=".$cid;
		}

		if(!empty($ia_id)){
			$where .= " AND o.`ia_id`=".$ia_id;	
		}

		if(!empty($supplier)){
			$where .= " AND  `s`.`supplier_id` = ".$supplier;
		}

		if(!empty($category)){
			$where .= " AND  `pc`.`prod_cat_id` = ".$category;
		}

		if(!empty($prod)){
			$where .= " AND  `p`.`prod_id`= ".$prod;
		}
		if(!empty($prodType)){
			$where .= " AND  `p`.`type`= '".$prodType."'";
		}

		if(!empty($st_date)){
			$start = get_ym_start($st_date);				
			$where .= " AND o.createdate >= '".$start." 00:00:00'"; 
		}

		if(!empty($end_date)){
			$end = get_ym_end($end_date);				
			$where .= " AND o.createdate <= '".$end." 23:59:59'"; 
		}	

		$query = "SELECT o.ia_id,CONCAT_WS(' ',u.firstname,u.lastname) AS consumer_name,b.business_name,
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
       
        $query=$this->db->query($query);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'lic_reconciliation-'.date('m-d-Y').'.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser
        

		$style = (new StyleBuilder())
		           ->setFontBold()
		           ->setFontSize(15)
		           ->setCellAlignment(CellAlignment::CENTER)
		           ->build();

		/** Create a row with cells and apply the style to all cells */
		$singleRow = WriterEntityFactory::createRowFromArray(['','','','Licensee Reconciliation Report','','',''], $style);
		$blankRow = WriterEntityFactory::createRowFromArray(['','','','','','','']);
		/** Add the row to the writer */
		$writer->addRow($singleRow);
		$writer->addRow($blankRow);

        
		$cellstyle = (new StyleBuilder())
           ->setFontBold()
           ->setFontSize(15)
           ->build();


        $cells = [
                WriterEntityFactory::createCell('Industry Association',$cellstyle),
                WriterEntityFactory::createCell('Consumer',$cellstyle),
                WriterEntityFactory::createCell('Supplier',$cellstyle),
                WriterEntityFactory::createCell('Category',$cellstyle),
                WriterEntityFactory::createCell('Product',$cellstyle),
                WriterEntityFactory::createCell('Product Type',$cellstyle),
                WriterEntityFactory::createCell('Total Orders',$cellstyle),
                WriterEntityFactory::createCell('Total Amount',$cellstyle),
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);

        foreach ($obj as $row) {
			
			$lic_ia_detail =  $this->generalmodel->get_iadata($row['ia_id']);
			$ia_name = $lic_ia_detail['business_name'];

            $data[0] = $ia_name;
            $data[1] = $row['consumer_name'];
            $data[2] = $row['business_name'];
            $data[3] = $row['category'];
            $data[4] = $row['product_name'];
            $data[5] = $row['type'];
            $data[6] = $row['total_orders'];
            $data[7] = numfmt_format_currency($this->fmt,$row['prod_total_amt'], "USD").' USD';
            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
        }
        
        $writer->close();
	}

	public function download_lic_reconciliation($pid){

        set_time_limit(0);
        ini_set('memory_limit', -1);
		$lic = $this->session->userdata['licenseeid'];
		
		$where ="o.`lic_id`=".$lic;

		if(!empty($pid)){
			$where .= " AND op.`prod_id`=".$pid;
		}

		$query = "SELECT o.ia_id,CONCAT_WS(' ',u.firstname,u.lastname) AS consumer_name,CONCAT_WS(' ',s.supplier_fname,s.supplier_lname) AS supplier_name,
		pc.prod_cat_name AS category,p.product_name,p.type,op.prod_qty AS total_orders,op.prod_total AS prod_total_amt,
		op.prod_id
		FROM `orders` as o
		LEFT JOIN orders_product as op ON `o`.`orders_id`= `op`.`orders_id` 
		LEFT JOIN product as p ON `op`.`prod_id`= `p`.`prod_id`
		LEFT JOIN product_category as pc ON `pc`.`prod_cat_id`= `p`.`prod_cat_id` 
		LEFT JOIN supplier as s ON `s`.`supplier_id`= `p`.`supplier_id` 
		LEFT JOIN user as u ON `u`.`user_id`= `o`.`createdby`
		WHERE ".$where;
       
        $query=$this->db->query($query);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'lic_reconciliation-'.date('m-d-Y').'.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser
        

		$style = (new StyleBuilder())
		           ->setFontBold()
		           ->setFontSize(15)
		           ->setCellAlignment(CellAlignment::CENTER)
		           ->build();

		/** Create a row with cells and apply the style to all cells */
		$singleRow = WriterEntityFactory::createRowFromArray(['','','','Licensee Reconciliation Report','','',''], $style);
		$blankRow = WriterEntityFactory::createRowFromArray(['','','','','','','']);
		/** Add the row to the writer */
		$writer->addRow($singleRow);
		$writer->addRow($blankRow);

        
		$cellstyle = (new StyleBuilder())
           ->setFontBold()
           ->setFontSize(15)
           ->build();


        $cells = [
                WriterEntityFactory::createCell('IA Name',$cellstyle),
                WriterEntityFactory::createCell('Consumer Name',$cellstyle),
                WriterEntityFactory::createCell('Supplier Name',$cellstyle),
                WriterEntityFactory::createCell('Category',$cellstyle),
                WriterEntityFactory::createCell('Product Name',$cellstyle),
                WriterEntityFactory::createCell('Product Type',$cellstyle),
                WriterEntityFactory::createCell('Total Orders',$cellstyle),
                WriterEntityFactory::createCell('Total Amount',$cellstyle),
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);

        foreach ($obj as $row) {
			
			$lic_ia_detail =  $this->generalmodel->get_iadata($row['ia_id']);
			$ia_name = $lic_ia_detail['username'];

            $data[0] = $ia_name;
            $data[1] = $row['consumer_name'];
            $data[2] = $row['supplier_name'];
            $data[3] = $row['category'];
            $data[4] = $row['product_name'];
            $data[5] = $row['type'];
            $data[6] = $row['total_orders'];
            $data[7] = $row['prod_total_amt'];
            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
        }
        
        $writer->close();
	
	}
	//========lic reconciliation end============

	//========ia reconciliation start============

	public function ia_reconciliation_report(){
		$ia=$this->session->userdata['iaid'];	
		if($ia==''){ 
			if($this->userdata['urole_id']==1){
				redirect('licensee/viewlicensee'); 
			}elseif($this->userdata['urole_id']==2){
				redirect('industryassociation/viewia'); 
			}elseif($this->userdata['urole_id']==3){
				redirect('consumer/consumer'); 
			}
		}	

		$data['consumerlist'] =  $this->generalmodel->consumerlist_of_ia_of_lic($ia);

		$iaData = $this->generalmodel->get_iadata($ia);

		//$data['prod_list'] =  $this->generalmodel->ia_assigned_products($iaData['ia_id']);
		$data['prod_cat_list'] = $this->generalmodel->prod_cat_list();
		$data['supplier_list'] = $this->generalmodel->all_suppliers();
		$data['meta_title'] = 'Reconciliation Report';

		$this->load->view('reports/ia_reconciliation_report',$data); 

	}

	public function ia_reconciliation_report_ajax(){
		$ia=$this->session->userdata['iaid'];	
		if($this->input->is_ajax_request()){

			$where = "o.`ia_id`=".$ia;
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
			echo $datatables->generate();
		}		
	}

	public function export_ia_reconciliation(){
        set_time_limit(0);
        ini_set('memory_limit', -1);

		$ia_id=$this->session->userdata['iaid'];	
		$cid = $this->input->post('consumer');
		$supplier = $this->input->post('supplier');
		$category = $this->input->post('prod_cat');
		$prod = $this->input->post('product');
		$prodType = $this->input->post('prod_type');
		$st_date = $this->input->post('startdate');
		$end_date = $this->input->post('enddate');
		
		$where = "o.`ia_id`=".$ia_id;

		if(!empty($cid)){
			$where .= " AND  o.`createdby` IN(".$cid.")";
		}

		if(!empty($supplier)){
			$where .= " AND  `s`.`supplier_id` = ".$supplier;
		}

		if(!empty($category)){
			$where .= " AND  `pc`.`prod_cat_id` = ".$category;
		}

		if(!empty($prod)){
			$where .= " AND  `p`.`prod_id`= ".$prod;
		}
		if(!empty($prodType)){
			$where .= " AND  `p`.`type`= '".$prodType."'";
		}

		if(!empty($st_date)){
			$start = get_ym_start($st_date);				
			$where .= " AND o.createdate >= '".$start." 00:00:00'"; 
		}

		if(!empty($end_date)){
			$end = get_ym_end($end_date);				
			$where .= " AND o.createdate <= '".$end." 23:59:59'"; 
		}	

		$query = "SELECT CONCAT_WS(' ',u.firstname,u.lastname) AS consumer_name,b.business_name,
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
 		
 		$query=$this->db->query($query);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'ia_reconciliation-'.date('m-d-Y').'.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser


		$style = (new StyleBuilder())
		           ->setFontBold()
		           ->setFontSize(15)
		           ->setCellAlignment(CellAlignment::CENTER)
		           ->build();

		/** Create a row with cells and apply the style to all cells */
		$singleRow = WriterEntityFactory::createRowFromArray(['','','','Industory Association Reconciliation Report','','',''], $style);
		$blankRow = WriterEntityFactory::createRowFromArray(['','','','','','','']);
		/** Add the row to the writer */
		$writer->addRow($singleRow);
		$writer->addRow($blankRow);

        
		$cellstyle = (new StyleBuilder())
           ->setFontBold()
           ->setFontSize(15)
           ->build();

        $cells = [
                WriterEntityFactory::createCell('Consumer ',$cellstyle),
                WriterEntityFactory::createCell('Supplier ',$cellstyle),
                WriterEntityFactory::createCell('Category',$cellstyle),
                WriterEntityFactory::createCell('Product ',$cellstyle),
                WriterEntityFactory::createCell('Product Type',$cellstyle),
                WriterEntityFactory::createCell('Total Orders',$cellstyle),
                WriterEntityFactory::createCell('Total Amount',$cellstyle),
        ];

        //=== add a row at a time ===//
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
        if(!empty($obj)){
	        foreach ($obj as $row) {
	            $data[1] = $row['consumer_name'];
	            $data[2] = $row['business_name'];
	            $data[3] = $row['category'];
	            $data[4] = $row['product_name'];
	            $data[5] = $row['type'];
	            $data[6] = $row['total_orders'];
	            //$data[7] = $row['prod_total_amt'];
	            $data[7] = numfmt_format_currency($this->fmt,$row['prod_total_amt'], "USD").' USD';
	            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
	        }
        }
        $writer->close();
	}
	public function filter_ia_reconciliation_total(){
		if($this->input->is_ajax_request()){

			$ia_id=$this->session->userdata['iaid'];	
			$cid = $this->input->post('cid');
			$supplier = $this->input->post('supplier');
			$category = $this->input->post('category');
			$prod = $this->input->post('prod');
			$prodType = $this->input->post('prodType');
			$st_date = $this->input->post('st_date');
			$end_date = $this->input->post('end_date');

			$where = "o.`ia_id`=".$ia_id;

			if(!empty($cid)){
				$where .= " AND  o.`createdby`=".$cid;
			}

			if(!empty($supplier)){
				$where .= " AND  `s`.`supplier_id` = ".$supplier;
			}

			if(!empty($category)){
				$where .= " AND  `pc`.`prod_cat_id` = ".$category;
			}

			if(!empty($prod)){
				$where .= " AND  `p`.`prod_id`= ".$prod;
			}
			if(!empty($prodType)){
				$where .= " AND  `p`.`type`= '".$prodType."'";
			}

			if(!empty($st_date)){
				$start = get_ym_start($st_date);				
				$where .= " AND o.createdate >= '".$start." 00:00:00'"; 
			}

			if(!empty($end_date)){
				$end = get_ym_end($end_date);				
				$where .= " AND o.createdate <= '".$end." 23:59:59'"; 
			}	

			$query = "SELECT SUM(op.prod_qty) AS total_orders ,SUM(op.prod_total) AS prod_total_amt
			FROM `orders` as o
			LEFT JOIN orders_product as op ON `o`.`orders_id`= `op`.`orders_id` 
			LEFT JOIN product as p ON `op`.`prod_id`= `p`.`prod_id`
			LEFT JOIN product_category as pc ON `pc`.`prod_cat_id`= `p`.`prod_cat_id` 
			LEFT JOIN supplier as s ON `s`.`supplier_id`= `p`.`supplier_id` 
			LEFT JOIN user as u ON `u`.`user_id`= `o`.`createdby`
			WHERE ".$where;

			$data = $this->generalmodel->customquery($query,'row_array');

			$data['total_orders'] = empty($data['total_orders'])?0:$data['total_orders'];
			$data['total_amount'] = numfmt_format_currency($this->fmt,$data['prod_total_amt'], "USD");
			echo json_encode($data);
		}
	}

	public function filter_ia_reconciliation(){
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){

			$ia_id=$this->session->userdata['iaid'];	
			$cid = $this->input->post('cid');
			$supplier = $this->input->post('supplier');
			$category = $this->input->post('category');
			$prod = $this->input->post('prod');
			$prodType = $this->input->post('prodType');
			$st_date = $this->input->post('st_date');
			$end_date = $this->input->post('end_date');

			$where = "o.`ia_id`=".$ia_id;

			if(!empty($cid)){
				$where .= " AND  o.`createdby` IN(".$cid.")";
			}

			if(!empty($supplier)){
				$where .= " AND  `s`.`supplier_id` = ".$supplier;
			}

			if(!empty($category)){
				$where .= " AND  `pc`.`prod_cat_id` = ".$category;
			}

			if(!empty($prod)){
				$where .= " AND  `p`.`prod_id`= ".$prod;
			}
			if(!empty($prodType)){
				$where .= " AND  `p`.`type`= '".$prodType."'";
			}

			if(!empty($st_date)){
				$start = get_ym_start($st_date);				
				$where .= " AND o.createdate >= '".$start." 00:00:00'"; 
			}

			if(!empty($end_date)){
				$end = get_ym_end($end_date);				
				$where .= " AND o.createdate <= '".$end." 23:59:59'"; 
			}	

			$query = "SELECT CONCAT_WS(' ',u.firstname,u.lastname) AS consumer_name,b.business_name,
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

	        $datatables->edit('prod_total_amt', function ($data) {
	            return numfmt_format_currency($this->fmt,$data['prod_total_amt'], "USD").' USD';
	        });
			echo $datatables->generate();
		}			
	}

	//========ia reconciliation end============

	//========lic transaction summary start============


	public function lic_transaction_summary(){
		$lic=$this->session->userdata['licenseeid'];
		$data['meta_title'] = 'Transaction Summary';

		$this->load->view('reports/lic_transaction_report'); 
	}

	public function lic_transaction_summary_ajax(){
		$lic=$this->session->userdata['licenseeid'];
		if($this->input->is_ajax_request()){

			$where = "o.`lic_id`= ".$lic;
			$query = "SELECT o.createdate,o.lic_id,o.ia_id,CONCAT_WS(' ',u.firstname,u.lastname) AS consumer_name,
			total_amt,order_amt,lic_disburse
			FROM `orders` as o
			LEFT JOIN user as u ON `u`.`user_id`= `o`.`createdby`
			WHERE ".$where;

			$datatables = new Datatables(new CodeigniterAdapter);

			$datatables->query($query);

	        $datatables->edit('createdate', function ($data) {
	            //return date('m/d/Y',strtotime($data['createdate']));
				$modi = gmdate_to_mydate($data['createdate'],$this->localtimzone);
				return date('m/d/Y',strtotime($modi));	            
	        });

			$datatables->edit('lic_id', function ($data){
				$licData =  $this->generalmodel->getlicdata($data['lic_id']);
				if(!empty($licData)){
					return $licData['business_name'];
				}else{
					return '';
				}
			});

			$datatables->edit('ia_id', function ($data){
				$iaData =  $this->generalmodel->get_iadata($data['ia_id']);
				if(!empty($iaData)){
					return $iaData['business_name'];
				}else{
					return '';
				}				
			});

	        $datatables->edit('total_amt', function ($data) {
	            return numfmt_format_currency($this->fmt,$data['total_amt'], "USD");
	        });

	        $datatables->edit('order_amt', function ($data) {
	            return numfmt_format_currency($this->fmt,$data['order_amt'], "USD");
	        });

	        $datatables->edit('lic_disburse', function ($data) {
	            return numfmt_format_currency($this->fmt,$data['lic_disburse'], "USD");
	        });
			echo $datatables->generate();
		}			
	}

	public function filter_lic_transac_summ_total(){
		if($this->input->is_ajax_request()){

			$st_date = $this->input->post('st_date');
			$end_date = $this->input->post('end_date');
			
			$lic=$this->session->userdata['licenseeid'];
	
			$where = "o.`lic_id`= ".$lic;
			if(!empty($st_date)){
				$start = get_ym_start($st_date);				
				$where .= " AND o.createdate >= '".$start." 00:00:00'"; 
			}

			if(!empty($end_date)){
				$end = get_ym_end($end_date);				
				$where .= " AND o.createdate <= '".$end." 23:59:59'"; 
			}					

			$query = "SELECT SUM(total_amt) AS total_amt,SUM(order_amt) AS ord_total,SUM(lic_disburse) AS disburse_total
			FROM `orders` as o
			LEFT JOIN user as u ON `u`.`user_id`= `o`.`createdby`
			WHERE ".$where;

			$data = $this->generalmodel->customquery($query,'row_array');

			$data['ord_total'] = numfmt_format_currency($this->fmt,$data['ord_total'], "USD");
			$data['disburse_total'] = numfmt_format_currency($this->fmt,$data['disburse_total'], "USD");
			echo json_encode($data);
		}
	}

	public function filter_lic_transac_summry(){

		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
			
			$st_date = $this->input->post('st_date');
			$end_date = $this->input->post('end_date');
			$lic_id=$this->session->userdata['licenseeid'];

			$where = "o.`lic_id`=".$lic_id;

			if(!empty($st_date)){
				$start = get_ym_start($st_date);				
				$where .= " AND o.createdate >= '".$start." 00:00:00'"; 
			}

			if(!empty($end_date)){
				$end = get_ym_end($end_date);				
				$where .= " AND o.createdate <= '".$end." 23:59:59'"; 
			}		

			$query = "SELECT o.createdate,o.lic_id,o.ia_id,CONCAT_WS(' ',u.firstname,u.lastname) AS consumer_name,
			total_amt,order_amt,lic_disburse
			FROM `orders` as o
			LEFT JOIN user as u ON `u`.`user_id`= `o`.`createdby`
			WHERE ".$where;

			$datatables = new Datatables(new CodeigniterAdapter);

			$datatables->query($query);


	        $datatables->edit('createdate', function ($data) {
	            //return date('m/d/Y',strtotime($data['createdate']));
				$modi = gmdate_to_mydate($data['createdate'],$this->localtimzone);
				return date('m/d/Y',strtotime($modi));		            
	        });

			$datatables->edit('lic_id', function ($data){
				$licData =  $this->generalmodel->getlicdata($data['lic_id']);
				if(!empty($licData)){
					return $licData['business_name'];
				}else{
					return '';
				}
			});

			$datatables->edit('ia_id', function ($data){
				$iaData =  $this->generalmodel->get_iadata($data['ia_id']);
				if(!empty($iaData)){
					return $iaData['business_name'];
				}else{
					return '';
				}				
			});

	        $datatables->edit('total_amt', function ($data) {
	            return numfmt_format_currency($this->fmt,$data['total_amt'], "USD");
	        });

	        $datatables->edit('order_amt', function ($data) {
	            return numfmt_format_currency($this->fmt,$data['order_amt'], "USD");
	        });

	        $datatables->edit('lic_disburse', function ($data) {
	            return numfmt_format_currency($this->fmt,$data['lic_disburse'], "USD");
	        });
			echo $datatables->generate();
		}			
	}

	public function export_lic_trans_summ(){
        set_time_limit(0);
        ini_set('memory_limit', -1);

		$st_date = $this->input->post('startdate');
		$end_date = $this->input->post('enddate');
		$lic_id=$this->session->userdata['licenseeid'];

		$where = "o.`lic_id`=".$lic_id;
		if(!empty($st_date)){
			$start = get_ym_start($st_date);				
			$where .= " AND o.createdate >= '".$start." 00:00:00'"; 
		}

		if(!empty($end_date)){
			$end = get_ym_end($end_date);				
			$where .= " AND o.createdate <= '".$end." 23:59:59'"; 
		}		

		$query = "SELECT o.createdate,o.lic_id,o.ia_id,CONCAT_WS(' ',u.firstname,u.lastname) AS consumer_name,
		o.ia_id,total_amt,order_amt,lic_disburse
		FROM `orders` as o
		LEFT JOIN user as u ON `u`.`user_id`= `o`.`createdby`
		WHERE ".$where;
		
 		$query=$this->db->query($query);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'lic_transaction_summary-'.date('m-d-Y').'.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser


		$style = (new StyleBuilder())
		           ->setFontBold()
		           ->setFontSize(15)
		           ->setCellAlignment(CellAlignment::CENTER)
		           ->build();

		/** Create a row with cells and apply the style to all cells */
		$singleRow = WriterEntityFactory::createRowFromArray(['','','','Licensee Transaction Summary Report','','',''], $style);
		$blankRow = WriterEntityFactory::createRowFromArray(['','','','','','','']);
		/** Add the row to the writer */
		$writer->addRow($singleRow);
		$writer->addRow($blankRow);

        
		$cellstyle = (new StyleBuilder())
           ->setFontBold()
           ->setFontSize(15)
           ->build();

        $cells = [
                WriterEntityFactory::createCell('Order Date and Time',$cellstyle),
                WriterEntityFactory::createCell('Licensee',$cellstyle),
                WriterEntityFactory::createCell('Industry Association',$cellstyle),
                WriterEntityFactory::createCell('Consumer',$cellstyle),
                WriterEntityFactory::createCell('Total Amount',$cellstyle),
                WriterEntityFactory::createCell('Total Order',$cellstyle),
                WriterEntityFactory::createCell('Order Total to Disburse',$cellstyle),
        ];

        //=== add a row at a time ===//
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
        if(!empty($obj)){
	        foreach ($obj as $row) {

	        	$lic = $ia = '';

				$licData =  $this->generalmodel->getlicdata($row['lic_id']);
				if(!empty($licData)){ $lic =  $licData['business_name'];}

				$iaData =  $this->generalmodel->get_iadata($row['ia_id']);
				if(!empty($iaData)){ $ia= $iaData['business_name']; }

				$modi = gmdate_to_mydate($row['createdate'],$this->localtimzone);

				//$get_iadata =  $this->generalmodel->get_iadata($row['ia_id']);

	            $data[1] = date('m/d/Y',strtotime($modi));
	            $data[2] = $lic;
	            $data[3] = $ia;
	            $data[4] = $row['consumer_name'];
	            // $data[5] = $get_iadata['username'];
	            $data[5] = numfmt_format_currency($this->fmt,$row['total_amt'], "USD").' USD';
	            $data[6] = numfmt_format_currency($this->fmt,$row['order_amt'], "USD").' USD';
	            $data[7] = numfmt_format_currency($this->fmt,$row['lic_disburse'], "USD").' USD';
	            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
	        }
        }
        $writer->close();        		
	}
	//========lic transaction summary end============


	//========ia transaction summary start===========
	public function ia_transaction_summary(){
		$ia=$this->session->userdata['iaid'];
		$data['meta_title'] = 'Transaction Summary';

		$this->load->view('reports/ia_transaction_summary'); 
	}

	public function ia_transaction_summary_ajax(){
		$ia_ids=$this->session->userdata['iaid'];
		if($this->input->is_ajax_request()){

			$where = "o.`ia_id` =".$ia_ids;
			$query = "SELECT o.createdate,o.lic_id,o.ia_id,CONCAT_WS(' ',u.firstname,u.lastname) AS consumer_name,
			total_amt,order_amt,lic_disburse
			FROM `orders` as o
			LEFT JOIN user as u ON `u`.`user_id`= `o`.`createdby`
			WHERE ".$where." ORDER BY o.orders_id";

			$datatables = new Datatables(new CodeigniterAdapter);
			$datatables->query($query);


	        $datatables->edit('createdate', function ($data) {
	            //return date('m/d/Y',strtotime($data['createdate']));
				$modi = gmdate_to_mydate($data['createdate'],$this->localtimzone);
				return date('m/d/Y',strtotime($modi));	 	            
	        });


			$datatables->edit('lic_id', function ($data){
				$licData =  $this->generalmodel->getlicdata($data['lic_id']);
				if(!empty($licData)){
					return $licData['business_name'];
				}else{
					return '';
				}
			});

			$datatables->edit('ia_id', function ($data){
				$iaData =  $this->generalmodel->get_iadata($data['ia_id']);
				if(!empty($iaData)){
					return $iaData['business_name'];
				}else{
					return '';
				}				
			});

	        $datatables->edit('total_amt', function ($data) {
	            return numfmt_format_currency($this->fmt,$data['total_amt'], "USD").' USD';
	        });

	        $datatables->edit('order_amt', function ($data) {
	            return numfmt_format_currency($this->fmt,$data['order_amt'], "USD").' USD';
	        });

	        $datatables->edit('lic_disburse', function ($data) {
	            return numfmt_format_currency($this->fmt,$data['lic_disburse'], "USD").' USD';
	        });
			echo $datatables->generate();
		}			
	}

	public function filter_ia_transac_summ_total(){
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){

			$st_date = $this->input->post('st_date');
			$end_date = $this->input->post('end_date');
			$ia_id = $this->session->userdata['iaid'];			

			// $consumerlist =  $this->generalmodel->consumerlist_of_ia_of_lic($ia_id);
			// $consumer_ids = implode(',', array_column($consumerlist, 'user_id'));
			
			// $where = "o.`createdby`IN(".$consumer_ids.")";
			$where = "o.`ia_id` =".$ia_id;

			if(!empty($st_date)){
				$start = get_ym_start($st_date);				
				$where .= " AND o.createdate >= '".$start." 00:00:00'"; 
			}

			if(!empty($end_date)){
				$end = get_ym_end($end_date);				
				$where .= " AND o.createdate <= '".$end." 23:59:59'"; 
			}			

			$query = "SELECT SUM(total_amt) AS total_amt ,SUM(order_amt) AS ord_total,SUM(lic_disburse) AS disburse_total
			FROM `orders` as o
			LEFT JOIN user as u ON `u`.`user_id`= `o`.`createdby`
			WHERE ".$where;

			$data = $this->generalmodel->customquery($query,'row_array');

			$data['ord_total'] = numfmt_format_currency($this->fmt,$data['ord_total'], "USD");
			$data['disburse_total'] = numfmt_format_currency($this->fmt,$data['disburse_total'], "USD");
			echo json_encode($data);
		}
	}
	public function filter_ia_transac_summry(){
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
			$st_date = $this->input->post('st_date');
			$end_date = $this->input->post('end_date');
			$ia_id = $this->session->userdata['iaid'];			

			// $data['consumerlist'] =  $this->generalmodel->consumerlist_of_ia_of_lic($ia_id);
			// $consumer_ids = implode(',', array_column($data['consumerlist'], 'user_id'));

			//$where = "o.`createdby`IN(".$consumer_ids.")";
			$where = "o.`ia_id`= ".$ia_id;

			if(!empty($st_date)){
				$start = get_ym_start($st_date);				
				$where .= " AND o.createdate >= '".$start." 00:00:00'"; 
			}

			if(!empty($end_date)){
				$end = get_ym_end($end_date);				
				$where .= " AND o.createdate <= '".$end." 23:59:59'"; 
			}		

			$query = "SELECT o.createdate,o.lic_id,o.ia_id,CONCAT_WS(' ',u.firstname,u.lastname) AS consumer_name,
			total_amt,order_amt,lic_disburse
			FROM `orders` as o
			LEFT JOIN user as u ON `u`.`user_id`= `o`.`createdby`
			WHERE ".$where;

			$datatables = new Datatables(new CodeigniterAdapter);

			$datatables->query($query);

	        $datatables->edit('createdate', function ($data) {
	            //return date('m/d/Y',strtotime($data['createdate']));
				$modi = gmdate_to_mydate($data['createdate'],$this->localtimzone);
				return date('m/d/Y',strtotime($modi));		            
	        });


			$datatables->edit('lic_id', function ($data){
				$licData =  $this->generalmodel->getlicdata($data['lic_id']);
				if(!empty($licData)){
					return $licData['business_name'];
				}else{
					return '';
				}
			});

			$datatables->edit('ia_id', function ($data){
				$iaData =  $this->generalmodel->get_iadata($data['ia_id']);
				if(!empty($iaData)){
					return $iaData['business_name'];
				}else{
					return '';
				}				
			});

	        $datatables->edit('total_amt', function ($data) {
	            return numfmt_format_currency($this->fmt,$data['total_amt'], "USD").' USD';
	        });

	        $datatables->edit('order_amt', function ($data) {
	            return numfmt_format_currency($this->fmt,$data['order_amt'], "USD").' USD';
	        });

	        $datatables->edit('lic_disburse', function ($data) {
	            return numfmt_format_currency($this->fmt,$data['lic_disburse'], "USD").' USD';
	        });
			echo $datatables->generate();
		}			
	}

	public function export_ia_trans_summ(){

		$st_date = $this->input->post('startdate');
		$end_date = $this->input->post('enddate');
		$ia_id = $this->session->userdata['iaid'];			

		// $data['consumerlist'] =  $this->generalmodel->consumerlist_of_ia_of_lic($ia_id);
		// $consumer_ids = implode(',', array_column($data['consumerlist'], 'user_id'));

		// $where = "o.`createdby`IN(".$consumer_ids.")";

		$where = "o.`ia_id`= ".$ia_id;

		if(!empty($st_date)){
			$start = get_ym_start($st_date);				
			$where .= " AND o.createdate >= '".$start." 00:00:00'"; 
		}

		if(!empty($end_date)){
			$end = get_ym_end($end_date);				
			$where .= " AND o.createdate <= '".$end." 23:59:59'"; 
		}		

		$query = "SELECT o.createdate,o.lic_id,o.ia_id,CONCAT_WS(' ',u.firstname,u.lastname) AS consumer_name,
		total_amt,order_amt,lic_disburse
		FROM `orders` as o
		LEFT JOIN user as u ON `u`.`user_id`= `o`.`createdby`
		WHERE ".$where;
		
 		$query=$this->db->query($query);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'ia_transaction_summary-'.date('m-d-Y').'.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser


		$style = (new StyleBuilder())
		           ->setFontBold()
		           ->setFontSize(15)
		           ->setCellAlignment(CellAlignment::CENTER)
		           ->build();

		/** Create a row with cells and apply the style to all cells */
		$singleRow = WriterEntityFactory::createRowFromArray(['','','','Industry Association Transaction Summary Report','','',''], $style);
		$blankRow = WriterEntityFactory::createRowFromArray(['','','','','','','']);
		/** Add the row to the writer */
		$writer->addRow($singleRow);
		$writer->addRow($blankRow);

        
		$cellstyle = (new StyleBuilder())
           ->setFontBold()
           ->setFontSize(15)
           ->build();

        $cells = [
                WriterEntityFactory::createCell('Order Date and Time',$cellstyle),
                WriterEntityFactory::createCell('Licensee',$cellstyle),
                WriterEntityFactory::createCell('Industry Association',$cellstyle),
                WriterEntityFactory::createCell('Consumer',$cellstyle),
                WriterEntityFactory::createCell('Total Amount',$cellstyle),
                WriterEntityFactory::createCell('Total Order',$cellstyle),
                WriterEntityFactory::createCell('Order Total to Disburse',$cellstyle),
        ];

        //=== add a row at a time ===//
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
        if(!empty($obj)){
	        foreach ($obj as $row) {


				$modi = gmdate_to_mydate($row['createdate'],$this->localtimzone);
				$lic= $ia= '';

				$licData =  $this->generalmodel->getlicdata($row['lic_id']);
				if(!empty($licData)){
					$lic= $licData['business_name'];
				}

				$iaData =  $this->generalmodel->get_iadata($row['ia_id']);
				if(!empty($iaData)){
					$ia =  $iaData['business_name'];
				}				

	            $data[1] = date('m/d/Y',strtotime($modi));
	            $data[2] = $lic;
	            $data[3] = $ia;
	            $data[4] = $row['consumer_name'];
	            $data[5] = numfmt_format_currency($this->fmt,$row['total_amt'], "USD").' USD';
	            $data[6] = numfmt_format_currency($this->fmt,$row['order_amt'], "USD").' USD';
	            $data[7] = numfmt_format_currency($this->fmt,$row['lic_disburse'], "USD").' USD';
	            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
	        }
        }
        $writer->close(); 		
	}
	//========ia transaction summary end============

	//===========LIC module ia financial end=========
/*
	public function ia_purchase_report(){
		$this->load->view('reports/ia_purchase');
	}

	public function ia_purchase_data(){
		$datatables = new Datatables(new CodeigniterAdapter);

		$userid = $this->userdata['user_id'];
		$consumer_id_arr = $this->generalmodel->ia_customer_ids($userid);	
		if(!empty($consumer_id_arr)){
			$consumer_ids = $consumer_id_arr['ids'];
			$datatables->query('SELECT o.orders_id, p.product_sku,p.product_name,p.type,s.supplier_fname, SUM(op.prod_qty) AS qty,SUM(op.prod_total) AS amount FROM `orders` as o  LEFT JOIN orders_product as op ON op.orders_id = o.orders_id LEFT JOIN product as p ON p.prod_id = op.prod_id LEFT JOIN supplier as s ON s.supplier_id = p.supplier_id WHERE o.createdby IN('.$consumer_ids.') GROUP BY op.prod_id');
			echo $datatables->generate();
		}
	}
	*/

	
	//*******==========Cron========*******// 
	//===========LIC module ia sales report cron start=========

	public function sales_report(){
		// $month_st_date = date('Y-m-01');
		// $month_end_date = date('Y-m-t');

		$month_st_date = date('Y-07-01');
		$month_end_date = date('Y-07-t');

		// $orderTble = "SELECT `u`.`createdby` AS ia_id,`o`.`orders_id`,`p`.`product_name`,`p`.`product_sku`,`p`.`type`,`p`.`supplier_id`,CONCAT_WS(' ',s.supplier_fname,s.supplier_lname) AS supplier_name
		// FROM `orders` as o
		// LEFT JOIN `user` as u ON `o`.`createdby`= `u`.`user_id`
		// WHERE o.`createdate` >='".$month_st_date."' AND o.`createdate` <='".$month_end_date."'";



		$query = "SELECT DISTINCT `op`.`prod_id`, GROUP_CONCAT(DISTINCT orders_id SEPARATOR ',') AS ord_id, SUM(`op`.`prod_total`) AS amount, SUM(`op`.`prod_qty`) AS qty,
		`op`.`orders_id`,`p`.`product_name`,`p`.`product_sku`,`p`.`type`,`p`.`supplier_id`,
		CONCAT_WS(' ',s.supplier_fname,s.supplier_lname) AS supplier_name 
		FROM `orders_product` as op 
		LEFT JOIN `product` as p ON `p`.`prod_id`= `op`.`prod_id` 
		LEFT JOIN `supplier` as s ON s.`supplier_id`= p.`supplier_id` 
		WHERE op.`createdate` >='".$month_st_date."' AND op.`createdate` <='".$month_end_date."' 
		GROUP BY `prod_id`
		ORDER BY `op`.`prod_id` ASC";
			
		$salebyprod = $this->db->query($query)->result_array();
		
		if(!empty($salebyprod)){

			$createdate = date('Y-m-d h:i:s');

			foreach($salebyprod as $value){

				$getconsumers = $this->db->query("SELECT `o`.`createdby` AS userid, `u`.`createdby` AS ia_id FROM orders as o 
				LEFT JOIN `user` as u ON `u`.`user_id`= `o`.`createdby`					
				WHERE `orders_id` IN(".$value['ord_id'].") ")->result_array();

				echo $this->db->last_query();
				echo "<pre>"; print_r($getconsumers); exit;

		// 	$salesData['sales_associate_consumer_id'] = 
		// 	$insertData['ia_id']
		// 	$insertData['lic_id']

		// 	$insertData['sales_associate_id']
		// 	$insertData['sr_product_id'] = $value['prod_id'];
		// 	$insertData['sr_product_sku'] = $value['product_sku'];
		// 	$insertData['sr_product_name'] = $value['product_name'];
		// 	$insertData['sr_product_type'] = $value['type'];
		// 	$insertData['sr_qty'] = $value['qty'];
		// 	$insertData['sr_total_amount'] = $value['amount'];
		// 	$insertData['sr_supplier_id'] = $value['supplier_id'];
		// 	$insertData['sr_supplier_name'] = $value['supplier_name'];

		// 	$insertData['sales_createdate'] = $createdate
		} }
		echo $this->db->last_query();
		echo "<pre>"; print_r($salebyprod);
		exit;
	}
	//===========LIC module ia sales report cron end=========	
	//*******==========Cron========*******// 


	//===========Reconciliation Report for all Licensee Start Here =========	
	
	public function general_reconciliation_report(){

		//$data['ialist'] =  $this->generalmodel->iaList();
		$data['liclist'] =  $this->generalmodel->all_licensee();
		$data['prod_cat_list'] = $this->generalmodel->prod_cat_list();
		$data['supplier_list'] = $this->generalmodel->all_suppliers();
		$data['meta_title'] = 'Reconciliation Report';

		$this->load->view('reports/general_reconciliation_report',$data); 
	}

	public function general_reconciliation_report_ajax(){

		if($this->input->is_ajax_request()){

			/*
			$query = "SELECT u.user_id,CONCAT_WS(' ',u.firstname,u.lastname) AS consumer_name,CONCAT_WS(' ',s.supplier_fname,s.supplier_lname) AS supplier_name,
			pc.prod_cat_name AS category,p.product_name,p.type,op.prod_qty AS total_orders ,op.prod_total AS prod_total_amt,
			o.orders_id
			FROM `orders` as o
			LEFT JOIN orders_product as op ON `o`.`orders_id`= `op`.`orders_id` 
			LEFT JOIN product as p ON `op`.`prod_id`= `p`.`prod_id`
			LEFT JOIN product_category as pc ON `pc`.`prod_cat_id`= `p`.`prod_cat_id` 
			LEFT JOIN supplier as s ON `s`.`supplier_id`= `p`.`supplier_id` 
			LEFT JOIN user as u ON `u`.`user_id`= `o`.`createdby` ";
			*/

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
			GROUP BY `op`.`prod_id`,`o`.`createdby`
			ORDER BY prod_total_amt";

			$datatables = new Datatables(new CodeigniterAdapter);

			$datatables->query($query);

			
			$datatables->edit('lic_id', function ($data){
				$licData =  $this->generalmodel->getlicdata($data['lic_id']);
				if(!empty($licData)){
					return $licData['business_name'];
				}else{
					return '';
				}
			});

			$datatables->edit('ia_id', function ($data){
				$iaData =  $this->generalmodel->get_iadata($data['ia_id']);
				if(!empty($iaData)){
					return $iaData['business_name'];
				}else{
					return '';
				}				
			});

	        $datatables->edit('prod_total_amt', function ($data) {
	            return numfmt_format_currency($this->fmt,$data['prod_total_amt'], "USD").' USD';
	        });
			echo $datatables->generate();
		}
	}

	public function filter_general_reconciliation(){

		if(!empty($this->input->post()) && $this->input->is_ajax_request()){

			$lic_id = $this->input->post('lic_id');
			$ia_id = $this->input->post('ia_id');
			$cid = $this->input->post('cid');
			$supplier = $this->input->post('supplier');
			$category = $this->input->post('category');
			$prod = $this->input->post('prod');
			$prodType = $this->input->post('prodType');
			$st_date = $this->input->post('st_date');
			$end_date = $this->input->post('end_date');

			$where = "(1=1)";

			if(!empty($lic_id)){
				$where .= " AND o.`lic_id` =".$lic_id;	
			}

			if(!empty($cid)){
				$where .= " AND o.`createdby`=".$cid;
			}

			if(!empty($ia_id)){
				$where .= " AND o.`ia_id` =".$ia_id;	
			}

			if(!empty($supplier)){
				$where .= " AND  `s`.`supplier_id` = ".$supplier;
			}

			if(!empty($category)){
				$where .= " AND  `pc`.`prod_cat_id` = ".$category;
			}

			if(!empty($prod)){
				$where .= " AND  `p`.`prod_id`= ".$prod;
			}
			if(!empty($prodType)){
				$where .= " AND  `p`.`type`= '".$prodType."'";
			}

			if(!empty($st_date)){
				$start = get_ym_start($st_date);				
				$where .= " AND o.createdate >= '".$start." 00:00:00'"; 
			}

			if(!empty($end_date)){
				$end = get_ym_end($end_date);				
				$where .= " AND o.createdate <= '".$end." 23:59:59'"; 
			}	
			
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
			WHERE  ".$where." GROUP BY `op`.`prod_id`,`o`.`createdby`
			ORDER BY prod_total_amt";

			$datatables = new Datatables(new CodeigniterAdapter);

			$datatables->query($query);

			$datatables->edit('lic_id', function ($data){
				$licData =  $this->generalmodel->getlicdata($data['lic_id']);
				if(!empty($licData)){
					return $licData['business_name'];
				}else{
					return '';
				}
			});

			$datatables->edit('ia_id', function ($data){
				$iaData =  $this->generalmodel->get_iadata($data['ia_id']);
				if(!empty($iaData)){
					return $iaData['business_name'];
				}else{
					return '';
				}				
			});
	        $datatables->edit('prod_total_amt', function ($data) {
	            return numfmt_format_currency($this->fmt,$data['prod_total_amt'], "USD");
	        });
			echo $datatables->generate();
		}
	}

	public function export_general_reconciliation(){
        set_time_limit(0);
        ini_set('memory_limit', -1);

		$lic_id = $this->input->post('lic');
		$ia_id = $this->input->post('ia');
		$cid = $this->input->post('consumer');
		$supplier = $this->input->post('supplier');
		$category = $this->input->post('prod_cat');
		$prod = $this->input->post('product');
		$prodType = $this->input->post('prod_type');
		$st_date = $this->input->post('startdate');
		$end_date = $this->input->post('enddate');

		$where = "(1=1)";

		if(!empty($lic_id)){
			$where .= " AND o.`lic_id` =".$lic_id;	
		}		
		if(!empty($cid)){
			$where .= " AND o.`createdby`=".$cid;
		}

		if(!empty($ia_id)){
			$where .= " AND o.`ia_id` =".$ia_id;	
		}

		if(!empty($supplier)){
			$where .= " AND  `s`.`supplier_id` = ".$supplier;
		}

		if(!empty($category)){
			$where .= " AND  `pc`.`prod_cat_id` = ".$category;
		}

		if(!empty($prod)){
			$where .= " AND  `p`.`prod_id`= ".$prod;
		}
		if(!empty($prodType)){
			$where .= " AND  `p`.`type`= '".$prodType."'";
		}

		if(!empty($st_date)){
			$start = get_ym_start($st_date);				
			$where .= " AND o.createdate >= '".$start." 00:00:00'"; 
		}

		if(!empty($end_date)){
			$end = get_ym_end($end_date);				
			$where .= " AND o.createdate <= '".$end." 23:59:59'"; 
		}	

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
		WHERE ".$where." GROUP BY `op`.`prod_id`,`o`.`createdby`
		ORDER BY prod_total_amt";
			
 		$query=$this->db->query($query);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'general_reconciliation-'.date('m-d-Y').'.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser


		$style = (new StyleBuilder())
		           ->setFontBold()
		           ->setFontSize(15)
		           ->setCellAlignment(CellAlignment::CENTER)
		           ->build();

		/** Create a row with cells and apply the style to all cells */
		$singleRow = WriterEntityFactory::createRowFromArray(['','','','General Reconciliation Report','','',''], $style);
		$blankRow = WriterEntityFactory::createRowFromArray(['','','','','','','']);
		/** Add the row to the writer */
		$writer->addRow($singleRow);
		$writer->addRow($blankRow);

        
		$cellstyle = (new StyleBuilder())
           ->setFontBold()
           ->setFontSize(15)
           ->build();

        $cells = [
                WriterEntityFactory::createCell('Licensee',$cellstyle),
                WriterEntityFactory::createCell('Industry Association',$cellstyle),
                WriterEntityFactory::createCell('Consumer',$cellstyle),
                WriterEntityFactory::createCell('Supplier',$cellstyle),
                WriterEntityFactory::createCell('Category',$cellstyle),
                WriterEntityFactory::createCell('Product',$cellstyle),
                WriterEntityFactory::createCell('Product Type',$cellstyle),
                WriterEntityFactory::createCell('Total Orders',$cellstyle),
                WriterEntityFactory::createCell('Total Amount',$cellstyle),
        ];

        //=== add a row at a time ===//
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
        if(!empty($obj)){
	        foreach ($obj as $row) {
	        	$lic = $ia = '';

				$licData =  $this->generalmodel->getlicdata($row['lic_id']);
				if(!empty($licData)){
					$lic = $licData['business_name'];
				}

				$iaData =  $this->generalmodel->get_iadata($row['ia_id']);
				if(!empty($iaData)){
					$ia =  $iaData['business_name'];
				}			

	            $data[1] = $lic;
	            $data[2] = $ia;
	            $data[3] = $row['consumer_name'];
	            $data[4] = $row['business_name'];
	            $data[5] = $row['category'];
	            $data[6] = $row['product_name'];
	            $data[7] = $row['type'];
	            $data[8] = $row['total_orders'];
	            $data[9] = $row['prod_total_amt'];
	            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
	        }
        }
        $writer->close();
	}

	public function filter_general_reconciliation_total(){

		if($this->input->is_ajax_request()){

			$ia_id = $this->input->post('ia_id');
			$cid = $this->input->post('cid');
			$supplier = $this->input->post('supplier');
			$category = $this->input->post('category');
			$prod = $this->input->post('prod');
			$prodType = $this->input->post('prodType');
			$st_date = $this->input->post('st_date');
			$end_date = $this->input->post('end_date');
			
			$where = "(1=1)";
			if(!empty($cid)){
				$where .=" AND o.`createdby`=".$cid;
			}

			if(!empty($ia_id)){
				$where .= " AND o.`ia_id`=".$ia_id;	
			}

			if(!empty($supplier)){
				$where .= " AND  `s`.`supplier_id` = ".$supplier;
			}

			if(!empty($category)){
				$where .= " AND  `pc`.`prod_cat_id` = ".$category;
			}

			if(!empty($prod)){
				$where .= " AND  `p`.`prod_id`= ".$prod;
			}
			if(!empty($prodType)){
				$where .= " AND  `p`.`type`= '".$prodType."'";
			}

			if(!empty($st_date)){
				$start = get_ym_start($st_date);				
				$where .= " AND o.createdate >= '".$start." 00:00:00'"; 
			}

			if(!empty($end_date)){
				$end = get_ym_end($end_date);				
				$where .= " AND o.createdate <= '".$end." 23:59:59'"; 
			}	

			$query = "SELECT SUM(op.prod_qty) AS total_orders ,SUM(op.prod_total) AS prod_total_amt			
			FROM `orders` as o
			LEFT JOIN orders_product as op ON `o`.`orders_id`= `op`.`orders_id` 
			LEFT JOIN product as p ON `op`.`prod_id`= `p`.`prod_id`
			LEFT JOIN product_category as pc ON `pc`.`prod_cat_id`= `p`.`prod_cat_id` 
			LEFT JOIN supplier as s ON `s`.`supplier_id`= `p`.`supplier_id` 
			LEFT JOIN user as u ON `u`.`user_id`= `o`.`createdby`
			WHERE ".$where;

			$data = $this->generalmodel->customquery($query,'row_array');

			$data['total_orders'] = $data['total_orders'];
			$data['total_amount'] = numfmt_format_currency($this->fmt,$data['prod_total_amt'], "USD");
			echo json_encode($data);
		}
	}	
	//===========Reconciliation Report for all Licensee End Here ===========

	//======General Disbursement Monthly Report for all Start Here==================
	public function all_lic_disbursement_report(){
		$data['licensee'] = $this->generalmodel->all_licensee();	
		$data['meta_title'] = 'Disbursement Report';

		$this->load->view('reports/all_lic_disbursement_report',$data); 
	}

	public function all_lic_disbursement_report_ajax(){
		if($this->input->is_ajax_request()){
			
			$urole = $this->userdata['urole_id'];
			$dept = $this->userdata['dept_id'];

			$where = "u.urole_id =2 AND o.createdate >= '".date('Y-m-01',strtotime('last month'))." 00:00:00'"; 
			$where .= " AND o.createdate <= '".date('Y-m-t',strtotime('last month'))." 23:59:59'"; 

			$query = "SELECT o.lic_id AS licensee,DATE_FORMAT(`o`.`createdate`, '%m-%Y') AS title,u.resource_id,
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

			if($urole==1 && ($dept==2 || $dept==3 || $dept==10)){
		        $datatables->edit('licensee', function ($data) {
		        	if($data['status']==1){
		        		return '';
		        	}else{
		            	return '<input type="checkbox" value="'.$data['total_eta_dis'].'" class="check" id="'.$data['licensee'].'" dates="'.$data['title'].'" />';
		        	}
		        });
			}else{
				$datatables->hide('licensee');
			}

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
	        if($urole!=1){
				$datatables->hide('lic_id');
			}else{
				$datatables->edit('lic_id', function ($data) {
					$menu = '<li>
	                        <a  href="'.site_url('reports/export_lic_dis_detail/').$data['lic_id'].'/'.$data['title'].'">
	                            <span class="glyphicon glyphicon-download"></span> Download
	                        </a>
	                    	</li>';

			        return '<div class="dropdown">
					<button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
					<i class="glyphicon glyphicon-option-vertical"></i>
					</button>
					<ul class="dropdown-menu">
					'.$menu.'    
					</ul></div>';
	 			});
	 		}
			echo $datatables->generate();
		}		
	}
	
	public function getTotal_all_lic_disbrs(){

		if($this->input->is_ajax_request()){
			$st_date = $this->input->post('st_date');
			$end_date = $this->input->post('end_date');
			$lic = $this->input->post('lic');

			$where = "(1=1)";
			if(!empty($st_date)){
				$start = get_ym_start($st_date);				
				$where .= " AND o.createdate >= '".$start." 00:00:00'"; 
			}

			if(!empty($end_date)){
				$end = get_ym_end($end_date);				
				$where .= " AND o.createdate <= '".$end." 23:59:59'"; 
			}else{
				$where .= " AND o.createdate <= '".date('Y-m-t',strtotime('last month'))." 23:59:59'"; 
			}

			if(!empty($lic)){
				$where .= " AND o.lic_id = '".$lic."'"; 
			}

			$query = "SELECT SUM(o.total_amt) AS reconcile,SUM(o.lic_disburse) AS disburse
			FROM `orders` AS o WHERE $where";


			$data = $this->generalmodel->customquery($query,'row_array');

			$data['reconcile'] = numfmt_format_currency($this->fmt,$data['reconcile'], "USD");
			$data['disburse'] = numfmt_format_currency($this->fmt,$data['disburse'], "USD");
			echo json_encode($data);
		}
	}

	public function filter_all_lic_disburs(){
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
			$st_date = $this->input->post('st_date');
			$end_date = $this->input->post('end_date');
			$lic = $this->input->post('lic');
			$urole = $this->userdata['urole_id'];
			$dept = $this->userdata['dept_id'];

			$where = "u.urole_id=2";

			if(!empty($st_date)){
				$start = get_ym_start($st_date);				
				$where .= " AND o.createdate >= '".$start." 00:00:00'"; 
			}
			if(!empty($end_date)){
				$end = get_ym_end($end_date);				
				$where .= " AND o.createdate <= '".$end." 23:59:59'"; 
			}else{
				$where .= " AND o.createdate <= '".date('Y-m-t',strtotime('last month'))." 23:59:59'"; 
			}

			if(!empty($lic)){
				$where .= " AND o.lic_id = '".$lic."'"; 
			}

			$query = "SELECT o.lic_id AS licensee,DATE_FORMAT(`o`.`createdate`, '%m-%Y') AS title,u.resource_id,
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
			ORDER BY u.resource_id ASC,`title` ASC";

			$datatables = new Datatables(new CodeigniterAdapter);

			$datatables->query($query);

			if($urole==1 && ($dept==2 ||$dept==3 ||$dept==10)){
		        $datatables->edit('licensee', function ($data) {
		        	if($data['status']==1){
		        		return '';
		        	}else{
			            return '<input type="checkbox" value="'.$data['total_eta_dis'].'" class="check" id="'.$data['licensee'].'" dates="'.$data['title'].'" />';
			        }
		        });
			}else{
				$datatables->hide('licensee');
		    }

	        $datatables->edit('modi', function ($data) {
	           	if(!empty($data['modi'])){
					$modi = gmdate_to_mydate($data['modi'],$this->localtimzone);
					return date('m/d/Y',strtotime($modi));
	           	}else{ return ''; }
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

	        if($urole!=1){
				$datatables->hide('lic_id');
			}else{
				$datatables->edit('lic_id', function ($data) {
					$menu = '<li>
	                        <a  href"'.site_url('reports/export_lic_dis_detail/').$data['lic_id'].'/'.$data['title'].'">
	                            <span class="glyphicon glyphicon-download"></span> Download
	                        </a>
	                    	</li>';

			        return '<div class="dropdown">
					<button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
					<i class="glyphicon glyphicon-option-vertical"></i>
					</button>
					<ul class="dropdown-menu">
					'.$menu.'    
					</ul></div>';
	 			});
			}
			echo $datatables->generate();
		}	
	}

	/*
	public function update_lic_dis_status($lic,$title){
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
			$data['lic_id'] = $lic;
			$data['amount'] = $this->input->post('amt');
			$data['status'] = '1';
			$data['updatedby'] = $userid = $this->userdata['user_id'];
			$data['updatedate'] = date('Y-m-d h:i:s');
			$data['dis_title'] = $title;

			$where = "`lic_id`=$lic AND `dis_title`='$title'";
			$getRecord = $this->generalmodel->getparticularData("id","lic_disburse_status",$where);
			if(!empty($getRecord)){
				$udata['status'] = '1';
				$udata['updatedby'] = $userid = $this->userdata['user_id'];
				$udata['updatedate'] = date('Y-m-d h:i:s');
				$query = $this->generalmodel->updaterecord("lic_disburse_status",$udata,$where);
			}else{
				$query = $this->generalmodel->add("lic_disburse_status",$data);
			}
			
			if($query){
				echo json_encode(array('success'=>true,'msg'=>'updated successfully'));
			}else{
				echo json_encode(array('success'=>false,'msg'=>'internal error'));
			}
		}
	}
	*/

	public function update_selected_lic_disburse(){
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
			$amount = $this->input->post('amt');
			$li = $this->input->post('lic');
			$dates = $this->input->post('dates');
			foreach($li as $key=>$lic){

				$title = $dates[$key];

				$where = "`lic_id`=$lic AND `dis_title`='$title'";
				$getRecord = $this->generalmodel->getparticularData("id","lic_disburse_status",$where);
				if(!empty($getRecord)){
					$udata['status'] = '1';
					$udata['updatedby'] = $userid = $this->userdata['user_id'];
					$udata['updatedate'] = date('Y-m-d h:i:s');
					$query = $this->generalmodel->updaterecord("lic_disburse_status",$udata,$where);
				}else{

					$data['lic_id'] = $lic;
					$data['amount'] = $amount[$key];
					$data['dis_title'] = $title;
					$data['status'] = '1';
					$data['updatedby'] = $userid = $this->userdata['user_id'];
					$data['updatedate'] = date('Y-m-d h:i:s');
					$query = $this->generalmodel->add("lic_disburse_status",$data);
				}
			}
			echo json_encode(array('success'=>true,'msg'=>'updated successfully'));
			// if($query){
			// 	echo json_encode(array('success'=>true,'msg'=>'updated successfully'));
			// }else{
			// 	echo json_encode(array('success'=>false,'msg'=>'internal error'));
			// }
		}
	}

	public function export_all_lic_disburse(){
		if(!empty($this->input->post())){
			$st_date = $this->input->post('startdate');
			$end_date = $this->input->post('enddate');
			$lic = $this->input->post('lic');
			$where = "u.urole_id=2";

			if(!empty($st_date)){
				$start = get_ym_start($st_date);				
				$where .= " AND o.createdate >= '".$start." 00:00:00'"; 
			}
			if(!empty($end_date)){
				$end = get_ym_end($end_date);				
				$where .= " AND o.createdate <= '".$end." 23:59:59'"; 
			}else{
				$where .= " AND o.createdate <= '".date('Y-m-t',strtotime('last month'))." 23:59:59'"; 
			}

			if(!empty($lic)){
				$where .= " AND o.lic_id = '".$lic."'"; 
			}

			$queryy = "SELECT DATE_FORMAT(`o`.`createdate`, '%m-%Y') AS title,u.resource_id,
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
			ORDER BY `title` ASC";


	 		$query=$this->db->query($queryy);

	        $obj= $query->result_array();

	        $writer = WriterEntityFactory::createXLSXWriter();
	        $filePath = base_url().'lic_disbursement_report-'.date('m-d-Y').'.xlsx';
	        $writer->openToBrowser($filePath); // stream data directly to the browser

			$style = (new StyleBuilder())
			           ->setFontBold()
			           ->setFontSize(15)
			           ->setCellAlignment(CellAlignment::CENTER)
			           ->build();

			/** Create a row with cells and apply the style to all cells */
			$singleRow = WriterEntityFactory::createRowFromArray(['','','','Licensee Disbursement Report','','',''], $style);
			$blankRow = WriterEntityFactory::createRowFromArray(['','','','','','','']);
			/** Add the row to the writer */
			$writer->addRow($singleRow);
			$writer->addRow($blankRow);

	        
			$cellstyle = (new StyleBuilder())
	           ->setFontBold()
	           ->setFontSize(15)
	           ->build();

	        $cells = [
	                WriterEntityFactory::createCell('Title',$cellstyle),
	                WriterEntityFactory::createCell('Resource ID',$cellstyle),
	                WriterEntityFactory::createCell('Licensee',$cellstyle),
	                WriterEntityFactory::createCell('Business',$cellstyle),
	                WriterEntityFactory::createCell('Total Order',$cellstyle),
	                WriterEntityFactory::createCell('Total Amount',$cellstyle),
	                WriterEntityFactory::createCell('Order Total to Disburse',$cellstyle),
	                WriterEntityFactory::createCell('Status',$cellstyle),
	                WriterEntityFactory::createCell('Modified Date',$cellstyle),
	        ];

	        //=== add a row at a time ===//
	        $singleRow = WriterEntityFactory::createRow($cells);
	        $writer->addRow($singleRow);
	        if(!empty($obj)){
		        
		        foreach ($obj as $row) {

		            $data[1] = $row['title'];
		            $data[2] = $row['resource_id'];
		            $data[3] = $row['username'];
		            $data[4] = $row['business_name'];
		            $data[5] = $row['total_orders'];
		            $data[6] = numfmt_format_currency($this->fmt,$row['total_amount'], "USD");
		            $data[7] = numfmt_format_currency($this->fmt,$row['total_eta_dis'], "USD");
		            if($row['status']==1){ $data[8] = 'Paid'; }else{ $data[8] = 'Unpaid'; }
		            $data[9] = $row['modi'];
		            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
		        }
	        }
	        $writer->close();
	    } 	
	}

	public function export_lic_dis_detail($lic,$title){

		$st_date = date('Y-m-01',strtotime('01-'.$title));
		$end_date = date('Y-m-t',strtotime($st_date));
		
		$where  = "o.createdate >= '".$st_date." 00:00:00'"; 
		$where .= " AND o.createdate <= '".$end_date." 23:59:59'"; 
		$where .= " AND o.lic_id = '".$lic."'"; 


		$queryy = "SELECT o.orders_id,CONCAT_WS(' ',u.firstname,u.lastname) AS username,
		o.total_amt,lic_disburse,o.createdate
		FROM `orders` AS o
		LEFT JOIN user AS u ON u.user_id= o.lic_id
        WHERE $where
		ORDER BY `o`.`createdate` ASC";


	 		$query=$this->db->query($queryy);

	        $obj= $query->result_array();

	        $writer = WriterEntityFactory::createXLSXWriter();
	        $filePath = base_url().'lic_disbursement_report-'.date('m-d-Y').'.xlsx';
	        $writer->openToBrowser($filePath); // stream data directly to the browser

			$style = (new StyleBuilder())
			           ->setFontBold()
			           ->setFontSize(15)
			           ->setCellAlignment(CellAlignment::CENTER)
			           ->build();

			/** Create a row with cells and apply the style to all cells */
			$singleRow = WriterEntityFactory::createRowFromArray(['','','','Licensee Disbursement Report','','',''], $style);
			$blankRow = WriterEntityFactory::createRowFromArray(['','','','','','','']);
			/** Add the row to the writer */
			$writer->addRow($singleRow);
			$writer->addRow($blankRow);

	        
			$cellstyle = (new StyleBuilder())
	           ->setFontBold()
	           ->setFontSize(15)
	           ->build();

	        $cells = [
	                WriterEntityFactory::createCell('Order Number',$cellstyle),
	                WriterEntityFactory::createCell('Licensee',$cellstyle),
	                WriterEntityFactory::createCell('Total Amount',$cellstyle),
	                WriterEntityFactory::createCell('Order Total to Disburse',$cellstyle),
	                WriterEntityFactory::createCell('Order Create Date',$cellstyle),
	        ];

	        //=== add a row at a time ===//
	        $singleRow = WriterEntityFactory::createRow($cells);
	        $writer->addRow($singleRow);
	        if(!empty($obj)){
		        
		        foreach ($obj as $row) {

		            $data[1] = $row['orders_id'];
		            $data[2] = $row['username'];
		            $data[3] = numfmt_format_currency($this->fmt,$row['total_amt'], "USD");
		            $data[4] = numfmt_format_currency($this->fmt,$row['lic_disburse'], "USD");
		            $data[5] = date('m/d/Y',strtotime($row['createdate']));
		            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
		        }
	        }
	        $writer->close();
	}
//==================lic monthly disburse end==============//

//==================ia monthly disburse start==============//

	public function all_ia_disbursement_report(){
		$urole = $this->userdata['urole_id'];
		if($urole==1){
			$data['ia'] = $this->generalmodel->all_ialist();	
		}else{
			$id = $this->userdata['user_id'];
			$data['ia'] = $this->generalmodel->iaList($id);	
		}
		$data['meta_title'] = 'Disbursement Report';

		$this->load->view('reports/all_ia_disbursement_report',$data); 
	}

	public function all_ia_disbursement_report_ajax(){
		if($this->input->is_ajax_request()){
			$urole = $this->userdata['urole_id'];
			$dept = $this->userdata['dept_id'];
			$user_id = $this->userdata['user_id'];

			$where = "u.urole_id=3 AND o.createdate >= '".date('Y-m-01',strtotime('last month'))." 00:00:00'"; 
			$where .= " AND o.createdate <= '".date('Y-m-t',strtotime('last month'))." 23:59:59'"; 

			if($urole!=1){
				$where .= " AND o.lic_id=".$user_id ;
			}

/*
			$query = "SELECT o.ia_id AS industryassoc,DATE_FORMAT(`o`.`createdate`, '%m-%Y') AS title,
			CONCAT_WS(' ',u.firstname,u.lastname) AS username,
			COUNT(`o`.`orders_id`) AS total_orders,SUM(o.total_amt) AS total_amount,
			SUM(o.ia_disburse) AS total_eta_dis,d.status,DATE_FORMAT(d.updatedate, '%m/%d/%Y') AS modi,o.ia_id
			FROM `orders` AS o
			LEFT JOIN user AS u ON u.user_id= o.ia_id
            LEFT JOIN ia_disburse_status as d ON ( d.ia_id=o.ia_id AND d.dis_title= DATE_FORMAT(`o`.`createdate`, '%m-%Y'))
            WHERE $where
			GROUP BY o.ia_id, MONTH(o.createdate), YEAR(o.createdate) DESC  
			ORDER BY `title` ASC";
*/

			$query = "SELECT o.ia_id AS industryassoc,DATE_FORMAT(`o`.`createdate`, '%m-%Y') AS title,u.resource_id,
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
		

			 if($urole==1 && ($dept==2 ||$dept==3 ||$dept==10)){
			    $datatables->edit('industryassoc', function ($data) {
			    	if($data['status']==1){
			    		return '';
			    	}else{
			        	return '<input type="checkbox" value="'.$data['total_eta_dis'].'" class="check" id="'.$data['ia_id'].'" dates="'.$data['title'].'" />';
					    } 
				});
			 }else{
				$datatables->hide('industryassoc');
			 }

			
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
	        if($urole!=1){
				$datatables->hide('ia_id');
			}else{
				$datatables->edit('ia_id', function ($data) {
					$menu = '<li>
	                        <a  href="'.site_url('reports/export_ia_dis_detail/').$data['ia_id'].'/'.$data['title'].'">
	                            <span class="glyphicon glyphicon-download"></span> Download
	                        </a>
	                    	</li>';

			        return '<div class="dropdown">
					<button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
					<i class="glyphicon glyphicon-option-vertical"></i>
					</button>
					<ul class="dropdown-menu">
					'.$menu.'    
					</ul></div>';
	 			});
			}
			echo $datatables->generate();
		}		
	}
	
	public function getTotal_all_ia_disbrs(){

		if($this->input->is_ajax_request()){
			$st_date = $this->input->post('st_date');
			$end_date = $this->input->post('end_date');
			$ia = $this->input->post('ia');
			$user_id = $this->userdata['user_id'];
			$urole = $this->userdata['urole_id'];
			$dept = $this->userdata['dept_id'];


			//$where = "u.urole_id=3 AND u.createdby=$user_id";
			$where = "u.urole_id=3";
			if(!empty($st_date)){
				$start = get_ym_start($st_date);				
				$where .= " AND o.createdate >= '".$start." 00:00:00'"; 
			}

			if(!empty($end_date)){
				$end = get_ym_end($end_date);				
				$where .= " AND o.createdate <= '".$end." 23:59:59'"; 
			}else{
				$where .= " AND o.createdate <= '".date('Y-m-t',strtotime('last month'))." 23:59:59'"; 
			}

			if(!empty($ia)){
				$where .= " AND o.ia_id = '".$ia."'"; 
			}

			if($urole!=1){
				$where .= " AND o.lic_id=".$user_id ;
			}

			$query = "SELECT SUM(o.total_amt) AS reconcile,SUM(o.ia_disburse) AS disburse
			FROM `orders` AS o
			JOIN user as u ON u.user_id=o.ia_id
			WHERE $where";



			$data = $this->generalmodel->customquery($query,'row_array');

// echo $query;
// print_r($data);
// exit;
			$data['reconcile'] = numfmt_format_currency($this->fmt,$data['reconcile'], "USD");
			$data['disburse'] = numfmt_format_currency($this->fmt,$data['disburse'], "USD");
			echo json_encode($data);
		}
	}

	public function filter_all_ia_disburs(){
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
			$st_date = $this->input->post('st_date');
			$end_date = $this->input->post('end_date');
			$ia = $this->input->post('ia');
			$user_id = $this->userdata['user_id'];
			$dept = $this->userdata['dept_id'];
			$urole = $this->userdata['urole_id'];
			$where = "u.urole_id=3";

			if(!empty($st_date)){
				$start = get_ym_start($st_date);				
				$where .= " AND o.createdate >= '".$start." 00:00:00'"; 
			}
			if(!empty($end_date)){
				$end = get_ym_end($end_date);				
				$where .= " AND o.createdate <= '".$end." 23:59:59'"; 
			}else{
				$where .= " AND o.createdate <= '".date('Y-m-t',strtotime('last month'))." 23:59:59'"; 
			}

			if(!empty($ia)){
				$where .= " AND o.ia_id = '".$ia."'"; 
			}

			if($urole!=1){
				$where .= " AND o.lic_id=".$user_id ;
			}

			/*
			$query = "SELECT o.ia_id AS industryassoc,DATE_FORMAT(`o`.`createdate`, '%m-%Y') AS title,
			CONCAT_WS(' ',u.firstname,u.lastname) AS username,
			COUNT(`o`.`orders_id`) AS total_orders,SUM(o.total_amt) AS total_amount,
			SUM(o.ia_disburse) AS total_eta_dis,d.status,DATE_FORMAT(d.updatedate, '%m/%d/%Y') AS modi,o.ia_id
			FROM `orders` AS o
			LEFT JOIN user AS u ON u.user_id= o.ia_id
            LEFT JOIN ia_disburse_status as d ON ( d.ia_id=o.ia_id AND d.dis_title= DATE_FORMAT(`o`.`createdate`, '%m-%Y'))
            WHERE $where
			GROUP BY o.ia_id, MONTH(o.createdate), YEAR(o.createdate) DESC  
			ORDER BY `title` ASC";
			*/

			$query = "SELECT o.ia_id AS industryassoc,DATE_FORMAT(`o`.`createdate`, '%m-%Y') AS title,u.resource_id,
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
			if($urole==1 && ($dept==2 ||$dept==3 ||$dept==10)){
		        $datatables->edit('industryassoc', function ($data) {
		        	if($data['status']==1){
		        		return '';
		        	}else{
		            	return '<input type="checkbox" value="'.$data['total_eta_dis'].'" class="check" id="'.$data['ia_id'].'" dates="'.$data['title'].'" />';
		            }
		        });
			}else{
				$datatables->hide('industryassoc');
		    }
			
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
	        if($urole!=1){
				$datatables->hide('ia_id');
			}else{
				$datatables->edit('ia_id', function ($data) {
					$menu = '<li>
	                        <a  href"'.site_url('reports/export_lic_dis_detail/').$data['ia_id'].'/'.$data['title'].'">
	                            <span class="glyphicon glyphicon-download"></span> Download
	                        </a>
	                    	</li>';

			        return '<div class="dropdown">
					<button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
					<i class="glyphicon glyphicon-option-vertical"></i>
					</button>
					<ul class="dropdown-menu">
					'.$menu.'    
					</ul></div>';
	 			});
			}
			echo $datatables->generate();
		}	
	}


	public function update_selected_ia_disburse(){
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
			$amount = $this->input->post('amt');
			$ia = $this->input->post('ia');
			//echo "<pre>"; print_r($_POST); exit;
			$dates = $this->input->post('dates');
			foreach($ia as $key=>$ia_id){

				$title = $dates[$key];

				$where = "`ia_id`=$ia_id AND `dis_title`='$title'";
				$getRecord = $this->generalmodel->getparticularData("id","ia_disburse_status",$where);
				if(!empty($getRecord)){
					$udata['status'] = '1';
					$udata['updatedby'] = $userid = $this->userdata['user_id'];
					$udata['updatedate'] = date('Y-m-d h:i:s');
					$query = $this->generalmodel->updaterecord("ia_disburse_status",$udata,$where);
				}else{

					$data['ia_id'] = $ia_id;
					$data['amount'] = $amount[$key];
					$data['dis_title'] = $title;
					$data['status'] = '1';
					$data['updatedby'] = $userid = $this->userdata['user_id'];
					$data['updatedate'] = date('Y-m-d h:i:s');
					$query = $this->generalmodel->add("ia_disburse_status",$data);
				}
			}
			echo json_encode(array('success'=>true,'msg'=>'updated successfully'));
		}
	}

	public function export_all_ia_disburse(){
		if(!empty($this->input->post())){
			$st_date = $this->input->post('startdate');
			$end_date = $this->input->post('enddate');
			$ia = $this->input->post('ia');
			$urole = $this->userdata['urole_id'];
			$user_id = $this->userdata['user_id'];

			$where = "(1=1)";

			if(!empty($st_date)){
				$start = get_ym_start($st_date);				
				$where .= " AND o.createdate >= '".$start." 00:00:00'"; 
			}
			if(!empty($end_date)){
				$end = get_ym_end($end_date);				
				$where .= " AND o.createdate <= '".$end." 23:59:59'"; 
			}else{
				$where .= " AND o.createdate <= '".date('Y-m-t',strtotime('last month'))." 23:59:59'"; 
			}

			if(!empty($ia)){
				$where .= " AND o.ia_id = '".$ia."'"; 
			}

			if($urole!=1){
				$where .= " AND o.lic_id=".$user_id ;
			}
				
				/*
			$queryy = "SELECT DATE_FORMAT(`o`.`createdate`, '%m-%Y') AS title,
			CONCAT_WS(' ',u.firstname,u.lastname) AS username,
			COUNT(`o`.`orders_id`) AS total_orders,SUM(o.total_amt) AS total_amount,
			SUM(o.ia_disburse) AS total_eta_dis,d.status,DATE_FORMAT(d.updatedate, '%m/%d/%Y') AS modi,o.ia_id
			FROM `orders` AS o
			LEFT JOIN user AS u ON u.user_id= o.ia_id
	        LEFT JOIN ia_disburse_status as d ON ( d.ia_id=o.ia_id AND d.dis_title= DATE_FORMAT(`o`.`createdate`, '%m-%Y'))
	        WHERE $where
			GROUP BY o.ia_id, MONTH(o.createdate), YEAR(o.createdate) DESC  
			ORDER BY `title` ASC";
			*/

			$queryy = "SELECT o.ia_id AS industryassoc,DATE_FORMAT(`o`.`createdate`, '%m-%Y') AS title,u.resource_id,
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


	 		$query=$this->db->query($queryy);

	        $obj= $query->result_array();

	        $writer = WriterEntityFactory::createXLSXWriter();
	        $filePath = base_url().'ia_disbursement_report-'.date('m-d-Y').'.xlsx';
	        $writer->openToBrowser($filePath); // stream data directly to the browser

			$style = (new StyleBuilder())
			           ->setFontBold()
			           ->setFontSize(15)
			           ->setCellAlignment(CellAlignment::CENTER)
			           ->build();

			/** Create a row with cells and apply the style to all cells */
			$singleRow = WriterEntityFactory::createRowFromArray(['','','','Industry Association Disbursement Report','','',''], $style);
			$blankRow = WriterEntityFactory::createRowFromArray(['','','','','','','']);
			/** Add the row to the writer */
			$writer->addRow($singleRow);
			$writer->addRow($blankRow);

	        
			$cellstyle = (new StyleBuilder())
	           ->setFontBold()
	           ->setFontSize(15)
	           ->build();

	        $cells = [
	                WriterEntityFactory::createCell('Title',$cellstyle),
	                WriterEntityFactory::createCell('Resource ID',$cellstyle),
	                WriterEntityFactory::createCell('Industry Association',$cellstyle),
	                WriterEntityFactory::createCell('Business',$cellstyle),
	                WriterEntityFactory::createCell('Total Order',$cellstyle),
	                WriterEntityFactory::createCell('Total Amount',$cellstyle),
	                WriterEntityFactory::createCell('Order Total to Disburse',$cellstyle),
	                WriterEntityFactory::createCell('Status',$cellstyle),
	                WriterEntityFactory::createCell('Modified Date',$cellstyle),
	        ];

	        //=== add a row at a time ===//
	        $singleRow = WriterEntityFactory::createRow($cells);
	        $writer->addRow($singleRow);
	        if(!empty($obj)){
		        
		        foreach ($obj as $row) {
		        	
		        	$modi = '';
					if(!empty($row['modi'])){
						$modi = gmdate_to_mydate($row['modi'],$this->localtimzone);
						$modi = date('m/d/Y',strtotime($modi));
					}

		            $data[1] = $row['title'];
		            $data[2] = $row['resource_id'];
		            $data[3] = $row['username'];
		            $data[4] = $row['business_name'];
		            $data[5] = $row['total_orders'];
		            $data[6] = numfmt_format_currency($this->fmt,$row['total_amount'], "USD");
		            $data[7] = numfmt_format_currency($this->fmt,$row['total_eta_dis'], "USD");
		            if($row['status']==1){ $data[8] = 'Paid'; }else{ $data[8] = 'Unpaid'; }
		            $data[9] = $modi;
		            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
		        }
	        }
	        $writer->close();
	    } 	
	}

	public function export_ia_dis_detail($ia,$title){

		$st_date = date('Y-m-01',strtotime('01-'.$title));
		$end_date = date('Y-m-t',strtotime($st_date));
		
		$where  = "o.createdate >= '".$st_date." 00:00:00'"; 
		$where .= " AND o.createdate <= '".$end_date." 23:59:59'"; 
		$where .= " AND o.ia_id = '".$ia."'"; 


		$queryy = "SELECT o.orders_id,CONCAT_WS(' ',u.firstname,u.lastname) AS username,
		o.total_amt,ia_disburse,o.createdate
		FROM `orders` AS o
		LEFT JOIN user AS u ON u.user_id= o.ia_id
        WHERE $where
		ORDER BY `o`.`createdate` ASC";


	 		$query=$this->db->query($queryy);

	        $obj= $query->result_array();

	        $writer = WriterEntityFactory::createXLSXWriter();
	        $filePath = base_url().'ia_disbursement_report-'.date('m-d-Y').'.xlsx';
	        $writer->openToBrowser($filePath); // stream data directly to the browser

			$style = (new StyleBuilder())
			           ->setFontBold()
			           ->setFontSize(15)
			           ->setCellAlignment(CellAlignment::CENTER)
			           ->build();

			/** Create a row with cells and apply the style to all cells */
			$singleRow = WriterEntityFactory::createRowFromArray(['','','','Industry Association Disbursement Report','','',''], $style);
			$blankRow = WriterEntityFactory::createRowFromArray(['','','','','','','']);
			/** Add the row to the writer */
			$writer->addRow($singleRow);
			$writer->addRow($blankRow);

	        
			$cellstyle = (new StyleBuilder())
	           ->setFontBold()
	           ->setFontSize(15)
	           ->build();

	        $cells = [
	                WriterEntityFactory::createCell('Order Number',$cellstyle),
	                WriterEntityFactory::createCell('Industry Association',$cellstyle),
	                WriterEntityFactory::createCell('Total Amount',$cellstyle),
	                WriterEntityFactory::createCell('Order Total to Disburse',$cellstyle),
	                WriterEntityFactory::createCell('Order Create Date',$cellstyle),
	        ];

	        //=== add a row at a time ===//
	        $singleRow = WriterEntityFactory::createRow($cells);
	        $writer->addRow($singleRow);
	        if(!empty($obj)){
		        
		        foreach ($obj as $row) {

		            $data[1] = $row['orders_id'];
		            $data[2] = $row['username'];
		            $data[3] = numfmt_format_currency($this->fmt,$row['total_amt'], "USD");
		            $data[4] = numfmt_format_currency($this->fmt,$row['ia_disburse'], "USD");
		            $data[5] = date('m/d/Y',strtotime($row['createdate']));
		            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
		        }
	        }
	        $writer->close();
	}


	/*
	public function general_disbursement_report_ajax(){
		if($this->input->is_ajax_request()){

			$query = "SELECT dis_title,ia.ia_resource_id,dis_total_orders,dis_total_amt,dis_disburs_amount,dis_status as status
			,dis_modified_date ,dis_id
			FROM disbursment_report as d
			LEFT JOIN indassociation as ia ON ia.user_id =d.dis_ia_id
			ORDER BY ia.ia_id";


			$datatables = new Datatables(new CodeigniterAdapter);

			$datatables->query($query);

	        $datatables->edit('dis_total_amt', function ($data) {
	            return numfmt_format_currency($this->fmt,$data['dis_total_amt'], "USD");
	        });

	        $datatables->edit('dis_disburs_amount', function ($data) {
	            return numfmt_format_currency($this->fmt,$data['dis_disburs_amount'], "USD");
	        });

	        $datatables->edit('status', function ($data){
	        	return ($data['status']==0)?'Unpaid':'Paid';
	        });

	        $datatables->edit('dis_modified_date', function ($data){
	        	return date('m/d/Y',strtotime($data['dis_modified_date']));
	        });

			$datatables->edit('dis_id', function ($data) {
				$menu = '<li>
                        <a  href="javascript:void(0)" link="'.site_url().'">
                            <span class="glyphicon glyphicon-download"></span> View
                        </a>
                    	</li>';
				$menu = '<li>
                        <a  href="javascript:void(0)" link="'.site_url().'">
                            <span class="glyphicon glyphicon-download"></span> Update Status
                        </a>
                    	</li>';                    	
				$menu = '<li>
                        <a  href="javascript:void(0)" link="'.site_url().'">
                            <span class="glyphicon glyphicon-download"></span> Download
                        </a>
                    	</li>';

	        return '<div class="dropdown">
			<button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
			<i class="glyphicon glyphicon-option-vertical"></i>
			</button>
			<ul class="dropdown-menu">
			'.$menu.'    
			</ul></div>';
 			});
			echo $datatables->generate();
		}		
	}
	
	public function getTotal_general_disbrs(){

		if($this->input->is_ajax_request()){
			$st_date = $this->input->post('st_date');
			$end_date = $this->input->post('end_date');
			
			$where = "(1=1)";
			if(!empty($st_date)){
				$start = get_ym_start($st_date);				
				$where .= " AND d.dis_createdate >= '".$start." 00:00:00'"; 
			}

			if(!empty($end_date)){
				$end = get_ym_end($end_date);				
				$where .= " AND d.dis_createdate <= '".$end." 23:59:59'"; 
			}

			$query = "SELECT SUM(dis_total_amt) AS reconcile,SUM(dis_disburs_amount) AS disburse
				FROM disbursment_report as d
				LEFT JOIN indassociation as ia ON ia.user_id =d.dis_ia_id 
				WHERE ".$where;

			$data = $this->generalmodel->customquery($query,'row_array');

			$data['reconcile'] = numfmt_format_currency($this->fmt,$data['reconcile'], "USD");
			$data['disburse'] = numfmt_format_currency($this->fmt,$data['disburse'], "USD");
			echo json_encode($data);
		}

	}

	public function filter_general_disburs(){
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
			$st_date = $this->input->post('st_date');
			$end_date = $this->input->post('end_date');

			$where = "(1=1)";
			if(!empty($st_date)){
				$start = get_ym_start($st_date);				
				$where .= " AND d.dis_createdate >= '".$start." 00:00:00'";
			}

			if(!empty($end_date)){
				$end = get_ym_end($end_date);				
				$where .= " AND d.dis_createdate <= '".$end." 23:59:59'"; 
			}

			$query = "SELECT dis_title,ia.ia_resource_id,dis_total_orders,dis_total_amt,dis_disburs_amount,dis_status as status
			,dis_modified_date ,dis_id
			FROM disbursment_report as d
			LEFT JOIN indassociation as ia ON ia.user_id =d.dis_ia_id 
			WHERE ".$where;

			$datatables = new Datatables(new CodeigniterAdapter);

			$datatables->query($query);

	        $datatables->edit('dis_total_amt', function ($data) {
	            return numfmt_format_currency($this->fmt,$data['dis_total_amt'], "USD");
	        });

	        $datatables->edit('dis_disburs_amount', function ($data) {
	            return numfmt_format_currency($this->fmt,$data['dis_disburs_amount'], "USD");
	        });

	        $datatables->edit('status', function ($data){
	        	return ($data['status']==0)?'Unpaid':'Paid';
	        });

	        $datatables->edit('dis_modified_date', function ($data){
	        	return date('m/d/Y',strtotime($data['dis_modified_date']));
	        });

			$datatables->edit('dis_id', function ($data) {
				$menu = '<li>
                        <a  href="javascript:void(0)" link="'.site_url().'">
                            <span class="glyphicon glyphicon-download"></span> View
                        </a>
                    	</li>';
				$menu = '<li>
                        <a  href="javascript:void(0)" link="'.site_url().'">
                            <span class="glyphicon glyphicon-download"></span> Update Status
                        </a>
                    	</li>';                    	
				$menu = '<li>
                        <a  href="javascript:void(0)" link="'.site_url().'">
                            <span class="glyphicon glyphicon-download"></span> Download
                        </a>
                    	</li>';

	        return '<div class="dropdown">
			<button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
			<i class="glyphicon glyphicon-option-vertical"></i>
			</button>
			<ul class="dropdown-menu">
			'.$menu.'    
			</ul></div>';
 			});
			echo $datatables->generate();
		}	
	}
	*/

	//======General Disbursement Monthly Report for all End Here====================	

	//======General Disbursement Transaction Report for all Start Here==================
	public function general_transaction_report(){
		$data['supplier'] = $this->generalmodel->all_suppliers();	
		$data['meta_title'] = 'Transaction Summary';

		$this->load->view('reports/general_transaction_report',$data); 
	}

	public function general_transaction_report_ajax(){

		if($this->input->is_ajax_request()){
			
			$query = "SELECT o.createdate,o.lic_id,o.ia_id,CONCAT_WS(' ',u.firstname,u.lastname) AS consumer_name,
			total_amt,order_amt,lic_disburse
			FROM `orders` as o
			LEFT JOIN user as u ON `u`.`user_id`= `o`.`createdby`";

			if($this->userdata['urole_id']==2){
				$query .= " WHERE o.lic_id=".$this->userdata['user_id'];
			}

			$datatables = new Datatables(new CodeigniterAdapter);

			$datatables->query($query);

	        $datatables->edit('createdate', function ($data) {
	        	$modi = gmdate_to_mydate($data['createdate'],$this->localtimzone);
				return date('m/d/Y',strtotime($modi));
	            //return date('m/d/Y',strtotime($data['createdate']));
	        });

			$datatables->edit('lic_id', function ($data){
				$licData =  $this->generalmodel->getlicdata($data['lic_id']);
				if(!empty($licData)){
					return $licData['business_name'];
				}else{
					return '';
				}
			});

			$datatables->edit('ia_id', function ($data){
				$iaData =  $this->generalmodel->get_iadata($data['ia_id']);
				if(!empty($iaData)){
					return $iaData['business_name'];
				}else{
					return '';
				}				
			});

	        $datatables->edit('total_amt', function ($data) {
	            return numfmt_format_currency($this->fmt,$data['total_amt'], "USD");
	        });

	        $datatables->edit('order_amt', function ($data) {
	            return numfmt_format_currency($this->fmt,$data['order_amt'], "USD");
	        });

	        $datatables->edit('lic_disburse', function ($data) {
	            return numfmt_format_currency($this->fmt,$data['lic_disburse'], "USD");
	        });
			echo $datatables->generate();
		}			
	}

	public function general_transac_summ_total(){
		if($this->input->is_ajax_request()){

			$st_date = $this->input->post('st_date');
			$end_date = $this->input->post('end_date');
			
			$where = "(1=1)";
			if(!empty($st_date)){
				$start = get_ym_start($st_date);				
				$where .= " AND o.createdate >= '".$start." 00:00:00'"; 
			}

			if(!empty($end_date)){
				$end = get_ym_end($end_date);				
				$where .= " AND o.createdate <= '".$end." 23:59:59'"; 
			}					

			if($this->userdata['urole_id']==2){
				$where .= " AND o.lic_id=".$this->userdata['user_id'];
			}

			$query = "SELECT SUM(total_amt) AS total_amt,SUM(order_amt) AS ord_total,SUM(lic_disburse) AS disburse_total
			FROM `orders` as o
			LEFT JOIN user as u ON `u`.`user_id`= `o`.`createdby`
			WHERE ".$where;

			$data = $this->generalmodel->customquery($query,'row_array');

			$data['ord_total'] = numfmt_format_currency($this->fmt,$data['ord_total'], "USD");
			$data['disburse_total'] = numfmt_format_currency($this->fmt,$data['disburse_total'], "USD");
			echo json_encode($data);
		}
	}
	public function filter_general_transaction(){

		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
			
			$st_date = $this->input->post('st_date');
			$end_date = $this->input->post('end_date');
			
			$where = "(1=1)";
			if(!empty($st_date)){
				$start = get_ym_start($st_date);				
				$where .= " AND o.createdate >= '".$start." 00:00:00'"; 
			}

			if(!empty($end_date)){
				$end = get_ym_end($end_date);				
				$where .= " AND o.createdate <= '".$end." 23:59:59'"; 
			}		

			if($this->userdata['urole_id']==2){
				$where .= " AND o.lic_id=".$this->userdata['user_id'];
			}

			$query = "SELECT o.createdate,o.lic_id,o.ia_id,CONCAT_WS(' ',u.firstname,u.lastname) AS consumer_name,
			total_amt,order_amt,lic_disburse
			FROM `orders` as o
			LEFT JOIN user as u ON `u`.`user_id`= `o`.`createdby`
			WHERE ".$where;

			$datatables = new Datatables(new CodeigniterAdapter);

			$datatables->query($query);


	        $datatables->edit('createdate', function ($data) {
	        	$modi = gmdate_to_mydate($data['createdate'],$this->localtimzone);
				return date('m/d/Y',strtotime($modi));	            
	        });

			$datatables->edit('lic_id', function ($data){
				$licData =  $this->generalmodel->getlicdata($data['lic_id']);
				if(!empty($licData)){
					return $licData['business_name'];
				}else{
					return '';
				}
			});

			$datatables->edit('ia_id', function ($data){
				$iaData =  $this->generalmodel->get_iadata($data['ia_id']);
				if(!empty($iaData)){
					return $iaData['business_name'];
				}else{
					return '';
				}				
			});

	        $datatables->edit('total_amt', function ($data) {
	            return numfmt_format_currency($this->fmt,$data['total_amt'], "USD");
	        });

	        $datatables->edit('order_amt', function ($data) {
	            return numfmt_format_currency($this->fmt,$data['order_amt'], "USD");
	        });

	        $datatables->edit('lic_disburse', function ($data) {
	            return numfmt_format_currency($this->fmt,$data['lic_disburse'], "USD");
	        });
			echo $datatables->generate();
		}			
	}

	public function export_general_transac_summ(){
			
		$st_date = $this->input->post('startdate');
		$end_date = $this->input->post('enddate');
		
		$where = "(1=1)";
		if(!empty($st_date)){
			$start = get_ym_start($st_date);				
			$where .= " AND o.createdate >= '".$start." 00:00:00'"; 
		}

		if(!empty($end_date)){
			$end = get_ym_end($end_date);				
			$where .= " AND o.createdate <= '".$end." 23:59:59'"; 
		}		

		if($this->userdata['urole_id']==2){
			$where .= " AND o.lic_id=".$this->userdata['user_id'];
		}

		$query = "SELECT o.createdate,o.lic_id,o.ia_id,CONCAT_WS(' ',u.firstname,u.lastname) AS consumer_name,
		total_amt,order_amt,lic_disburse
		FROM `orders` as o
		LEFT JOIN user as u ON `u`.`user_id`= `o`.`createdby`
		WHERE ".$where." ORDER BY o.createdate ASC";
		
 		$query=$this->db->query($query);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'general_transaction_summary-'.date('m-d-Y').'.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser

		$style = (new StyleBuilder())
		           ->setFontBold()
		           ->setFontSize(15)
		           ->setCellAlignment(CellAlignment::CENTER)
		           ->build();

		/** Create a row with cells and apply the style to all cells */
		$singleRow = WriterEntityFactory::createRowFromArray(['','','','General Transaction Summary Report','','',''], $style);
		$blankRow = WriterEntityFactory::createRowFromArray(['','','','','','','']);
		/** Add the row to the writer */
		$writer->addRow($singleRow);
		$writer->addRow($blankRow);

        
		$cellstyle = (new StyleBuilder())
           ->setFontBold()
           ->setFontSize(15)
           ->build();

        $cells = [
                WriterEntityFactory::createCell('Order Date and Time',$cellstyle),
                WriterEntityFactory::createCell('Licensee',$cellstyle),
                WriterEntityFactory::createCell('Industry Association',$cellstyle),
                WriterEntityFactory::createCell('Consumer',$cellstyle),
                WriterEntityFactory::createCell('Total Amount',$cellstyle),
                WriterEntityFactory::createCell('Total Order',$cellstyle),
                WriterEntityFactory::createCell('Order Total to Disburse',$cellstyle),
        ];

        //=== add a row at a time ===//
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
        if(!empty($obj)){
	        foreach ($obj as $row) {


	        	$modi = gmdate_to_mydate($row['createdate'],$this->localtimzone);
	        	$lic = $ia = '';
				$licData =  $this->generalmodel->getlicdata($row['lic_id']);
				if(!empty($licData)){
					$lic = $licData['business_name'];
				}

				$iaData =  $this->generalmodel->get_iadata($row['ia_id']);
				if(!empty($iaData)){
					$ia =  $iaData['business_name'];
				}				

				//$get_iadata =  $this->generalmodel->get_iadata($row['ia_id']);

	            $data[1] = date('m/d/Y',strtotime($modi));
	            $data[2] = $lic;
	            $data[3] = $ia;
	            $data[4] = $row['consumer_name'];
	            $data[5] = numfmt_format_currency($this->fmt,$row['total_amt'], "USD");
	            $data[6] = numfmt_format_currency($this->fmt,$row['order_amt'], "USD");
	            $data[7] = numfmt_format_currency($this->fmt,$row['lic_disburse'], "USD");
	            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
	        }
        }
        $writer->close(); 		
	}

	public function get_iaconsumers(){
		$html = '<option value="">Select a Consumer</option>';
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
			$ia = $this->input->post('ia_id');
			$consumerlist =  $this->generalmodel->consumerlist_of_ia_of_lic($ia);
			if(!empty($consumerlist)){
				foreach($consumerlist as $value){
					$html .='<option value="'.$value['user_id'].'">'.$value['username'].'</option>';
				}
			}
		}
		$return = array('html'=>$html);
		echo json_encode($return);
	}

	public function get_ia(){
		$html = '<option value="">Select An IA</option>';
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
			$lic = $this->input->post('lic');
			$ia_list =  $this->generalmodel->iaList($lic);
			if(!empty($ia_list)){
				foreach($ia_list as $value){
					$html .='<option value="'.$value['user_id'].'">'.$value['business_name'].'</option>';
				}
			}
		}
		$return = array('html'=>$html);
		echo json_encode($return);		
	}
	public function supplier_products(){
		$html = '<option value="">Select a Product</option>';
		if(!empty($this->input->post()) && $this->input->is_ajax_request()){
			$sid = $this->input->post('sid');
			$prod_list =  $this->generalmodel->supplier_products($sid);
			if(!empty($prod_list)){
				foreach($prod_list as $value){
					$html .='<option value="'.$value['prod_id'].'">'.$value['product_name'].'</option>';
				}
			}
		}
		$return = array('html'=>$html);
		echo json_encode($return);		
	}
	//======General Disbursement Transaction Report for all End Here====================	


}
?>
