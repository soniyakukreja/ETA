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
										<div id="errorMsg" class="alert alert-danger hide">
										  <strong>Warning!</strong>
										</div>
										<div id="successMsg" class="alert alert-success hide">
										  <strong>Success!</strong>
										</div>
						
										<div class="row">
		
       <div class="col-md-12 ">

<div class="panel panel-default">
  <div class="panel-heading">  <h4>Award Level  <a href="<?php echo site_url('user_category/User/editcategory/').encoding($cate['user_cat_id']); ?>" style="float: right;"><span class="glyphicon glyphicon-pencil"></span> Edit </a>
<a href="javascript:window.history.go(-1);" style="float: right; margin-right: 35px;">Back</a>
  </h4> </div>
   <div class="panel-body">
       
    <div class="box box-info">
        
            <div class="box-body">
                    
            <div class="col-sm-9">
         
<div class="col-sm-5 col-xs-6 tital ">Award Name:</div><div class="col-sm-7"><?php echo $cate['user_cat_name']; ?></div>
     <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Intended User:</div><div class="col-sm-7"> <?php echo $cate['rolename']; ?></div>
  <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Status:</div><div class="col-sm-7"><?php if($cate['user_cat_status']=='1'){ echo "Active";}else{echo "Inactive";} ?></div>

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
<?php $this->load->view('include/confim_popup.php'); ?>

</div>
</body>
</html>