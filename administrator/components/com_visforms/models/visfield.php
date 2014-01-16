<?php
/**
 * visfield model for Visforms
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

jimport('joomla.application.component.modeladmin');

/**
 * Visfield model class for Visforms
 *
 * @package      Joomla.Administrator
 * @subpackage   com_visforms
 *
 * @since        Joomla 1.6 
 */
class VisformsModelVisfield extends JModelAdmin
{
	/**
	 * Constructor that retrieves the ID from the request
	 *
	 * @return	void
	 * @since        Joomla 1.6
	 */
	function __construct()
	{
		parent::__construct();

		$array = JRequest::getVar('cid',  0, '', 'array');
		$fid = JRequest::getVar('fid',  0, '', 'int');
		
		$this->setId((int)$array[0]);
	}

	/**
	 * Method to set the field identifier
	 *
	 * @access	public
	 * @param	int field identifier
	 * @return	void
	 * @since        Joomla 1.6
	 */
	function setId($id)
	{
		// Set id and wipe data
		$this->_id		= $id;
		$this->_data	= null;
	}

	/**
	 * Method to get the field identifier
	 *
	 * @return	$id
	 * @since        Joomla 1.6
	 */
	function getId()
	{
		return $this->_id;
	}
		
	/**
	 * Method to get a hello
	 * @return object with data
	 * @since        Joomla 1.6
	 */
	function &getData()
	{
		// Load the data
		if (empty( $this->_data )) {
			$query = ' SELECT * FROM #__visfields '.
					'  WHERE id = '.$this->_id;
			$this->_db->setQuery( $query );
			$this->_data = $this->_db->loadObject();
		}

		if (!$this->_data) {
			$this->_data = new stdClass();
			$this->_data->id = 0;
			$this->_data->fid = 0;
			$this->_data->name = null;
			$this->_data->label = null;
			$this->_data->checked_out = 0;
			$this->_data->checked_out_time = '0000-00-00 00:00:00';
			$this->_data->published = 1;
			$this->_data->typefield = null;
			$this->_data->ordering = null;
			$this->_data->mandatory = null;
			$this->_data->custominfo = null;
			$this->_data->customerror = null;
			$this->_data->customvalidation = null;
			$this->_data->readonly = null;
			$this->_data->labelCSSclass = null;
			$this->_data->fieldCSSclass = null;
			$this->_data->customtext = null;
			$this->_data->frontdisplay = 1;
			$this->_data->fillwith = null;

			$this->_data->t_wrap = '';
			$this->_data->t_typeBT = '';	
			$this->_data->t_texttype = '';	
			$this->_data->t_displayRB = '';
			$this->_data->t_filluid = '';
			$this->_data->t_noborderFS = '';
			$this->_data->d_format  = '';
			$this->_data->d_daydate  = '';

			$this->_data->t_listHS  = '';
			$this->_data->t_listHRB  = '';
			
			$this->_data->d_initvalueD = '';
			
		} else {
			$opt = explode("[--]", $this->_data->defaultvalue);

			$this->_data->t_wrap = '';
			$this->_data->t_typeBT = '';	
			$this->_data->t_texttype = '';	
			$this->_data->t_displayRB = '';
			$this->_data->t_filluid = '';
			$this->_data->t_noborderFS = '';
			$this->_data->d_format  = '';
			$this->_data->d_daydate  = '';
			$this->_data->d_initvalueD = '';
			$this->_data->t_listHS  = '';
			$this->_data->t_listHRB  = '';

			if (isset($this->_data->frontdisplay) == false)
			{
				$this->_data->frontdisplay = 1;
			}
			if (isset($this->_data->fillwith) == false)
			{
				$this->_data->fillwith = null;
			}

			$this->_data->fillwithemail = $this->_data->fillwith;
			
			switch ($this->_data->typefield)
			{
				case 'text':					
					$key1 = explode("===", $opt[0]);
					$key2 = explode("===", $opt[1]);
					$key3 = explode("===", $opt[2]);
					$key4 = explode("===", $opt[3]);
					$this->_data->t_initvalueT = $key1[1];
					$this->_data->t_maxchar = $key2[1];
					$this->_data->t_texttype = $key3[1];
					$this->_data->t_minchar = $key4[1];
					if (count($opt) > 4)
					{
						$key5 = explode("===", $opt[4]);
						$this->_data->d_format = $key5[1];
					}
					if (count($opt) > 5)
					{
						$key6 = explode("===", $opt[5]);
						$this->_data->d_daydate = $key6[1];
					}
					if (count($opt) > 6)
					{
						$key7 = explode("===", $opt[6]);
						$this->_data->d_initvalueD = $key7[1];
					}
					break;
	
				case 'hidden':
					$key1 = explode("===", $opt[0]);
					$this->_data->t_initvalueH = $key1[1];
					if (count($opt) > 1)
					{
						$key2 = explode("===", $opt[1]);
						$this->_data->t_filluid = $key2[1];
					}
					break;
					
				case 'textarea':
					$key1 = explode("===", $opt[0]);
					$key2 = explode("===", $opt[1]);
					$key3 = explode("===", $opt[2]);
					$key4 = explode("===", $opt[3]);
					$key5 = explode("===", $opt[4]);
					$key6 = explode("===", $opt[5]);
					$key7 = explode("===", $opt[6]);
					$this->_data->t_initvalueTA = $key1[1];
					$this->_data->t_HTMLEditor = $key2[1];
					$this->_data->t_columns = $key3[1];
					$this->_data->t_rows = $key4[1];
					$this->_data->t_wrap = $key5[1];
					$this->_data->t_maxchar = $key6[1];		
					$this->_data->t_minchar = $key7[1];				
					break;
	
				case 'checkbox':
					$key1 = explode("===", $opt[0]);
					$this->_data->t_initvalueCB = $key1[1];
					$key2 = explode("===", $opt[1]);
					$this->_data->t_checkedCB = $key2[1];
					break;
					
				case 'radiobutton':
					$key1 = explode("===", $opt[0]);
					$this->_data->t_listHRB = $key1[1];
					if (count($opt) > 1)
					{
						$key2 = explode("===", $opt[1]);
						$this->_data->t_displayRB = $key2[1];
					}
					break;

				case 'select':
					$key1 = explode("===", $opt[0]);
					$key2 = explode("===", $opt[1]);
					$key3 = explode("===", $opt[2]);
					$this->_data->t_multipleS = $key1[1];
					$this->_data->t_heightS = $key2[1];
					$this->_data->t_listHS = $key3[1];					
					break;

				case 'button':
					$key1 = explode("===", $opt[0]);
					$this->_data->t_typeBT = $key1[1];
					break;
	
				case 'fieldsep':
					$key1 = explode("===", $opt[0]);
					$this->_data->t_noborderFS = $key1[1];
					break;
			}			
		}
		
		return $this->_data;
	}

