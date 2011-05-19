<?php
/**
 * ShowAuditTrail shows the audit trail for the current item
 */

Yii::import('zii.widgets.CPortlet');
require_once(realpath(dirname(__FILE__) . '/../../AuditTrailModule.php'));

class ShowAuditTrail extends CPortlet
{
	/**
	 * @var CActiveRecord the model you want to use with this field
	 */
	public $model;

	/**
	 * @var boolean whether or not to show the widget
	 */
	public $visible = true;

	/**
	 * @var AuditTrailModule static variable to hold the module so we don't have to instantiate it a million times to get config values
	 */
	private static $__auditTrailModule;

	/**
	 * Sets the title of the portlet
	 */
	public function init() {
		$this->title = "Audit Trail For " . get_class($this->model) . " " . $this->model->id;
		parent::init();
	}

	/**
	 * generates content of widget the widget.
	 * This renders the widget, if it is visible.
	 */
	public function renderContent()
	{
		if($this->visible) {
			$auditTrail = AuditTrail::model()->recently();
			$auditTrail->model = get_class($this->model);
			$auditTrail->model_id = $this->model->id;

			$evalUserLabel = $this->getEvalUserLabelCode();
			$this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'audit-trail-grid',
				'dataProvider'=>$auditTrail->search(),
//				'filter'=>'',
				'columns'=>array(
					array(
						'name' => 'old_value',
						'filter' => '',
					),
					array(
						'name' => 'new_value',
						'filter' => '',
					),
					array(
						'name' => 'action',
						'filter'=> '',
					),
					array(
						'name' => 'field',
						'filter' => '',
					),
					array(
						'name' => 'stamp',
						'filter' => '',
					),
					array(
						'name' => 'user_id',
						'value'=>$evalUserLabel,
						'filter'=> '',
					),
					$this->getButtonColumn(),
				),
			));

		}
	}
	
	protected function getEvalUserLabelCode() {
		$userClass = $this->getFromConfigOrObject('userClass');
		$userNameColumn = $this->getFromConfigOrObject('userNameColumn');
		$userEvalLabel = ' ( ($t = '
							. $userClass
							. '::model()->findByPk($data->user_id)) == null ? "": $t->'
							. $userNameColumn
							. ' ) ';
		return $userEvalLabel;
	}
	
	protected function getFromConfigOrObject($value) {
		$at = Yii::app()->modules['auditTrail'];

		//If we can get the value from the config, do that to save overhead
		if( isset( $at[$value]) && !empty($at[$value] ) ) {
			return $at[$value];
		}

		//If we cannot get the config value from the config file, get it from the
		//instantiated object. Only instantiate it once though, its probably 
		//expensive to do. PS I feel this is a dirty trick and I don't like it
		//but I don't know a better way
		if(!is_object(self::$__auditTrailModule)) {
			self::$__auditTrailModule = new AuditTrailModule(microtime(), null);
		}
		
		return self::$__auditTrailModule->$value;
	}
	
	protected function getButtonColumn() {
		return array(
			'class'=>'CButtonColumn',
			'template' => '',
		);
	}
}