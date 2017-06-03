/**
 Custom module for you to write your own javascript functions
 **/
var Custom = function () {
    var HOST = '';
    // private functions & variables

    var myFunc = function (text) {
        alert(text);
    }
    var handlePagination = function () {
        jQuery('.pagination a[href="#"]').click(function (e) {
                e.preventDefault;
                return false;
            }
        )
    }
    var showBlockProcessing = function () {
        var html = '<div style="font-style:italic;">Processing, please wait...</div>';
        $.blockUI
        ({
            message: html,
            css: {
                background: '#333',
                color: '#fff',
                border: '2px double #ccc',
                showOverlay: true,
                width: '400px',
                top: '100px',
                left: ($(window).width() - 300) / 2 + 'px',
                padding: '5px',
                borderRadius: '8px'
            }
        });
    }
    var getCheckAllValue = function () {
        var result = [];
        $('.checkboxes').each(function () {
            if (this.checked) {
                result.push(this.value);
            }
        });
        return result;
    }
    var encodeQueryData = function (data) {
        var ret = [];
        for (var d in data)
            ret.push(encodeURIComponent(d) + "=" + encodeURIComponent(data[d]));
        return ret.join("&");
    }
    var submitManualUpdate = function (controllerName, actionName) {
        var checked = getCheckAllValue();
        if (!checked.length) {
            alert('Please choose some items.');
        } else {
            var params = {
                'manualUpdateId': checked,
                'manualUpdateAction': actionName,
                'manualUpdateUrl': window.location.href
            };
            showBlockProcessing();
            Metronic.redirect(controllerName + '/manual-update/?' + encodeQueryData(params));
        }
    }
    var submitManualCustomUpdate = function (controllerName, actionType, actionName) {
        var checked = getCheckAllValue();
        if (!checked.length) {
            alert('Please choose some items.');
        } else {
            var params = {
                'manualUpdateId': checked,
                'manualUpdateAction': actionName,
                'manualUpdateUrl': window.location.href
            };
            showBlockProcessing();
            Metronic.redirect(controllerName + '/' + actionType + '/?' + encodeQueryData(params));
        }
    }

    // public functions
    return {

        //main function
        init: function () {
            //initialize here something.            
        },

        //some helper function
        doSomeStuff: function () {
            myFunc();
        },
        initPagination: function () {
            handlePagination();
        },
        initManualUpdate: function (controllerName) {
            $('#manualUpdateElement').change(function () {
                if (this.value) {
                    submitManualUpdate(controllerName, this.value);
                }
            });
        },
        initManualCustomUpdate: function (element, controllerName, actionType) {
            $(element).change(function () {
                if (this.value) {
                    submitManualCustomUpdate(controllerName, actionType, this.value);
                }
            });
        },
        initValidate: function () {
            //===== Validation engine =====//
            $("#validate").validationEngine();
        },
        initFCK: function (id) {
            CKEDITOR.replace(id, {
                filebrowserImageBrowseUrl: HOST + '/statics/asset/global/plugins/ckeditor/filemanager/browser/default/browser.html?Type=Image&Connector=' +
                HOST + '/statics/asset/global/plugins/ckeditor/filemanager/connectors/php/connector.php'
            });
        },
        initPageBreadcrumb: function () {
            $('.page-breadcrumb a[href="#"]').click(function (e) {
                e.preventDefault();
                return false;
            });
        },
        showBlockProcessing: function () {
            showBlockProcessing();
        },
        closeBlockUI: function () {
            closeBlockUI();
        }


    };

}();

/***
 Usage
 ***/
//Custom.init();
//Custom.doSomeStuff();