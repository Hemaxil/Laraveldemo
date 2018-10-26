  $("#product_form").validate({

    rules:{
        name:{
          required:true,
          maxlength:45,
          alphanumeric:true,

        },
        short_description:{
          required:true,
          maxlength:100,
          alphanumeric:true,

        },
         sku:{
          required:true,
          maxlength:45,
          alphanumeric:true,

        },
        quantity:{
          required:true,
          min:1,
          digits:true,
          

        },
        price:{
          required:true,
          validation_float:true,
        },
         special_price:{
        
          validation_float:true,
        },
        meta_title:{
          required:true,
          maxlength:45,
          alphanumeric:true,

        },
        meta_description:{
          required:true,
          maxlength:45,
          alphanumeric:true,

        },
        meta_keywords:{
          required:true,
          maxlength:45,
          alphanumeric:true,

        },
        'category[]':"required",
        'attribute[]':{
          notSelect:true,
          

        },
        'attribute_value[]':{
          notSelect:true,
        },
        'images[]':{
         notSelect:true,
        }


    },
    messages:{
        name:{
          required:"Code is required",
          maxlength:"Max length allowed is 45",
          alphanumeric:"Code should be alphanumeric",

        },
        short_description:{
          required:"Code is required",
          maxlength:"Max length allowed is 100",
          alphanumeric:"Code should be alphanumeric",

        },
        sku:{
          required:"Code is required",
          maxlength:"Max length allowed is 100",
          alphanumeric:"Code should be alphanumeric",

        },
        quantity:{
          required:"Please enter max numbers of times this can be used",
          min:"Min value needs to be 1",
          digits:"Only digits are allowed",
          

        },
        price:{
          required:"Percentage off field is required",
          validation_float:"Only upto 2 decimal places allowed",
        },
        special_price:{
         
          validation_float:"Only upto 2 decimal places allowed",
        },
        meta_title:{
          required:"Code is required",
          maxlength:"Max length allowed is 100",
          alphanumeric:"Code should be alphanumeric",

        },
        meta_description:{
          required:"Code is required",
          maxlength:"Max length allowed is 100",
          alphanumeric:"Code should be alphanumeric",

        },
        meta_keywords:{
          required:"Code is required",
          maxlength:"Max length allowed is 100",
          alphanumeric:"Code should be alphanumeric",

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

jQuery.validator.addMethod("notSelect", function(value, element) {
  // allow any non-whitespace characters as the host part
  return value!="select";
}, 'Please select ');