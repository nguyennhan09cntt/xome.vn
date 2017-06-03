$(function () {
    Custom.initManualUpdate('product');
    $('#btn_add_new').click(function () {
        Metronic.redirect('product/edit/')
    });
    Metronic.initCheckbox('.group-checkable');
    Custom.initManualCustomUpdate('#manualUpdateDisplay','product', 'manual-priority');

});