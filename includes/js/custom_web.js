$('.invalidText').css('display','none');
$("form").attr('autocomplete', 'off'); // Switching form autocomplete attribute to off


$('.monthyear').datepicker({
   autoclose:true,
   format: 'mm/yyyy',
    viewMode: "months", 
    minViewMode: "months"
})

$('.monthyear_from').datepicker({
	autoclose:true,
	format: 'mm/yyyy',
	viewMode: "months", 
	minViewMode: "months"
}).on('changeDate', function () {
    var fromDate = $(this).val();
    var to_date = $(this).parents('.row').find('.monthyear_to');
    to_date.val(fromDate);
	to_date.datepicker('destroy');
    to_date.datepicker({
		startDate:fromDate, 
		autoclose:true,
		format: 'mm/yyyy', 
		viewMode: "months", 
		minViewMode: "months"	   
	});
});

$('.monthyear_from_dis_next').datepicker({
	autoclose:true,
	format: 'mm/yyyy',
	viewMode: "months", 
	minViewMode: "months",
	endDate: "-1M",
}).on('changeDate', function () {
    var fromDate = $(this).val();
    var to_date = $(this).parents('.row').find('.monthyear_to');
    to_date.val(fromDate);
	to_date.datepicker('destroy');
    to_date.datepicker({
		startDate:fromDate, 
		autoclose:true,
		format: 'mm/yyyy', 
		viewMode: "months", 
		minViewMode: "months"	   
	});
});


$('.datepicker').datepicker({
   autoclose:true,
   format: 'mm/dd/yyyy',
})

$('.dpic_dsbl_prev').datepicker({
   autoclose:true,
   format: 'mm/dd/yyyy', 
   startDate:'0d' 
});

if($('.datepicker_from').length>0){
	var start_date_edit = $('.datepicker_from').val();
}else{ var start_date_edit = '0d'; }
$('.endDate_edit').datepicker({
   autoclose:true,
   format: 'mm/dd/yyyy', 
   startDate:start_date_edit 
});

$('.datepicker_from').datepicker({
   autoclose:true,
   format: 'mm/dd/yyyy',
   startDate: '-0d'
}).on('changeDate', function () {
    var fromDate = $(this).val();
    var to_date = $(this).parents('.row').find('.datepicker_to');
    //to_date.val(fromDate+1);
    to_date.val(add_oneyear(fromDate));
	to_date.datepicker('destroy');
    to_date.datepicker({
	   startDate:fromDate, 
	   autoclose:true,
	   format: 'mm/dd/yyyy', 
	})
});


$('.dash_datepicker_from').datepicker({
   autoclose:true,
   format: 'mm/dd/yyyy',
   startDate: '-0d'
}).on('changeDate', function () {
    var fromDate = $(this).val();
    var to_date = $(this).parents('.row').find('.datepicker_to');
    //to_date.val(add_onemonth(fromDate));
    to_date.val(fromDate);
	to_date.datepicker('destroy');
    to_date.datepicker({
	   startDate:fromDate, 
	   autoclose:true,
	   format: 'mm/dd/yyyy', 
	})
});

function alphanumeric_space_only(ds){
	var regex = /^[0-9a-zA-Z ]*$/;
	return regex.test(ds);
}

