<?php $this->load->view('include/header'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/chart/css/style.css'); ?>">

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
                                <div class="filterBody w100">
                                    <div class="filterDiv">
                                        <div class="row formDate">
                                            <div class="colmd2">
                                                <h4>Filter all</h4>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Start Date</label>
                                                            <div class="dateInput">
                                                                <span class="input-group-addon">
                                                                <i class="glyphicon glyphicon-calendar"></i></span>
                                                                <input name="startdate" id="startdate" class="form-control datepicker dash_datepicker_from" type="text" onkeydown="event.preventDefault()" autocomplete="off" value="<?php echo date('m/01/Y'); ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>End Date</label>
                                                            <div class="dateInput">
                                                                <span class="input-group-addon">
                                                                <i class="glyphicon glyphicon-calendar"></i></span>
                                                                <input name="enddate" id="enddate" class="form-control datepicker datepicker_to" type="text" onkeydown="event.preventDefault()" autocomplete="off" value="<?php echo date('m/t/Y'); ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <button class="addNew" id="applyfilter">Apply</button>
                                                        <button class="addNew" id="clearfilter" style="display:none;">Reset</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="newestTicket filterTable chengHead">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h3>Newest Tickets</h3>
                                                    <table id="newest_ticket" class="table table-striped table-bordered dataTable">
                                                        <thead>
                                                            <tr>
                                                                <th>Ticket Number</th>
                                                                <th>Category</th>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td colspan="4">No Record Found</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-md-6">
                                                    <h4 class="complint">Compliance and Tickets <br><span class="msgNote">Showing of all time</span></h4>
                                                    <div class="compTik">
                                                        <ul>
                                                            <li>
                                                                <span id="openComp">0</span>
                                                                <p>Open<br>Tickets</p>
                                                            </li>
                                                            <li>
                                                                <span id="pendingComp">0</span>
                                                                <p>Pending<br>Tickets</p>
                                                            </li>
                                                            <li>
                                                                <span id="resolvedComp">0</span>
                                                                <p>Resolved<br>Tickets</p>
                                                            </li>
                                                            <li>
                                                                <span id="spamComp">0</span>
                                                                <p>Spam<br>Tickets</p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="filterTable chengHead">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h4 class="complint">Accounts<br><span class="msgNote">Showing of month</span></h4>
                                                    <div class="compTik compFull">
                                                        <ul>
                                                            <li>
                                                                <span id="amount_reconcile">0</span>
                                                                <p>Amount Reconciled</p>
                                                            </li>
                                                            <li>
                                                                <span id="amount_disburse">0</span>
                                                                <p>Amount to Disburse</p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <h3 class="mt75">Tickets per Category</h3>
                                                    <div class="chatrtDiv" id="ticketpercat_chart">
                                                        <canvas id="ticket_per_cat"></canvas>

                                                        <div id="ul_li"></div>
                                                    </div>
                                                    <div id="ticketpercat_404" style="display:none;">No New Tickets Generated</div>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="filterTable chengHead">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="pandu">
                                                        <h3 class="tp-heading">Top Licensees</h3>
                                                        <table id="top_lic" class="table table-striped table-bordered dataTable">
                                                            <thead>
                                                                <tr>
                                                                    <th>Licensees Name</th>
                                                                    <th>Amount of Orders</th>
                                                                    <th>Number of Products</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr>
                                                                <td colspan="4">No Record Found</td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="pandu">
                                                        <h3 class="tp-heading">Top Industry Associations</h3>
                                                        <table id="top_ia" class="table table-striped table-bordered dataTable">
                                                            <thead>
                                                                <tr>
                                                                    <th>Industry Associations Name</th>
                                                                    <th>Amount of Orders</th>
                                                                    <th>Number of Products</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr>
                                                                <td colspan="4">No Record Found</td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="filterTable chengHead">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="pandu">
                                                        <h3 class="tp-heading">Top Consumers</h3>
                                                        <table id="top_consumers" class="table table-striped table-bordered dataTable">
                                                            <thead>
                                                                <tr>
                                                                    <th>Consumer Name</th>
                                                                    <th>Amount of Orders</th>
                                                                    <th>Number of Products</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr>
                                                                <td colspan="4">No Record Found</td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="pandu">
                                                        <h3 class="tp-heading">Top Suppliers</h3>   
                                                        <table id="top_suppliers" class="table table-striped table-bordered dataTable">
                                                            <thead>
                                                                <tr>
                                                                    <th>Supplier Name</th>
                                                                    <th>Amount of Orders</th>
                                                                    <th>Number of Products</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr>
                                                                <td colspan="4">No Record Found</td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="filterTable chengHead">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="pandu">
                                                        <h3 class="tp-heading">Reconciliation Summary</h3>
                                                        <table id="reconciliation" class="table table-striped table-bordered dataTable horizontal_scroll">
                                                            <thead>
                                                                <tr>
                                                                    <?php if($this->userdata['urole_id'] ==1){ ?><th>Licensee</th><?php } ?>
                                                                    <?php if($this->userdata['urole_id'] ==1 || $this->userdata['urole_id'] ==2){ ?><th>Industry Association</th><?php } ?>
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
                                                                <td colspan="4">No Record Found</td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="pandu">
                                                        <h3 class="tp-heading">Licensee Disbursement Report</h3>   
                                                        <table id="lic_disburse" class="table table-striped table-bordered dataTable horizontal_scroll">
                                                            <thead>
                                                                <tr>
                                                                    <th>Title</th>
                                                                    <th>Resource ID</th>
                                                                    <th>Licensee</th>
                                                                    <th>Business</th>
                                                                    <th>Total Orders</th>
                                                                    <th>Total Amount</th>
                                                                    <th>Total to Disburse</th>
                                                                    <th>Status</th>
                                                                    <th>Modified Date</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr>
                                                                <td colspan="4">No Record Found</td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="filterTable chengHead">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="pandu">
                                                        <h3 class="tp-heading">IA Disbursement Report</h3>   
                                                        <table id="ia_disburse" class="table table-striped table-bordered dataTable horizontal_scroll">
                                                            <thead>
                                                                <tr>
                                                                    <th>Title</th>
                                                                    <th>Resource ID</th>
                                                                    <th>Industry Association</th>
                                                                    <th>Business</th>
                                                                    <th>Total Orders</th>
                                                                    <th>Total Amount</th>
                                                                    <th>Total to Disburse</th>
                                                                    <th>Status</th>
                                                                    <th>Modified Date</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr>
                                                                <td colspan="4">No Record Found</td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <h3 class="mt75">Products Sold per Category/Subcategory</h3>
                                                    <div class="chatrtDiv" >
                                                        <canvas id="productbarChart"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="filterTable chengHead">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="pandu">
                                                        <h3 class="mt20">Sales per User Type</h3>
                                                        <div class="graphCode">
                                                            <canvas id="sales_per_user"></canvas>
                                                        </div>
                                                    </div>    
                                                </div>
                                               
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
<script type="text/javascript" src="<?php echo base_url('assets/chart/js/Chart.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('includes/js/chart/pie.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('includes/js/dashboard_functions.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('includes/js/chart/productbar.js'); ?>"></script>
<script>


newest_ticket();
compliance_count();
top_suppliers();
top_consumers();
top_ia();
top_lic();
load_accountdata();
ticket_percat();
sales_per_user();
producbycat();
ia_disburse();
lic_disburse();
reconciliation();
//================pie charts================

$(document).on('click','#applyfilter',function(){
  $('.dataTable').DataTable().destroy();
  $('.msgNote').hide();

  f_newest_ticket();
  compliance_count();
  top_suppliers();
  top_consumers();
  top_ia();
  top_lic();
  load_accountdata();
  ticket_percat();
  producbycat();
  sales_per_user('true');
  ia_disburse();
  lic_disburse();
  reconciliation();
  $('#clearfilter').css('display','inline-block');
});

$(document).on('click','#clearfilter',function(){

  var date = new Date();
  var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
  var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
   
  var st_date = ((firstDay.getMonth() > 8) ? (firstDay.getMonth() + 1) : ('0' + (firstDay.getMonth() + 1))) + '/' + ((firstDay.getDate() > 9) ? firstDay.getDate() : ('0' + firstDay.getDate())) + '/' + firstDay.getFullYear();
  var end_date = ((lastDay.getMonth() > 8) ? (lastDay.getMonth() + 1) : ('0' + (lastDay.getMonth() + 1))) + '/' + ((lastDay.getDate() > 9) ? lastDay.getDate() : ('0' + lastDay.getDate())) + '/' + lastDay.getFullYear();

$('#enddate').datepicker('destroy');
$('#enddate').datepicker({
   startDate:st_date, 
   autoclose:true,
   format: 'mm/dd/yyyy', 
});

  $('#startdate').val(st_date);
  $('#enddate').val(end_date);
  $('.dataTable').DataTable().destroy();
  $('.msgNote').show();

  newest_ticket();
  compliance_count();
  top_suppliers();
  top_consumers();
  top_ia();
  top_lic();
  load_accountdata();
  ticket_percat();
  sales_per_user();
  producbycat();
  ia_disburse();
  lic_disburse();
  reconciliation();

  $('#clearfilter').css('display','none');
});

</script>

<script type="text/javascript" src="<?php //echo base_url('includes/js/chart/productbar.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('includes/js/chart/sales_peruser.js'); ?>"></script>
</div>
</body>
</html>