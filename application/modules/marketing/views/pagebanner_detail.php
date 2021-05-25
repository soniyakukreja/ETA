<?php $this->load->view('include/header.php'); $this->userdata = $this->session->userdata('userdata');
	$arr=array(); $arr=$this->session->userdata('userdata');
    $perms=explode(",",$arr['upermission']);?>


	<article>
		<content>
			<main>
				<div class="dashSection">
					<div class="dashCard">
						<div class="dashNav">
							<?php $this->load->view('include/nav.php'); ?>
						</div>
						<div class="dashBody">
							<div class="innerDiv">
							<?php $this->load->view('include/leftsidebar.php'); ?>
								
								<?php $role=$this->generalmodel->getSingleRowById('user_role', 'urole_id', $pa['pb_role_id'], $returnType = 'array');
								?>

								<div class="filterBody">
									<div class="filterDiv">
										
									
									<div class="row">
		
       <div class="col-md-12 ">

<div class="panel panel-default">
  <div class="panel-heading">  <h4 >Page Manager  
  <!-- edit for user  -->
  	 <?php if(in_array('PG_E',$perms)) {?><a href="<?php echo site_url() ?>marketing/editpage_banner/<?php echo $pa['pb_id']; ?>" style="float: right;"><span class="glyphicon glyphicon-pencil"></span> Edit</a><?php }?>
  	 <a href="javascript:window.history.go(-1);" style="float: right; margin-right: 35px;">Back</a>
                                                                    </h4> </div>
   <div class="panel-body">
       
    <div class="box box-info">
        
            <div class="box-body">
                     <div class="col-sm-3">
                     <div  align="center"> <?php if($pa['pb_featureimage']){ ?>
												<img src="<?php echo base_url() ?>uploads/page_feature_img/<?php echo $pa['pb_featureimage']; ?>" id="profile-image1" class="img-responsive">
											<?php }else{ ?>
												<img src="<?php echo base_url() ?>assets/img/avtr.png" id="profile-image1" class="img-responsive">
											<?php } ?>
														<!-- <img alt="User Pic" src="https://x1.xingassets.com/assets/frontend_minified/img/users/nobody_m.original.jpg" id="profile-image1" class="img-responsive"> --> 
                
<input id="profilepicture" name="profilepicture" class="hidden imgInput" type="file">
<input id="profilepicture_h" type="hidden" name="profilepicture_h">
<div style="color:#999;" ><a href="#" id="profilePicBtn"> click here to change profile image </a></div>
  <h5 style="color:#00b1b1;"><?php echo $pa['pb_name']; ?></h5>
<hr>
                
                     </div>
              
              <!-- /input-group -->
            </div>
            <div class="col-sm-9">
         
<div class="col-sm-5 col-xs-6 tital " >Page Name:</div><div class="col-sm-7 col-xs-6 "><?php echo $pa['pb_name']; ?></div>
     <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital " >Slug:</div><div class="col-sm-7"> <?php echo $pa['pb_slug']; ?></div>
  <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital " >Intended for:</div><div class="col-sm-7"><?php echo $role['rolename']; ?></div>

  <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital " >Description:</div><div class="col-sm-7"><?php echo $pa['pb_description']; ?></div> 
  <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital " >Status:</div><div class="col-sm-7"><?php if($pa['pb_status']==0){ echo 'Draft';}else{echo 'Published';} ?></div>

  <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital " >CTA Label:</div><div class="col-sm-7"><?php echo $pa['pb_cta_label']; ?></div>

 <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital " >CTA Link:</div><div class="col-sm-7"><?php echo $pa['pb_cta_text']; ?></div>

 <div class="clearfix"></div>
<div class="bot-border"></div>


			  
            </div>
            <div class="clearfix"></div>
            <!-- <hr style="margin:5px 0 5px 0;"> -->
    
              



            <!-- /.box-body -->
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
	<input type="hidden" id="uploadtype" value="" >
	<input type="hidden" id="directmove" value="page_feature_img" table="pagebanner" field="pb_featureimage" data-id="<?php echo $pa['pb_id']; ?>" name-id="pb_id" >
	<?php $this->load->view('include/crop_image_modal'); ?>	
<?php $this->load->view('include/footer.php'); ?>
</div>
</body>
</html>