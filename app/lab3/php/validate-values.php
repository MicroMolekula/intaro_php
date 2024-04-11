<?php

function filter_request($values)
{
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

    return filter_var_array($values, $options_filter);
}