<?php

namespace problems;

use DateTime;

class Solution
{
    // Задача "Три острых топора"
    public static function threeSharpAxes($input): int
    {
        $inputArray = [];
        // Сплитим строку по \n
        $tmpArray = explode("\n", $input);
        // Проходимся по всем значениям нового массива
        foreach ($tmpArray as $item) {
            // Проверям если в строке 3 элемента, значит это ставка
            if (count(explode(" ", $item)) == 3) {
                // Делим массив на номер матча, сумму ставки и на результат матча
                list($n, $total, $result) = explode(" ", $item);
                $bet = compact(array('n', 'total', 'result'));
                // Помещаем в подмассив ставок
                $inputArray['bets'][] = $bet;
                continue;
            }
            // Проверям если в строке 5 элемента, значит это матч
            if (count(explode(" ", $item)) == 5) {
                // Разбиваем строку на номер матча, коэффициенты на комманд и на результат
                list($n, $L, $R, $D, $result) = explode(" ", $item);
                $match = compact(array('n', 'L', 'R', 'D', 'result'));
                // Помещаем в подмассив матчей
                $inputArray['matches'][] = $match;
                continue;
            }
            $inputArray[] = explode(" ", $item);
        }

        // Общая сумма ставок
        $overTotalBets = 0;
        // Выигрыш со ставок
        $totalWin = 0;

        // Проходимся по ставкам
        foreach ($inputArray['bets'] as $bet) {
            // Добавляем сумму ставки в общую сумму ставок
            $overTotalBets += (int)($bet['total']);
            // Матч на который было поставлено
            $match = $inputArray['matches'][(int)$bet['n'] - 1];
            // Проверям зашла ли ставка
            if ($bet['result'] == $match['result']) {
                // Добавляем в сумму выигрыша произведение коэффицинта и суммы ставки
                $totalWin += (int)$bet['total'] * (float)$match[$bet['result']];
            }
        }

        return $totalWin - $overTotalBets;
    }

    // Задача "Размер имеет значение"
    public static function sizeMatters($input): string
    {
        $inputArray = [];
        $tmpArray = explode("\n", $input);
        // Проходимся по входным строкам
        foreach ($tmpArray as $item) {
            // Сплитим строку на элементы, которые разделенны :
            $item = explode(":", $item);
            // Удаляем из массива пустые элементы
            $item = array_diff($item, array(''));
            $item = array_map(function ($value) {
                // Если длина элемента массива меньше 4, то мы добавляем к нему 0
                if (strlen($value) < 4) {
                    // Сплитим строку на символы
                    $value = str_split($value);
                    // Создаем массив с недостающими нулями в элементе массива
                    $zeroArray = array_fill(0, 4 - count($value), 0);
                    // Сливаем массив нулей и массив с нашими значениями, новый массив объединяем в строку
                    return implode('', array_merge($zeroArray, $value));
                }
                return $value;
            }, (array)$item);
            $inputArray[] = $item;
        }

        //  Проходимся по нашим массивам и добиваем их недостающими 0000
        foreach ($inputArray as $key => $item) {
            // Если длина массива меньше 8, значит в нем не достает 0000
            if (count($item) < 8) {
                // Определяем какое количество 0000 нам нужно добить в массив
                $tmp = 8 - count($item);
                for ($i = 0; $i < 8; $i++) {
                    // Проверяем существует ли данный ключ в массиве, если нет значит нам нужно поместить туда 0000
                    if (!key_exists($i, $item)) {
                        $res = [];
                        // Создаем массив из 0000 размера недостающего количества
                        for ($j = 0; $j < $tmp; $j++) {
                            $res[] = '0000';
                        }
                        // Помещаем массив из 0000 в массив с нашими значениями
                        array_splice($item, $i, 0, $res);
                    }
                }
            }
            // Соединяем массив в строку
            $inputArray[$key] = implode(':', $item);
        }
        $output = implode("\n", $inputArray);
        return $output;
    }

    // Задача "Семь раз отмерь, один раз отрежь"
    public static function cutOnce($input): string
    {
        // Разбиваем входные строки на значение и параметр валидации
        $inputArray = array_map(function ($v) {
            return preg_split("/(?<=\>)\s/", $v);
        }, explode("\n", $input));

        $result = array_map(function ($v) {
            switch ($v[1][0]) {
                    // Валидация для обычной строки
                case 'S':
                    $params = explode(" ", $v[1]);
                    // Проверяем на длину
                    return strlen(trim($v[0], "<>")) <= (int)$params[2] &&
                        strlen(trim($v[0], "<>")) >= (int)$params[1] ?
                        "OK" : "FAIL";
                    // Валидация для числа
                case 'N':
                    $params = explode(" ", $v[1]);
                    $str = trim($v[0], "<>");
                    // Провеяем являются ли данные числом, в проверку также входит проверка на отрицательные числа
                    if (preg_match("#^(-\d+)$|^(\d+)$#", $str)) {
                        return (int)$str <= (int)$params[2] &&
                            (int)$str >= (int)$params[1] ?
                            "OK" : "FAIL";
                    }
                    return "FAIL";
                    // Валидация номера телефона
                case 'P':
                    return preg_match('#^\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}$#', trim($v[0], "<>")) ?
                        "OK" : "FAIL";
                    // Валидация даты
                case 'D':
                    $matches = [];
                    if (preg_match(
                        '#^([0-9]|[0-2][0-9]|[3][0-1]).([0][0-9]|[1][0-1]|[0-9]|12).(\d{4}) ([0-1][0-9]|[2][0-3]|[0-9]):([0-5][0-9])$#',
                        trim($v[0], "<>"),
                        $matches
                    )) {
                        // В массив matches помещаются подгруппы регулярного выражения, в подгруппе 2 находится месяц
                        // В подгруппе 1 день месяца, а в подгруппе 3 год
                        // Проверка на дни февраля в високосный год и в не високосный
                        if ((int)$matches[2] == 2) {
                            if ((int)$matches[1] <= 28 && (int)$matches[3] % 4 != 0) return "OK";
                            if ((int)$matches[1] <= 29 && (int)$matches[3] % 4 == 0) return "OK";
                            else return "FAIL";
                        }
                        return "OK";
                    }
                    return "FAIL";
                    // Валидация электронной почты
                case 'E':
                    return preg_match(
                        '#^(^[a-zA-Z0-9][a-zA-Z0-9_]{3,29})@([a-zA-Z]{2,30})\.([a-z]{2,10})$#',
                        trim($v[0], "<>")
                    ) ?
                        "OK" : "FAIL";
            }
            return "FAIL";
        }, $inputArray);

        $output = implode("\n", $result);

        $outputArray = array_map(function ($v) {
            return array_map(function ($s) {
                return htmlspecialchars($s);
            }, $v);
        }, $inputArray);

        return $output;
    }

