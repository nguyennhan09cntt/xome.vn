var AddIndex = {

    init: function () {
        CKEDITOR.replace('form-add-description', {
            filebrowserImageBrowseUrl: '' + '/statics/asset/global/plugins/ckeditor/filemanager/browser/default/browser.html?Type=Image&Connector=' +
            '' + '/statics/asset/global/plugins/ckeditor/filemanager/connectors/php/connector.php'
        });
    }
}

$(function () {
    //AddIndex.init();
    Metronic.init();
});