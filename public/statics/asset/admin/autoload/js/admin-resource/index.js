$(function(){
    Custom.initManualUpdate('admin-resource');

    $('#btn_add_new').click(function(){
        Metronic.redirect('admin-resource/edit/?m=' + $('#m').val())
    });
});