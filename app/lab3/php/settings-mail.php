<?php

// Настройки для отправки письма
return [
    'mail_settings_prod' => [
        'host' => 'smtp.gmail.com',
        'auth' => true,
        'port' => 465,
        'secure' => 'ssl',
        'username' => 'mmiamoto284@gmail.com',
        'password' => explode("=", file_get_contents("../.env"))[1],
        'charset' => 'UTF-8',
        'from_email' => 'mmiamoto284@gmail.com',
        'from_name' => 'Ivan',
        'is_html' => true,
    ],
];