<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_visforms
 * @copyright	Copyright (C) vi-solutions, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

//require_once JPATH_SITE.'/components/com_visforms/helpers/route.php';

jimport('joomla.application.component.model');

JModel::addIncludePath(JPATH_SITE.'/components/com_visforms/models', 'VisformsModel');

abstract class modVisformsHelper
{
	/**
	 * Method to retrieve the form data structure from db
	 *
	 * @return object containing the data from the database
	 * @since		1.6
	 */
	public static function getForm(&$params)
	{
		$app	= JFactory::getApplication();
		$db		= JFactory::getDbo();
		$id = $params->get('catid', 0);

		// Get an instance of the generic visforms model
		$model = JModel::getInstance('Visforms', 'VisformsModel', array('ignore_request' => true));

		// Set application parameters in model
		//$appParams = JFactory::getApplication()->getParams();
		//$model->setState('params', $appParams);
		//$id = $params->get('catid', array());
		//echo $id[0];
		
		//	Retrieve Content
		//$items = $model->getItems();
		
		$query = ' SELECT * FROM #__visforms where id='.$id ;
		$db->setQuery( $query );
		$form = $db->loadObject();

		return $form;
	}
	
	/**
	 * Method to retrieve the fields data structure from db
	 *
	 * @return object list containing the data from the database
	 * @since		1.6
	 */
	 
