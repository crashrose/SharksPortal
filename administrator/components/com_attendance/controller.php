<?php
// No direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted access' );
// import Joomla controller library
jimport ( 'joomla.application.component.controller' );

/**
 * General Controller of attendance component
 */
class attendanceController extends JController {

	/**
	 * display task
	 * @return void
	 */
	function display($cachable = false, $urlparams = false) {
		require_once JPATH_COMPONENT . '/helpers/attendance.php';
		// Load the submenu.
		attendanceHelper::addSubmenu ( JRequest::getCmd ( 'view', 'events' ) );
		$input = JFactory::getApplication ()->input;
		$input->set ( 'view', $input->getCmd ( 'view', 'Events' ) );
		// call parent behavior
		parent::display ( $cachable );
	}
}