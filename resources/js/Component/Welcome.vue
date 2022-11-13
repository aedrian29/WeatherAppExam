<template>
    <div id="main" :class="isDay ? 'day-'+citySearch : 'night-'+citySearch">

        <div v-if="showWeather" class="container my-3" style="max-width: 400px; min-width: 360px;">
            <h1 class="title text-center">#TravelJapan</h1>
            <form class="search-location">
                <select
                v-on:change.prevent="getData"
                class="form-control text-muted form-rounded p-3 shadow-sm"
                style="text-align-last:center;"
                v-model="citySearch"
            >
                    <option value="Tokyo">Tokyo</option>
                    <option value="Yokohama">Yokohama</option>
                    <option value="Kyoto">Kyoto</option>
                    <option value="Osaka">Osaka</option>
                    <option value="Sapporo">Sapporo</option>
                    <option value="Nagoya">Nagoya</option>
                </select>
            </form>
        <div
            class="card rounded my-3 shadow-lg back-card overflow-hidden"
            v-if="visible"
            style="height:400px"
        >
            <div>
                <div icon="sunny" v-if="clearSky" data-label="Sunny">
                    <span class="sun"></span>
                </div>

            <div icon="snowy" v-if="snowy" data-label="Chilly">
                <ul>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                </ul>
            </div>

            <div icon="stormy" v-if="stormy" data-label="Soggy">
                <span class="cloud"></span>
                <ul>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                </ul>
            </div>
            <div icon="cloudy" v-if="cloudy" data-label="Perfect">
                <span class="cloud"></span>
                <span class="cloud"></span>
            </div>
            <div icon="nightmoon" v-if="clearNight" data-label="Cool!">
                <span class="moon"></span>
                <span class="meteor"></span>
            </div>
            </div>

            <div class="card-top text-center" style="margin-bottom: 7rem">
                <div class="city-name my-3">
                    <p>Weather</p>
                    <span>...</span>
                </div>
            </div>

            <div class="card-body">
                <div class="card-mid">
                    <div class="row">
                        <div class="col-12 text-center temp" style="margin-bottom: 1rem">
                            <span>{{ weather.temperature }}&deg;C</span>
                            <p class="my-4">{{ weather.description.toUpperCase() }}</p>
                        </div>
                    </div>
                <div class="row">
                    <div class="col d-flex justify-content-between px-5 mx-5">
                        <p>
                            <img src="./../../svg/down.svg" alt="" />
                            {{ weather.lowTemp }}&deg;C
                        </p>
                        <p>
                            <img src="./../../svg/up.svg" alt="" />
                            {{ weather.highTemp }}&deg;C
                        </p>
                    </div>
                </div>
            </div>
            <div class="card-bottom px-5 py-4 row">
                <div class="col text-center">
                    <p>{{ weather.feelsLike }}&deg;C</p>
                    <span>Feels like</span>
                </div>
                <div class="col text-center">
                    <p>{{ weather.humidity }}%</p>
                    <span>humidity</span>
                </div>
                </div>
            </div>
        </div>
        <div class="text-center">
            <button v-on:click.prevent="showHide" class=" btn btn-lg btn-dark"> Places to visit in {{weather.cityName}}</button>
        </div>
      </div>

      <div v-if="showPlace" class="container my-3" style="max-width: 400px; min-width: 360px;">
            <h1 class="title text-center">#TravelJapan</h1>
            <form class="search-location">
                <select
                    v-on:change.prevent="getData"
                    class="form-control text-muted form-rounded p-3 shadow-sm my-3"
                    style="text-align-last:center;"
                    v-model="citySearch"
                >
                    <option value="Tokyo"> Tokyo </option>
                    <option value="Yokohama"> Yokohama </option>
                    <option value="Kyoto"> Kyoto </option>
                    <option value="Osaka"> Osaka </option>
                    <option value="Sapporo"> Sapporo </option>
                    <option value="Nagoya"> Nagoya </option>
                </select>
            </form>
        <div
          class="card-places card overflow-auto"
          v-if="visible"
          style="height:400px;"
        >
        <p class="pt-3" style="text-align: Center;"><b>#Visit{{weather.cityName}}</b></p>
        <div v-for="(place, key) in places" class="p-2">
            <p style="text-align: Left;">
                <b>Name</b>
                <br> {{place.text.primary ??= "N/A"}}
                <br> <b>Address</b>
                <br> {{place.text.secondary ??= "N/A"}}
            </p>
        </div>
        </div>
            <div class="text-center pt-2">
                <button v-on:click.prevent="showHide" class="btn btn-lg btn-dark"> Weather in {{weather.cityName}}</button>
            </div>
        </div>
    </div>
