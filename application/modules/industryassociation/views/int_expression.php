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
                                        <h3>Expression of Interests</h3>

                                        <div id="errorMsg" class="alert alert-danger hide">
                                          <strong>Warning!</strong>
                                        </div>
                                        <div id="successMsg" class="alert alert-success hide">
                                          <strong>Success!</strong>
                                        </div>
                                        
                                        <div class="filterTable exportButton expoTable">
                                             
                                             
                                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                                <thead>
                                                    <tr class="n-blue-bg">
                                                        <th>Customer Name</th>
                                                        <th>Product Name</th>
                                                        <th>Date</th>
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
   <?php $this->load->view('industryassociation/ia_js.php'); ?>

</div>
 <script type="text/javascript" charset="utf-8">
function loadTableData(){
    var url = "<?php echo site_url() ?>industryassociation/int_expression_ajax";
    $('#example').dataTable( {
        "serverSide": true,
        "ajax" : url,
        "lengthMenu": [ 10, 20, 50, 100, 200,250,500 ],
    } );
}
loadTableData();

    </script>
</body>
</html>