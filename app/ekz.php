<?php
function strToCamelCase(string $input)
{
    $inputArray = preg_split("/\_+/", $input);
    for($i = 1; $i < count($inputArray); $i++) {
        $inputArray[$i] = mb_convert_case($inputArray[$i], MB_CASE_TITLE, "UTF-8");
    }
    return implode('', $inputArray);
}

$input = '';
if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['input']){
    $input = $_POST['input'];
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Экзамен по php</title>
</head>

<body>
    <form action="ekz.php" method="post">
        <input style="width: 100%" type="text" name="input" value="<?= $input ?>">
        <input type="submit">
    </form>
    <?php if($input) {?>
        <div>Ответ: <pre><?php print_r(strToCamelCase($input)) ?></pre></div>
    <?php } ?>
</body>

</html>