<?php
/**
 * Form component for Joomla
 *
 * @author       Aicha Vack
 * @see           visforms is extended and rivised adaptation of ckforms from cookex (http://www.cookex.eu) for Joomla 2.5
 * @package      Joomla.Site
 * @subpackage   com_visforms
 * @link         http://www.vi-solutions.de 
 * @license      GNU General Public License version 2 or later; see license.txt
 * @copyright    2012 vi-solutions
 * @since        Joomla 1.6 
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// Require the base controller
jimport('joomla.application.component.controller');

// Create the controller
$controller = JController::getInstance('Visforms');

// Perform the Request task
$controller->execute( JRequest::getCmd('task')); // function to execute; if not specified in request it's display();

// Redirect if set by the controller
$controller->redirect();

?>