<?php include ("g1_file.php"); //GetParameters();


$lines   = explode("\n",file_get_contents('g1_input.txt','r'));

$currentline =1;
for($TestCase = 1; $TestCase <= $lines[0];$TestCase++){
     list($N,$M) = split(" ", $lines[$currentline], 2);
     $currentline++; $inputPathsOnPC=array();$inputPathsToCreate=array();
    
     for($linesonPC=1;$linesonPC <= $N;$linesonPC++){
        $inputPathsOnPC[] = $lines[$currentline];
        $currentline++;   
     }

     for($linestoC=1;$linestoC <= $M;$linestoC++){
        $inputPathsToCreate[] = $lines[$currentline];
        $currentline++;   
     }


$PC_Structure = array();
$Create_Structure = array();


foreach ($inputPathsOnPC as $currentPath){
       $dirs = split("/", $currentPath); 
       
       $Num_subdirs = (sizeof($dirs)-1);
       $string = '';
       for($i=1;$i<=$Num_subdirs;$i++)
           if ($dirs[$i] <> '') $string .= '[\''.trim($dirs[$i]).'\']'; 
         
         $EvalTxt = 'if (!is_array($PC_Structure'.$string.')) $PC_Structure'.$string.' = array();';  
        //$EvalTxt = '$PC_Structure'.$string.' = array();';
        eval($EvalTxt);
        
}
 

foreach ($inputPathsToCreate as $currentPath){
        $dirs = split("/", $currentPath); 
       
       $Num_subdirs = (sizeof($dirs)-1);
       $string = '';
       for($i=1;$i<=$Num_subdirs;$i++)
           if ($dirs[$i] <> '') $string .= '[\''.trim($dirs[$i]).'\']'; 
           
        $EvalTxt = 'if (!is_array($Create_Structure'.$string.')) $Create_Structure'.$string.' = array();';
        //echo $EvalTxt;
        eval($EvalTxt);
}
$OutputText .= "Case #".$TestCase.": ".CheckDir($Create_Structure,$PC_Structure,0)."\n";
//echo  "<br /><br /><br /><strong>Case #".$TestCase.": ".CheckDir($Create_Structure,$PC_Structure,0)."</strong><br /><br /><br />";

}

function CheckDir($Create_Structure,$PC_Structure,$sum){
    foreach ($Create_Structure as $key =>$Level) {
        if (!is_array($PC_Structure[$key])){ 
           // echo 'I must create key: '.$key.'<br />'; 
            $sum++;
            $PC_Structure[$key] = array();
        } 
        $sum = CheckDir($Create_Structure[$key],$PC_Structure[$key],$sum);   
    }
    return $sum;
}





//echo $OutputText;

WriteData($OutputText); 
echo 'Ready !!';
echo $OutputText;
?>



