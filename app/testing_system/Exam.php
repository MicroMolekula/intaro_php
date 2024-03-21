<?php
namespace testing_system;


class Exam
{
    private $dirTests;
    private $tests;

    public function __construct($dirTests)
    {
        $this->dirTests = "tests/$dirTests";
        $this->tests = [
            'dat' => [],
            'ans' => []
        ];
    }

    private function initTests()
    {
        $files = scandir($this->dirTests);
        unset($files[0], $files[1]);
        foreach ($files as $file) {
            $content = "$this->dirTests/$file";
            if (str_ends_with($file, 'dat')) {
                $this->tests['dat'][] = trim(file_get_contents($content), "\n");
            } else {
                $this->tests['ans'][] = trim(file_get_contents($content), "\n");
            }
        }
    }

    public function examIter($callback, $numberTest)
    {
        $this->initTests();
        print_r(call_user_func($callback, $this->tests['dat'][$numberTest]));
        print_r($this->tests['ans'][$numberTest]  == call_user_func($callback, $this->tests['dat'][$numberTest]) ?
            'Правильно' : 'Не правильно');
    }

    public function examTests($callback)
    {
        $this->initTests();
        $result = [];
        for ($i = 0; $i < count($this->tests['dat']); $i++){
            $result[] = $this->tests['ans'][$i]  == call_user_func($callback, $this->tests['dat'][$i]);
            if(!($this->tests['ans'][$i]  == call_user_func($callback, $this->tests['dat'][$i]))){
                print_r("<pre>" . "$i<br>" . call_user_func($callback, $this->tests['dat'][$i]) . "</pre>");
            }
        }
        return $result;
    }

}