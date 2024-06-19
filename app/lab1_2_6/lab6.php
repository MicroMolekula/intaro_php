<?php
namespace lab12;

include './testing_system/Exam.php';
include './problems/Solution.php';

ini_set('display_errors', 'Off');
use problems\Solution;
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
$ex1 = new Exam('test6/A');
$zadacha1 = $ex1->examTests('problems\Solution::adALotOf');

$ex2 = new Exam('test6/B');
$zadacha2 = $ex2->examTests('problems\Solution::divideAndConquer');

$ex3 = new Exam('test6/C');
$zadacha3 = $ex3->examTestsWithEr('problems\Solution::bigGulp');
?>

<div style="display: flex;
flex-direction: row;
justify-content: space-around;
margin-bottom: 3rem;">
    <div>
        <div>Рекламы много не бывает</div>
        <?php printResult($zadacha1); ?>
    </div>
    <div>
        <div>Разделяй и влавствуй</div>
        <?php printResult($zadacha2); ?>
    </div>
    <div>
        <div>Большой куш</div>
        <?php printResult($zadacha3); ?>
    </div>
</div>