    // Задача 1 на регулярки
    public static function regProblem1($input): string
    {
        // Находим число в строке и заменяем его на произведение этого числа и 2
        return preg_replace_callback("#'\d+'#", function ($matches) {
            $v = trim($matches[0], "'");
            return "'" . (int)$v * 2 . "'";
        }, $input);
    }

    // Задача 2 на регулярки
    public static function regProblem2($input): string
    {
        // Находим в строке параметр url
        preg_match("#(?<=&RN=)(\d+-\d+)(?=&)#", $input, $matches);
        // И помещаем этот параметр в новый url
        return "http://sozd.parlament.gov.ru/bill/$matches[0]";
    }

    private static function getDateOfID($id, $array): array
    {
        $result = [];
        foreach ($array as $value) {
            if ($value['id'] == $id) $result[] = new DateTime($value['date']);
        }
        return $result;
    }

    // Задача Рекламы много не бывает
    public static function adALotOf($input): string
    {
        $inputArray = explode("\n", $input);
        $arrayAd = [];
        foreach ($inputArray as $value) {
            $tmp = preg_split("/\s+/", $value);
            $arrayAd[] = [
                "id" => $tmp[0],
                "date" => $tmp[1] . ' ' . $tmp[2],
            ];
        }
        $idArray = array_column($arrayAd, 'id');
        $uniqueId = array_unique($idArray);
        $countId = array_count_values($idArray);
        $lastDatesOfId = [];
        foreach ($uniqueId as $value) {
            $lastDatesOfId[$value] = max(self::getDateOfID($value, $arrayAd));
        }
        $result = [];
        $lastDatesOfId = array_map(function ($v) {
            return $v->format('d.m.Y H:i:s');
        }, $lastDatesOfId);
        foreach ($uniqueId as $value) {
            $result[] = "{$countId[$value]} $value {$lastDatesOfId[$value]}";
        }
        return implode("\n", $result);
    }

    // Задача Разделяй и влавствуй
    public static function divideAndConquer($input): string
    {
        $inputArray = explode("\n", $input);
        $arrayItems = [];
        foreach ($inputArray as $value) {
            $tmp = explode(' ', $value);
            $arrayItems[] = [
                'id' => $tmp[0],
                'title' => $tmp[1],
                'lkey' => $tmp[2],
                'rkey' => $tmp[3],
            ];
        }
        usort($arrayItems, function ($a, $b) {
            return ($a['lkey'] < $b['lkey']) ? -1 : 1;
        });
        $itemTree = [];
        foreach ($arrayItems as $value) {
            $itemTree[$value['id']] = [
                'title' => $value['title'],
            ];
        }
        foreach ($arrayItems as $value) {
            foreach ($arrayItems as $value2) {
                if ($value['lkey'] < $value2['lkey'] && $value['rkey'] > $value2['rkey']) {
                    $itemTree[$value2['id']]['title'] = '-' . $itemTree[$value2['id']]['title'];
                }
            }
        }
        $result = implode("\n", array_column($itemTree, 'title'));

        return $result;
    }

    private static function getWeightedRandomElement($banners)
    {
        $totalWeight = array_sum(array_column($banners, 'weight'));
        $random = mt_rand(1, $totalWeight);
        $currentWeight = 0;

        foreach ($banners as $banner) {
            $currentWeight += $banner['weight'];
            if ($random <= $currentWeight) {
                return $banner['id'];
            }
        }
    }

    // Задача Большой куш
    public static function bigGulp($input): string
    {
        $lines = explode("\n", $input);
        $banners = [];
        foreach ($lines as $line) {
            list($id, $weight) = explode(' ', $line);
            $weight = (int)$weight;
            $banners[] = ['id' => $id, 'weight' => $weight];
        }
        $showCounts = [];
        foreach ($banners as $banner) {
            $showCounts[$banner['id']] = 0;
        }
        $totalShows = 1000000;
        for ($i = 0; $i < $totalShows; $i++) {
            $selectedBanner = self::getWeightedRandomElement($banners);
            $showCounts[$selectedBanner]++;
        }
        $result = '';
        $bannerRes = [];
        foreach ($banners as $banner) {
            $share = $showCounts[$banner['id']] / $totalShows;
            $share = number_format($share, 6, '.', '');
            $bannerRes[] = $banner['id'] . ' ' . $share;
        }

        $result = implode("\n", $bannerRes);
        return $result;
    }
}
