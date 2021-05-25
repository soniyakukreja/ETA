<?php $this->load->view('include/header'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/chart/css/style.css'); ?>">
<style>
 
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
                                                            <input name="startdate" id="startdate" class="form-control datepicker datepicker_from" type="text" onkeydown="event.preventDefault()" autocomplete="off" value="<?php echo date('m/01/Y'); ?>">
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
                                                    <button class="addNew" id="clearfilter" style="display:none;">Clear</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="newestTicket filterTable chengHead">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h3>My Newest Tickets</h3>
                                                <table id="newest_ticket" class="table table-striped table-bordered dataTable">
                                                    <thead>
                                                        <tr>
                                                            <th>Ticket Name</th>
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
                                                <h3>Pending Audits</h3>
                                                <table id="pending_audit" class="table table-striped table-bordered dataTable">
                                                    <thead>
                                                        <tr>
                                                            <th>Product Name</th>
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
                                        </div>
                                    </div>

                                    <div class="filterTable chengHead">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h4 class="complint">Compliance and Tickets <span>Showing of all time</span></h4>
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
                                                <div class="pandu">
                                                    <h3>Newest Tickets</h3>
                                                    <table id="compTicket" class="table table-striped table-bordered dataTable">
                                                        <thead>
                                                            <tr>
                                                                <th>Ticket Name</th>
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
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h3 class="mt75">Tickets per Category</h3>
                                                        <div class="chatrtDiv" id="ticketpercat_chart">
                                                            <canvas id="ticket_per_cat"></canvas>
                                                            <div id="ul_li"></div>   
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h3 class="mt75">Tickets per Staff</h3>
                                                        <div class="chatrtDiv" id="ticketperstaff_chart">
                                                            <canvas id="ticket_per_staff"></canvas>   
                                                            <div id="ul_li"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="filterTable chengHead">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h4 class="complint">Accounts<span>Showing of month</span></h4>
                                                <div class="compTik compFull">
                                                    <ul>
                                                        <li>
                                                            <span id="amount_reconcile">$0.00 USD</span>
                                                            <p>Amount Reconciled</p>
                                                        </li>
                                                        <li>
                                                            <span id="amount_disburse">$0.00 USD</span>
                                                            <p>Amount to Disburse</p>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <h3 class="mt75">Products Sold per Category/Subcategory</h3>
                                                <div class="chatrtDiv">
                                                    <canvas id="productbarChart"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="filterTable chengHead">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="pandu">
                                                    <h3>Top Industry Associations</h3>
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
                                            <div class="col-md-6">
                                                <div class="pandu">
                                                    <h3>Top Consumers</h3>
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
                                        </div>
                                    </div>
                                    <div class="filterTable chengHead">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="pandu">
                                                    <h3>Top Suppliers</h3>
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

                                    <h4 class="complint mt20">KAMs &AMP; CSRs</h4>
                                    <div class="filterTable chengHead">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="pandu">
                                                    <h3>Upcoming MBRs<span class="shohin" id="mbr_note">Showing upcoming 2 weeks</span></h3>
                                                    <table id="upcoming_mbrs" class="table table-striped table-bordered dataTable">
                                                        <thead>
                                                            <tr>
                                                                <th>Industry Association Name</th>
                                                                <th>Due Date</th>
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
                                                    <h3>Upcoming QBRs<span class="shohin" id="qbr_note">Showing upcoming 2 weeks</span></h3>
                                                    <table id="upcoming_qbrs" class="table table-striped table-bordered dataTable">
                                                        <thead>
                                                            <tr>
                                                                <th>Industry Association Name</th>
                                                                <th>Due Date</th>
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
                                                    <h3>Upcoming ABRs<span class="shohin" id="abr_note">Showing upcoming 2 weeks</span></h3>
                                                    <table id="upcoming_abrs" class="table table-striped table-bordered dataTable">
                                                        <thead>
                                                            <tr>
                                                                <th>Industry Association Name</th>
                                                                <th>Due Date</th>
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
                                                    <h3>Expiring Licenses<span class="shohin" id="exp_lic_note">Showing upcoming 2 months</span></h3>
                                                    <table id="expiring_licensee" class="table table-striped table-bordered dataTable">
                                                        <thead>
                                                            <tr>
                                                                <th>Licensee Name</th>
                                                                <th>Due Date</th>
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
<script type="text/javascript" src="<?php echo base_url('includes/js/dashboard_functions.js'); ?>"></script>

<script type="text/javascript" src="<?php echo base_url('includes/js/cto_lic.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('includes/js/chart/productbar.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('includes/js/chart/sales_peruser.js'); ?>"></script>
</div>
</body>
</html>