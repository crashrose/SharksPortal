<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');

/**
 * 
*/

class attendanceControllerCountResponses extends JControllerAdmin
{
	//protected $text_prefix = 'COM_ATTENDANCE_UNK_RESPONSES';
	/**
	 * Proxy for getModel.
	 * @since       2.5
	 */
	protected $view_list = 'ResponsesForItem';
	public function getModel($name = 'ResponsesForItem', $prefix = 'attendanceModel')
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}

	

}