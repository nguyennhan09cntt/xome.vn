var AdminCommon = {
    errorDiv: 'divErrorMsg',

    getAdminUrl: function(path)
    {
        return '/' + path;
    },

    redirect: function(path){
        window.location.href = '/' + path;
    },

    refeshPage: function(){
        window.location.reload();
    },

    showBlockProcessing: function()
    {
        var html = '<div style="font-style:italic;">Processing, please wait...</div>';
        $.blockUI
        ({
            message: html,
            css:
            {
                background	: '#333',
                color		: '#fff',
                border		: '2px double #ccc',
                showOverlay	: true,
                width		: '400px',
                top			: '100px',
                left		: ($(window).width()-300)/2 + 'px',
                padding		: '5px',
                borderRadius: '8px'
            }
        });
    },

    closeBlockUI: function()
    {
        $.unblockUI();
    },

    randomText: function(nLength)
    {
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

        for( var i=0; i < nLength; i++ )
            text += possible.charAt(Math.floor(Math.random() * possible.length));

        return text;
    },

    displayFCK: function(id)
    {
        CKEDITOR.replace(id,{
            filebrowserImageBrowseUrl 	:
                HOST + '/statics/asset/libs/js/editor/ckeditor/filemanager/browser/default/browser.html?Type=Image&Connector=' +
                    HOST + '/statics/asset/libs/js/editor/ckeditor/filemanager/connectors/php/connector.php'
        });
    },

    initializeCheckAll: function()
    {
        $('.check-all').click(function(){
            $('.check-items').attr('checked', this.checked);
        });
    },

    getCheckAllValue: function()
    {
        var result = [];
        $('.check-items').each(function(){
            if (this.checked) {
                result.push(this.value);
            }
        });
        return result;
    },

    initializeManualUpdate: function(controllerName)
    {
        $('#manualUpdateElement').change(function(){
            if (this.value) {
                AdminCommon.submitManualUpdate(controllerName, this.value);
            }
        });
    },

    submitManualUpdate: function(controllerName, actionName)
    {
        var checked = this.getCheckAllValue();
        if (!checked.length) {
            alert('Please choose some items.');
        } else {
            var params = {
                'manualUpdateId' : checked,
                'manualUpdateAction' : actionName,
                'manualUpdateUrl' : window.location.href
            };
            this.showBlockProcessing();
            this.redirect( controllerName + '/manual-update/?' + this.encodeQueryData(params) );
        }
    },

    encodeQueryData: function(data)
    {
        var ret = [];
        for (var d in data)
            ret.push(encodeURIComponent(d) + "=" + encodeURIComponent(data[d]));
        return ret.join("&");
    },

    resetErrorMsg: function(data)
    {
        $('#' + this.errorDiv).html('');
    },

    appendErrorMsg: function(msg)
    {
        var html = '<div class="nNote nFailure hideit">';
        html    += '<p>' + msg + '</p>';
        html    += '</div>';
        $('#' + this.errorDiv).append(html);
    },

    showDistrictOptions : function(province)
    {
        if (districtJson) {
            var district = $('.district');

            district.empty();
            district.append('<option value="">Quận/ Huyện</option>');
            var hiddenDistrict = $('#hiddenDistrict').val();

            $.each(districtJson, function(id, data) {
                if (data.fk_region_province == province) {
                    var selected = data.region_district_id == hiddenDistrict ? 'selected' : '';
                    var html = '<option value="'+ data.region_district_id +'" '+ selected +'>'+data.region_district_name+'</option>';
                    district.append(html);
                }
            });
        }
    },
    showProductCategoryOptions  : function($component)
    {
        if (productCategoryJson) {
            var category = $('.productCategory');

            category.empty();
            category.append('<option value="">++</option>');
            var hiddenCategory = $('#hiddenProductCategory').val();

            $.each(productCategoryJson, function(id, data) {
                if (data.fk_product_component == $component) {
                    var selected = data.product_category_id == hiddenCategory ? 'selected' : '';
                    var html = '<option value="'+ data.product_category_id +'" '+ selected +'>'+data.product_category_name+'</option>';
                    category.append(html);
                }
            });
        }
    }
};


$(document).ready(function(){
    var current = $('ul#menu').find('a.current');
    if (current) {
        var resource = current.parent('li').parent().parent().find('a.resource');
        if (resource) {
            resource.removeClass('exp');
            var module = resource.parent('li').parent().parent().find('a.module');
            if (module) {
                module.removeClass('exp');
                module.addClass('active');
            }
        }
    }

    $('.exp').collapsible({
        defaultOpen: 'current',
        cookieName: 'navAct',
        cssOpen: 'active',
        cssClose: 'inactive',
        speed: 200
    });

    $('.province').change(function(){
        AdminCommon.showDistrictOptions(this.value);
    });

    $('.product-component').change(function(){
        AdminCommon.showProductCategoryOptions(this.value);
    });
    AdminCommon.initializeCheckAll();
});