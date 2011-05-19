<?

class spConnect {

	public function connectToShiftPlanning() {
		// Connect to ShiftPlanning
		Yii::import("application.extensions.shiftplanning.YShiftPlanning");
		$sp = new YShiftPlanning(
			array(
				'key' => Yii::app()->params['SPAPIKey']
				)
			);
		// IE9/FF4 Hack
		// Forcefully re-load the appToken to make sure we are getting the right one (we only need to do this once.
		if (Yii::app()->user->getState('appTokenFirstTime') != 1) {
			Yii::app()->user->setState('appTokenFirstTime', 1);
			$data = Users::model()->findByAttributes(array('uid'=>Yii::app()->user->id));
			Yii::app()->user->setState('appToken',$data['attributes']['appToken']);
			}
		return $sp;	
		}
	}
?>