
$(document).on('submit','#add_product',function (e) {
	e.preventDefault();
    var allIsOk = true;

    
	var product_name = $('#product_name').val();
	var product_sku = $('#product_sku').val();
	var prod_cat_id = $('#prod_cat_id :selected').val().trim();
	var supplier_id = $('#supplier_id :selected').val().trim();
	var role_id = $('#role_id :selected').val().trim();
	var type = $('#type :selected').val().trim();
	var w_price = $('#wsale_price').val().trim();
	var l_price = $('#l_price').val().trim();
	var ia_price = $('#ia_price').val().trim();
	var c_price = $('#c_price').val().trim();
	var ck_form_id = $('#ck_form_id :selected').val().trim();
	var prod_dis = $('#prod_dis').val();
	var prod_dis_startdate = $('#prod_dis_startdate').val();
	var prod_dis_enddate = $('#prod_dis_enddate').val();
	var prod_status = $('#prod_status').val();

	$('.invalidText').hide();

	if (product_name == '') {
		$("#product_name").focus();
		$("#product_name_err").show().html('Please Enter Product Name');
        allIsOk = false;
    } if(product_sku == ''){
		$("#product_sku").focus();
		$("#product_sku_err").show().html('Please Enter Product SKU');
        allIsOk = false;    	
    }else if(product_sku.length<8){
		$("#product_sku").focus();
		$("#product_sku_err").show().html('Please Product SKU must be atleast 8 charachters long');
        allIsOk = false;     	
    }
    if(prod_cat_id == ''){
		$("#prod_cat_id").focus();
		$("#prod_cat_id_err").show().html('Please Select Category');
        allIsOk = false;    	
    } if(supplier_id == ''){
		$("#supplier_id").focus();
		$("#supplier_id_err").show().html('Please Select Supplier');
        allIsOk = false;    	
    } if(type == ''){
		$("#type").focus();
		$("#type_err").show().html('Please Select Type');
        allIsOk = false;    	
    } if(w_price == '' || isNaN(w_price)){
		$("#wsale_price").focus();
		$("#wsale_price_err").show().html('Please Enter Wholesale Price');
        allIsOk = false;    	
    } if(l_price == '' || isNaN(l_price)){
		$("#l_price").focus();
		$("#l_price_err").show().html('Please Enter Licensee Price');
        allIsOk = false;    	
    } if(ia_price == '' || isNaN(ia_price)){
		$("#ia_price").focus();
		$("#ia_price_err").show().html('Please Enter Industry Association Price');
        allIsOk = false;    	
    } if(c_price == '' || isNaN(c_price)){
		$("#c_price").focus();
		$("#c_price_err").show().html('Please Enter Consumer Price');
        allIsOk = false;    	
    } if(prod_dis != ''){
    	if(isNaN(prod_dis)){
			$("#prod_dis_err").show().html('Please Enter Valid Discount Percent');
			allIsOk = false; 
    	}
		if(prod_dis_startdate == ''){
			//$("#prod_dis_startdate").focus();
			$("#prod_dis_startdate_err").show().html('Please Enter Start Date');
        		allIsOk = false; 
		}else if(prod_dis_enddate == ''){
			//$("#prod_dis_enddate").focus();
			$("#prod_dis_enddate_err").show().html('Please Enter End Date');
        		allIsOk = false;    	
    		}   	
    } if(prod_status == ''){
		$("#prod_status").focus();
		$("#prod_status_err").show().html('Please Select Status');
        allIsOk = false;    	
    } if(role_id == ''){
		$("#role_id").focus();
		$("#role_id_err").show().html('Please Select Intended Type');
        allIsOk = false;    	
    }

    if(allIsOk){
    	ds = $(this);
		var url = $(this).attr('action');
		var formData = new FormData(ds[0]);
		$.ajax({
			url: url,
			type: "POST",
			data:formData,
    		dataType: "json",
		    processData: false,
		    contentType: false,			
			beforeSend:function(){
				ajaxindicatorstart();
			},
			success: function(res) {
				ajaxindicatorstop();
				if(res.success) {
					$('#add_product')[0].reset();
					$('#errorMsg').addClass('hide').removeClass('show');
					$('#successMsg').addClass('show').removeClass('hide').html('Product Added successfully!').fadeOut('slow');

 					$('#prod_cat_id, #supplier_id, #type,#prod_status,#ck_form_id,#role_id').val(null).trigger('change');					
					$('.ckeditor').val('');
					$('.strongWeak').hide();
					setTimeout( function(){ 
						$('#errorMsg , #successMsg').addClass('hide').removeClass('show').fadeOut('slow');
					  }  , 10000 );
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
    }
    return allIsOk    
});


$(document).on('submit','#edit_product',function (e) {
	e.preventDefault();
    var allIsOk = true;

	var product_name = $('#product_name').val();
	var product_sku = $('#product_sku').val();
	var prod_cat_id = $('#prod_cat_id :selected').val().trim();
	var supplier_id = $('#supplier_id :selected').val().trim();
	var type = $('#type :selected').val().trim();
	var role_id = $('#role_id :selected').val().trim();
	var w_price = $('#wsale_price').val().trim();
	var l_price = $('#l_price').val().trim();
	var ia_price = $('#ia_price').val().trim();
	var c_price = $('#c_price').val().trim();
	var ck_form_id = $('#ck_form_id :selected').val().trim();
	var prod_dis = $('#prod_dis').val();
	var prod_dis_startdate = $('#prod_dis_startdate').val();
	var prod_dis_enddate = $('#prod_dis_startdate').val();
	var prod_status = $('#prod_status').val();

	$('.invalidText').hide();

	if (product_name == '') {
		$("#product_name").focus();
		$("#product_name_err").show().html('Please Enter Product Name');
        allIsOk = false;
    }else if(product_sku == ''){
		$("#product_sku").focus();
		$("#product_sku_err").show().html('Please Enter Product SKU');
        allIsOk = false;    	
    }else if(prod_cat_id == ''){
		$("#prod_cat_id").focus();
		$("#prod_cat_id_err").show().html('Please Select Category');
        allIsOk = false;    	
    }else if(supplier_id == ''){
		$("#supplier_id").focus();
		$("#supplier_id_err").show().html('Please Select Supplier');
        allIsOk = false;    	
    }else if(type == ''){
		$("#type").focus();
		$("#type_err").show().html('Please Select Type');
        allIsOk = false;    	
    }else if(w_price == '' || isNaN(w_price)){
		$("#wsale_price").focus();
		$("#wsale_price_err").show().html('Please Enter Wholesale  Price');
        allIsOk = false;    	
    }else if(l_price == '' || isNaN(l_price)){
		$("#l_price").focus();
		$("#l_price_err").show().html('Please Enter Licensee Price');
        allIsOk = false;    	
    }else if(ia_price == '' || isNaN(ia_price)){
		$("#ia_price").focus();
		$("#ia_price_err").show().html('Please Enter Industry Association Price');
        allIsOk = false;    	
    }else if(c_price == '' || isNaN(c_price)){
		$("#c_price").focus();
		$("#c_price_err").show().html('Please Enter Consumer Price');
        allIsOk = false;    	
    }else if(prod_dis != ''){
		if(prod_dis_startdate == ''){
			$("#prod_dis_startdate").focus();
			$("#prod_dis_startdate_err").show().html('Please Enter Start Date');
        		allIsOk = false; 
		}else if(prod_dis_enddate == ''){
			$("#prod_dis_enddate").focus();
			$("#prod_dis_enddate_err").show().html('Please Enter End Date');
        		allIsOk = false;    	
    		}   	
    }else if(prod_status == ''){
		$("#prod_status").focus();
		$("#prod_status_err").show().html('Please Select Status');
        allIsOk = false;    	
    }else if(role_id == ''){
		$("#role_id").focus();
		$("#role_id_err").show().html('Please Select Intended Type');
        allIsOk = false;    	
    }
    	
    if(allIsOk){
    	ds = $(this);
		var url = $(this).attr('action');
		var formData = new FormData(ds[0]);
		$.ajax({
			'async': false,
			url: url,
			type: "POST",
			data:formData,
    		dataType: "json",
		    processData: false,
		    contentType: false,			
			beforeSend:function(){
				ajaxindicatorstart();
			},
			success: function(res) {
				ajaxindicatorstop();
				if(res.success) {
					
					$('#errorMsg').addClass('hide').removeClass('show');
					$('#successMsg').addClass('show').removeClass('hide').html('Product Updated successfully!').fadeOut('slow');
					
					$('.strongWeak').hide();
					setTimeout( function(){ 
						$('#errorMsg , #successMsg').addClass('hide').removeClass('show').fadeOut('slow');
					  }  , 10000 );
					//window.location.reload();
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
    }
    return allIsOk    
});

$(document).on('submit','#add_category',function (e) {
	e.preventDefault();
    var allIsOk = true;

	var prod_cat_name = $('#prod_cat_name').val();
	

	$('.invalidText').hide();

	if (prod_cat_name == '') {
		$("#prod_cat_name").focus();
		$("#cat_name_err").show().html('Please Enter Category Name');
        allIsOk = false;
    }

    if(allIsOk){
    	ds = $(this);
		var url = $(this).attr('action');
		var formData = new FormData(ds[0]);
		$.ajax({
			'async': false,
			url: url,
			type: "POST",
			data:formData,
    		dataType: "json",
		    processData: false,
		    contentType: false,			
			beforeSend:function(){
				ajaxindicatorstart();
			},
			success: function(res) {
				ajaxindicatorstop();
				if(res.success) {
					$('#add_category')[0].reset();
					$('#errorMsg').addClass('hide').removeClass('show');
					$('#successMsg').addClass('show').removeClass('hide').html('Product Category Added successfully!').fadeOut('slow');
					
					$('.strongWeak').hide();
					setTimeout( function(){ 
						$('#errorMsg , #successMsg').addClass('hide').removeClass('show').fadeOut('slow');
					  }  , 10000 );
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
    }
    return allIsOk    
});


$(document).on('submit','#edit_category',function (e) {
	e.preventDefault();
    var allIsOk = true;

	var prod_cat_name = $('#prod_cat_name').val();
	

	$('.invalidText').hide();

	if (prod_cat_name == '') {
		$("#prod_cat_name").focus();
		$("#cat_name_err").show().html('Please Enter Category Name');
        allIsOk = false;
    }

    if(allIsOk){
    	ds = $(this);
		var url = $(this).attr('action');
		var formData = new FormData(ds[0]);
		$.ajax({
			'async': false,
			url: url,
			type: "POST",
			data:formData,
    		dataType: "json",
		    processData: false,
		    contentType: false,			
			beforeSend:function(){
				ajaxindicatorstart();
			},
			success: function(res) {
				ajaxindicatorstop();
				if(res.success) {
					
					$('#errorMsg').addClass('hide').removeClass('show');
					$('#successMsg').addClass('show').removeClass('hide').html('Product Category Updated successfully!').fadeOut('slow');
					
					$('.strongWeak').hide();
					setTimeout( function(){ 
						$('#errorMsg , #successMsg').addClass('hide').removeClass('show').fadeOut('slow');
					  }  , 10000 );
					//window.location.reload();
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
    }
    return allIsOk    
});

$(document).on('submit','#add_note',function (e) {

	console.log('abc');

	e.preventDefault();
    var allIsOk = true;

	var app_activity_title = $('#app_activity_title').val();
	var app_activity_des = $('#app_activity_des').val();
		
	$('.invalidText').hide();

	if (app_activity_title == '') {
		$("#app_activity_title").focus();
		$("#app_activity_title_err").show().html('Please Enter Title');
        allIsOk = false;
    }else if (app_activity_des == '') {
		$("#app_activity_des").focus();
		$("#app_activity_des_err").show().html('Please Enter Description');
        allIsOk = false;
    }

    if(allIsOk){
    	ds = $(this);
		var url = $(this).attr('action');
		var formData = new FormData(ds[0]);
		$.ajax({
			'async': false,
			url: url,
			type: "POST",
			data:formData,
    		dataType: "json",
		    processData: false,
		    contentType: false,			
			beforeSend:function(){
				ajaxindicatorstart();
			},
			success: function(res) {
				ajaxindicatorstop();
				if(res.success) {
					
					$("#addNote .close").click();
					
					$('#errorMsg').addClass('hide').removeClass('show');
					$('#successMsg').addClass('show').removeClass('hide').html('Activity Added successfully!').fadeOut('slow');
					
					$('.strongWeak').hide();
					setTimeout( function(){ 
						$('#errorMsg , #successMsg').addClass('hide').removeClass('show').fadeOut('slow');
									window.location.reload();
					  }  , 10000 );
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
    }
    return allIsOk    
});

$(document).on('submit','#add_supplier',function (e) {
	e.preventDefault();
    var allIsOk = true;

	var firstname = $('#supplier_fname').val().trim();
	var lastname = $('#supplier_lname').val().trim();
	var country = $('#supplier_country :selected').val().trim();
	var email = $('#supplier_email').val();
	var contactno = $('#phone').val();
	var business_name = $('#business_name').val();
	var password = $('#password').val();
	var cpassword = $('#cpassword').val();
	

	$('.invalidText').hide();

	if (firstname == '') {
		$("#supplier_fname").focus();
		$("#supplier_fname_err").show().html('Please Enter First Name');
        allIsOk = false;
    }
    if(lastname == ''){
		$("#supplier_lname").focus();
		$("#supplier_lname_err").show().html('Please Enter Last Name');
        allIsOk = false;    	
    }
    if(country == ''){
		$("#supplier_country").focus();
		$("#supplier_country_err").show().html('Please Select Country');
        allIsOk = false;    	
    }
    if(business_name == ''){
		$("#business_name").focus();
		$("#business_name_err").show().html('Please Enter Business Name');
        allIsOk = false;    	
    }
    if(email == '' || !validateEmail(email)){
		$("#supplier_email").focus();
		$("#supplier_email_err").show().html('Please Enter Email Address');
        allIsOk = false;    	
    }
    if(contactno == ''){
		$("#phone").focus();
		$("#phone_err").show().html('Please Enter Contact Number');
        allIsOk = false;    	
    }
    if(password == ''){
		$("#password").focus();
		$("#p_err").show().html('Please add Password');
        allIsOk = false;    	
    }else if(!validate_pass($('#password'))){
    	$("#password").focus();
    	$("#p_err").show().html("Password don't match");
    	allIsOk = false;  
    }else if(cpassword == ''){
		$("#cpassword").focus();
		$("#cp_err").show().html('Please add Confirm Password');
        allIsOk = false;    	
    }
    if(!validate_pass($('#cpassword'))){
    	$("#cpassword").focus();
    	$("#cp_err").show().html("Password don't match");
    	allIsOk = false;  
    }else if(password !==cpassword){
		$("#cpassword").focus();
		$("#p_err").show().html("Password don't match");
        allIsOk = false;    	
    }


	$( ".imgInput" ).each(function(i,v) {
	  if($(this).attr('is_valid')==0){
	  	$(this).parents('.form-group').find('.image_err').css('display','block');
	  	allIsOk = false;  
	  }
	});

    if(allIsOk){
    	ds = $(this);
		var url = $(this).attr('action');
		var formData = new FormData(ds[0]);
		$.ajax({
			'async': false,
			url: url,
			type: "POST",
			data:formData,
    		dataType: "json",
		    processData: false,
		    contentType: false,			
			beforeSend:function(){
				ajaxindicatorstart();
			},
			success: function(res) {
				ajaxindicatorstop();
				if(res.success) {
					$('#add_supplier')[0].reset();
					$('#supplier_country, #prod_cat_id').val(null).trigger('change');
					$('.imgInput, .hiddenfile').val('');

					$('#errorMsg').addClass('hide').removeClass('show');
					$('#successMsg').addClass('show').removeClass('hide').html('Supplier Added successfully!').fadeOut('slow');
					
					$('.strongWeak').hide();
					setTimeout( function(){ 
						$('#errorMsg , #successMsg').addClass('hide').removeClass('show').fadeOut('slow');
					  }  , 10000 );
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
    }
    return allIsOk    
});

$(document).on('submit','#edit_supplier',function (e) {
	e.preventDefault();
    var allIsOk = true;

	var firstname = $('#supplier_fname').val().trim();
	var lastname = $('#supplier_lname').val().trim();
	var country = $('#supplier_country :selected').val().trim();
	var email = $('#supplier_email').val();
	var contactno = $('#phone').val();
	var business_name = $('#business_name').val();

	$('.invalidText').hide();

	if (firstname == '') {
		$("#supplier_fname").focus();
		$("#supplier_fname_err").show().html('Please Enter First Name');
        allIsOk = false;
    } if(lastname == ''){
		$("#supplier_lname").focus();
		$("#supplier_lname_err").show().html('Please Enter Last Name');
        allIsOk = false;    	
    } if(country == ''){
		$("#supplier_country").focus();
		$("#supplier_country_err").show().html('Please Select Country');
        allIsOk = false;    	
    } if(business_name == ''){
		$("#business_name").focus();
		$("#business_name_err").show().html('Please Enter Business Name');
        allIsOk = false;    	
    } if(email == '' || !validateEmail(email)){
		$("#supplier_email").focus();
		$("#supplier_email_err").show().html('Please Enter Email Address');
        allIsOk = false;    	
    } if(contactno == ''){
		$("#phone").focus();
		$("#phone_err").show().html('Please Enter Contact Number');
        allIsOk = false;    	
    }

	$( ".imgInput" ).each(function(i,v) {
	  if($(this).attr('is_valid')==0){
	  	$(this).parents('.form-group').find('.image_err').css('display','block');
	  	allIsOk = false;  
	  }
	});

    if(allIsOk){
    	ds = $(this);
		var url = $(this).attr('action');
		var formData = new FormData(ds[0]);
		$.ajax({
			'async': false,
			url: url,
			type: "POST",
			data:formData,
    		dataType: "json",
		    processData: false,
		    contentType: false,			
			beforeSend:function(){
				ajaxindicatorstart();
			},
			success: function(res) {
				ajaxindicatorstop();
				if(res.success) {
					
					$('#errorMsg').addClass('hide').removeClass('show');
					$('#successMsg').addClass('show').removeClass('hide').html('Supplier Updated successfully!').fadeOut('slow');
					$('.imgInput, .hiddenfile').val('');
					
					$('.strongWeak').hide();
					setTimeout( function(){ 
						$('#errorMsg , #successMsg').addClass('hide').removeClass('show').fadeOut('slow');
					  }  , 10000 );
					//window.location.reload();
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
    }
    return allIsOk    
});

$(document).on('submit','#edit_page',function (e) {
	e.preventDefault();
    var allIsOk = true;
	$('.invalidText').hide();
	
	var pb_name = $('#pb_name').val();
	var pb_slug = $('#pb_slug').val().trim();
	var pb_role_id = $('#pb_role_id :selected').val().trim();
	var pb_status = $('#pb_status :selected').val().trim();
	var pb_featureimage = $('#pb_featureimage').val().trim();
	// var pb_cta_label = $('#pb_cta_label').val().trim();
	// var pb_cta_text = $('#pb_cta_text').val().trim();
	// var pb_publishdate = $('#pb_publishdate').val().trim();
	var content = CKEDITOR.instances['cta_desc'].getData().replace(/<[^>]*>/gi, '').length;

	if (pb_name == '') {
		$("#pb_name").focus();
		$("#name_err").show().html('Please Enter Page Name');
        allIsOk = false;
    }
    if(pb_slug == ''){
		$("#pb_slug").focus();
		$("#slug_err").show().html('Please Enter Page Slug');
        allIsOk = false;    	
    }
    if(pb_role_id == ''){
		$("#pb_role_id").focus();
		$("#role_id_err").show().html('Please Select Intended User');
        allIsOk = false;    	
    }
    if(pb_status == ''){
		$("#pb_status").focus();
		$("#status_err").show().html('Please Select Status');
        allIsOk = false;    	
    }
  //   if(pb_featureimage == ''){
		// $("#pb_featureimage").focus();
		// $("#featureimage_err").show().html('Please Upload Feature Image');
  //       allIsOk = false;    	
  //   }
    if(content <=0){
		$("#cta_desc").focus();
		$("#content_err").show().html('Please Enter CTA Description');
        allIsOk = false;    	
    }

	$( ".imgInput" ).each(function(i,v) {
	  if($(this).attr('is_valid')==0){
	  	$(this).parents('.form-group').find('.image_err').css('display','block');
	  	allIsOk = false;  
	  }
	});


    if(allIsOk){
    	ds = $(this);
		var url = $(this).attr('action');
		var formData = new FormData(ds[0]);
		$.ajax({
			'async': false,
			url: url,
			type: "POST",
			data:formData,
    		dataType: "json",
		    processData: false,
		    contentType: false,			
			beforeSend:function(){
				ajaxindicatorstart();
			},
			success: function(res) {
				ajaxindicatorstop();
				if(res.success) {
					
					$('#errorMsg').addClass('hide').removeClass('show');
					$('#successMsg').addClass('show').removeClass('hide').html('Page Updated successfully!').fadeOut('slow');
					$('.imgInput, .hiddenfile').val('');
					$('.strongWeak').hide();
					setTimeout( function(){ 
						$('#errorMsg , #successMsg').addClass('hide').removeClass('show').fadeOut('slow');
					  //window.location.reload();
					  }  , 10000 );
					
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
    }
    return allIsOk    
});

$(document).on('submit','#edit_banner',function (e) {
	e.preventDefault();
    var allIsOk = true;
	$('.invalidText').hide();
	
	var ba_name = $('#ba_name').val();
	var ba_image = $('#ba_image').val().trim();
	//var ba_roles_id = $('#ba_roles_id').val().trim();
	var ba_link = $('#ba_link').val().trim();
	var ba_status = $('#ba_status :selected').val().trim();
	var ba_bannertype = $('#ba_bannertype :selected').val().trim();
	//var publish_date = $('#publish_date').val().trim();

	if (ba_name == '') {
		$("#ba_name").focus();
		$("#ba_name_err").show().html('Please Enter Banner Name');
        allIsOk = false;
    }
  //   if(ba_image == ''){
		// $("#ba_image").focus();
		// $("#ba_image_err").show().html('Please Upload Banner Image');
  //       allIsOk = false;    	
  //   }
  //   if(ba_roles_id == ''){
		// $("#ba_roles_id").focus();
		// $("#ba_roles_err").show().html('Please Select Intended User');
  //       allIsOk = false;    	
  //   }
    if(ba_link == ''){
		$("#ba_link").focus();
		$("#link_err").show().html('Please Add link');
        allIsOk = false;    	
    }
    if(ba_status == ''){
		$("#ba_status").focus();
		$("#status_err").show().html('Please Select Status');
        allIsOk = false;    	
    }
  //   if(publish_date == ''){
		// $("#publish_date").focus();
		// $("#date_err").show().html('Please Enter Publish Date');
  //       allIsOk = false;    	
  //   }
    if(ba_bannertype == ''){
		$("#ba_bannertype").focus();
		$("#bannertype_err").show().html('Please Select Type');
        allIsOk = false;    	
    }

    $( ".imgInput" ).each(function(i,v) {
	  if($(this).attr('is_valid')==0){
	  	$(this).parents('.form-group').find('.image_err').css('display','block');
	  	allIsOk = false;  
	  }
	});


    if(allIsOk){
    	ds = $(this);
		var url = $(this).attr('action');
		var formData = new FormData(ds[0]);
		$.ajax({
			'async': false,
			url: url,
			type: "POST",
			data:formData,
    		dataType: "json",
		    processData: false,
		    contentType: false,			
			beforeSend:function(){
				ajaxindicatorstart();
			},
			success: function(res) {
				ajaxindicatorstop();
				if(res.success) {
					
					$('#errorMsg').addClass('hide').removeClass('show');
					$('#successMsg').addClass('show').removeClass('hide').html('Banner Updated successfully!').fadeOut('slow');
					$('.imgInput, .hiddenfile').val('');
					$('.strongWeak').hide();
					setTimeout( function(){ 
						$('#errorMsg , #successMsg').addClass('hide').removeClass('show').fadeOut('slow');
						//window.location.reload(); 
					}  , 10000 );
					
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
    }
    return allIsOk    
});


/*
$(document).on('submit','#edit_staff',function (e) {
	e.preventDefault();
    var allIsOk = true;

	var firstname = $('#firstname').val().trim();
	var lastname = $('#lastname').val().trim();
	var country = $('#country :selected').val().trim();
	var email = $('#email').val().trim();
	var contactno = $('#phone').val();
	var dept = $('#dept :selected').val().trim();

	$('.invalidText').hide();
	
	if(firstname == ''){
		$("#firstname").focus();
		$("#firstname_err").show().html('Please Enter First Name');
        allIsOk = false;    	
    }else if(lastname == ''){
		$("#lastname").focus();
		$("#lastname_err").show().html('Please Enter Last Name');
        allIsOk = false;    	
    }else if(email == '' || !validateEmail(email)){
		$("#email").focus();
		$("#email_err").show().html('Please Enter Email Address');
        allIsOk = false;    	
    }else if(!validateMobile(contactno)){
		$("#phone").focus();
		$("#contactno_err").show().html('Please Enter Contact Number');
        allIsOk = false;    	
    }else if(country == ''){
		$("#country").focus();
		$("#country_err").show().html('Please Select Country');
        allIsOk = false;    	
    }else if(dept == ''){
		$("#dept").focus();
		$("#dept_err").show().html('Please Select Department');
        allIsOk = false;    	
    }

    if(allIsOk){
    	ds = $(this);
		var url = $(this).attr('action');
		var formData = $("form").serialize();
		$.ajax({
			'async': false,
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
					
					$('#errorMsg').addClass('hide').removeClass('show');
					$('#successMsg').addClass('show').removeClass('hide').html('Staff Updated successfully!').fadeOut('slow');
					
					$('.strongWeak').hide();
					setTimeout( function(){ 
						$('#errorMsg , #successMsg').addClass('hide').removeClass('show').fadeOut('slow');
					  }  , 10000 );
					window.location.reload();
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
    }
    return allIsOk    
});
*/

$(document).on('submit','#add_ticcategory',function (e) {
	e.preventDefault();
    var allIsOk = true;

	var prod_cat_name = $('#tic_cat_name').val();
	

	$('.invalidText').hide();

	if (prod_cat_name == '') {
		$("#tic_cat_name").focus();
		$("#cat_name_err").show().html('Please Enter Category Name');
        allIsOk = false;
    }

    if(allIsOk){
    	ds = $(this);
		var url = $(this).attr('action');
		var formData = new FormData(ds[0]);
		$.ajax({
			'async': false,
			url: url,
			type: "POST",
			data:formData,
    		dataType: "json",
		    processData: false,
		    contentType: false,			
			beforeSend:function(){
				ajaxindicatorstart();
			},
			success: function(res) {
				ajaxindicatorstop();
				if(res.success) {
					$('#add_ticcategory')[0].reset();
					$('#errorMsg').addClass('hide').removeClass('show');
					$('#successMsg').addClass('show').removeClass('hide').html('Ticket Category Added successfully!').fadeOut('slow');
					
					$('.strongWeak').hide();
					setTimeout( function(){ 
						$('#errorMsg , #successMsg').addClass('hide').removeClass('show').fadeOut('slow');
					  }  , 10000 );
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
    }
    return allIsOk    
});


$(document).on('submit','#edit_ticcategory',function (e) {
	e.preventDefault();
    var allIsOk = true;

	var prod_cat_name = $('#tic_cat_name').val();
	

	$('.invalidText').hide();

	if (prod_cat_name == '') {
		$("#tic_cat_name").focus();
		$("#cat_name_err").show().html('Please Enter Category Name');
        allIsOk = false;
    }

    if(allIsOk){
    	ds = $(this);
		var url = $(this).attr('action');
		var formData = new FormData(ds[0]);
		$.ajax({
			'async': false,
			url: url,
			type: "POST",
			data:formData,
    		dataType: "json",
		    processData: false,
		    contentType: false,			
			beforeSend:function(){
				ajaxindicatorstart();
			},
			success: function(res) {
				ajaxindicatorstop();
				if(res.success) {
					
					$('#errorMsg').addClass('hide').removeClass('show');
					$('#successMsg').addClass('show').removeClass('hide').html('Ticket Category Updated successfully!').fadeOut('slow');
					
					$('.strongWeak').hide();
					setTimeout( function(){ 
						$('#errorMsg , #successMsg').addClass('hide').removeClass('show').fadeOut('slow');
					  }  , 10000 );
					// window.location.reload();
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
    }
    return allIsOk    
});

$(document).on('submit','#add_ticket',function (e) {
	e.preventDefault();
    var allIsOk = true;

	var tic_title = $('#tic_title').val();
	

	$('.invalidText').hide();

	if (tic_title == '') {
		$("#tic_title").focus();
		$("#tic_title_err").show().html('Please Enter Title');
        allIsOk = false;
    }

    if(allIsOk){
    	ds = $(this);
		var url = $(this).attr('action');
		var formData = new FormData(ds[0]);
		$.ajax({
			'async': false,
			url: url,
			type: "POST",
			data:formData,
    		dataType: "json",
		    processData: false,
		    contentType: false,			
			beforeSend:function(){
				ajaxindicatorstart();
			},
			success: function(res) {
				ajaxindicatorstop();
				if(res.success) {
					$('#add_ticket')[0].reset();
					$('#errorMsg').addClass('hide').removeClass('show');
					$('#successMsg').addClass('show').removeClass('hide').html('Ticket Added successfully!').fadeOut('slow');
					
					$('.strongWeak').hide();
					setTimeout( function(){ 
						$('#errorMsg , #successMsg').addClass('hide').removeClass('show').fadeOut('slow');
					  }  , 10000 );
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
    }
    return allIsOk    
});

$(document).on('submit','#edit_ticket',function (e) {
	e.preventDefault();
    var allIsOk = true;

	var tic_title = $('#tic_title').val();
	

	$('.invalidText').hide();

	if (tic_title == '') {
		$("#tic_title").focus();
		$("#tic_title_err").show().html('Please Enter Title');
        allIsOk = false;
    }

    if(allIsOk){
    	ds = $(this);
		var url = $(this).attr('action');
		var formData = new FormData(ds[0]);
		$.ajax({
			'async': false,
			url: url,
			type: "POST",
			data:formData,
    		dataType: "json",
		    processData: false,
		    contentType: false,			
			beforeSend:function(){
				ajaxindicatorstart();
			},
			success: function(res) {
				ajaxindicatorstop();
				if(res.success) {
					
					$('#errorMsg').addClass('hide').removeClass('show');
					$('#successMsg').addClass('show').removeClass('hide').html('Ticket Updated successfully!').fadeOut('slow');
					
					$('.strongWeak').hide();
					setTimeout( function(){ 
						$('#errorMsg , #successMsg').addClass('hide').removeClass('show').fadeOut('slow');
					  }  , 10000 );
					// window.location.reload();
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
    }
    return allIsOk    
});

$(document).on('submit','#add_ticket_account',function (e) {
	e.preventDefault();
    var allIsOk = true;

	var tic_title = $('#tic_title').val();
	var role_id = $('#role_id').val();
	

	$('.invalidText').hide();

	if (tic_title == '') {
		$("#tic_title").focus();
		$("#tic_title_err").show().html('Please Enter Title');
        allIsOk = false;
    }
    if (role_id == '') {
		$("#role_id").focus();
		$("#role_id_err").show().html('Please Select Intended User');
        allIsOk = false;
    }

    if(allIsOk){
    	ds = $(this);
		var url = $(this).attr('action');
		var formData = new FormData(ds[0]);
		$.ajax({
			'async': false,
			url: url,
			type: "POST",
			data:formData,
    		dataType: "json",
		    processData: false,
		    contentType: false,			
			beforeSend:function(){
				ajaxindicatorstart();
			},
			success: function(res) {
				ajaxindicatorstop();
				if(res.success) {
					$('#add_ticket_account')[0].reset();
					$('#errorMsg').addClass('hide').removeClass('show');
					$('#successMsg').addClass('show').removeClass('hide').html('Ticket Added successfully!').fadeOut('slow');
					
					$('.strongWeak').hide();
					setTimeout( function(){ 
						$('#errorMsg , #successMsg').addClass('hide').removeClass('show').fadeOut('slow');
					  }  , 10000 );
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
    }
    return allIsOk    
});

$(document).on('submit','#edit_ticket_account',function (e) {
	e.preventDefault();
    var allIsOk = true;

	var tic_title = $('#tic_title').val();
	

	$('.invalidText').hide();

	if (tic_title == '') {
		$("#tic_title").focus();
		$("#tic_title_err").show().html('Please Enter Title');
        allIsOk = false;
    }

    if(allIsOk){
    	ds = $(this);
		var url = $(this).attr('action');
		var formData = new FormData(ds[0]);
		$.ajax({
			'async': false,
			url: url,
			type: "POST",
			data:formData,
    		dataType: "json",
		    processData: false,
		    contentType: false,			
			beforeSend:function(){
				ajaxindicatorstart();
			},
			success: function(res) {
				ajaxindicatorstop();
				if(res.success) {
					
					$('#errorMsg').addClass('hide').removeClass('show');
					$('#successMsg').addClass('show').removeClass('hide').html('Ticket Updated successfully!').fadeOut('slow');
					
					$('.strongWeak').hide();
					setTimeout( function(){ 
						$('#errorMsg , #successMsg').addClass('hide').removeClass('show').fadeOut('slow');
					  }  , 10000 );
					// window.location.reload();
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
    }
    return allIsOk    
});

$(document).on('submit','#add_ticnote',function (e) {
	e.preventDefault();
    var allIsOk = true;

	var tic_activity_title = $('#tic_activity_title').val().trim();
	var tic_activity_des = $('#tic_activity_des').val().trim();
	var tic_activity_type = $('#tic_activity_type :selected').val().trim();
	

	$('.invalidText').hide();

	if (tic_activity_title == '') {
		$("#tic_activity_title").focus();
		$("#tic_activity_title_err").show().html('Please Enter Title');
        allIsOk = false;
    }else if (tic_activity_type == '') {
		$("#tic_activity_type").focus();
		$("#tic_activity_type_err").show().html('Please Select Activity Type');
        allIsOk = false;
    }else if (tic_activity_des == '') {
		$("#tic_activity_des").focus();
		$("#tic_activity_des_err").show().html('Please Enter Description');
        allIsOk = false;
    }

    if(allIsOk){
    	ds = $(this);
		var url = $(this).attr('action');
		var formData = new FormData(ds[0]);
		$.ajax({
			'async': false,
			url: url,
			type: "POST",
			data:formData,
    		dataType: "json",
		    processData: false,
		    contentType: false,			
			beforeSend:function(){
				ajaxindicatorstart();
			},
			success: function(res) {
				ajaxindicatorstop();
				if(res.success) {
					$("#addNote .close").click();
					$('#errorMsg').addClass('hide').removeClass('show');
					$('#successMsg').addClass('show').removeClass('hide').html('Activity Added successfully!').fadeOut('slow');
					
					$('.strongWeak').hide();
					setTimeout( function(){ 
						$('#errorMsg , #successMsg').addClass('hide').removeClass('show').fadeOut('slow');
					  }  , 10000 );
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
    }
    return allIsOk    
});

$(document).on('submit','#add_usercategory',function (e) {
	e.preventDefault();
    var allIsOk = true;

	var user_cat_name = $('#user_cat_name').val();
	var user_cat_status = $('#user_cat_status').val();
	var role_id = $('#role_id').val();

	$('.invalidText').hide();

	if (user_cat_name == '') {
		$("#user_cat_name").focus();
		$("#cat_name_err").show().html('Please Enter Category Name');
        allIsOk = false;
    }else if (role_id == '') {
		$("#role_id").focus();
		$("#role_id_err").show().html('Please Select Intended User');
        allIsOk = false;
    }else if (user_cat_status == '') {
		$("#user_cat_status").focus();
		$("#user_cat_status_err").show().html('Please Select Status');
        allIsOk = false;
    } 

    if(allIsOk){
    	ds = $(this);
		var url = $(this).attr('action');
		var formData = new FormData(ds[0]);
		$.ajax({
			'async': false,
			url: url,
			type: "POST",
			data:formData,
    		dataType: "json",
		    processData: false,
		    contentType: false,			
			beforeSend:function(){
				ajaxindicatorstart();
			},
			success: function(res) {
				ajaxindicatorstop();
				if(res.success) {
					$('#add_usercategory')[0].reset();
					$('#errorMsg').addClass('hide').removeClass('show');
					$('#successMsg').addClass('show').removeClass('hide').html('User Category Added successfully!').fadeOut('slow');
					
					$('.strongWeak').hide();
					setTimeout( function(){ 
						$('#errorMsg , #successMsg').addClass('hide').removeClass('show').fadeOut('slow');
					  }  , 10000 );
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
    }
    return allIsOk    
});

$(document).on('submit','#edit_usercategory',function (e) {
	e.preventDefault();
    var allIsOk = true;

	var prod_cat_name = $('#user_cat_name').val();
	var user_cat_status= $('#user_cat_status').val();
	var roles_id= $('#roles_id').val();
	

	$('.invalidText').hide();

	if (prod_cat_name == '') {
		$("#user_cat_name").focus();
		$("#cat_name_err").show().html('Please Enter Category Name');
        allIsOk = false;
    }else if (roles_id == '') {
		$("#roles_id").focus();
		$("#roles_id_err").show().html('Please Select Intended User');
        allIsOk = false;
    }else if(user_cat_status == ''){
		$("#user_cat_status").focus();
		$("#user_cat_status_err").show().html('Please Select Status');
        allIsOk = false;    	
    }

    if(allIsOk){
    	ds = $(this);
		var url = $(this).attr('action');
		var formData = new FormData(ds[0]);
		$.ajax({
			'async': false,
			url: url,
			type: "POST",
			data:formData,
    		dataType: "json",
		    processData: false,
		    contentType: false,			
			beforeSend:function(){
				ajaxindicatorstart();
			},
			success: function(res) {
				ajaxindicatorstop();
				if(res.success) {
					
					$('#errorMsg').addClass('hide').removeClass('show');
					$('#successMsg').addClass('show').removeClass('hide').html('User Category Updated successfully!').fadeOut('slow');
					
					$('.strongWeak').hide();
					setTimeout( function(){ 
						$('#errorMsg , #successMsg').addClass('hide').removeClass('show').fadeOut('slow');
					  }  , 10000 );
					// window.location.reload();
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
    }
    return allIsOk    
});

$(document).on('submit','#change_stage',function (e) {
	e.preventDefault();
    var allIsOk = true;

	var deal_stage = $('#deal_stages').val().trim();
	var app_activity_des = $('#app_activity_des').val().trim();
	
	$('.invalidText').hide();

	if (deal_stage == '') {
		$("#deal_stage").focus();
		$("#deal_stage_err").show().html('Please Select Stage');
        allIsOk = false;
    }

    if (app_activity_des == '') {
		$("#app_activity_des").focus();
		$("#app_activity_des_err").show().html('Please Enter Description');
        allIsOk = false;
    }
    if(allIsOk){
    	ds = $(this);
		var url = $(this).attr('action');
		var formData = new FormData(ds[0]);
		$.ajax({
			'async': false,
			url: url,
			type: "POST",
			data:formData,
    		dataType: "json",
		    processData: false,
		    contentType: false,			
			beforeSend:function(){
				// ajaxindicatorstart();
			},
			success: function(res) {
				// ajaxindicatorstop();
				if(res.success) {
					$("#ChangeStage .close").click();
					// console.log(res.view);
					$('#errorMsg').addClass('hide').removeClass('show');
					$('#successMsg').addClass('show').removeClass('hide').html('Deal Stage Changed successfully!').fadeOut('slow');
					$('.pileLine').html(res.view);
					
					$('.strongWeak').hide();

					setTimeout( function(){ 
						// window.location.reload();
						$('#errorMsg , #successMsg').addClass('hide').removeClass('show').fadeOut('slow');
					  }  , 10000 );
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
    }
    return allIsOk    
});

$(document).on('submit','#change_name',function (e) {
	e.preventDefault();
    var allIsOk = true;

	var name = $('#name').val().trim();
	
	$('.invalidText').hide();

	if (name == '') {
		$("#name").focus();
		$("#name_err").show().html('Please Enter Name');
        allIsOk = false;
    }
    if(allIsOk){
    	ds = $(this);
		var url = $(this).attr('action');
		var formData = new FormData(ds[0]);
		$.ajax({
			'async': false,
			url: url,
			type: "POST",
			data:formData,
    		dataType: "json",
		    processData: false,
		    contentType: false,			
			beforeSend:function(){
				// ajaxindicatorstart();
			},
			success: function(res) {
				// ajaxindicatorstop();
				if(res.success) {
					$("#changename .close").click();
					// console.log(res.view);
					$('#errorMsg').addClass('hide').removeClass('show');
					$('#successMsg').addClass('show').removeClass('hide').html('Name Changed successfully!').fadeOut('slow');
					$('.strongWeak').hide();

					setTimeout( function(){ 
						window.location.reload();
						$('#errorMsg , #successMsg').addClass('hide').removeClass('show').fadeOut('slow');
					  }  , 10000 );
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
    }
    return allIsOk    
});

$(document).on('submit','#editlicbusiness',function (e) {
	e.preventDefault();
    var allIsOk = true;
	var busrev_status = $('#busrev_status').val().trim();
	
	$('.invalidText').hide();

	if (busrev_status == '') {
		$("#busrev_status").focus();
		$("#busrev_status_err").show().html('Please Select Status');
        allIsOk = false;
    }

	$( ".pdffile" ).each(function(i,v) {
	  if($(this).attr('is_valid')==0){
	  	$(this).parents('.form-group').find('.pdferror').css('display','block');
	  	allIsOk = false;  
	  }
	});

    if(allIsOk){
    	ds = $(this);
		var url = $(this).attr('action');
		var formData = new FormData(ds[0]);
		$.ajax({
			'async': false,
			url: url,
			type: "POST",
			data:formData,
    		dataType: "json",
		    processData: false,
		    contentType: false,			
			beforeSend:function(){
				ajaxindicatorstart();
			},
			success: function(res) {
				ajaxindicatorstop();
				if(res.success) {
					$("#ChangeStage .close").click();
					$('#errorMsg').addClass('hide').removeClass('show');
					$('#successMsg').addClass('show').removeClass('hide').html('Business Review Updated successfully!').fadeOut('slow');
					
					$('.pdffile').val('');
					setTimeout( function(){ 
						$('#errorMsg , #successMsg').addClass('hide').removeClass('show').fadeOut('slow');
					  }  , 10000 );
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
    }
    return allIsOk    
});

$(document).on('submit','#editiabusiness',function (e) {
	e.preventDefault();
    var allIsOk = true;

	var busrev_status = $('#busrev_status').val().trim();
	
	$('.invalidText').hide();

	if (busrev_status == '') {
		$("#busrev_status").focus();
		$("#busrev_status_err").show().html('Please Select Status');
        allIsOk = false;
    }
    if(allIsOk){
    	ds = $(this);
		var url = $(this).attr('action');
		var formData = new FormData(ds[0]);
		$.ajax({
			'async': false,
			url: url,
			type: "POST",
			data:formData,
    		dataType: "json",
		    processData: false,
		    contentType: false,			
			beforeSend:function(){
				ajaxindicatorstart();
			},
			success: function(res) {
				ajaxindicatorstop();
				if(res.success) {
					$("#ChangeStage .close").click();
					$('#errorMsg').addClass('hide').removeClass('show');
					$('#successMsg').addClass('show').removeClass('hide').html('Business Review Updated successfully!').fadeOut('slow');
					
					$('.strongWeak').hide();
					setTimeout( function(){ 
						// window.location.reload();
						$('#errorMsg , #successMsg').addClass('hide').removeClass('show').fadeOut('slow');
					  }  , 10000 );
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
    }
    return allIsOk    
});

 $(document).ready(function(){
       $('body').on('click','.addDesc',function(){
           var ad = $(this).attr('value');
           console.log(ad);
            $('#addDesc .add_desc').html(ad);
            $('#addDesc').modal('show');
        });
    });

$(document).on('change','#deal_stages',function(){
		var stage = $(this).val();
   if(stage == 5){
   	  $('#ChangeStage').modal('hide');
   	  $('#stage_modal').modal('show');
   }
  
});

$(document).on('click','.ready',function(){
           var ad =  $(this).attr('value');
           if (ad == 'Yes') {
   	  		 $('#stage_modal').modal('hide');
           	 $('#ChangeStage').modal('show');
           }else{

           	 $('#stage_modal').modal('hide');
           	 $('#ChangeStage').modal('show');
           	 $('#deal_stages').val('');
           }
          
 });

$("#profilePicBtn").click(function () {
	$('#uploadtype').val('cto');
  		$(".imgInput").trigger('click');

});

$(document).on('submit','#updateproduct',function (e) {
	e.preventDefault();
		ds = $(this);
		var url = $(this).attr('action');
		var formData = new FormData(ds[0]);
		$.ajax({
			'async': false,
			url: url,
			type: "POST",
			data:formData,
    		dataType: "json",
		    processData: false,
		    contentType: false,			
			beforeSend:function(){
				ajaxindicatorstart();
			},
			success: function(res) {
				ajaxindicatorstop();
				if(res.success) {
					
					$('#errorMsg').addClass('hide').removeClass('show');
					$('#successMsg').addClass('show').removeClass('hide').html('Product Updated successfully!').fadeOut('slow');
					
					$('.strongWeak').hide();
					setTimeout( function(){ 
						$('#errorMsg , #successMsg').addClass('hide').removeClass('show').fadeOut('slow');
					  }  , 10000 );
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

$(document).on('submit','#add_audience',function (e) {
	e.preventDefault();
    var allIsOk = true;

	var name = $('#name').val().trim();
	var email = $('#email').val();
	var businessname = $('#businessname').val();
	var user = $('#user').val();
	var status = $('#status').val();

	$('.invalidText').hide();

	if (name == '') {
		$("#name").focus();
		$("#name_err").show().html('Please Enter First Name');
        allIsOk = false;
    } if(businessname == ''){
		$("#businessname").focus();
		$("#businessname_err").show().html('Please Enter Business Name');
        allIsOk = false;    	
    } if(email == '' || !validateEmail(email)){
		$("#email").focus();
		$("#email_err").show().html('Please Enter Email Address');
        allIsOk = false;    	
    } if(user == ''){
		$("#user").focus();
		$("#user_err").show().html('Please Select Intended User');
        allIsOk = false;    	
    }if(status == ''){
		$("#status").focus();
		$("#status_err").show().html('Please Select Status');
        allIsOk = false;    	
    }

    if(allIsOk){
    	ds = $(this);
		var url = $(this).attr('action');
		var formData = new FormData(ds[0]);
		$.ajax({
			'async': false,
			url: url,
			type: "POST",
			data:formData,
    		dataType: "json",
		    processData: false,
		    contentType: false,			
			beforeSend:function(){
				ajaxindicatorstart();
			},
			success: function(res) {
				ajaxindicatorstop();
				if(res.success) {
					$('#add_audience')[0].reset();
					
					$('#errorMsg').addClass('hide').removeClass('show');
					$('#successMsg').addClass('show').removeClass('hide').html('Audience Added successfully!').fadeOut('slow');
					
					$('.strongWeak').hide();
					setTimeout( function(){ 
						$('#errorMsg , #successMsg').addClass('hide').removeClass('show').fadeOut('slow');
					  }  , 10000 );
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
    }
    return allIsOk    
});

$(document).on('submit','#edit_audience',function (e) {
	e.preventDefault();
    var allIsOk = true;

	var name = $('#name').val().trim();
	var email = $('#email').val();
	var businessname = $('#businessname').val();
	var user = $('#user').val();
	var status = $('#status').val();

	$('.invalidText').hide();

	if (name == '') {
		$("#name").focus();
		$("#name_err").show().html('Please Enter First Name');
        allIsOk = false;
    } if(businessname == ''){
		$("#businessname").focus();
		$("#businessname_err").show().html('Please Enter Business Name');
        allIsOk = false;    	
    } if(email == '' || !validateEmail(email)){
		$("#email").focus();
		$("#email_err").show().html('Please Enter Email Address');
        allIsOk = false;    	
    } if(user == ''){
		$("#user").focus();
		$("#user_err").show().html('Please Select Intended User');
        allIsOk = false;    	
    }if(status == ''){
		$("#status").focus();
		$("#status_err").show().html('Please Select Status');
        allIsOk = false;    	
    }

    if(allIsOk){
    	ds = $(this);
		var url = $(this).attr('action');
		var formData = new FormData(ds[0]);
		$.ajax({
			'async': false,
			url: url,
			type: "POST",
			data:formData,
    		dataType: "json",
		    processData: false,
		    contentType: false,			
			beforeSend:function(){
				ajaxindicatorstart();
			},
			success: function(res) {
				ajaxindicatorstop();
				if(res.success) {
					
					$('#errorMsg').addClass('hide').removeClass('show');
					$('#successMsg').addClass('show').removeClass('hide').html('Audience Updated successfully!').fadeOut('slow');
					
					
					$('.strongWeak').hide();
					setTimeout( function(){ 
						$('#errorMsg , #successMsg').addClass('hide').removeClass('show').fadeOut('slow');
					  }  , 10000 );
					//window.location.reload();
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
    }
    return allIsOk    
});


$(document).on('submit','#add_audit',function (e) {
	e.preventDefault();
    var allIsOk = true;

	// var businessname = $('#businessname').val();
	var end_date = $('#end_date').val();
	var issue_date = $('#issue_date').val();
	var status = $('#status').val();

	$('.invalidText').hide();

	
	 if(issue_date == ''){
		$("#issue_date").focus();
		$("#issue_date_err").show().html('Please Enter Issue Date');
        allIsOk = false;    	
    } if(end_date == ''){
		$("#end_date").focus();
		$("#end_date_err").show().html('Please Enter End Date');
        allIsOk = false;    	
    }if(status == ''){
		$("#status").focus();
		$("#status_err").show().html('Please Select Status');
        allIsOk = false;    	
    }

    if(allIsOk){
    	ds = $(this);
		var url = $(this).attr('action');
		var formData = new FormData(ds[0]);
		$.ajax({
			'async': false,
			url: url,
			type: "POST",
			data:formData,
    		dataType: "json",
		    processData: false,
		    contentType: false,			
			beforeSend:function(){
				ajaxindicatorstart();
			},
			success: function(res) {
				ajaxindicatorstop();
				if(res.success) {
					$('#add_audit')[0].reset();
					
					$('#errorMsg').addClass('hide').removeClass('show');
					$('#successMsg').addClass('show').removeClass('hide').html('Audit Added successfully!').fadeOut('slow');
					
					$('.strongWeak').hide();
					setTimeout( function(){ 
						$('#errorMsg , #successMsg').addClass('hide').removeClass('show').fadeOut('slow');
					  }  , 10000 );
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
    }
    return allIsOk    
});

$(document).on('submit','#edit_audit',function (e) {
	e.preventDefault();
    var allIsOk = true;

	// var businessname = $('#businessname').val();
	var end_date = $('#end_date').val();
	var issue_date = $('#issue_date').val();
	var status = $('#status').val();

	$('.invalidText').hide();

	 if(issue_date == ''){
		$("#issue_date").focus();
		$("#issue_date_err").show().html('Please Enter Issue Date');
        allIsOk = false;    	
    } if(end_date == ''){
		$("#end_date").focus();
		$("#end_date_err").show().html('Please Enter End Date');
        allIsOk = false;    	
    }if(status == ''){
		$("#status").focus();
		$("#status_err").show().html('Please Select Status');
        allIsOk = false;    	
    }

    if(allIsOk){
    	ds = $(this);
		var url = $(this).attr('action');
		var formData = new FormData(ds[0]);
		$.ajax({
			'async': false,
			url: url,
			type: "POST",
			data:formData,
    		dataType: "json",
		    processData: false,
		    contentType: false,			
			beforeSend:function(){
				ajaxindicatorstart();
			},
			success: function(res) {
				ajaxindicatorstop();
				if(res.success) {
					
					$('#errorMsg').addClass('hide').removeClass('show');
					$('#successMsg').addClass('show').removeClass('hide').html('Audit Updated successfully!').fadeOut('slow');
					
					
					$('.strongWeak').hide();
					setTimeout( function(){ 
						$('#errorMsg , #successMsg').addClass('hide').removeClass('show').fadeOut('slow');
					  }  , 10000 );
					//window.location.reload();
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
    }
    return allIsOk    
});

$(document).on('submit','#edit_whisle',function (e) {
	e.preventDefault();
    var allIsOk = true;

	// var businessname = $('#businessname').val();
	var status = $('#tic_status').val();
	

	$('.invalidText').hide();

	if(status == ''){
		$("#tic_status").focus();
		$("#tic_status_err").show().html('Please Select Status');
        allIsOk = false;    	
    }

    if(allIsOk){
    	ds = $(this);
		var url = $(this).attr('action');
		var formData = new FormData(ds[0]);
		$.ajax({
			'async': false,
			url: url,
			type: "POST",
			data:formData,
    		dataType: "json",
		    processData: false,
		    contentType: false,			
			beforeSend:function(){
				ajaxindicatorstart();
			},
			success: function(res) {
				ajaxindicatorstop();
				if(res.success) {
					
					$('#errorMsg').addClass('hide').removeClass('show');
					$('#successMsg').addClass('show').removeClass('hide').html('Whisle Blower Updated successfully!').fadeOut('slow');
					
					
					$('.strongWeak').hide();
					setTimeout( function(){ 
						$('#errorMsg , #successMsg').addClass('hide').removeClass('show').fadeOut('slow');
					  }  , 10000 );
					//window.location.reload();
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
    }
    return allIsOk    
});

$(document).on('submit','#uploadcsv',function (e) {
	e.preventDefault();
    var allIsOk = true;

	// var businessname = $('#businessname').val();
	var file = $('#file').val();
	var exts = ['csv'];
	var get_ext = file.split('.');
	get_ext = get_ext.reverse();

	$('.invalidText').hide();

	if(file==''){
		$("#file").focus();
		$("#file_err").show().html('Please Upload CSV File !');
        allIsOk = false; 
	    
	}else if ( $.inArray ( get_ext[0].toLowerCase(), exts ) > -1 ){
	  return true;
	} else {
		$("#file").focus();
		$("#file_err").show().html('Required Only CSV File !');
        allIsOk = false; 
	 
	}
	

    if(allIsOk){
    	ds = $(this);
		var url = $(this).attr('action');
		var formData = new FormData(ds[0]);
		$.ajax({
			'async': false,
			url: url,
			type: "POST",
			data:formData,
    		dataType: "json",
		    processData: false,
		    contentType: false,			
			beforeSend:function(){
				ajaxindicatorstart();
			},
			success: function(res) {
				ajaxindicatorstop();
				if(res.success) {
					
					$('#errorMsg').addClass('hide').removeClass('show');
					// $('#successMsg').addClass('show').removeClass('hide').html('CSV Uploaded successfully!').fadeOut('slow');
					$('.tableData').html(res.data);
					
					$('.strongWeak').hide();
					setTimeout( function(){ 
						$('#errorMsg , #successMsg').addClass('hide').removeClass('show').fadeOut('slow');
					  }  , 10000 );
					//window.location.reload();
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
    }
    return allIsOk    
});

$(document).on('submit','#import',function (e) {
	e.preventDefault();
    var allIsOk = true;

	// var businessname = $('#businessname').val();
	var map = $('#map').val();
	

	$('.invalidText').hide();

	if(map == ''){
		$("#map").focus();
		$("#map_err").show().html('Please Select Column Name');
        allIsOk = false;    	
    }

    if(allIsOk){
    	ds = $(this);
		var url = $(this).attr('action');
		var formData = new FormData(ds[0]);
		$.ajax({
			'async': false,
			url: url,
			type: "POST",
			data:formData,
    		dataType: "json",
		    processData: false,
		    contentType: false,			
			beforeSend:function(){
				// ajaxindicatorstart();
			},
			success: function(res) {
				// ajaxindicatorstop();
				if(res.success) {
					

					window.location.reload();
					$('#errorMsg').addClass('hide').removeClass('show');
					$('#successMsg').addClass('show').removeClass('hide').html('CSV Uploaded successfully!').fadeOut('slow');
					
					
					$('.strongWeak').hide();
					setTimeout( function(){ 
						$('#errorMsg , #successMsg').addClass('hide').removeClass('show').fadeOut('slow');
					  }  , 10000 );
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
    }
    return allIsOk    
});
