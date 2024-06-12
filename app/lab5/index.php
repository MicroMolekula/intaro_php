<?php
$apiKey = '';
// $content = file_get_contents("https://geocode-maps.yandex.ru/1.x/?apikey=$apiKey&format=json&geocode=метро");
// $content = json_decode($content, true);
$coord = '';
$formatedAddress = '';
$metro = '';
$error = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if($_POST['address'] != ''){
        $addressRequest = $_POST['address'];
        $apiUrl = "https://geocode-maps.yandex.ru/1.x/?apikey={$apiKey}&format=json&geocode=" . urlencode($addressRequest);
        $content = file_get_contents($apiUrl);
        $content = json_decode($content, true);
        $formatedAddress = $content['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['metaDataProperty']['GeocoderMetaData']['Address']['formatted'];
        $coord = $content['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['Point']['pos'];

        $coordRequest = implode(',', explode(' ', $coord));

        $metroResponse = file_get_contents("https://geocode-maps.yandex.ru/1.x/?apikey={$apiKey}&format=json&geocode=" . $coordRequest . "&kind=metro");
        $metroContent = json_decode($metroResponse, true);

        if (isset($metroContent['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['name'])){
            $metro = $metroContent['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['name'];
        } else {
            $metro = 'Метро не найдено';
        }
    }else {
        $error = 'Введите адрес';
    }
}

?>


<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <title>Яндекс карты</title>
</head>

<body>
    <form style="margin-left: 2rem; margin-top: 1rem;" action="index.php" method="post">
        <div style="font-weight: 600; font-size: 24px; margin-bottom: 3rem;">Поиск ближайшего метро</div>
        <div class="mb-3" style="width: 40rem;">
            <label for="address" class="form-label">Адрес:</label>
            <input type="text" class="form-control" id="address" name="address" placeholder="Адрес">
            <div><?=$error?></div>
        </div>
        <button type="submit" class="btn btn-primary">Найти метро</button>
    </form>
    <?php if($formatedAddress != '') {?>
    <div style="margin-left: 2rem; margin-top: 1rem;">Форматированный адрес: <?= $formatedAddress ?></div>
    <?php }?>
    <?php if($coord != '') {?>
    <div style="margin-left: 2rem;">Координаты: <?= $coord ?></div>
    <?php }?>
    <?php if($coord != '') {?>
    <div style="margin-left: 2rem;">Метро: <?= $metro ?></div>
    <?php }?>
    
</body>

</html>