  $("#user_form").validate({

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
          email:true,
        },
        password_confirmation:{

          required:true,
          equalTo:"#password",
          maxlength:45,
        },
        'roles[]':{
          required:true,
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
          email:"Enter a valid email",
        },
        password_confirmation:{

          required:"Password is required",
          equalTo:"Pasword Confirmation should be same as password",
          maxlength:"Length should be less than 45",
        },
        'roles[]':{
          required:"User Role is required",
        },
    },
    errorClass:'error',
    errorElement:'div',
    
  });
