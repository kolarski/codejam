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
            $total_sum = trim(fgets($handle));
            fgets($handle);
            $products = explode(" ", trim(fgets($handle)));
            return array($total_sum, $products);
        }
        public function appendResult($T, $result)
        {
            $text = "Case #{$T}: ".$result;
            file_put_contents('output.out', $text. "\n", FILE_APPEND);
        }
        public function solve($total_sum, $products)
        {
            // rsort($products);
            $products_count = count($products);
            for ($i=0; $i < $products_count; $i++) { 
                for ($j=$i+1; $j < $products_count; $j++) { 
                    if ($products[$i] + $products[$j] == $total_sum) return array($i+1, $j+1);
                }
            }
        }
    }
    
    $task = new Task1();
    list($handle, $T) = $task->getTestCases("A-large-practice.in");
    file_put_contents('output.out', '');
    // $T = 1;
    for ($i=0; $i < $T; $i++)
    {
        list($total_sum, $products) = $task->getNextTestCase($handle);
        $result = $task->solve($total_sum, $products);
        // var_dump($result);
        $task->appendResult($i+1, implode(" ", $result));
    }