<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('wid')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->wid), array('view', 'id'=>$data->wid)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('timestamp')); ?>:</b>
	<?php echo CHtml::encode($data->timestamp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ipAddress')); ?>:</b>
	<?php echo CHtml::encode($data->ipAddress); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('data')); ?>:</b>
	<?php echo CHtml::encode($data->data); ?>
	<br />


</div>