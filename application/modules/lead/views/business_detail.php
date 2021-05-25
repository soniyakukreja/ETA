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


<?php 
if($contact){
$ci=0;
$di = 1;
foreach ($contact as $key=>$row) { 
	
	$cLoad = true;
if($key>0){
 $cid = $contact[$key-1]['cid']; 
 if($cid==$row['cid']){ $cLoad = false; }
}
if($cLoad){
	
	$ci++;
	$di = 1;
?>

<div class="row">

<div class="col-md-12 ">

<div class="panel panel-default">
<div class="panel-heading">  <h4>Contact <?php echo $ci; ?> <a href="<?php echo site_url('lead/contact/editcontact/').encoding($row['contact_id']); ?>" style="float: right;"><span class="glyphicon glyphicon-pencil"></span> Edit
</a></h4> </div>
<div class="panel-body">

<div class="box box-info">

<div class="box-body">

<div class="col-sm-9">
         
<div class="col-sm-5 col-xs-6 tital ">Name:</div><div class="col-sm-7"><a target="_blank" href="<?php echo site_url('lead/contact/contactdetail/').encoding($row['contact_id']); ?>"><?php echo $row['contact_person']; ?></a></div>
     <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Phone Number:</div><div class="col-sm-7"> <?php echo $row['contact_phone']; ?></div>
  <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Email Address:</div><div class="col-sm-7"><?php echo $row['contact_email']; ?></div>

  <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Note:</div><div class="col-sm-7"><?php echo $row['contact_notes']; ?></div>



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

<?php } 
if(!empty($row['deal_id'])){
 ?>
<!-- DEAL -->
<div class="row">
<div class="col-md-12 ">

<div class="panel panel-default">
  <div class="panel-heading ">  <h4>Deal <?php echo $di; ?>  <a href="<?php echo site_url('lead/deal/editdeal/').encoding($row['deal_id']); ?>" style="float: right;"><span class="glyphicon glyphicon-pencil"></span> Edit</a></h4>
   </div>
   <div class="panel-body">
       
    <div class="box box-info">
        
            <div class="box-body">
                    
            <div class="col-sm-9">
     
<div class="col-sm-5 col-xs-6 tital ">Deal Title:</div><div class="col-sm-7"> <?php echo $row['deal_title']; ?></div>
     <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Deal Value:</div><div class="col-sm-7"><?php 
echo numfmt_format_currency($this->fmt,$row['deal_value'], "USD");
 ?></div>

  <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Stage:</div><div class="col-sm-7"><?php echo $row['pstage_name']; ?></div>

  <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Age:</div><div class="col-sm-7"><?php $createdate= strtotime($row['stagemodifydate']);
						$today = strtotime(date('Y-m-d H:i:s'));
						$age= ceil((($today-$createdate)/3600)/24); echo $age.' Day(s)';  ?></div>

 <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Expected Close date:</div><div class="col-sm-7"><?php if($row['deal_exp_closedate'] !='0000-00-00 00:00:00'){ echo date('m/d/Y',strtotime($row['deal_exp_closedate'])); } ?></div>

 <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Additional Details:</div><div class="col-sm-7"><?php echo $row['deal_notes']; ?></div>

            <!-- <hr style="margin:5px 0 5px 0;"> -->
            <!-- /.box-body -->
          </div>
        </div>
    </div> 
    </div>
</div>  
</div>
</div>

<?php $di++;
}
}	
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