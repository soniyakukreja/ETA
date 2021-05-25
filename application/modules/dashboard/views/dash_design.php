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
                                <?php //$this->load->view('include/leftsidebar'); ?>
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
                                                                <input name="startdate" id="startdate" class="form-control datepicker datepicker_from" type="text" onkeydown="event.preventDefault()" autocomplete="off" value="08/01/2020">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>End Date</label>
                                                            <div class="dateInput">
                                                                <span class="input-group-addon">
                                                                <i class="glyphicon glyphicon-calendar"></i></span>
                                                                <input name="enddate" id="enddate" class="form-control datepicker datepicker_to" type="text" onkeydown="event.preventDefault()" autocomplete="off" value="08/31/2020">
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
                                                    <table id="example" class="table table-striped table-bordered dataTable">
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
                                                                <td>Ticket Name</td>
                                                                <td>Category</td>
                                                                <td>Status</td>
                                                                <td>
                                                                    <div class="dropdown">
                                                                        <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                            <i class="glyphicon glyphicon-option-vertical"></i>
                                                                        </button>
                                                                        <ul class="dropdown-menu">
                                                                            <li>
                                                                                <a href="#">
                                                                                    <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                                <a href="#">
                                                                                    <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                                <a href="#">
                                                                                    <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                </a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Ticket Name</td>
                                                                <td>Category</td>
                                                                <td>Status</td>
                                                                <td>
                                                                    <div class="dropdown">
                                                                        <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                            <i class="glyphicon glyphicon-option-vertical"></i>
                                                                        </button>
                                                                        <ul class="dropdown-menu">
                                                                            <li>
                                                                                <a href="#">
                                                                                    <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                                <a href="#">
                                                                                    <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                                <a href="#">
                                                                                    <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                </a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Ticket Name</td>
                                                                <td>Category</td>
                                                                <td>Status</td>
                                                                <td>
                                                                    <div class="dropdown">
                                                                        <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                            <i class="glyphicon glyphicon-option-vertical"></i>
                                                                        </button>
                                                                        <ul class="dropdown-menu">
                                                                            <li>
                                                                                <a href="#">
                                                                                    <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                                <a href="#">
                                                                                    <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                                <a href="#">
                                                                                    <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                </a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Ticket Name</td>
                                                                <td>Category</td>
                                                                <td>Status</td>
                                                                <td>
                                                                    <div class="dropdown">
                                                                        <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                            <i class="glyphicon glyphicon-option-vertical"></i>
                                                                        </button>
                                                                        <ul class="dropdown-menu">
                                                                            <li>
                                                                                <a href="#">
                                                                                    <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                                <a href="#">
                                                                                    <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                                <a href="#">
                                                                                    <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                </a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Ticket Name</td>
                                                                <td>Category</td>
                                                                <td>Status</td>
                                                                <td>
                                                                    <div class="dropdown">
                                                                        <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                            <i class="glyphicon glyphicon-option-vertical"></i>
                                                                        </button>
                                                                        <ul class="dropdown-menu">
                                                                            <li>
                                                                                <a href="#">
                                                                                    <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                                <a href="#">
                                                                                    <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                                <a href="#">
                                                                                    <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                </a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-md-6">
                                                    <h3>Pending Audits</h3>
                                                    <table id="example" class="table table-striped table-bordered dataTable">
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
                                                                <td>Ticket Name</td>
                                                                <td>Category</td>
                                                                <td>Status</td>
                                                                <td>
                                                                    <div class="dropdown">
                                                                        <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                            <i class="glyphicon glyphicon-option-vertical"></i>
                                                                        </button>
                                                                        <ul class="dropdown-menu">
                                                                            <li>
                                                                                <a href="#">
                                                                                    <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                                <a href="#">
                                                                                    <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                                <a href="#">
                                                                                    <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                </a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Ticket Name</td>
                                                                <td>Category</td>
                                                                <td>Status</td>
                                                                <td>
                                                                    <div class="dropdown">
                                                                        <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                            <i class="glyphicon glyphicon-option-vertical"></i>
                                                                        </button>
                                                                        <ul class="dropdown-menu">
                                                                            <li>
                                                                                <a href="#">
                                                                                    <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                                <a href="#">
                                                                                    <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                                <a href="#">
                                                                                    <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                </a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Ticket Name</td>
                                                                <td>Category</td>
                                                                <td>Status</td>
                                                                <td>
                                                                    <div class="dropdown">
                                                                        <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                            <i class="glyphicon glyphicon-option-vertical"></i>
                                                                        </button>
                                                                        <ul class="dropdown-menu">
                                                                            <li>
                                                                                <a href="#">
                                                                                    <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                                <a href="#">
                                                                                    <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                                <a href="#">
                                                                                    <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                </a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Ticket Name</td>
                                                                <td>Category</td>
                                                                <td>Status</td>
                                                                <td>
                                                                    <div class="dropdown">
                                                                        <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                            <i class="glyphicon glyphicon-option-vertical"></i>
                                                                        </button>
                                                                        <ul class="dropdown-menu">
                                                                            <li>
                                                                                <a href="#">
                                                                                    <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                                <a href="#">
                                                                                    <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                                <a href="#">
                                                                                    <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                </a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Ticket Name</td>
                                                                <td>Category</td>
                                                                <td>Status</td>
                                                                <td>
                                                                    <div class="dropdown">
                                                                        <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                            <i class="glyphicon glyphicon-option-vertical"></i>
                                                                        </button>
                                                                        <ul class="dropdown-menu">
                                                                            <li>
                                                                                <a href="#">
                                                                                    <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                                <a href="#">
                                                                                    <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                                <a href="#">
                                                                                    <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                </a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </td>
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
                                                                <span>99,999</span>
                                                                <p>Open<br>Tickets</p>
                                                            </li>
                                                            <li>
                                                                <span>99,999</span>
                                                                <p>Pending<br>Tickets</p>
                                                            </li>
                                                            <li>
                                                                <span>99,999</span>
                                                                <p>Resolved<br>Tickets</p>
                                                            </li>
                                                            <li>
                                                                <span>99,999</span>
                                                                <p>Spam<br>Tickets</p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="pandu">
                                                        <h3>Newest Tickets</h3>
                                                        <table id="example" class="table table-striped table-bordered dataTable">
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
                                                                    <td>Ticket Name</td>
                                                                    <td>Category</td>
                                                                    <td>Status</td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                                <i class="glyphicon glyphicon-option-vertical"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu">
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Ticket Name</td>
                                                                    <td>Category</td>
                                                                    <td>Status</td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                                <i class="glyphicon glyphicon-option-vertical"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu">
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Ticket Name</td>
                                                                    <td>Category</td>
                                                                    <td>Status</td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                                <i class="glyphicon glyphicon-option-vertical"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu">
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Ticket Name</td>
                                                                    <td>Category</td>
                                                                    <td>Status</td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                                <i class="glyphicon glyphicon-option-vertical"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu">
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Ticket Name</td>
                                                                    <td>Category</td>
                                                                    <td>Status</td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                                <i class="glyphicon glyphicon-option-vertical"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu">
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h3 class="mt75">Tickets per Category</h3>
                                                            <div class="chatrtDiv">
                                                                <!-- Chat code yaha likh -->
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h3 class="mt75">Tickets per Staff</h3>
                                                            <div class="chatrtDiv">
                                                                <!-- Chat code yaha likh -->
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
                                                                <span>$999,999.00</span>
                                                                <p>Amount Reconciled</p>
                                                            </li>
                                                            <li>
                                                                <span>$999,999.00</span>
                                                                <p>Amount to Disburse</p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <h3 class="mt75">Products Sold per Category/Subcategory</h3>
                                                    <div class="chatrtDiv">
                                                        <!-- Chat code yaha likh -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="filterTable chengHead">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="pandu">
                                                        <h3>Top Licensees</h3>
                                                        <table id="example" class="table table-striped table-bordered dataTable">
                                                            <thead>
                                                                <tr>
                                                                    <th>Licensees Name</th>
                                                                    <th>Amount of Orders</th>
                                                                    <th>Amount of Products</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Name</td>
                                                                    <td>999,999</td>
                                                                    <td>999,999</td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                                <i class="glyphicon glyphicon-option-vertical"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu">
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Name</td>
                                                                    <td>999,999</td>
                                                                    <td>999,999</td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                                <i class="glyphicon glyphicon-option-vertical"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu">
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Name</td>
                                                                    <td>999,999</td>
                                                                    <td>999,999</td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                                <i class="glyphicon glyphicon-option-vertical"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu">
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Name</td>
                                                                    <td>999,999</td>
                                                                    <td>999,999</td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                                <i class="glyphicon glyphicon-option-vertical"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu">
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Name</td>
                                                                    <td>999,999</td>
                                                                    <td>999,999</td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                                <i class="glyphicon glyphicon-option-vertical"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu">
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="pandu">
                                                        <h3>Top Industry Associations</h3>
                                                        <table id="example" class="table table-striped table-bordered dataTable">
                                                            <thead>
                                                                <tr>
                                                                    <th>Industry Associations Name</th>
                                                                    <th>Amount of Orders</th>
                                                                    <th>Amount of Products</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Name</td>
                                                                    <td>999,999</td>
                                                                    <td>999,999</td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                                <i class="glyphicon glyphicon-option-vertical"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu">
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Name</td>
                                                                    <td>999,999</td>
                                                                    <td>999,999</td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                                <i class="glyphicon glyphicon-option-vertical"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu">
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Name</td>
                                                                    <td>999,999</td>
                                                                    <td>999,999</td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                                <i class="glyphicon glyphicon-option-vertical"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu">
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Name</td>
                                                                    <td>999,999</td>
                                                                    <td>999,999</td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                                <i class="glyphicon glyphicon-option-vertical"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu">
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Name</td>
                                                                    <td>999,999</td>
                                                                    <td>999,999</td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                                <i class="glyphicon glyphicon-option-vertical"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu">
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>
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
                                                        <h3>Top Consumers</h3>
                                                        <table id="example" class="table table-striped table-bordered dataTable">
                                                            <thead>
                                                                <tr>
                                                                    <th>Consumer Name</th>
                                                                    <th>Amount of Orders</th>
                                                                    <th>Amount of Products</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Name</td>
                                                                    <td>999,999</td>
                                                                    <td>999,999</td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                                <i class="glyphicon glyphicon-option-vertical"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu">
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Name</td>
                                                                    <td>999,999</td>
                                                                    <td>999,999</td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                                <i class="glyphicon glyphicon-option-vertical"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu">
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Name</td>
                                                                    <td>999,999</td>
                                                                    <td>999,999</td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                                <i class="glyphicon glyphicon-option-vertical"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu">
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Name</td>
                                                                    <td>999,999</td>
                                                                    <td>999,999</td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                                <i class="glyphicon glyphicon-option-vertical"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu">
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Name</td>
                                                                    <td>999,999</td>
                                                                    <td>999,999</td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                                <i class="glyphicon glyphicon-option-vertical"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu">
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="pandu">
                                                        <h3>Top Suppliers</h3>
                                                        <table id="example" class="table table-striped table-bordered dataTable">
                                                            <thead>
                                                                <tr>
                                                                    <th>Supplier Name</th>
                                                                    <th>Amount of Orders</th>
                                                                    <th>Amount of Products</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Name</td>
                                                                    <td>999,999</td>
                                                                    <td>999,999</td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                                <i class="glyphicon glyphicon-option-vertical"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu">
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Name</td>
                                                                    <td>999,999</td>
                                                                    <td>999,999</td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                                <i class="glyphicon glyphicon-option-vertical"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu">
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Name</td>
                                                                    <td>999,999</td>
                                                                    <td>999,999</td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                                <i class="glyphicon glyphicon-option-vertical"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu">
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Name</td>
                                                                    <td>999,999</td>
                                                                    <td>999,999</td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                                <i class="glyphicon glyphicon-option-vertical"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu">
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Name</td>
                                                                    <td>999,999</td>
                                                                    <td>999,999</td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                                <i class="glyphicon glyphicon-option-vertical"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu">
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>
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
                                                        <h3>Upcoming MBRs<span class="shohin">Showing upcoming 2 weeks</span></h3>
                                                        <table id="example" class="table table-striped table-bordered dataTable">
                                                            <thead>
                                                                <tr>
                                                                    <th>Licensee Name</th>
                                                                    <th>Due Date</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Name</td>
                                                                    <td>01/01/2020</td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                                <i class="glyphicon glyphicon-option-vertical"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu">
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Name</td>
                                                                    <td>01/01/2020</td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                                <i class="glyphicon glyphicon-option-vertical"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu">
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Name</td>
                                                                    <td>01/01/2020</td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                                <i class="glyphicon glyphicon-option-vertical"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu">
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Name</td>
                                                                    <td>01/01/2020</td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                                <i class="glyphicon glyphicon-option-vertical"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu">
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Name</td>
                                                                    <td>01/01/2020</td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                                <i class="glyphicon glyphicon-option-vertical"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu">
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="pandu">
                                                        <h3>Upcoming QBRs<span class="shohin">Showing upcoming 2 weeks</span></h3>
                                                        <table id="example" class="table table-striped table-bordered dataTable">
                                                            <thead>
                                                                <tr>
                                                                    <th>Licensee Name</th>
                                                                    <th>Due Date</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Name</td>
                                                                    <td>01/01/2020</td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                                <i class="glyphicon glyphicon-option-vertical"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu">
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Name</td>
                                                                    <td>01/01/2020</td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                                <i class="glyphicon glyphicon-option-vertical"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu">
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Name</td>
                                                                    <td>01/01/2020</td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                                <i class="glyphicon glyphicon-option-vertical"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu">
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Name</td>
                                                                    <td>01/01/2020</td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                                <i class="glyphicon glyphicon-option-vertical"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu">
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Name</td>
                                                                    <td>01/01/2020</td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                                <i class="glyphicon glyphicon-option-vertical"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu">
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>
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
                                                        <h3>Upcoming ABRs<span class="shohin">Showing upcoming 2 weeks</span></h3>
                                                        <table id="example" class="table table-striped table-bordered dataTable">
                                                            <thead>
                                                                <tr>
                                                                    <th>Licensee Name</th>
                                                                    <th>Due Date</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Name</td>
                                                                    <td>01/01/2020</td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                                <i class="glyphicon glyphicon-option-vertical"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu">
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Name</td>
                                                                    <td>01/01/2020</td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                                <i class="glyphicon glyphicon-option-vertical"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu">
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Name</td>
                                                                    <td>01/01/2020</td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                                <i class="glyphicon glyphicon-option-vertical"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu">
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Name</td>
                                                                    <td>01/01/2020</td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                                <i class="glyphicon glyphicon-option-vertical"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu">
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Name</td>
                                                                    <td>01/01/2020</td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                                <i class="glyphicon glyphicon-option-vertical"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu">
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="pandu">
                                                        <h3>Expiring Licenses<span class="shohin">Showing upcoming 2 months</span></h3>
                                                        <table id="example" class="table table-striped table-bordered dataTable">
                                                            <thead>
                                                                <tr>
                                                                    <th>Licensee Name</th>
                                                                    <th>Due Date</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Name</td>
                                                                    <td>01/01/2020</td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                                <i class="glyphicon glyphicon-option-vertical"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu">
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Name</td>
                                                                    <td>01/01/2020</td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                                <i class="glyphicon glyphicon-option-vertical"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu">
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Name</td>
                                                                    <td>01/01/2020</td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                                <i class="glyphicon glyphicon-option-vertical"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu">
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Name</td>
                                                                    <td>01/01/2020</td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                                <i class="glyphicon glyphicon-option-vertical"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu">
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Name</td>
                                                                    <td>01/01/2020</td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                                <i class="glyphicon glyphicon-option-vertical"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu">
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-eye-open"></span> View
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <span class="glyphicon glyphicon-trash"></span> Delete
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>
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
                                                        	<!-- Graph Code yaha likhe -->
                                                        </div>
                                                    </div>    
                                        		</div>
                                        	</div>
                                        </div>

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
<?php $this->load->view('include/footer'); ?>
<script type="text/javascript" src="<?php //echo base_url('includes/js/eta_dashboard.js'); ?>"></script>
</div>
</body>
</html>