function openCurrentPostEdit(id) {
	document.cookie = "huahinCurrentPost=" + id;
	window.location.href = "edit/";
}
function openCurrentPostDel(id) {
	document.cookie = "huahinCurrentPost=" + id;
	window.location.href = "delete/";
}
function openCurrentPostBook(id) {
	document.cookie = "huahinCurrentPost=" + id;
	window.location.href = "book/";
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

const filterPool = params.get("pool");
if ((filterPool != null) && (filterPool != "null")) {
	filterableContainers.forEach(container => {
		const poolElement = container.querySelector('#pool');
		const poolText = poolElement.textContent;
		if (poolText.slice(poolText.indexOf(":") + 2) != filterPool) {
			container.style.display = "none";
		}
	});
}

const filterChildren = params.get("children");
if ((filterChildren != null) && (filterChildren != "null")) {
	filterableContainers.forEach(container => {
		const childrenElement = container.querySelector('#children');
		const childrenText = childrenElement.textContent;
		if (childrenText.slice(childrenText.indexOf(":") + 2) != filterChildren) {
			container.style.display = "none";
		}
	});
}

const filterPet = params.get("pet");
if ((filterPet != null) && (filterPet != "null")) {
	filterableContainers.forEach(container => {
		const petElement = container.querySelector('#pet');
		const petText = petElement.textContent;
		if (petText.slice(petText.indexOf(":") + 2) != filterPet) {
			container.style.display = "none";
		}
	});
}

const filterRooms = params.get("rooms");
if ((filterRooms != null) && (filterRooms != "null")) {
	filterableContainers.forEach(container => {
		const roomsElement = container.querySelector('#rooms');
		const roomsText = roomsElement.textContent;
		if (roomsText.slice(roomsText.indexOf(":") + 2) != filterRooms) {
			container.style.display = "none";
		}
	});
}

const filterBathRooms = params.get("bathrooms");
if ((filterBathRooms != null) && (filterBathRooms != "null")) {
	filterableContainers.forEach(container => {
		const bathRoomsElement = container.querySelector('#bathrooms');
		const bathRoomsText = bathRoomsElement.textContent;
		if (bathRoomsText.slice(bathRoomsText.indexOf(":") + 2) != filterBathRooms) {
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

const filterSizeMin = params.get("minSize");
const filterSizeMax = params.get("maxSize");
if ((filterSizeMin != null) && (filterSizeMax != null)) {
	filterableContainers.forEach(container => {
		const sizeElement = container.querySelector('#size');
		const sizeText = sizeElement.textContent;
		if (parseInt(sizeText.slice(sizeText.indexOf(":") + 2, -2)) < parseInt(filterSizeMin) || parseInt(sizeText.slice(sizeText.indexOf(":") + 2, -2)) > parseInt(filterSizeMax)) {
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