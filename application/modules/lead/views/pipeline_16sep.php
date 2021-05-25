<?php $this->load->view('include/header.php'); ?>
<style>
	
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
										<h3>Pipeline</h3>
										<div id="errorMsg" class="alert alert-danger hide">
                      					<strong>Warning!</strong>
                    					</div>
                    					<div id="successMsg" class="alert alert-success hide">
                      					<strong>Success!</strong>
                    					</div>
										<div class="pileLine pi-stage">
											<ul>
											<?php if ($stages) {
													foreach ($stages as $value) { 
														if($value['last_stage']==0){
														?>
												<li>
													<h3><?php echo $value['pstage_name']; ?><?php if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) { ?><a href="javascript:;" class='changename' stage-nm="<?php echo $value['pstage_id']; ?>"><span class="glyphicon glyphicon-pencil" style="float: right"></span></a><?php }?><span class="glyphicon glyphicon-menu-right"></span></h3>
											<?php if ($data) {
														foreach ($data as $row) { 
														$stage=$this->generalmodel->getSingleRowById('pipelinstage', 'pstage_id', $row['pstage_id'], $returnType = 'array');
															if($stage['pstage_name']==$value['pstage_name']){ 
																$createdate= strtotime($row['stagemodifydate']);
																$today = strtotime(date('Y-m-d H:i:s'));
																$age= ceil((($today-$createdate)/3600)/24);
															 ?>
															<div class="pipeBox">
																
																<h4><a href="<?php echo site_url('lead/deal/dealdetail/').encoding($row['deal_id']); ?>" target="_blank"><?php echo $row['deal_title']; ?></a></h4>
																<p>Business-<a href="<?php echo site_url('lead/business/viewbusiness_detail/').encoding($row['business_id']); ?>" target="_blank"><?php echo $row['business_name']; ?></a><br><p>Contact-<a href="<?php echo site_url('lead/contact/contactdetail/').encoding($row['contact_id']); ?>" target="_blank"><?php echo $row['contact_person']; ?></a> <br> Expected Close- <b><?php echo date('m/d/Y',strtotime($row['deal_exp_closedate'])); ?></b> <br> Deal Age - <b><?php echo $age; ?> Day(s)</b> </p>
																<div class="footPipe">
																	<a href="#ChangeStage" class="ChangeStage" data-id="<?php echo $row['deal_id']; ?>" data-stage="<?php echo $stage['pstage_id']; ?>">Change Stage</a>
																</div>
															</div>
													<?php	} }
													}else{ ?> 
															<div class="pipeBox">No Record Found</div>
													<?php } ?>
													
												</li>
													
												<?php }else{ ?>
												<li>
													<h3><?php echo $value['pstage_name']; ?><?php if ($this->userdata['dept_id']==1) { ?><a href="javascript:;" class='changename' stage-nm="<?php echo $value['pstage_id']; ?>"><span class="glyphicon glyphicon-pencil" style="float: right"></span></a><?php } ?><span class="glyphicon glyphicon-menu-right"></span></h3>
											<?php if ($data) {
														foreach ($data as $row) { 
														$stage=$this->generalmodel->getSingleRowById('pipelinstage', 'pstage_id', $row['pstage_id'], $returnType = 'array');
															if($stage['pstage_name']==$value['pstage_name']){ 
																$createdate= strtotime($row['stagemodifydate']);
																$today = strtotime(date('Y-m-d H:i:s'));
																$age= ceil((($today-$createdate)/3600)/24);
															 ?>
															<div class="pipeBox">
																
																<h4><a href="<?php echo site_url('lead/deal/dealdetail/').encoding($row['deal_id']); ?>" target="_blank"><?php echo $row['deal_title']; ?></a></h4>
																<p>Business-<a href="<?php echo site_url('lead/business/viewbusiness_detail/').encoding($row['business_id']); ?>" target="_blank"><?php echo $row['business_name']; ?></a><br><p>Contact-<a href="<?php echo site_url('lead/contact/contactdetail/').encoding($row['contact_id']); ?>" target="_blank"><?php echo $row['contact_person']; ?></a> <br> Expected Close- <b><?php echo date('m/d/Y',strtotime($row['deal_exp_closedate'])); ?></b> <br> Deal Age - <b><?php echo $age; ?> Day(s)</b> </p>
																<div class="footPipe">

																	<?php $this->userdata = $this->session->userdata('userdata'); if($this->userdata['dept_id']==2 || $this->userdata['dept_id']==10){ ?>
																	<a href="#ChangeStage" class="ChangeStage" data-id="<?php echo $row['deal_id']; ?>" data-stage="<?php echo $stage['pstage_id']; ?>">Convert</a>

																<?php	} ?>
																</div>
															</div>
													<?php	} }
													}else{ ?> 
															<div class="pipeBox">No Record Found</div>
													<?php } ?>
													
												</li>
											<?php 	}	} 
											}else{ ?>
													<li><h3>No Record Found</h3></li>
													
										<?php	} ?>
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

       $('body').on('click','.changename',function(){
           var name = $(this).attr('stage-nm');
           // console.log(name,'ad');
            $('#changename #stage_id').val(name);
            //$('#ChangeStage #deal_stage').val(stage);
            $('#changename').modal('show');
        });
	
    });

    $(document).on('click','.stop',function(){
		$(document).find('#change_stage')[0].reset();
    	$('#ChangeStage').modal('hide');
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
					<input type="hidden" name="app_activity_title" value="test">
					<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-th-list"></i></span>
						<select class="form-control" name="deal_stage" id="deal_stages">
							<option value="">Please Select</option>
							<?php if (isset($stages)) {
								foreach ($stages as $value) { 
									if($value['last_stage']==0){ ?>
								 <option value="<?php echo $value['pstage_id']; ?>"><?php echo $value['pstage_name']; ?></option>

								<?php }else{ ?>

								 <option value="<?php echo $value['pstage_id']; ?>" class="assign" ><?php echo $value['pstage_name']; ?></option>
								<?php }
									?>
							<?php 	}
							} ?>
						 
						</select>
					</div>
					<span id="deal_stage_err" class="invalidText"></span>
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
					<button class="cenle stop" type="button">Cancel</button>
				</div>
			<?php echo form_close(); ?>
		</div>
    </div>

  </div>
</div>


<div id="changename" class="modal fade modelin" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
		<div>
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h3>Change Stage Name</h3>
		<?php echo form_open('lead/Pipeline/changename',array('class'=>'addForm','id'=>'change_name','enctype'=>'multipart/form-data','autocomplete'=>'off')); ?>
					<input type="hidden" name="stage_id" id="stage_id">	
						<div class="input-group"><span class="input-group-addon">
							<i class="glyphicon glyphicon-user"></i></span>
							<input name="name" id="name" class="form-control" placeholder="Name" value="" type="text"  autocomplete="off"> 
						</div>
						<span id="name_err" class="invalidText"></span>
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