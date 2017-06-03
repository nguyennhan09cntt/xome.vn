$(function(){
    $('#btn_add_new').click(function(){
        Metronic.redirect('config-shorten-url/edit/');
    });

    $('.btDeleteUrl').click(function(){
        var msg = 'Thao tác này sẽ xóa dữ liệu shorten url hiện tại. Bạn có chắc là mình muốn thực hiện điều này.';
        if (confirm(msg)) {
            Metronic.redirect( 'config-shorten-url/delete-by-id/?i=' + this.rel );
        }
    });
});
