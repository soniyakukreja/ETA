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
								<?php $this->load->view('include/leftsidebar.php'); ?>
								<div class="filterBody">
									<div class="filterDiv">
								<?php $city=$this->generalmodel->getSingleRowById('country', 'id', $data['business_country'], $returnType = 'array');
?>
										

										<div class="row">
		
       <div class="col-md-12 ">

<div class="panel panel-default">
  <div class="panel-heading">  <h4>Business  <a href="<?php echo site_url('lead/business/editbusiness/').encoding($data['business_id']); ?>" style="float: right;"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
<a href="javascript:window.history.go(-1);" style="float: right; margin-right: 35px;">Back</a>
  </h4> </div>
   <div class="panel-body">
       
    <div class="box box-info">
        
            <div class="box-body">
                    
            <div class="col-sm-9">
         
<div class="col-sm-5 col-xs-6 tital ">Business Name:</div><div class="col-sm-7"><?php echo $data['business_name']; ?></div>
     <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Phone Number:</div><div class="col-sm-7 col-xs-6 "><?php echo $data['business_phonenumber']; ?></div>
  <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Website:</div><div class="col-sm-7"> <?php echo $data['business_website']; ?></div>
  <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Street Address 1:</div><div class="col-sm-7"><?php echo $data['business_street1']; ?></div>

  <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Street Address 2:</div><div class="col-sm-7"><?php echo $data['business_street2']; ?></div>
<div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Suburb/Province:</div><div class="col-sm-7"><?php echo $data['business_suburb']; ?></div>
<div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">State/Region:</div><div class="col-sm-7"><?php echo $data['business_state']; ?></div>
<div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Postcode:</div><div class="col-sm-7"><?php echo $data['business_postalcode']; ?></div>
<div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Country:</div><div class="col-sm-7"><?php echo $city['country_name']; ?></div>
<div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Notes:</div><div class="col-sm-7"><?php echo $data['business_notes']; ?></div>



            <!-- <hr style="margin:5px 0 5px 0;"> -->
    
              



            <!-- /.box-body -->
          </div>
          <!-- /.box -->

        </div>
       
            
    </div> 
    </div>
</div>  
</div></div>


										<?php $i = 0;
											if($contact){
												foreach ($contact as $row) { 
													$data=$this->generalmodel->getSingleRowById('contact', 'contact_id', $row['contact_id'], $returnType = 'array'); $i++;
													?>
													
													<div class="row">
		
       <div class="col-md-12 ">

<div class="panel panel-default">
  <div class="panel-heading">  <h4>Contact <?php echo $i; ?> <a href="<?php echo site_url('lead/contact/editcontact/').encoding($data['contact_id']); ?>" style="float: right;"><span class="glyphicon glyphicon-pencil"></span> Edit
                                                                        </a></h4> </div>
   <div class="panel-body">
       
    <div class="box box-info">
        
            <div class="box-body">
                    
            <div class="col-sm-9">
         
<div class="col-sm-5 col-xs-6 tital ">Name:</div><div class="col-sm-7"><a target="_blank" href="<?php echo site_url('lead/contact/contactdetail/').encoding($data['contact_id']); ?>"><?php echo $data['contact_person']; ?></a></div>
     <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Phone Number:</div><div class="col-sm-7"> <?php echo $data['contact_phone']; ?></div>
  <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Email Address:</div><div class="col-sm-7"><?php echo $data['contact_email']; ?></div>

  <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Note:</div><div class="col-sm-7"><?php echo $data['contact_notes']; ?></div>



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
								

											<?php 	}	
											}
										 ?>
	




									
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
<?php $this->load->view('include/footer.php'); ?>
</div>
</body>
</html>