  $("#user_register_form").validate({

    rules:{
        firstname:{
          required:true,
          maxlength:45,
        },
       lastname:{
          required:true,
          maxlength:45,
        },
       email:{
          required:true,
          maxlength:45,
        },
        password:{
          required:true,
          maxlength:45,
         
        },
        password_confirmation:{

          required:true,
          equalTo:"#password",
          maxlength:45,
        },
        


    },
    messages:{
        firstname:{
          required:"First name is required",
          maxlength:"Length should be less than 45",
        },
          lastname:{
          required:"Last name is required",
          maxlength:"Length should be less than 45",
        },
         email:{
          required:"Email is required",
          maxlength:"Length should be less than 45",
        },
         password:{
          required:"Password is required",
          maxlength:"Length should be less than 45",
          
        },
        password_confirmation:{

          required:"Password is required",
          equalTo:"Pasword Confirmation should be same as password",
          maxlength:"Length should be less than 45",
        },
       
    },
    errorClass:'error',
    errorElement:'div',
    
  });


    $("#user_login_form").validate({

    rules:{
       email:{
          required:true,
          maxlength:45,
        },
        password:{
          required:true,
          maxlength:45,
          
        },

    },
    messages:{
        
         email:{
          required:"Email is required",
          maxlength:"Length should be less than 45",
        },
         password:{
          required:"Password is required",
          maxlength:"Length should be less than 45",
          
        },
        
       
    },
    errorClass:'error',
    errorElement:'div',
    
  });

