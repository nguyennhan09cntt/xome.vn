$(function(){
    $('#btn_add_new').click(function(){
        Metronic.redirect('admin-module/edit')
    });
    Metronic.initCheckbox('.group-checkable');

});