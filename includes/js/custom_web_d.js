
$(document).on('submit','#add_product',function (e) {
	e.preventDefault();
    var allIsOk = true;

    
	var product_name = $('#product_name').val();
	var product_sku = $('#product_sku').val();
	var prod_cat_id = $('#prod_cat_id :selected').val().trim();
	var supplier_id = $('#supplier_id :selected').val().trim();
	// var role_id = $('#role_id :selected').val().trim();
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
    } if(w_price == '' || isNaN(w_price) || w_price<=0){
		$("#wsale_price").focus();
		$("#wsale_price_err").show().html('Please Enter Wholesale Price');
        allIsOk = false;    	
    } if(l_price == '' || isNaN(l_price) || l_price<=0){
		$("#l_price").focus();
		$("#l_price_err").show().html('Please Enter Licensee Price');
        allIsOk = false;    	
    }else if(parseFloat(l_price) <= parseFloat(w_price)){
		$("#l_price").focus();
		$("#l_price_err").show().html('Licensee Price must be greater than Wholesale Price');
        allIsOk = false;    
    }
    if(ia_price == '' || isNaN(ia_price) || ia_price<=0){
		$("#ia_price").focus();
		$("#ia_price_err").show().html('Please Enter Industry Association Price');
        allIsOk = false;    	
    }else if(parseFloat(ia_price) <= parseFloat(l_price)){
		$("#ia_price").focus();
		$("#ia_price_err").show().html('Industry Association Price must be greater than Licensee Price');
        allIsOk = false;    
    }
    if(c_price == '' || isNaN(c_price) || c_price<=0){
		$("#c_price").focus();
		$("#c_price_err").show().html('Please Enter Consumer Price');
        allIsOk = false;    	
    }
	else if(parseFloat(c_price) <= parseFloat(ia_price)){
		$("#c_price").focus();
		$("#c_price_err").show().html('Consumer Price must be greater than Industry Association Price');
        allIsOk = false;    
    }
     if(prod_dis != ''){
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
    } 
  //   if(role_id == ''){
		// $("#role_id").focus();
		// $("#role_id_err").show().html('Please Select Intended Type');
  //       allIsOk = false;    	
  //   }

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
	// var role_id = $('#role_id :selected').val().trim();
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
    }
    if(product_sku == ''){
		$("#product_sku").focus();
		$("#product_sku_err").show().html('Please Enter Product SKU');
        allIsOk = false;    	
    }
    if(prod_cat_id == ''){
		$("#prod_cat_id").focus();
		$("#prod_cat_id_err").show().html('Please Select Category');
        allIsOk = false;    	
    }
    if(supplier_id == ''){
		$("#supplier_id").focus();
		$("#supplier_id_err").show().html('Please Select Supplier');
        allIsOk = false;    	
    }
    if(type == ''){
		$("#type").focus();
		$("#type_err").show().html('Please Select Type');
        allIsOk = false;    	
    }
    if(w_price == '' || isNaN(w_price) || w_price<=0){
		$("#wsale_price").focus();
		$("#wsale_price_err").show().html('Please Enter Wholesale  Price');
        allIsOk = false;    	
    }
    if(l_price == '' || isNaN(l_price) || l_price<=0){
		$("#l_price").focus();
		$("#l_price_err").show().html('Please Enter Licensee Price');
        allIsOk = false;    	
    }else if(parseFloat(l_price) <= parseFloat(w_price)){
		$("#l_price").focus();
		$("#l_price_err").show().html('Licensee Price must be greater than Wholesale Price');
        allIsOk = false;    
    }
    if(ia_price == '' || isNaN(ia_price) || ia_price<=0){
		$("#ia_price").focus();
		$("#ia_price_err").show().html('Please Enter Industry Association Price');
        allIsOk = false;    	
    }else if(parseFloat(ia_price) <= parseFloat(l_price)){
		$("#ia_price").focus();
		$("#ia_price_err").show().html('Industry Association Price must be greater than Licensee Price');
        allIsOk = false;    
    }

    if(c_price == '' || isNaN(c_price) || c_price<=0){
		$("#c_price").focus();
		$("#c_price_err").show().html('Please Enter Consumer Price');
        allIsOk = false;    	
    }else if(parseFloat(c_price) <= parseFloat(ia_price)){
		$("#c_price").focus();
		$("#c_price_err").show().html('Consumer Price must be greater than Industry Association Price');
        allIsOk = false;    
    }
