
<script src="jquery.js"></script>
<script src="jquery-validate.js"></script>
<script>
$("#contact-form-1").validate({
    rules: {

    },
    messages: {
        nombre: {
            required: 'The name is required',
        },
        email:{
            required:'Email required',
            email:'Must be email address'
        },
        mensaje:{
            required:'Must leave a message',
            
        }
    },
    submitHandler: function(form) {
        $.ajax({
             url: 'https://example.com',
             type: 'POST',
             dataType: 'json',
             data: $('#contact-form-1').serialize(),
             success: function(response) {
                 console.log(response);
                 console.log();
               $("#server-response").empty();
               $("#server-response").append(response.message);
               $("#contact-form-1").trigger("reset");
             }
          }).fail(function(response) {
             if (error.result == false) {
                $('#contact-form-1').append('There is a problem sending the request');
             }
          });
    }

});
</script>