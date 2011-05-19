<? if($this->beginCache('TCShiftPlanningMessages', array('duration'=>1800))) {?>
<div class="data4">
<?
	// Load the ShiftPlanning API
	Yii::import("application.extensions.shiftplanning.YShiftPlanning");
	
	// Call the constructor
	$sp = new YShiftPlanning(
			array(
				'key' => Yii::app()->params['SPAPIKey'],
				)
			);
	
	// Authenticate against ShiftPlanning
	$response = $sp->doLogin(
			array(
				'username' => "t55-clockit@acu.edu",				// ShiftPlanning Username
				'password' => Yii::app()->params['SPPassword'],		// ShiftPlanning Password
				)	
			);
	
	// Get the Message Wall
	$data = $sp->getWallMessages();
	
	// Output it
	foreach ($data['data'] as $messages) {
		echo "<b>" . $messages['title'] ."</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . htmlwrap($messages['post'], 40, "<br />\n") . "<br /><br />";
		}
	
	// Logout
	$sp->doLogout();
					?>
</div>
<? $this->endCache(); } ?>	
<?php
function htmlwrap(&$str, $maxLength, $char='<br />'){
    $count = 0;
    $newStr = '';
    $openTag = false;
    $lenstr = strlen($str);
    for($i=0; $i<$lenstr; $i++){
        $newStr .= $str{$i};
        if($str{$i} == '<'){
            $openTag = true;
            continue;
        }
        if(($openTag) && ($str{$i} == '>')){
            $openTag = false;
            continue;
        }
        if(!$openTag){
            if($str{$i} == ' '){
                if ($count == 0) {
                    $newStr = substr($newStr,0, -1);
                    continue;
                } else {
                    $lastspace = $count + 1;
                }
            }
            $count++;
            if($count==$maxLength){
                if ($str{$i+1} != ' ' && $lastspace && ($lastspace < $count)) {
                    $tmp = ($count - $lastspace)* -1;
                    $newStr = substr($newStr,0, $tmp) . $char . substr($newStr,$tmp);
                    $count = $tmp * -1;
                } else {
                    $newStr .= $char;
                    $count = 0;
                }
                $lastspace = 0;
            }
        }  
    }

    return $newStr;
}
?>