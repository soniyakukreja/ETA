<div class="bannerDiv">
	<?php $userdata = $this->session->userdata('userdata');
	$bar = $this->generalmodel->getJoinData('m.ba_id,m.ba_image,m.ba_link,m.ba_target','banner_ads as m','user as b','m.ba_createdby = b.user_id',array('m.ba_roles_id'=>$userdata['urole_id'],'m.ba_bannertype'=>'Right','m.ba_status'=>1),'m.ba_id','desc','result_array');
				
				if($bar)
				{ ?>
				<a href="<?php echo $bar[0]['ba_link']; ?>" <?php if($bar[0]['ba_target']){echo "target= ".$bar[0]['ba_target'];} ?>>
				<img src="<?php echo base_url() ?>uploads/banner/<?php echo $bar[0]['ba_image']; ?>" alt="Ads" /></a>

			<?php	} ?>
				<!-- <img src="<?php echo base_url();?>assets/img/right_banner.jpeg" alt="Ads" /> -->

			
</div>