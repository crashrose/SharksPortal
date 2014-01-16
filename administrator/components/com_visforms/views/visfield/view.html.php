<?php
/**
 * Visfield view for Visforms
 *
 * @author       Aicha Vack
 * @see           visforms is extended and rivised adaptation of ckforms from cookex (http://www.cookex.eu) for Joomla 2.5
 * @package      Joomla.Administrator
 * @subpackage   com_visforms
 * @link         http://www.vi-solutions.de 
 * @license      GNU General Public License version 2 or later; see license.txt
 * @copyright    2012 vi-solutions
 * @since        Joomla 1.6 
 */

// no direct access
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

/**
 * visfield view to show a singl field
 *
 * @package      Joomla.Administrator
 * @subpackage   com_visforms
 * @since        Joomla 1.6 
 */
class VisformsViewVisfield extends JView
{
	/**
	 * Visfield view display method
	 *
	 * @return void
	 **/
	function display($tpl = null)
	{
		//get the field data
		$visfield 	= $this->get('Data');
		$isNew  	= ($visfield->id < 1);
		
		$document = JFactory::getDocument();
		$css = '.icon-48-visform {background:url(../administrator/components/com_visforms/images/logo-banner.png) no-repeat;}';
   		$document->addStyleDeclaration($css);
	
		$text = $isNew ? JText::_( 'COM_VISFORMS_NEW' ) : JText::_( 'COM_VISFORMS_EDIT' );
		JToolBarHelper::title(JText::_( 'COM_VISFORMS_VISFORM_FIELDS' ).': <small><small>[ ' . $text.' ]</small></small>' , 'visform' );
		
		JToolBarHelper::save('visfield.save');
		JToolBarHelper::apply('visfield.apply');
		if ($isNew)  {
			JToolBarHelper::cancel('visfield.cancel');
		} else {
			// for existing items the button is renamed `close`
			JToolBarHelper::cancel( 'visfield.cancel', 'COM_VISFORMS_CLOSE' );
		}

		JRequest::setVar( 'hidemainmenu', 1 );
		JHtml::_('behavior.framework');
		

		$document->addScript(JURI::root(true).'/administrator/components/com_visforms/js/mootabs.js');
		$document->addScript(JURI::root(true).'/administrator/components/com_visforms/js/visforms.js');

		$document->addStyleSheet(JURI::root(true).'/administrator/components/com_visforms/css/mootabs.css');
		$document->addStyleSheet(JURI::root(true).'/administrator/components/com_visforms/css/visforms.css');		
		
		$this->assignRef('visfield',$visfield);
		
		$typelist[0]         = JHTML::_('select.option',  '0', '- '.JText::_( 'COM_VISFORMS_SELECT_TYPE' ).' -', 'id', 'cattitle' );
		$typelist[1]         = JHTML::_('select.option',  'text', JText::_( 'COM_VISFORMS_TEXT' ), 'id', 'cattitle' );
		$typelist[2]         = JHTML::_('select.option',  'hidden', JText::_( 'COM_VISFORMS_HIDDEN' ), 'id', 'cattitle' );
		$typelist[3]         = JHTML::_('select.option',  'textarea', JText::_( 'COM_VISFORMS_TEXTAREA' ), 'id', 'cattitle' );
		$typelist[4]         = JHTML::_('select.option',  'checkbox', JText::_( 'COM_VISFORMS_CHECKBOX' ), 'id', 'cattitle' );
		$typelist[5]         = JHTML::_('select.option',  'radiobutton', JText::_( 'COM_VISFORMS_RADIO_BUTTON' ), 'id', 'cattitle' );
		$typelist[6]         = JHTML::_('select.option',  'select', JText::_( 'COM_VISFORMS_SELECT' ), 'id', 'cattitle' );
		$typelist[7]         = JHTML::_('select.option',  'fileupload', JText::_( 'COM_VISFORMS_FILE_UPLOAD' ), 'id', 'cattitle' );
		$typelist[8]         = JHTML::_('select.option',  'button', JText::_( 'COM_VISFORMS_BUTTON' ), 'id', 'cattitle' );
		$typelist[9]         = JHTML::_('select.option',  'fieldsep', JText::_( 'COM_VISFORMS_FIELD_SEPERATOR' ), 'id', 'cattitle' );
		$lists['type']      = JHTML::_('select.genericlist', $typelist, 'typefield', 'onchange="typeFieldChange()" class="inputbox" size="1"','id', 'cattitle', $visfield->typefield );

      	//-- push data to template
      	$this->assignRef( 'listtypes',   $lists['type']);

		$dateformat = array();
		
		//value contains dateformat for php and for javascript (Calendarcontrol)
		
		$dateformat[0]       = JHTML::_('select.option',  'd.m.Y;%d.%m.%Y', 'DD.MM.YYYY');
		$dateformat[1]         = JHTML::_('select.option',  'm/d/Y;%m/%d/%Y','MM/DD/YYYY');
		$dateformat[2]         = JHTML::_('select.option',  'Y-m-d;%Y-%m-%d','YYYY-MM-DD');
		
		 //create listbox
		$lists['dateformat']      = JHTML::_('select.genericlist', $dateformat, 'd_format', array('list.attr'=>array('class'=>'inputbox', 'size'=>'1', 'onchange'=>'formatFieldDateChange()'), 'list.select'=>$visfield->d_format));

      	//-- push data to template
      	$this->assignRef( 'dateformat',   $lists['dateformat']);
		
		//Calendar for defaultdate
		// get dateformat for php and for javascript	
		if ($visfield->d_format != "") {$dformat = explode(";", $visfield->d_format);}
		if (isset($dformat[1])) {$dformat = $dformat[1];} else {$dformat = "%y-%m-%d";}
		
		$lists['calendar'] = JHTML::calendar($visfield->d_initvalueD, 'd_initvalueD', 'd_initvalueD',  $dformat);
		
		// Push data to template
		$this->assignRef( 'calendar',   $lists['calendar']);
		
		$fillwithtext[0]       = JHTML::_('select.option',  'inival', JText::_( 'COM_VISFORMS_INITIAL_VALUE' ), 'id', 'cattitle' );
		$fillwithtext[1]         = JHTML::_('select.option',  'usrname',JText::_( 'COM_VISFORMS_CONNECTED_USER_NAME' ), 'id', 'cattitle' );
		$fillwithtext[2]         = JHTML::_('select.option',  'usrusername',JText::_( 'COM_VISFORMS_CONNECTED_USER_USERNAME' ), 'id', 'cattitle' );
		$lists['fillwithtext']      = JHTML::_('select.genericlist', $fillwithtext, 'fillwith', 'class="inputbox" size="1"','id', 'cattitle', $visfield->fillwith );

      	//-- push data to template
      	$this->assignRef( 'fillwithtext',   $lists['fillwithtext']);
		
		$fillwithemail[0]       = JHTML::_('select.option',  'inival', JText::_( 'COM_VISFORMS_INITIAL_VALUE' ), 'id', 'cattitle' );
		$fillwithemail[1]         = JHTML::_('select.option',  'usremail',JText::_( 'COM_VISFORMS_CONNECTED_USER_EMAIL' ), 'id', 'cattitle' );
		$lists['fillwithemail']      = JHTML::_('select.genericlist', $fillwithemail, 'fillwithemail', 'class="inputbox" size="1"','id', 'cattitle', $visfield->fillwith );

      	//-- push data to template
      	$this->assignRef( 'fillwithemail',   $lists['fillwithemail']);

      	//-- push data to template
      	$this->assignRef( 'dateformat',   $lists['dateformat']);
	  	
		$wraplist[0]         = JHTML::_('select.option',  'default', JText::_( 'COM_VISFORMS_DEFAULT' ), 'id', 'cattitle' );
		$wraplist[1]         = JHTML::_('select.option',  'off', JText::_( 'COM_VISFORMS_OFF' ), 'id', 'cattitle' );
		$wraplist[2]         = JHTML::_('select.option',  'virtual', JText::_( 'COM_VISFORMS_VIRTUAL' ), 'id', 'cattitle' );
		$wraplist[3]         = JHTML::_('select.option',  'physical', JText::_( 'COM_VISFORMS_PHYSICAL' ), 'id', 'cattitle' );
        $lists['wrap']      = JHTML::_('select.genericlist', $wraplist, 't_wrap', 'class="inputbox" size="1"','id', 'cattitle', $visfield->t_wrap );
		
		$this->assignRef( 'listwrap',   $lists['wrap']);

		$texttypelist[0]         = JHTML::_('select.option',  'text', JText::_( 'COM_VISFORMS_TEXT' ), 'id', 'cattitle' );
		$texttypelist[1]         = JHTML::_('select.option',  'password', JText::_( 'COM_VISFORMS_PASSWORD' ), 'id', 'cattitle' );
		$texttypelist[2]         = JHTML::_('select.option',  'email', JText::_( 'COM_VISFORMS_EMAIL' ), 'id', 'cattitle' );
		$texttypelist[3]         = JHTML::_('select.option',  'date', JText::_( 'COM_VISFORMS_DATE' ), 'id', 'cattitle' );
		$texttypelist[4]         = JHTML::_('select.option',  'number', JText::_( 'COM_VISFORMS_NUMBER' ), 'id', 'cattitle' );
		$texttypelist[5]         = JHTML::_('select.option',  'url', JText::_( 'COM_VISFORMS_URL' ), 'id', 'cattitle' );
        $lists['texttype']      = JHTML::_('select.genericlist', $texttypelist, 't_texttype', 'onchange="typeFieldTextChange()" class="inputbox" size="1"','id', 'cattitle', $visfield->t_texttype );
		
		$this->assignRef( 'texttype',   $lists['texttype']);
 
		$buttontypelist[0]         = JHTML::_('select.option',  'submit', JText::_( 'COM_VISFORMS_SUBMIT' ), 'id', 'cattitle' );
		$buttontypelist[1]         = JHTML::_('select.option',  'reset', JText::_( 'COM_VISFORMS_RESET' ), 'id', 'cattitle' );
 		$lists['buttontype']      = JHTML::_('select.genericlist', $buttontypelist, 't_typeBT', 'class="inputbox" size="1"','id', 'cattitle', $visfield->t_typeBT );
		
		$this->assignRef( 'listbuttontype',   $lists['buttontype']);
		
		$fid = JRequest::getVar( 'fid', -1 );
		$this->assignRef('fid',$fid);
		
		parent::display($tpl);
	}
}
