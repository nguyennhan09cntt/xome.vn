$(function(){
    Custom.initManualUpdate('site-slide');
    Metronic.initCheckbox('.group-checkable');
    $('#btn_add_new').click(function(){
        Metronic.redirect('site-slide/edit/')
    });
});