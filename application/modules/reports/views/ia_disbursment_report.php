<?php $this->load->view('include/header');
$urole = $this->userdata['urole_id'];
$dept = $this->userdata['dept_id'];

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
                                        <h3>Monthly Summary</h3>
<div id="errorMsg" class="alert alert-danger hide"></div>
<div id="successMsg" class="alert alert-success hide"></div>                                        
                                        <div class="filterTable exportButton proTable">
                                        <?php echo form_open('reports/export_ia_disburse'); ?>
                                        <div class="row">
                                            <div class="col-md-8 formDate">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Start Date</label>
                                                            <div class="dateInput">
                                                                <span class="input-group-addon">
                                                                <i class="glyphicon glyphicon-calendar"></i></span>
                                                                <input name="startdate" id="startdate" class="form-control monthyear_from_dis_next" type="text"   autocomplete="off" placeholder="Start Date" value="<?php echo date('m/Y',strtotime('last month')); ?>"  >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>End Date</label>
                                                            <div class="dateInput">
                                                                <span class="input-group-addon">
                                                                <i class="glyphicon glyphicon-calendar"></i></span>
                                                                <input name="enddate" id="enddate" class="form-control monthyear monthyear_to" type="text"   autocomplete="off" placeholder="End Date" value="<?php echo date('m/Y',strtotime('last month')); ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="aplyReset">
                                                    <button type="button" class="addNew" id="applyfilter">Apply</button>
                                                    <button type="button" class="addNew mt00" id="clearfilter" style="display:none;">Reset</button>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="figurNuber">
                                                   <h4>Table Totals</h4>
                                                   <p>Total Reconciled: <b id="totalRecon">0</b></p> 
                                                   <p>Total Disbursed: <b id="totalDisburs">0.00</b></p> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row formDate">
                                            <div class="col-md-8">
                                            </div>
                                            <div class="col-md-4 reportExpo">
                                                <?php if($urole==1 && ($dept==2 ||$dept==3 || $dept==10)){ ?><button type="button" class="addNew uppp" id="updade_selected">Update Selected</button><?php } ?>
                                                <button type="submit" class="addNew">Export</button>
                                            </div>
                                        </div>
                                        <?php echo form_close(); ?>


                                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                                <thead>
                                                    <tr class="n-blue-bg">
                                                        <?php if($urole==1 && ($dept==2 ||$dept==3 || $dept==10)){ ?><th><input type="checkbox" id="checkall" /></th><?php } ?>
                                                        <th>Title</th>
                                                        <th>Resource ID</th>
                                                        <th>Industry Association</th>
                                                        <th>Business </th>
                                                        <th>Total Orders</th>
                                                        <th>Total Amount</th>
                                                        <th>Total to Disburs</th>
                                                        <th>Status</th>
                                                        <th>Modified Date</th>
                                                        <?php if($urole==1 && ($dept==2 ||$dept==3 || $dept==10)){ ?><th>Action</th><?php } ?>
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
var ia = "<?php echo $this->session->userdata['iaid']; ?>";
function loadTableData(){
    var url = site_url+"reports/ia_disbursment_report_ajax";
    $('#example').dataTable( {
        "serverSide": true,
        "ajax" : url,
        "order": [[1, "asc" ]],
        "lengthMenu": [20, 50, 100, 200,250,500],
        "aoColumnDefs": [
          { "bSortable": false, "aTargets": [ 0 ],}
        ],
        
    } );    
}
loadTableData();
getTotals('<?php echo date("m/Y",strtotime('last month')); ?>','<?php echo date("m/Y",strtotime('last month')); ?>',ia);

function getTotals(st_date,end_date,ia){
    $.ajax({
        url: site_url+"reports/ia_monthly_disbrs_total",
        type: "POST",
        data:{'ia':ia,'st_date':st_date,'end_date':end_date},
        dataType: "json",
        // beforeSend:function(){
        //     ajaxindicatorstart();
        // },
        success: function(res) {
            // ajaxindicatorstop();
            $('#totalRecon').html(res.reconcile);
            $('#totalDisburs').html(res.disburse);
        }
    });     
}

