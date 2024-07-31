$(document).ready(function () {
    $("#departure_tour").keyup(function () {
        let query = $(this).val();
        let url = $(this).data("url");
        console.log(url);
        searchDeparture(query, url);
    });

    $("#destination_tour").keyup(function () {
        let query = $(this).val();
        let url = $(this).data("url");
        // console.log(url);
        searchDestination(query, url);
    });

    $("#location_input").keyup(function () {
        let query = $(this).val();
        let url = $(this).data("url");
        console.log(url);
        searchLocation(query, url);
    });

    function searchDeparture(query, url) {
        if (query != "") {
            $.ajax({
                url: url,
                type: "GET",
                data: {
                    departure: query,
                },
                success: function (data) {
                    // data.forEach(function())
                    // console.log(data);
                    $("#search-results").html(data).show();
                },
            });
        } else {
            $("#search-results").html("").hide();
        }
        $(document).on("click", ".search-item", function () {
            let name = $(this).data("name");
            // console.log(name)
            $("#departure_tour").val(name);
            $("#search-results").hide();
        });
    }

    function searchDestination(query, url) {
        if (query != "") {
            $.ajax({
                url: url,
                type: "GET",
                data: {
                    destination: query,
                },
                success: function (data) {
                    // data.forEach(function())
                    console.log(data);
                    $("#search-results-destination").html(data).show();
                },
            });
        } else {
            $("#search-results-destination").html("").hide();
        }
        $(document).on("click", ".search-item-destination", function () {
            let nameDes = $(this).data("name");
            // console.log(name)
            $("#destination_tour").val(nameDes);
            $("#search-results-destination").hide();
        });
    }


    function searchLocation(query, url) {
        if (query != "") {
            $.ajax({
                url: url,
                type: "GET",
                data: {
                    location: query,
                },
                success: function (data) {
                    // data.forEach(function())
                    console.log(data);
                    $("#search-results-location").html(data).show();
                },
            });
        } else {
            $("#search-results-location").html("").hide();
        }
        $(document).on("click", ".search-item-location", function () {
            let nameLo = $(this).data("name");
            // console.log(nameLo)
            $("#location_input").val(nameLo);
            $("#search-results-location").hide();
        });
    }
});
