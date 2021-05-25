<?php  
	   $uristring=$this->uri->segment(1).'/'.$this->uri->segment(2);	
	   $urione = $this->uri->segment(1);
	   $arr=array(); $arr=$this->session->userdata('userdata');
	   $perms=explode(",",$arr['upermission']);
?>
<style>
	.pr-cunsum {
display: flex;
justify-content: space-between;
	}
	li#cartmenu {
    position: relative;
}
#cartmenu ::before {
    content: "";
    position: absolute;
    border: 1px solid #000;
    height: 15px;
    margin-left: -8px;
}	
	@media (max-width: 991px) {
		ul.pr-viewcart {
    position: initial !important;
    opacity: 1 !important;
    visibility: visible !important;
    text-align: right;
    width: 210px !important;
    margin-left: auto !important;
    margin-top: 0px !important;
}
ul.pr-viewcart li {
    display: inline-block !important;
    z-index: 9;
}
	}
</style>
<nav class="pr-cunsum">
	<input type="checkbox" name="">
	<ul>
		<?php if($arr['urole_id']==5){ 
			if($urione=='myprofile'){ ?><li><a href="<?php echo site_url('myprofile');?>" class="active">My Profile</a></li>	<?php 
			}else{ ?><li><a href="<?php echo site_url('myprofile');?>">My Profile</a></li><?php } 
		} ?>
		<?php if(in_array('DASH_MOD',$perms)) {
			if($uristring=='cto-dashboard/'|| $uristring=='dashboard/' || $uristring=='lic-dashboard/' ||  $uristring=='ia-dashboard/'){
			?>
			<li><a href="<?php echo base_url();?>dashboard" class="active">Dashboard </a></li>
		<?php }else {?>	
			<li><a href="<?php echo base_url();?>dashboard">Dashboard </a></li>
		<?php } }?>

		<?php if(in_array('STAFF_MOD',$perms)) {
			if($uristring=='staff/allstaff' || $uristring=='staff/itstaff' || $uristring=='staff/comofficerstaff'|| $uristring=='staff/accountstaff'|| $uristring=='staff/marketingstaff'|| $uristring=='staff/prodmanagerstaff'|| $uristring=='staff/bdestaff'|| $uristring=='staff/kamstaff'||  $uristring=='staff/csrstaff'|| $uristring=='staff/addnew' || $uristring=='staff/staff_detail' || $uristring=='staff/editstaff' || $uristring=='staff/myprofile'){?>
			<li><a href="<?php echo base_url();?>staff/allstaff" class="active">Staff</a></li>
		<?php }else{?>
			<li><a href="<?php echo base_url();?>staff/allstaff">Staff</a></li>
		<?php } }?>

		<?php if(in_array('All_ACC_MOD',$perms)) {
			if($arr['urole_id']==1)
				$acclink='licensee/viewlicensee';
			elseif($arr['urole_id']==2)
				$acclink='industryassociation/viewia';
			elseif($arr['urole_id']==3)
				$acclink='consumer/consumer';

				if(($uristring=='licensee/viewlicensee' || $uristring=='licensee/addlicensee' || $uristring=='financial' || $uristring=='Kams' || $uristring=='industryassociation/viewlicia' || $uristring=='licensee/editlicensee' || $uristring=='financial' || $uristring=='industryassociation/addia' || $uristring=='financial/financial' || $uristring=='kams/viewkamslic' ||$uristring=='kams/viewkamsia'|| $uristring=='business_review/licbusiness_review' || $uristring=='supplier/addsupplier' || $uristring=='supplier/supplier' || $uristring=='licensee/productbylic' || $uristring=='marketing/bannerbylic' || $uristring=='consumer/consumer' || $uristring=='consumer/addnew' || $uristring=='consumer/consumer-detail' || $uristring=='consumer/editconsumer' || $uristring=='supplier/supplierdetail' || $uristring=='supplier/editsupplier' || $uristring=='licensee/licenseedetail' || $uristring=='industryassociation/Industryassociation' || $uristring=='industryassociation/productbyia' || $uristring=='supplier/productbysupplier' || $uristring=='marketing/bannerbyia' || $uristring=='licensee/viewproduct' || $uristring=='industryassociation/viewproduct' || $uristring=='supplier/viewproduct' || $uristring=='business_review/iabusiness_review' || $uristring=='business_review/licbusiness_detail' || $uristring=='business_review/editlicbusiness' || $uristring=='product/productassign' || $uristring=='product/productassignia' || $uristring=='business_review/iabusiness_detail' || $uristring=='industryassociation/viewia' || $uristring=='industryassociation/industryassociation' || $uristring=='ticket_account/ticketia' || $uristring=='reports/lic_reconciliation_report' || $uristring=='reports/lic_disbursment_report' || $uristring=='reports/lic_transaction_summary' || $uristring=='ticket_account/ticketlic' || $uristring=='reports/ia_reconciliation_report' || $uristring=='reports/ia_disbursment_report' || $uristring=='reports/ia_transaction_summary' || $uristring=='ticket_account/viewticket_account' || $uristring=='reports/purchase-report') && $uristring !='reports/lic_reconciliation_report' && $uristring !='reports/general-reconciliation-report' && $uristring !='reports/ia_reconciliation_report' ){	
				echo '<li><a href='.site_url($acclink).' class="active">All Accounts</a></li>';
				}else{
				echo '<li><a href='.site_url($acclink).'>All Accounts</a></li>';
				} 


			}?>			

		<?php if(in_array('FIN_MOD',$perms)) {
			if($this->userdata['urole_id']==2){
				$this->session->set_userdata('licenseeid',$this->userdata['user_id']);
				$report_url = 'reports/lic-reconciliation-report';
			}elseif($this->userdata['urole_id']==3){
				$this->session->set_userdata('iaid',$this->userdata['user_id']);
				$report_url = 'reports/ia-reconciliation-report';
			}elseif($this->userdata['urole_id']==1){
				$report_url = 'reports/general-reconciliation-report';
			}

			if($uristring=='account/reconciliation' ||$uristring=='reports/general-reconciliation-report' || $uristring=='account/monthlydisburse' || $uristring=='account/disbursement' || $uristring=='reports/all-lic-disbursement-report' || $uristring=='reports/all-ia-disbursement-report'|| $uristring=='reports/general-transaction-report' || $uristring=='reports/ia-reconciliation-report'|| $uristring=='reports/lic-reconciliation-report') {?>
				<li><a href="<?php echo site_url().$report_url;?>" class="active">Financial Reports</a></li>
			<?php }else{?>
				<li><a href="<?php echo site_url().$report_url;?>">Financial Reports</a></li>
		<?php } }?>			

		<?php if(in_array('PRD_MOD',$perms)) {
				if($uristring=='product/product' || $uristring=='product/addcategory' || $uristring=='audit/audit' || $uristring=='audit/viewaudit' || $uristring=='audit/editaudit' || $uristring=='product/int-expression'  || $uristring=='product/formtemplate'){?>		
			<li><a href="<?php echo base_url();?>product/product" class="active">Products</a></li>
			<?php }else{ ?>	
			<li><a href="<?php echo base_url();?>product/product">Products</a></li>	
		<?php } }?>

		<?php if(in_array('MAR_MOD',$perms)) {if($uristring=='marketing/page-ads' || $uristring=='marketing/banner' || $uristring == 'marketing/page-ads-form' || $uristring=='marketing/editbanner' || $uristring=='marketing/banner_detail' || $uristring=='marketing/page-manage-form' || $uristring=='audience/audience' || $uristring=='audience/editaudience' || $uristring=='audience/audiencedetail' || $uristring=='marketing/page-detail' || $uristring=='marketing/editpage-banner' || $uristring=='audience/addaudience' || $uristring=='marketing/viewpagedetail') {?>		
			<li><a href="<?php echo base_url();?>marketing/page-ads" class="active">Marketing</a></li>
			<?php }else{?>
			<li><a href="<?php echo base_url();?>marketing/page-ads">Marketing</a></li>	
		<?php } }?>

		<?php if(in_array('LEAD_MOD',$perms)) {
			if($uristring=='lead/contact' || $uristring=='lead/business' || $uristring=='lead/deal' || $uristring=='lead/pipeline'){?>	<li><a href="<?php echo base_url();?>lead/deal" class="active">Leads &amp; Prospects</a></li>
			<?php }else{?>
			 <li><a href="<?php echo base_url();?>lead/deal">Leads &amp; Prospects</a></li>	
		<?php } }?>

