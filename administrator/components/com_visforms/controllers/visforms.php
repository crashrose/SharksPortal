<?php
/**
 * visforms controller for Visforms
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

jimport( 'joomla.application.component.controlleradmin' );

/**
 * visforms Controller
 *
 * @package      Joomla.Administrator
 * @subpackage   com_visforms
 * @since        Joomla 1.6 
 */
class VisformsControllerVisforms extends JControllerAdmin
{
	/**
	 * constructor (registers additional tasks to methods)
	 *
	 * @return void
	 * @since Joomla 1.6
	 */
	function __construct()
	{
		parent::__construct();

		// Register Extra tasks
		$this->registerTask('unpublish', 'publish');
	}

	/**
	 * display the visforms CSS
	 *
	 * @return void
	 * @since Joomla 1.6
	 */
	function edit_css() 
	{	
		$this->setRedirect("index.php?option=com_visforms&task=vistools.editCSS");
	}
	
	/**
	 * remove record(s)
	 *
	 * @return void
	 * @since Joomla 1.6
	 */
	function remove()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		
		$model = $this->getModel('visform');
		$cids = JRequest::getVar('cid', array(0), 'post', 'array');
		if(!$model->delete($cids)) {
			$msg = JText::_('COM_VISFORMS_DELETE_FORM_ERROR');
		} else {
			$msg = JText::_('COM_VISFORMS_DELETE_FORM_SUCCESS');
		}

