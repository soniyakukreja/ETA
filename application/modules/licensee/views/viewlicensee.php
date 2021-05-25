<?php $this->load->view('include/header.php'); 

    $uristring=$this->uri->segment(1).'/'.$this->uri->segment(2);
    $myprofile='staff/staffprofile/'.$this->userdata["user_id"];
    $arr=array(); $arr=$this->session->userdata('userdata');
    $perms=explode(",",$arr['upermission']);
?>

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

                                        <h3>Licensees</h3>
                                        
                                        <div id="errorMsg" class="alert alert-danger hide">
                                          <strong>Warning!</strong>
                                        </div>
                                        <div id="successMsg" class="alert alert-success hide">
                                          <strong>Success!</strong>
                                        </div>

                                        
                                       
                                        <div class="filterTable exportButton expBtn <?php if(!in_array("LIC_A",$perms)){ echo 'proTable'; } ?>">
                                        <?php if(in_array('LIC_A',$perms)){?>   
										  <a href="<?php echo site_url() ?>licensee/addlicensee" class="addNew n-m-70">Add New</a>
                                        <?php }?> 
                                        <?php if(in_array('LIC_EXP',$perms)){?>  
                                        <!-- <a href="<?php echo site_url() ?>licensee/export" style='margin-right: -73px;' class="addNew n-m-70">Export</a>  -->
                                        <form action="<?php echo site_url() ?>licensee/export" method="POST">
                                                <input type="hidden" name="search" id="searchfltr">
                                                <button class="addNew ex-btn">Export</button>
                                         </form>
                                        <?php }?>     
                                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                                <thead>
                                                    <tr class="n-blue-bg">
                                                        <th>Resource ID</th>
                                                        <th>License Number</th>
                                                        <th>Business Name</th>
                                                        <th>Category</th>
                                                        <th>CTO Name</th>
                                                        <th>CTO Email Address</th>
                                                        <th>License End Date</th>
                                                        <!-- <th>Next Business Review Date</th> -->
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
    <?php $this->load->view('include/confim_popup.php'); ?>
</div>
<script>
function loadTableData(){
    var url = "<?php echo site_url() ?>licensee/licensee/ajax";
    $('#example').dataTable( {
        "serverSide": true,
        "ajax" : url,
        "order": [[ 6, "desc" ]],
        "lengthMenu": [ 10, 20, 50, 100, 200,250,500 ],
    } );    
}
loadTableData();
var table = $('#example').DataTable();

$('#example').on('search.dt', function() {
    var value = $('.dataTables_filter input').val();
    $('#searchfltr').val(value);
    // console.log(value); // <-- the value
}); 

</script>
</body>
</html>