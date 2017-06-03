$(function(){
    Custom.initManualUpdate('product-image');
    $('#btn_add_new').click(function(){
        Metronic.redirect('product-image/edit/?p='+$('#p').val());
    });
    Metronic.initCheckbox('.group-checkable');
});