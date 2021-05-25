<?php $this->load->view('include/header'); ?>
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
                                <div class="aside">
                                <?php $this->load->view('include/leftsidebar'); ?>
                                </div>
                                <div class="filterBody">
                                    <div class="filterDiv">

                                        <h3>Sales Report:</h3>
                                        <div class="filterTable exportButton">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Filter By Supplier</label>
                                                            <div class="dateInput">
                                                                <select class="form-control js-example-basic-single" name="supplier" id="supplier"  autocomplete="off">
                                                                  <option value="">Select a Supplier</option>
                                                                  <?php if(!empty($supplier)){  foreach($supplier as $value){ ?>
                                                                    <option value="<?php echo $value['supplier_id']; ?>"><?php echo $value['username']; ?></option>
                                                                  <?php } } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Filter By Consumer</label>
                                                            <div class="dateInput">
                                                                <select class="form-control js-example-basic-single" name="consumer" id="consumer"  autocomplete="off">
                                                                  <option value="">Select a Consumer</option>
                                                                  <?php if(!empty($consumers)){  foreach($consumers as $value){ ?>
                                                                    <option value="<?php echo $value['user_id']; ?>"><?php echo $value['fullname']; ?></option>
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
                                                   <p>Total Qty: <b id="qtyTotal">0</b></p> 
                                                   <p>Total Amount: <b id="amtTotal">0.00</b></p> 
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
                                                    <div class="col-md-4">
                                                        <button class="addNew" id="applyfilter">Apply</button>
                                                        <button class="addNew" id="clearfilter" style="display:inline-block;">Reset</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <button class="addNew">Export</button>
                                            </div>
                                        </div>

                                            <table id="example" class="table table-striped table-bordered" style="width:100%">
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
    var url = "<?php echo site_url('reports/ia_sales_data/'); ?>";
    $('#example').dataTable( {
        "serverSide": true,
        "ajax" : url,
        "order": [[6, "desc" ]],
        "lengthMenu": [20, 50, 100, 200,250,500],
    } );    
}
loadTableData();
getTotals();


function getTotals(supplier,consumer,st_date,end_date){
    $.ajax({
        url: "<?php echo site_url('reports/filter_ia_sales_total/'); ?>",
        type: "POST",
        data:{'supplier':supplier,'consumer':consumer,'st_date':st_date,'end_date':end_date},
        dataType: "json",
        beforeSend:function(){
            ajaxindicatorstart();
        },
        success: function(res) {
            ajaxindicatorstop();
            $('#qtyTotal').html(res.qty);
            $('#amtTotal').html(res.amount);
        }
    });     
}

function filterData(){
    var supplier = $('#supplier :selected').val();
    var consumer = $('#consumer :selected').val();
    var st_date = $('#startdate').val();
    var end_date = $('#enddate').val();
       
    $('#example').DataTable().destroy();

    var url = "<?php echo site_url('reports/filter_ia_sales_data/'); ?>";
    $('#example').dataTable({
        "serverSide": true,
        "responsive": true,
        "order": [[0, "asc" ]],
        "lengthMenu": [20, 50, 100, 200,250,500 ],
        "ajax": {
          "url": url,
          "type": "POST",
          "data":{'supplier':supplier,'consumer':consumer,'st_date':st_date,'end_date':end_date},
        }
    });   
    getTotals(supplier,consumer,st_date,end_date);

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
    $('#supplier,#consumer').val(null).trigger('change');
    $('#startdate, #enddate').val('');      
});
</script>
</body>
</html>