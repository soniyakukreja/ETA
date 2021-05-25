<?php $this->load->view('include/header.php'); 
$uristring=$this->uri->segment(1).'/'.$this->uri->segment(2);
?>

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
								
								<?php $cate=$this->generalmodel->getSingleRowById('ticket_category', 'tic_cat_id', $product['tic_cat_id'], $returnType = 'array'); ?>
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
  <div class="panel-heading">  <h4 >Ticket  
  <!-- edit for user  -->
  	<?php 
  	//print_r($product); exit;
  	$edit = false;
  	if($uristring=='ticket_account/viewlicticket'){ $edit = true; ?>
  	 <a href="<?php echo site_url('ticket/editlicticket/').encoding($product['tic_id']); ?>" style="float: right;"><span class="glyphicon glyphicon-pencil"></span> Edit</a> <?php }
  	 else if ($uristring=='ticket_account/viewiaticket'){  $edit = true;?>
  	 <a href="<?php echo site_url('ticket/editiaticket/').encoding($product['tic_id']); ?>" style="float: right;"><span class="glyphicon glyphicon-pencil"></span> Edit</a> <?php }
  	 else if ($uristring=='ticket_account/viewconticket'){  $edit = true;?>
  	 <a href="<?php echo site_url('ticket/editconticket/').encoding($product['tic_id']); ?>" style="float: right;"><span class="glyphicon glyphicon-pencil"></span> Edit</a> <?php }?>
  	 <a href="javascript:window.history.go(-1);" style="float:right; <?php if($edit){ echo 'margin-right: 35px';} ?>">Back</a>
                                                                    </h4> </div>
   <div class="panel-body">
       
    <div class="box box-info">
        
            <div class="box-body">
                     
            <div class="col-sm-9">
         <input type="hidden" name="tic_id" id="tic_id" value="<?php echo $product['tic_id']; ?>">
<div class="col-sm-5 col-xs-6 tital " >Ticket Title:</div><div class="col-sm-7 col-xs-6 "><?php echo $product['tic_title']; ?></div>
     <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital " >Ticket Number:</div><div class="col-sm-7"> <?php echo $product['tic_number']; ?></div>
  <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital " >Ticket User:</div><div class="col-sm-7">
	
	<?php 
	// $name=''; foreach (explode($product['tic_users']) as $value) {
		$name = "";
	if($product['tic_users']){

		$user=  $this->generalmodel->get_data_by_condition('firstname,lastname','user','user_id IN ('.trim($product['tic_users'],",").')'); 
		foreach ($user as $row) {
			$name.=$row['firstname'].' '.$row['lastname'].', ';
		}
	 echo rtrim($name,', '); 
	}
		
	?></div>

  <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital " >Category:</div><div class="col-sm-7"><?php echo
$cate['tic_cat_name']; ?></div>

  <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital " >Ticket Status:</div><div class="col-sm-7"><?php if($product['tic_status']==0){ echo "Open";}else if($product['tic_status']==1){ echo "Pending";}else if($product['tic_status']==2){ echo "Resolved";}else if($product['tic_status']==3){ echo "Spam";} ?></div>

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
														<form>
															<label>Filter by Type</label>
															<select id="type">
																<option value="">Please Select</option>
																<option value="All">All</option>
																<option value="Whispers">Whisper</option>
																<option value="Comment">Comment</option>
															</select>
															<button id="filter" type="button">Filter</button>
															<button  type="reset">Reset</button>

														</form>
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
									<?php $this->load->view('include/rightsidebar'); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</main>
		</content>
	</article>
	<input type="hidden" id="users" value="<?php echo $product['tic_users']; ?>">
	<?php $this->load->view('include/footer.php'); ?>
  <?php $this->load->view('include/confim_popup.php'); ?>
  <?php $this->load->view('include/readmore_modal.php'); ?>
<script>
function loadTableData(){
  			var tic_id = $('#tic_id').val();
  			var users = $('#users').val();
            //var url = "<?php echo site_url() ?>ticket/Ticket/viewnote";
            var url = site_url+"ticket/Ticket/viewnote/"+tic_id;;
            $('#example').dataTable( {
                "serverSide": true,
                "searching": false,
                "lengthMenu": [ 10, 20, 50, 100, 200,250,500 ],
                "ajax": {
			        "url": url,
			        "type": "POST",
			        "data":{'tic_id':tic_id,users:users},
			      },
			      "aaSorting": [[3, 'desc']],
            } );
        };
	loadTableData();

function loadData(){
	var tic_id = $('#tic_id').val();
    var url = site_url+"ticket/Ticket/viewnote/"+tic_id;
    $('#example').dataTable( {
    	"destroy": true,
        "serverSide": true,
        "searching": false,
        "lengthMenu": [ 10, 20, 50, 100, 200,250,500 ],
        "ajax": {
	        "url": url,
	        "type": "POST",
	        "data":{'tic_id':tic_id},
	      },
	      "aaSorting": [[3, 'desc']],
    } );
};

$(document).on('click','#filter',function(){
  $('#example').DataTable().destroy();
  var type = $('#type').val();
  var tic_id = $('#tic_id').val();
  //var url = "<?php echo site_url() ?>ticket/Ticket/viewnote";
  var url = site_url+"ticket/Ticket/viewnote/"+tic_id;

   $('#example').dataTable({
      "serverSide": true,
      "responsive": true,
      "searching": false,
      "lengthMenu": [ 10, 20, 50, 100, 200,250,500 ],
      "ajax": {
        "url": url,
        "type": "POST",
        "data":{'type':type, 'tic_id':tic_id},
      }
  });   

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
							<option value="Whispers">Whisper</option>
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