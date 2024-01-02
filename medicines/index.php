<?php
	header("Access-Control-Allow-Origin: *");
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Huanhin</title>
	<link rel="stylesheet" href="/style/style.css">
</head>
<body class="space_bottom">
		<div class="container post">
			<div class="response"></div>
			<form method="POST" id="form" autocomplete="off" action="result/">
				<input type="text" id="searchInput" placeholder="Домашняя страна">
				<div id="searchResults"></div>
				<select name="homeCountry" id="homeCountry" style="display: none;">
					<?php
						include 'data_country.php';
						$data = json_decode($response, true);
						for ($i = 0; $i < count($data['countries']); $i++) {
							$country = $data['countries'][$i];
					?>
						<option value="<?php echo $country['id']; ?>"><?php echo $country['name']; ?></option>
					<?php
						}
					?>
				</select>
				<input type="text" id="searchInputm" placeholder="Выберите лекарство">
				<div id="searchResultsm"></div>
				<select name="medicine" id="medicine" style="display: none;">
					<?php
						include 'data_med.php';
						$data = json_decode($response, true);
						for ($i = 0; $i < count($data['medicines']); $i++) {
							$medicine = $data['medicines'][$i];
					?>
						<option value="<?php echo $medicine['id']; ?>"><?php echo $medicine['name']; ?></option>
					<?php
						}
					?>
				</select>
				<input type="text" id="searchInputt" placeholder="Где найти">
				<div id="searchResultst"></div>
				<select name="targetCountry" id="targetCountry" style="display: none;">
					<?php
						include 'data_country.php';
						$data = json_decode($response, true);
						for ($i = 0; $i < count($data['countries']); $i++) {
							$country = $data['countries'][$i];
					?>
						<option value="<?php echo $country['id']; ?>"><?php echo $country['name']; ?></option>
					<?php
						}
					?>
				</select>
				<a class="centered" onclick="sendData()">Найти лекарства</a>
			</form>
		</div>

	<div class="footer">
		<a class="navBtn" id="back" href="/"><span>🏠</span></a>
	</div>

	<script src="https://telegram.org/js/telegram-web-app.js"></script>
	<script src="/script/script.js"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script>
		function select1Change() {
			var data = $('#homeCountry').val();

			$.ajax({
				type: 'POST', // или 'GET', в зависимости от вашего выбора
				url: 'data_hcountry.php',
				data: { data: data },
				success: function(response) {
					$("#medicine").empty();

					$.ajax({
						type: 'POST', // или 'GET', в зависимости от вашего выбора
						url: 'https://api.pillintrip.com/search',
						data: JSON.stringify({
							"api_key": "HJjhs634kjhreifus8234602ngfshdl;kkf72634jwslo4jkdhf",
							"home_country": $('#homeCountry').val(),
							"state": "main_search",
							"query": ""
						}),
						success: function(response) {
							const data = JSON.parse(response);
							for (let i = 0; i < data.medicines.length; i++) {
								var option = $("<option></option>");
								option.val(data.medicines[i].id);
								option.text(data.medicines[i].name);
								$("#medicine").append(option);
							}
						}
					});
					<?php
						// }
					?>
				}
			});
		}


		var searchInput = document.getElementById("searchInput");
		var countrySelect = document.getElementById("homeCountry");
		var options = countrySelect.getElementsByTagName("option");
		var searchResults = document.getElementById("searchResults");

		searchInput.addEventListener("input", function () {
				searchResults.style.visibility = "visible";
				var searchValue = this.value.toLowerCase();

				// Очищаем результаты поиска
				searchResults.innerHTML = "";

				// Перебираем опции select и фильтруем результаты
				for (var i = 0; i < options.length; i++) {
					var option = options[i];
					var countryName = option.innerHTML.toLowerCase();
					if (countryName.indexOf(searchValue) !== -1) {
						var resultOption = document.createElement("div");
						resultOption.innerHTML = option.innerHTML;
						resultOption.value = option.value;
						resultOption.addEventListener("click", function () {
							countrySelect.value = this.value; // Устанавливаем значение в select
							searchInput.value = this.innerHTML; // Устанавливаем значение в input
							searchResults.style.display = "none";
							select1Change();
						});
						searchResults.appendChild(resultOption);
					}
				}

				if (searchResults.innerHTML !== "") {
						searchResults.style.display = "block";
				} else {
						searchResults.style.display = "none";
				}
		});

		searchInput.addEventListener("focusout", function () {
			setTimeout(function () {
				searchResults.style.display = "none";
			}, 200);
		});
		searchInput.addEventListener("focusin", function () {
			if (searchResults.innerHTML == 0) {
				searchResults.style.visibility = "hidden";
			}
			searchResults.style.display = "block";
		});

		var searchInputm = document.getElementById("searchInputm");
		var countrySelectm = document.getElementById("medicine");
		var optionsm = countrySelectm.getElementsByTagName("option");
		var searchResultsm = document.getElementById("searchResultsm");

		searchInputm.addEventListener("input", function () {
			searchResultsm.style.visibility = "visible";
				var searchValuem = this.value.toLowerCase();

				// Очищаем результаты поиска
				searchResultsm.innerHTML = "";

				// Перебираем опции select и фильтруем результаты
				for (var i = 0; i < optionsm.length; i++) {
						var optionm = optionsm[i];
						var countryNamem = optionm.innerHTML.toLowerCase();
						if (countryNamem.indexOf(searchValuem) !== -1) {
								var resultOptionm = document.createElement("div");
								resultOptionm.innerHTML = optionm.innerHTML;
								resultOptionm.value = optionm.value;
								resultOptionm.addEventListener("click", function () {
										countrySelectm.value = this.value; // Устанавливаем значение в select
										searchInputm.value = this.innerHTML; // Устанавливаем значение в input
										searchResultsm.style.display = "none";
								});
								searchResultsm.appendChild(resultOptionm);
						}
				}

				if (searchResultsm.innerHTML !== "") {
						searchResultsm.style.display = "block";
				} else {
						searchResultsm.style.display = "none";
				}
		});

		searchInputm.addEventListener("focusout", function () {
			setTimeout(function () {
				searchResultsm.style.display = "none";
			}, 200);
		});
		searchInputm.addEventListener("focusin", function () {
			if (searchResultsm.innerHTML == 0) {
				searchResultsm.style.visibility = "hidden";
			}
			searchResultsm.style.display = "block";
		});

		var searchInputt = document.getElementById("searchInputt");
		var countrySelectt = document.getElementById("targetCountry");
		var optionst = countrySelect.getElementsByTagName("option");
		var searchResultst = document.getElementById("searchResultst");

		searchInputt.addEventListener("input", function () {
			searchResultst.style.visibility = "visible";
				var searchValuet = this.value.toLowerCase();

				// Очищаем результаты поиска
				searchResultst.innerHTML = "";

				// Перебираем опции select и фильтруем результаты
				for (var i = 0; i < optionst.length; i++) {
						var optiont = optionst[i];
						var countryNamet = optiont.innerHTML.toLowerCase();
						if (countryNamet.indexOf(searchValuet) !== -1) {
								var resultOptiont = document.createElement("div");
								resultOptiont.innerHTML = optiont.innerHTML;
								resultOptiont.value = optiont.value;
								resultOptiont.addEventListener("click", function () {
										countrySelectt.value = this.value; // Устанавливаем значение в select
										searchInputt.value = this.innerHTML; // Устанавливаем значение в input
										searchResultst.style.display = "none";
								});
								searchResultst.appendChild(resultOptiont);
						}
				}

				if (searchResultst.innerHTML !== "") {
						searchResultst.style.display = "block";
				} else {
						searchResultst.style.display = "none";
				}
		});

		searchInputt.addEventListener("focusout", function () {
			setTimeout(function () {
				searchResultst.style.display = "none";
			}, 200);
		});
		searchInputt.addEventListener("focusin", function () {
			if (searchResultst.innerHTML == 0) {
				searchResultst.style.visibility = "hidden";
			}
			searchResultst.style.display = "block";
		});


		function sendData() {
			document.getElementById("form").submit();
		}
	</script>

</body>
</html>