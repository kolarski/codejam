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
            $test_case = array();
            $N_K = explode(" ", trim(fgets($handle)));
            for($i = 0; $i< $N_K[0]; $i++)
            {
                $test_case[] = trim(fgets($handle));
            }
            return array($handle, $test_case, (int) $N_K[0], (int) $N_K[1]);
        }
        public function simulateRotation($board, $N)
        {
            $empty = str_repeat ('.', $N);
            $new_board = '';
            foreach ($board as &$row)
            {
                if (trim($row) == $empty) { $new_board .= $empty; continue; }
                $row = str_replace('.', '', $row);
                $new_board .= str_pad($row, $N, '.', STR_PAD_LEFT);
            }
            return $new_board;
        }
        public function whoWins($board, $N, $needed)
        {
            $R_col = array_fill(0, $N, 0);
            $B_col = array_fill(0, $N, 0);
            $R_dia1 = array_fill(0, $N*2-1, 0);
            $R_dia2 = array_fill(0, $N*2-1, 0);
            $B_dia1 = array_fill(0, $N*2-1, 0);
            $B_dia2 = array_fill(0, $N*2-1, 0);
            $R_OK = false;
            $B_OK = false;
           
            for($i=$N-1; $i>=0; $i--)
            {
                if ($R_OK && $B_OK) break;
                $R_row = 0;
                $B_row = 0;
                $row = substr($board, $i*$N, $N);
                $row1 = str_pad(str_pad('',$i,'.').$row, $N*2-1, '.');
                $row2 = str_pad($row.str_pad('',$i,'.'), $N*2-1, '.', STR_PAD_LEFT);
                for($d=0; $d<$N*2-1; $d++)
                {
                    if (!$R_OK) {
                        if ($row1[$d] == "R")
                        {
                            $R_dia1[$d] += 1;
                            if ($R_dia1[$d] >= $needed) $R_OK = true;
                        } else {
                            $R_dia1[$d] = 0;
                        }
                        if ($row2[$d] == "R")
                        {
                            $R_dia2[$d] += 1;
                            if ($R_dia2[$d] >= $needed) $R_OK = true;
                        } else {
                            $R_dia2[$d] = 0;
                        }
                    }
                    if (!$B_OK) {
                        if ($row1[$d] == "B")
                        {
                            $B_dia1[$d] += 1;
                            if ($B_dia1[$d] >= $needed) $B_OK = true;
                        } else {
                            $B_dia1[$d] = 0;
                        }
                        if ($row2[$d] == "B")
                        {
                            $B_dia2[$d] += 1;
                            if ($B_dia2[$d] >= $needed) $B_OK = true;
                        } else {
                            $B_dia2[$d] = 0;
                        }
                    }
                }
                for($j=$N-1; $j>=0; $j--)
                {
                    if ($R_OK && $B_OK) break;
                    if (!$R_OK) {
                        if ($board[$i*$N + $j] == "R")
                        {
                            $R_col[$j] += 1;
                            $R_row += 1;
                            if ($R_col[$j] >= $needed || $R_row >= $needed) $R_OK = true;
                        } else {
                            $R_row = 0;
                            $R_col[$j] = 0;
                        }
                    }
                    if (!$B_OK) {
                        if ($board[$i*$N + $j] == "B")
                        {
                            $B_col[$j] += 1;
                            $B_row += 1;
                            if ($B_col[$j] >= $needed || $B_row >= $needed) $B_OK = true;
                        } else {
                            $B_row = 0;
                            $B_col[$j] = 0;
                        }
                    }
                }
            }
            return array($R_OK, $B_OK);
        }
        public function appendResult($T, $result)
        {
            if ($result[0] == false & $result[1] == false) $word = 'Neither';
            if ($result[0] == true & $result[1] == false) $word = 'Red';
            if ($result[0] == false & $result[1] == true) $word = 'Blue';
            if ($result[0] == true & $result[1] == true) $word = 'Both';
            $text = "Case #{$T}: ".$word;
            file_put_contents('output.out', $text. "\n", FILE_APPEND);
        }
    }
    
    $task = new Task1();
    list($handle, $T) = $task->getTestCases("A-large-practice.in");
    file_put_contents('output.out', '');
    for ($i=0; $i < $T; $i++)
    {
        list($handle, $board, $N, $K) = $task->getNextTestCase($handle);
        $board = $task->simulateRotation($board, $N);
        $result = $task->whoWins($board, $N, $K);
        $task->appendResult($i+1, $result);
    }