<?php
header('Content-Type: application/json; charset=UTF-8');
require_once "../vendor/autoload.php";
// Подключаем настройки для отправки письма по почте
$mail_settings = require_once "./settings-mail.php";
// Подключаем файл с функцией отправки письма
require_once "./mail.php";
// Подключаем БД
$pdo = require_once "connect_db.php";
// Подключаем файл с функцией валидации данных
require_once "validate-values.php";
// Подключаем файл с функциями для работы с БД
require_once "work_with_bd.php";

// Получаем данные с запроса
$json = file_get_contents('php://input');
$post = json_decode($json, true);

// Делим ФИО на отдельные поля Фамилия Имя Отчество
$post['name'] = trim($post['name'], " ");
list($sname, $fname, $mname) = explode(" ", $post['name']);
$post["sname"] = trim($sname, " ");
$post["fname"] = trim($fname, " ");
$post["mname"] = trim($mname, " ");
unset($post["name"]);

// Валидируем данные
$post = filter_request($post);

// Проверка результата валидации
if(!array_search(false, $post)){
    // Создание объекта даты и времени по МСК
    $date = new DateTime('now', timezone_open('Europe/Moscow'));
    // Проверяем отправлялось ли сообщение с такой же почтой в течение часа
    $ch_mail = check_email($pdo, $post, $date);
    // Если сообщение с этой почтой не отправлялось в течение часа, то добавляем данные в БД
    $flag_db = $ch_mail == 'ok' ? add_values_bd($pdo, $post, $date->format("Y-m-d H:i:s")) : false;
    // Проверка на ошибку добавления данных в БД
    if($flag_db){
        // Формируем ответ для письма
        $response_mail = "
            <div><b>Отправлено сообщение из формы обратной связи</b></div>
            <div><b>Имя:</b> {$post['fname']}</div>
            <div><b>Фамилия:</b> {$post['sname']}</div>
            <div><b>Отчество:</b> {$post['mname']}</div>
            <div><b>E-mail:</b> {$post['email']}</div>
            <div><b>Телефон:</b> +7{$post['phone']}</div>
            <div><b>Сообщение:</b> {$post['comment']}</div>
            <div><b>Дата:</b> {$date->format('H:i:s d:m:Y')}</div>
        ";

        // Отправляем письма на указанную почту
        send_mail($mail_settings['mail_settings_prod'], "mmiamoto284@gmail.com", "Отправлено сообщение из формы обратной связи", $response_mail);

        // Создаем объект времени с интервалом в 1.5 часа для ответа пользователю
        $date_connection = $date->add(new DateInterval('PT1H30M'));
        // Формируем ответ
        $response = [
            'message' => 'ok',
            'surname' => $post['sname'],
            'name' => $post['fname'],
            'middle_name' => $post['mname'],
            'email' => $post['email'],
            'phone' => "+7{$post['phone']}",
            'date' => $date_connection->format("H:i:s d:m:Y"),
        ];
        // Отправляем json на front
        $responseJson = json_encode($response);
        echo $responseJson;
    } else {
        // Если сообщение с этой почтой уже было отправлено в течение часа, то отправляем ответ с Ошибкой
        echo json_encode([
            'message' => 'fail',
            'date' => $ch_mail,
        ]);
    }
} else {
    print_r("Error");
}

