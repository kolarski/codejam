<?php

/**
 * @author Pro4Life
 * @copyright 2010
 */
 
 ini_set('memory_limit', '128M');
 set_time_limit(0);
 
 GetParameters();
 function GetParameters(){
      
      global $Tests_Query;
      global $Tests_R;
      global $Tests_k;
      global $Tests_N;
      global $TestsNum;
      global $TestCases;
      
        $handle = @fopen("input.txt", "r");
        $i=0;$TestNum=0;
        if ($handle) {
            while (!feof($handle)) {
                $buffer = fgets($handle, 4096);
               // echo $i.'. '.$buffer.'<br />';
                if ($i == 0) $TestCases = $buffer;
                else {
                if (($i-1) % 2 == 0) {
                    list($R,$k,$N) = split(" ", $buffer, 3); 
                    $Tests_R[] = $R;
                    $Tests_k[] = $k;
                    $Tests_N[] = $N;
                    $TestNum++;
                } else {
                      $Tests_Query[$TestNum] = split(" ", $buffer, $N); 
                }
                }
                $i++;
            }
            fclose($handle);  
            $TestNum = $TestNum-1;
        } 
    }
    
      
Class Roller {
    public $k;                  // Брой хора побиращи се на влакчето
    public $R;                  // Колко пъти влакчето се върти
    public $GroupsAllowed;      // Колко групи ще се връткат 
    public $PeopleAllowed;      // Колко хора ще се връткат 
    public $Query = array();    // Опашка от групи хора
    public $lengthOfQuery;      // Дължина на опашката
    public $Money = 0;          // Колко парички сме събрали (в евро)
    
    public function GetNextPeople(){
        $this->GroupsAllowed = 0;
        $this->PeopleAllowed = 0;
        foreach($this->Query as $Group)
            if ($Group <= $this->k-$this->PeopleAllowed) { $this->PeopleAllowed = $this->PeopleAllowed+$Group; $this->GroupsAllowed++;} else break;
    }
    
    public function CalculateMoney(){
        $this->Money = $this->Money + $this->PeopleAllowed;
    }
    public function AddToBack(){
        $TempQuery = array();
        for($i=$this->GroupsAllowed;$i<=$this->lengthOfQuery-1;$i++)
            $TempQuery[] = $this->Query[$i];
        for($i=0;$i<=$this->GroupsAllowed-1;$i++)
            $TempQuery[] = $this->Query[$i];
        
        $this->Query = $TempQuery;
    }
}

    for($j=1;$j<=$TestCases;$j++){
        
        $R = $Tests_R[$j-1];
        $MyRoller = new Roller();
        $MyRoller->Query = $Tests_Query[$j];
        $MyRoller->k = $Tests_k[$j-1];
        $MyRoller->lengthOfQuery = $Tests_N[$j-1];;

        for($i=1; $i<=$R;$i++){
            $MyRoller->GetNextPeople();
            $MyRoller->CalculateMoney();
            $MyRoller->AddToBack();   
        }
        $OutputString .= "Case #".$j.": ".$MyRoller->Money."\n";
    }
    //echo $OutputString;
    //exit;
    $myFile = "output.txt";
    $fh = fopen($myFile, 'w') or die("can't open file");
    fwrite($fh, $OutputString);
    fclose($fh);
?>