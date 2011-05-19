<?
if($this->beginCache('FPTwitterFeed', array('duration'=>1800))) {  
		Yii::import('application.extensions.twitter.YTwitterParser');
		$twitter = new YTwitterParser();
		try {
			$tweets = $twitter->fetch_tweets("acuteam55", 5);
			}
		catch (Exception $e) {
			$tweets = $tweets = $e->getMessage();
			}
?>
			<ul>
<?			foreach($tweets as $tweet) {
				echo "<li style=\"list-style:none; padding-bottom: 5px;\"><b>" . $tweet['date'] ."</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . htmlwrap($tweet['desc'], 40, "<br />\n") . "<br /><br /></li>";
				}
				?>
			</ul>
<?
$this->endCache(); 
}


// Helper Function
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