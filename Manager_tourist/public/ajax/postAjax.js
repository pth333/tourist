var editor;
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $(".edit").on("click", function (e) {
        e.preventDefault();
        var url = $(this).data("url");
        // console.log(url);
        editTour(url);
    });

    function editTour(url) {
        $("#edit-modal").modal("show");
        $.ajax({
            type: "GET",
            url: url,
            success: function (res) {
                if (res.code == 200) {
                    $("#name_post").val(res.post.name_post);
                    $("#description").val(res.post.description);
                    $("#postId").val(res.post.id);
                    $("#category_id").val(res.post.category_id);
                    $("#feature_image_preview").attr(
                        "src",
                        res.post.image_post
                    );

                    // console.log(post['name_post'])
                    if (!editor) {
                        ClassicEditor.create(document.querySelector("#editor_edit"))
                            .then((newEditor) => {
                                editor = newEditor;
                                // Set nội dung vào CKEditor
                                editor.setData(res.post.content);
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
