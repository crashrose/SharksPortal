<?php

/**
 * @version		$Id: script.php 22354 2011-11-07 05:01:16Z github_bot $
 * @package		com_visforms
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die( 'Restricted access' );


class com_visformsInstallerScript
{
	/**
	 * Constructor
	 *
	 * @param   JAdapterInstance  $adapter  The object responsible for running this script
	 */
   // public function __constructor(JAdapterInstance $adapter);

	/**
	 * Called before any type of action
	 *
	 * @param   string  $route  Which action is happening (install|uninstall|discover_install)
	 * @param   JAdapterInstance  $adapter  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 */
	//public function preflight($route, JAdapterInstance $adapter);

	/**
	 * Called after any type of action
	 *
	 * @param   string  $route  Which action is happening (install|uninstall|discover_install)
	 * @param   JAdapterInstance  $adapter  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 */
   // public function postflight($route, JAdapterInstance $adapter);

	/**
	 * Called on installation
	 *
	 * @param   JAdapterInstance  $adapter  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 */
    public function install(JAdapterInstance $adapter) 
	{
		JFactory::getApplication()->enqueueMessage(JText::_('COM_VISFORMS_INSTALL_MESSAGE'));
	}

	/**
	 * Called on update
	 *
	 * @param   JAdapterInstance  $adapter  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 */
	//public function update(JAdapterInstance $adapter);

	/**
	 * Called on uninstallation
	 *
	 * @param   JAdapterInstance  $adapter  The object responsible for running this script
	 */
	public function uninstall(JAdapterInstance $adapter)
	{

		$db	= JFactory::getDBO();
		$app = JFactory::getApplication();

		if ($db) 
		{
			$db->setQuery("SELECT * FROM #__visforms");
			$forms = $db->loadObjectList();
	
			$n=count($forms);
			for ($i=0; $i < $n; $i++)
			{
				$row = $forms[$i];
				$tn = "#__visforms_".$row->id;
				$db->setQuery("drop table if exists ".$tn);
				$db->query();
				if ($db->getErrorNum())
				{
					echo JText::sprintf('DB function failed with error number %s <br /><span style="_QQ_"color: red;"_QQ_">%s</span>', $db->getErrorNum(), $db->getErrorMsg()).'<br />';
				}
				else
				{
					echo JText::sprintf('Data table of form %s dropped', $row->id) .'<br />'; 
				}
			}

			$db->setQuery("drop table if exists #__visfields");
			$db->query();			
			if ($db->getErrorNum())
			{
				echo JText::sprintf('DB function failed with error number %s <br /><span style="_QQ_"color: red;"_QQ_">%s</span>', $db->getErrorNum(), $db->getErrorMsg()).'<br />';
			}
			else
			{
				echo JText::sprintf('Fields table dropped') .'<br />'; 
			}
			
			$db->setQuery("drop table if exists #__visforms");
			$db->query();			
			if ($db->getErrorNum())
			{
				echo JText::sprintf('DB function failed with error number %s <br /><span style="_QQ_"color: red;"_QQ_">%s</span>', $db->getErrorNum(), $db->getErrorMsg()) .'<br />';
			}
			else
			{
				echo JText::sprintf('Forms table dropped') .'<br />'; 
			}
		}
	}
}

?>
