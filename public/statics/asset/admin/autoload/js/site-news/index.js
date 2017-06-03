$(function(){
    Custom.initManualUpdate('site-news');
    Metronic.initCheckbox('.group-checkable');
    $('#btn_add_new').click(function(){
        Metronic.redirect('site-news/edit/')
    });
});