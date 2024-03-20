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

    public static function sizeMatters($input)
    {
        function callback($value)
        {
            if (strlen($value) < 4) {

            }
        }

        $inputArray = [];
        $tmpArray = explode("\n", $input);
        foreach ($tmpArray as $item) {
            $item = explode(":", $item);
            $item = array_diff($item, array(''));
            array_map();
            $inputArray[] = $item;

        }
        return $inputArray;
    }
}