function validate_pass(ds){
	var dsval = $(ds).val();
	var stre_field = $(ds).parents('.form-group').find('.strongWeak');
	stre_field.show();
	var specialChars = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/gi;
    var regex = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[^\w\s]).{8,}$/;

	var percent = 0;
	//====check length
	if(dsval.length >=8){
		if(dsval.length >128){
			return { success : false, msg : 'Password Exceed Maximum Allowed Length' };
		}else{
			percent +=20;
		}
		
	}
	
	//====check uppercase
	if(dsval.replace(/[^A-Z]/g, "").length>=1){
		percent +=20;
	}
	//====check lowercase
	if(dsval.replace(/[^a-z]/g, "").length>=1){
		percent +=20;
	}

	//====check numbers
	if(dsval.replace(/[^0-9]/g, "").length>=1){
		percent +=20;
	}
	//====check special charachter
	if(dsval.match(specialChars)){
		percent +=20;
	}

	if(parseInt(percent)<=25){
		if(parseInt(percent)==0){
			stre_field.find('.stren_line').css({"background": "red","width":"10%"});
		}else{
			stre_field.find('.stren_line').css({"background": "red","width":percent+"%"});
		}
		stre_field.find('.stren_text').html('Very Weak');
		return { success : false, msg : 'Your Password is Weak' };

	}

	if(parseInt(percent)>25 && parseInt(percent)<50){
		stre_field.find('.stren_line').css({"background": "red","width":percent+"%"});
		stre_field.find('.stren_text').html('Weak');
		return { success : false, msg : 'Your Password is Weak' };

	}

	if(parseInt(percent)>50 && parseInt(percent)<100){
		stre_field.find('.stren_line').css({"background": "#8de6498c","width":percent+"%"});
		stre_field.find('.stren_text').html('Medium');
		return { success : false, msg : 'Your Password is Medium' };

	}

	if(parseInt(percent)==100 && regex.test(dsval)){
		stre_field.find('.stren_line').css({"background": "#49e663","width":percent+"%"});
		stre_field.find('.stren_text').html('Strong');

		var pass = $('#password').val().trim();
		var cpass = $('#cpassword').val().trim();

		if(pass !='' && cpass !=''){
			if(pass != cpass) {
			    return { success : false, msg : "Your Password doesn't match" };
			} else {
			    $('#p_err ,#cp_err').hide();
			    return { success : true };
			}
		}else{
			return { success : true };
		}	
	}
}

$('.no-paste').on("cut copy paste",function(e) {
  e.preventDefault();
});

$(".toggle-password").click(function() {
	$(this).toggleClass("fa-eye fa-eye-slash");
	var input = $($(this).attr("toggle"));
	if (input.attr("type") == "password") {
		input.attr("type", "text");
	} 
	else {
		 input.attr("type", "password");
	}
});

function validateEmail(email){
    var reg = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;		
	if (reg.test(email) == false) 
	{
		return false;
	}else{
	}
    return true;
}

function validateMobile(mobile){
	var mobileregex = /^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[ \s\/0-9]*$/;
	if(mobile!=''){
		if (!mobile.match(mobileregex)) 
		{
			return false;
		}else{
			return true;
		}
	}else{
		return false;
	}
}

$("input").keyup(function(){
	if($(this).attr("type")=="text" || $(this).attr("type")=="password"){
		var err = $(this).parents('.form-group').find('.invalidText');
		if(err.is(':visible')){ err.css('display','none');
		}
	}else if($(this).attr("type")=="email" && ($(this).val()=='' || validateEmail($(this).val()))){
		var err = $(this).parents('.form-group').find('.invalidText');
		if(err.is(':visible')){ err.css('display','none');		}
	}
});

$("select").on('change',function(){
	if($(this).val()!=""){
		var err = $(this).parents('.form-group').find('.invalidText');
		if(err.is(':visible')){ err.css('display','none');
		}
	}
});


