/**
 * Created by nhannvt on 10/21/2015.
 */
var AdminRoleIndex = {
    initCheckAll: function () {
        var set = jQuery('.group-checkable').attr("data-set");
        var lengthChecked = $("input.checkboxes:checkbox:checked").length;
        var length = jQuery(set).length;
        if (length == lengthChecked) {
            $(".group-checkable").attr('checked', true);
            jQuery.uniform.update('.group-checkable');
        }
    }
};
$(function () {
    $("input.checkboxes:checkbox").click(function () {
        var checkedStatus = this.checked;
        if (!checkedStatus && $(".group-checkable").is(':checked')) {
            $(".group-checkable").attr('checked', false);
            jQuery.uniform.update('.group-checkable');
        }else if(checkedStatus){
            AdminRoleIndex.initCheckAll();
        }
    });
    AdminRoleIndex.initCheckAll();
    Metronic.initCheckbox('.group-checkable');
})
