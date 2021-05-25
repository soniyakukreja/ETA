<?php $this->load->view('include/header');  $lic = $this->uri->segment(3); ?>
<style>
    .dataTables_wrapper {
    padding-top: 0px;
}
   .reportExpo {
    position: relative;
}
.reportExpo button.addNew {
    position: inherit !important;
    right: 0px;
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
                                        <h3>Transaction History</h3>
                                        <div class="filterTable exportButton proTable">
                                        <?php echo form_open('reports/export_lic_trans_summ'); ?>
                                        <div class="row">
                                            <div class="col-md-8 formDate">
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label>Start Date</label>
                                                            <div class="dateInput">
                                                                <span class="input-group-addon">
                                                                <i class="glyphicon glyphicon-calendar"></i></span>
                                                                <input name="startdate" id="startdate" class="form-control monthyear_from" type="text" onkeydown="event.preventDefault()"  autocomplete="off" placeholder="Start Date"  >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label>End Date</label>
                                                            <div class="dateInput">
                                                                <span class="input-group-addon">
                                                                <i class="glyphicon glyphicon-calendar"></i></span>
                                                                <input name="enddate" id="enddate" class="form-control monthyear monthyear_to" type="text" onkeydown="event.preventDefault()"  autocomplete="off" placeholder="End Date" >
                                                            </div>
                                                        </div>
                                                    </div>                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12 col-xs-12">
                                                <div class="figurNuber">
                                                   <h4>Table Totals</h4>
                                                   <p>Total Reconciled: <b id="ord_total">0</b></p> 
                                                   <p>Total Disbursed: <b id="disburse">0.00</b></p> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row formDate">
                                            <div class="col-md-8 col-sm-12">
                                                <div class="aplyReset">
                                                    <button class="addNew" type="button" id="applyfilter">Apply</button>
                                                    <button class="addNew" type="button" id="clearfilter" style="display:none;">Reset</button>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-xs-12 reportExpo">
                                                <button type="submit" class="addNew">Export</button>
                                            </div>
                                        </div>
                                        <?php echo form_close(); ?>
                                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                                <thead>
                                                    <tr class="n-blue-bg">
                                                        <th>Order Date and Time</th>
                                                        <th>Licensee</th>
                                                        <th>Industry Association</th>
                                                        <th>Consumer</th>
                                                        <th>Total Amount</th>
                                                        <th>Order Total</th>
                                                        <th>Order Total to Disburse</th>
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
    var url = "<?php echo site_url('reports/lic_transaction_summary_ajax/') ?>";
    $('#example').dataTable( {
        "serverSide": true,
        "ajax" : url,
        "order": [[0, "asc" ]],
        "lengthMenu": [20, 50, 100, 200,250,500],
    } );    
}
loadTableData();
getTotals('<?php echo $lic; ?>');

function getTotals(lic_id,st_date,end_date){
    $.ajax({
        url: "<?php echo site_url('reports/filter_lic_transac_summ_total/'); ?>",
        type: "POST",
        data:{'lic_id':lic_id,'st_date':st_date,'end_date':end_date},
        dataType: "json",
        beforeSend:function(){
            ajaxindicatorstart();
        },
        success: function(res) {
            ajaxindicatorstop();
            $('#ord_total').html(res.ord_total);
            $('#disburse').html(res.disburse_total);
        }
    });     
}

function filterData(){
    // var supplier = $('#supplier :selected').val();
    // var consumer = $('#consumer :selected').val();
    var st_date = $('#startdate').val();
    var end_date = $('#enddate').val();
    var lic_id = '<?php echo $lic; ?>';

    $('#example').DataTable().destroy();

    var url = "<?php echo site_url('reports/filter_lic_transac_summry/'); ?>";
    $('#example').dataTable({
        "serverSide": true,
        "responsive": true,
        "order": [[0, "asc" ]],
        "lengthMenu": [20, 50, 100, 200,250,500 ],
        "ajax": {
          "url": url,
          "type": "POST",
          "data":{'lic_id':lic_id,'st_date':st_date,'end_date':end_date},
        }
    });   
    getTotals(lic_id,st_date,end_date);
}


$(document).on('click','#applyfilter',function(){
    filterData();
    $('#clearfilter').css('display','inline-block');
});

$(document).on('click','#clearfilter',function(){
    $('#example').DataTable().destroy();
    loadTableData();
    getTotals('<?php echo $lic; ?>');
    $('#clearfilter').css('display','none');
    $('#startdate,#enddate').val('');
});

</script>
</body>
</html>