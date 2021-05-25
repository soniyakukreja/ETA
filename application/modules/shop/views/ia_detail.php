<?php $this->load->view('include/header'); ?>
	<article>
		<content>
			<main>
				<div class="dashSection">
					<div class="dashCard">
						<div class="dashNav">
							<?php $this->load->view('include/nav'); ?>
						</div>
						<div class="dashBody">
							<div class="innerDiv">
							
							<?php $this->load->view('shop/shop_leftbar'); ?>
								<div class="filterBody">
									<div class="filterDiv">
										
										
<div class="row">
    <div class="col-md-12 ">
<div class="panel panel-default">
  <div class="panel-heading">  
  	<h4 >Industry Association Detail </h4> </div>
   <div class="panel-body">
    <div class="box box-info">
            <div class="box-body">
            <div id="viewDiv">
            <div class="col-sm-3">
                     <div  align="center"> 
                     	<?php if($ia_detail['ia_profilepicture']){ ?>
							<img src="<?php echo base_url() ?>uploads/ia_profile/<?php echo $ia_detail['ia_profilepicture']; ?>" id="profile-image1" class="img-responsive">
						<?php }else{ ?>
							<img src="<?php echo base_url() ?>assets/img/avtr.png" id="profile-image1" class="img-responsive">
						<?php } ?>
                     </div>
            </div>
            <div class="col-sm-9">
				<div class="col-sm-5 col-xs-6 tital " >Resource ID:</div><div class="col-sm-7 col-xs-6 "><?php echo $ia_detail['ia_resource_id']; ?></div>
				     <div class="clearfix"></div>
				<div class="bot-border"></div>

				<div class="col-sm-5 col-xs-6 tital " >Name:</div><div class="col-sm-7"> <?php echo $ia_detail['username']; ?></div>
				  <div class="clearfix"></div>
				<div class="bot-border"></div>

				<div class="col-sm-5 col-xs-6 tital " >Email Address:</div><div class="col-sm-7"><?php echo $ia_detail['email']; ?></div>

				  <div class="clearfix"></div>
				<div class="bot-border"></div>

				<div class="col-sm-5 col-xs-6 tital " >Contact Number:</div><div class="col-sm-7"><?php echo $ia_detail['contactno']; ?></div>

				  <div class="clearfix"></div>
				<div class="bot-border"></div>
            </div>
        </div>

          </div>
          <!-- /.box -->

        </div>
    </div> 
    </div>
</div>  
   </div>
										
										
										
									</div>
									<?php $this->load->view('include/rightsidebar'); ?>
									
								</div>
								
							</div>
						</div>
					</div>
				</div>
			</main>
		</content>
	</article>
<?php $this->load->view('include/crop_image_modal'); ?>
<?php $this->load->view('include/footer'); ?>
<?php $this->load->view('include/shop_js'); ?>
</div>
</body>
</html>