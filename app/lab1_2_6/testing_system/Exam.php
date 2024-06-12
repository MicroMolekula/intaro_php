<?php
namespace testing_system;


class Exam
{
    // Свойство класса, указывающее на директорию теста
    private $dirTests;
    // Ассоциативный массив с тестами
    private $tests;

    // При создании класса указываем название директории с тестами
    public function __construct($dirTests)
    {
        $this->dirTests = "tests/$dirTests";
        // Создаваемый массив
        $this->tests = [
            'dat' => [],
            'ans' => []
        ];
    }

    // Метод для инициализации тестов
    private function initTests()
    {
        // Получаем в массив имена файлов с тестами
        $files = scandir($this->dirTests);
        unset($files[0], $files[1]);
        // Проходимся по всем файлам и помещаем их содержимое в массив с тестами
        foreach ($files as $file) {
            $content = "$this->dirTests/$file";
            if (str_ends_with($file, 'dat')) {
                $this->tests['dat'][] = trim(file_get_contents($content), "\n");
            } else {
                $this->tests['ans'][] = trim(file_get_contents($content), "\n");
            }
        }
    }

    // Метод для проверки одного теста
    // На вход передаем функцию для теста и номер теста
    public function examIter($callback, $numberTest)
    {
        $this->initTests();
        print_r(call_user_func($callback, $this->tests['dat'][$numberTest]));
        print_r($this->tests['ans'][$numberTest]  == call_user_func($callback, $this->tests['dat'][$numberTest]) ?
            '<br><br>Правильно' : '<br><br>Не правильно');
    }

    // Метод для проверки функции на всех тестах
    public function examTests($callback)
    {
        // Инициализируем тесты
        $this->initTests();
        // Создаем массив, в который будем помещать буллевые значения
        $result = [];
        for ($i = 0; $i < count($this->tests['dat']); $i++){
            // Сравниваем ответ из теста и значение которое возвращает функция с данными на вход из теста
            // После чего помещаем результат в массив результата
            $result[] = $this->tests['ans'][$i]  == call_user_func($callback, $this->tests['dat'][$i]);
            // Если какой то из тестов оказался не верным выводим его номер и результат функции
            if(!($this->tests['ans'][$i]  == call_user_func($callback, $this->tests['dat'][$i]))){
                print_r("<pre>" . "$i<br>" . call_user_func($callback, $this->tests['dat'][$i]) . "</pre>");
            }
        }
        return $result;
    }

}