console.log('prod_dis',prod_dis);
    if(prod_dis != '' && parseFloat(prod_dis)>0){
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
    }
  //   else if(role_id == ''){
		// $("#role_id").focus();
		// $("#role_id_err").show().html('Please Select Intended Type');
  //       allIsOk = false;    	
  //   }
    	
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
					$("#add_note")[0].reset();
					
					$('#errorMsg').addClass('hide').removeClass('show');
					$('#successMsg').addClass('show').removeClass('hide').html('Activity Added successfully!').fadeOut('slow');
					
					$('.strongWeak').hide();
					setTimeout( function(){ 
						$('#errorMsg , #successMsg').addClass('hide').removeClass('show').fadeOut('slow');
									loadData();
					  }  , 1000 );
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
	var nameReg = /^[A-Za-z-0-9]+$/;
	if(pb_name == '') {
		$("#pb_name").focus();
		$("#name_err").show().html('Please Enter Page Name');
        allIsOk = false;
    }else if(pb_name.length >255){
    	$("#pb_name").focus();
		$("#name_err").show().html("Page Name Length exceeds the maximum limit of 255 charachters ");
        allIsOk = false;
    }else if(!pb_name.match(nameReg)){
		$("#pb_name").focus();
		$("#name_err").show().html('Please Enter Only alphanumeric Page Name');
        allIsOk = false;
    }
    if(pb_slug == ''){
		$("#pb_slug").focus();
		$("#slug_err").show().html('Please Enter Page Slug');
        allIsOk = false;    	
    }else if(!nameReg.test(pb_slug)){
    	$("#pb_slug").focus();
		$("#slug_err").show().html('Only Charachters And Numbers Allow !');
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
		$("#content_err").show().html('Please Enter The Page Content');
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
					$('#tic_parent_id').val('').trigger('change');
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
	var tic_user = $('#tic_user').find('option:selected').length;
	var desript = $('#tic_desc').val().trim();
	var tic_cat_id = $('#tic_cat_id :selected').val();

	$('.invalidText').hide();

	if (tic_title == '') {
		$("#tic_title").focus();
		$("#tic_title_err").show().html('Please enter title');
        allIsOk = false;
    }
	if (tic_user==0) {
		$("#tic_user").focus();
		$("#tic_users_err").show().html('Please select user');
        allIsOk = false;
    }
	if (tic_cat_id==0) {
		$("#tic_cat_id").focus();
		$("#tic_cat_id_err").show().html('Please select ticekt category');
        allIsOk = false;
    }    


	if (desript=='') {
		$("#desript").focus();
		$("#tic_desc_err").show().html('Please enter description');
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
					$('#tic_user,#tic_cat_id').val(null).trigger('change');
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
					$("#add_ticnote")[0].reset();
					
					$('#errorMsg').addClass('hide').removeClass('show');
					$('#successMsg').addClass('show').removeClass('hide').html('Activity Added successfully!').fadeOut('slow');
					
					$('.strongWeak').hide();
					setTimeout( function(){ 
						$('#errorMsg , #successMsg').addClass('hide').removeClass('show').fadeOut('slow');
							loadData();
					  }  , 1000 );
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
					$('#successMsg').addClass('show').removeClass('hide').html('Award Level Added successfully!').fadeOut('slow');
					
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
					$('#successMsg').addClass('show').removeClass('hide').html('Award Level Updated successfully!').fadeOut('slow');
					
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

	var deal_stage = $('#deal_stages').val();
	var app_activity_des = $('#app_activity_des').val().trim();
	var stage = $('#st').val();

	$('.invalidText').hide();

	if (deal_stage == '') {
		$("#deal_stage").focus();
		$("#deal_stage_err").show().html('Please Select Stage');
        allIsOk = false;
    }else if(deal_stage== stage){
    	$("#deal_stage").focus();
		$("#deal_stage_err").show().html('You have already in this stage');
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
					$(document).find('#change_stage')[0].reset();
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
					$('.pileLine').html(res.view);
					$('#errorMsg').addClass('hide').removeClass('show');
					$('#successMsg').addClass('show').removeClass('hide').html('Name Changed successfully!').fadeOut('slow');
					$('.strongWeak').hide();

					setTimeout( function(){ 
						
						$('#errorMsg , #successMsg').addClass('hide').removeClass('show').fadeOut('slow');
					  }  , 5000 );
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
		// var className = $('#assign').attr('class');
		var stage =  $('#ChangeStage #st').val();
		var className = $(this).find(":selected").attr('class');
		if(className=='assign'){
			$('#ChangeStage').modal('hide');
			$('#stage_modal #stage').val(stage);
   	  		$('#stage_modal').modal('show');
		}
});

$(document).on('click','.ready',function(){
           var stage =  $('#stage_modal #stage').val();
           var ad =  $(this).attr('value');
           console.log(ad);
           console.log(stage);
           if (ad == 'Yes') {
   	  		 $('#stage_modal').modal('hide');
           	 $('#ChangeStage').modal('show');
           }else{

           	 $('#stage_modal').modal('hide');
           	 $('#deal_stages').val(stage);
           	 $('#ChangeStage').modal('show');
           	 
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
	var urole_id = $('#urole_id').val();

console.log('status',status);

	$('.invalidText').hide();

	if(issue_date == '' && status==3){
		//$("#issue_date").focus();
		$("#issue_date_err").show().html('Please Enter Issue Date');
        allIsOk = false;    	
    } 

    if(end_date == '' && status==3){
		//$("#end_date").focus();
		$("#end_date_err").show().html('Please Enter End Date');
        allIsOk = false;    	
    }

    if(urole_id ==5 && status==2){
    	if($('#file').val()==''){
			$("#file").focus();
			$("#file_err").show().html('Please Upload File');
	        allIsOk = false;    	   		
    	}
    }else if(urole_id ==1 && status==3){
    	if($('#certificate_file').val()==''){
			$("#certificate_file").focus();
			$("#certificate_file_err").show().html('Please Upload File');
	        allIsOk = false;    	   		
    	}
    }

    if((urole_id ==1 && status==0) || (urole_id ==5 && status=='')){
		$("#status").focus();
		$("#status_err").show().html('Please Select Status');
        allIsOk = false;    
    }
  //   if(status == ''){
		// $("#status").focus();
		// $("#status_err").show().html('Please Select Status');
  //       allIsOk = false;    	
  //   }

    if(allIsOk){
    	ds = $(this);
		var url = $(this).attr('action');
		var formData = new FormData(ds[0]);
		$.ajax({
			async: false,
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
					
					if(urole_id ==5 && status==2){
						//$('#status').val('1').trigger('change');
						$('#file').val('');
						$('#submitbtn').hide();

					}else if(urole_id ==1 && status==3){
						$('#submitbtn').hide();
						$('#certificate_file').val('');	
					}

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
	  allIsOk = true;
	}else{
		$("#file").focus();
		$("#file_err").show().html('Required Only CSV File !');
        allIsOk = false; 
	 
	}
	
	console.log(allIsOk);
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
				console.log(res);
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
