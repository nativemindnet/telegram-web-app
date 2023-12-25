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

const filterAuthor = params.get("author");
if (filterAuthor == "on") {
	filterableContainers.forEach(container => {
		const authorElement = container.querySelector('#author');
		const authorText = authorElement.textContent;
		if (authorText != tg.initDataUnsafe.user.username) {
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