$(document).ready(function () {
    // Thiết lập AJAX để bao gồm token CSRF
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    // Hàm xử lý xóa
    function actionDelete(event) {
        event.preventDefault();
        let urlRequest = jQuery(this).data("url");
        console.log(urlRequest);
        let that = jQuery(this);
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
                        _method: 'DELETE' // Sử dụng _method để chỉ định phương thức DELETE
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
                        swal("Bạn không có quyền xóa!", {
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
});
