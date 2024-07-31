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
        editSlider(url);
    });

    function editSlider(url) {
        $("#edit-modal").modal("show");
        $.ajax({
            type: "GET",
            url: url,
            success: function (res) {
                if (res.code == 200) {
                    $("#name").val(res.slider.name);
                    $("#feature_image_preview").attr("src", res.slider.image_path);

                    $("#sliderId").val(res.slider.id);
                    // console.log(res.slider.id);
                     // Lưu nội dung vào trình soạn thảo TinyMCE trước khi đặt nội dung mới
                     $("#description").val(res.slider.description);

                }
            },
        });
    }
});
