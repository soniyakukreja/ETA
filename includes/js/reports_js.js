
$(document).on('change','.getia_cons',function(){
    var ia_id = $(this).val();
    if(ia_id>0){

        $.ajax({
            url: site_url+"reports/get_iaconsumers",
            type: "POST",
            data:{'ia_id':ia_id},
            dataType: "json",
            beforeSend:function(){
                ajaxindicatorstart();
            },
            success: function(res) {
                ajaxindicatorstop();
                $('.consumerdropdown').html(res.html);
            }
        }); 
    }else{
        $('.consumerdropdown').html('<option value="">First Select IA</option>');
    }
});

$(document).on('change','#supplier',function(){
    var sid = $(this).val();
    if(sid>0){

        $.ajax({
            url: site_url+"reports/supplier_products",
            type: "POST",
            data:{'sid':sid},
            dataType: "json",
            beforeSend:function(){
                ajaxindicatorstart();
            },
            success: function(res) {
                ajaxindicatorstop();
                $('.prod_dropdown').html(res.html);
            }
        }); 
    }else{
        $('.prod_dropdown').html('<option value="">First Select Supplier</option>');
    }
});


$(document).on('change','#lic',function(){
    var lic = $(this).val();
    if(lic>0){

        $.ajax({
            url: site_url+"reports/get_ia",
            type: "POST",
            data:{'lic':lic},
            dataType: "json",
            beforeSend:function(){
                ajaxindicatorstart();
            },
            success: function(res) {
                ajaxindicatorstop();
                $('#ia').html(res.html);
            }
        }); 
    }else{
        $('.prod_dropdown').html('<option value="">First Select Licensee</option>');
    }
}); 

