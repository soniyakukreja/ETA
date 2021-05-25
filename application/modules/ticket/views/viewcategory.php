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
								
								<?php $cat=$this->generalmodel->getSingleRowById('ticket_category', 'tic_cat_id', $cate['tic_parent_id'], $returnType = 'array');
								 ?>

								<div class="filterBody">
									<div class="filterDiv">
									
									<div class="row">
		
       <div class="col-md-12 ">

<div class="panel panel-default">
  <div class="panel-heading">  <h5 style="font-weight: 600;">Ticket Category  
  <!-- edit for user  -->
  	 <a href="<?php echo site_url('ticket/editcategory/').encoding($cate['tic_cat_id']); ?>" style="float: right;"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
  	 <a href="javascript:window.history.go(-1);" style="float: right; margin-right: 35px;">Back</a> 
                                                                    </h5> </div>
   <div class="panel-body">
       
    <div class="box box-info">
        
            <div class="box-body">
                     
            <div class="col-sm-9">
         
<div class="col-sm-5 col-xs-6 tital " >Category Name:</div><div class="col-sm-7 col-xs-6 "><?php echo $cate['tic_cat_name']; ?></div>
     <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital " >Parent Category:</div><div class="col-sm-7"> <?php echo $cat['tic_cat_name']; ?></div>
  <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital " >Status:</div><div class="col-sm-7"><?php if($cate['tic_cat_status']==0){echo "Inactive";}else{echo "Active";} ?></div>

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
	<?php $this->load->view('include/crop_image_modal'); ?>	
<?php $this->load->view('include/footer.php'); ?>
</div>
</body>
</html>