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
                    $("#config_key").val(res.setting.config_key);
                    $("#config_value").val(res.setting.config_value);
                    $("#settingId").val(res.setting.id);
                }
            },
        });
    }
});
