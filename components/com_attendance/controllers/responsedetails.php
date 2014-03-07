<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla controlleradmin library
jimport('joomla.application.component.controllerform');


/**
 * Events Controller
 */

class attendanceControllerResponseDetails extends JControllerLegacy {

	//	protected $text_prefix = 'COM_ATTENDANCE_RESPONSE';
	/**
	 * Proxy for getModel.
	 * @since       2.5
	 */


	public function getModel($name = 'ResponseDetails', $prefix = 'attendanceModel') {
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		var_dump($model);
		return $model;
	}

public function apply(){
//$jinput = JFactory::getApplication ()->input;
//		$rsvp_date = $jinput->get ( 'rsvp_date_reviewed', '', 'string' );
//		var_dump($rsvp_date)
parent::apply();
}


}
