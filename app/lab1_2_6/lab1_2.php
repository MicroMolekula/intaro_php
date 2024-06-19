<?php
namespace lab12;

include './testing_system/Exam.php';
include './problems/Solution.php';

use problems\Solution;
use testing_system\Exam;


ini_set('display_errors', 'Off');
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

$input1 = '';
if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['input1']){
    $input1 = $_POST['input1'];
}

$input2 = '';
if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['input2']){
    $input2 = $_POST['input2'];
}


$ex1 = new Exam('tests/A');
$zadacha1 = $ex1->examTests('problems\Solution::threeSharpAxes');

$ex2 = new Exam('tests/B');
$zadacha2 = $ex2->examTests('problems\Solution::sizeMatters');

$ex3 = new Exam('tests/C');
$zadacha3 = $ex3->examTests('problems\Solution::cutOnce');

?>

<div style="display: flex;
flex-direction: row;
justify-content: space-around;
margin-bottom: 3rem;">
    <div>
        <div>Три острых топора</div>
        <?php printResult($zadacha1); ?>
    </div>
    <div>
        <div>Размер имеет значение</div>
        <?php printResult($zadacha2); ?>
    </div>
    <div>
        <div>Семь раз отмерь, один раз отрежь</div>
        <?php printResult($zadacha3); ?>
    </div>
</div>
<div style="margin-bottom: 3rem;">
    <div>Задача 1 на регулярки</div>
    <form action="lab1_2.php" method="post">
        <input type="text" name="input1" value="<?= $input1 ?>">
        <input type="submit">
    </form>

    <?php if($input1) {?>
        <div>Ответ: <?= Solution::regProblem1($input1) ?></div>
    <?php } ?>
</div>
<div style="margin-bottom: 3rem;">
    <div>Задача 2 на регулярки</div>
    <form action="lab1_2.php" method="post">
        <input style="width: 100%" type="text" name="input2" value="<?= $input2 ?>">
        <input type="submit">
    </form>

    <?php if($input2) {?>
        <div>Ответ: <?= Solution::regProblem2($input2) ?></div>
    <?php } ?>
</div>
<!--<div>Интерактивное тестирование</div>-->
<?php
//echo '<pre>';
//$ex3->examIter('problems\Solution::cutOnce', 0);
//echo '</pre>';
//?>
