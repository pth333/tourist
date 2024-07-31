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
        // console.log(url)
        editTour(url);
    });

    function editTour(url) {
        $("#edit-modal").modal("show");
        $.ajax({
            type: "GET",
            url: url,
            success: function (res) {
                if (res.code == 200) {
                    $("#name_tour").val(res.tour.name_tour);
                    $("#price").val(res.tour.price);
                    $("#sale_price").val(res.tour.sale_price);
                    $("#departure_day").val(res.tour.departure_day);
                    $("#return_day").val(res.tour.return_day);
                    $("#type_vehical").val(res.tour.type_vehical);
                    $("#departure").val(res.tour.departure);
                    $("#destination").val(res.tour.destination);
                    $("#price_adult").val(res.tour.price_adult);
                    $("#price_child").val(res.tour.price_child);
                    $("#price_infant").val(res.tour.price_infant);
                    $("#max_participants").val(res.tour.max_participants);
                    $("#category_id").val(res.tour.category_id);
                    $("#tourId").val(res.tour.id);

                    $("#feature_image_preview").attr(
                        "src",
                        res.tour.feature_image_path
                    );

                    $("#other_images_container").empty();
                    // Hiển thị ảnh chi tiết
                    res.tourImageDetail.forEach(function (image) {
                        var imgElement = $("<img>");
                        imgElement.attr("src", image.image_path);
                        imgElement.addClass("other-image");
                        $("#other_images_container").append(imgElement);
                        //  console.log(image.image_path)
                    });

                    if (!editor) {
                        ClassicEditor.create(document.querySelector("#editor_edit"))
                            .then((newEditor) => {
                                editor = newEditor;
                                // Set nội dung vào CKEditor
                                editor.setData(res.tour.description);
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
                }
            },
        });
    }
});
