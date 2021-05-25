<?php $this->load->view('include/header.php');
$this->userdata = $this->session->userdata('userdata');
$perms=explode(",",$this->userdata['upermission']); ?>
<style>
	.panel-heading h5 {
		font-weight: bold;
	}
	.panel-body {
    
    padding: 15px 0px;
}
.addNew {
    position: unset;
}
</style>
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
								
								<?php $dep= $this->generalmodel->getSingleRowById('department','dept_id', $ia['dept_id'], $returnType = 'array'); 
									  $Country= $this->generalmodel->getSingleRowById('country','id', $ia['country'], $returnType = 'array');
									  $category= $this->generalmodel->getSingleRowById('user_category','user_cat_id', $ia['category'], $returnType = 'array');
								 ?>
								<div class="filterBody">
									<div class="filterDiv">
										<div id="errorMsg" class="alert alert-danger hide">
                      						<strong>Warning!</strong>
                    					</div>
                    					<div id="successMsg" class="alert alert-success hide">
                      						<strong>Success!</strong>
                    					</div>
										

<div class="row">
		
       <div class="col-xs-12 ">

<div class="panel panel-default">
  <div class="panel-heading">  <h5>Licensee Details
  	<?php if(in_array("LIC_E",$perms)) {?>
  	<a href="<?php echo site_url('licensee/editlicensee/').encoding($ia['user_id']); ?>" style="float: right;"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
  	<?php }?>
   <a href="javascript:window.history.go(-1);" style="float: right; margin-right: 35px;">Back</a>
  </h5> </div>
   <div class="panel-body">
       
    <div class="box box-info">
        
            <div class="box-body">
            	<div  class="col-sm-6">
                     <div class="col-sm-9" id="iaprofileDiv">
                     <div align="center"> 
                     	<?php if($ia['lic_profilepicture']){ ?>
							<img src="<?php echo base_url() ?>uploads/licensee_profile/<?php echo $ia['lic_profilepicture']; ?>" id="profile-image1" class="img-responsive"> 
						<?php }else{ ?>
							<img src="<?php echo base_url() ?>assets/img/avtr.png" id="profile-image1" class="img-responsive"> 
						<?php } ?>
														<!-- <img alt="User Pic" src="https://x1.xingassets.com/assets/frontend_minified/img/users/nobody_m.original.jpg" id="profile-image1" class="img-responsive"> 
                 -->
                <input id="lic_profilepicture" name="lic_profilepicture" class="hidden imgInput" type="file">
                <input id="lic_profilepicture_h" type="hidden" name="lic_profilepicture_h">
<!-- <div style="color:#999;"><a href="#" id="profilePicBtnlic"> click here to change profile image </a></div> -->
   <!-- <h5 style="color:#00b1b1;"><?php //echo $ia['lic_number']; ?></h5> -->
<hr>
                
                     </div>
              
              <!-- /input-group -->
            </div>
<div class="">
         


<div class="col-sm-5 col-xs-6 tital ">ID:</div><div class="col-sm-7"><?php echo $ia['resource_id']; ?></div>
 <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">License Number:</div><div class="col-sm-7"><?php echo $ia['lic_number']; ?></div>
 <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">License Date:</div><div class="col-sm-7">
	<?php 			$localtimzone =$this->userdata['timezone'];
        			$lic_startdate = gmdate_to_mydate($ia['lic_startdate'],$localtimzone);
        			$lic_enddate = gmdate_to_mydate($ia['lic_enddate'],$localtimzone);

	echo date('m-d-Y', strtotime($lic_startdate)).' - '.date('m-d-Y', strtotime($lic_enddate)); 
	?>
</div>
 <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Country:</div><div class="col-sm-7"><?php echo $Country['country_name']; ?></div>
 <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Category:</div><div class="col-sm-7"><?php echo $category['user_cat_name']; ?></div>
 <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Licensee File:</div>

<div class="col-sm-7">
<?php if(!empty($ia['license_file'])){ ?> 
	<a href="<?php echo base_url('uploads/licensee_file/').$ia['license_file']; ?>" class="downldBtn" target="_blank" download="">Download <span class="glyphicon glyphicon-download-alt"></span></a>
<?php }else{ echo 'File Not uploaded'; } ?>
</div>
 <div class="clearfix"></div>
<div class="bot-border"></div>

			  
            </div>
        </div>
            <div  class="col-sm-6">
            <div class="col-sm-9" id="profileDiv">
                     <div align="center"> 
                     	<?php if($ia['profilepicture']){ ?>
							<img src="<?php echo base_url() ?>uploads/cto_profile/<?php echo $ia['profilepicture']; ?>" id="profile-image1" class="img-responsive"> 
						<?php }else{ ?>
							<img src="<?php echo base_url() ?>assets/img/avtr.png" id="profile-image1" class="img-responsive"> 
						<?php } ?>
														<!-- <img alt="User Pic" src="https://x1.xingassets.com/assets/frontend_minified/img/users/nobody_m.original.jpg" id="profile-image1" class="img-responsive"> 
                 -->
                <input id="profilepicture" name="profilepicture" class="hidden imgInput" type="file">
                <input id="profilepicture_h" type="hidden" name="profilepicture_h">
<!-- <div style="color:#999;"><a href="#" id="profilePicBtnp"> click here to change profile image </a></div>-->
   <!-- <h5 style="color:#00b1b1;"><?php //echo $ia['firstname'].' '.$ia['lastname']; ?></h5> -->
