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
           email:true,
        },
        password:{
          required:true,
          minlength:6,
          maxlength:12,
          alphanumeric:true,
         
        },
        password_confirmation:{

          required:true,
          equalTo:"#password",
          minlength:6,
          maxlength:12,
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
          maxlength:"Length should be less than 8",
        },
         password:{
          required:"Password is required",
          minlength:"Min length should be 6",
          maxlength:"Length should be less than 12",
         alphanumeric:"Pasword should contain only digits and alphabets"

        },
        password_confirmation:{

          required:"Password is required",
          equalTo:"Pasword Confirmation should be same as password",
           minlength:"Min length should be 6",
          maxlength:"Length should be less than 12",
        },
        'roles[]':{
          required:"User Role is required",
        },
    },
    errorClass:'error',
    errorElement:'div',
    
  });
jQuery.validator.addMethod("alphanumeric", function(value, element) {
  // allow any non-whitespace characters as the host part
  return this.optional( element ) || /[A-Za-z0-9]+/.test( value );
}, 'This field must contain only alphabets and numbers');