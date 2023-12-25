function openCurrentPostEdit(id) {
	document.cookie = "huahinCurrentPost=" + id;
	window.location.href = "edit/";
}
function openCurrentPostDel(id) {
	document.cookie = "huahinCurrentPost=" + id;
	window.location.href = "delete/";
}

const filtersBtn = document.getElementById("filtersBtn");
const filtersPage = document.getElementById("filtersPage");

filtersBtn.addEventListener("click", function() {
	filtersPage.classList.toggle("hidden");
});

//////////////////////////////////////
var url = window.location.href;
const filterableContainers = document.querySelectorAll('.container');
const params = new URLSearchParams(window.location.search);
tg = window.Telegram.WebApp;

const filterCategory = params.get("category");
if ((filterCategory != null) && (filterCategory != "null")) {
	filterableContainers.forEach(container => {
		const categoryElement = container.querySelector('#category');
		const categoryText = categoryElement.textContent;
		if (categoryText.slice(categoryText.indexOf(":") + 2) != filterCategory) {
			container.style.display = "none";
		}
	});
}

const filterType = params.get("type");
if ((filterType != null) && (filterType != "null")) {
	filterableContainers.forEach(container => {
		const typeElement = container.querySelector('#type');
		const typeText = typeElement.textContent;
		if (typeText.slice(typeText.indexOf(":") + 2) != filterType) {
			container.style.display = "none";
		}
	});
}

const filterBrand = params.get("brand");
if ((filterBrand != null) && (filterBrand != "null")) {
	filterableContainers.forEach(container => {
		const brandElement = container.querySelector('#brand');
		const brandText = brandElement.textContent;
		if (brandText.slice(brandText.indexOf(":") + 2) != filterBrand) {
			container.style.display = "none";
		}
	});
}


const filterPriceMin = params.get("minPrice");
const filterPriceMax = params.get("maxPrice");
if ((filterPriceMin != null) && (filterPriceMax != null)) {
	filterableContainers.forEach(container => {
		const priceElement = container.querySelector('#price');
		const priceText = priceElement.textContent;
		if (parseInt(priceText.slice(priceText.indexOf(":") + 2, -2)) < parseInt(filterPriceMin) || parseInt(priceText.slice(priceText.indexOf(":") + 2, -2)) > parseInt(filterPriceMax)) {
			container.style.display = "none";
		}
	});
}

const filterAuthor = params.get("author");
if (filterAuthor == "on") {
	filterableContainers.forEach(container => {
		const authorElement = container.querySelector('#author');
		const authorText = authorElement.textContent;
		if (authorText != tg.initDataUnsafe.user.id) {
			container.style.display = "none";
		}
	});
}

//////////////////////////////

var countOfVisibleCont = 0;
const elCont = document.querySelectorAll(".container");

elCont.forEach(function(elCont) {
  if (window.getComputedStyle(elCont).display === "none") {
    countOfVisibleCont++;
  }
});

if (document.getElementsByClassName('container').length <= countOfVisibleCont) {
	document.getElementById("empty").style.display = "flex";
}
else {
	document.getElementById("empty").style.display = "none";
}