<?php include ("g1_file.php");
$lines = explode("\n",file_get_contents('g1_input.txt','r'));

$currentline =1;
for($TestCase = 1; $TestCase <= $lines[0];$TestCase++){ echo '<br />Currently executing testcase: '.$TestCase.' ...<br />'; 
    
    $N = $lines[$currentline];
    $currentline++; $windows = 0;
    for($i=1;$i<=$N;$i++){
        list($Left,$Right) = split(" ", $lines[$currentline], 2);
        $LeftBuilding[] = $Left;
        $RightBuilding[] = $Right;
        $sum=0;
        $currentline++; $windows++;
    }
    
    $Level = 0;$DrownLeft = array();$DrownRight = array();
    foreach($LeftBuilding as $LeftWindow){
        if (!($LeftWindow == $RightBuilding[$Level])){
            if ($Level == 0) {$DrownLeft[] = $LeftWindow; $DrownRight[] = $RightBuilding[$Level];} else {
            $j=0;
            foreach($DrownLeft as $DrownWindow){
                
                if( ((int)$DrownWindow > (int)$LeftWindow) && ((int)$DrownRight[$j] < (int)$RightBuilding[$Level]))  $sum++;
                if( ((int)$DrownWindow < (int)$LeftWindow) && ((int)$DrownRight[$j] > (int)$RightBuilding[$Level]))  $sum++;
                
                $j++;
            }
            if (!in_array($LeftWindow,$DrownLeft)) $DrownLeft[] = $LeftWindow;
            if (!in_array($RightBuilding[$Level],$DrownRight)) $DrownRight[] = $RightBuilding[$Level];
        }
        }
        $Level++;
    }
   



    
    
$Result = $sum; 
$OutputText .= "Case #".$TestCase.": ".$Result."\n";
$DrownLeft = array(); $DrownRight = array(); $sum=0; $LeftBuilding = array(); $RightBuilding = array();
}



//echo $OutputText;
WriteData($OutputText); 
echo '<br />Ready !!';

?>



