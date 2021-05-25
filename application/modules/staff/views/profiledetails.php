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
							
							<?php $this->load->view('include/leftsidebar'); ?>
								<div class="filterBody">
									<?php $dep= $this->generalmodel->getSingleRowById('department','dept_id', $data['dept_id'], $returnType = 'array'); 
									  $Country= $this->generalmodel->getSingleRowById('country','id', $data['country'], $returnType = 'array');
								 ?>
									<div class="filterDiv">
										
<div class="row">
		
	<div class="col-md-12 ">

<div class="panel panel-default">
  <div class="panel-heading">  <h4 >My Profile:  
  <!-- edit for user  -->
  	 <a href="<?php echo site_url('staff/editstaff/').encoding($data['user_id']); ?>" style="float: right;"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
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
                
<input id="profilepicture" name="profilepicture" class="hidden imgInput" type="file">
<input id="profilepicture_h" type="hidden" name="profilepicture_h">
<!-- <div style="color:#999;" ><a href="#" id="profilePicBtn"> click here to change profile image </a></div> -->
   <!-- <h5 style="color:#00b1b1;"><?php echo $data['firstname'].' '.$data['lastname']; ?></h5> -->
<!-- <hr> -->
                
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

<br>
<a href="javascript:void(0)" class="downldBtn" id="changePassbtn">Change Password</a>
			  
            </div>
            <div class="clearfix"></div>
			<!-- /.box-body -->
			</div>
			<!-- /.box -->

			</div>
			</div> 
		</div>
	</div>  
</div>

<div class="row" id="changePassDiv"  style="display:none;">
	<div class="col-md-12 ">
	<div class="panel panel-default">
		<div class="panel-heading">  
			<h4>Change Password:</h4> 
		</div>
	<div class="panel-body">
    	<div class="box box-info">
            <div class="box-body">
            
        <div id="editDiv">
            	<div id="errorMsg" class="alert alert-danger hide"></div>
				<div id="successMsg" class="alert alert-success hide"></div>

<?php echo form_open('update-my-password',array('class'=>'addForm','id'=>'update_myPass','autocomplete'=>'off')); ?>
			<div class="row">
				<div class="col-md-7">
					<div class="form-group required">
						<label>Old Password </label>
						<div class="input-group"><span class="input-group-addon">
							<i class="glyphicon glyphicon-lock"></i></span>
							<input name="old_password" id="old_password" class="form-control no-paste" placeholder="Old Password" value="" type="password" onpaste="return false;" onkeyup="return validate_pass(this)" >
							<span toggle="#old_password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
						</div>
						<span id="old_p_err" class="invalidText"  style="display:none"></span>
					</div>	
				</div>
			</div>
			<div class="row">
				<div class="col-md-7">
					<div class="form-group required">
						<label>New Password </label>
						<div class="input-group"><span class="input-group-addon"  
title="Minimum 8 characters in length
Contains 3/4 of the following items:
- Uppercase Letters
- Lowercase Letters
- Numbers
- Symbols">
							<i class="glyphicon glyphicon-lock"></i></span>
							<input name="password" id="password" class="form-control no-paste" placeholder="New Password" value="" type="password" onpaste="return false;" onkeyup="return validate_pass(this)" >
							<span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
						</div>
						<span id="p_err" class="invalidText"  style="display:none"></span>
						<div class="strongWeak" id="pass_err" style="display:none;">
							<div class="w3-border">
								<div class="stren_line" style="height:5px;width:20%;background: red;"></div>
							</div>
							<span class="stren_text">Weak</span>
						</div>
					</div>	
				</div>
			</div>
			<div class="row">
				<div class="col-md-7">
					<div class="form-group required">
						<label>Confirm Password</label>
						<div class="input-group"><span class="input-group-addon"
title="Minimum 8 characters in length
Contains 3/4 of the following items:
- Uppercase Letters
- Lowercase Letters
- Numbers
- Symbols">
							<i class="glyphicon glyphicon-lock"></i></span>
							<input  name="cpassword" id="cpassword" class="form-control" placeholder="Confirm Password" value="" type="password" onpaste="return false;" onkeyup="return validate_pass(this)">
							<span toggle="#cpassword" class="fa fa-fw fa-eye field-icon toggle-password" ></span>
						</div>
						<span id="cp_err" class="invalidText" style="display:none"></span>
					</div>
				</div>
			</div>
			<div class="row">
				<button type="submit">Save</button>
				<button type="button" id="cancelPassChange">Cancel</button>
			</div>
			<?php echo form_close(); ?>
            <div class="clearfix"></div>
            <!-- /.box-body -->
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
	<input type="hidden" id="uploadtype" value="" >
<input type="hidden" id="directmove" value="user" table="user" field="profilepicture" data-id="<?php echo $data['user_id']; ?>" name-id="user_id" >
<?php $this->load->view('include/crop_image_modal'); ?>
<?php $this->load->view('include/footer.php'); ?>
<script type="text/javascript" src="<?php echo base_url('includes/js/myprofile.js'); ?>"></script>
</div>
</body>
</html>