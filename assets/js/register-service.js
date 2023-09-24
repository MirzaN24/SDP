var RegisterService = {

    init: function () {
        var token = localStorage.getItem("token");
        if (token) {
            $(document).ready(function () {
                var app = $.jQuerySPApp({ defaultView: "analysis" });
                //define routes
                app.run();
            })
        }
        $('#register-form').validate({
            submitHandler: function (form) {
                var entity = Object.fromEntries((new FormData(form)).entries());
                entity.username = $('#username').val();
                entity.email = $('#email').val();
                entity.password = $('#password').val();
                entity.passwordconfirm = $('#passwordconfirm').val();
                RegisterService.register(entity);
            }
        });
    },

    register: function(entity){
      $.ajax({
        url: 'rest/register',
        type: 'POST',
        data: JSON.stringify(entity),
        contentType: "application/json",
        success: function(result) {
          console.log(result);
          localStorage.setItem("token", result.token);
          window.location.replace("index.html");
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          toastr.error(XMLHttpRequest.responseJSON.message);
        }
      });
    }
}