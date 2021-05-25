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
								<?php $cate=$this->generalmodel->getSingleRowById('product_category', 'prod_cat_id', $product['prod_cat_id'], $returnType = 'array');
								$sup=$this->generalmodel->getSingleRowById('supplier', 'supplier_id', $product['supplier_id'], $returnType = 'array');
								$chek=$this->generalmodel->getSingleRowById('form_manager', 'frm_manager_id', $product['ck_form_id'], $returnType = 'array'); 
								$type=$this->generalmodel->getSingleRowById('user_role', 'urole_id', $product['urole_id'], $returnType = 'array'); ?>

								<div class="filterBody">
									<div class="filterDiv">
										
										<div class="row">
		
       <div class="col-md-12 ">

<div class="panel panel-default">
  <div class="panel-heading">  <h4>Product  
  	<?php if(in_array('PROD_E', $perms)){?><a href="<?php echo site_url('product/product/editproduct/').encoding($product['prod_id']); ?>" style="float: right;"><span class="glyphicon glyphicon-pencil"></span> Edit</a><?php }?>
  	<a href="javascript:window.history.go(-1);" style="float: right; margin-right: 35px;">Back</a>
  </h4> </div>
   <div class="panel-body">
       
    <div class="box box-info">
        
            <div class="box-body">
                     <div class="col-sm-3">
                     <div align="center"> 
                     	<?php if($product['prod_image']){ ?>
							<img src="<?php echo base_url() ?>uploads/product_img/<?php echo $product['prod_image']; ?>" id="profile-image1" class="img-responsive">
						<?php }else{ ?>
							<img src="<?php echo base_url() ?>assets/img/avtr.png" id="profile-image1" class="img-responsive">
						<?php } ?>
														<!-- <img alt="User Pic" src="https://x1.xingassets.com/assets/frontend_minified/img/users/nobody_m.original.jpg" id="profile-image1" class="img-responsive"> 
                 -->
                <input id="prod_img" name="profilepicture" class="hidden imgInput" type="file">
                <input id="product_img_h" type="hidden" name="profilepicture_h">
<!-- <div style="color:#999;"><a href="#" id="profilePicBtn"> click here to change profile image </a></div>
   <h5 style="color:#00b1b1;"><?php echo $product['product_name']; ?></h5> -->
<hr>
                
                     </div>
              
              <!-- /input-group -->
            </div>
            <div class="col-sm-9">
         
<div class="col-sm-5 col-xs-6 tital ">Product SKU:</div><div class="col-sm-7"> <?php echo $product['product_name']; ?></div>
     <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Product Name:</div><div class="col-sm-7 col-xs-6 "><?php echo $product['product_sku']; ?></div>
  <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Category:</div><div class="col-sm-7"> <?php echo $cate['prod_cat_name']; ?></div>
  <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Supplier:</div><div class="col-sm-7"><?php echo $sup['supplier_bname']; ?></div>

  <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Type:</div><div class="col-sm-7"><?php echo $product['type']; ?></div>

  <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Wholesale Price:</div><div class="col-sm-7"><?php setlocale(LC_MONETARY,"en_US"); echo money_format("$%i", $product['wsale_price']).' USD'; ?></div>

 <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Licensee Price:</div><div class="col-sm-7"><?php setlocale(LC_MONETARY,"en_US"); echo money_format("$%i", $product['l_price']).' USD'; ?></div>

 <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Industry Association Price:</div><div class="col-sm-7"><?php setlocale(LC_MONETARY,"en_US"); echo money_format("$%i", $product['ia_price']).' USD'; ?></div>

 <div class="clearfix"></div>
<div class="bot-border"></div>
<div class="col-sm-5 col-xs-6 tital ">Consumer Price:</div><div class="col-sm-7"><?php setlocale(LC_MONETARY,"en_US"); echo money_format("$%i", $product['c_price']).' USD'; ?></div>
 <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Discount:</div><div class="col-sm-7"><?php echo $product['prod_dis']; ?>%</div>
 <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Discount Start Dates:</div><div class="col-sm-7"><?php if($product['prod_dis_enddate']=='0000-00-00 00:00:00'){echo '-';}else{echo date('m-d-Y',strtotime($product['prod_dis_startdate']));} ?></div>
 <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Discount End Dates:</div><div class="col-sm-7"><?php if($product['prod_dis_enddate']=='0000-00-00 00:00:00'){echo '-';}else{echo date('m-d-Y',strtotime($product['prod_dis_enddate']));} ?></div>
 <div class="clearfix"></div>
<div class="bot-border"></div>
<div class="col-sm-5 col-xs-6 tital ">Status:</div><div class="col-sm-7"><?php if($product['prod_status']==1){echo "Active";}else{ echo "Inactive";} ?></div>
 <div class="clearfix"></div>
<div class="bot-border"></div>
<div class="col-sm-5 col-xs-6 tital ">Checkout Form Name:</div><div class="col-sm-7"><?php echo $chek['frm_template_name']; ?></div>
<div class="clearfix"></div>
<div class="bot-border"></div>
<div class="col-sm-5 col-xs-6 tital ">Intended Type:</div><div class="col-sm-7"><?php echo $type['rolename']; ?></div>

			  
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
	<input type="hidden" id="uploadtype" value="" >
<input type="hidden" id="directmove" value="product_img" table="product" field="prod_image" data-id="<?php echo $product['prod_id']; ?>" name-id="prod_id" >
<?php $this->load->view('include/crop_image_modal'); ?>
<?php $this->load->view('include/footer.php'); ?>
</div>
</body>
</html>