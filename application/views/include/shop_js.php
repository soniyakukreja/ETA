<script>
function load_products(page,catid,sort_by){
	if($('#shopDiv').length>0){
		$.ajax({
			url: site_url+'shop/loadproducts/'+page+'?catid='+catid+'&sort='+sort_by,
			type: 'GET',
			dataType:'json',
			beforeSend:function(){
			},
			success: function(res) {
				$('#shopDiv').html(res.html);
				$('#linkdiv').html(res.links).css('display','block');
			}             
		});
	}else{
		var url = site_url+'shop?catid='+catid+'&sort='+sort_by;
		window.open(url, '_blank');
	}
}

$(document).on('keyup', '#search_field', function(e) {
	e.preventDefault();
	var term=$(this).val();
	if(term!='' && term.length>=3){

		$.ajax({
			url: site_url+'shop/prod_suggessions',
			data: ({term: term}),
			dataType: 'json', 
			type: 'post',
			beforeSend:function(){
			},
			success: function(data) {
				if(data.status=='success'){
					$('#prod_search_container').html(data.data);
				}else{
					$('#prod_search_container').html('');
				}
			}             
		});
		
	}else{
		$('#prod_search_container').html('');
	}
});


$(document).on('click', '.prod_item', function() {
	$('#prod_search_container').html('');
	if($('#shopDiv').length>0){
		var cat=$(this).html();
		var prodVal=$(this).attr('data-val');
		var prodname = $(this).html();
		
		$('#search_field').val(prodname);

		$.ajax({
			url: site_url+'shop/shop_filter_page',
			data: ({search: prodVal}),
			type: 'post',
			beforeSend:function(){
			},
			success: function(data) {
				$('#prod_div').html(data);
				$('#linkdiv').css('display','none');
			}             
		});
	}else{
		var url = site_url+'shop';
		window.open(url, '_blank');		
	}
});

$(document).on('click', '.searchbycat', function() {
	var catid=$(this).attr('id');
	$('.searchbycat').removeClass('active');
	$(this).addClass('active');
	$('#prod_search_container').html('');
	$('#search_field').val('');
	$('#catid').val(catid);

	var sort_by= $('#sort_by :selected').val();
	load_products(1,catid,sort_by);
});

$(document).on('change','#sort_by',function(){
	var catid = $('#catid').val();
	var sort_by = $(this).val();
	load_products(1,catid,sort_by);	
});

$(document).on('click','.addtocart',function(){
	var pid = $(this).data('val');
	if($('.qty').length>0){
		var qty = $('.qty').val();
	}else{
		var qty = 1;
	}
	var ds = $(this);
	$.ajax({
		url: site_url+'shop/addtocart',
		data: ({pid: pid,qty:qty}),
		type: 'post',
		dataType:'json',
		beforeSend:function(){
			ajaxindicatorstart();
		},
		success: function(res) {
			ajaxindicatorstop();
			if(res.success){
				$('#navCartTotal').html(res.qtytotal);
				$(document).find('#cartmenu').show(); 
				$('#success_head').css('display','block');
				$('#error_head').css('display','none');
				
				if($('.qty').length>0){ 
					changeButton();
				}else{
					ds.removeClass('addtocart').addClass('addedToCart').html('Added to Cart');
				}

			}else{
				$('#error_head').css('display','block');
				$('#success_head').css('display','none');
				allIsOk = false;
			}
			$('#msgbody').html(res.msg);
			$('#msg_modal').modal('show');
		}             
	});
});

$(document).on('click','.expressInt',function(){
	var pid = $(this).data('val');
	var ds = $(this);
	$.ajax({
		url: site_url+'shop/expressInt',
		data: ({pid: pid}),
		type: 'post',
		dataType:'json',
		beforeSend:function(){
			ajaxindicatorstart();
		},
		success: function(res) {
			ajaxindicatorstop();
			if(res.success){
				$('#success_head').css('display','block');
				$('#error_head').css('display','none');
				ds.removeClass('expressInt').addClass('expressed').html('Interest Sent');
				
			}else{
				$('#error_head').css('display','block');
				$('#success_head').css('display','none');
				allIsOk = false;
			}
			$('#msgbody').html(res.msg);
			$('#msg_modal').modal('show');
		}             
	});
});

</script>