<?php
namespace main;

include 'testing_system/Exam.php';
include 'problems/Solution.php';

use testing_system\Exam;

function printResult($zadacha)
{
    $output = '';
    foreach ($zadacha as $key => $result) {
        $n = $key + 1;
        $mark = $result ? ' &#10003' : '&#10007';
        $output .= "<div>Тест $n : $mark</div>";
    }
    echo $output;
}


$ex1 = new Exam('A');
$zadacha1 = $ex1->examTests('problems\Solution::threeSharpAxes');

$ex2 = new Exam('B');
$zadacha2 = $ex2->examTests('problems\Solution::sizeMatters');

$ex3 = new Exam('C');
$zadacha3 = $ex3->examTests('problems\Solution::cutOnce');

?>

<div>Три острых топора</div>
<?php printResult($zadacha1); ?>
<div></div>
<div>Размер имеет значение</div>
<?php printResult($zadacha2); ?>
<div>Семь раз отмерь, один раз отрежь</div>
<?php printResult($zadacha3); ?>
<?php
//echo '<pre>';
//$ex3->examIter('problems\Solution::cutOnce', 0);
//echo '</pre>';
//?>


