document
    .getElementById("weatherForm")
    .addEventListener("submit", function (event) {
        event.preventDefault();
        const latitude = document.getElementById("latitude").value;
        const longitude = document.getElementById("longitude").value;
        const date = new Date(document.getElementById("date").value);
        const apiKey = "77fdf7914d4c945a1e215a8cf2c5d0a2";
        const apiUrl = `https://api.openweathermap.org/data/2.5/forecast?lat=${latitude}&lon=${longitude}&appid=${apiKey}&units=metric&lang=vi`;
        // console.log(apiUrl);
        fetch(apiUrl)
            .then((response) => response.json())
            .then((data) => {
                const weatherResult = document.getElementById("weatherResult");
                const forecastList = data.list;
                const forecastDate = date.toISOString().split("T")[0];
                const forecast = forecastList.find((item) =>
                    item.dt_txt.startsWith(forecastDate)
                );
                const formattedDate = forecastDate.split("-").reverse().join("-");
                console.log(forecastList);
                if (forecast) {
                    weatherResult.innerHTML = `
                    <h6>Thời Tiết vào ngày ${formattedDate} ở ${data.city.name}</h6>
                    <p>Nhiệt độ trung bình: ${forecast.main.temp}°C</p>
                    <p>Tình hình thời tiết: ${forecast.weather[0].description}</p>
                    <p>Độ ẩm: ${forecast.main.humidity}%</p>
                    <p>Tốc độ gió: ${forecast.wind.speed} m/s</p>
                `;
                } else {
                    weatherResult.innerHTML = `<p>Không tìm thấy thông tin thời tiết cho ngày đã chọn.</p>`;
                }
            })
            .catch((error) => {
                console.error("Error fetching weather data:", error);
                weatherResult.innerHTML = `<p>Đã xảy ra lỗi khi lấy thông tin thời tiết. Vui lòng thử lại sau.</p>`;
            });
    });
