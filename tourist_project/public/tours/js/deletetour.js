function actionDelete(event) {
    event.preventDefault();
    let urlRequest = jQuery(this).data("url");
    let that = jQuery(this);
    // console.log(urlRequest)
    swal({
        title: "Bạn có chắc chắn muốn xóa?",
        text: "Bạn sẽ không thể hoàn tác lại nó!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            jQuery.ajax({
                url: urlRequest,
                data: {
                    _method: "DELETE",
                },
                success: function (data) {
                    if (data.code == 200) {
                        that.parent().parent().remove();
                        swal("Bạn đã xóa thành công!", {
                            icon: "success",
                        });
                    }
                },
                error: function () {
                    swal("Xóa không thành công!", {
                        icon: "error",
                    });
                },
            });
        } else {
            swal("Dữ liệu của bạn chưa được xóa!");
        }
    });
}
// Gán sự kiện click cho các phần tử có class .action_delete
$(document).on("click", ".action_delete", actionDelete);
