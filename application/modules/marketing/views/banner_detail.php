<?php $this->load->view('include/header.php'); $this->userdata = $this->session->userdata('userdata');
	$arr=array(); $arr=$this->session->userdata('userdata');
    $perms=explode(",",$arr['upermission']);?>


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
								<?php $this->load->view('include/leftsidebar.php'); ?>

								<div class="filterBody">
									<div class="filterDiv">
										
										<div id="errorMsg" class="alert alert-danger hide">
                                          <strong>Warning!</strong>
                                        </div>
                                        <div id="successMsg" class="alert alert-success hide">
                                          <strong>Success!</strong>
                                        </div>
                                       

										<div class="row">
		
       <div class="col-md-12 ">

<div class="panel panel-default">
  <div class="panel-heading">  <h4 >Banner  
  <!-- edit for user  -->
  	 <?php if(in_array('BN_E', $perms)) {?><a href="<?php echo site_url('marketing/editbanner/').encoding($ba['ba_id']); ?>" style="float: right;"><span class="glyphicon glyphicon-pencil"></span> Edit</a> <?php }?>
  	 <a href="javascript:window.history.go(-1);" style="float: right; margin-right: 35px;">Back</a>
                                                                    </h4> </div>
   <div class="panel-body">
       
    <div class="box box-info">
        
            <div class="box-body">
                     <div class="col-sm-3">
                     <div  align="center"> <?php if($ba['ba_image']){ ?>
												<img src="<?php echo base_url() ?>uploads/banner/<?php echo $ba['ba_image']; ?>" id="profile-image1" class="img-responsive">
											<?php }else{ ?>
												<img src="<?php echo base_url() ?>assets/img/avtr.png" id="profile-image1" class="img-responsive">
											<?php } ?>
														
 <?php /*               
<input id="profilepicture" name="profilepicture" class="hidden imgInput" type="file">
<input id="profilepicture_h" type="hidden" name="profilepicture_h">

<div style="color:#999;" ><a href="#" id="profilePicBtn"> click here to change profile image </a></div>
  <h5 style="color:#00b1b1;"><?php echo $ba['ba_name']; ?></h5> 
  */ ?>
 <hr> 
                
                     </div>
              
              <!-- /input-group -->
            </div>
            <div class="col-sm-9">
         
<div class="col-sm-5 col-xs-6 tital " >Banner Name:</div><div class="col-sm-7 col-xs-6 "><?php echo $ba['ba_name']; ?></div>
     <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital " >Intended User:</div><div class="col-sm-7"> <?php echo $ba['rolename']; ?></div>
  <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital " >Link:</div><div class="col-sm-7"><?php echo $ba['ba_link']; ?></div>

  <div class="clearfix"></div>
<div class="bot-border"></div>

<!-- <div class="col-sm-5 col-xs-6 tital " >Password:</div><div class="col-sm-7"><?php echo $data['contactno']; ?></div> -->

 <!--  <div class="clearfix"></div>
<div class="bot-border"></div> -->

<div class="col-sm-5 col-xs-6 tital " >Status:</div><div class="col-sm-7"><?php if($ba['ba_status']==0){ echo 'Draft';}else{echo 'Published';} ?></div>

  <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital " >Publish Date:</div><div class="col-sm-7"><?php echo date('m-d-Y', strtotime($ba['ba_publish_date'])); ?></div>

 <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital " >Banner Type:</div><div class="col-sm-7"><?php echo $ba['ba_bannertype']; ?></div>

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
	<input type="hidden" id="directmove" value="banner" table="banner_ads" field="ba_image" data-id="<?php echo $ba['ba_id']; ?>" name-id="ba_id" >
	<?php $this->load->view('include/crop_image_modal'); ?>	
<?php $this->load->view('include/footer.php'); ?>
</div>
</body>
</html>