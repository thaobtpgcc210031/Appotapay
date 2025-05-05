jQuery(function($){
    $('#address-book-form').on('submit', function(e){
        e.preventDefault();
        const data = $(this).serializeArray().reduce((obj, item) => {
            obj[item.name] = item.value;
            return obj;
        }, {});
        $.post(WAB.ajax_url, {
            action: 'save_address',
            ...data
        }, function(res){
            if (res.success) {
                alert('Lưu địa chỉ thành công!');
                location.reload();
            } else {
                alert('Đã có lỗi xảy ra!');
            }
        });
    });

    $('.delete-address').on('click', function(){
        if (!confirm("Bạn chắc chắn muốn xoá địa chỉ này?")) return;
        const id = $(this).closest('[data-id]').data('id');
        $.post(WAB.ajax_url, {
            action: 'delete_address',
            address_id: id
        }, function(res){
            if (res.success) {
                alert('Xoá địa chỉ thành công!');
                location.reload();
            } else {
                alert('Không xoá được địa chỉ!');
            }
        });
    });
});
