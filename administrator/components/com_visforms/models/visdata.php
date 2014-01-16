<?php
/**
 * visdata model for Visforms
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

jimport( 'joomla.application.component.modellist' );

/**
 * Visdata model class for Visforms
 *
 * @package      Joomla.Administrator
 * @subpackage   com_visforms
 *
 * @since        Joomla 1.6 
 */
class VisformsModelVisdata extends JModelList
{
	
	/**
	* Visdata fields array
	*
	* @var array
	*/
	protected $_datafields = Array();
	
	/**
	* data of selected form
	*
	* @var array
	* @since Joomla 1.6
	*/
	
	var $_data = Array();
	
	/**
	* Visdata form id
	*
	* @var protected $_id Form Id
	*
	* @since Joomla 1.6
	*/
	protected $_id = null;
	
	/**
	 * Constructor.
	 *
	 * @param	array	An optional associative array of configuration settings.
	 * @see		JController
	 * @since	1.6
	 */
	 
	 
	public function __construct($config = array())
	{	
		$id = JRequest::getInt('fid', -1);
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
		$query = ' SELECT c.id from #__visfields as c where c.fid='.$id.' ';
		$db->setQuery( $query );
		$fields = $db->loadObjectList();
		
		//add field id's to filter_fields
		foreach ($fields as $field) {
			$config['filter_fields'][] = "a.F" . $field->id;
		}
		
		parent::__construct($config);
		
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

		$search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
		$this->setState('filter.search', $search);
		
		$published = $this->getUserStateFromRequest($this->context.'.filter.published', 'filter_published', '');
		$this->setState('filter.published', $published);

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
		$id	.= ':'.$this->getState('filter.search');
		$id	.= ':'.$this->getState('filter.published');

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

		// Filter by published state
		$published = $this->getState('filter.published');
		if (is_numeric($published)) {
			$query->where('a.published = ' . (int) $published);
		}
		elseif ($published === '') {
			$query->where('(a.published = 0 OR a.published = 1)');
		}

		// Filter by search
		$filter = $this->getFilter();		
		if (!($filter === '')) {
			$query->where($filter);
		}

		// Add the list ordering clause.
		$orderCol	= $this->state->get('list.ordering', 'a.id');
		$orderDirn	= $this->state->get('list.direction', 'asc');
		$query->order($db->escape($orderCol.' '.$orderDirn));
		return $query;
	}
	
	/**
	 * Retrieves the forms data
	 * @return array Array of objects containing the data from the database
	 * @since Joomla 1.6
	 */
	function getData()
	{
		
		// Lets load the data if it doesn't already exist
		if (empty( $this->_data ))
		{
			$query = $this->_getListQuery();
		$this->_data = $this->_getList($query, $this->getStart(), $this->getState('list.limit'));
			
		}

		return $this->_data;
	}
	
	/**
	 * Method to set the form identifier
	 *
	 * @param	int form identifier
	 *
	 * @return	void
	 * @since	1.6
	 */
	public function setId($id)
	{
		// Set id and wipe data
		$this->_id = $id;
	}

	/**
	 * Method to set the text for SQL where statement for search filter
	 *
	 * @return string where statement for SQL
	 * @since	1.6
	 */
	public function getFilter()
	{
		// Get Filter parameters
		$visfilter = $this->getState('filter.search');
		$filter = '';	
		if ($visfilter != '')
		{
			$filter = $filter." (";
			$fields = $this->getDatafields();
			$keywords = explode(" ", $visfilter);
			$k=count( $keywords );
			
			for ($j=0; $j < $k; $j++)
			{
				$n=count( $fields );
				for ($i=0; $i < $n; $i++)
				{
					$rowField = $fields[$i];
					if ($rowField->typefield != 'button' && $rowField->typefield != 'fieldsep')
					{
						$prop="F".$rowField->id;
						$filter = $filter." upper(".$prop.") like upper('%".$keywords[$j]."%') or ";
					}
				}
				$filter = $filter." ipaddress like '%".$keywords[$j]."%' or ";
			}
			$filter = rtrim($filter,'or '); 
			$filter = $filter." )";
								 
		}
		
		return $filter;
	}
	
	/**
	 * Method to retrieves the fields list
	 *
	 * @return array Array of objects containing the data from the database
	 * @since	1.6
	 */
	public function getDatafields()
	{
		// Lets load the data if it doesn't already exist
		if (empty( $this->_datafields ))
		{	
			$tn = "#__visforms_".$this->_id;
						
			$query = ' SELECT * from #__visfields as c where c.fid='.$this->_id.' ';	
								
			$this->_datafields = $this->_getList( $query );
			
		}
		return $this->_datafields;
	}
	
	/**
	 * Method to get form data detail
	 *
	 * @return object with data
	 * @since	1.6
	 */
	public function getDetail()
	{
		$array = JRequest::getVar('cid',  0, '', 'array');
		
		$query = ' SELECT * FROM #__visforms_'.$this->_id.
				'  WHERE id = '.(int)$array[0];
		$this->_db->setQuery( $query );
		$this->_detail = $this->_db->loadObject();
		
		return $this->_detail;
	}

	/**
	 * Method to delete record(s)
	 *
	 * @return	boolean	True on success
	 * @since	1.6
	 */
	public function delete()
	{
		
		$dba = JFactory::getDBO(); 

		$fid = JRequest::getVar( 'fid', -1);
		$tn = "visforms_" . $fid;
				
		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );
		foreach($cids as $cid) {
			$query = "delete from #__" . $tn . " where id=" . $cid;
			$dba->SetQuery($query);
			if (!$dba->query()) 
			{
				$this->setError(JText::_('COM_VISFORMS_PROBLEM_WITH') . " (".$query.")");
				return false;
			}		
		}
		
		return true;
		
	}
		
		
}
