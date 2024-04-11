<?php
header('Content-Type: application/json; charset=UTF-8');
require_once "../vendor/autoload.php";
$mail_settings = require_once "./settings-mail.php";
require_once "./mail.php";
$pdo = require_once "connect_db.php";
require_once "validate-values.php";
require_once "work_with_bd.php";

$json = file_get_contents('php://input');
$post = json_decode($json, true);


$post['name'] = trim($post['name'], " ");
list($sname, $fname, $mname) = explode(" ", $post['name']);
$post["sname"] = trim($sname, " ");
$post["fname"] = trim($fname, " ");
$post["mname"] = trim($mname, " ");
unset($post["name"]);

$post = filter_request($post);

if(!array_search(false, $post)){
    $date = new DateTime('now', timezone_open('Europe/Moscow'));
    $flag_db = add_values_bd($pdo, $post, $date->format("Y-m-d H:i:s"));
    if($flag_db){
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
        send_mail($mail_settings['mail_settings_prod'], "mmiamoto284@gmail.com", "Отправлено сообщение из формы обратной связи", $response_mail);

        $date_connection = $date->add(new DateInterval('PT1H30M'));
        $response = [
            'surname' => $post['sname'],
            'name' => $post['fname'],
            'middle_name' => $post['mname'],
            'email' => $post['email'],
            'phone' => "+7{$post['phone']}",
            'date' => $date_connection->format("H:i:s d:m:Y"),
        ];
        $responseJson = json_encode($response);
        echo $responseJson;
    } else {
        print_r("Error db");
    }
} else {
    print_r("Error");
}

