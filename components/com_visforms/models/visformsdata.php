<?php
/**
 * Visformsdata model for Visforms
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
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.modellist' );

/**
 * Visdata model class for Visforms
 *
 * @package      Joomla.Site
 * @subpackage   com_visforms
 *
 * @since        Joomla 1.6 
 */
class VisformsModelVisformsdata extends JModelList
{
	/*
	* visdata fields array
	*
	* @var array
	*/
	var $_datafields;
	
	/**
	* form id
	* @var int
	*/
	var $_id;
	
	/**
	* Single Form Dataset object
	* @var object
	*/
	var $_detail;
	
	/*
	 * Constructor
	 *
	 */
	function __construct()
	{
		
		$id = JRequest::getCmd('id',  '-1');
		$this->setId($id);

		//get an array of fieldnames that can be used to sort data in datatable
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
				'a.id', 'a.ipaddress', 'a.published',
			);
		}
		
		//get all form field id's from database
		$db	= JFactory::getDBO();
		$tn = "#__visforms_".$id;	
		$query = ' SELECT c.id from #__visfields as c where c.fid='.$id.' AND (c.frontdisplay is null or c.frontdisplay = 1) ';
		$db->setQuery( $query );
		$fields = $db->loadObjectList();
		
		//add field id's to filter_fields
		foreach ($fields as $field) {
			$config['filter_fields'][] = "a.F" . $field->id;
		}
		
		parent::__construct($config);	
	}
	
	/**
	 * Method to set the form identifier
	 *
	 * @param	int form identifier
	 * @return	void
	 * @since        Joomla 1.6
	 */
	function setId($id)
	{
		// Set id and wipe data
		$this->_id = $id;
	}
	
	/**
	 * Method to get the form identifier
	 *
	 * @param	int form identifier
	 * @return	int id
	 * @since        Joomla 1.6
	 */
	function getId()
	{
		return $this->_id;
	}
	
	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @return	void
	 * @since	1.6
	 */
	 
	protected function populateState($ordering = null, $direction = null)
	{
		// Initialise variables.
		$app = JFactory::getApplication();
		$session = JFactory::getSession();

		// List state information.
		parent::populateState('a.id', 'asc');
	}
	
	/**
	 * Method to get a store id based on model configuration state.
	 *
	 * This is necessary because the model is used by the component and
	 * different modules that might need different sets of data or different
	 * ordering requirements.
	 *
	 * @param	string		$id	A prefix for the store id.
	 *
	 * @return	string		A store id.
	 * @since	1.6
	 */
	protected function getStoreId($id = '')
	{
		// Compile the store id.
		return parent::getStoreId($id);
	}
	
	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return	JDatabaseQuery
	 * @since	1.6
	 */
	protected function getListQuery()
	{
		// Create a new query object.
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);
		$user	= JFactory::getUser();

		// Select the required fields from the table.
		$query->select(
			$this->getState(
				'list.select',
				'*'
			)
		);
		$tn = "#__visforms_" . $this->_id;
		$query->from($tn . ' AS a');
		$query->where('(a.published = 1)');

		// Add the list ordering clause.
		$orderCol	= $this->state->get('list.ordering', 'a.id');
		$orderDirn	= $this->state->get('list.direction', 'asc');
		$query->order($db->escape($orderCol.' '.$orderDirn));
		return $query;
	}


	/**
	 * Method to retrieve the field list of a given form
	 * 
	 * @return array Array of objects containing the data from the database
	 * @since        Joomla 1.6
	 */
	function getDatafields()
	{
		// Lets load the data if it doesn't already exist
		if (empty( $this->_datafields ))
		{
			$query = ' SELECT * from #__visfields c where c.fid='.$this->_id." and (c.frontdisplay is null or c.frontdisplay = '1') ";	
			$this->_datafields = $this->_getList($query);					
		}

		return $this->_datafields;
	}
	
	/**
	* Method get the details of one dataset for a given form
	* @return object with data
	* @since        Joomla 1.6
	*/
	function getDetail()
	{
		$array = JRequest::getVar('cid',  0, '', 'array');
		$id=(int)$array[0];
		if (is_numeric($id) == false) 
		{
			return null;
		}
		
		$query = ' SELECT * FROM #__visforms_'.$this->_id.
				'  WHERE id = '.$id;
		$this->_db->setQuery( $query );
		$this->_detail = $this->_db->loadObject();
		
		return $this->_detail;
	}

	
	/**
	* Method to get the form
	* @return object with data
	* @since        Joomla 1.6
	*/
	function getForm()
	{
		$query = ' SELECT * FROM #__visforms '.
				'  WHERE id = '.$this->_id;
		$this->_db->setQuery( $query );
		$this->_detail = $this->_db->loadObject();		
		
		return $this->_detail;
	}


	/**
	* Method to get the Itemid
	* @return object with data
	* @since        Joomla 1.6
	*/
	function getItemid()
	{
		$Itemid = JRequest::getCmd('Itemid',  '-1');
		if (is_numeric($Itemid) == false) {
			return null;
		}
		
		return $Itemid;
	}
	
	/**
	* Method to retrieve menu params
	* @return return array Array of objects containing the params from active menu
	* @since        Joomla 1.6
	*/
	
	function getMenuparams () 
	{
		$app = JFactory::getApplication();
		$menu_params = $app->getParams();
		$this->setState('menu_params', $menu_params);
		
		return $menu_params;
	}
}