	 public static function getFields( &$params) {
		$db		= JFactory::getDbo();
		$id = $params->get('catid', 0);
		$query = ' SELECT * FROM #__visfields where fid='.$id." and published=1 order by ordering asc" ;
		$db->setQuery($query);
		$fields = $db->loadObjectList();
		
		$n=count($fields );
		for ($i=0; $i < $n; $i++)
		{ 
			$opt = explode("[--]", $fields[$i]->defaultvalue);
			
			switch ($fields[$i]->typefield)
			{
				case 'text':
					if (count($opt) > 0) {
						$key1 = explode("===", $opt[0]);
						$fields[$i]->t_initvalueT = $key1[1];
					} else {
						$fields[$i]->t_initvalueT = '';
					}
					if (count($opt) > 1) {
						$key2 = explode("===", $opt[1]);
						$fields[$i]->t_maxchar = $key2[1];
					} else {
						$fields[$i]->t_maxchar = '';
					}
					if (count($opt) > 2) {
						$key3 = explode("===", $opt[2]);
						$fields[$i]->t_texttype = $key3[1];	
					} else {
						$fields[$i]->t_texttype = '';
					}
					if (count($opt) > 3) {
						$key4 = explode("===", $opt[3]);
						$fields[$i]->t_minchar = $key4[1];		
					} else {
						$fields[$i]->t_minchar = '';
					}
					if (count($opt) > 4) {
						$key5 = explode("===", $opt[4]);
						$fields[$i]->d_format = $key5[1];		
					} else {
						$fields[$i]->d_format = '';
					}
					if (count($opt) > 5) {
						$key6 = explode("===", $opt[5]);
						$fields[$i]->d_daydate = $key6[1];		
					} else {
						$fields[$i]->d_daydate = '';
					}
					
					if (count($opt) > 6) {
						$key7 = explode("===", $opt[6]);
						$fields[$i]->d_initvalueD = $key7[1];		
					} else {
						$fields[$i]->d_dinitvalueD = '';
					}
					
					if (strcmp($fields[$i]->fillwith,'inival') != 0) 
					{
						$user =  JFactory::getUser(); 
						if (strcmp($fields[$i]->t_texttype,'text') == 0 && strcmp($fields[$i]->fillwith,'usrname') == 0) 
						{
							$fields[$i]->t_initvalueT = $user->name;
						} 
						else if (strcmp($fields[$i]->t_texttype,'text') == 0 && strcmp($fields[$i]->fillwith,'usrusername') == 0) 
						{
							$fields[$i]->t_initvalueT = $user->username;
						}
						else if (strcmp($fields[$i]->t_texttype,'email') == 0 && strcmp($fields[$i]->fillwith,'usremail') == 0) 
						{
							$fields[$i]->t_initvalueT = $user->email;
						}
					}
					
				break;
	
				case 'hidden':
					if (count($opt) > 0) {
						$key1 = explode("===", $opt[0]);
						$fields[$i]->t_initvalueH = $key1[1];
					} else {
						$fields[$i]->t_initvalueH = '';
					}
					if (count($opt) > 1) {
						$key2 = explode("===", $opt[1]);
						$fields[$i]->t_filluid = $key2[1];
					} else {
						$fields[$i]->t_filluid = '';
					}
						
					break;
					
				case 'textarea':
					if (count($opt) > 0) {
						$key1 = explode("===", $opt[0]);
						$fields[$i]->t_initvalueTA = $key1[1];
					} else {
						$fields[$i]->t_initvalueTA = '';
					}
					if (count($opt) > 1) {
						$key2 = explode("===", $opt[1]);
						$fields[$i]->t_HTMLEditor = $key2[1];
					} else {
						$fields[$i]->t_HTMLEditor = '';
					}
					if (count($opt) > 2) {
						$key3 = explode("===", $opt[2]);
						$fields[$i]->t_columns = $key3[1];
					} else {
						$fields[$i]->t_columns = '';
					}
					if (count($opt) > 3) {
						$key4 = explode("===", $opt[3]);
						$fields[$i]->t_rows = $key4[1];
					} else {
						$fields[$i]->t_rows = '';
					}
					if (count($opt) > 4) {
						$key5 = explode("===", $opt[4]);
						$fields[$i]->t_wrap = $key5[1];					
					} else {
						$fields[$i]->t_wrap = '';
					}
					if (count($opt) > 5) {
						$key6 = explode("===", $opt[5]);
						$fields[$i]->t_maxchar = $key6[1];
					} else {
						$fields[$i]->t_maxchar = '';
					}
					if (count($opt) > 6) {
						$key7 = explode("===", $opt[6]);
						$fields[$i]->t_minchar = $key7[1];							
					} else {
						$fields[$i]->t_minchar = '';
					}

					break;
	
				case 'checkbox':
					if (count($opt) > 0) {
						$key1 = explode("===", $opt[0]);
						$fields[$i]->t_initvalueCB = $key1[1];
					} else {
						$fields[$i]->t_initvalueCB = '';
					}
					if (count($opt) > 0) {
						$key2 = explode("===", $opt[1]);
						$fields[$i]->t_checkedCB = $key2[1];										
					} else {
						$fields[$i]->t_checkedCB = '';
					}
					break;
					
				case 'radiobutton':
					if (count($opt) > 0) {
						$key1 = explode("===", $opt[0]);
						$fields[$i]->t_listHRB = $key1[1];
					} else {
						$fields[$i]->t_listHRB = '';
					}
					if (count($opt) > 1) {
						$key2 = explode("===", $opt[1]);
						$fields[$i]->t_displayRB = $key2[1];
					} else {
						$fields[$i]->t_displayRB = '';
					}
					break;

				case 'select':
					if (count($opt) > 0) {
						$key1 = explode("===", $opt[0]);
						$fields[$i]->t_multipleS = $key1[1];
					} else {
						$fields[$i]->t_multipleS = '';
					}
					if (count($opt) > 1) {
						$key2 = explode("===", $opt[1]);
						$fields[$i]->t_heightS = $key2[1];
					} else {
						$fields[$i]->t_heightS = '';
					}
					if (count($opt) > 2) {
						$key3 = explode("===", $opt[2]);
						$fields[$i]->t_listHS = $key3[1];					
					} else {
						$fields[$i]->t_listHS = '';
					}
					break;

				case 'button':
					if (count($opt) > 0) {
						$key1 = explode("===", $opt[0]);
						$fields[$i]->t_typeBT = $key1[1];
					} else {
						$fields[$i]->t_typeBT = '';
					}
					break;
	
				case 'fieldsep':
					$fields[$i]->t_noborderFS = '0';
					if (count($opt) > 0) {
						$key1 = explode("===", $opt[0]);
						if (count($key1) > 1)
						{
							$fields[$i]->t_noborderFS = $key1[1];
						}
					}
					break;
			}
		
		}				

		return $fields;
	}
}