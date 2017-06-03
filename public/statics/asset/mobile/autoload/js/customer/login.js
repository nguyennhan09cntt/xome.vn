var CustomerLogin = {
    init: function () {
        $("#frmSignIn").validate({
            submitHandler: function(form) {
                form.submit();
            }
        });
    }
}

$(function(){
    CustomerLogin.init();
});