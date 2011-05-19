<? if($this->beginCache('TCTwitterFeed', array('duration'=>1800))) { ?>
<div class="data2">
<? 
		Yii::import('application.extensions.twitter.YTwitterParser');
		$twitter = new YTwitterParser();
		$tweets = $twitter->fetch_tweets("acuteam55", 4);
?>
<?			foreach($tweets as $tweet) {
				echo "<b>" . $tweet['date'] ."</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . htmlwrap($tweet['desc'], 40, "<br />\n") . "<br /><br />";
				}
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