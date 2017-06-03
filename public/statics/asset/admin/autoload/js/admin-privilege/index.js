$(function(){
    Custom.initManualUpdate('admin-privilege');
    $('#btn_add_new').click(function(){
        Metronic.redirect('admin-privilege/edit/?r=' + $('#r').val())
    });
    Metronic.initCheckbox('.group-checkable');

});