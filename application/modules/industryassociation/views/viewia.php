<?php $this->load->view('include/header.php'); 

    $uristring=$this->uri->segment(1).'/'.$this->uri->segment(2);
    $this->session->set_userdata('licenseeid','');
    $myprofile='staff/staffprofile/'.$this->userdata["user_id"];
    $arr=array(); $arr=$this->session->userdata('userdata');
    $perms=explode(",",$arr['upermission']);
?>
<style>
    @media (max-width: 767px) {
.rem-btn {
position: unset;
}
}
</style>
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
                                        <?php if($this->userdata['dept_id']=='2' || $this->userdata['dept_id']=='10'){?>
                                       <!--  <form action="<?php echo site_url() ?>industryassociation/removeia" method="POST" id="remove">
                                                <input type="hidden" name="ids" id="ids">
                                                <button class="addNew rem-btn" type="button" id="submit">Remove</button>
                                        </form> -->
                                        <?php }?>
                                        <h3>Industry Associations</h3>

                                        <div id="errorMsg" class="alert alert-danger hide">
                                          <strong>Warning!</strong>
                                        </div>
                                        <div id="successMsg" class="alert alert-success hide">
                                          <strong>Success!</strong>
                                        </div>
                                        
                                        <div class="filterTable exportButton expBtn <?php if(!in_array("IA_A",$perms)){ echo 'proTable'; } ?>">
                                            <?php if(in_array('IA_A',$perms)){?>   
                                                <a href="<?php echo site_url() ?>industryassociation/addia" class="addNew n-m-70">Add New</a>
                                            <?php }?> 
                                            <?php if(in_array('IA_EXP',$perms)){?> 
                                            <form action="<?php echo site_url() ?>industryassociation/export" method="POST">
                                                <input type="hidden" name="search" id="searchfltr">
                                                <button class="addNew ex-btn">Export</button>
                                            </form>  
                                            <?php }?> 
                                            <div class="table-responsive">
                                                <table id="example" class="table table-striped table-bordered" style="width:100%">
                                                    <thead>
                                                        <tr class="n-blue-bg">
                                                            <!-- <th><input type="checkbox" name="chck" id="selectall"></th> -->
                                                            <th>Resource ID</th>
                                                            <th>Business Name</th>
                                                            <th>Licensee</th>
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
 <script type="text/javascript" charset="utf-8">
function loadTableData(){
    var url = "<?php echo site_url() ?>industryassociation/industryassociation/ajax/";
    $('#example').dataTable( {
        "serverSide": true,
        "ajax" : url,
        "lengthMenu": [ 10, 20, 50, 100, 200,250,500 ],
         
    } );
}
loadTableData();
var table = $('#example').DataTable();

$('#example').on('search.dt', function() {
    var value = $('.dataTables_filter input').val();
    $('#searchfltr').val(value);
});

$(document).on('change','#selectall',function(){
        if($(this).prop('checked')==true){
            $('.case').prop('checked',true);
        }else{
            $('.case').prop('checked',false);
        }
    });


$(document).on('click','#submit',function(){
     var cs = [];
    var checkboxV = $("input[name='id[]']:checked");
    checkboxV.each(function()
      {cs.push($(this).val());
      });
    if(cs.length=='0')
      {
        $('#errorMsg').addClass('show').removeClass('hide').html('Please Select minimum one record');
        allIsOk = false;
        return false;
      }

     $('#ids').val(cs); 
    $('#confirm_modal').modal('show');

});
$(document).on('click','#cancel_remove',function(){
$('#confirm_modal').modal('hide');

});


$(document).on('click','#yes_removeall',function(){
    
        var url = $('#remove').attr('action');
        var formData = $("#remove").serialize();
        $.ajax({
            url: url,
            type: "POST",
            data:formData,
            dataType: "json",
            beforeSend:function(){
                ajaxindicatorstart();
            },
            success: function(res) {
                ajaxindicatorstop();
                if(res.success) {
                    $('#remove')[0].reset();
                    $('#example').DataTable().destroy();

                    loadTableData();
                    $('#confirm_modal').modal('hide');
                    $('#errorMsg').addClass('hide').removeClass('show');
                    $('#successMsg').addClass('show').removeClass('hide').html(res.msg);
                    
                    setTimeout( function(){ 
                        $('#errorMsg , #successMsg').addClass('hide').removeClass('show').fadeOut('slow');
                     }  , 3000 );                       
                }else{
                    $('#errorMsg').addClass('show').removeClass('hide').html(res.msg);
                    $('#successMsg').addClass('hide').removeClass('show');
                    allIsOk = false;
                }
                $('html, body').animate({
                    scrollTop: $(".dashBody").offset().top
                }, 1000); 
            }
        });

});

    </script>
</body>
</html>