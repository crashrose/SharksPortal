<?php
/**
 * visfields controller for Visforms
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
 * Visdfields controller class for Visforms
 *
 * @package      Joomla.Administrator
 * @subpackage   com_visforms
 *
 * @since        Joomla 1.6 
 */
class VisformsControllerVisfields extends JControllerAdmin
{
	/**
	 * Class constructor. Register extra tasks
	 *
	 * @param   array  $config  A named array of configuration variables.
	 *
	 * @since	1.6
	 */
	function __construct($config = array())
	{
		parent::__construct($config);

		$this->registerTask('unpublish', 'publish' );
		$this->registerTask('orderup', 'reorder' );
		$this->registerTask('orderdown', 'reorder' );
	}

	/**
	 * remove record(s)
	 *
	 * @return void
	 *
	 * @since Joomla 1.6 
	 */
	function remove()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		
		$model = $this->getModel('visfield');
		$fid = JRequest::getVar( 'fid', -1 );
		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );
		
		if(!$model->delete($cids)) {
			$msg = JText::_( 'COM_VISFORMS_DELETE_ERROR' );
		} else {
			$msg = JText::_( 'COM_VISFORMS_DELETE_FIELD_SUCCESS' );
		}

		$this->setRedirect('index.php?option=com_visforms&view=visfields&fid='.$fid, $msg );
	}
	
	
	/**
	 * publish record(s)
	 *
	 * @return void
	 *
	 * @since Joomla 1.6 
	 */
	function publish()
	{
		
		// Check for request forgeries
		JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		
		// Initialize variables
		$db			= JFactory::getDBO();
		$user		= JFactory::getUser();
		$cid		= JRequest::getVar('cid', array(), 'post', 'array');
		$task 		= $this->getTask();
		$publish	= ($task == 'publish');
		$n			= count($cid);
		$fid		= JRequest::getVar( 'fid', -1 );

		if (empty($cid)) {
			return JError::raiseWarning(500, JText::_('COM_VISFORMS_NO_ITEMS_SELECTED'));
		}

		JArrayHelper::toInteger($cid);
		$cids = implode( ',', $cid );

		$query = 'UPDATE #__visfields'
		. ' SET published = ' . (int) $publish
		. ' WHERE id IN ( '. $cids.'  )'
		;
		$db->setQuery($query);
		if (!$db->query()) {
			return JError::raiseWarning( 500, $row->getError());
		}
		$this->setMessage(JText::sprintf($publish ? JText::_('COM_VISFORMS_FIELDS_PUBLISHED') : JText::_('COM_VISFORMS_FIELDS_UNPUBLISHED'), $n));
		
		$link = 'index.php?option=com_visforms&view=visfields&fid='. $fid ;
		
		$this->setRedirect($link);
	}	

	
	/**
	 * Changes the order of one or more records.
	 *
	 * @return  boolean  True on success
	 *
	 * @since   11.1
	 */
	public function reorder()
	{
		// Check for request forgeries.
		JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Initialise variables.
		$ids = JRequest::getVar('cid', null, 'post', 'array');
		$inc = ($this->getTask() == 'orderup') ? -1 : +1;
		$fid = JRequest::getVar( 'fid', -1 );

		$model = $this->getModel('visfield');
		$return = $model->reorder($ids, $inc);
		if ($return === false)
		{
			// Reorder failed.
			$message = JText::sprintf('JLIB_APPLICATION_ERROR_REORDER_FAILED', $model->getError());
			$this->setRedirect(JRoute::_('index.php?option=com_visforms&view=visfields&fid='. $fid, false), $message, 'error');
			return false;
		}
		else
		{
			// Reorder succeeded.
			$message = JText::_('JLIB_APPLICATION_SUCCESS_ITEM_REORDERED');
			$this->setRedirect(JRoute::_('index.php?option=com_visforms&view=visfields&fid='. $fid, false), $message);
			return true;
		}
	}

	/**
	 * Method to save the order
	 *
	 * @return void
	 * @since Joomla 1.6
	 */
	function saveorder()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		
		$fid = JRequest::getVar('fid', -1);

		$cid = JRequest::getVar('cid', array(), 'post', 'array');
		$order = JRequest::getVar('order', array(), 'post', 'array');
		JArrayHelper::toInteger($cid);
		JArrayHelper::toInteger($order);

		$model = $this->getModel('visfield');
		$model->saveorder($cid, $order);

		$msg = JText::_('COM_VISFORMS_NEW_ORDERING_SAVED');
		$this->setRedirect('index.php?option=com_visforms&view=visfields&fid='. $fid, $msg );
	}
	
	/**
	 * Duplicate selected Fields
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
		$n			= count($cid);
		$fid		= JRequest::getVar('fid', -1);
		
		if (empty( $cid )) {
			return JError::raiseWarning(500, JText::_('COM_VISFORMS_NO_ITEMS_SELECTED'));
		}

		JArrayHelper::toInteger( $cid );
		$cids = implode( ',', $cid );

		$query = ' SELECT * from #__visfields c where c.id IN ( '. $cids.'  )';
		$db->setQuery($query);
		$duplicaterows = $db->loadObjectList();

		for ($i=0; $i < count($duplicaterows); $i++)
		{
			$row = $duplicaterows[$i];
			
			//get highest ordering value
			//Still needed?
			$query = ' SELECT * from #__visfields c where c.fid='.$fid.' order by ordering desc';
			$db->setQuery($query);
			$rows = $db->loadObjectList();
			if (count($rows) > 0)
			{
				$order = $rows[0]->ordering + 1;
			} else {
				$order = 0;
			}
			
			//get an index number to add to new fieldname
			$query = ' SELECT * from #__visfields c where c.fid='.$fid.' order by id desc';
			$db->setQuery($query);
			$rows = $db->loadObjectList();
			if (count($rows) > 0)
			{
				$newid = $rows[0]->id + 1;
			} else {
				$newid = '';
			}
			
			$model = $this->getModel('visfield');
			$newrow = JTable::getInstance('visfield', 'Table');
	
			$newrow->fid = $fid;
			$newrow->name = 'field'.$newid;
			$newrow->label = "Kopie " . $row->label;
			$newrow->checked_out = 0;
			$newrow->checked_out_time = '0000-00-00 00:00:00';
			$newrow->typefield = $row->typefield;
			$newrow->defaultvalue = $row->defaultvalue;
			$newrow->mandatory = $row->mandatory;
			$newrow->published = false;
			$newrow->ordering = $order;
			$newrow->custominfo = $row->custominfo;
			$newrow->customerror = $row->customerror;
			$newrow->customvalidation = $row->customvalidation;
			$newrow->readonly = $row->readonly;
			$newrow->labelCSSclass = $row->labelCSSclass;
			$newrow->fieldCSSclass = $row->fieldCSSclass;
			$newrow->customtext = $row->customtext;
			$newrow->frontdisplay = $row->frontdisplay;
			$newrow->fillwith = $row->fillwith;
			
			$newrow->store();
			
			$id = $newrow->get('id');
		
			// adjust datatable
			$tn = "#__visforms_".$fid;
			$dba	= JFactory::getDBO(); 
			$tnfull = $dba->getPrefix(). 'visforms_'.$fid;
			$tablesAllowed = $dba->getTableList(); 	
			
			// if table exist, then we must insert duplicated field
			if (in_array($tnfull, $tablesAllowed)) {
				$model->createDataTableField($fid, $id);
			}
		}

		$msg = JText::_( 'COM_VISFORMS_FIELDS_DUPLICATED' );
		$this->setRedirect('index.php?option=com_visforms&view=visfields&fid='. $fid, $msg );
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
	public function getModel($name = 'Field', $prefix = 'VisformsModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);

		return $model;
	}
	
}
?>
