<?php 
	$uristring=$this->uri->segment(1).'/'.$this->uri->segment(2);
	$urione = $this->uri->segment(1);
	$last = $this->uri->total_segments();
	//$myprofile='staff/staffprofile/'.$this->userdata["user_id"];
	$myprofile='staff/staffprofile/'.encoding($this->userdata["user_id"]);


	$arr=array(); $arr=$this->session->userdata('userdata');
	$perms=explode(",",$arr['upermission']);
?>
<div class="aside">
	<?php if($uristring=='staff/allstaff' || $uristring=='staff/itstaff' || $uristring=='staff/comofficerstaff'|| $uristring=='staff/accountstaff'|| $uristring=='staff/marketingstaff'|| $uristring=='staff/prodmanagerstaff'|| $uristring=='staff/bdestaff'|| $uristring=='staff/kamstaff'||  $uristring=='staff/csrstaff'|| $uristring=='staff/addnew' || $uristring=='staff/staff_detail' || $uristring=='staff/editstaff' || $uristring=='staff/staffprofile' || $uristring=='staff/myprofile'){ ?>
	<a href="<?php echo site_url('staff/allstaff'); ?>" style="text-decoration:none;"><h3>Staff</h3></a>
	<ul>
		<li>
			<a href="<?php echo site_url($myprofile); ?>">My Profile</a>
		</li>
		<?php if($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {?>
		<li>
			<a href="<?php echo site_url('staff/allstaff'); ?>">Staff Manager</a>
			<ul>
				<?php if($this->userdata["urole_id"]==1){
				echo '<li><a href='.site_url("staff/itstaff").'>I.T.</a></li>';
				echo '<li><a href='.site_url("staff/comofficerstaff").'>Compliance Officers</a></li>';
				}?>
				<!-- <li><a href="<?php echo site_url('staff/comofficerstaff'); ?>">Compliance Officers</a></li> -->
				<li><a href="<?php echo site_url('staff/accountstaff'); ?>">Accounts</a></li>
				<li><a href="<?php echo site_url('staff/marketingstaff'); ?>">Marketing</a></li>
				<?php if($this->userdata["urole_id"]==1)
				echo '<li><a href='.site_url("staff/prodmanagerstaff").'>Product Managers</a></li>';
				?>
				<li><a href="<?php echo site_url('staff/bdestaff'); ?>">BDEs</a></li>
				<li><a href="<?php echo site_url('staff/kamstaff'); ?>">KAMs</a></li>
				<li><a href="<?php echo site_url('staff/csrstaff'); ?>">CSRs</a></li>
			</ul>
		</li>
		<?php }?>
	</ul>
	<?php }?>
	<?php if($uristring=='licensee/viewlicensee' || $uristring=='licensee/addlicensee' || $uristring=='financial' || $uristring=='Kams' || $uristring=='industryassociation/viewlicia' || $uristring=='licensee/editlicensee' || $uristring=='financial' || $uristring=='industryassociation/addia' || $uristring=='financial/financial' || $uristring=='kams/viewkamslic' ||$uristring=='kams/viewkamsia'|| $uristring=='business-review/licbusiness-review' || $uristring=='supplier/addsupplier' || $uristring=='supplier/supplier' || $uristring=='licensee/productbylic' || $uristring=='marketing/bannerbylic' || $uristring=='consumer/consumer' || $uristring=='consumer/addnew' || $uristring=='consumer/consumer-detail' || $uristring=='consumer/editconsumer' || $uristring=='supplier/supplierdetail' || $uristring=='supplier/editsupplier' || $uristring=='licensee/licenseedetail' || $uristring=='industryassociation/Industryassociation' || $uristring=='industryassociation/productbyia' || $uristring=='supplier/productbysupplier' || $uristring=='marketing/bannerbyia' || $uristring=='licensee/viewproduct' || $uristring=='industryassociation/viewproduct' || $uristring=='supplier/viewproduct' || $uristring=='business-review/iabusiness-review' || $uristring=='business-review/editiabusiness' || $uristring=='business-review/licbusiness-detail' || $uristring=='business-review/editlicbusiness' || $uristring=='product/productassign' || $uristring=='product/productassignia' || $uristring=='business-review/iabusiness-detail/' || $uristring=='industryassociation/viewia' || $uristring=='industryassociation/industryassociation' || $uristring=='ticket-account/ticketia' || $uristring=='reports/lic-reconciliation-report' || $uristring=='reports/lic-disbursment-report' || $uristring=='reports/lic-transaction-summary' || $uristring=='ticket-account/ticketlic' || $uristring=='reports/ia-reconciliation-report' || $uristring=='reports/ia-disbursment-report' || $uristring=='reports/ia-transaction-summary' || $uristring=='ticket_account/viewticket_account' || $uristring=='reports/purchase-report' || $uristring=='reports/ia_sales_report' || $uristring=='ticket-account/ticketconsume' || $uristring=='ticket_account/viewlicticket' || $uristring=='ticket_account/viewiaticket'|| $uristring=='ticket_account/viewconticket' || $uristring=='ticket/editlicticket' || $uristring=='ticket/editiaticket' || $uristring=='ticket/editconticket' || $uristring=='audit/consumeraudit' || $uristring=='audit/editconaudit' || $uristring=='reports/sup-sales-report' || $uristring=='marketing/pagebylic' || $uristring=='marketing/pagebyia'){?>
	<a href="<?php echo site_url($uristring); ?>" style="text-decoration:none;"><h3>All Accounts</h3></a>
	<ul>
		<?php if(in_array('LIC_V',$perms) || in_array('LIC_A',$perms) || in_array('LIC_KAM_V',$perms) || in_array('LIC_IA_V',$perms) || in_array('LIC_BR_V',$perms) || in_array('LIC_TIC_V',$perms) || in_array('LIC_PRODC_V',$perms) || in_array('LIC_BN_V',$perms)){ ?>
		<?php 
		echo '<li>';
			if(in_array('LIC_V',$perms))
			echo '<a href='.site_url("licensee/viewlicensee").'>Licensees</a>';
			echo '
			<ul>';
				if($uristring=='licensee/licenseedetail' || $uristring=='licensee/editlicensee' || $uristring=='kams/viewkamslic' || $uristring=='industryassociation/viewlicia' || $uristring=='business-review/licbusiness-review' || $uristring=='product/productassign' || $uristring=='licensee/addlicensee' || $uristring=='reports/lic-reconciliation-report' || $uristring=='reports/lic-disbursment-report' || $uristring=='reports/lic-transaction-summary' || $uristring=='ticket-account/ticketlic' || $uristring=='ticket_account/viewticket_account' || $uristring=='business-review/licbusiness-detail' || $uristring=='ticket_account/viewlicticket' || $uristring=='business-review/editlicbusiness' || $uristring=='ticket/editlicticket'|| $uristring=='marketing/bannerbylic' || $uristring=='marketing/pagebylic' )
					echo '<li>';
				else
					echo '<li style="display:none;">';	
					//echo '<ul>';
					if(in_array('LIC_A',$perms)){
						echo '<li><a href='.site_url("licensee/addlicensee").'>Add New Account</a></li>';
					}
					if(!empty($this->session->userdata['licenseeid'])){
						if(in_array('LIC_V',$perms)){
						echo '<li><a href='.site_url("licensee/licenseedetail/".encoding($this->session->userdata['licenseeid'])."").'>Details</a></li>';	
					}
					if(in_array('LIC_FIN_RV',$perms)){
						echo '<li><a href="javascript:void(0)">Financial Reports</a>';
						echo '<ul>';	
						echo '<li><a href='.site_url("reports/lic-reconciliation-report").'>Reconciliation Reports</a><li>';
						echo '<li><a href="javascript:void(0)">Disbursement Reports</a>';
							echo '<ul>';
							echo '<li><a href='.site_url("reports/lic-disbursment-report").'>Monthly Summary</a><li>';
							echo '<li><a href='.site_url("reports/lic-transaction-summary").'>Transaction History</a><li>';
							echo '</ul>';	
						echo '<li>';
						echo '</ul>';
						echo '</li>';
					}	
					if(in_array('LIC_KAM_V',$perms))
						echo '<li><a href="'.site_url().'kams/viewkamslic">KAMs and CSRs</a></li>';
					if(in_array('LIC_IA_V',$perms))
						echo '<li><a href="'.site_url().'industryassociation/viewlicia/">Industry Associations</a></li>';
					if(in_array('LIC_BR_V',$perms))
						echo '<li><a href="'.site_url().'business-review/licbusiness-review/">Business Reviews</a></li>';
					if(in_array('LIC_TIC_V',$perms))
						echo '<li><a href="'.site_url().'ticket-account/ticketlic">Tickets</a></li>';
					/*if(in_array('LIC_PRODC_V',$perms))
						echo '<li><a href='.site_url("licensee/productbylic").'>Products</a></li>';*/
					// if(in_array('LIC_BN_V',$perms))
					// 	echo '<li><a href="'.site_url().'marketing/bannerbylic/">Marketing</a></li>';	
					if(in_array('LIC_BN_V',$perms)){
						echo '<li><a href="javascript:void(0)">Marketing</a>';
						echo '<ul>';
							echo '<li><a href="'.site_url().'marketing/bannerbylic/">Banner Manager</a><li>';
							echo '<li><a href="'.site_url().'marketing/pagebylic/">Page Manager</a><li>';
						
						echo '</ul>';
						echo '</li>';	
					}
					}
					
					
					// echo '</ul>'; ?>
				</li>
			</ul>
		</li>
		<?php }?>
		<?php if(in_array('IA_A',$perms) || in_array('IA_V',$perms) || in_array('IA_FIN_RV',$perms) || in_array('IA_KAM_V',$perms) || in_array('IA_BR_V',$perms) || in_array('IA_TIC',$perms) || in_array('IA_PRODC_V',$perms) || in_array('IA_BN_V',$perms)){ ?>
		<?php 
		echo '<li>';
			if(in_array('IA_V',$perms))
			echo '<a href="'.site_url().'industryassociation/viewia/">Industry Associations</a>';
			echo '<ul>';
					if($uristring=='industryassociation/industryassociation' || $uristring=='kams/viewkamsia' ||$uristring=='business-review/iabusiness-review' || $uristring=='industryassociation/addia' || $uristring=='business-review/editiabusiness' || $uristring=='ticket-account/ticketia' || $uristring=='reports/ia-reconciliation-report' || $uristring=='reports/ia-disbursment-report' || $uristring=='reports/ia-transaction-summary' || $uristring=='reports/ia_sales_report' || $uristring=='business-review/iabusiness-detail/' || $uristring=='ticket/editiaticket' || $uristring=='marketing/bannerbyia' || $uristring=='marketing/pagebyia')
						echo '<li>';
					else	
						echo '<li style="display:none;">';
					if(in_array('IA_A',$perms))
					echo '<a href='.site_url("industryassociation/addia").'>Add New Account</a>';
					echo '<ul>';
					if(!empty($this->session->userdata['iaid'])){
						if(in_array('IA_V',$perms))
					echo '<li><a href='.site_url("industryassociation/industryassociation/industryassociation/".encoding($this->session->userdata['iaid'])."").'>Details</a></li>';
					if(in_array('IA_FIN_RV',$perms)){
						echo '<li><a href="#">Financial Reports</a>';
						echo '<ul>';
						echo '<li><a href='.site_url("reports/ia-reconciliation-report").'>Reconciliation Reports</a><li>';
						echo '<li><a href="#">Disbursement Reports</a>';
							echo '<ul>';
							echo '<li><a href='.site_url("reports/ia-disbursment-report").'>Monthly Summary</a><li>';
							echo '<li><a href='.site_url("reports/ia-transaction-summary").'>Transaction History</a><li>';
							echo '</ul>';	
						echo '<li>';
						echo '</ul>';
						echo '</li>';
					}
					if($this->userdata["urole_id"]==2)
					echo '<li><a href="'.site_url().'reports/ia_sales_report">Sales Report</a></li>';	
					if(in_array('IA_KAM_V',$perms))
					echo '<li><a href="'.site_url().'kams/viewkamsia/">KAMs and CSRs</a></li>';
					if(in_array('IA_BR_V',$perms))
					echo '<li><a href="'.site_url().'business-review/iabusiness-review/">Business Reviews</a></li>';
					if(in_array('IA_TIC',$perms))
					echo '<li><a href="'.site_url().'ticket-account/ticketia">Tickets</a></li>';
					/*if(in_array('IA_PRODC_V',$perms))
					echo '<li><a href='.site_url('industryassociation/productbyia').'>Products</a></li>';*/
					// if(in_array('IA_BN_V',$perms))
					// echo '<li><a href="'.site_url().'marketing/bannerbyia/">Marketing</a></li>';

					if(in_array('IA_BN_V',$perms)){
						echo '<li><a href="javascript:void(0)">Marketing</a>';
						echo '<ul>';
							echo '<li><a href="'.site_url().'marketing/bannerbyia/">Banner Manager</a><li>';
							echo '<li><a href="'.site_url().'marketing/pagebyia/">Page Manager</a><li>';
						
						echo '</ul>';
						echo '</li>';	
					}
					}
					echo '</ul>';
				echo '</li>';
			echo '</ul>';
		echo '</li>'; }?>

		<?php 
		echo '<li>';
			if(in_array('CON_A',$perms) ||in_array('CON_V',$perms)|| in_array('CON_P',$perms) || in_array('CON_T',$perms) || in_array('CON_AT',$perms)){
			echo '<a href='.site_url("consumer/consumer").'>Consumers</a>';

			if($uristring=='consumer/addnew' || $uristring=='ticket-account/ticketconsume' || $uristring=='consumer/consumer-detail' ||$uristring=='consumer/editconsumer' || $uristring=='reports/purchase-report' || $uristring=='ticket-account/viewconticket' || $uristring=='ticket/editconticket' || $uristring=='audit/consumeraudit' || $uristring=='audit/editconaudit')
				echo '<ul>';
			else 
			echo '<ul style="display:none;">';	
				if(in_array('CON_A',$perms))
				echo '<li><a href='.site_url("consumer/addnew").'">Add New Account</a></li>';
				if(in_array('CON_V',$perms) && isset($this->session->userdata['customerid']))	
				echo '<li><a href='.site_url("consumer/consumer-detail/").encoding($this->session->userdata['customerid']).'>Details</a></li>';
				if(in_array('CON_P',$perms))
				echo '<li><a href='.site_url("reports/purchase-report").'>Purchase Reports</a></li>';
				if(in_array('CON_T',$perms))
				echo '<li><a href="'.site_url().'ticket-account/ticketconsume">Tickets</a></li>';
				if(in_array('CON_AT',$perms))
				echo '<li><a href='.site_url("audit/consumeraudit").'>Audits</a></li>';
			echo '</ul>';
		echo '</li>'; }?>
		
		<?php 
		echo '<li>';
			if(in_array('SUPP_A',$perms) || in_array('SUPP_V',$perms) || in_array('SUPP_S',$perms) || in_array('SUPP_P',$perms) || in_array('SUPP_T',$perms))
			echo '<a href='.site_url('supplier/supplier').'>Suppliers</a>';
			if($uristring=='supplier/addsupplier' || $uristring=='supplier/productbysupplier' || $uristring=='supplier/supplierdetail' || $uristring=='supplier/editsupplier' || $uristring=='reports/sup-sales-report')
			    echo '<ul>';
			else
				echo '<ul style="display:none;">';
				if(in_array('SUPP_A',$perms))
				echo '<li><a href='.site_url('supplier/addsupplier').'>Add New Account</a><li>';
				if(!empty($this->session->userdata["supplierid"])){
					if(in_array('SUPP_V',$perms))
				echo '<li><a href='.site_url('supplier/supplierdetail/').encoding($this->session->userdata["supplierid"]).'>Details</a><li>';
				if(in_array('SUPP_S',$perms))
					echo '<li><a href='.site_url('reports/sup-sales-report').'>Sales and Reports</a></li>';
				if(in_array('SUPP_P',$perms))
					echo '<li><a href='.site_url('supplier/productbysupplier').'>Product</a></li>';
				if(in_array('SUPP_T',$perms))
					echo '<li><a href="'.site_url().'ticket/ticket_account/ticketsup">Ticket</a></li>';
				}
			echo '</ul>';
		echo '</li>';?>
	</ul>
	<?php }?>
	<?php if($this->userdata['urole_id']==1 && ($uristring=='reports/general-reconciliation-report' || $uristring=='reports/all-lic-disbursement-report' || $uristring=='reports/general-transaction-report' || $uristring=='reports/all-ia-disbursement-report')){?>
	<a href="<?php echo site_url('reports/general-reconciliation-report'); ?>" style="text-decoration:none;"><h3>Financial Reports</h3></a>
	<ul>
		<li>
				<a href="<?php echo site_url('reports/general-reconciliation-report'); ?>">Reconciliation Reports</a>
			</li>
			<li>
				<a href="#">Disbursement Reports</a>
				<ul>
					<li><a href=#>Monthly Summary</a>
						<ul>
							<?php
							echo '<li><a href='.site_url("reports/all-lic-disbursement-report").'>Licensee Monthly Summary</li>';
							echo '<li><a href='.site_url("reports/all-ia-disbursement-report").'>Industry Association Monthly Summary</li>'; ?>
						</ul>	
					</li>
					<li><a href="<?php echo site_url('reports/general-transaction-report'); ?>">Transaction History</a></li>
				</ul>
			</li>
		</ul>
	<?php }?>
	<?php if($this->userdata['urole_id']==2 && ($uristring=='reports/lic-reconciliation-report' || $uristring=='reports/all-lic-disbursement-report' || $uristring=='reports/general-transaction-report' || $uristring=='reports/all-ia-disbursement-report')){?>
	<a href="<?php echo site_url('reports/lic-reconciliation-report'); ?>" style="text-decoration:none;"><h3>Financial Reports</h3></a>
	<ul>
		<li>
				<a href="<?php echo site_url('reports/lic-reconciliation-report'); ?>">Reconciliation Reports</a>
			</li>
			<li>
				<a href="#">Disbursement Reports</a>
				<ul>
					<li><a href='<?php echo site_url("reports/all-ia-disbursement-report"); ?>'>Monthly Summary</a></li>
					<li><a href="<?php echo site_url('reports/general-transaction-report'); ?>">Transaction History</a></li>
				</ul>
			</li>
		</ul>
	<?php }?>
	<?php if($this->userdata['urole_id']==3 && ($uristring=='reports/ia-reconciliation-report' || $uristring=='reports/ia-disbursment-report' || $uristring=='reports/general-transaction-report' || $uristring=='reports/all-ia-disbursement-report')){?>
	<a href="<?php echo site_url('reports/ia-reconciliation-report'); ?>" style="text-decoration:none;"><h3>Financial Reports</h3></a>
	<ul>
		<li>
				<a href="<?php echo site_url('reports/ia-reconciliation-report'); ?>">Reconciliation Reports</a>
			</li>
			<li>
				<a href="#">Disbursement Reports</a>
				<ul>
					<li><a href='<?php echo site_url("reports/ia-disbursment-report"); ?>'>Monthly Summary</a></li>
					<li><a href="<?php echo site_url('reports/ia-transaction-summary'); ?>">Transaction History</a></li>
				</ul>
			</li>
		</ul>
	<?php }?>	
	<?php if($uristring=='marketing/page-ads' || $uristring=='marketing/banner' || $uristring == 'marketing/page-ads-form' || $uristring=='marketing/editbanner' || $uristring=='marketing/banner-detail' || $uristring=='marketing/page-manage-form' || $uristring=='marketing/page-detail' || $uristring=='marketing/editpage-banner' || $uristring=='audience/audience' || $uristring=='audience/addaudience' || $uristring=='audience/audiencedetail' || $uristring=='audience/uploadcsv' || $uristring=='audience/editaudience' || $uristring=='audience/audiencedetail' || $uristring=='marketing/editpage_banner') {?>
	<a href="<?php echo site_url('marketing/page-ads'); ?>" style="text-decoration:none;"><h3>Marketing</h3></a>
	<ul>
		<?php if(in_array('PG_V', $perms)) {?>
		<li>
			<a href="<?php echo site_url('marketing/page-ads'); ?>">Page Manager</a>
		</li>
		<?php }?>
		<?php if(in_array('BN_V', $perms)) {?>
		<li>
			<a href="<?php echo site_url('marketing/banner'); ?>">Banner Manager</a>
		</li>
		<?php }?>
		<?php if(in_array('AUD_V', $perms)) {?>
		<li>
			<a href="<?php echo site_url('audience/audience'); ?>">Audience</a>
		</li>
		<?php }?>
	</ul>
	<?php }?>
	
	<?php if($uristring=='product/product' || $uristring=='product/addcategory' || $uristring=='product/formtemplate' || $uristring=='product/formtemplate/addnew' || $uristring=='audit/audit' || $uristring=='audit/auditlic' || $uristring=='audit/auditia' || $uristring=='audit/editaudit' || $uristring=='audit/viewaudit' || $uristring=='licensee/int_expression' || $uristring=='industryassociation/int_expression' || $uristring=='product/int-expression' and $this->userdata['urole_id']!=5){?>
	<a href="<?php echo site_url('product/product'); ?>" style="text-decoration:none;"><h3>Product</h3></a>
	<ul>
		<li>
			<a href="<?php echo site_url('product/product'); ?>">Product Manager</a>
			<ul>
				<?php if($this->userdata['urole_id']==1){
					echo '<li><a href='.site_url("audit/audit").'>Purchased Audits</a></li>';
					echo '<li><a href='.site_url("product/int-expression").'>Expressions of Interest</a></li>';
				}else if($this->userdata['urole_id']==2){
					echo '<li><a href='.site_url("audit/auditlic").'>Purchased Audits</a></li>';
					echo '<li><a href='.site_url("licensee/int_expression").'>Expressions of Interest</a></li>';
				}
				else if($this->userdata['urole_id']==3){
					echo '<li><a href='.site_url("audit/auditia").'>Purchased Audits</a></li>';
					echo '<li><a href='.site_url("industryassociation/int_expression").'>Expressions of Interest</a></li>';	
				}?>
				
			</ul>
		</li>
		<li>
			<a href="<?php echo site_url('product/product/category');?>">Category Manager</a>
		</li>
		<?php if(in_array('FTM_MOD',$perms)) {?>
			<li><a href="<?php echo site_url('product/formtemplate');?>">Form Template Manager</a></li>	
		<?php }?>	
	</ul>
	<?php }?>
	<?php if($uristring=='lead/contact' || $uristring=='lead/business' || $uristring=='import-business-contact/' || $uristring=='lead/deal' || $uristring=='lead/pipeline')  {?>
	<a href="<?php echo site_url('lead/deal'); ?>" style="text-decoration:none;"><h3>Leads and Prospects</h3></a>
	<ul>
		<li>
			<a href="<?php echo site_url('lead/pipeline'); ?>">Pipeline</a>
		</li>
		<li>
			<a href="<?php echo site_url('lead/contact'); ?>">Contacts</a>
		</li>
		<li>
			<a href="<?php echo site_url('lead/business'); ?>">Businesses</a>
		</li>
		<li>
			<a href="<?php echo site_url('lead/deal'); ?>">Deals</a>
		</li>
		<li>
			<a href="<?php echo site_url('lead/pipeline/piplinereport'); ?>">Pipeline Report</a>
		</li>
	</ul>
	<?php }?>

	<?php if($urione == 'awardlevel' || $uristring=='awardlevel/add' || $uristring=='awardlevel/view' || $uristring=='awardlevel/edit'){ ?>
	<a href="<?php echo site_url('awardlevel'); ?>" style="text-decoration:none;"><h3>Award Level Manager</h3></a>
	<ul>
		<li>
			<a href="<?php echo site_url('awardlevel/add'); ?>">Add Award Level</a>
		</li>
		<li>
			<a href="<?php echo site_url('awardlevel'); ?>">Award Level</a>
		</li>
	</ul>
	<?php }?>

	<?php if($uristring=='ticket/ticket' || $uristring=='ticket/addticket' || $uristring=='ticket/viewticket' || $uristring=='ticket/editticket' || $uristring=='ticket/category' || $uristring=='ticket/addcategory' || $uristring=='ticket/viewcategory' || $uristring=='ticket/editcategory' || $uristring=='complianeticket/whistleblower' ){?>
	<a href="<?php echo site_url('ticket/ticket'); ?>" style="text-decoration:none;"><h3>Compliance & Tickets</h3></a>
	<ul>
		<li>
			<a href="<?php echo site_url('ticket/category');?>">Category Manager</a>
		</li>
		<li>
			<a href="<?php echo site_url('complianeticket/whistleblower');?>">Whistle Blowers</a>
		</li>
		<li>
			<a href="javascript:void(0);">WhistleBlower Report</a>
			<ul>
				<li><a href="<?php echo site_url('complianeticket/whistleblower/whislelic'); ?>">Licensees</a></li>
				<li><a href="<?php echo site_url('complianeticket/whistleblower/whistleia'); ?>">Industry Association</a></li>
				<li><a href="<?php echo site_url('complianeticket/whistleblower/whistlesup'); ?>">Supplier</a></li>
				<li><a href="<?php echo site_url('complianeticket/whistleblower/whistleconsume'); ?>">Consumer</a></li>
			</ul>
		</li>
	</ul>
	<?php } ?>


	<?php if($uristring=='template-manager/email-manager' || $uristring=='template-manager/doc-manager'){?>		
	<a href="<?php echo site_url('template-manager/email-manager'); ?>" style="text-decoration:none;"><h3>Templates</h3></a>
	<ul>
		<li>
			<a href="<?php echo site_url('template-manager/doc-manager');?>">Document Template</a>
		</li>
		<li>
			<a href="<?php echo site_url('template-manager/email-manager');?>">Email Template</a>
		</li>
	</ul>
	<?php } ?>


	<?php 
	if($this->userdata['urole_id']==5){
		if($uristring=='audit/audit' || $uristring=='audit/editaudit' || $uristring=='audit/viewaudit' || $uristring=='audit/addaudit'){?>		
	<h3>Audit</h3>
	<ul>
		<li>
			<a href="<?php echo site_url('audit/audit');?>">Audit Product</a>
		</li>
	</ul>
	<?php } }?>
</div>