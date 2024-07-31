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
        editUser(url);
    });

    function editUser(url) {
        $("#edit-modal").modal("show");
        $.ajax({
            type: "GET",
            url: url,
            success: function (res) {
                if (res.code == 200) {
                    $("#name").val(res.user.name);
                    $("#email").val(res.user.email);

                    // Clear existing options
                    $("#role_id").empty();

                    // Add options for roles to dropdown
                    res.roles.forEach(function (roleItem) {
                        var option = new Option(
                            roleItem.name,
                            roleItem.id,
                            false,
                            false
                        );
                        $("#role_id").append(option);
                    });

                    // Initialize Select2
                    $("#role_id").select2({
                        placeholder: "Chọn vai trò",
                        allowClear: true,
                    });

                    // Get selected role IDs from roleUsers
                    var selectedRoles = res.roleUsers.map(function (role) {
                        return role.id;
                    });

                    // Set selected values
                    $("#role_id").val(selectedRoles).trigger("change");

                    $("#userId").val(res.user.id);
                }
            },
        });
    }
});
