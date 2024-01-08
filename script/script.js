tg = window.Telegram.WebApp;

if (tg.platform == "unknown") location.replace("/platform");

document.cookie = "huahinUser=" + tg.initDataUnsafe.user.username;
document.cookie = "huahinUserID=" + tg.initDataUnsafe.user.id;

function selectLanguage() {
	langBtn = document.getElementById("lang");
	langBtn1 = document.getElementById("lang1");
	langBtn2 = document.getElementById("lang2");
	langBtn3 = document.getElementById("lang3");
	langBtn4 = document.getElementById("lang4");
	langBtn1.style.display = "none";
	langBtn2.style.display = "block";
	langBtn3.style.display = "block";
	langBtn4.style.display = "block";
}

function deselectLanguage() {
	langBtn = document.getElementById("lang");
	langBtn1 = document.getElementById("lang1");
	langBtn2 = document.getElementById("lang2");
	langBtn3 = document.getElementById("lang3");
	langBtn4 = document.getElementById("lang4");
	langBtn1.style.display = "block";
	langBtn2.style.display = "none";
	langBtn3.style.display = "none";
	langBtn4.style.display = "none";
}

var selectElements = document.querySelectorAll("select");

selectElements.forEach(function(selectElement) {
	if (selectElement.value == "change" || selectElement.value == "null") {
		selectElement.style.margin = "9.5px";
		selectElement.style.background = "var(--main-btn-color)";
		selectElement.style.border = "0";
	}
	else {
		selectElement.style.margin = "7.5px";
		selectElement.style.background = "var(--main-bg-color)";
		selectElement.style.border = "2px solid var(--main-btn-color)";
	}
});

selectElements.forEach(function(selectElement) {
	selectElement.addEventListener("change", function() {
		if (selectElement.value == "change" || selectElement.value == "null") {
			this.style.margin = "9.5px";
			this.style.color = "var(--main-btn-txt-color)";
			this.style.background = "var(--main-btn-color)";
			this.style.border = "0";
		}
		else {
			this.style.margin = "7.5px";
			this.style.color = "var(--main-txt-color)";
			this.style.background = "var(--main-bg-color)";
			this.style.border = "2px solid var(--main-btn-color)";
		}
	});
});

var file = document.getElementById("file-upload");
var fileToSave = document.getElementById("FileToSave");
var fileParag = document.querySelectorAll("#file-upload p");
if (file) {
	file.addEventListener("change", function() {
		if (fileToSave.value == "") {
			fileParag[0].style.color = "var(--main-btn-txt-color)";
			fileParag[1].style.color = "var(--main-btn-txt-color)";
			if (fileParag[2]) {
				fileParag[2].style.color = "var(--main-btn-txt-color)";
			}
			file.style.margin = "9.5px";
			file.style.background = "var(--main-btn-color)";
			file.style.border = "0";
		}
		else {
			fileParag[0].style.color = "var(--main-txt-color)";
			fileParag[1].style.color = "var(--main-txt-color)";
			if (fileParag[2]) {
				fileParag[2].style.color = "var(--main-txt-color)";
			}
			file.style.margin = "7.5px";
			file.style.background = "var(--main-bg-color)";
			file.style.border = "2px solid var(--main-btn-color)";
		}
	});
}