		$this->setRedirect('index.php?option=com_visforms', $msg);
	}
	
	/**
	 * publish record
	 *
	 * @return void
	 * @since Joomla 1.6
	 */
	function publish()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		
		$this->setRedirect('index.php?option=com_visforms');
		
		// Initialize variables
		$db			= JFactory::getDBO();
		$user		= JFactory::getUser();
		$cid		= JRequest::getVar('cid', array(), 'post', 'array');
		$task 		= $this->getTask();
		$publish	= ($task == 'publish');
		$n			= count( $cid );

		if (empty( $cid )) {
			return JError::raiseWarning(500, JText::_('COM_VISFORMS_NO_ITEMS_SELECTED'));
		}

		JArrayHelper::toInteger($cid);
		$cids = implode(',', $cid);

		$query = 'UPDATE #__visforms'
		. ' SET published = ' . (int) $publish
		. ' WHERE id IN ( '. $cids.'  )'
		;
		$db->setQuery( $query );
		if (!$db->query()) {
			return JError::raiseWarning(500, $row->getError());
		}
		$this->setMessage(JText::sprintf($publish ? JText::_('COM_VISFORMS_FORM_PUBLISHED') : JText::_('COM_VISFORMS_FORM_UNPUBLISHED'), $n));
	}	
	
	/**
	 * Duplicate selected form with all fields and datatable
	 *
	 * @return void
	 * @since Joomla 1.6
	 */
	function duplicate()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		
		// Initialize variables
		$db			= JFactory::getDBO();
		$user		= JFactory::getUser();
		$cid		= JRequest::getVar('cid', array(), 'post', 'array');
		$n			= count( $cid );
		
		if (empty($cid)) {
			return JError::raiseWarning(500, JText::_('COM_VISFORMS_NO_ITEMS_SELECTED'));
		}

		JArrayHelper::toInteger($cid);
		$cids = implode(',', $cid);

		//get data from selected form(s)
		$query = ' SELECT * from #__visforms c where c.id IN ( '. $cids.'  ) order by id asc';
		$db->setQuery($query);
		$duplicateforms = $db->loadObjectList();
		
		for ($j=0; $j < count($duplicateforms); $j++)		
		{
			$form = $duplicateforms[$j];
			
			//get an index-number for new form name
			$query = ' SELECT * from #__visforms c order by id desc';
			$db->setQuery($query);
			$rows = $db->loadObjectList();
			if (count($rows) > 0)
			{
				$newid = $rows[0]->id + 1;
			} else {
				$newid = '';
			}

			//get the model
			$model = $this->getModel('visform');
			
			//get the table
			$newform = JTable::getInstance('visform', 'Table');
			
			$newform->asset_id = $form->asset_id;
			$newform->name = 'form'.$newid;
			$newform->title = "Kopie" . $form->title;
			$newform->checked_out = 0;
			$newform->checked_out_time = '0000-00-00 00:00:00';
			$newform->description = $form->description;
			$newform->emailfrom = $form->emailfrom;
			$newform->emailto = $form->emailto;
			$newform->emailcc = $form->emailcc;
			$newform->emailbcc = $form->emailbcc;
			$newform->subject = $form->subject;
			$newform->created = $form->created;
			$newform->created_by = $form->created_by;
			$newform->hits = $form->hits;
			$newform->published = false;
			$newform->saveresult = $form->saveresult;
			$newform->emailresult = $form->emailresult;
			$newform->textresult = $form->textresult;
			$newform->redirecturl = $form->redirecturl;
			$newform->spambotcheck = $form->spambotcheck;
			$newform->captcha = $form->captcha;
			$newform->captchacustominfo = $form->captchacustominfo;
			$newform->captchacustomerror = $form->captchacustomerror;
			$newform->uploadpath = $form->uploadpath;
			$newform->maxfilesize = $form->maxfilesize;
			$newform->allowedextensions = "bmp,csv,doc,gif,ico,jpg,jpeg,odg,odp,ods,odt,pdf,png,ppt,swf,txt,xcf,xls,BMP,CSV,DOC,GIF,ICO,JPG,JPEG,ODG,ODP,ODS,ODT,PDF,PNG,PPT,SWF,TXT,XCF,XLS";
			$newform->poweredby = $form->poweredby;
			$newform->emailreceipt = $form->emailreceipt;
			$newform->emailreceipttext = $form->emailreceipttext;
			$newform->emailreceiptsubject = $form->emailreceiptsubject;
			$newform->emailreceiptincfield = $form->emailreceiptincfield;
			$newform->emailreceiptincfile = $form->emailreceiptincfile;
			$newform->emailresultincfile = $form->emailresultincfile;
			$newform->formCSSclass = $form->formCSSclass;			
			$newform->displayip = $form->displayip;	
		   	$newform->displaydetail = $form->displaydetail;	
		   	$newform->fronttitle = $form->fronttitle;			
		   	$newform->frontdescription = $form->frontdescription;	
			$newform->autopublish = $form->autopublish;
			$newform->language = $form->language;

			//	store data in new form
			if (!$newform->store()) 
			{
				//ToDo set an error
				$this->setRedirect( 'index.php?option=com_visforms', $newform->getError() );
			} else 
			{
				//get Id of saved form
				$fid = $newform->get('id');
			}

			//get field data from selected form
			$query = ' SELECT * from #__visfields where fid='.$form->id.' order by id asc';
			$db->setQuery($query);
			$duplicaterows = $db->loadObjectList();
	
			//save field data with new form
			for ($i=0; $i < count($duplicaterows); $i++)
			{
				$row = $duplicaterows[$i];
				
				//get an Index-numver for new field name
				$query = ' SELECT * from #__visfields c order by id desc';
				$db->setQuery($query);
				$rows = $db->loadObjectList();
				if (count($rows) > 0)
				{
					$newid = $rows[0]->id + 1;
				} else {
					$newid = '';
				}
				
				//get the table
				$newrow = JTable::getInstance('visfield', 'Table');
		
				$newrow->fid = $fid;
				$newrow->name = 'field'.$newid;
				$newrow->label = $row->label;
				$newrow->checked_out = 0;
				$newrow->checked_out_time = '0000-00-00 00:00:00';
				$newrow->typefield = $row->typefield;
				$newrow->defaultvalue = $row->defaultvalue;
				$newrow->mandatory = $row->mandatory;
				$newrow->published = $row->published;
				$newrow->ordering = $i;
				$newrow->custominfo = $row->custominfo;
				$newrow->customerror = $row->customerror;
				$newrow->customvalidation = $row->customvalidation;
				$newrow->readonly = $row->readonly;
				$newrow->labelCSSclass = $row->labelCSSclass;
				$newrow->fieldCSSclass = $row->fieldCSSclass;
				$newrow->customtext = $row->customtext;
				$newrow->frontdisplay = $row->frontdisplay;
				$newrow->fillwith = $row->fillwith;
				
				//save the field
				if (!$newrow->store()) 
				{
					//ToDo Throw an error
					$this->setRedirect( 'index.php?option=com_visforms', $newrow->getError() );
				} 
			
			}
			
			//Create a datatable if selected form has parameter saveresult set to 1
			if ((isset($form->saveresult)) && ($form->saveresult == 1))
			{
				if (!$model->createDataTable($fid)) 
				{
					//ToDo Throw an Error
					$this->setRedirect( 'index.php?option=com_visforms', "Problem" );
				}
			}
		}
		
		$msg = JText::_('COM_VISFORMS_FIELD_FORM_DUPLICATED');
		$this->setRedirect('index.php?option=com_visforms', $msg);
	}
	
	/**
	 * Proxy for getModel.
	 *
	 * @param	string	$name	The name of the model.
	 * @param	string	$prefix	The prefix for the PHP class name.
	 *
	 * @return	JModel
	 * @since	1.6
	 */
	public function getModel($name = 'Form', $prefix = 'VisformsModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);

		return $model;
	}
	
}
?>
