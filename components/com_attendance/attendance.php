<?php
/**
 * @version     1.0.0
 * @package     com_attendance
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Katherine Rose <katherinelrose@hotmail.com> - http://
 */

//No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
//import joomla controller library
jimport('joomla.application.component.controller');
 
//Get an instance of the controller prefixed by attendance
$controller = JController::getInstance('attendance');
// var_dump ($controller);
 
// Get the task
$controller->execute(JFactory::getApplication()->input->getCmd('task'));

 
// Redirect if set by the controller
$controller->redirect();