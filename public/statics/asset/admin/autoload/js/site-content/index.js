$(function(){
    Custom.initManualUpdate('site-content');
    $('#btn-new-add').click(function(){
        Metronic.redirect('site-content/edit/')
    });
});