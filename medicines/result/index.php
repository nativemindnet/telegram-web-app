<?php
// Адрес удаленного сервера, куда вы хотите отправить запрос
$remote_url = "https://api.pillintrip.com/search";

// Тело запроса, которое вы хотите отправить на удаленный сервер
$request_data = [
	'api_key' => "HJjhs634kjhreifus8234602ngfshdl;kkf72634jwslo4jkdhf",
	'home_country' => $_POST['homeCountry'],
	'language' => "ru",
	'state' => "main_search",
	'medicine' => $_POST['medicine'],
	'target_country' => $_POST['targetCountry']
];

// Преобразуйте данные запроса в формат JSON
$request_body = json_encode($request_data);

// Инициализируйте cURL-сессию
$ch = curl_init($remote_url);

// Установите параметры cURL, включая тело запроса
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $request_body);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Выполните запрос к удаленному серверу
$response = curl_exec($ch);

if (curl_errno($ch)) {
	echo 'cURL error: ' . curl_error($ch);
}
// Закройте cURL-сессию
curl_close($ch);

$data = json_decode($response, true);
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
			<?php if ($data['medicine_analogs'] != "no_results") {?>
			<p><span>Домашняя страна:</span> <?php echo $data['medicine_info']['country_name'] ?></p>
			<p><span>Лекарство:</span> <a class="centered" href="https://pillintrip.com/medicine/<?php echo $data['medicine_info']['medicine_slug'] ?>"><?php echo $data['medicine_info']['medicine_name'] ?></a></p>
			<p><span>Состав:</span> <?php
				for ($i = 0; $i < count($data['medicine_info']['components']); $i++) {
					echo $data['medicine_info']['components'][$i];
					if ($i + 1 != count($data['medicine_info']['components'])) {
						echo ", ";
					}
				}
			?></p>
			<?php if ($data['medicine_info']['treatments']) { ?>
			<p><span>Применяется для лечения:</span> <?php
				for ($i = 0; $i < count($data['medicine_info']['treatments']); $i++) {
					echo substr($data['medicine_info']['treatments'][$i], strpos($data['medicine_info']['treatments'][$i], ":") + 1, null);
					if ($i + 1 != count($data['medicine_info']['treatments'])) {
						echo ", ";
					}
				}
			?></p>
			<?php } ?>
			<?php if ($data['medicine_info']['applyings']) { ?>
			<p><span>Фармакологическая группа:</span> <?php
				for ($i = 0; $i < count($data['medicine_info']['applyings']); $i++) {
					echo substr($data['medicine_info']['applyings'][$i], strpos($data['medicine_info']['applyings'][$i], ":") + 1, null);
					if ($i + 1 != count($data['medicine_info']['applyings'])) {
						echo ", ";
					}
				}
			?></p>
			<?php } ?>
		</div>
		<div class="container post">
			<p><span>Страна поиска:</span> <?php echo $data['medicine_analogs']['0']['country_name'] ?></p>
			<p><span>Лучший аналог:</span> <a class="centered" href="https://pillintrip.com/medicine/<?php echo $data['medicine_analogs']['0']['analog_slug'] ?>"><?php echo $data['medicine_analogs']['0']['analog_name'] ?> (совпадение <?php echo $data['medicine_analogs']['0']['percentage'] ?>%)</a></p>
			<p><span>Состав:</span> <?php 
				for ($i = 0; $i < count($data['medicine_analogs']['0']['analog_components']); $i++) {
					echo $data['medicine_analogs']['0']['analog_components'][$i];
					if ($i + 1 != count($data['medicine_analogs']['0']['analog_components'])) {
						echo ", ";
					}
				}
			?></p>
			<p><span>Другие аналоги:</span> <ul>
			<?php
				for ($j = 1; $j < 6; $j++) {
					echo "<li>";
					echo '<a class="centered" href="https://pillintrip.com/medicine/' . $data['medicine_analogs'][$j]['analog_slug'].'">';
					echo $data['medicine_analogs'][$j]['analog_name'] . " (совпадение " . $data['medicine_analogs'][$j]['percentage'] . "%)";
					echo "</a>";
					echo "</li>";
				}
			?>
			</ul></p>
			<?php } else { ?>
				<p class="centered">Нет результатов</p>
			<?php } ?>
			</div>

	<div class="footer">
		<a class="navBtn" id="back" href="/"><span>🏠</span></a>
	</div>

	<script src="https://telegram.org/js/telegram-web-app.js"></script>
	<script src="/script/script.js"></script>
</body>
</html>