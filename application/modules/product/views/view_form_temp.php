<?php $this->load->view('include/header.php'); ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>includes/css/tether.min.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>includes/css/form_builder.css" />

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
                                        <h3>View Form Template:</h3>
<?php  echo form_open('product/formtemplate/add_formtemp',array('class'=>'addForm','id'=>'add_frm_template','autocomplete'=>'off')); ?>
<?php 

echo $data['frm_template_name'];
echo  $data['frm_manager_fields']; 
print_r($data['frm_manager_fields']); 

/*
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group required">
                                                        <label>Template Name</label>
                                                        <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                            <input  name="frm_temp_name" id="frm_temp_name" class="form-control" placeholder="Form Template Name" value="" type="text">
                                                        </div>
                                                        <span id="temp_name_err" class="invalidText"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <span id="html_err" class="invalidText"></span>

            <div class="row">
                <div class="col-sm-3">
                    <nav class="nav-sidebar">
                        <ul class="nav">
                            <li class="form_bal_textfield">
                                <a href="javascript:;">Text Field <i class="fa fa-plus-circle pull-right"></i></a>
                            </li>
                            <li class="form_bal_textarea">
                                <a href="javascript:;">Paragraph <i class="fa fa-plus-circle pull-right"></i></a>
                            </li>
                            <li class="form_bal_select">
                                <a href="javascript:;">Select <i class="fa fa-plus-circle pull-right"></i></a>
                            </li>
                            <li class="form_bal_radio">
                                <a href="javascript:;">Radio Button <i class="fa fa-plus-circle pull-right"></i></a>
                            </li>
                            <li class="form_bal_checkbox">
                                <a href="javascript:;">Checkbox <i class="fa fa-plus-circle pull-right"></i></a>
                            </li>
                            <li class="form_bal_number">
                                <a href="javascript:;">Number <i class="fa fa-plus-circle pull-right"></i></a>
                            </li>

                        </ul>
                    </nav>
                </div>
                <div class="col-md-5 bal_builder">
                    <div class="form_builder_area"></div>
                </div>
                <div class="col-md-4">
                    <div class="col-md-12">
                        <div id="preview" class="preview"></div>
                        <div style="display: none" class="form-group plain_html">
                            <textarea id="txtval" rows="50" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            */ ?>
 </form>
                       


                                            
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

<script src="<?php echo base_url(); ?>includes/js/jquery-ui.min.js"></script>
<script src="<?php echo base_url(); ?>includes/js/tether.min.js"></script>
<script src="<?php echo base_url(); ?>includes/js/form_builder.js"></script>
</body>
</html>


