const quantityAdult = document.getElementById("quantity_adult");
const quantityChild = document.getElementById("quantity_child");
const quantityInfant = document.getElementById("quantity_infant");

// console.log(123)
const priceAdultText = document.querySelector(".price_adult").textContent;
const priceChildText = document.querySelector(".price_child").textContent;
const priceInfantText = document.querySelector(".price_infant").textContent;

const priceAdult = parseFloat(priceAdultText.replace(/[^\d.-]/g, ""));
const priceChild = parseFloat(priceChildText.replace(/[^\d.-]/g, ""));
const priceInfant = parseFloat(priceInfantText.replace(/[^\d.-]/g, ""));

// console.log(priceAdult);
const totalPriceElement = document.getElementById("total-price");
const totalDepositeElement = document.getElementById("deposit_price");
function updateTotalPrice() {
    const totalAdultPrice = quantityAdult.value * priceAdult;
    const totalChildPrice = quantityChild.value * priceChild;
    const totalInfantPrice = quantityInfant.value * priceInfant;
    const totalPrice = totalAdultPrice + totalChildPrice + totalInfantPrice;
    const totalDeposit = Math.ceil((totalPrice * 50) / 100);

    totalPriceElement.textContent = formatNumber(totalPrice);
    totalDepositeElement.textContent = formatNumber(totalDeposit);

    function formatNumber(amount) {
        // Kiểm tra nếu amount không phải là số, trả về chuỗi rỗng
        if (isNaN(amount)) return "";
        return amount.toLocaleString("vi-VN");
    }
}

quantityAdult.addEventListener("change", updateTotalPrice);
quantityChild.addEventListener("change", updateTotalPrice);
quantityInfant.addEventListener("change", updateTotalPrice);

updateTotalPrice();

jQuery(".booking-tour").on("click", function (e) {
    e.preventDefault();
    bookingTour(1);
});

jQuery(".deposit-tour").on("click", function (e) {
    e.preventDefault();
    bookingTour(2);
});
function bookingTour(paymentType) {
    var checkOutUrl = $(".tour-booking").data("url");
    var totalPriceString = $("#total-price").text();
    var totalPrice = totalPriceString.replace(/\./g, "");
    var totalDepositString = $("#deposit_price").text();
    var totalDeposit = totalDepositString.replace(/\./g, "");
    var tourId = $("#tourId").val();
    var fullname = $("#fullname").val();
    var email = $("#email").val();
    var phone = $("#phone").val();
    var quantity_adult = $("#quantity_adult").val();
    var quantity_child = $("#quantity_child").val();
    var quantity_infant = $("#quantity_infant").val();
    var csrfToken = $('meta[name="csrf-token"]').attr("content");
    $.ajax({
        type: "POST",
        url: checkOutUrl,
        data: {
            totalPrice: totalPrice,
            totalDeposit: totalDeposit,
            tourId: tourId,
            fullname: fullname,
            email: email,
            phone: phone,
            quantity_adult: quantity_adult,
            quantity_child: quantity_child,
            quantity_infant: quantity_infant,
            paymentType: paymentType,
        },
        headers: {
            "X-CSRF-TOKEN": csrfToken,
        },
        success: function (data) {
            if (data.code === 200) {
                $("body").html(data.bookingComponent);
                // console.log(bookingComponent);
            }
        },
        error: function (xhr) {
            if (xhr.status === 429) {
                swal("Số lượng người đã vượt quá giới hạn!", {
                    icon: "warning",
                });
            }
        },
    });
}
