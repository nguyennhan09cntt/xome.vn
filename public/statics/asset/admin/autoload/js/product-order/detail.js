var ProductOrderDetail = {
    getOrderEncode :function () {
      return $('#encode').val();
    },
    getStatusId: function(){
        return $('#statusId').val();
    },

    getCurrentStatusId: function(){
        return $('#currentStatusId').val();
    },
    updateNote: function()
    {
        var noteContent = $('#noteContent');
        if (!noteContent.val()) {
            noteContent.focus();
        } else {
            Custom.showBlockProcessing();
            window.location.href = '/product-order/update-note/?encode=' + ProductOrderDetail.getOrderEncode() + '&note=' + noteContent.val();
        }
    }
}

$(function(){
    Custom.initManualUpdate('product-order');
    $('#btUpdateStatus').click(function(){
        var encode = ProductOrderDetail.getOrderEncode();
        var statusId = ProductOrderDetail.getStatusId();
        var currentStatusId = ProductOrderDetail.getCurrentStatusId();

        if (currentStatusId!=statusId) {
            var message = 'Hãy chắn chắn rằng bạn muốn cập nhật trạng thái cho vé xe này';
            if (confirm(message)) {
                Custom.showBlockProcessing();
                window.location.href = '/product-order/update-status/?encode=' + encode + '&status=' + statusId;
            }
        }
    });

    $('#btUpdateNote').click(function(){
        ProductOrderDetail.updateNote();
    });
});