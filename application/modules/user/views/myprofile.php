<?php 
	$this->load->view('include/header'); 
	//echo "<pre>"; print_r($data); exit;
	$userdata = $this->session->userdata('userdata');
	$dept = $userdata['dept_id'];
	$role = $userdata['urole_id'];
	$show_business = false;
	if($role==4||$role==5){
		$show_business = true;
	}elseif(($role==2 || $role==3) && ($dept==2)){ 
		$show_business = true;
	}
?>
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
							
							<?php 

							//echo $dept;exit;
							// if($userdata['urole_id']==4){ 
							// 	$this->load->view('shop/shop_leftbar');
							// }else{
							 $this->load->view('include/leftsidebar'); 
							// }  
							?>

								<div class="filterBody">
									<?php $dep= $this->generalmodel->getSingleRowById('department','dept_id', $data['dept_id'], $returnType = 'array'); 
									  $Country= $this->generalmodel->getSingleRowById('country','id', $data['country'], $returnType = 'array');
								 ?>
									<div class="filterDiv">
										
										
<div class="row">
    <div class="col-md-12 ">
<div class="panel panel-default">
  <div class="panel-heading">  
  	<h4 >My Profile  
  		<a href="javascript:void(0)" style="float: right;" onclick="editProfile()" id="editanchor">
  		<span class="glyphicon glyphicon-pencil"></span> Edit</a>
  		<a href="javascript:void(0)" style="float: right;display:none;" onclick="viewProfile()"  id="viewanchor">View</a>
  	</h4> </div>
   <div class="panel-body">
    <div class="box box-info">
            <div class="box-body">
            <div id="viewDiv">
                     <div class="col-sm-3">
                     <div  align="center"> 
                     	<?php if($data['profilepicture']){ ?>
							<img src="<?php echo base_url() ?>uploads/user/<?php echo $data['profilepicture']; ?>" id="profile-image1" class="img-responsive">
						<?php }else{ ?>
							<img src="<?php echo base_url() ?>assets/img/avtr.png" id="profile-image1" class="img-responsive">
						<?php } ?>
                     </div>
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

				<div class="col-sm-5 col-xs-6 tital " >Contact Number:</div><div class="col-sm-7"><?php echo $data['contactno']; ?></div>

				  <div class="clearfix"></div>
				<div class="bot-border"></div>

				<div class="col-sm-5 col-xs-6 tital " >Country:</div><div class="col-sm-7"><?php echo $Country['country_name']; ?></div>
				 <div class="clearfix"></div>
				<div class="bot-border"></div>		

				<?php if($show_business){ ?>
				<div class="col-sm-5 col-xs-6 tital " >Business:</div><div class="col-sm-7"><?php echo $data['business_name']; ?></div>
				<div class="clearfix"></div>
				<div class="bot-border"></div>
				<?php } ?>

