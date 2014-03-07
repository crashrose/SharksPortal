<?php
// No direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted access' );
// import Joomla controlleradmin library
jimport ( 'joomla.application.component.controlleradmin' );

/**
 * Events Controller
 */
class attendanceControllerLocations extends JControllerAdmin {
	protected $text_prefix = 'COM_ATTENDANCE_LOCATIONS';
	/**
	 * Proxy for getModel.
	 * @since 2.5
	 */
	protected $view_list = 'locations';

	public function getModel($name = 'Locations', $prefix = 'attendanceModel') {
		$model = parent::getModel ( $name, $prefix, array (
				'ignore_request' => true
		) );
		return $model;
	}
}