</template>
<script>
  export default {
    data() {
      return {
        showWeather: true,
        showPlace: false,
        cityFound: false,
        visible: false,
        stormy: false,
        cloudy: false,
        clearSky: false,
        clearNight: false,
        snowy: false,
        isDay: true,
        citySearch: "Tokyo",
        weather: {
            cityName: "",
            country: "",
            temperature: "",
            description: "",
            lowTemp: "",
            highTemp: "",
            feelsLike: "",
            humidity: "",
        },
        places: {},
      };
    },
    methods: {
      showHide: async function() {
            this.showWeather = !this.showWeather;
            this.showPlace = !this.showPlace;
      },

      getData: async function () {
        console.log(this.citySearch);
        const baseURL = `/city_data/${this.citySearch}`;

        try {
            const response = await fetch(baseURL);
            const data = await response.json();
            const weatherData = data["weather"];
            const cityData = data["places"];

            this.weather.cityName = weatherData.name;
            this.weather.country = weatherData.sys.country;
            this.weather.temperature = Math.round(weatherData.main.temp);
            this.weather.description = weatherData.weather[0].description;
            this.weather.lowTemp = Math.round(weatherData.main.temp_min);
            this.weather.highTemp = Math.round(weatherData.main.temp_max);
            this.weather.feelsLike = Math.round(weatherData.main.feels_like);
            this.weather.humidity = Math.round(weatherData.main.humidity);
            this.places = cityData;
            console.log(cityData)
            const timeOfDay = weatherData.weather[0].icon;

            if (timeOfDay.includes("n")) {
                this.isDay = false;
            } else {
                this.isDay = true;
            }

            const mainWeather = weatherData.weather[0].main;
            if (mainWeather.includes("Clouds")) {
                this.stormy = false;
                this.cloudy = true;
                this.clearSky = false;
                this.clearNight = false;
                this.snowy = false;
            }
            if (mainWeather.includes("Clouds")) {
                this.stormy = false;
                this.cloudy = true;
                this.clearSky = false;
                this.clearNight = false;
                this.snowy = false;
            }
            if (
                mainWeather.includes("Thunderstorm") ||
                mainWeather.includes("Rain")
            ) {
                this.stormy = true;
                this.cloudy = false;
                this.clearSky = false;
                this.clearNight = false;
                this.snowy = false;
            }
            if (mainWeather.includes("Clear") && this.isDay) {
                this.stormy = false;
                this.cloudy = false;
                this.clearSky = true;
                this.clearNight = false;
                this.snowy = false;
            }
            if (mainWeather.includes("Clouds") && !this.isDay) {
                this.stormy = false;
                this.cloudy = false;
                this.clearSky = false;
                this.clearNight = true;
                this.snowy = false;
            }
            if (mainWeather.includes("Snow")) {
                this.stormy = false;
                this.cloudy = false;
                this.clearSky = false;
                this.clearNight = false;
                this.snowy = true;
            }

                this.visible = true;
                this.cityFound = false;
            } catch (error) {
                console.log(error);
                this.cityFound = true;
                this.visible = false;
            }
        },

    },
    created: function () {
       this.getData();
    },
  };
</script>
<style scoped>
  @import "./../../css/animation.css";
  @import "./../../css/custom.css";
</style>
