<?php $this->load->view('include/header'); 
    $ia = $this->uri->segment(3);
?>
<article>
    <content>
        <main>
            <div class="dashSection">
                <div class="dashCard">
                    <div class="dashNav">
                        <?php $this->load->view('include/nav'); ?>
                    </div>
                        <div class="dashBody">
                            <div class="innerDiv">
                                <?php $this->load->view('include/leftsidebar'); ?>
                                <div class="filterBody">
                                    <div class="filterDiv">
                                        <h3>Reconciliation Report</h3>
                                        <div class="filterTable exportButton proTable">
                                    <?php echo form_open('reports/export_ia_reconciliation'); ?>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Filter By Consumer</label>
                                                            <div class="dateInput">
                                                                <select class="form-control js-example-basic-single" name="consumer" id="consumer"  autocomplete="off">
                                                                  <option value="">Select a Consumer</option>
                                                                  <?php if(!empty($consumerlist)){  foreach($consumerlist as $value){ ?>
                                                                    <option value="<?php echo $value['user_id']; ?>"><?php echo $value['username']; ?></option>
                                                                  <?php } } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Filter By Supplier</label>
                                                            <div class="dateInput">
                                                                <select class="form-control js-example-basic-single" name="supplier" id="supplier"  autocomplete="off">
                                                                  <option value="">Select a Supplier</option>
                                                                  <?php if(!empty($supplier_list)){  foreach($supplier_list as $value){ ?>
                                                                    <option value="<?php echo $value['supplier_id']; ?>"><?php echo $value['business_name']; ?></option>
                                                                  <?php } } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Filter By Category</label>
                                                            <div class="dateInput">
                                                                <select class="form-control js-example-basic-single" name="prod_cat" id="prod_cat"  autocomplete="off">
                                                                  <option value="">Select a Category</option>
                                                                  <?php if(!empty($prod_cat_list)){  foreach($prod_cat_list as $value){ ?>
                                                                    <option value="<?php echo $value['prod_cat_id']; ?>"><?php echo $value['prod_cat_name']; ?></option>
                                                                  <?php } } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>                                                  
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="figurNuber">
                                                    <h4>Table Totals</h4>
                                                   <p>Total Orders: <b id="qtyTotal">0</b></p> 
                                                   <p>Total Amount: <b id="amtTotal">0.00</b></p> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Filter By Product</label>
                                                            <div class="dateInput">
                                                                <select class="form-control js-example-basic-single prod_dropdown" name="product" id="product"  autocomplete="off">
                                                                  <option value="">First Select Supplier</option>
                                                                  <?php if(!empty($prod_list)){  foreach($prod_list as $value){ ?>
                                                                    <option value="<?php echo $value['prod_id']; ?>"><?php echo $value['product_name']; ?></option>
                                                                  <?php } } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Filter By Product Type</label>
                                                            <div class="dateInput">
                                                                <select class="form-control js-example-basic-single" name="prod_type" id="prod_type"  autocomplete="off">
                                                                  <option value="">Select a product Type</option>
                                                                  <option value="Standard">Standard</option>
                                                                  <option value="Audit">Audit</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                                        
                                        <div class="row formDate">
                                            <div class="col-md-8">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Start Date</label>
                                                            <div class="dateInput">
                                                                <span class="input-group-addon">
                                                                <i class="glyphicon glyphicon-calendar"></i></span>
                                                                <input name="startdate" id="startdate" class="form-control monthyear_from" type="text" onkeydown="event.preventDefault()"  autocomplete="off" placeholder="Start Date" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>End Date</label>
                                                            <div class="dateInput">
                                                                <span class="input-group-addon">
                                                                <i class="glyphicon glyphicon-calendar"></i></span>
                                                                <input name="enddate" id="enddate" class="form-control monthyear monthyear_to" type="text" onkeydown="event.preventDefault()"  autocomplete="off" placeholder="End Date">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="aplyReset">
                                                    <button class="addNew" type="button" id="applyfilter">Apply</button>
                                                    <button class="addNew" type="button" id="clearfilter" style="display:none;">Reset</button>
                                                </div>
                                            </div> 
                                            
                                            <div class="col-md-4 reportExpo">
                                                <button class="addNew">Export</button>
                                            </div>
                                        </div>
                                        <?php echo form_close(); ?>
                                        <div class="table-responsive expoTable">
                                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                                <thead>
                                                    <tr class="n-blue-bg">
                                                        <th>Consumer</th>
                                                        <th>Supplier</th>
                                                        <th>Category</th>
                                                        <th>Product</th>
                                                        <th>Product Type</th>
                                                        <th>Total Orders</th>
                                                        <th>Total Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                  <tr>
                                                    <td>loading...</td>
                                                 </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        </div>
                                    </div>
                                    <?php $this->load->view('include/rightsidebar'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </content>
    </article>
    <?php $this->load->view('include/footer'); ?>

</div>
<script>
function loadTableData(){
    var url = "<?php echo site_url('reports/ia_reconciliation_report_ajax');?>";
    $('#example').dataTable( {
        "serverSide": true,
        "ajax" : url,
        "order": [[0, "asc" ]],
        "lengthMenu": [20, 50, 100, 200,250,500],
    } );    
}
loadTableData();

var cid = $('#consumer :selected').val();
var supplier = $('#supplier :selected').val();
var category = $('#prod_cat :selected').val();
var prod = $('#product :selected').val();
var prodType = $('#prod_type :selected').val();

getTotals(cid,supplier,category,prod,prodType);


function filterData(){
    var st_date = $('#startdate').val();
    var end_date = $('#enddate').val();
    var cid = $('#consumer :selected').val();
    var supplier = $('#supplier :selected').val();
    var category = $('#prod_cat :selected').val();
    var prod = $('#product :selected').val();
    var prodType = $('#prod_type :selected').val();
    
     
    $('#example').DataTable().destroy();

    var url = "<?php echo site_url('reports/filter_ia_reconciliation/'); ?>";
    $('#example').dataTable({
        "serverSide": true,
        "responsive": true,
        "order": [[0, "asc" ]],
        "lengthMenu": [20, 50, 100, 200,250,500 ],
        "ajax": {
          "url": url,
          "type": "POST",
          "data":{'cid':cid,'supplier':supplier,'category':category,'prod':prod,'prodType':prodType,'st_date':st_date,'end_date':end_date},
        }
    });   
    getTotals(cid,supplier,category,prod,prodType);

}


function getTotals(cid,supplier,category,prod,prodType,st_date,end_date){
    
    $.ajax({
        url: "<?php echo site_url('reports/filter_ia_reconciliation_total/'); ?>",
        type: "POST",
        data:{'cid':cid,'supplier':supplier,'category':category,'prod':prod,'prodType':prodType,'st_date':st_date,'end_date':end_date},
        dataType: "json",
        // beforeSend:function(){
        //     ajaxindicatorstart();
        // },
        success: function(res) {
            // ajaxindicatorstop();
            $('#qtyTotal').html(res.total_orders);
            $('#amtTotal').html(res.total_amount);
        }
    });     
}

$(document).on('click','#applyfilter',function(){
    filterData();
    $('#clearfilter').css('display','inline-block');
});

$(document).on('click','#clearfilter',function(){
    $('#example').DataTable().destroy();
    loadTableData();
    getTotals();
    $('#clearfilter').css('display','none');
    $('#consumer, #supplier,#prod_cat,#product,#prod_type').val(null).trigger('change');
    $('#startdate, #enddate').val('');

});
</script>
<script src="<?php echo base_url('includes/js/reports_js.js') ?>"></script>
</body>
</html>