<?php
    class Task1 {
        public function getTestCases($filename)
        {
            $handle = fopen($filename, "r");
            $T = (int) fgets($handle);
            return array($handle, $T);
        }
        public function getNextTestCase($handle)
        {
            return trim(fgets($handle));
        }
        public function appendResult($T, $result)
        {
            $text = "Case #{$T}: ".$result;
            file_put_contents('output.out', $text. "\n", FILE_APPEND);
        }
    }
    
    $task = new Task1();
    list($handle, $T) = $task->getTestCases("B-large-practice.in");
    file_put_contents('output.out', '');
    for ($i=0; $i < $T; $i++)
    {
        $msg = $task->getNextTestCase($handle);
        $task->appendResult($i+1, implode(" ",array_reverse(explode(" ", $msg))));
    }