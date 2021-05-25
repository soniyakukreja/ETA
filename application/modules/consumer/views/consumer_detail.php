<?php $this->load->view('include/header.php'); 
$this->userdata = $this->session->userdata('userdata');
$perms=explode(",",$this->userdata['upermission']); ?>

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
									<?php   $Country= $this->generalmodel->getSingleRowById('country','id', $data['country'], $returnType = 'array'); ?>
									<div class="filterDiv">
										
										<div class="row">
		
       <div class="col-md-12 ">

<div class="panel panel-default">
  <div class="panel-heading">  <h4 >Consumer Details  
  	<?php if(in_array("CON_E",$perms)) {?>
  	<a href="<?php echo site_url('consumer/editconsumer/').encoding($data['user_id']); ?>" style="float: right;"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
   <?php }?>
<a href="javascript:window.history.go(-1);" style="float: right;<?php if(in_array("CON_E",$perms)) { echo 'margin-right: 35px';} ?> ">Back</a>
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
														
                
                <input id="profile-image-upload" class="hidden" type="file">
<!-- <div style="color:#999;" >click here to change profile image</div> -->
                
                     </div>
              
              <!-- /input-group -->
            </div>
            <div class="col-sm-9">
<div class="col-sm-5 col-xs-6 tital " >Business Name:</div><div class="col-sm-7 col-xs-6 "><?php echo $data['business_name']; ?></div>
     <div class="clearfix"></div>
<div class="bot-border"></div>

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
										<?php $this->userdata = $this->session->userdata('userdata');
											if($this->userdata['urole_id']==1 ||$this->userdata['urole_id']==2 ||$this->userdata['urole_id']==3){
										 ?>
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
	<input type="hidden" id="consumer_id" value="<?php echo $data['user_id']; ?>">
<?php $this->load->view('include/footer.php'); ?>
	<?php $this->load->view('include/readmore_modal.php'); ?>

</div>
 <script>
	function loadTableData(){
            var url = "<?php echo site_url() ?>consumer/viewnote";
          	var consumer_id = $('#consumer_id').val();
            $('#example').dataTable( {
                "serverSide": true,
                "ajax": {
			          "url": url,
			          "type": "POST",
			          "data":{'consumer_id':consumer_id},
			        },
                "searching": false,
                "aaSorting": [[3, 'desc']],
            } );
        };
	loadTableData();
	function loadData(){
            var url = "<?php echo site_url() ?>consumer/viewnote";
          	var consumer_id = $('#consumer_id').val();
            $('#example').dataTable( {
            	"destroy":true,
                "serverSide": true,
               "ajax": {
			          "url": url,
			          "type": "POST",
			          "data":{'consumer_id':consumer_id},
			        },
                "searching": false,
                "aaSorting": [[3, 'desc']],
            } );
        };
</script>

<div id="addNote" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
		<div class="addNote">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h3>Add Note</h3>
		<?php echo form_open('consumer/addnote',array('class'=>'addForm','id'=>'add_note','enctype'=>'multipart/form-data','autocomplete'=>'off')); ?>
				<input type="hidden" name="consumer_id" value="<?php echo $data['user_id']; ?>">
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
</body>
</html>