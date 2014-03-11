<?php
// No direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted access' );
// import Joomla controlleradmin library
jimport ( 'joomla.application.component.controlleradmin' );

/**
 * Events Controller
 */
class attendanceControllerEvents extends JControllerAdmin {
	protected $text_prefix = 'COM_ATTENDANCE_EVENTS';
	/**
	 * Proxy for getModel.
	 * @since 2.5
	 */
	protected $view_list = 'events';

	public function getModel($name = 'Event', $prefix = 'attendanceModel') {
		$model = parent::getModel ( $name, $prefix, array (
				'ignore_request' => true
		) );
		return $model;
	}
}