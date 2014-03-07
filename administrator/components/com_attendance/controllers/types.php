<?php
// No direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted access' );
// import Joomla controlleradmin library
jimport ( 'joomla.application.component.controlleradmin' );

/**
 * Events Controller
 */
class attendanceControllerTypes extends JControllerAdmin {
	protected $text_prefix = 'COM_ATTENDANCE_EVENT_TYPES';
	/**
	 * Proxy for getModel.
	 * @since 2.5
	 */
	protected $view_list = 'types';

	public function getModel($name = 'Types', $prefix = 'attendanceModel') {
		$model = parent::getModel ( $name, $prefix, array (
				'ignore_request' => true
		) );
		return $model;
	}
}