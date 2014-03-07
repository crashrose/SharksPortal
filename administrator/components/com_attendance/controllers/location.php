<?php
// No direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted access' );
// import Joomla controllerform library
jimport ( 'joomla.application.component.controllerform' );

/**
 * Location Controller
 */
class attendanceControllerLocation extends JControllerForm {
	protected $view_list = 'locations';
}