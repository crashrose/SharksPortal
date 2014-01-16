<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');

/**
 * Unknown Responses Controller
*/

class attendanceControllerCountResponses extends JControllerAdmin
{
	protected $text_prefix = 'COM_ATTENDANCE_UNK_RESPONSES';
	/**
	 * Proxy for getModel.
	 * @since       2.5
	 */
	protected $view_list = 'CountResponses';
	public function getModel($name = 'CountResponses', $prefix = 'attendanceModel')
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}

	

}