<?php //print_r($perms); exit; ?>
		<?php if(in_array('COMT_MOD',$perms)) {

			if($this->userdata['urole_id']==5){
				
				if($uristring=='supplier/ticket'){ ?>
					<li><a href="<?php echo site_url('supplier/ticket');?>" class="active">Compliance &amp; Tickets</a></li>
				<?php }else{ ?>
					<li><a href="<?php echo site_url('supplier/ticket');?>" >Compliance &amp; Tickets</a></li>
				<?php }
			}else{

			if($uristring=='ticket/ticket' || $uristring=='ticket/addticket' || $uristring=='ticket/viewticket' || $uristring=='ticket/editticket' || $uristring=='ticket/category'
		 || $uristring=='ticket/viewcategory' || $uristring=='ticket/editcategory' || $uristring=='complianeticket/whistleblower'){?>			
			<li><a href="<?php echo base_url();?>ticket/ticket" class="active">Compliance &amp; Tickets</a></li>
			<?php }else{?>
			<li><a href="<?php echo base_url();?>ticket/ticket">Compliance &amp; Tickets</a></li>	
		<?php } } }?>

		<?php if(in_array('USR_MOD',$perms)) {
			if($uristring=='awardlevel/add' || $urione=='awardlevel' || $uristring=='awardlevel/view' || $uristring=='awardlevel/edit'){?>		
			<li><a href="<?php echo base_url();?>awardlevel" class="active">Award Level Manager</a></li>
		<?php }else {?>
			<li><a href="<?php echo base_url();?>awardlevel">Award Level Manager</a></li>	
		<?php } }?>

		<?php if(in_array('TEM_MOD',$perms)) {		
			if($uristring=='template-manager/email-manager' || $uristring=='template-manager/doc_manager'){?>		
				<li><a href="<?php echo base_url();?>template-manager/email-manager" class="active">Template Manager</a></li>
			<?php }else {?>
				<li><a href="<?php echo base_url();?>template-manager/email-manager">Template Manager</a></li>	
		<?php } }?>

		<?php if(in_array('AUD_MOD',$perms)){
				if($uristring=='audit/audit' || $uristring=='audit/editaudit' || $uristring=='audit/viewaudit' || $uristring=='audit/addaudit'){
					echo '<li><a href='.site_url('audit/audit').' class="active">Audit</a></li>';
				}else{
					echo '<li><a href='.site_url('audit/audit').'>Audit</a></li>';
				}
		}
		?>
		<?php if(in_array('SHOP_MOD',$perms)) {	?>		
			<li><a href="<?php echo site_url('myprofile');?>">My Profile</a></li>	
			<?php 
			$orderHistory = ($arr['urole_id']==4)?getCustomerOrderCount($arr['user_id']):0;
			if($orderHistory>0)
				if($uristring=="consumer/orderHistory" || $this->uri->segment(1)=='order-summary'){
					echo '<li id="ord_his_menu" ><a href='.site_url('consumer/orderHistory').' class="active">Order History</a></li>';

				}else{
					echo '<li id="ord_his_menu" ><a href='.site_url('consumer/orderHistory').'>Order History</a></li>';
				}
			else
				if($uristring=="consumer/orderHistory" || $this->uri->segment(1)=='order-summary'){
					echo '<li id="ord_his_menu" style="display:none;" ><a href='.site_url('consumer/orderHistory').' class="active">Order History</a></li>';
				}else{
					echo '<li id="ord_his_menu" style="display:none;" ><a href='.site_url('consumer/orderHistory').'>Order History</a></li>';
				}


			if($this->uri->segment(1)=="shop")
				echo '<li><a href='.site_url('shop').' class="active">Shop</a></li>';
			else
				echo '<li><a href='.site_url('shop').'>Shop</a></li>';

			/*
			if(!empty($this->session->userdata('cartvalue')>0))
				echo '<li id="cartmenu" ><a href='.site_url('cart').'>Cart</a></li>';
			else
				echo '<li id="cartmenu" style="display:none;" ><a href='.site_url('cart').'>Cart</a></li>';
			*/
			if($uristring=="consumer/ticket")				
			echo '<li><a href='.site_url('consumer/ticket').' class="active">Tickets</a></li>';
			else
			echo '<li><a href='.site_url('consumer/ticket').'>Tickets</a></li>';
			
			if($uristring=="consumer/auditlist" || $uristring=='audit/editaudit' || $uristring=='audit/viewaudit')
			echo '<li><a href='.site_url('consumer/auditlist').' class="active">Audit</a></li>';
			else
			echo '<li><a href='.site_url('consumer/auditlist').'>Audit</a></li>';
			
		}?>
		
		
	</ul>
	
	<?php if(in_array('SHOP_MOD',$perms)) {	
		//$cartActive = 'active';
		$cartActive = $uristring=="cart/"?'active':'';

		if(!empty($this->session->userdata('cartqty')>0)){
			$cartqty = round($this->session->userdata('cartqty'),2);
			echo '<ul class="pr-viewcart"><li><span id="navCartTotal">'.$cartqty.' </span> <span> items in cart</span></li>';
			echo '<li id="cartmenu"><a href="'.site_url('cart').'" class="'.$cartActive.'">view cart</a></li></ul>';
		}else{
			echo '<ul class="pr-viewcart"><li><span id="navCartTotal">0 </span> <span> items in cart</span></li>';
			echo '<li id="cartmenu" style="display:none;"><a href="'.site_url('cart').'" class="'.$cartActive.'">view cart</a></li></ul>';
		}

	} ?>
		
	
</nav>	