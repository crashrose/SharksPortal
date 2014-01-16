<?php 
/**
 *
 * index view
 *
 * @version             1.0.0
 * @package             Joomlike Framework
 * @copyright			Copyright (C) 2012 vonfio.de. All rights reserved.
 *               
 */
  
// No direct access.
defined('_JEXEC') or die;

// getting params
$option 	= JRequest::getCmd('option', '');
$view 		= JRequest::getCmd('view', '');
$app 		= JFactory::getApplication();

// include framework classes and files
require_once('lib/framework.php');
$joomlikelayout = new TemplateLayout;

// Head Includes
require_once("layout/head.php");
 
require_once('layout/default.php');

?>