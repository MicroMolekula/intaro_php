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
    public static function cutOnce()
    {
        // \+7 \(\d{3}\) \d{3}-\d{2}-\d{2}
        // ^([0-2][0-9]|30).([0-9]|[1][0-1]|12).(\d{4}) ([0-1][0-9]|[2][0-3]):([0-5][0-9]|60)
    }
}