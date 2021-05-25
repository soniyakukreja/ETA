<?php 
	$uristring=$this->uri->segment(1).'/'.$this->uri->segment(2);
	$myprofile='staff/staffprofile/'.$this->userdata["user_id"];
	$arr=array(); $arr=$this->session->userdata('userdata');
	$perms=explode(",",$arr['upermission']);
;?>
<div class="aside">
	<?php if($uristring=='staff/allstaff' || $uristring=='staff/itstaff' || $uristring=='staff/comofficerstaff'|| $uristring=='staff/accountstaff'|| $uristring=='staff/marketingstaff'|| $uristring=='staff/prodmanagerstaff'|| $uristring=='staff/bdestaff'|| $uristring=='staff/kamstaff'||  $uristring=='staff/csrstaff'|| $uristring=='staff/addnew' || $uristring=='staff/staff_detail' || $uristring=='staff/editstaff' || $uristring=='staff/staffprofile'){ ?>
	<h3>Staff</h3>
	<ul>
		<li>
			<a href="<?php echo site_url($myprofile); ?>">My Profile</a>
		</li>
		<li>
			<a href="<?php echo site_url('staff/allstaff'); ?>">Staff Manager</a>
			<ul>
				<?php if($this->userdata["urole_id"]==1)
				echo '<li><a href='.site_url("staff/itstaff").'>I.T.</a></li>';
				?>
				<li><a href="<?php echo site_url('staff/comofficerstaff'); ?>">Compliance Officers</a></li>
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
	</ul>
	<?php }?>
	<?php if($uristring=='licensee/viewlicensee' || $uristring=='licensee/addlicensee' || $uristring=='financial' || $uristring=='Kams' || $uristring=='industryassociation/viewia' || $uristring=='licensee/editlicensee' || $uristring=='financial' || $uristring=='industryassociation/addia' || $uristring=='financial/financial' || $uristring=='kams/kams' || $uristring=='business_review/licbusiness_review' || $uristring=='supplier/addsupplier' || $uristring=='supplier/supplier' || $uristring=='licensee/productbylic' || $uristring=='licensee/bannerbylic' || $uristring=='consumer/consumer' || $uristring=='consumer/addnew' || $uristring=='consumer/consumer_detail' || $uristring=='consumer/editconsumer' || $uristring=='supplier/supplierdetail' || $uristring=='supplier/editsupplier' || $uristring=='licensee/licenseedetail' || $uristring=='industryassociation/Industryassociation' || $uristring=='industryassociation/productbyia' || $uristring=='supplier/productbysupplier' || $uristring=='industryassociation/bannerbyia' || $uristring=='licensee/viewproduct' || $uristring=='industryassociation/viewproduct' || $uristring=='supplier/viewproduct' || $uristring=='business_review/iabusiness_review' || $uristring=='business_review/licbusiness_detail' || $uristring=='business_review/editlicbusiness' || $uristring=='product/productassign' || $uristring=='product/productassignia' || $uristring=='business_review/iabusiness_detail')  {?>
	<h3>All Accounts</h3>
	<ul>
		<?php if(in_array('LIC_V',$perms) || in_array('LIC_A',$perms) || in_array('LIC_KAM_V',$perms) || in_array('LIC_IA_V',$perms) || in_array('LIC_BR_V',$perms) || in_array('LIC_TIC_V',$perms) || in_array('LIC_PRODC_V',$perms) || in_array('LIC_BN_V',$perms)){ ?>
		<?php 
		echo '<li>';
	
			echo '<a href="#">Licensees</a>';
			echo '
			<ul>
				<li>';
					if(empty($id)){$ids = '';}else{ $ids = $id;}
					if(in_array('LIC_V',$perms))
						echo '<a href='.site_url("licensee/viewlicensee").'>View & Manage Licensees</a>'; 
					echo '<ul>';
					if(in_array('LIC_A',$perms))
						echo '<li><a href='.site_url("licensee/addlicensee").'>Add New</a></li>';
					if(in_array('LIC_FIN_RV',$perms))
						echo '<li><a href='.site_url("financial/financial").'>Financial Reports</a></li>';
					if(in_array('LIC_KAM_V',$perms))
						echo '<li><a href="'.site_url().'kams/kams">KAMs and CSRs</a></li>';
					if(in_array('LIC_IA_V',$perms))
						echo '<li><a href='.site_url("industryassociation/viewia").'>Industry Associations</a></li>';
					if(in_array('LIC_BR_V',$perms))
						echo '<li><a href='.site_url("business_review/licbusiness_review").'>Business Reviews</a></li>';
					if(in_array('LIC_TIC_V',$perms))
						echo '<li><a href="'.site_url().'ticket/ticket_account/ticketlic">Tickets</a></li>';
					/*if(in_array('LIC_PRODC_V',$perms))
						echo '<li><a href='.site_url("licensee/productbylic").'>Products</a></li>';*/
					if(in_array('LIC_BN_V',$perms))
						echo '<li><a href='.site_url("licensee/bannerbylic").'>Marketing</a></li>';
					echo '</ul>'; ?>
				</li>
			</ul>
		</li>
		<?php }?>
		<?php if(in_array('IA_A',$perms) || in_array('IA_V',$perms) || in_array('IA_FIN_RV',$perms) || in_array('IA_KAM_V',$perms) || in_array('IA_BR_V',$perms) || in_array('IA_TIC',$perms) || in_array('IA_PRODC_V',$perms) || in_array('IA_BN_V',$perms)){ ?>
		<?php 
		echo '<li>';
			echo '<a href="#">Industry Associations</a>';
			echo '<ul>';
				echo '<li>';
					if(in_array('IA_A',$perms))
					echo '<a href='.site_url("industryassociation/addia").'>Add New</a>';
					echo '<ul>';
					if(in_array('IA_V',$perms))
					echo '<li><a href='.site_url("industryassociation/viewia").'>View & Manage Industry Associations</a></li>';
					if(in_array('IA_FIN_RV',$perms))
					echo '<li><a href='.site_url("financial/financial").'>Financial Reports</a></li>';
					if(in_array('IA_KAM_V',$perms))
					echo '<li><a href='.site_url("kams/kams/viewkamsia").'>KAMs and CSRs</a></li>';
					if(in_array('IA_BR_V',$perms))
					echo '<li><a href='.site_url("business_review/iabusiness_review").'>Business Reviews</a></li>';
					if(in_array('IA_TIC',$perms))
					echo '<li><a href="'.site_url().'ticket/ticket_account/ticketia">Tickets</a></li>';
					/*if(in_array('IA_PRODC_V',$perms))
					echo '<li><a href='.site_url('industryassociation/productbyia').'>Products</a></li>';*/
					if(in_array('IA_BN_V',$perms))
					echo '<li><a href='.site_url('industryassociation/bannerbyia').'>Marketing</a></li>';
					echo '</ul>';
				echo '</li>';
			echo '</ul>';
		echo '</li>'; }?>
		<?php 
		echo '<li>';
			if(in_array('CON_V',$perms) || in_array('CON_A',$perms) || in_array('CON_P',$perms) || in_array('CON_T',$perms) || in_array('CON_AT',$perms))
			echo '<a href="#">Consumers</a>';
			echo '<ul>';
				if(in_array('CON_V',$perms))
					echo '<li><a href='.site_url("consumer/consumer").'>Viewing and Managing Consumers</a>';
				echo '<ul>';
				if(in_array('CON_A',$perms))	
				echo '<li><a href='.site_url("consumer/addnew").'>Add New</a></li>';
				if(in_array('CON_P',$perms))
				echo '<li><a href="#">Purchase Reports</a></li>';
				if(in_array('CON_T',$perms))
				echo '<li><a href="'.site_url().'ticket/ticket_account/ticketconsume">Tickets</a></li>';
				if(in_array('CON_AT',$perms))
				echo '<li><a href="#">Audits</a></li>';
				echo '</ul>';
				echo '</li>';
			echo '</ul>';
		echo '</li>'; ?>
		<?php 
		echo '<li>';
			if(in_array('SUPP_A',$perms) || in_array('SUPP_V',$perms) || in_array('SUPP_S',$perms) || in_array('SUPP_P',$perms) || in_array('SUPP_T',$perms))
			echo '<a href="#">Suppliers</a>';
			echo '<ul>';
				if(in_array('SUPP_V',$perms))
					echo '<li><a href='.site_url('supplier/supplier').'>Viewing and Managing Suppliers</a>';
				echo '<ul>';
				if(in_array('SUPP_A',$perms))
				echo '<li><a href='.site_url('supplier/addsupplier').'>Add New</a>';
				if(in_array('SUPP_S',$perms))
					echo '<li><a href="#">Sales and Reports</a></li>';
				if(in_array('SUPP_P',$perms))
					echo '<li><a href='.site_url('supplier/productbysupplier').'>Product</a></li>';
				if(in_array('SUPP_T',$perms))
					echo '<li><a href="'.site_url().'ticket/ticket_account/ticketsup">Ticket</a></li>';
				echo '</ul>';
			echo '</li>';
			echo '</ul>';
		echo '</li>';?>
	</ul>
	<?php }?>
	<?php if($uristring=='account/reconciliation' || $uristring=='account/monthlydisburse' || $uristring=='account/disbursement') {?>
	<h3>Financial Reports</h3>
	<ul>
		<li>
			<a href="<?php echo site_url('account/reconciliation'); ?>">Reconcilliation Reports</a>
		</li>
		<li>
			<a href="<?php echo site_url('account/Disbursement/monthlydisburse'); ?>">Dispuresement Reports</a>
			<ul>
				<li><a href="<?php echo site_url('account/Disbursement/monthlydisburse'); ?>">Monthly Summary</a></li>
				<li><a href="<?php echo site_url('account/Disbursement'); ?>">Transaction Summary</a></li>
			</ul>
		</li>
	</ul>
	<?php }?>
	<?php if($uristring=='marketing/page_ads' || $uristring=='marketing/banner' || $uristring == 'marketing/page_ads_form' || $uristring=='marketing/editbanner' || $uristring=='marketing/banner_detail' || $uristring=='marketing/page_manage_form' || $uristring=='marketing/page_detail' || $uristring=='marketing/editpage_banner') {?>
	<h3>Marketing</h3>
	<ul>
		<!-- <li>
			<a href="#">Newsletters</a>
		</li> -->
		<li>
			<a href="<?php echo site_url('marketing/page_ads'); ?>">Page Manager</a>
		</li>
		<li>
			<a href="<?php echo site_url('marketing/banner'); ?>">Banner Manager</a>
		</li>
		<li>
			<a href="#">Audience</a>
		</li>
	</ul>
	<?php }?>
	
	<?php if($uristring=='product/product' || $uristring=='product/addcategory' || $uristring=='product/formtemplate' || $uristring=='product/formtemplate/addnew'){?>
	<h3>Product</h3>
	<ul>
		<li>
			<a href="<?php echo site_url('product/product'); ?>">Product Manager</a>
			<ul>
				<li><a href="#">Audit Product</a></li>
				<li><a href="#">Expression of Interest</a></li>
			</ul>
		</li>
		<li>
			<a href="<?php echo site_url('product/product/category');?>">Category Manager</a>
		</li>
		<li>
			<a href="<?php echo site_url('product/formtemplate');?>">Form Template Manager</a>
		</li>
		<li>
			<a href="#">Audience</a>
		</li>
	</ul>
	<?php }?>
	<?php if($uristring=='lead/contact' || $uristring=='lead/business' || $uristring=='lead/deal' || $uristring=='lead/pipeline')  {?>
	<h3>Leads and Prospects</h3>
	<ul>
		<li>
			<a href="<?php echo site_url('lead/pipeline'); ?>">Pipeline</a>
		</li>
		<li>
			<a href="<?php echo site_url('lead/contact'); ?>">Contacts</a>
		</li>
		<li>
			<a href="<?php echo site_url('lead/business'); ?>">Business</a>
		</li>
		<li>
			<a href="<?php echo site_url('lead/deal'); ?>">Deals</a>
		</li>
		<li>
			<a href="#">Pipeline Report</a>
		</li>
	</ul>
	<?php }?>

	<?php if($uristring=='user_category/User/addcategory' || $uristring=='user_category/User' || $uristring=='user_category/User/viewcategory' || $uristring=='user_category/User/editcategory'){ ?>
	<h3>User Manager</h3>
	<ul>
		<li>
			<a href="<?php echo site_url('user_category/User/addcategory'); ?>">Add Categroy</a>
		</li>
		<li>
			<a href="<?php echo site_url('user_category/User'); ?>">User Categroy</a>
		</li>
	</ul>
	<?php }?>

	<?php if($uristring=='ticket/ticket' || $uristring=='ticket/addticket' || $uristring=='ticket/viewticket' || $uristring=='ticket/editticket' || $uristring=='ticket/category' || $uristring=='ticket/viewcategory' || $uristring=='ticket/editcategory'){?>
	<h3>Compliance & Tickets</h3>
	<ul>
		<li>
			<a href="<?php echo site_url('ticket/category');?>">Category Manager</a>
		</li>
		<li>
			<a href="#">Whistle Blowers</a>
		</li>
		<li>
			<a href="#">WhistleBlower Report</a>
		</li>
		<li>
			<a href="#">Pipeline Report</a>
		</li>
	</ul>
	<?php } ?>


	<?php if($uristring=='template-manager/email_manager' || $uristring=='template-manager/doc_manager'){?>		
	<h3>Templates</h3>
	<ul>
		<li>
			<a href="<?php echo site_url('template-manager/doc_manager');?>">Document Template</a>
		</li>
		<li>
			<a href="<?php echo site_url('template-manager/email_manager');?>">Email Template</a>
		</li>
	</ul>
	<?php } ?>
</div>