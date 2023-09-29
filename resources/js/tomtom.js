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
    };

    if (input.length >= 4) {
        dropdown.classList.add("show");
        axios
            .get(`${url}${input}.json`, { params })
            .then((res) => {
                const results = res.data.results;
                results.forEach((result) => {
                    dropdown.innerHTML += `<li><a class="dropdown-item" >${result.address.freeformAddress} </a></li>`;
                });
            })
            .catch((err) => console.error(err));
    }
});
