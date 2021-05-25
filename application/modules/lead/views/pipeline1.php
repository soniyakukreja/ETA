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
								<div class="filterBody">
									<div class="filterDiv"> 
										<h3>Pipeline:</h3>
										<div id="errorMsg" class="alert alert-danger hide">
                      					<strong>Warning!</strong>
                    					</div>
                    					<div id="successMsg" class="alert alert-success hide">
                      					<strong>Success!</strong>
                    					</div>
										<div class="pileLine">
											<ul>
												<li>
													<h3>Stage 1 <span class="glyphicon glyphicon-menu-right"></span></h3>
													<?php if ($data) {
														foreach ($data as $row) { 
												$stage=$this->generalmodel->getSingleRowById('pipelinstage', 'pstage_id', $row['deal_stage'], $returnType = 'array');
															if($stage['pstage_name']=='Stage 1'){ 
																$createdate= strtotime($row['deal_createdate']);
																$today = strtotime(date('Y-m-d H:i:s'));
																$age= ceil((($today-$createdate)/3600)/24);
															 ?>
															<div class="pipeBox">
																
																<h4><a href="<?php echo site_url() ?>lead/deal/dealdetail/<?php echo $row['deal_id'] ?>" target="_blank"><?php echo $row['deal_title']; ?></a></h4>
																<p>Business-<a href="<?php echo site_url() ?>lead/business/viewbusiness_detail/<?php echo $row['business_id'] ?>" target="_blank"><?php echo $row['business_name']; ?></a><br><p>Contact-<a href="<?php echo site_url() ?>lead/contact/contactdetail/<?php echo $row['contact_id'] ?>" target="_blank"><?php echo $row['contact_person']; ?></a> <br> Expected Close- <b><?php echo date('m/d/Y',strtotime($row['deal_exp_closedate'])); ?></b> <br> Deal Age - <b><?php echo $age; ?> Day(s)</b> </p>
																<div class="footPipe">
																	<a href="#ChangeStage" class="ChangeStage" data-id="<?php echo $row['deal_id']; ?>" data-stage="<?php echo $stage['pstage_id']; ?>">Change Stage</a>
																</div>
															</div>
													<?php	} }
													}else{ ?> 
															<div class="pipeBox">No Record Found</div>
													<?php } ?>
													
												</li>
												<li>
													<h3>Stage 2<span class="glyphicon glyphicon-menu-right"></span></h3>
													<?php if ($data) {
														foreach ($data as $row) { 
															$stage=$this->generalmodel->getSingleRowById('pipelinstage', 'pstage_id', $row['deal_stage'], $returnType = 'array');
															if($stage['pstage_name']=='Stage 2'){ 
																$createdate= strtotime($row['deal_createdate']);
																$today = strtotime(date('Y-m-d H:i:s'));
																$age= ceil((($today-$createdate)/3600)/24);
															 ?>
															<div class="pipeBox">
																
																<h4><a href="<?php echo site_url() ?>lead/deal/dealdetail/<?php echo $row['deal_id'] ?>" target="_blank"><?php echo $row['deal_title']; ?></a></h4>
																<p>Business-<a href="<?php echo site_url() ?>lead/business/viewbusiness_detail/<?php echo $row['business_id'] ?>" target="_blank"><?php echo $row['business_name']; ?></a><br><p>Contact-<a href="<?php echo site_url() ?>lead/contact/contactdetail/<?php echo $row['contact_id'] ?>" target="_blank"><?php echo $row['contact_person']; ?></a> <br> Expected Close- <b><?php echo date('m/d/Y',strtotime($row['deal_exp_closedate'])); ?></b> <br> Deal Age - <b><?php echo $age; ?> Day(s)</b> </p>
																<div class="footPipe">
																	<a href="#ChangeStage" class="ChangeStage" data-id="<?php echo $row['deal_id']; ?>" data-stage="<?php echo $stage['pstage_id']; ?>">Change Stage</a>
																</div>
															</div>
													<?php	} }
													}else{ ?> 
															<div class="pipeBox">No Record Found</div>
													<?php } ?>
												</li>
												<li>
													<h3>Stage 3<span class="glyphicon glyphicon-menu-right"></span></h3>
													<?php if ($data) {
														foreach ($data as $row) { 
															$stage=$this->generalmodel->getSingleRowById('pipelinstage', 'pstage_id', $row['deal_stage'], $returnType = 'array');
															if($stage['pstage_name']=='Stage 3'){ 
																$createdate= strtotime($row['deal_createdate']);
																$today = strtotime(date('Y-m-d H:i:s'));
																$age= ceil((($today-$createdate)/3600)/24);
															 ?>
															<div class="pipeBox">
																
																<h4><a href="<?php echo site_url() ?>lead/deal/dealdetail/<?php echo $row['deal_id'] ?>" target="_blank"><?php echo $row['deal_title']; ?></a></h4>
																<p>Business-<a href="<?php echo site_url() ?>lead/business/viewbusiness_detail/<?php echo $row['business_id'] ?>" target="_blank"><?php echo $row['business_name']; ?></a><br><p>Contact-<a href="<?php echo site_url() ?>lead/contact/contactdetail/<?php echo $row['contact_id'] ?>" target="_blank"><?php echo $row['contact_person']; ?></a> <br> Expected Close- <b><?php echo date('m/d/Y',strtotime($row['deal_exp_closedate'])); ?></b> <br> Deal Age - <b><?php echo $age; ?> Day(s)</b> </p>
																<div class="footPipe">
																	<a href="#ChangeStage" class="ChangeStage" data-id="<?php echo $row['deal_id']; ?>" data-stage="<?php echo $stage['pstage_id']; ?>">Change Stage</a>
																</div>
															</div>
													<?php	} }
													}else{ ?> 
															<div class="pipeBox">No Record Found</div>
													<?php } ?>
												</li>
												<li>
													<h3>Stage 4 <span class="glyphicon glyphicon-menu-right"></span></h3>
													<?php if ($data) {
														foreach ($data as $row) { 
															$stage=$this->generalmodel->getSingleRowById('pipelinstage', 'pstage_id', $row['deal_stage'], $returnType = 'array');
															if($stage['pstage_name']=='Stage 4'){ 
																$createdate= strtotime($row['deal_createdate']);
																$today = strtotime(date('Y-m-d H:i:s'));
																$age= ceil((($today-$createdate)/3600)/24);
																
															 ?>
															<div class="pipeBox">
																
																<h4><a href="<?php echo site_url() ?>lead/deal/dealdetail/<?php echo $row['deal_id'] ?>" target="_blank"><?php echo $row['deal_title']; ?></a></h4>
																<p>Business-<a href="<?php echo site_url() ?>lead/business/viewbusiness_detail/<?php echo $row['business_id'] ?>" target="_blank"><?php echo $row['business_name']; ?></a><br><p>Contact-<a href="<?php echo site_url() ?>lead/contact/contactdetail/<?php echo $row['contact_id'] ?>" target="_blank"><?php echo $row['contact_person']; ?></a> <br> Expected Close- <b><?php echo date('m/d/Y',strtotime($row['deal_exp_closedate'])); ?></b> <br> Deal Age - <b><?php echo $age; ?> Day(s)</b> </p>
																<div class="footPipe">
																	<a href="#ChangeStage" class="ChangeStage" data-id="<?php echo $row['deal_id']; ?>" data-stage="<?php echo $stage['pstage_id']; ?>">Change Stage</a>
																</div>
															</div>
													<?php	} }
													}else{ ?> 
															<div class="pipeBox">No Record Found</div>
													<?php } ?>
												</li>
												<li>
													<h3>Stage 5<span class="glyphicon glyphicon-menu-right"></span></h3>
													<?php if ($data) {
														foreach ($data as $row) { 
															$stage=$this->generalmodel->getSingleRowById('pipelinstage', 'pstage_id', $row['deal_stage'], $returnType = 'array');
															if($stage['pstage_name']=='Stage 5'){ 
																$createdate= strtotime($row['deal_createdate']);
																$today = strtotime(date('Y-m-d H:i:s'));
																$age= ceil((($today-$createdate)/3600)/24);
															 ?>
															<div class="pipeBox">
																
																<h4><a href="<?php echo site_url() ?>lead/deal/dealdetail/<?php echo $row['deal_id'] ?>" target="_blank"><?php echo $row['deal_title']; ?></a></h4>
																<p>Business-<a href="<?php echo site_url() ?>lead/business/viewbusiness_detail/<?php echo $row['business_id'] ?>" target="_blank"><?php echo $row['business_name']; ?></a><br><p>Contact-<a href="<?php echo site_url() ?>lead/contact/contactdetail/<?php echo $row['contact_id'] ?>" target="_blank"><?php echo $row['contact_person']; ?></a> <br> Expected Close- <b><?php echo date('m/d/Y',strtotime($row['deal_exp_closedate'])); ?></b> <br> Deal Age - <b><?php echo $age; ?> Day(s)</b> </p>
																<div class="footPipe">
																	<a href="#ChangeStage" class="ChangeStage" data-id="<?php echo $row['deal_id']; ?>" data-stage="<?php echo $stage['pstage_id']; ?>">Change Stage</a>
																</div>
															</div>
													<?php	} }
													}else{ ?> 
															<div class="pipeBox">No Record Found</div>
													<?php } ?>
												</li>
											</ul>
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
	<?php $this->load->view('include/footer'); ?>
	<?php $this->load->view('include/change_stage'); ?>
	<script type="text/javascript">
	$(document).ready(function(){
       $('body').on('click','.ChangeStage',function(){
           var ad = $(this).attr('data-id');
           var stage = $(this).attr('data-stage');
           console.log(stage,'stage');
            $('#ChangeStage #deal_id').val(ad);
            //$('#ChangeStage #deal_stage').val(stage);
            $(document).find('#deal_stages').val(stage);
            $('#ChangeStage').modal('show');
        });
	
    });


	</script>
</div>
<div id="ChangeStage" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
		<div>
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h3>Change Stage</h3>
		<?php echo form_open('lead/Pipeline/changestage',array('class'=>'addForm','id'=>'change_stage','enctype'=>'multipart/form-data','autocomplete'=>'off')); ?>
				<div class="form-group">
					<input type="hidden" name="deal_id" id="deal_id">
					<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-th-list"></i></span>
						<select class="form-control" name="deal_stage" id="deal_stages">
							<option value="">Please Select</option>
							<?php if (isset($stages)) {
								foreach ($stages as $value) { ?>
								 <option value="<?php echo $value['pstage_id']; ?>"><?php echo $value['pstage_name']; ?></option>
							<?php 	}
							} ?>
								 <option value="5" class="assign" >Ready to Assign</option>
						 
						</select>
					</div>
					<span id="deal_stage_err" class="invalidText"></span>
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