<?php $this->load->view('include/header.php'); 
$this->userdata = $this->session->userdata('userdata');
$perms=explode(",",$this->userdata['upermission']); ?>

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
								<?php $cat=$this->generalmodel->getSingleRowById('product_category', 'prod_cat_id', $cate['prod_cat_parent_category_id'], $returnType = 'array');
								 ?>

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
  <div class="panel-heading">  <h4>Product Category:  
  	<?php if(in_array('PRODC_E',$perms)){?><a href="<?php echo site_url() ?>product/product/editcategory/<?php echo $cate['prod_cat_id']; ?>" style="float: right;"><span class="glyphicon glyphicon-pencil"></span> Edit </a><?php }?>
<a href="javascript:window.history.go(-1);" style="float: right; margin-right: 35px;">Back</a>
  </h4> </div>
   <div class="panel-body">
       
    <div class="box box-info">
        
            <div class="box-body">
                    
            <div class="col-sm-9">
         
<div class="col-sm-5 col-xs-6 tital ">Category Name:</div><div class="col-sm-7"><?php echo $cate['prod_cat_name']; ?></div>
     <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Parent Category:</div><div class="col-sm-7"> <?php echo $cat['prod_cat_name']; ?></div>
  <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Status:</div><div class="col-sm-7"><?php if($cate['prod_cat_status']==0){echo "Inactive";}else{echo "Active";} ?></div>

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
	<?php $this->load->view('include/crop_image_modal'); ?>	
<?php $this->load->view('include/footer.php'); ?>
</div>
</body>
</html>