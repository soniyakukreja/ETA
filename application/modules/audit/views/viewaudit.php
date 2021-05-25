<?php $this->load->view('include/header.php'); 
$this->userdata = $this->session->userdata('userdata');
?>
<style>
	.expBtn a.addNew {
    position: inherit;
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
							
								
								<div class="filterBody">
									<div class="filterDiv">
										
                    				
										<div class="row">
		
       <div class="col-md-12 ">

<div class="panel panel-default">
  <div class="panel-heading">  <h4>Audit  
<a href="javascript:window.history.go(-1);" style="float: right;">Back</a>
  </h4> </div>
   <div class="panel-body">
       
    <div class="box box-info">
        
            <div class="box-body">
                    <div class="row">
            <div class="col-sm-9">
<div class="row">
<div class="col-sm-5 col-xs-6 tital "><h4>Product Detail</h4> </div>
</div>  
<div class="bot-border"></div>        
<div class="col-sm-5 col-xs-6 tital ">Product Name:</div><div class="col-sm-7"><?php echo $ad['prod_name']; ?></div>
     <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Audit Number:</div><div class="col-sm-7"><?php echo $ad['audit_num']; ?></div>
     <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Business Name:</div><div class="col-sm-7"><?php echo $ad['businessname']; ?></div>
     <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Status:</div><div class="col-sm-7">
	<?php if($ad['status']==0){ echo "Pending Audit";}
	else if($ad['status']==1){ echo "Pending Review"; }
	else if($ad['status']==2){ if($this->userdata['urole_id']==4){ echo "Pending Review";}else{  echo "Pending Certificate"; } }
	else if($ad['status']==3){echo "Approved";}elseif($ad['status']==4){echo "Denied";} 
	?></div>
  <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Last Updated Date:</div><div class="col-sm-7">
	<?php if($ad['updatedate']!='0000-00-00 00:00:00'){ 
		$localtimzone =$this->userdata['timezone'];
        $update = gmdate_to_mydate($ad['updatedate'],$localtimzone);
       
        // return date('m/d/Y',strtotime($createdate));
		echo date('m/d/Y',strtotime($update)); 
		// echo date('m/d/Y',strtotime($ad['updatedate']));
	}else{ echo '-';} ?></div>
  <div class="clearfix"></div>
<div class="bot-border"></div>

<?php  if($this->userdata['urole_id']==4){ ?>
<div class="col-sm-5 col-xs-6 tital ">Issue Date:</div><div class="col-sm-7">
	<?php if($ad['issue_date']!='0000-00-00 00:00:00' && $ad['issue_date']!='1970-01-01 00:00:00'){ 
		$localtimzone =$this->userdata['timezone'];
        $issuedate = gmdate_to_mydate($ad['issue_date'],$localtimzone);
       
        // return date('m/d/Y',strtotime($createdate));
		echo date('m/d/Y',strtotime($issuedate)); 
	}else{ echo '-';} 
	?>
		
	</div>
  <div class="clearfix"></div>
<div class="bot-border"></div>


<div class="col-sm-5 col-xs-6 tital ">End Date:</div><div class="col-sm-7">
	<?php if($ad['end_date']!='0000-00-00 00:00:00' && $ad['end_date']!='1970-01-01 00:00:00'){ 
		$localtimzone =$this->userdata['timezone'];
        $enddate = gmdate_to_mydate($ad['end_date'],$localtimzone);
       
       echo date('m/d/Y',strtotime($enddate));
		// echo date('m/d/Y',strtotime($ad['end_date'])); 
	}else{ echo '-';} ?></div>
  <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">File:</div><div class="col-sm-7"><?php if($ad['certificate_file']){ ?><a href="<?php echo base_url('uploads/audit_file/certificate/').$ad['certificate_file']; ?>" class="downldBtn" target="_blank" download="">Download <span class="glyphicon glyphicon-download-alt"></span></a><?php }else{ echo '-'; } ?></div>
<?php } ?>
<?php if($this->userdata['urole_id']==1){ ?>
<div class="col-sm-5 col-xs-6 tital ">Supplier Uploaded File:</div><div class="col-sm-7"><?php if($ad['file']){ ?><a href="<?php echo base_url('uploads/audit_file/').$ad['file']; ?>" class="downldBtn" target="_blank" download="">Download <span class="glyphicon glyphicon-download-alt"></span></a><?php }else{ echo '-'; } ?></div>
<div class="clearfix"></div>
<div class="bot-border"></div>
<div class="col-sm-5 col-xs-6 tital ">File:</div><div class="col-sm-7"><?php if($ad['certificate_file']){ ?><a href="<?php echo base_url('uploads/audit_file/certificate/').$ad['certificate_file']; ?>" class="downldBtn" target="_blank" download="">Download <span class="glyphicon glyphicon-download-alt"></span></a><?php }else{ echo '-'; } ?></div>
<?php }elseif($this->userdata['urole_id']==5){ ?>
<div class="col-sm-5 col-xs-6 tital ">File:</div><div class="col-sm-7"><?php if($ad['file']){ ?><a href="<?php echo base_url('uploads/audit_file/').$ad['file']; ?>" class="downldBtn" target="_blank" download="">Download <span class="glyphicon glyphicon-download-alt"></span></a><?php }else{ echo '-'; } ?></div>
<?php } ?>
  <div class="clearfix"></div>
<div class="bot-border"></div>

          </div>
 </div>
 <hr>
 <div class="mt-20"></div>
        <div class="row blDet">
			<div class="col-sm-9">
				
				<div class="row">
				<div class="col-sm-5 col-xs-6 tital "><h4>Billing  Detail</h4> </div>
				</div>  
				<div class="bot-border"></div> 

				<div class="row vadt">
					<div class="col-md-5 col-sm-5 col-xs-6 tital ">Full Name:</div>
					<div class="col-sm-7 col-sm-7"><?php echo $ad['billing_fname'].' '.$ad['billing_lname']; ?></div>
				</div>  
				<div class="bot-border"></div> 


				<div class="row vadt">
				<div class="col-md-5 col-sm-5 col-xs-6 tital ">Email Address:</div>
				<div class="col-md-7 col-sm-7"><?php echo $ad['billing_email']; ?></div>
				</div>  
				<div class="bot-border"></div> 

				<div class="row vadt">
				<div class="col-md-5 col-sm-5 col-xs-6 tital ">Street Address:</div>
				<div class="col-md-7 col-sm-7"><?php echo $ad['billing_address']; ?></div>
				</div>  
				<div class="bot-border"></div> 

				<div class="row vadt">
				<div class="col-md-5 col-sm-5 col-xs-6 tital ">Street Address:</div>
				<div class="col-md-7 col-sm-7"><?php if(!empty($ad['billing_alt_add'])){ echo $ad['billing_alt_add']; }else{ echo '-'; } ?></div>
				</div>  
				<div class="bot-border"></div> 

				
				<div class="row vadt">
				<div class="col-md-5 col-sm-5 col-xs-6 tital ">Suburb/Province:</div>
				<div class="col-md-7 col-sm-7"><?php echo $ad['billing_city']; ?></div>
				</div>  
				<div class="bot-border"></div> 

				
				<div class="row vadt">
				<div class="col-md-5 col-sm-5 col-xs-6 tital ">State:</div>
				<div class="col-md-7 col-sm-7"><?php echo $ad['billing_state']; ?></div>
				</div>  
				<div class="bot-border"></div> 

				
				<div class="row vadt">
				<div class="col-md-5 col-sm-5 col-xs-6 tital ">Post Code:</div>
				<div class="col-md-7 col-sm-7"><?php echo $ad['billing_postalcode']; ?></div>
				</div>  
				<div class="bot-border"></div>

				<div class="row vadt">
				<div class="col-md-5 col-sm-5 col-xs-6 tital ">Country:</div>
				<div class="col-md-7 col-sm-7"><?php
				$cdata = getcountry_data($ad['billing_country']); echo $cdata['country_name']; 
				?></div>
				</div>  
				<div class="bot-border"></div> 


			</div>
		</div>
 <hr>
        <div class="row">
			<div class="col-sm-9">
				
				<div class="row ">
				<div class="col-sm-5 col-xs-6 tital "><h4>Shipping  Detail</h4> </div>
				</div>  
				<div class="bot-border"></div> 

				<?php 
				if($ad['is_billing_same']==1){
					echo '<div class="row vadt">Shipping Address is same as billing address</div>';
				}else{ ?>
					
				<div class="row vadt">
				<div class="col-md-5 col-sm-5 col-xs-6 tital ">Street Address:</div>
				<div class="col-md-7 col-sm-7"><?php echo $ad['shipping_address']; ?></div>
				</div>  
				<div class="bot-border"></div> 

				<div class="row vadt">
				<div class="col-md-5 col-sm-5 col-xs-6 tital ">Street Address:</div>
				<div class="col-md-7 col-sm-7"><?php if(!empty($ad['shipping_alt_add'])){  echo $ad['shipping_alt_add']; }else{ echo '-'; } ?></div>
				</div>  
				<div class="bot-border"></div> 

				
				<div class="row vadt">
				<div class="col-md-5 col-sm-5 col-xs-6 tital ">Suburb/Province:</div>
				<div class="col-md-7 col-sm-7"><?php echo $ad['shipping_city']; ?></div>
				</div>  
				<div class="bot-border"></div> 

				
				<div class="row vadt">
				<div class="col-md-5 col-sm-5 col-xs-6 tital ">State:</div>
				<div class="col-md-7 col-sm-7"><?php echo $ad['shipping_state']; ?></div>
				</div>  
				<div class="bot-border"></div> 

				
				<div class="row vadt">
				<div class="col-md-5 col-sm-5 col-xs-6 tital ">Post Code:</div>
				<div class="col-md-7 col-sm-7"><?php echo $ad['shipping_postalcode']; ?></div>
				</div>  
				<div class="bot-border"></div>
				 				
				<div class="row vadt">
				<div class="col-md-5 col-sm-5 col-xs-6 tital ">Country:</div>
				<div class="col-md-7 col-sm-7"><?php 
				$cdata = getcountry_data($ad['shipping_country']); echo $cdata['country_name']; 
				?></div>
				</div>  
				

				<?php }	?>
				<div class="bot-border"></div> 

			</div>
		</div>

		<?php  if(!empty($ad['add_fields'])){ ?>
		 <hr>
		<div class="row">
			<div class="col-sm-9">

			<div class="row vadt">
			<div class="col-sm-5 col-xs-6 tital "><h4>Additional Questions</h4></div>
			</div>  
			<div class="bot-border"></div> 
		<?php $add_fields = unserialize($ad['add_fields']); 
			if(!empty($add_fields)){ foreach($add_fields as $key=>$add){
				if($key=='files'){
					foreach($add as $file){
						foreach($file as $k=>$f){
							$link = base_url('uploads/additional_fields/').$f;

						?>
						<div class="row vadt">
						<div class="col-md-5 col-sm-5 col-xs-6 tital "><?php echo $k; ?>:</div>
						<div class="col-md-7 col-sm-7"><?php if(!empty($f)){ echo '<a href="'.$link.'" class="downldBtn" target="_blank" download="">Download <span class="glyphicon glyphicon-download-alt"></span></a>'; }else{ echo 'Not Uploaded'; } ?></div>
						</div>  
						<div class="bot-border"></div>
						<?php 
						}
					}
				}else{
					foreach($add as $k=>$v){
						?>
						<div class="row vadt">
						<div class="col-md-5 col-sm-5 col-xs-6 tital "><?php echo $k; ?>:</div>
						<div class="col-md-7 col-sm-7"><?php if(is_array($v)){ echo $v[0]; }else{ echo $v; } ?></div>
						</div>  
						<div class="bot-border"></div>
						<?php
					}
				}
			} }
		
			?>
		</div></div>
		<?php } ?>


          <!-- /.box -->

        </div>
       
            
    </div> 
    </div>
</div>  
</div>



									
									</div>
									

									<div class="noteDetail">
											<div class="panel panel-default expBtn">
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