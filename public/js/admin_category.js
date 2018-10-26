

  $("#category_form").validate({
    onkeyup:true,
    rules:{
        name:{
          required:true,
          maxlength:100,
        }
    },
    messages:{
        name:{
          required:"Category Name is required",
          maxlength:"Category Name should be only 100 characters long",
        }
    },
    errorClass:'error',
    errorElement:'div',
    
  });
