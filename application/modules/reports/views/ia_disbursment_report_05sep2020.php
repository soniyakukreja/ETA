<?php $this->load->view('include/header'); $ia = $this->uri->segment(3); ?>
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
                                        <h3>Monthly Summary</h3>
                                        <div class="filterTable exportButton">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="row">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="figurNuber">
                                                   <h4>Table Totals</h4>
                                                   <p>Total Reconcile: <b id="totalRecon">0</b></p> 
                                                   <p>Total Disburse: <b id="totalDisburs">0.00</b></p> 
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
                                                                <input name="startdate" id="startdate" class="form-control monthyear_from" type="text" onkeydown="event.preventDefault()"  autocomplete="off" placeholder="Start Date">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>End Date</label>
                                                            <div class="dateInput">
                                                                <span class="input-group-addon">
                                                                <i class="glyphicon glyphicon-calendar"></i></span>
                                                                <input name="enddate" id="enddate" class="form-control monthyear monthyear_to" type="text" onkeydown="event.preventDefault()"  autocomplete="off" placeholder="End Date" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <button class="addNew" id="applyfilter">Apply</button>
                                                        <button class="addNew" id="clearfilter" style="display:none;">Reset</button>
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
                                                        <th>Total Orders</th>
                                                        <th>Total Amount</th>
                                                        <th>Total to Disburs</th>
                                                        <th>Status</th>
                                                        <th>Modified Date</th>
                                                        <th>Action</th>
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
    var url = "<?php echo site_url('reports/ia_disbursment_report_ajax'); ?>";
    $('#example').dataTable( {
        "serverSide": true,
        "ajax" : url,
        "order": [[0, "asc" ]],
        "lengthMenu": [20, 50, 100, 200,250,500],
    } );    
}
loadTableData();
getTotals();


function getTotals(st_date,end_date){
    $.ajax({
        url: "<?php echo site_url('reports/ia_getTotal_monthly_disbrs'); ?>",
        type: "POST",
        data:{'st_date':st_date,'end_date':end_date},
        dataType: "json",
        beforeSend:function(){
            ajaxindicatorstart();
        },
        success: function(res) {
            ajaxindicatorstop();
            $('#totalRecon').html(res.reconcile);
            $('#totalDisburs').html(res.disburse);
        }
    });     
}

function filterData(){
    var st_date = $('#startdate').val();
    var end_date = $('#enddate').val();
    $('#example').DataTable().destroy();

    var url = "<?php echo site_url('reports/filter_ia_disburs/'); ?>";
    $('#example').dataTable({
        "serverSide": true,
        "responsive": true,
        "order": [[0, "desc" ]],
        "lengthMenu": [20, 50, 100, 200,250,500 ],
        "ajax": {
          "url": url,
          "type": "POST",
          "data":{'st_date':st_date,'end_date':end_date},
        }
    });   
    getTotals(st_date,end_date);

}


$(document).on('click','#applyfilter',function(){
    filterData();
    $('#clearfilter').css('display','inline-block');
});

$(document).on('click','#clearfilter',function(){
    $('#example').DataTable().destroy();
    $('#startdate, #enddate').val('');
    loadTableData();
    getTotals();
    $('#clearfilter').css('display','none');
});

</script>
</body>
</html>