$(document).on('submit','#add_banner',function (e) {
	e.preventDefault();
    var allIsOk = true;
	$('.invalidText').hide();
	
	var ba_name = $('#ba_name').val();
	var ba_image = $('#ba_image').val().trim();
	var ba_roles_id = $('#ba_roles_id').val().trim();
	var ba_link = $('#ba_link').val().trim();
	var ba_status = $('#ba_status :selected').val().trim();
	var ba_bannertype = $('#ba_bannertype :selected').val().trim();
	var publish_date = $('#publish_date').val().trim();

	if (ba_name == '') {
		$("#ba_name").focus();
		$("#ba_name_err").show().html('Please Enter Banner Name');
        allIsOk = false;
    }
    if(ba_image == ''){
		$("#ba_image").focus();
		$("#ba_image_err").show().html('Please Upload Banner Image');
        allIsOk = false;    	
    }
    if(ba_roles_id == ''){
		$("#ba_roles_id").focus();
		$("#ba_roles_err").show().html('Please Select Intended User');
        allIsOk = false;    	
    }
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
					$('#add_banner')[0].reset();
					 $('.imgInput, .hiddenfile').val('');
					 $('#ba_roles_id, #ba_status, #ba_bannertype').val(null).trigger('change');

					$('#errorMsg').addClass('hide').removeClass('show');
					$('#successMsg').addClass('show').removeClass('hide').html('Product Added successfully!').fadeOut('slow');
					
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

$(document).on('submit','#add_page',function (e) {
	e.preventDefault();
    var allIsOk = true;
	$('.invalidText').hide();
	
	var pb_name = $('#pb_name').val();
	var pb_slug = $('#pb_slug').val().trim();
	var pb_role_id = $('#pb_role_id :selected').val().trim();
	var pb_status = $('#pb_status :selected').val().trim();
	var pb_featureimage = $('#pb_featureimage').val().trim();
	//var pb_cta_label = $('#pb_cta_label').val().trim();
	//var pb_cta_text = $('#pb_cta_text').val().trim();
	//var pb_publishdate = $('#pb_publishdate').val().trim();
	var content = CKEDITOR.instances['cta_desc'].getData().replace(/<[^>]*>/gi, '').length;
//var nameReg = /^[A-Za-z-0-9]+$/;
var nameReg = /^[a-zA-Z0-9\-\s]+$/


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
    if(pb_featureimage == ''){
		$("#pb_featureimage").focus();
		$("#featureimage_err").show().html('Please Upload Feature Image');
        allIsOk = false;    	
    }
  //   if(pb_cta_label == ''){
		// $("#pb_cta_label").focus();
		// $("#label_err").show().html('Please Enter CTA Label');
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
					$('#add_page')[0].reset();
					CKupdate();
					$('.imgInput, .hiddenfile').val('');

					$('#pb_role_id, #pb_status').val(null).trigger('change');

					$('#errorMsg').addClass('hide').removeClass('show');
					$('#successMsg').addClass('show').removeClass('hide').html('Page Added successfully!').fadeOut('slow');
					
					$('.strongWeak').hide();
					setTimeout( function(){ 
						$('#errorMsg , #successMsg').addClass('hide').removeClass('show').fadeOut('slow');
					  }  , 10000 );
				}else{

					console.log(res);
					if(res.err_field !=''){
						$('#'+res.err_field).html(res.msg).show();
						console.log(res.err_field);
						console.log(res.msg);
					}else{
						$('#errorMsg').addClass('show').removeClass('hide').html(res.msg);
						$('#successMsg').addClass('hide').removeClass('show');
					}
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


$(document).on('keyup', '#business', function(e) {
	$('#business_id').val('');
	if($('#cp_business_id').length>0){ var bid = $('#cp_business_id').val(); }else{ bid =''; }
	e.preventDefault();
	var term=$(this).val();
	if(term!='' && term.length>=3){

		$.ajax({
			url: site_url+'lead/contact/getBusinessList',
			data: ({term: term,bid:bid}),
			dataType: 'json', 
			type: 'post',
			beforeSend:function(){

			},
			success: function(data) {
				if(data.status=='success'){
					$('#busContainer').html(data.data);
					$('#businessDiv').hide();
				}else{
					$('#busContainer').html('');
					$('#businessDiv').show();
				}
			}             
		});
		
	}else{
		$('#busContainer').html('');
	}
});




$(document).on('click', '.categoryItem', function() {
	var cat=$(this).html();
	var catVal=$(this).attr('data-val');
	var busname = $(this).html();
	$('#busContainer').html('');
	$('#business_id').val(catVal);
	$('#business').val(busname);
});


/*
$(document).on('keyup', '#cp_name', function(e) {
	$('#business_id , #contact_id').val('');
	//$('#addbusinessDiv, #businessDivOne').hide();
	e.preventDefault();
	var term=$(this).val();
	if(term!='' && term.length>=3){

		$.ajax({
			url: site_url+'lead/deal/getCP',
			data: ({term: term}),
			dataType: 'json', 
			type: 'post',
			beforeSend:function(){

			},
			success: function(data) {
				if(data.status=='success'){
					$('#cpContainer').html(data.data);
					
					$('#addbusinessDiv').hide();
				}else{
					$('#addbusinessDiv').show();
					$('#businessDivOne').hide();
					$('#cpContainer').html('');
				}
			}             
		});
		
	}else{
		$('#cpContainer').html('');
	}
});


$(document).on('click', '.cpItem', function() {
	$('#businessDivOne').show();
	var cat=$(this).html();
	var cpid=$(this).attr('cval');
	var bid=$(this).attr('bval');
	var bname=$(this).attr('bname');
	var cpname = $(this).html();
	$('#cpContainer').html('');
	$('#business_id').val(bid);
	$('#contact_id').val(cpid);
	$('#bus_name_poped').val(bname);
	$('#cp_name').val(cpname);
});

*/

$('.removeFile').on('click',function(){
	var fileinput = $(this).parents('.input-group').find('input[type="file"]');
	fileinput.attr('is_valid','1')
	fileinput.val('');
	$(this).parents('.form-group').find('.image_err').css('display','none');
	$(this).parents('.form-group').find('.imgInput, .hiddenfile').val('');	
});

//=============delete entry code============//

$(document).on('click','.deleteEntry',function(){
    var link = $(this).attr('link');
    $(document).find('#deleteEntryForm').attr('action',link);
    $('#confirm_modal').modal('show');
});

$(document).on('submit','#deleteEntryForm',function(e){

    e.preventDefault();
    ds = $(this);
    var url = $(this).attr('action');
    var formData = $("form").serialize();
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
                
                $('#deleteEntryForm')[0].reset();
                    
                $('#errorMsg').addClass('hide').removeClass('show');
                $('#successMsg').addClass('show').removeClass('hide').html(res.msg);
            
                setTimeout( function(){ 
                    $('#errorMsg , #successMsg').addClass('hide').removeClass('show').fadeOut('slow');
                  }  , 10000 );

                $("#example").DataTable().destroy();
                
                loadTableData();
            }else{
                $('#errorMsg').addClass('show').removeClass('hide').html(res.msg);
                $('#successMsg').addClass('hide').removeClass('show');
            }
            $('#confirm_modal').modal('hide');
            $('html, body').animate({
                scrollTop: $(".dashBody").offset().top
            }, 1000); 
        }
    });
});

