<ul>
<?php if (isset($stages)) {
		foreach ($stages as $value) { 
			
			if($value['last_stage']==0){
				
			?>
	<li>
		<h3><?php echo $value['pstage_name']; ?><?php if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) { ?><a href="javascript:;" class='changename' stage-nm="<?php echo $value['pstage_id']; ?>"><span class="glyphicon glyphicon-pencil" style="float: right"></span></a><?php }?><span class="glyphicon glyphicon-menu-right"></span></h3>
<?php if ($data) {
			foreach ($data as $row) { 
			if($value['pstage_id']==$row['pstage_id']){
					$createdate= strtotime($row['stagemodifydate']);
					$today = strtotime(date('Y-m-d H:i:s'));
					$age= ceil((($today-$createdate)/3600)/24);
				 ?>
				<div class="pipeBox">
					
					<h4><a href="<?php echo site_url('lead/deal/dealdetail/').encoding($row['deal_id']); ?>" target="_blank"><?php echo $row['deal_title']; ?></a></h4>
					<p>Business-<a href="<?php echo site_url('lead/business/viewbusiness_detail/').encoding($row['business_id']); ?>" target="_blank"><?php echo $row['business_name']; ?></a><br><p>Contact-<a href="<?php echo site_url('lead/contact/contactdetail/').encoding($row['contact_id']); ?>" target="_blank"><?php echo $row['contact_person']; ?></a> <br> Expected Close- <b><?php echo date('m/d/Y',strtotime($row['deal_exp_closedate'])); ?></b> <br> Deal Age - <b><?php echo $age; ?> Day(s)</b> </p>
					<div class="footPipe">
						<a href="#ChangeStage" class="ChangeStage" data-id="<?php echo $row['deal_id']; ?>" data-stage="<?php echo $value['pstage_id']; ?>">Change Stage</a>
					</div>
				</div>
		<?php	} }
		}else{ ?> 
				<div class="pipeBox">There are no deals currently in this stage</div>
		<?php } ?>
		
	</li>
		
	<?php  }else{ ?>
	<li>
		<h3><?php echo $value['pstage_name']; ?><?php if ($this->userdata['dept_id']==1) { ?><a href="javascript:;" class='changename' stage-nm="<?php echo $value['pstage_id']; ?>"><span class="glyphicon glyphicon-pencil" style="float: right"></span></a><?php } ?><span class="glyphicon glyphicon-menu-right"></span></h3>
<?php if ($data) {
			foreach ($data as $row) { 
				if($value['pstage_id']==$row['pstage_id']){ 
					$createdate= strtotime($row['stagemodifydate']);
					$today = strtotime(date('Y-m-d H:i:s'));
					$age= ceil((($today-$createdate)/3600)/24);
				 ?>
				<div class="pipeBox">
					
					<h4><a href="<?php echo site_url('lead/deal/dealdetail/').encoding($row['deal_id']); ?>" target="_blank"><?php echo $row['deal_title']; ?></a></h4>
					<p>Business-<a href="<?php echo site_url('lead/business/viewbusiness_detail/').encoding($row['business_id']); ?>" target="_blank"><?php echo $row['business_name']; ?></a><br><p>Contact-<a href="<?php echo site_url('lead/contact/contactdetail/').encoding($row['contact_id']); ?>" target="_blank"><?php echo $row['contact_person']; ?></a> <br> Expected Close- <b><?php echo date('m/d/Y',strtotime($row['deal_exp_closedate'])); ?></b> <br> Deal Age - <b><?php echo $age; ?> Day(s)</b> </p>
					<div class="footPipe">

						<?php 
						$urole = $this->userdata['urole_id'];
						 if($this->userdata['dept_id']==2 || $this->userdata['dept_id']==10 && $row['user_id']==0){ ?>
						<a href="javascript:void(0);" class="ChangeStage" data-id="<?php echo $row['deal_id']; ?>" data-stage="<?php echo $value['pstage_id']; ?>">Change Stage</a>
						<?php if($urole==1 && $row['user_id']==0){ ?>
						<a href="<?php echo site_url('licensee/addlicensee/').encoding($row['deal_id']); ?>" >Convert to Account</a>
						<?php }elseif($urole==2 && $row['user_id']==0){ ?>
						<a href="<?php echo site_url('industryassociation/addia/').encoding($row['deal_id']); ?>" >Convert to Account</a>
						<?php }elseif($urole==3 && $row['user_id']==0){ ?>
						<a href="<?php echo site_url('consumer/addnew/').encoding($row['deal_id']); ?>" >Convert to Account</a>
						<?php } ?>
					<?php	} ?>
					</div>
				</div>
		<?php	} }
		}else{ ?> 
				<div class="pipeBox">There are no deals currently in this stage</div>
		<?php } ?>
		
	</li>
<?php 	}	} 
} ?>
</ul>