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
        editOrderTour(url);
    });

    function editOrderTour(url) {
        $("#edit-modal").modal("show");
        $.ajax({
            type: "GET",
            url: url,
            success: function (res) {
                if (res.code == 200) {
                    $("#name").val(res.transactionUser.name);
                    $("#email").val(res.transactionUser.email);
                    $("#total_tran").val(res.transaction.total_tran);
                    $("#total_deposit").val(res.transactionOrder.total_deposit);
                    $("#total_person").val(res.transactionOrder.total_person);
                    $("#transactionId").val(res.transaction.id);
                }
            },
        });
    }
});