//=============delete entry code============//


//============crop image code===============
$image_crop = $('#image_demo').croppie({
	enableExif: true,
	viewport: {
	  width:240,
	  height:240,
	  type:'square' //circle
	},
	boundary:{
	  width:245,
	  height:245
	}
});

//=====================image upload process start===========//
var hidden_img = '';
// var is_valid = 1;
// var img_err = '';

$('.imgInput').on('click', function(){
	$(this).val('');
	$(this).attr('is_valid',1);
	$(this).parents('.form-group').find('.image_err').hide();
	$(this).parents('.form-group').find('.imgInput, .hiddenfile').val('');
});

$('.imgInput').on('change', function(){

	var reader = new FileReader();
	var ds = $(this);
	console.log(ds);
	image_validation(this).then(function(){

		setTimeout(function() {

			is_valid = ds.attr('is_valid');
			if(is_valid==1){
				ds.parents('.form-group').find('.image_err').hide().html('');
				


	var filename =  $(ds).get(0).files[0].name;
	var inputname = $(ds).attr('name');
	var extension = filename.substr( (filename.lastIndexOf('.') +1) );
	//if(inputname=='ba_image' && extension =='gif'){
	
	if(inputname=='ba_image'){
		ajaxindicatorstart();
		readFileURL(ds[0],'imgPreview');
	}else {
			ajaxindicatorstart();

				inputID = ds.attr('id');
				hidden_img = $('#'+inputID+'_h');
				imgpreview = $('#'+inputID+'_h').attr('preview');
				//previewpath = $('#'+inputID+'_h').attr('path');
				imgelement = ds.parents('.row').find('.img');

				reader.onload = function (event) {
				  $image_crop.croppie('bind', {
				    url: event.target.result
				    
				  }).then(function(){
				      ajaxindicatorstop();
				  });
				}
				reader.readAsDataURL(ds[0].files[0]);
				$('.crop_image').prop('disabled',false);
				$('#uploadimageModal').modal('show');
	}

			}

		}, 1000);

	});
});