<?php if($userdata['urole_id']!='4' && $userdata['urole_id']!='5'){  ?>
<div class="col-sm-5 col-xs-6 tital " >Department:</div><div class="col-sm-7"><?php echo $dep['deptname']; ?></div>

 <div class="clearfix"></div>
<div class="bot-border"></div>
<?php } ?>
<br>
<a href="javascript:void(0)" class="downldBtn" id="changePassbtn">Change Password</a>

            </div>
        </div>


        <div id="editDiv" style="display:none;">
            	<div id="errorMsg" class="alert alert-danger hide"></div>
				<div id="successMsg" class="alert alert-success hide"></div>

				<?php echo form_open('user/Myprofile/updateprofile',array('class'=>'addForm','id'=>'update_myprofile','autocomplete'=>'off')); ?>
					

					<div class="row">
						<div class="col-md-6">
							<img src="<?php if(!empty($data['profilepicture'])){ echo base_url('uploads/user/').$data['profilepicture']; }else{ echo base_url('assets/img/avtr.png'); } ?>" class="img" style="width: 200px; height: 200px;">
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Profile Picture</label>
								<div class="input-group"><span class="input-group-addon">
									<i class="glyphicon glyphicon-file"></i></span>
									<input name="profilepicture" id="profilepicture" class="form-control imgInput" type="file" accept=".jpeg, .jpg, .PNG, .png" is_valid="1">
									<input type="hidden" name="profilepicture_h" id="profilepicture_h" class="hiddenfile" preview="true" path=""> 
								<i class="fa fa-times-circle removeFile" aria-hidden="true"></i>
								</div>
								<small style="font-weight:bold;">Only Supported Files are JPG, JPEG, PNG</small>
								<br><span id="" class="invalidText image_err"></span>
							</div>
						

							<?php if($show_business){ ?>
							<div class="form-group required">
								<label>Business Name</label>
								<div class="input-group"><span class="input-group-addon">
									<i class="glyphicon glyphicon-user"></i></span>
									<input readonly  class="form-control" placeholder="Business Name" value="<?php echo $data['business_name']; ?>" type="text">
								</div>
								<span id="lastname_err" class="invalidText"></span>
							</div>
							<?php } ?>
						</div>
						
					</div>
					<br>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group required">
								<label>First Name <span></span></label>
								<div class="input-group"><span class="input-group-addon">
									<i class="glyphicon glyphicon-user"></i></span>
									<input readonly name="firstname" id="firstname" class="form-control" placeholder="First Name" value="<?php echo $data['firstname']; ?>" type="text">
								</div>
								<span id="firstname_err" class="invalidText"></span>
							</div>	
						</div>
						<div class="col-md-6">
							<div class="form-group required">
								<label>Last Name</label>
								<div class="input-group"><span class="input-group-addon">
									<i class="glyphicon glyphicon-user"></i></span>
									<input readonly name="lastname" id="lastname" class="form-control" placeholder="Last Name" value="<?php echo $data['lastname']; ?>" type="text">
								</div>
								<span id="lastname_err" class="invalidText"></span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group required">
								<label>Email Address</label>
								<div class="input-group"><span class="input-group-addon">
									<i class="glyphicon glyphicon-envelope"></i></span>
									<input readonly name="email" id="email" class="form-control"  value="<?php echo $data['email']; ?>" type="email" placeholder="Email Address">
								</div>
								<span id="email_err" class="invalidText"></span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Contact Number</label>
								<div class="inputGroup">
									<input type="text" placeholder="Contact number" name="phone" id="phone" autocomplete="off" onkeypress="return isNumberKey(event)" class="form-control" value="<?php echo trim($data['contactno']); ?>">
								    <button type="button" class="hide" id="sa-warning" class="btn btn-primary" data-toggle="modal" data-target="#login_for_review">test1</button>
								    <span id="valid-msg" class="hide" style="color:#67cc19">✓ Valid</span>
									<span id="error-msg" class="hide" style="color:#ea0909"></span>
								    <div id="phone_codes"></div>
								    <div id="error_four" style="margin-top: 8px;"></div>
								</div>
								<span id="contactno_err" class="invalidText"></span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group required">
								<label>Country</label>
								<div class="dateInput"><span class="input-group-addon"><i class="glyphicon glyphicon-road"></i></span>
									<select disabled="" class="form-control js-example-basic-single" name="country" id="country">
									  <option value="">Please Select</option>
									  <?php if(!empty($countrylist)){  foreach($countrylist as $value){ ?>
										<option value="<?php echo $value['id']; ?>" <?php if($value['id']==$data['country']){echo "selected";} ?>><?php echo $value['country_name']; ?></option>
									  <?php } } ?>
									</select>
								</div>
								<span id="country_err" class="invalidText"></span>
							</div>
						</div>
						<?php if($userdata['urole_id']!='4' && $userdata['urole_id']!='5'){  ?>
					
						<div class="col-md-6">
							<div class="form-group required">
								<label>Department</label>
								<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span>
									
									<select class="form-control js-example-basic-single" disabled="" id="dept" >
										<option value="">Please Select</option>
										<?php if(!empty($deptlist)){  foreach($deptlist as $value){ ?>
										<option value="<?php echo $value['dept_id']; ?>" <?php if($value['dept_id']==$data['dept_id']){echo "selected";} ?>><?php echo $value['deptname']; ?></option>
									  	<?php } } ?>
									</select>
								</div>
								<span id="dept_err" class="invalidText"></span>
							</div>
						</div>
						<?php } ?>
					</div>
					<div class="row">
						<button type="submit">Submit</button>
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
            <?php $this->load->view('user/password_form'); ?>



