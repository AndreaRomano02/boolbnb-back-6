import axios from "axios";

const dropdown = document.getElementById("dropdown");
const inputElement = document.getElementById("address");
const url = "https://api.tomtom.com/search/2/search/";

inputElement.addEventListener("input", (e) => {
    dropdown.classList.remove("show");
    const input = inputElement.value;

    const params = {
        key: "PWX9HGsOx1sGv84PlpxzgXIbaElOjVMF",
        limit: 5,
        country: "italy",
    };

    if (input.length >= 15) {
        console.log(input);
        dropdown.classList.add("show");
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
                            inputElement.value = item.innerText;
                            dropdown.classList.remove("show");
                        });
                    });
                });
            })
            .catch((err) => console.log(err));
    }
});