$('.crop_image').click(function(event){
	$(this).prop('disabled',true);
	var directmove = false;
	var path = '';var table = '';var field = '';var id = '';var name = '';
	if($('#directmove').length >0){
		directmove = true;

		if($('#uploadtype').val()=='cto'){
			path = $('#directmove').val();
			table = $('#directmove').attr('table');
			field = $('#directmove').attr('field');
			id = $('#directmove').attr('data-id');
			name = $('#directmove').attr('name-id');
		}else{
			path = $('#directmoveli').val();
			table = $('#directmoveli').attr('table');
			field = $('#directmoveli').attr('field');
			id = $('#directmoveli').attr('data-id');
			name = $('#directmoveli').attr('name-id');
		}
	}


	$image_crop.croppie('result', {
	  type: 'canvas',
	  size: 'viewport'
	}).then(function(response){
	  $.ajax({
	    url: site_url+"licensee/uploadImage",
	    type: "POST",
	    data:{"image": response,'directmove':directmove,'path':path,'table':table,'field':field, 'id':id, 'name':name},
	    dataType:'json',
	    beforeSend:function(){
	         ajaxindicatorstart();
	    },
	    success:function(data)
	    {
	        ajaxindicatorstop();
	        console.log(imgpreview);
			if(imgpreview){ 
				imgelement.attr('src',base_url+'tmp_upload/'+data.fileName);
	  		}
	    	if(data.show=='insert'){
		        hidden_img.val(data.fileName);
		        $('#uploadimageModal').modal('hide');


	    	}else{
	    		hidden_img.val(data.fileName);
		        $('#uploadimageModal').modal('hide');
	       		window.location.reload();
	    	}
	    }
	  });
	});
});


async function image_validation(ds){
	var msg = '';
	ext_validate =false;
	var inputname = $(ds).attr('name');

	var filename = ds.files[0].name;
	var extension = filename.substr( (filename.lastIndexOf('.') +1) );
	if(inputname=='ba_image' && (extension =='gif' || extension =='jpg' || extension =='jpeg' || extension =='png')){
		ext_validate = true;
	}else if(extension =='jpg' || extension =='jpeg' || extension =='png'){
		ext_validate = true;
	}
	
	if(ext_validate){

		if (window.FileReader && window.Blob) {
	            
	            var files = $(ds).get(0).files;
	            if (files.length > 0) {
	                var file = files[0];
	                var fileReader = new FileReader();
	                fileReader.onloadend = function (e) {
	                    var arr = (new Uint8Array(e.target.result)).subarray(0, 4);
	                    var header = '';
	                    for (var i = 0; i < arr.length; i++) {
	                        header += arr[i].toString(16);
	                    }

	                    // Check the file signature against known types
	                    var type = 'unknown';
	                    switch (header) {
	                        case '89504e47':
	                            type = 'image/png';
	                            break;
	                        case '47494638':
	                            type = 'image/gif';
	                            break;
	                        case 'ffd8ffe0':
	                        case 'ffd8ffe1':
	                        case 'ffd8ffe2':
	                            type = 'image/jpeg';
	                            break;
	                    }

	                    if (file.type !== type) {
							$(ds).attr('is_valid',0);
							$(ds).parents('.form-group').find('.image_err').show().html('Invalid file selected');
	                    } else {
	                    	$(ds).attr('is_valid',1);
	                    }
	                };
	                fileReader.readAsArrayBuffer(file);
	            }else{
	            	$(ds).attr('is_valid',0);
					$(ds).parents('.form-group').find('.image_err').show().html('Please select file');            	
	            }
	    }else{
	    	$(ds).attr('is_valid',0);
			$(ds).parents('.form-group').find('.image_err').show().html('Your browser is not supported. Sorry.');            	   	
	    }

	}else{
		$(ds).attr('is_valid',0);
		$(ds).parents('.form-group').find('.image_err').show().html('invalid file extension');            	   	
	}
}

