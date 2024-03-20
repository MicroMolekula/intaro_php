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
                $this->tests['dat'][] = file_get_contents($content);
            } else {
                $this->tests['ans'][] = file_get_contents($content);
            }
        }
    }

    public function examTests($callback)
    {
        $this->initTests();
        print_r(call_user_func($callback, $this->tests['dat'][0]));
//        $result = [];
//        for ($i = 0; $i < count($this->tests['dat']); $i++){
//            $result[] = $this->tests['ans'][$i]  == call_user_func($callback, $this->tests['dat'][$i]);
//        }
//        return $result;
    }

}