	/**
	 * Method to store a record
	 *
	 * @access	public
	 * @return	boolean	True on success
	 */
	function store()
	{
		$data = JRequest::get('POST', JREQUEST_ALLOWHTML);
		$fid = JRequest::getVar('fid');
		
		$query = ' SELECT max( ordering ) as maxx FROM #__visfields WHERE fid = '.$data['fid'];
		$this->_db->setQuery( $query );
		$max = $this->_db->loadObject();
			
		$row = $this->getTable();
		
		$user = JFactory::getUser(); 
								
		// Get Specific values
		
		$defaultvalue = '';
		switch ($data['typefield'])
		{
			case 'text':
				$t_initvalueT = $data['t_initvalueT'];
				$t_maxchar = $data['t_maxchar'];
				$t_minchar = $data['t_minchar'];
				$t_texttype = $data['t_texttype'];
				if ($data['t_texttype'] === 'date') 
				{
					$d_format = $data['d_format'];
					$d_daydate = $data['d_daydate'];
				}
				else
				{
					$d_format = '';
					$d_daydate = '';
				}
				if ($data['t_texttype'] === 'email')
				{
					$data['fillwith'] = $data['fillwithemail'];
				}
				$d_initvalueD = $data['d_initvalueD'];
				
				$defaultvalue = 't_initvalueT==='.$t_initvalueT.'[--]t_maxchar==='.$t_maxchar.'[--]t_texttype==='.$t_texttype.'[--]t_minchar==='.$t_minchar.'[--]d_format==='.$d_format.'[--]d_daydate==='.$d_daydate.'[--]d_initvalueD==='.$d_initvalueD;
				break;

			case 'hidden':
				$t_initvalueH = $data['t_initvalueH'];
				if (isset($data['t_filluid']))
				{
					$t_filluid = $data['t_filluid'];
				} else {
					$t_filluid = 0;
				}
				$defaultvalue = 't_initvalueH==='.$t_initvalueH.'[--]t_filluid==='.$t_filluid;
				break;
				
			case 'textarea':
				$t_initvalueTA = $data['t_initvalueTA'];
				$t_HTMLEditor = $data['t_HTMLEditor'];
				$t_columns = $data['t_columns'];
				$t_rows = $data['t_rows'];
				$t_wrap = $data['t_wrap'];
				$t_maxchar = $data['t_maxchar'];
				$t_minchar = $data['t_minchar'];
				$defaultvalue = 't_initvalueTA==='.$t_initvalueTA.'[--]t_HTMLEditor==='.$t_HTMLEditor.'[--]t_columns==='.$t_columns.'[--]t_rows==='.$t_rows.'[--]t_wrap==='.$t_wrap.'[--]t_maxchar==='.$t_maxchar.'[--]t_minchar==='.$t_minchar;
				break;
			
			case 'checkbox':
				$t_initvalueT = $data['t_initvalueCB'];
				$t_checkedCB = $data['t_checkedCB'];
				$defaultvalue = 't_initvalueCB==='.$t_initvalueT.'[--]t_checkedCB==='.$t_checkedCB;
				break;

			case 'radiobutton':
				$t_listHRB = $data['t_listHRB'];
				$t_displayRB = $data['t_displayRB'];
				$defaultvalue = 't_listHRB==='.$t_listHRB.'[--]t_displayRB==='.$t_displayRB;
				break;

			case 'select':
				$t_multipleS = $data['t_multipleS'];
				$t_heightS = $data['t_heightS'];
				$t_listHS = $data['t_listHS'];

				$defaultvalue = 't_multipleS==='.$t_multipleS.'[--]t_heightS==='.$t_heightS.'[--]t_listHS==='.$t_listHS;
				break;
				
			case 'button':
				$t_typeBT = $data['t_typeBT'];
				$defaultvalue = 't_typeBT==='.$t_typeBT;
				break;
				
			case 'fieldsep':
				$t_noborderFS = $data['t_noborderFS'];
				$defaultvalue = 't_noborderFS==='.$t_noborderFS;
				break;
		}
		
		$row->defaultvalue = $defaultvalue;
		// End Get Specific values
		
		// Bind the form fields to the table
		if (!$row->bind($data)) 
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Set complementary data
		if ($row->ordering == "")
		{			
			if (isset($max)) 
			{
				$row->ordering = $max->maxx + 1;
			} else {
				$row->ordering = 1;
			}
		}

		
		// Make sure the record is valid
		if (!$row->check()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		// Store the web link table to the database
		if (!$row->store()) {
			$this->setError( $row->getError() );
			
			return false;
		}
		else {
			$row->id = $row->get('id');
		}
		
		$this->_id = $row->id;

		// Test if data must be saved in DB for this form
		$query = ' SELECT * from #__visforms c where c.id='.$fid.' ';
		$forms = $this->_getList( $query );
		if (count($forms ) > 0)
		{
			$rowTable = $forms[0];
			if ($rowTable->saveresult == 1) {
				$this->createDataTableField($fid, $row->id);
			}
		}
		
		return true;
	}
	
	/**Method to create a field in datatable
	 *
	 * @params string $fid form id
	 * @return boolean true
	 *
	 * @since Joomla 1.6
	 */
	 // Test if data must be saved in DB for this form
	
	public function createDataTableField($fid = Null, $id = Null) 
	{
		
		$tn = "#__visforms_".$fid;	
	
		$dba	= JFactory::getDBO(); 

		$tableFields = $dba->getTableColumns($tn,false);
		$fieldname = "F" . id;
		
		if (!isset( $tableFields[$fieldname] ))  
		{

			$query = "ALTER TABLE ".$tn." ADD F".$id." TEXT NULL";
			$dba->SetQuery($query);
			if (!$dba->query()) 
			{
				echo JText::_( 'COM_VISFORMS_PROBLEM_WITH' )." (".$query.")";
				return false;
			}
		return true;
		}
	return true;
	}

	/**
	 * Method to delete record(s)
	 *
	 * @access	public
	 * @return	boolean	True on success
	 */
	function delete(&$cids)
	{
		$saveDB = false;
		
		$fid = JRequest::getVar( 'fid', array(0), 'post', 'int' );
		if (isset( $fid )) 
		{
		
			$query = ' SELECT * from #__visforms c where c.id=' . $fid . ' ';
			$forms = $this->_getList( $query );
			if (count($forms ) > 0)
			{
				$rowTable = $forms[0];
				if ($rowTable->saveresult == 1) {
					$saveDB = true;
				}
			}
		
		}		
		
		if ($saveDB == true)
		{
			$tn = "#__visforms_".$fid;		
			$dba	= JFactory::getDBO(); 
			$tableFields = $dba->getTableColumns($tn,false);
		}

		$row = $this->getTable();

		if (count( $cids ))
		{
			foreach($cids as $cid) {
			
				
				if ($saveDB == true)
				{
					$query = ' SELECT * FROM #__visfields '.
							'  WHERE id = '. $cid;
					$this->_db->setQuery( $query );
					$field = $this->_db->loadObject();
				}
			
				if (!$row->delete( $cid )) {
					$this->setError( $row->getErrorMsg() );
					return false;
				} else {
					/* Delete Field From DB */
					if ($saveDB == true)
					{
						
						$fieldname = "F" . $cid;
						if (isset( $tableFields[$fieldname] )) 
						{
							$query = "ALTER TABLE ".$tn." DROP ".$fieldname;
							$dba->SetQuery($query);
							if (!$dba->query())  
							{	
								echo JText::_( 'COM_VISFORMS_PROBLEM_WITH' )." (".$query.")";
							}

						}
					
					}
				}
			}						
		}
		return true;
	}

	/**
	 * Method to get the record form.
	 *
	 * @param	array	$data		Data for the form.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 *
	 * @return	mixed	A JForm object on success, false on failure
	 * @since	1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{	
		// Get the form.
		$form = $this->loadForm('com_visforms.visfield', 'visfield', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}

		return $form;
	}
	
	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return	mixed	The data for the form.
	 * @since	1.6
	 */
	protected function loadFormData()
	{	
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_visforms.visfield_tpl.visfield.data', array());

		if (empty($data)) {
			$data = $this->getItem();
		}

		return $data;
	}
	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	1.6
	 */
	public function getTable($type = 'Visfield', $prefix = 'Table', $config = array())
	{	
		return JTable::getInstance($type, $prefix, $config);
	}
	
	/**
	 * A protected method to get a set of ordering conditions.
	 *
	 * @param	object	A record object.
	 *
	 * @return	array	An array of conditions to add to add to ordering queries.
	 * @since	1.6
	 */
	protected function getReorderConditions($table)
	{
		$condition = array();
		$condition[] = 'fid = '.(int) JRequest::getVar('fid', 0);
		return $condition;
	}
}		
?>
