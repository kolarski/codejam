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
            return explode(" ",trim(fgets($handle)));
        }
        public function appendResult($T, $result)
        {
            $text = "Case #{$T}: ".$result;
            var_dump($text);
            file_put_contents('output.out', $text. "\n", FILE_APPEND);
        }
        public function moveArya(&$i, &$j)
        {
            var_dump('Arya move');
            var_dump($i, $j);
            if ($i > $j)
            {
                $k = (int)($i / $j) - 1;
                if ($k == 0) $k = 1;
                $i = $i - $k * $j;
            } else {
                $k = (int)($j / $i) - 1;
                if ($k == 0) $k = 1;
                $j = $j - $k * $i;
            }
            var_dump($i, $j);
        }
        public function moveBran(&$i, &$j)
        {
            var_dump('Bran move');
            var_dump($i, $j);
            if ($i > $j)
            {
                $i = $i - 1 * $j;
            } else {
                $j = $j - 1 * $i;
            }
            var_dump($i, $j);
        }
        public function isWinning($i, $j)
        {
            $who_is_no_move = 1; // 1- Arya , -1 - Bran 
            if ($i == $j) return 0;
            while( ($i > 0 && $j > 0) && ($i % $j != 0 && $j % $i != 0) )
            {
                if ($who_is_no_move == 1)
                {
                    $this->moveArya($i, $j);
                } else {
                    $this->moveBran($i, $j);
                }
                $who_is_no_move = -$who_is_no_move;
            }
            return ($i > 0 && $j > 0 && $who_is_no_move == 1)? 1: 0;
        }
        public function solve($plot)
        {
            $winning_pos = 0;
            for ($i=(int)$plot[0]; $i <= (int)$plot[1] ; $i++) { 
                for ($j=(int)$plot[2]; $j <= (int)$plot[3]; $j++) { 
                    var_dump("------{$i} -- ${j}------");
                    $winning_pos += $this->isWinning($i,$j);
                }
            }
            return $winning_pos;
        }
    }
    $task = new Task1();
    list($handle, $T) = $task->getTestCases("C-small-practice.in");
    file_put_contents('output.out', '');
    for ($i=0; $i < $T; $i++)
    {
        $plot = $task->getNextTestCase($handle);
        $result = $task->solve($plot);
        $task->appendResult($i+1, $result);
    }