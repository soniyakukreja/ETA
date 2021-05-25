
<?php $this->load->view('include/header.php');
$this->userdata = $this->session->userdata('userdata');
$perms=explode(",",$this->userdata['upermission']); ?>
<style>
	.expBtn .addNew {
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
								
								<?php $this->load->view('include/leftsidebar.php'); ?>
								
								<?php $Country= $this->generalmodel->getSingleRowById('country','id', $sup['country'], $returnType = 'array');
									$Category= $this->generalmodel->getSingleRowById('user_category','user_cat_id', $sup['user_cat_id'], $returnType = 'array');
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
		
       <div class="col-md-12 ">

<div class="panel panel-default">
 <div class="panel-heading">  <h4 >Supplier Details  
 <?php if(in_array("SUPP_E",$perms)) {?>
 <a href="<?php echo site_url('supplier/editsupplier/').encoding($sup['supplier_id']); ?>" style="float: right;"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
 <?php }?>
<a href="javascript:window.history.go(-1);" style="float:right;<?php if(in_array("SUPP_E",$perms)) { echo 'margin-right: 35px'; } ?>">Back</a>
  </h4> </div>
   <div class="panel-body">
       
    <div class="box box-info">
        
            <div class="box-body">
                     <div class="col-sm-3">
                     <div  align="center"> <?php if($sup['profilepicture']){ ?>
												<img src="<?php echo base_url() ?>uploads/user/<?php echo $sup['profilepicture']; ?>" id="profile-image1" class="img-responsive">
											<?php }else{ ?>
												<img src="<?php echo base_url() ?>assets/img/avtr.png" id="profile-image1" class="img-responsive">
											<?php } ?>
														<!-- <img alt="User Pic" src="https://x1.xingassets.com/assets/frontend_minified/img/users/nobody_m.original.jpg" id="profile-image1" class="img-responsive"> --> 
                
                <input id="supplier_img" name="supplier_img" class="hidden imgInput" type="file">
                <input id="supplier_img_h" type="hidden" name="supplier_img_h">
<!-- <div style="color:#999;"><a href="#" id="profilePicBtn"> click here to change profile image </a></div> -->
                
                     </div>
              
              <!-- /input-group -->
            </div>
            <div class="col-sm-9">
         
<div class="col-sm-5 col-xs-6 tital " >Resource ID:</div><div class="col-sm-7 col-xs-6 "><?php echo $sup['resource_id']; ?></div>
     <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital " >Business:</div><div class="col-sm-7 col-xs-6 "><?php echo $sup['supplier_bname']; ?></div>
     <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital " >First Name:</div><div class="col-sm-7 col-xs-6 "><?php echo $sup['supplier_fname']; ?></div>
     <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital " >Last Name:</div><div class="col-sm-7"> <?php echo $sup['supplier_lname']; ?></div>
  <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital " >Email Address:</div><div class="col-sm-7"><?php echo $sup['email']; ?></div>

  <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital " >Contact Number:</div><div class="col-sm-7"><?php echo $sup['contactno']; ?></div>

  <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital " >Country:</div><div class="col-sm-7"><?php echo $Country['country_name']; ?></div>

 <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital " >Award Level:</div><div class="col-sm-7"><?php echo $Category['user_cat_name']; ?></div>

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


										<div class="noteDetail">
											<div class="panel panel-default">
												<div class="panel-heading expBtn"><span>Activity</span> <a href="#addNote" class="addNew" data-toggle="modal">Add Note</a></div>
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
		<input type="hidden" id="supplier_id" value="<?php echo $sup['supplier_id']; ?>" >
		<input type="hidden" id="uploadtype" value="" >
	<input type="hidden" id="directmove" value="user" table="user" field="profilepicture" data-id="<?php echo $sup['user_id']; ?>" name-id="user_id" >
	<?php $this->load->view('include/crop_image_modal'); ?>
	<?php $this->load->view('include/footer.php'); ?>
 <?php $this->load->view('include/confim_popup.php'); ?>
 	<?php $this->load->view('include/readmore_modal.php'); ?>

<script>
function loadTableData(){
			var supplier_id = $('#supplier_id').val();
            var url = "<?php echo site_url() ?>supplier/Supplier/viewnote";
            $('#example').dataTable( {
                "serverSide": true,
                "ajax": {
			          "url": url,
			          "type": "POST",
			          "data":{'supplier_id':supplier_id},
			        },
                "searching": false,
                "aaSorting": [[3, 'desc']],
            } );
        };
	loadTableData();

	function loadData(){
			var supplier_id = $('#supplier_id').val();
            var url = "<?php echo site_url() ?>supplier/Supplier/viewnote";
            $('#example').dataTable( {
            	"destroy": true,
                "serverSide": true,
                "ajax": {
			          "url": url,
			          "type": "POST",
			          "data":{'supplier_id':supplier_id},
			        },
                "searching": false,
                "aaSorting": [[3, 'desc']],
            } );
        };
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
		<?php echo form_open('supplier/addnote',array('class'=>'addForm','id'=>'add_note','enctype'=>'multipart/form-data','autocomplete'=>'off')); ?>
				<input type="hidden" name="supplier_id" value="<?php echo $sup['supplier_id']; ?>" >
				<div class="form-group">
					<label>Title</label>
					<div class="input-group">
						<span class="input-group-addon">
							<i class="glyphicon glyphicon-user"></i>
						</span>
						<input  name="app_activity_title" id="app_activity_title" class="form-control" placeholder="Title"  type="text">
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
</body>
</html>