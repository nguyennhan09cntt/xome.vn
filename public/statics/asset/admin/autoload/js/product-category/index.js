$(function(){
    Custom.initManualUpdate('product-category');
    $('#btn_new_add').click(function(){
        Metronic.redirect('product-category/edit/')
    });
    Metronic.initCheckbox('.group-checkable');
});