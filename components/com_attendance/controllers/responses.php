<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');

/**
 * Unknown Responses Controller
*/

class attendanceControllerResponses extends JControllerAdmin
{
	protected $text_prefix = 'COM_ATTENDANCE_RESPONSES';
	/**
	 * Proxy for getModel.
	 * @since       2.5
	 */
	protected $view_list = 'Responses';
	public function getModel($name = 'Responses', $prefix = 'attendanceModel')
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
	

}