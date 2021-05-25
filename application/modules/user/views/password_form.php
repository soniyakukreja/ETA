
<div class="row" id="changePassDiv"  style="display:none;">
	<div class="col-md-12 ">
	<div class="panel panel-default">
		<div class="panel-heading">  
			<h4>Change Password:</h4> 
		</div>
	<div class="panel-body">
    	<div class="box box-info">
            <div class="box-body">
            
        <div>
            	<div id="error_msg" class="alert alert-danger hide"></div>
				<div id="success_msg" class="alert alert-success hide"></div>

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
<script type="text/javascript" src="<?php echo base_url('includes/js/myprofile.js'); ?>"></script>
