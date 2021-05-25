<?php $this->load->view('include/header'); ?>
<style>
    .expBtn button.addNew {
    top: unset;
}
</style>
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
                                        <h3>Supplier Sales Report</h3>
                                        <div class="filterTable exportButton expBtn proTable">
                                        <?php echo form_open('reports/export_sup_salesreport'); ?>                                            
                                        <div class="row">
                                            <div class="col-md-8 col-xs-12">
                                                <div class="row">
                                                    <div class="col-md-4 col-xs-12">
                                                        <div class="form-group">
                                                            <label>Filter By Licensee</label>
                                                            <div class="dateInput">
                                                                <select class="form-control js-example-basic-single" name="lic" id="lic"  autocomplete="off">
                                                                  <option value="">Select a Licensee</option>
                                                                  <?php if(!empty($licensee)){  foreach($licensee as $value){ ?>
                                                                    <option value="<?php echo $value['user_id']; ?>"><?php echo $value['username']; ?></option>
                                                                  <?php } } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                
                                                    <div class="col-md-4 col-xs-12">
                                                        <div class="form-group">
                                                            <label>Filter By IA</label>
                                                            <div class="dateInput">
                                                                <select class="form-control js-example-basic-single getia_cons" name="ia" id="ia"  autocomplete="off">
                                                                  <option value="">First Select Licensee</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-xs-12">
                                                        <div class="form-group">
                                                            <label>Filter By Consumer</label>
                                                            <div class="dateInput">
                                                                <select class="form-control js-example-basic-single consumerdropdown" name="consumer" id="consumer"  autocomplete="off">
                                                                  <option value="">First Select IA</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-xs-12">
                                                <div class="figurNuber">
                                                   <h4>Table Totals</h4>
                                                   <p>Total Qty: <b id="qtyTotal">0</b></p> 
                                                   <p>Total Amount: <b id="amtTotal">0.00</b></p> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row formDate">
                                            <div class="col-md-8 ">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Start Date</label>
                                                            <div class="dateInput">
                                                                <span class="input-group-addon">
                                                                <i class="glyphicon glyphicon-calendar"></i></span>
                                                                <input name="startdate" id="startdate" class="form-control datepicker datepicker_from" type="text" onkeydown="event.preventDefault()"  autocomplete="off" placeholder="Start Date"  >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>End Date</label>
                                                            <div class="dateInput">
                                                                <span class="input-group-addon">
                                                                <i class="glyphicon glyphicon-calendar"></i></span>
                                                                <input name="enddate" id="enddate" class="form-control datepicker datepicker_to" type="text" onkeydown="event.preventDefault()"  autocomplete="off" placeholder="End Date" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="aplyReset">
                                                    <button class="addNew" type="button" id="applyfilter">Apply</button>
                                                    <button class="addNew" type="button" id="clearfilter" style="display:none;">Reset</button>
                                                </div>
                                            </div>
                                            <div class="col-md-4  reportExpo">
                                                
                                            </div>
                                        </div>
                                        <button class="addNew" type="submit">Export</button>
                                        <?php echo form_close(); ?>
                                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                                <thead>
                                                    <tr class="n-blue-bg">
                                                        <th>Title</th>
                                                        <th>Product SKU</th>
                                                        <th>Product Name</th>
                                                        <th id="prodTypeHead">Product Type</th>
                                                        <th>Supplier</th>
                                                        <th>Unit Sold</th>
                                                        <th>Total Amount</th>
                                                        <th>Revenue</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                  <tr>
                                                    <td>loading...</td>
                                                 </tr>
                                                </tbody>
                                            </table>
                                            <?php /*
                                            <table id="example2" class="table table-striped table-bordered" style="width:100%;display:none;">
                                                <thead>
                                                    <tr class="n-blue-bg">
                                                        <th>Title</th>
                                                        <th>Product SKU</th>
                                                        <th>Product Name</th>
                                                        <th>Product Type</th>
                                                        <th>Supplier</th>
                                                        <th>Unit Sold</th>
                                                        <th>Total Amount</th>
                                                        <th>Revenue</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                  <tr>
                                                    <td>loading...</td>
                                                 </tr>
                                                </tbody>
                                            </table>
                                            */ ?>
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
<script type="text/javascript" src="<?php echo base_url('includes/js/reports_js.js'); ?>"></script>
<script>
function loadTableData(){
    var url = site_url+"reports/sup_sales_data";
    $('#example').dataTable( {
        "serverSide": true,
        "ajax" : url,
        "order": [[0, "asc" ]],
        "lengthMenu": [20, 50, 100, 200,250,500],
        "aoColumnDefs": [
          { "bSortable": false, "aTargets": [ 0 ],
            "targets": [4],
            "visible":  false  
          }
        ],
    });    
}
loadTableData();
getTotals();


function getTotals(lic,ia,consumer,st_date,end_date){
    $.ajax({
        url: site_url+"reports/filter_sup_sales_total",
        type: "POST",
        data:{'lic':lic,'ia':ia,'consumer':consumer,'st_date':st_date,'end_date':end_date},
        dataType: "json",
        // beforeSend:function(){
        //     ajaxindicatorstart();
        // },
        success: function(res) {
            // ajaxindicatorstop();
            $('#qtyTotal').html(res.qty);
            $('#amtTotal').html(res.amount);
        }
    });     
}


function filterData(){
    var lic = $('#lic :selected').val();
    var ia = $('#ia :selected').val();
    var consumer = $('#consumer :selected').val();
    var st_date = $('#startdate').val();
    var end_date = $('#enddate').val();
    $('#example').DataTable().destroy();

    var url = site_url+"reports/filter_sup_sales_data";
    if(lic>0 ||ia>0 ||consumer>0){
        $('#example').dataTable({
            "serverSide": true,
            "responsive": true,
            "order": [[0, "asc" ]],
            "lengthMenu": [20, 50, 100, 200,250,500 ],
            "ajax": {
              "url": url,
              "type": "POST",
              "data":{'lic':lic,'ia':ia,'consumer':consumer,'st_date':st_date,'end_date':end_date},
            }
        });           
    }else{
        $('#example').dataTable({
            "serverSide": true,
            "responsive": true,
            "order": [[0, "asc" ]],
            "lengthMenu": [20, 50, 100, 200,250,500 ],
            "ajax": {
              "url": url,
              "type": "POST",
              "data":{'lic':lic,'ia':ia,'consumer':consumer,'st_date':st_date,'end_date':end_date},
            },
            "aoColumnDefs": [
              { "bSortable": false, "aTargets": [ 0 ],
                "targets": [4],
                "visible":  false  
              }
            ],            
        });         
    }
    getTotals(lic,ia,consumer,st_date,end_date);
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
    $('#lic').val(null).trigger('change');
    $('#ia').html("<option>First Select Licensee</option>").trigger('change');
    $('#consumer').html('<option>First Select IA</option>').trigger('change');
    $('#startdate, #enddate').val('');      
});
 

</script>
</body>
</html>