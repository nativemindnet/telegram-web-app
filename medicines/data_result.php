<?php
// Адрес удаленного сервера, куда вы хотите отправить запрос
$remote_url = "https://api.pillintrip.com/search";

// Тело запроса, которое вы хотите отправить на удаленный сервер
$request_data = [
    'api_key' => 'HJjhs634kjhreifus8234602ngfshdl;kkf72634jwslo4jkdhf',
    'home_country' => '94',
    'language' => 'en',
    'state' => 'main_search',
    'url_medicine' => 'geksoral-rus',
    'url_target_country' => 'thailand'
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

// Верните ответ в виде JSON
echo $response;


?>