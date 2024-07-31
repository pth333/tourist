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
        editCategory(url);
    });

    function editCategory(url) {
        $("#edit-modal").modal("show");
        $.ajax({
            type: "GET",
            url: url,
            success: function (res) {
                // console.log(res.categories);
                if (res.code == 200) {
                    $("#name").val(res.categories.name);
                    $("#parent_id").val(res.categories.parent_id);
                    $("#categoryId").val(res.categories.id);
                }
            },
        });
    }
});
