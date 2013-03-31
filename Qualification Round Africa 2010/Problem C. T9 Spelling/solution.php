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
            $a = fgets($handle);
            return str_replace("\n", '', $a);
        }
        public function appendResult($T, $result)
        {
            $text = "Case #{$T}: ".$result;
            file_put_contents('output.out', $text. "\n", FILE_APPEND);
        }
        public function revMapping()
        {
            $rev_mapping = array();
            $mapping = array(
            array(' '),array(), array('a','b','c'),array('d','e','f'),array('g','h','i'),array('j','k','l'),
            array('m','n','o'),array('p','q','r','s'),array('t','u','v'), array('w','x','y','z'),
            array('null'));
            foreach ($mapping as $key1 => $value1)
            {
                foreach ($value1 as $key => $value)
                {
                    $rev_mapping[$value] = implode("", array_fill(0, $key+1, $key1));
                }
            }
            return $rev_mapping;
        }
        public function solve($msg)
        {
            $out = '';
            $reverse_mapping = $this->revMapping();
            $prev = null;
            $msg_l = strlen($msg);
            for ($i=0; $i < $msg_l ; $i++) {
                if ($prev) {
                    $a = $reverse_mapping[$prev];
                    if ($a[strlen($a)-1] == $reverse_mapping[$msg[$i]][0]) {
                        $out .= ' ';
                    }
                }
                $out .= $reverse_mapping[$msg[$i]];
                $prev = $msg[$i];
            }
            return $out;
        }
    }
    
    $task = new Task1();
    list($handle, $T) = $task->getTestCases("C-small-practice.in");
    file_put_contents('output.out', '');
    for ($i=0; $i < $T; $i++)
    {
        $msg = $task->getNextTestCase($handle);
        $result = $task->solve($msg);
        var_dump($result);
        $task->appendResult($i+1, $result);
    }