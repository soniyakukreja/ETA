$('input:text[name="phone"]').keyup(function() {
        if($(this).val().length > 0) {
           $('#error_four').html('');
        }
    });  
				 
 var phone = document.querySelector("#phone"),
			errorMsg = document.querySelector("#error-msg"),
			validMsg = document.querySelector("#valid-msg");

		var errorMap = [ "Please enter a valid contact number", "Please enter valid country code", "Please enter a valid contact number", "Please enter a valid contact number", "Please enter a valid contact number"];
//alert(errorMap);
		var iti = window.intlTelInput(phone, {
		  utilsScript: "http://45.33.105.92/ETA/includes/js/utils.js?1549804213570",
		  formatOnDisplay:false,	
		  initialCountry: "us",
		});

		var reset = function() {
		  phone.classList.remove("error");
		  errorMsg.innerHTML = "";
		  errorMsg.classList.add("hide");
		  validMsg.classList.add("hide");
		};

		// on blur: validate
		phone.addEventListener('blur', function() {
		  reset();
		  if (phone.value.trim()) {
		    if (iti.isValidNumber()) {
		        //$("#sa-success").trigger('click');
		       phone.classList.add("bColor");
		       phone.classList.remove("noColor");
		       errorMsg.innerHTML = "";
		       errorMsg.classList.add("hide");
		    } else {
		       //alert("else");
		       phone.classList.remove("bColor");
		       phone.classList.add("noColor");
		      var errorCode = iti.getValidationError();
		       $("#sa-warning").trigger('click', [ errorMap[errorCode] ] );
		       $("#phoneresult").html([ errorMap[errorCode] ]);
		       errorMsg.innerHTML = "wrong,"+errorMap[errorCode];
		       errorMsg.classList.add("hide");
		    }
		  }
		});

		// on keyup / change flag: reset
		phone.addEventListener('change', reset);
		phone.addEventListener('keyup', reset);
		
 		   function isNumberKey(evt){
                var charCode = (evt.which) ? evt.which : event.keyCode
                if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 43 && charCode != 32 && charCode != 45 && charCode != 40 && charCode != 41)
                   return false;
                return true;
            }
            
