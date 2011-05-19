<?
$this->breadcrumbs=array(
	'Admin'=>array('/admin'),
	'Statistics'=>array('index')
);

$this->menu=array(
	array('label'=>'Statistics', 'url'=>array('index')),
	array('label'=>'Global Statistics', 'url'=>array('global')),
	array('label'=>'Forgot Statistics', 'url'=>array('forgot')),
	array('label'=>'User Statistics', 'url'=>array('user')),
);

 Yii::app()->clientScript->registerCss(
	'CSSTableView',
	'.lastLine{clear:both;width:470px;border-top:1px solid #e3e7e7}#table p{float:left;clear:both;width:100%;margin:0;background:url(images/borders2.gif) 0 0 repeat-y;padding-top:5px;padding-bottom:5px}#table span{float:left;padding:0 10px;border-bottom:1px solid #e3e7e7;padding-bottom:5px}#table p.firstLine span{border-top:none}#table span.col1{width:40% }#table span.col2{width:20%}#table span.col3{width:20%}#table span.col4{width:15%}#table { margin-left: 10%;}');

?>

<div class="fullPage">
	<h3>Clockit Statistics</h3>
	<p class="info">
		To view more statistics for Clockit, choose an option from the list on the right.
	</p>
	
	<div>
		<h3>Karma</h3>
		<div id="table"> 

		<?
		foreach ($gKarma as $item) {
			echo "<p><span class=\"col1\"><a href=\"" . $this->createUrl('user', array('uid'=>$item[2]))  . "\">" . $item[0] . "</a></span>";
			echo "<span class=\"col2\">&nbsp;</span>";
			echo "<span class=\"col3\">" . $item[1] . "%</span></p>";
			}
		?>
		</div>
	</div>
</div>