//=====================image upload process End===========//


//=====================pdf upload process start===========//

$('.pdffile').on('click', function(){
	$(this).val('');
	$(this).attr('is_valid',1);
	$(this).parents('.form-group').find('.pdferror').hide();
});

$('.pdffile').on('change', function(){

	var reader = new FileReader();
	var ds = $(this);
	pdf_validation(this);
});


function pdf_validation(ds){
	ext_validate = false;
	var inputname = $(ds).attr('name');

	var filename = ds.files[0].name;
	var extension = filename.substr( (filename.lastIndexOf('.') +1) );
	if(extension =='pdf'){
		ext_validate = true;
	}
	
	if(ext_validate){

		if (window.FileReader && window.Blob) {
	            var files = $(ds).get(0).files;
	            if (files.length > 0) {
	                var file = files[0];
	                var fileReader = new FileReader();
	                fileReader.onloadend = function (e) {
	                    var arr = (new Uint8Array(e.target.result)).subarray(0, 4);
	                    var header = '';
	                    for (var i = 0; i < arr.length; i++) {
	                        header += arr[i].toString(16);
	                    }

	                    // Check the file signature against known types
	                    var type = 'unknown';
	                    switch (header) {
	                        case '25504446':
	                            type = 'application/pdf';
	                            break;
	                    }

	                    if (file.type !== type) {

							$(ds).parents('.form-group').find('.pdferror').css('display','block').html('Invalid file selected');
							$(ds).attr('is_valid',0);
	                    } else {

							$(ds).parents('.form-group').find('.pdferror').css('display','none').html('');
							$(ds).attr('is_valid',1);	 	                    	
	                    }
	                };
	                fileReader.readAsArrayBuffer(file);
	            }else{
					$(ds).parents('.form-group').find('.pdferror').show().html('Please select file');
					$(ds).attr('is_valid',0);	  
	            }
	    }else{
			$(ds).parents('.form-group').find('.pdferror').show().html('Your browser is not supported. Sorry.');
			$(ds).attr('is_valid',0);	    	
	    }

	}else{
		$(ds).parents('.form-group').find('.pdferror').show().html('invalid file extension');
		$(ds).attr('is_valid',0);
	}
}
//=====================pdf upload process End===========//



//=====================pdf upload process start===========//

$('.csvfile').on('click', function(){
	$(this).val('');
	$(this).attr('is_valid',1);
	$(this).parents('.form-group').find('.csverror').hide();
});

$('.csvfile').on('change', function(){

	var reader = new FileReader();
	var ds = $(this);
	csv_validation(this);
});