function filterData(){
    var st_date = $('#startdate').val();
    var end_date = $('#enddate').val();
    $('#example').DataTable().destroy();

    var url = site_url+"reports/filter_ia_disburs";
    $('#example').dataTable({
        "serverSide": true,
        "responsive": true,
        "order": [[1, "asc" ]],
        "lengthMenu": [20, 50, 100, 200,250,500 ],
        "ajax": {
          "url": url,
          "type": "POST",
          "data":{'ia':ia,'st_date':st_date,'end_date':end_date},
        },
        "aoColumnDefs": [
          { "bSortable": false, "aTargets": [ 0 ] }
        ],
    });           

    getTotals(st_date,end_date,ia);
}

//filterData();
$(document).on('click','#applyfilter',function(){
    filterData();
    $('#clearfilter').css('display','inline-block');
});

$(document).on('click','#clearfilter',function(){
    $('#example').DataTable().destroy();
    $('#startdate').val('<?php echo date("m/Y",strtotime('last month')); ?>');
    $('#enddate').val('<?php echo date("m/Y",strtotime('last month')); ?>');
    loadTableData();
    getTotals('<?php echo date("m/Y",strtotime('last month')); ?>','<?php echo date("m/Y",strtotime('last month')); ?>',ia);
    $('#clearfilter').css('display','none');
});

$(document).on('click','.updatestatus',function(){
    var url = $(this).attr('link');
    var amt = $(this).attr('amt');

    $.ajax({
        url: url,
        dataType: "json",
        type: "POST",
        data:{'amt':amt},
        beforeSend:function(){
            ajaxindicatorstart();
        },
        success: function(res) {
            ajaxindicatorstop();
            if(res.success){
                $('#errorMsg').addClass('hide').removeClass('show');
                $('#successMsg').addClass('show').removeClass('hide').html(res.msg);
                setTimeout( function(){ 
                    $('#errorMsg , #successMsg').addClass('hide').removeClass('show').fadeOut('slow');
                }  , 10000 );
                filterData();
            }else{
                $('#errorMsg').addClass('hide').removeClass('show');
                $('#successMsg').addClass('show').removeClass('hide').html(res.msg).fadeOut('slow');
            }
        }
    });    
});

$(document).on('click','#checkall',function(){
    if($(this).prop('checked')){
$('.check').prop('checked',true);
    }else{
      $('.check').prop('checked',false);
    }
});

$(document).on('click','#updade_selected',function(){
    var lic = [];
    var dates = [];
    var amt = [];
    $('.check').each(function(){
        if($(this).prop('checked')){
         lic.push($(this).attr('id'));
         dates.push($(this).attr('dates'));
         amt.push($(this).val());
        }
    });    
    if(lic.length=='0')
    {
        $('#errorMsg').addClass('show').removeClass('hide').html('Please Select atleast one record');
        allIsOk = false;
        return false;
    }else{
        var url = site_url+'reports/update_selected_ia_disburse';

        $.ajax({
            url: url,
            dataType: "json",
            type: "POST",
            data:{'amt':amt,'ia':lic,'dates':dates},
            beforeSend:function(){
                ajaxindicatorstart();
            },
            success: function(res) {
                ajaxindicatorstop();
                if(res.success){
                    $('#checkall').prop('checked',false);
                    $('#errorMsg').addClass('hide').removeClass('show');
                    $('#successMsg').addClass('show').removeClass('hide').html(res.msg);
                    setTimeout( function(){ 
                        $('#errorMsg , #successMsg').addClass('hide').removeClass('show').fadeOut('slow');
                    }  , 10000 );
                    filterData();
                }else{
                    $('#errorMsg').addClass('hide').removeClass('show');
                    $('#successMsg').addClass('show').removeClass('hide').html(res.msg).fadeOut('slow');
                }
            }
        });            
    }
});

</script>
</body>
</html>