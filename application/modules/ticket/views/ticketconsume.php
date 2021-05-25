<?php $this->load->view('include/header.php'); 
$this->userdata = $this->session->userdata('userdata');
$perms=explode(",",$this->userdata['upermission']); ?>
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
                              
                                
                                    <?php $this->load->view('include/leftsidebar'); ?>
                                
                                 
                                <div class="filterBody">
                                    <div class="filterDiv">
                                        <h3>Ticket</h3>
                                        <div id="errorMsg" class="alert alert-danger hide">
                                          <strong>Warning!</strong>
                                        </div>
                                        <div id="successMsg" class="alert alert-success hide">
                                          <strong>Success!</strong>
                                        </div>
                                        
                                      <?php $class = '';
										if(!in_array('TIC_A',$perms) && !in_array('TIC_EXP',$perms)){
											$class = 'expoTable';
										}elseif(in_array('TIC_A',$perms) && !in_array('TIC_EXP',$perms)){
											$class = 'addBtnTablr';
										}elseif(!in_array('TIC_A',$perms) && in_array('TIC_EXP',$perms)){
											$class = 'proTable';
										} ?>
                                        <div class="filterTable exportButton expBtn <?php  echo $class; ?>">
                                            <?php if(in_array("TIC_A",$perms)) {?>
                                            <a href="<?php echo site_url() ?>ticket/addticket" class="addNew n-m-70">Add New</a>
                                            <?php }?>
                                            <?php if(in_array("TIC_EXP",$perms)) {?>
                                            <form action="<?php echo site_url() ?>ticket/ticket_account/exportconsume" method="POST">
                                                <input type="hidden" name="search" id="searchfltr">
                                                <button class="addNew">Export</button>
                                            </form>
                                            <?php }?>
                                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                                <thead>
                                                    <tr class="n-blue-bg">
                                                        <th>Ticket Title</th>
                                                        <th>Ticket Number</th>
                                                        <th>Made By</th>
                                                        <th>Business Name</th>
                                                        <th>Status</th>
                                                        <th>Category</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Loading....</td>
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
    <?php $this->load->view('include/footer.php'); ?>
    <?php $this->load->view('include/confim_popup.php'); ?>
<script>
function loadTableData(){
            var url = "<?php echo site_url() ?>ticket/ticket_account/ajaxconsume";
            // alert(url); 
            $('#example').dataTable( {
                "serverSide": true,
                "ajax" : url,
                "lengthMenu": [ 10, 20, 50, 100, 200,250,500 ],
            } );
        };
    loadTableData();

var table = $('#example').DataTable();

$('#example').on('search.dt', function() {
    var value = $('.dataTables_filter input').val();
    $('#searchfltr').val(value);
    // console.log(value); // <-- the value
});
    </script>
</div>
</body>
</html>