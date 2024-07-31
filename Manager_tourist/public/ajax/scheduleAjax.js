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
                    $("#order_date").val(res.tourSchedule.order_date);
                    $("#schedule").val(res.tourSchedule.schedule);
                    $("#activity").val(res.tourSchedule.activity);
                    $("select[name='tour_id']").val(res.tourSchedule.tour_id);
                    $("#scheduleId").val(res.tourSchedule.id);

                    // console.log(editor)

                    if (!editor) {
                        ClassicEditor.create(
                            document.querySelector("#editor_edit")
                        )
                            .then((newEditor) => {
                                editor = newEditor;
                                // Set nội dung vào CKEditor
                                editor.setData(res.tourSchedule.description);
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
