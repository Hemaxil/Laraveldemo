  $("#attribute_value_form").validate({

    rules:{
        attribute:{
          required:true,
        },
        attribute_value:{
          required:true,
          alphanumeric:true,
        },

    },
    messages:{
         attribute:{
          required:"Select attribute",
        },
        attribute_value:{
          required:"Attribute value field is required",
          alphanumeric:"Only alphabets and digits are allowed",
        },
    },
    errorClass:'error',
    errorElement:'div',
    
  });




jQuery.validator.addMethod("alphanumeric", function(value, element) {
  // allow any non-whitespace characters as the host part
  return this.optional( element ) || /[A-Za-z0-9]+/.test( value );
}, 'This field must contain only alphabets and numbers');