function csv_validation(ds){
	ext_validate = false;
	var inputname = $(ds).attr('name');

	var filename = ds.files[0].name;
	var extension = filename.substr( (filename.lastIndexOf('.') +1) );
	if(extension =='csv'){
		ext_validate = true;
	}
	
	if(ext_validate){

		if (window.FileReader && window.Blob) {
	            var files = $(ds).get(0).files;
	            if (files.length > 0) {
	                var file = files[0];
	                var fileReader = new FileReader();
	                fileReader.onloadend = function (e) {
	                    var arr = (new Uint8Array(e.target.result)).subarray(0, 4);
	                    var header = '';
	                    for (var i = 0; i < arr.length; i++) {
	                        header += arr[i].toString(16);
	                    }
	                    console.log('header',header);
	                    // Check the file signature against known types
	                    var type = 'unknown';
	                    switch (header) {
	                        case '436f6e74':
	                            type = 'application/vnd.ms-excel';
	                            break;
	                    }

	                    if (file.type !== type) {

							$(ds).parents('.form-group').find('.csverror').css('display','block').html('Invalid file selected');
							$(ds).attr('is_valid',0);
	                    } else {

							$(ds).parents('.form-group').find('.csverror').css('display','none').html('');
							$(ds).attr('is_valid',1);	 	                    	
	                    }
	                };
	                fileReader.readAsArrayBuffer(file);
	            }else{
					$(ds).parents('.form-group').find('.csverror').show().html('Please select file');
					$(ds).attr('is_valid',0);	  
	            }
	    }else{
			$(ds).parents('.form-group').find('.csverror').show().html('Your browser is not supported. Sorry.');
			$(ds).attr('is_valid',0);	    	
	    }

	}else{
		$(ds).parents('.form-group').find('.csverror').show().html('invalid file extension');
		$(ds).attr('is_valid',0);
	}
}
//=====================pdf upload process End===========//


// $('#add_staff').disableAutoFill({
//     passwordField: '#password',
// });

$('#add_frm_template, #update_frm_template ,#edit_category, #edit_product, #add_staff,#edit_staff,#add_usercategory,#edit_usercategory ,#edit_supplier, #add_note, #add_supplier').attr('autocomplete', 'off');
//============crop image code===============

function CKupdate(){
    for ( instance in CKEDITOR.instances ){
        CKEDITOR.instances[instance].updateElement();
        CKEDITOR.instances[instance].setData('');
    }
}

function readFileURL(input,previewId) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    
    reader.onload = function(e) {
      $('#'+previewId).attr('src', e.target.result);
      ajaxindicatorstop();
    }
    reader.readAsDataURL(input.files[0]); // convert to base64 string
  }
}


function check_emailexist(email,id){
	allIsOk = true;
	url = site_url+'licensee/check_email_exist';
	$.ajax({
		async: false,
		url: url,
		type: "POST",
		data:{'email':email,'id':id},
		dataType: "json",
		beforeSend:function(){
			//ajaxindicatorstart();
		},
		success: function(res) {
			//ajaxindicatorstop();
			if(!res.success) {
				$('#email_err').show().html('Email Address Already Exist!');
				allIsOk = false;
				//$('#email').focus();
			}else{
				$('#email_err').hide();
			}
		}
	});

	return allIsOk;
}

function add_oneyear(givendate){
	var d = new Date(givendate);
	d.setFullYear(d.getFullYear() + 1);
	var year = d.getFullYear();
	var month = d.getMonth();
	var month = month+1;
	var month = ("0" + (d.getMonth() + 1)).slice(-2)	
	var day = d.getDate();
	var day = ("0" + d.getDate()).slice(-2);
	mydate = month+'/'+day+'/'+year;
	return mydate;
}

function add_onemonth(givendate){
	var d = new Date(givendate);
	d.setMonth(d.getMonth() + 1);
	var year = d.getFullYear();
	var month = d.getMonth();
	var month = month+1;
	var month = ("0" + (d.getMonth() + 1)).slice(-2)	
	var day = d.getDate();
	var day = ("0" + d.getDate()).slice(-2);
	mydate = month+'/'+day+'/'+year;
	return mydate;	
}