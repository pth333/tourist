var editor
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $(".edit").on("click", function (e) {
        e.preventDefault();
        var url = $(this).data("url");
        editDestination(url);
    });

    function editDestination(url) {
        $("#edit-modal").modal("show");
        $.ajax({
            type: "GET",
            url: url,
            success: function (res) {
                if (res.code == 200) {
                    $("#name").val(res.destination.name_des);
                    $("#address").val(res.destination.address);
                    $("#ticket_price").val(res.destination.ticket_price);
                    $("#latitude").val(res.destination.latitude);
                    $("#longtitude").val(res.destination.longtitude);
                    $("#close_time").val(res.destination.close_time);
                    $("#open_time").val(res.destination.open_time);
                    $("#category_id").val(res.destination.category_id);
                    $("#feature_image_preview").attr(
                        "src",
                        res.destination.feature_image_path
                    );
                    $("#destinationId").val(res.destination.id);

                    if (!editor) {
                        ClassicEditor.create(
                            document.querySelector("#editor_edit")
                        )
                            .then((newEditor) => {
                                editor = newEditor;
                                // Set nội dung vào CKEditor
                                editor.setData(res.destination.description);
                            })
                            .catch((error) => {
                                console.error(error);
                            });
                    }

                    $("#edit-modal").on("hidden.bs.modal", function () {
                        if (editor) {
                            editor
                                .destroy()
                                .then(() => {
                                    editor = null; // Đặt editor về null sau khi đã hủy
                                    console.log("Editor was destroyed");
                                })
                                .catch((error) => {
                                    console.error(
                                        "Error destroying editor:",
                                        error
                                    );
                                });
                        }
                    });
                    // Hiển thị ảnh chi tiết
                    // console.log(res.destinationImage)
                    $("#other_images_container").empty();
                    res.destinationImage.forEach(function (image) {
                        var imgElement = $("<img>");
                        imgElement.attr("src", image.image_path);
                        imgElement.addClass("other-image");
                        $("#other_images_container").append(imgElement);
                        //  console.log(image.image_path)
                    });

                }
            },
        });
    }
});
