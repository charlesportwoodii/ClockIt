<?php

/**
 * Messages Model
 * Handles API Messaging to and from shiftPlanning
 */
class Messages extends CFormModel
{
	public $id;
	public $sticky;
	public $title;
	public $post;

	public function rules()
		{
			return array(
				array('title, post', 'required'),
				//array('sticky', 'numerical'),
			);
		}
}

?>