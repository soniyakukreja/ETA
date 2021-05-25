<?php $this->load->view('include/header.php'); ?>
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
								<div class="aside">
								<?php $this->load->view('include/leftsidebar.php'); ?>
								</div>
								<div class="filterBody">
									<div class="filterDiv">
										 <h3>Transaction Summary:</h3>
                                       <!-- <form>
                                        	<div class="row">
                                        			
                                            <label>Filter by Industry Association</label>
                                            <select>
                                                <option>Select Consumer</option>
                                                <option>Select Consumer</option>
                                                <option>Select Consumer</option>
                                                <option>Select Consumer</option>
                                            </select>
                                            <label>Filter by Licensee</label>
                                            <select>
                                                <option>Select Consumer</option>
                                                <option>Select Consumer</option>
                                                <option>Select Consumer</option>
                                                <option>Select Consumer</option>
                                            </select>
                                        	</div><br> -->
                                        <!-- 	<div class="row">
															
													<div class="form-group">
														<label>Start Date</label>
														<input name="lic_startdate" id="lic_startdate" class="datepicker" type="text" >
													</div>
													<div class="form-group">
														<label>End Date</label>
														<input name="lic_enddate" id="lic_enddate" class="datepicker" type="text" >
													</div>
											</div> -->
                                        
                                        <!-- </form> -->
										<div class="filterTable exportButton">

											<button class="addNew">Export</button><br><br>
											<table id="example" class="table table-striped table-bordered" style="width:100%">
										        <thead>
										            <tr class="n-blue-bg">
										                <th>Order Number</th>
										                <th>Order Date and Time</th>
										                <th>Consumer</th>
										                <th>Industry Association</th>
										                <th>Licensee</th>
										                <th>Order Total</th>
										                <th>Order Total to Disburse </th>
										                <th>Status</th>
										                <th>Actions</th>
										            </tr>
										        </thead>
										        <tbody>
										            <tr>
										            	<td colspan="10">No Record Found</td>
										            </tr>
										        </tbody>
										    </table>
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
	<?php $this->load->view('include/footer.php'); ?>
	<!-- <script type="text/javascript" charset="utf-8">
        $(document).ready(function() {
            var url = "<?php echo site_url() ?>product/Product/ajax";
            // alert(url); 
            $('#example').dataTable( {
                "serverSide": true,
                "ajax" : url
            } );
        } );
    </script> -->
</div>
</body>
</html>