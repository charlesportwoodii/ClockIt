<div class="data1">
<?
	$connection=Yii::app()->db;

	// Select the number of punches
	$sql="SELECT fName, lName, users.uid FROM users WHERE cStatus = 1 ORDER BY lName ASC";
	$command = $connection->createCommand($sql);
	$data = $command->query();
?>
	<div style='text-align:center;'>
	<?	foreach ($data as $row) {  ?>
				<strong><!--style='float:left; padding-left: 30px;' --><? echo $row['fName'] . " " . $row['lName']; ?></strong>
				<!--<a style='float:right; padding-right: 30px;'>Not here?</a> -->
				<br />
	<?		}						?>
	</div>
</div>