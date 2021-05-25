<?php $this->load->view('include/header.php'); ?>


<div class="dashSection">
    <div class="dashCard">
        
        <div class="dashBody">
            <div class="innerDiv">
                <div class="cartDetail">
                    <div class="filterBody">
                        <div class="filterDiv">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="bilDetail changScc">
                                        <h1><?php echo $pa['pb_name']; ?></h1>
                                        <p class="lead">
                                        <!-- by
                                        <?php echo $pa['firstname'].' '.$pa['lastname']; ?> -->
                                        </p>

                                        <hr>

                                        <!-- Date/Time January 1, 2017 at 12:00 PM  -->
                                        <p>Posted on <?php echo date('M d, Y', strtotime($pa['pb_createdate'])).' at '.date('g:i a', strtotime($pa['pb_createdate'])) ; ?></p>
                                        <hr>

                                        <?php if($pa['pb_featureimage']){ ?>
                                            <img src="<?php echo base_url() ?>uploads/page_feature_img/<?php echo $pa['pb_featureimage']; ?>" id="profile-image1" class="img-responsive" style="width: 1200px; height: 250px;">
                                        <?php }else{ ?>
                                            <img src="<?php echo base_url() ?>assets/img/avtr.png" id="profile-image1" class="img-responsive">
                                        <?php } ?>
                                        <div class="descripTab">
                                            <?php echo $pa['pb_description']; ?>
                                        </div>
                                            <?php if(!empty($pa['pb_cta_label'])){ ?>
                                        	<a href="<?php echo $pa['pb_cta_text']; ?>" class="addNew" <?php if($pa['pb_target']){echo 'target='.$pa['pb_target']; } ?> style="float: left; margin-top: 30px;"><?php echo $pa['pb_cta_label']; ?></a>
                                        <?php } ?>
                                            <a href="javascript:window.history.go(-1);" class="addNew" style="float: left; margin: 30px;">Back</a>
                                        	
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php $this->load->view('include/rightsidebar.php'); ?>

                        <!-- <div class="bannerDiv">
                            <img src="http://45.33.105.92/ETA/uploads/banner/1597919217right_banner.jpeg" alt="Ads">
                        </div> -->
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php $this->load->view('include/footer.php'); ?>

