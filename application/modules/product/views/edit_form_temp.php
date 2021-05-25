<?php $this->load->view('include/header.php'); ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>includes/css/tether.min.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>includes/css/form_builder.css" />
<style>
    .tm-form .ui-sortable-handle {
    width: 100% !important;
    height: auto !important;
}

@media (max-width: 991px) {
    .form_builder .bal_builder {
    padding: 15px !important;
        margin: 0 10px !important;
}
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
                                <?php $this->load->view('include/leftsidebar.php'); ?>
                                <div class="filterBody">
                                    <div class="filterDiv">
                                        <h3>Edit Form Template</h3>
                                        <div id="errorMsg" class="alert alert-danger hide"></div>
                                        <div id="successMsg" class="alert alert-success hide"></div>
                                        <!-- <form class="addForm"> -->
                                        <?php  echo form_open('product/formtemplate/update_frm_template',array('class'=>'addForm','id'=>'update_frm_template','autocomplete'=>'off')); ?>
                                            <input type="hidden" id="temp_id" name="temp_id" value="<?php echo  $data['frm_manager_id']; ?>" />
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group required">
                                                        <label>Template Name</label>
                                                        <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                            <input  name="frm_temp_name" id="frm_temp_name" class="form-control" placeholder="Form Template Name" value="<?php echo  $data['frm_template_name']; ?>" type="text">
                                                        </div>
                                                        <span id="temp_name_err" class="invalidText"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <span id="html_err" class="invalidText"></span>

                <div class="form_builder">

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
                            <li class="form_bal_filefield">
                                <a href="javascript:;">File <i class="fa fa-plus-circle pull-right"></i></a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="col-md-5 bal_builder tm-form"  id="abcDiv">
                    <div class="form_builder_area">
<?php echo  $data['editable_html']; ?>
                    </div>
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

<input type="hidden" id="tmp_id" value="<?php echo $data['frm_manager_id']; ?>" />
<p style="display:none" id="EditView_html_div"></p>            
            
            <button id="btnclick" type="button" class="addNew update_html mt-2 pull-right">Submit</button>
                       
        </div>


<?php echo form_close();  ?>
                                            
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
<script>

// $(document).ready(function () {
//     getPreview();
// });

</script>
</body>
</html>


