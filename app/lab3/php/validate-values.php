<?php

// Функция валидации данных, которые пришли с фронта
function filter_request($values)
{
    // Формируем настройки для валидации
    $options_filter = [
        'fname' => [
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => [
                'regexp' => '/[А-я]+/'
            ],
        ],
        'sname' => [
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => [
                'regexp' => '/[А-я]+/'
            ],
        ],
        'mname' => [
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => [
                'regexp' => '/[А-я]+/'
            ],
        ],
        'phone' => [
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => [
                'regexp' => '/^[0-9]{10}$/'
            ],
        ],
        'email' => FILTER_VALIDATE_EMAIL,
        'comment' => [
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => [
                'regexp' => '/^(?!\s+$)[\w\W]+/'
            ],
        ],
    ];

    // Возвращаем валидированные данные
    return filter_var_array($values, $options_filter);
}