<hr> 

                
                     </div>
              
              <!-- /input-group -->
            </div>
<div class="">
         


<div class="col-sm-5 col-xs-6 tital ">CTO Name:</div><div class="col-sm-7"><?php echo $ia['firstname'].' '.$ia['lastname']; ?></div>
 <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">CTO Email Address:</div><div class="col-sm-7"><?php echo $ia['email']; ?></div>
 <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">CTO Contact Number:</div><div class="col-sm-7"><?php echo $ia['contactno']; ?></div>
 <div class="clearfix"></div>
<div class="bot-border"></div>
<div class="col-sm-5 col-xs-6 tital ">Business Name:</div><div class="col-sm-7"><?php echo $ia['business_name']; ?></div>
 <div class="clearfix"></div>
<div class="bot-border"></div>

			  
            </div>
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



										<div class="noteDetail">
											<div class="panel panel-default">
												<div class="panel-heading"><span>Activity</span> <a href="#addNote" class="addNew" data-toggle="modal">Add Note</a></div>
												<div class="panel-body">
													<div class="detailTebler filterTable table-responsive">
														<table id="example">
															<thead>
																<tr>
																	<th>Title</th>
																	<th>User</th>
																	<!-- <th>Name</th> -->
																	<th>Description</th>
																	<th>Date</th>
																</tr>
															</thead>
															<tbody>
																
																<tr>
																	<td>Loading..</td>
																</tr>
															
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-6">
												
											</div>
										</div>

									</div>
									<?php $this->load->view('include/rightsidebar.php'); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</main>
		</content>
	</article>
	<input type="hidden" id="lic_id" value="<?php echo $ia['lic_id']; ?>">
	<input type="hidden" id="uploadtype" value="" >
	<input type="hidden" id="directmove" value="cto_profile" table="user" field="profilepicture" data-id="<?php echo $ia['user_id']; ?>" name-id="user_id" style="display: block;">
	<input type="hidden" id="directmoveli" value="licensee_profile" table="licensee" field="lic_profilepicture" data-id="<?php echo $ia['lic_id']; ?>" name-id="lic_id" style="display: none;">
	<?php $this->load->view('include/crop_image_modal'); ?>
	<?php $this->load->view('include/footer.php'); ?>
	<?php $this->load->view('include/readmore_modal.php'); ?>
 <?php $this->load->view('include/confim_popup.php'); ?>
    <script>
	function loadTableData(){
            var url = "<?php echo site_url() ?>licensee/Licensee/viewnote";
          	var lic_id = $('#lic_id').val();
            $('#example').dataTable( {
                "serverSide": true,
                "ajax": {
			          "url": url,
			          "type": "POST",
			          "data":{'lic_id':lic_id},
			        },
                "searching": false,
                "aaSorting": [[3, 'desc']],
            } );
        };

	loadTableData();
	
	function loadData(){
            var url = "<?php echo site_url() ?>licensee/Licensee/viewnote";
          	var lic_id = $('#lic_id').val();
            $('#example').dataTable( {
            	"destroy": true,
                "serverSide": true,
                "ajax": {
			          "url": url,
			          "type": "POST",
			          "data":{'lic_id':lic_id},
			        },
			    "aaSorting": [[3, 'desc']],
                "searching": false,
            } );
        };

	$("#profilePicBtnlic").click(function () {
        	$('#directmove').css('display','none');
        	$('#directmoveli').css('display','block');
        	$('#uploadtype').val('ia');
  		$('#iaprofileDiv').find(".imgInput").trigger('click');
	});

		$("#profilePicBtnp").click(function () {
        	$('#directmoveli').css('display','none');
        	$('#directmove').css('display','block');
        	$('#uploadtype').val('cto');
  		$('#profileDiv').find(".imgInput").trigger('click');
	});
    </script>
</div>
<!-- Modal -->
<div id="addNote" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
		<div class="addNote">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h3>Add Note</h3>
		<?php echo form_open('licensee/addnote',array('class'=>'addForm','id'=>'add_note','enctype'=>'multipart/form-data','autocomplete'=>'off')); ?>
				<input type="hidden" name="lic_id" value="<?php echo $ia['lic_id']; ?>">
				<div class="form-group">
					<label>Title</label>
					<div class="input-group">
						<span class="input-group-addon">
							<i class="glyphicon glyphicon-user"></i>
						</span>
						<input  name="app_activity_title" id="app_activity_title" class="form-control" placeholder="Title"  value="" type="text">
					</div>
						<span id="app_activity_title_err" class="invalidText"></span>
				</div>
				<div class="form-group">
					<label>Description</label>
					<div class="input-group">
						<span class="input-group-addon">
							<i class="glyphicon glyphicon-user"></i>
						</span>
						<textarea cols="5" rows="5" class="desript" name="app_activity_des" id="app_activity_des"></textarea>
					</div>
					<span id="app_activity_des_err" class="invalidText"></span>
				</div>
				<div class="addButton">
					<button>Submit</button>
					<button class="cenle" data-dismiss="modal">Cancel</button>
				</div>
			<?php echo form_close(); ?>
		</div>
    </div>

  </div>
</div>
<style type="text/css">
.modal-dialog {
    width: 600px;
    margin: 138px auto;
}
</style>
</body>
</html>