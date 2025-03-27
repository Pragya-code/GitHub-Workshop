const apiKey = "eb136d8cad8d35b06b3708919c4936a2";
const apiUrl = "https://api.openweathermap.org/data/2.5/weather?&units=metric&appid=eb136d8cad8d35b06b3708919c4936a2&q=";

const searchBox = document.querySelector(".search input");
const searchBtn = document.querySelector(".search button");
const weatherIcon = document.querySelector(".weather-icon");

// Fetching weather information
async function checkWeather(city) {
    const response = await fetch(`http://localhost/Prototype2/connection.php?q=${city}`);

    // if (response.status == 404) {
    //     document.querySelector(".error").style.display = "block";
    //     document.querySelector(".weather").style.display = "none";
    // } else {
        var data = await response.json();
        console.log(data);

        document.querySelector(".city").innerHTML = data[0].city;
        document.querySelector(".temp").innerHTML = data[0].temperature + "°c";
        document.querySelector(".humidity").innerHTML = data[0].humidity + "%";
        document.querySelector(".wind").innerHTML = data[0].wind + " km/h";
        document.getElementById("icon").src = `http://openweathermap.org/img/w/${data[0].icon}.png`;
        console.log(`http://openweathermap.org/img/w/${data.weather[0].icon}.png`);

        if (data.weather[0].main == "Clouds") {
            weatherIcon.src = "images/clouds.png";
        } else if (data.weather[0].main == "Clear") {
            weatherIcon.src = "images/clear.png";
        } else if (data.weather[0].main == "Rain") {
            weatherIcon.src = "images/rain.png";
        } else if (data.weather[0].main == "Drizzle") {
            weatherIcon.src = "images/drizzle.png";
        } else if (data.weather[0].main == "Mist") {
            weatherIcon.src = "images/mist.png";
        }

        document.querySelector(".weather").style.display = "block";
    }
//}

// Adding event listener
searchBtn.addEventListener("click", () => {
    checkWeather(searchBox.value);
});

checkWeather();
