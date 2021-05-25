<?php $this->load->view('include/header.php'); ?>
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
							
							<?php $this->load->view('shop/shop_leftbar'); ?>
								<div class="filterBody">
									<?php $dep= $this->generalmodel->getSingleRowById('department','dept_id', $data['dept_id'], $returnType = 'array'); 
									  $Country= $this->generalmodel->getSingleRowById('country','id', $data['country'], $returnType = 'array');
								 ?>
									<div class="filterDiv">
										
										<div class="row">
		
       <div class="col-md-12 ">

<div class="panel panel-default">
  <div class="panel-heading">  <h4 >View Staff:  <a href="<?php echo site_url() ?>staff/editstaff/<?php echo $data['user_id']; ?>" style="float: right;"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
<a href="javascript:window.history.go(-1);" style="float: right; margin-right: 35px;">Back</a>
  </h4> </div>
   <div class="panel-body">
       
    <div class="box box-info">
        
            <div class="box-body">
                     <div class="col-sm-3">
                     <div  align="center"> <?php if($data['profilepicture']){ ?>
												<img src="<?php echo base_url() ?>uploads/user/<?php echo $data['profilepicture']; ?>" id="profile-image1" class="img-responsive">
											<?php }else{ ?>
												<img src="<?php echo base_url() ?>assets/img/avtr.png" id="profile-image1" class="img-responsive">
											<?php } ?>
														<!-- <img alt="User Pic" src="https://x1.xingassets.com/assets/frontend_minified/img/users/nobody_m.original.jpg" id="profile-image1" class="img-responsive"> --> 
                
                <input id="profile-image-upload" class="hidden" type="file">
<div style="color:#999;" >click here to change profile image</div>
<hr>
   <h5 style="color:#00b1b1;"><?php echo $data['firstname'].' '.$data['lastname']; ?></h5>
                
                     </div>
              
              <!-- /input-group -->
            </div>
            <div class="col-sm-9">
         
<div class="col-sm-5 col-xs-6 tital " >First Name:</div><div class="col-sm-7 col-xs-6 "><?php echo $data['firstname']; ?></div>
     <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital " >Last Name:</div><div class="col-sm-7"> <?php echo $data['lastname']; ?></div>
  <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital " >Email Address:</div><div class="col-sm-7"><?php echo $data['email']; ?></div>

  <div class="clearfix"></div>
<div class="bot-border"></div>

<!-- <div class="col-sm-5 col-xs-6 tital " >Password:</div><div class="col-sm-7"><?php echo $data['contactno']; ?></div> -->

 <!--  <div class="clearfix"></div>
<div class="bot-border"></div> -->

<div class="col-sm-5 col-xs-6 tital " >Contact Number:</div><div class="col-sm-7"><?php echo $data['contactno']; ?></div>

  <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital " >Country:</div><div class="col-sm-7"><?php echo $Country['country_name']; ?></div>

 <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital " >Department:</div><div class="col-sm-7"><?php echo $dep['deptname']; ?></div>

 <div class="clearfix"></div>
<div class="bot-border"></div>


			  
            </div>
            <div class="clearfix"></div>
            <hr style="margin:5px 0 5px 0;">
    
              



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
<?php $this->load->view('include/footer.php'); ?>
</div>
</body>
</html>