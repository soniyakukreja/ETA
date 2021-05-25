function phonevalidate(){


				 
	var phone = document.querySelector("#phone"),
	errorMsg = document.querySelector("#error-msg"),
	validMsg = document.querySelector("#valid-msg");

	var errorMap = [ "Please enter a valid contact number", "Please enter valid country code", "Please enter a valid contact number", "Please enter a valid contact number", "Please enter a valid contact number"];
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


		
 		   
            
}