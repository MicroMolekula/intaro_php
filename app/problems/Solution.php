<?php

namespace problems;

class Solution
{
    // Задача "Три острых топора"
    public static function threeSharpAxes($input) : int
    {
        $inputArray = [];
        $tmpArray = explode("\n", $input);
        foreach ($tmpArray as $item) {
            if(count(explode(" ", $item)) == 3){
                list($n, $total, $result) = explode(" ", $item);
                $bet = compact(array('n', 'total', 'result'));
                $inputArray['bets'][] = $bet;
                continue;
            }
            if(count(explode(" ", $item)) == 5){
                list($n, $L, $R, $D, $result) = explode(" ", $item);
                $match = compact(array('n', 'L', 'R', 'D', 'result'));
                $inputArray['matches'][] = $match;
                continue;
            }
            $inputArray[] = explode(" ", $item);
        }

        $overTotalBets = 0;
        $totalWin = 0;

        foreach ($inputArray['bets'] as $bet) {
            $overTotalBets += (int)($bet['total']);
            $match = $inputArray['matches'][(int)$bet['n'] - 1];
            if ($bet['result'] == $match['result']) {
                $totalWin += (int)$bet['total'] * (float)$match[$bet['result']];
            }
        }

        return $totalWin - $overTotalBets;
    }

    // Задача "Размер имеет значение"
    public static function sizeMatters($input)
    {
        $inputArray = [];
        $tmpArray = explode("\n", $input);
        foreach ($tmpArray as $item) {
            $item = explode(":", $item);
            $item = array_diff($item, array(''));
            $item = array_map(function ($value)
            {
                if (strlen($value) < 4) {
                    $value = str_split($value);
                    $zeroArray = array_fill(0, 4 - count($value), 0);
                    return implode('', array_merge($zeroArray, $value));
                }
                return $value;
            }, (array)$item);
            $inputArray[] = $item;
        }

        foreach ($inputArray as $key => $item) {
            if(count($item) < 8){
                $tmp = 8 - count($item);
                for ($i = 0; $i < 8; $i++) {
                    if (!key_exists($i, $item)){
                        $res = [];
                        for ($j = 0; $j < $tmp; $j++) {
                            $res[] = '0000';
                        }
                        array_splice($item, $i, 0, $res);
                    }
                }
            }
            $inputArray[$key] = implode(':', $item);
        }
        $output = implode("\n", $inputArray);
        return $output;
    }

    // Задача "Семь раз отмерь, один раз отрежь"
    public static function cutOnce($input)
    {
        $inputArray = array_map(function ($v){
            return preg_split("/(?<=\>)\s/", $v);
        }, explode("\n", $input));

        $result = array_map(function ($v) {
            switch ($v[1][0]) {
                case 'S':
                    $params = explode(" ", $v[1]);
                    return strlen(trim($v[0], "<>")) <= (int)$params[2] &&
                        strlen(trim($v[0], "<>")) >= (int)$params[1] ?
                        "OK" : "FAIL";
                case 'N':
                    $params = explode(" ", $v[1]);
                    $str = trim($v[0], "<>");
                    if(preg_match("#^(-\d+)$|^(\d+)$#", $str)){
                        return (int)$str <= (int)$params[2] &&
                        (int)$str >= (int)$params[1] ?
                            "OK" : "FAIL";
                    }
                    return "FAIL";
                case 'P':
                    return preg_match('#^\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}$#', trim($v[0], "<>")) ?
                        "OK" : "FAIL";
                case 'D':
                    $matches = [];
                    if(preg_match('#^([0-9]|[0-2][0-9]|[3][0-1]).([0][0-9]|[1][0-1]|[0-9]|12).(\d{4}) ([0-1][0-9]|[2][0-3]|[0-9]):([0-5][0-9])$#',
                        trim($v[0], "<>"), $matches)) {
                        if((int)$matches[2] == 2){
                            if ((int)$matches[1] <= 28 && (int)$matches[3] % 4 != 0) return "OK";
                            if ((int)$matches[1] <= 29 && (int)$matches[3] % 4 == 0) return "OK";
                            else return "FAIL";
                        }
                        return "OK";
                    }
                    return "FAIL";
                case 'E':
                    return preg_match('#^(^[a-zA-Z0-9][a-zA-Z0-9_]{3,29})@([a-zA-Z]{2,30})\.([a-z]{2,10})$#',
                        trim($v[0], "<>")) ?
                        "OK" : "FAIL";
            }
            return "FAIL";
        }, $inputArray);

        $output = implode("\n", $result);

        $outputArray = array_map(function ($v) {
            return array_map(function ($s){
                return htmlspecialchars($s);
            }, $v);
        }, $inputArray);

        return $output;
    }

    // Задача 1 на регулярки
    public static function regProblem1($input)
    {
        return preg_replace_callback("#'\d+'#", function ($matches){
            $v = trim($matches[0], "'");
            return "'" . (int)$v*2 . "'";
        }, $input);
    }

    // Задача 2 на регулярки
    public static function regProblem2($input)
    {
        preg_match("#(?<=&RN=)(\d+-\d+)(?=&)#", $input, $matches);
        return "http://sozd.parlament.gov.ru/bill/$matches[0]";
    }
}