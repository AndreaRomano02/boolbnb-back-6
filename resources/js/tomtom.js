import axios from "axios";

const dropdown = document.getElementById("dropdown");
const inputElement = document.getElementById("address");
const latitudeField = document.getElementById("latitude");
const longitudeField = document.getElementById("longitude");
const url = "https://api.tomtom.com/search/2/search/";
let latitude = "";
let longitude = "";
let timer; // dichiaro la variabile del timer

//# Attendo che venga scritto qualcosa nell'input
inputElement.addEventListener("input", (e) => {
    //* Azzero le variabili
    latitudeField.value = "";
    longitudeField.value = "";
    dropdown.classList.remove("show");
    const input = inputElement.value;

    const params = {
        key: "PWX9HGsOx1sGv84PlpxzgXIbaElOjVMF",
        limit: 5,
        country: "italy",
    };

    //# Faccio partire un timer di 5 secondi che se si smette di scrivere e non è stata cliccata una via
    //# viene precompilato con il primo parametro
    timer = setTimeout(() => {
        axios.get(`${url}${input}.json`, { params }).then((res) => {
            const firstAddress = res.data.results[0].address.freeformAddress;
            inputElement.value = firstAddress;
            latitude = res.data.results[0]["position"]["lat"];
            longitude = res.data.results[0]["position"]["lon"];
            latitudeField.value = latitude;
            longitudeField.value = longitude;
            dropdown.classList.remove("show");
        });
    }, 5000);

    //# Attendo che nell'input ci siano almeno 8 caratteri
    if (input.length >= 8) {
        dropdown.classList.add("show");

        //# Faccio la chiamata per avere tutti i suggerimenti
        axios
            .get(`${url}${input}.json`, { params })
            .then((res) => {
                let results = [];
                dropdown.innerHTML = "";
                results = res.data.results;
                results.forEach((result) => {
                    dropdown.innerHTML += `<li><button type="button" class="dropdown-item">${result.address.freeformAddress}</button></li>`;
                    const items = document.querySelectorAll(".dropdown-item");
                    items.forEach((item) => {
                        item.addEventListener("click", () => {
                            clearTimeout(timer); // interrompo il timer
                            inputElement.value = item.innerText;
                            dropdown.classList.remove("show");
                            latitude = res.data.results[0]["position"]["lat"];
                            longitude = res.data.results[0]["position"]["lon"];
                            latitudeField.value = latitude;
                            longitudeField.value = longitude;
                        });
                    });
                });
            })
            .catch((err) => console.log(err));
    }
});

//# Ogni volta che finsco di digitare interrompe il timer
inputElement.addEventListener("keydown", () => {
    clearTimeout(timer);
});
