  $("#coupon_form").validate({

    rules:{
        code:{
          required:true,
          maxlength:45,
          alphanumeric:true,

        },
        percent_off:{
          required:true,
          validation_float:true,

         
        },
        no_of_uses:{
          required:true,
          min:1,
          digits:true,
          

        },

    },
    messages:{
        code:{
          required:"Code is required",
          maxlength:"Max length allowed is 45",
          alphanumeric:"Code should be alphanumeric",

        },
        percent_off:{
          required:"Percentage off field is required",
          validation_float:"Only upto 2 decimal places allowed",

         
        },
        no_of_uses:{
          required:"Please enter max numbers of times this can be used",
          min:"Min value needs to be 1",
          digits:"Only digits are allowed",
          

        },
    },
    errorClass:'error',
    errorElement:'div',
    
  });


jQuery.validator.addMethod("validation_float", function(value, element) {
  // allow any non-whitespace characters as the host part
  return this.optional( element ) || /^\d*.?\d{1,2}$/.test( value );
}, 'Percent off should be rounded to 2 digits after decimal');


jQuery.validator.addMethod("alphanumeric", function(value, element) {
  // allow any non-whitespace characters as the host part
  return this.optional( element ) || /[A-Za-z0-9]+/.test( value );
}, 'This field must contain only alphabets and numbers');
