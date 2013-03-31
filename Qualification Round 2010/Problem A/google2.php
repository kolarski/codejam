<?php

/**
 * @author Pro4Life
 * @copyright 2010
 */

 $N = 1;
 $K = 1;
 $Tests = array();
 
 GetParameters();
 function GetParameters(){
      global $Tests;
        $handle = @fopen("input.txt", "r");
        $i=0;
        if ($handle) {
            while (!feof($handle)) {
                
                $buffer = fgets($handle, 4096);
                if ($i > 0) list($N, $K) = split(" ", $buffer, 2); 
                if ($K <> '' && $N <> '') {
                    $Tests[$i]['K'] = $K;
                    $Tests[$i]['N'] = $N;
                }
                $i++;
            }
            fclose($handle);    
        }
    }
    
$All2OnN = array();
$LimitN = 10; // For big 30 
for ($i=1; $i<=$LimitN;$i++){
    $All2OnN[$i]= pow(2,$i);
}
$OutputText = ''; $Counter = 1;
foreach($Tests as $Test){
    $K_plus = $Test['K']+1;
    $ok = true;
    for($i=1; $i<=$Test['N'];$i++){
        if ($K_plus % $All2OnN[$i] <> 0) {$ok = false; break;}
    }
    
    if ($ok) 
        $OutputText .= "Case #".$Counter.": ON\n";
    else 
        $OutputText .= "Case #".$Counter.": OFF\n";

    $Counter++;
    
}
//echo $OutputText;

    $myFile = "output.txt";
    $fh = fopen($myFile, 'w') or die("can't open file");
    fwrite($fh, $OutputText);
    fclose($fh);

//echo (10 % 6);

 //foreach($Tests as $Test) {TestCase($Test['N'],$Test['K'],$CaseN); $CaseN++;}


 
   /*
    // OUTPUT
    if ($$MyObjectName->hasPower == 1 &&  $$MyObjectName->State == 1){
     echo 'Case #'.$CaseN.': ON<br />';
    } else { 
        echo 'Case #'.$CaseN.': OFF<br />'; 
    }
    
   */
   /*
    $myFile = "output.txt";
    $fh = fopen($myFile, 'a') or die("can't open file");
    if ($$MyObjectName->hasPower == 1 &&  $$MyObjectName->State == 1)
        $stringData = "Case #".$CaseN.": ON\n";
    else 
        $stringData = "Case #".$CaseN.": OFF\n";
    fwrite($fh, $stringData);
    fclose($fh);
   */
    
?>