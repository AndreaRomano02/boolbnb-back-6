import axios from "axios";

const dropdown = document.getElementById("dropdown");
const inputElement = document.getElementById("address");
const latitudeField = document.getElementById("latitude");
const longitudeField = document.getElementById("longitude");
const form = document.getElementById("form");
const feedback = document.querySelector(".feedback-address");

const url = "https://api.tomtom.com/search/2/search/";
let latitude = "";
let longitude = "";
let is_clicked = true;

//# Attendo che venga scritto qualcosa nell'input
inputElement.addEventListener("input", (e) => {
    //* Azzero le variabili
    is_clicked = false;
    latitudeField.value = "";
    longitudeField.value = "";
    dropdown.classList.remove("show");
    const input = inputElement.value;

    const params = {
        key: "PWX9HGsOx1sGv84PlpxzgXIbaElOjVMF",
        limit: 5,
        country: "italy",
    };
    //# Attendo che nell'input ci siano almeno 8 caratteri
    if (input.length >= 8) {
        console.log(is_clicked);
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
                            is_clicked = true;
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

form.addEventListener("submit", (e) => {
    if (!is_clicked) {
        e.preventDefault();
        feedback.innerText = "L'indirizzo inserito non è completo";
        inputElement.classList.add("is-invalid");
    } else {
        feedback.innerText = "";
        inputElement.classList.remove("is-invalid");
    }
});
