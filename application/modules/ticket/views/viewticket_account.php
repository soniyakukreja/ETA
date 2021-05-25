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
								
									<div class="aside">
                        			<?php $this->load->view('include/leftsidebar'); ?>
                        		</div>
								
								<?php $cate=$this->generalmodel->getSingleRowById('ticket_category', 'tic_cat_id', $product['tic_cat_id'], $returnType = 'array');
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
  <div class="panel-heading">  <h4 >Ticket:  
  <!-- edit for user  -->
  	 <a href="<?php echo site_url('ticket_account/editticket_account/').encoding($product['tic_id']); ?>" style="float: right;"><span class="glyphicon glyphicon-pencil"></span> Edit</a> 
  	 <a href="javascript:window.history.go(-1);" style="float: right; margin-right: 35px;">Back</a>
                                                                    </h4> </div>
   <div class="panel-body">
       
    <div class="box box-info">
        
            <div class="box-body">
                     
            <div class="col-sm-9">
         
<div class="col-sm-5 col-xs-6 tital " >Ticket Title:</div><div class="col-sm-7 col-xs-6 "><?php echo $product['tic_title']; ?></div>
     <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital " >Ticket Number:</div><div class="col-sm-7"> <?php echo $product['tic_number']; ?></div>
  <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital " >Ticket User:</div><div class="col-sm-7"><?php echo $product['tic_users']; ?></div>

  <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital " >Category:</div><div class="col-sm-7"><?php echo
$cate['tic_cat_name']; ?></div>

  <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital " >Ticket Status:</div><div class="col-sm-7"><?php echo $product['tic_status']; ?></div>

  <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital " >Description:</div><div class="col-sm-7"><?php echo $product['tic_desc']; ?></div>

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
												<div class="panel-heading"><span>Activity</span> <a href="#addNote" class="addNew" data-toggle="modal">Add Note</a></div>
												<div class="panel-body">
													<div class="detailTebler filterTable table-responsive">
														<table id="example">
															<thead>
																<tr>
																	<th>Title</th>
																	<th>User</th>
																	<th>Name</th>
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
  <?php $this->load->view('include/confim_popup.php'); ?>
<script>
function loadTableData(){
            var url = "<?php echo site_url() ?>ticket/Ticket/viewnote";
            $('#example').dataTable( {
                "serverSide": true,
                "ajax" : url
            } );
        };
	loadTableData();
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
		<?php echo form_open('ticket/addnote',array('class'=>'addForm','id'=>'add_ticnote','enctype'=>'multipart/form-data','autocomplete'=>'off')); ?>
				<input type="hidden" name="id" value="<?php echo $product['tic_id']; ?>"> 
				<div class="form-group">
					<label>Title</label>
					<div class="input-group">
						<span class="input-group-addon">
							<i class="glyphicon glyphicon-user"></i>
						</span>
						<input  name="tic_activity_title" id="tic_activity_title" class="form-control" placeholder="Title" required="true" value="" type="text">
						<span id="tic_activity_title_err" class="invalidText"></span>
					</div>
				</div>
				<div class="form-group">
					<label>Type</label>
					<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-th-list"></i></span>
						<select class="form-control js-example-basic-single" name="tic_activity_type" id="tic_activity_type">
							<option value="">Please Select</option>
							<option value="All">All</option>
							<option value="Whispers">Whispers</option>
							<option value="Comment">Comment</option>
						</select>
					</div>
					<span id="tic_activity_type_err" class="invalidText"></span>
				</div>
				<div class="form-group">
					<label>Description</label>
					<div class="input-group">
						<span class="input-group-addon">
							<i class="glyphicon glyphicon-user"></i>
						</span>
						<textarea cols="5" rows="5" class="desript" name="tic_activity_des" id="tic_activity_des"></textarea>
					</div>
					<span id="tic_activity_des_err" class="invalidText"></span>
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