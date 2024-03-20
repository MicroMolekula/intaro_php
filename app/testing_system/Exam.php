<?php
namespace exam;

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

    public function initTests()
    {
//        $countTests = (count(scandir($this->dirTests))-2)/2;
        $files = scandir($this->dirTests);
        unset($files[0], $files[1]);
        foreach ($files as $file){

        }
//        for ($i = 1; $i <= $countTests; $i++){
//            $filenameDat = $i < 10 ? "00$i.dat" : "0$i.dat";
//            $filenameAns = $i < 10 ? "00$i.ans" : "0$i.ans";
//            $contentsDat = file_get_contents($this->dirTests . "/$filenameDat");
//            $contentsAns = file_get_contents($this->dirTests . "/$filenameAns");
//            array_push($this->tests['dat'], $contentsDat);
//            array_push($this->tests['ans'], $contentsAns);
//        }
    }


}