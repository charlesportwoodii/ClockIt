<?php $this->beginContent('//layouts/main'); ?>
	
	<div class="wrap">
			<?php echo $content; ?>
		<div class="last">
		<?php
			$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>'<h3>Operations</h3>',
				'contentCssClass' => 'sidebar',
				'id'=> 'sidebar',
			));
			$this->widget('zii.widgets.CMenu', array(
				'items'=>$this->menu,			
			));
			$this->endWidget();
		?>
		</div><!-- sidebar -->
	</div>
<?php $this->endContent(); ?>