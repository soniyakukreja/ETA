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
                                
                                    <?php $this->load->view('include/leftsidebar'); ?>
                               
                                <div class="filterBody">
                                    <div class="filterDiv">
                                        <h3>Business Reviews</h3>
                                        <div class="filterTable exportButton">
                                            <a href="<?php echo site_url() ?>business_review/addnew" class="addNew n-m-70">Add New</a>
                                            <form action="<?php echo site_url() ?>business_review/export" method="POST">
                                                <input type="hidden" name="search" id="searchfltr">
                                                <button class="addNew">Export</button>
                                            </form>
                                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                                <thead>
                                                    <tr class="n-blue-bg">
                                                        <th>Title</th>
                                                        <th>Due Date</th>
                                                        <th>Status</th>
                                                        <th>Date Completed</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                  <tr>
                                                    <td colspan="6">No Record Found</td>
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
</div>
    
<!-- <script>
    $(document).ready(function() {
            var url = "<?php echo site_url() ?>licensee/Licensee/ajax";
            alert(url); 
            $('#example').dataTable( {
                "serverSide": true,
                "ajax" : url
            } );
        } );

</script> -->
</body>
</html>