<?php $this->load->view('include/header.php'); ?>
<style>
	.dl-dt a.addNew {
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
								
								<div class="filterBody">
									<div class="filterDiv">
										
										<div id="errorMsg" class="alert alert-danger hide">
                      						<strong>Warning!</strong>
                    					</div>
                    					<div id="successMsg" class="alert alert-success hide">
                      						<strong>Success!</strong>
                    					</div>
                           
                    					<?php 
                    					$stage=$this->generalmodel->getSingleRowById('pipelinstage', 'pstage_id', $data['pstage_id'], $returnType = 'array'); 

                    					?>
										
										<div class="row">
										<input type="hidden" name="bus_id" id="bus_id" value="<?php echo $data['business_id'] ?>" >
       <div class="col-md-12 ">

<div class="panel panel-default">
  <div class="panel-heading ">  <h4>Deals  <a href="<?php echo site_url('lead/deal/editdeal/').encoding($data['deal_id']); ?>" style="float: right;"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
<a href="javascript:window.history.go(-1);" style="float: right; margin-right: 35px;">Back</a>
  </h4> </div>
   <div class="panel-body">
       
    <div class="box box-info">
        
            <div class="box-body">
                    
            <div class="col-sm-9">
     
<div class="col-sm-5 col-xs-6 tital ">Deal Title:</div><div class="col-sm-7"> <?php echo $data['deal_title']; ?></div>
     <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Person:</div><div class="col-sm-7 col-xs-6 "><a href="<?php echo site_url('lead/contact/contactdetail/').encoding($data['contact_id']); ?>" target="_blank"><?php echo $data['contact_person']; ?></a></div>
  <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Business:</div><div class="col-sm-7"> <a href="<?php echo site_url('lead/business/viewbusiness_detail/').encoding($data['business_id']); ?>" target="_blank"><?php echo $data['business_name']; ?></a></div>
  <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Deal Value:</div><div class="col-sm-7"><?php setlocale(LC_MONETARY,"en_US"); echo money_format("$%i", $data['deal_value']).' USD'; ?></div>

  <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Stage:</div><div class="col-sm-7"><?php echo $stage['pstage_name']; ?></div>

  <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Age:</div><div class="col-sm-7"><?php $createdate= strtotime($data['stagemodifydate']);
						$today = strtotime(date('Y-m-d H:i:s'));
						$age= ceil((($today-$createdate)/3600)/24); echo $age.' Day(s)'; ?></div>

 <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Expected Close date:</div><div class="col-sm-7"><?php echo date('m/d/Y',strtotime($data['deal_exp_closedate'])); ?></div>

 <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Additional Details:</div><div class="col-sm-7"><?php echo $data['deal_notes']; ?></div>


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


										<div class="noteDetail">
											<div class="panel panel-default">
												<div class="panel-heading dl-dt"><span>Activity</span> <a href="#addNote" class="addNew" data-toggle="modal">Add Note</a></div>
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

	<input type="hidden" id="deal_id" value="<?php echo $data['deal_id']; ?>" >
	<?php $this->load->view('include/footer.php'); ?>
	<?php $this->load->view('include/readmore_modal.php'); ?>
 <script type="text/javascript" charset="utf-8">
       function loadTableData(){
       		var deal_id = $('#deal_id').val();
            var url = "<?php echo site_url() ?>lead/Deal/viewnote";
          
          $('#example').dataTable( {
                "serverSide": true,
                "ajax": {
			          "url": url,
			          "type": "POST",
			          "data":{'deal_id':deal_id},
			        },
                "searching": false,
                "aaSorting": [[0, 'desc']],
            } );
        };
	loadTableData();
	function loadData(){
       		var deal_id = $('#deal_id').val();
            var url = "<?php echo site_url() ?>lead/Deal/viewnote";
          
          $('#example').dataTable( {
          		"destroy":true,
                "serverSide": true,
                "ajax": {
			          "url": url,
			          "type": "POST",
			          "data":{'deal_id':deal_id},
			        },
                "searching": false,
                "aaSorting": [[0, 'desc']],
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
		<?php echo form_open('lead/Deal/addnote',array('class'=>'addForm','id'=>'add_note','enctype'=>'multipart/form-data','autocomplete'=>'off')); ?>
				<input type="hidden" name="deal_id" value="<?php echo $data['deal_id']; ?>" >
				<div class="form-group">
					<label>Title</label>
					<div class="input-group">
						<span class="input-group-addon">
							<i class="glyphicon glyphicon-user"></i>
						</span>
						<input  name="app_activity_title"  id="app_activity_title" class="form-control" placeholder="Title"  value="" type="text">
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