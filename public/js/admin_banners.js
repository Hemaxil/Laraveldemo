  $("#banner_form").validate({
   
    onkeyup:true,
      submitHandler: function(form) {
    // do other things for a valid form
        form.submit();
      },
    rules:{
        title:{
          required:true,
          maxlength:45,
        },
        content:{
          required:true,
         
        },
        image:{
          required:true,
          extension:'jpeg|jpg|png',
          filesize:1999,

        }

    },
    messages:{
        title:{
          required:"Title is required",
          maxlength:"Max length allowed is 45",
        },
         content:{
          required:"Content is required",
          
        },
        image:{
          required:"Image is required",
          extension:"Image should be only in jpeg or png format",
          filesize:"filesize should be less than 2MB",
        }
    },
    errorClass:'error',
    errorElement:'div',
     

    
  });
