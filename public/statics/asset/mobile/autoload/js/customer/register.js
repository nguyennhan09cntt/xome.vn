var CustomerRegister = {
    init: function () {
        /*window.theme.captcha('1234');*/
        $("#frmRegister").validate({
            submitHandler: function(form) {
                form.submit();
            },
            rules:{
                password:{

                },
                confirm_pass:{
                    equalTo:'#password'
                },
                captcha:{
                    required: true,
                    captcha: true
                }
            }
        });
    }
}

$(function(){
    CustomerRegister.init();
});