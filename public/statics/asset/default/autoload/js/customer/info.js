var CustomerInfo = {
    init: function () {
        /*window.theme.captcha('1234');*/
        $("#frmProfile").validate({
            submitHandler: function(form) {
                form.submit();
            },
            rules:{
                captcha:{
                    required: true,
                    captcha: true
                }
            }
        });
    },
    showDistrictOptions : function(province)
    {
        if (districtJson) {
            var district = $('.district');

            district.empty();
            district.append('<option value="">Quận/ Huyện</option>');
            var hiddenDistrict = $('#hidden-district').val();

            $.each(districtJson, function(id, data) {
                if (data.district_province == province) {
                    var selected = data.district_id == hiddenDistrict ? 'selected' : '';
                    var html = '<option value="'+ data.district_id +'" '+ selected +'>'+data.district_name+'</option>';
                    district.append(html);
                }
            });
        }
    }
}

$(function(){
    CustomerInfo.init();
    Metronic.init();
});