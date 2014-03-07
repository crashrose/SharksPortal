<?php
// No direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted access' );
// import Joomla controller library
jimport ( 'joomla.application.component.controller' );

/**
 * Attendance Component Controller
 */
class attendanceController extends JControllerLegacy {

	function display($cachable = false, $urlparams = false) {
		require_once JPATH_COMPONENT . '/helpers/attendance.php';
		JHtml::addIncludePath ( JPATH_PLATFORM . '/helpers/html' );

		// call parent behavior
		parent::display ( $cachable );
	}
}