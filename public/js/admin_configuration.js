  $("#configuration_form").validate({
   
    onkeyup:true,
      submitHandler: function(form) {
    // do other things for a valid form
        form.submit();
      },
    rules:{
        conf_key:{
          required:true,
          maxlength:45,
        },
        conf_value:{
          required:true,
         
        },
       
    },
    messages:{
        conf_key:{
          required:"Confguration Key is required",
          maxlength:"Max length allowed is 45",
        },
         conf_value:{
          required:"Configuration value is required",
          
        },
        
    },
    errorClass:'error',
    errorElement:'div',
    
  });
