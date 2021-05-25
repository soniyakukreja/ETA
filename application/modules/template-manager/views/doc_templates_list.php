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
                                <?php $this->load->view('include/leftsidebar'); ?>
                                <div class="filterBody">
                                    <div class="filterDiv">

                                        <h3>Document Templates</h3>
                                        
                                        <div id="errorMsg" class="alert alert-danger hide">
                                          <strong>Warning!</strong>
                                        </div>
                                        <div id="successMsg" class="alert alert-success hide">
                                          <strong>Success!</strong>
                                        </div>

                                        <!--   -->
                                       
                                        <div class="filterTable exportButton expoTable">
                                            <?php /*
                                            <form action="<?php echo site_url() ?>Doc_manager/export" method="POST">
                                                <input type="hidden" name="search" id="searchfltr">
                                                <button class="addNew">Export</button>
                                            </form>
                                            */ ?>
                                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Title</th>
                                                        <th>User Type</th>
                                                        <th>Document</th>
                                                        <th>Last Updated</th>
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
    var url = site_url+"template-manager/Doc_manager/loadTableData";
    console.log('url',url);
    $('#example').dataTable( {
        "serverSide": true,
        "ajax" : url,
        
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