<?php if($userdata['urole_id']==4){ ?>
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
                     	<?php if($ia_detail['userprofile']){ ?>
							<img src="<?php echo base_url() ?>uploads/user/<?php echo $ia_detail['userprofile']; ?>" id="profile-image1" class="img-responsive">
						<?php }else{ ?>
							<img src="<?php echo base_url() ?>assets/img/avtr.png" id="profile-image1" class="img-responsive">
						<?php } ?>
                     </div>
            </div>
            <div class="col-sm-9">
				<div class="col-sm-5 col-xs-6 tital " >Resource ID:</div><div class="col-sm-7 col-xs-6 "><?php echo $ia_detail['ia_resource_id']; ?></div>
				     <div class="clearfix"></div>
				<div class="bot-border"></div>

				<div class="col-sm-5 col-xs-6 tital " >Business:</div><div class="col-sm-7 col-xs-6 "><?php echo $ia_detail['business_name']; ?></div>
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
   <?php } ?>            
										
										
										
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
<?php //$this->load->view('include/leftsidebar_js'); ?>

<script>
function editProfile(){
	$('#viewDiv').css('display','none');
	$('#editDiv').css('display','block');
	$('#editanchor').css('display','none');
	$('#viewanchor').css('display','block');
}
function viewProfile(){
	$('#viewDiv').css('display','block');
	$('#editDiv').css('display','none');
	$('#editanchor').css('display','block');
	$('#viewanchor').css('display','none');	
}


$(document).on('submit','#update_myprofile',function(e){
	e.preventDefault();
	var allIsOk = true;
    var contactno = $('#phone').val();
	var password = $('#password').val();
	var cpassword = $('#cpassword').val();

	if(contactno!='' && !validateMobile(contactno)){
    	$("#phone").focus();
		$("#contactno_err").show().html('Please Enter Contact Number');
        allIsOk = false;    	
    }    

	if(password != '' && !validate_pass($('#password'))){
    	$("#password").focus();
    	$("#p_err").show().html("Password don't match");
    	allIsOk = false;  
    }
    if(cpassword != '' && !validate_pass($('#cpassword'))){
    	$("#cpassword").focus();
    	$("#cp_err").show().html("Password don't match");
    	allIsOk = false;  
    }
    if(password !==cpassword){
		$("#cpassword").focus();
		$("#p_err").show().html("Password don't match");
        allIsOk = false;    	
    }

	$( ".imgInput" ).each(function(i,v) {
	  if($(this).attr('is_valid')==0){
	  	$(this).parents('.form-group').find('.image_err').css('display','block');
	  	allIsOk = false;  
	  }
	});    
    if(allIsOk){
    	ds = $(this);
		var url = $(this).attr('action');
		var formData = $("form").serialize();
		$.ajax({
			'async': false,
			url: url,
			type: "POST",
			data:formData,
    		dataType: "json",
			beforeSend:function(){
				ajaxindicatorstart();
			},
			success: function(res) {
				ajaxindicatorstop();
				if(res.success) {
					$('#pass_err, #cpassword_err').css('display','none');

					$('#errorMsg').addClass('hide').removeClass('show');
					$('#successMsg').addClass('show').removeClass('hide').html('Profile details updated!').fadeOut('slow');
					
					setTimeout( function(){ 
						$('#errorMsg , #successMsg').addClass('hide').removeClass('show').fadeOut('slow');
						window.location.reload();
					 }  , 3000 );						
				}else{
					$('#errorMsg').addClass('show').removeClass('hide').html(res.msg);
					$('#successMsg').addClass('hide').removeClass('show');
					allIsOk = false;
				}
				$('html, body').animate({
				    scrollTop: $(".dashBody").offset().top
				}, 1000); 
			}
		});
    }
    return allIsOk    

});
</script>
</div>
</body>
</html>