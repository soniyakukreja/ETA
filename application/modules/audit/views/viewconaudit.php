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
									<div class="filterDiv">
										
                    				
										<div class="row">
		
       <div class="col-md-12 ">

<div class="panel panel-default">
  <div class="panel-heading">  <h4>Audit:  
<a href="javascript:window.history.go(-1);" style="float: right; margin-right: 35px;">Back</a>
  </h4> </div>
   <div class="panel-body">
       
    <div class="box box-info">
        
            <div class="box-body">
                    
            <div class="col-sm-9">
         
<div class="col-sm-5 col-xs-6 tital ">Audit Number:</div><div class="col-sm-7"><?php echo $ad['audit_num']; ?></div>
     <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Business Name:</div><div class="col-sm-7"><?php echo $ad['businessname']; ?></div>
     <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Status:</div><div class="col-sm-7"><?php if($ad['status']==0){echo "Pending Audit";}else if($ad['status']==1){echo "Pending Review";}else if($ad['status']==2){echo "Pending Certificate";}?></div>
  <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Last Updated Date:</div><div class="col-sm-7">
	<?php if($ad['updatedate']!='0000-00-00 00:00:00'){ 
		$localtimzone =$this->userdata['timezone'];
        $update = gmdate_to_mydate($ad['updatedate'],$localtimzone);
       
       echo date('m/d/Y',strtotime($update));
		// echo date('m/d/Y',strtotime($ad['updatedate']));
	}else{ echo '00-00-0000';} ?></div>
  <div class="clearfix"></div>
<div class="bot-border"></div>

<?php $this->userdata = $this->session->userdata('userdata'); if($this->userdata['urole_id']==4){ ?>
<div class="col-sm-5 col-xs-6 tital ">Issue Date:</div><div class="col-sm-7">
	<?php if($ad['issue_date']!='0000-00-00 00:00:00'){ 
		$localtimzone =$this->userdata['timezone'];
        $issuedate = gmdate_to_mydate($ad['issue_date'],$localtimzone);
       
       echo date('m/d/Y',strtotime($issuedate));
		// echo date('m/d/Y',strtotime($ad['issue_date'])); 
	}else{ echo '00-00-0000';} ?></div>
  <div class="clearfix"></div>
<div class="bot-border"></div>


<div class="col-sm-5 col-xs-6 tital ">End Date:</div><div class="col-sm-7">
	<?php if($ad['end_date']!='0000-00-00 00:00:00'){ 
		$localtimzone =$this->userdata['timezone'];
        $enddate = gmdate_to_mydate($ad['end_date'],$localtimzone);
       
       echo date('m/d/Y',strtotime($enddate));
		// echo date('m/d/Y',strtotime($ad['end_date'])); 
	}else{ echo '00-00-0000';} ?></div>
  <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">File:</div><div class="col-sm-7"><?php if($ad['file']){ ?><a href="<?php echo base_url('uploads/audit_file/certificate').$ad['certificate_file']; ?>" class="downldBtn" target="_blank" download="">Download <span class="glyphicon glyphicon-download-alt"></span></a><?php } ?></div>
<?php } ?>
<?php if($this->userdata['urole_id']==1){ ?>
<div class="col-sm-5 col-xs-6 tital ">File:</div><div class="col-sm-7"><?php if($ad['file']){ ?><a href="<?php echo base_url('uploads/audit_file').$ad['file']; ?>" class="downldBtn" target="_blank" download="">Download <span class="glyphicon glyphicon-download-alt"></span></a><?php } ?></div>
<?php } ?>
  <div class="clearfix"></div>
<div class="bot-border"></div>

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
												<div class="panel-heading"><span>Activity</span> <a href="#addNote" class="addNew" data-toggle="modal">Add Note</a></div>
												<div class="panel-body">
													<div class="detailTebler filterTable table-responsive">
														<table id="example">
															<thead>
																<tr>
																	<th>Title</th>
																	<th>User</th>
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
	<input type="hidden" id="ord_prod_id" value="<?php echo $ad['ord_prod_id']; ?>">
	<?php $this->load->view('include/footer.php'); ?>
  <?php $this->load->view('include/confim_popup.php'); ?>
	<?php $this->load->view('include/readmore_modal.php'); ?>

  <script type="text/javascript" charset="utf-8">
       function loadTableData(){
            var url = "<?php echo site_url() ?>audit/viewnote";
          	var ord_prod_id = $('#ord_prod_id').val();
            $('#example').dataTable( {
                "serverSide": true,
                "ajax": {
			          "url": url,
			          "type": "POST",
			          "data":{'ord_prod_id':ord_prod_id},
			        },
                "searching": false,
                "aaSorting": [[3, 'desc']],
            } );
        };
	loadTableData();

	function loadData(){
            var url = "<?php echo site_url() ?>audit/viewnote";
          	var ord_prod_id = $('#ord_prod_id').val();
            $('#example').dataTable( {
            	"destroy":true,
                "serverSide": true,
               "ajax": {
			          "url": url,
			          "type": "POST",
			          "data":{'ord_prod_id':ord_prod_id},
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
		<?php echo form_open('audit/addnote',array('class'=>'addForm','id'=>'add_note','enctype'=>'multipart/form-data','autocomplete'=>'off')); ?>
				<input type="hidden" id="url" value="<?php echo site_url() ?>audit/viewaudit/<?php echo $ad['ord_prod_id']; ?>">
				<input type="hidden" name="ord_prod_id" value="<?php echo $ad['ord_prod_id']; ?>">
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
</body>
</html>