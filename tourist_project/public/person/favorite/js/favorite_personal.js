$(document).ready(function () {
    // Lấy trạng thái yêu thích từ localStorage khi trang được tải lại
    $(".heart-icon").each(function () {
        var url = $(this).data("url");
        var tourId = url.substring(url.lastIndexOf("/") + 1);
        var isFavorite = localStorage.getItem("favorite_tour_" + tourId);
        if (isFavorite == "true") {
            $(this).find("i").addClass("fa-solid fa-heart text-danger");
        }
    });
    // console.log(url)
});

function favoriteAdd(event) {
    event.preventDefault(event);
    url = $(this).data("url");
    // console.log(url)
    var that = $(this);
    var action = that.find("i").hasClass("fa-solid") ? "remove" : "add";
    // console.log(isFavorite)
    $.ajax({
        url: url,
        data: {
            action: action,
        },
        method: "GET",
        success: function (res) {
            if (res.code == 200) {
                if (res.action === "add") {
                    that.find("i").toggleClass("fa-solid text-danger");
                    // Lưu trạng thái yêu thích vào localStorage
                    localStorage.setItem("favorite_tour_" + res.tourId, "true");
                    swal("Đã thêm vào mục yêu thích", {
                        icon: "success",
                    });
                } else {
                    that.find("i").removeClass("fa-solid text-danger");
                    localStorage.removeItem("favorite_tour_" + res.tourId);
                    swal("Đã xóa khỏi mục yêu thích", {
                        icon: "success",
                    });
                }
            }
        },
        error: function(xhr){
            if(xhr.code == 429){
                swal("Vui lòng đăng nhập để thêm vào mục yêu thích!", {
                    icon: "warning",
                });
            }
        }
    });
}
$(document).on("click", ".heart-icon", favoriteAdd);
