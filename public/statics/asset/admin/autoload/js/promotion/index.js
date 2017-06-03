$(function () {
    Custom.initManualUpdate('product');
    $('#btn_new_add').click(function () {
        Metronic.redirect('product/edit/')
    });
    Metronic.initCheckbox('.group-checkable');
    Custom.initManualCustomUpdate('#manualUpdateDisplay','product', 'manual-priority');

});