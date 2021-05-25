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
										
										
	
										<div class="row">
		
       <div class="col-md-12 ">

<div class="panel panel-default">
  <div class="panel-heading">  <h4>Contact  <a href="<?php echo site_url('lead/contact/editcontact/').encoding($data['contact_id']); ?>" style="float: right;"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
  <a href="javascript:window.history.go(-1);" style="float: right; margin-right: 35px;">Back</a>
</h4> </div>
   <div class="panel-body">
       
    <div class="box box-info">
        
            <div class="box-body">
                    
            <div class="col-sm-9">
         
<div class="col-sm-5 col-xs-6 tital ">Name:</div><div class="col-sm-7"><?php echo $data['contact_person']; ?></div>
     <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Business Name:</div><div class="col-sm-7 col-xs-6 "><a href="<?php echo site_url('lead/business/viewbusiness_detail/').encoding($data['business_id']); ?>" target="_blank"><?php echo $data['business_name']; ?></a></div>
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