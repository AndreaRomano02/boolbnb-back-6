import axios from "axios";

const inputField = document.getElementById("address");
const latitudeField = document.getElementById("latitude");
const longitudeField = document.getElementById("longitude");
const key = "key=PWX9HGsOx1sGv84PlpxzgXIbaElOjVMF";
let latitude = "";
let longitude = "";

inputField.addEventListener("input", (e) => {
    const address = inputField.value;

    if (address.length == 0) {
        latitudeField.value = "";
        longitudeField.value = "";
    }

    if (address.length >= 8) {
        const test = address.split(" ").join("%20");
        console.log(test);
        const endpoint = `https://api.tomtom.com/search/2/geocode/%20${test}.json?${key}`;
        const config = {
            headers: { "Access-Control-Allow-Origin": "*" },
        };
        axios.get(endpoint, config).then((res) => {
            latitude = res.data.results[0]["position"]["lat"];
            longitude = res.data.results[0]["position"]["lon"];
            latitudeField.value = latitude;
            longitudeField.value = longitude;
        });
    }
});
