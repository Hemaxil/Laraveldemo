  $("#user_address_form").validate({

    rules:{
        address1:{
          required:true,
          maxlength:45,
        },
       address2:{
         
          maxlength:45,
        },
       city:{
          required:true,
          maxlength:45,
        },
        state:{
          required:true,
          maxlength:45,
        },
        country:{
          required:true,
          maxlength:45,
        },
        zipcode:{
          required:true,
          maxlength:6,
          minlength:6,
          digits:true,
        },

        


    },
    messages:{
         address1:{
          required:"Address 1 is required",
          maxlength:"Max characters allowed are 45",
        },
       address2:{
          
         maxlength:"Max characters allowed are 45",
        },
       city:{
          required:"City is required",
         maxlength:"Max characters allowed are 45",
        },
        state:{
          required:"State is required",
          maxlength:"Max characters allowed are 45",
        },
        country:{
          required:"Country is required",
          maxlength:"Max characters allowed are 45",
        },
        zipcode:{
          required:"Zipcode is required",
          maxlength:"Only 6 digits are allowed",
          minlength:"Min 6 digits are required",
          digits:"Only numbers are allowed",
        },
    },
    errorClass:'error',
    errorElement:'div',
    
  });
