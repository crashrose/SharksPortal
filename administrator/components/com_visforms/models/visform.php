<?php
/**
 * visform model for Visforms
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
 * visform Model
 *
 * @package      Joomla.Administrator
 * @subpackage   com_visforms
 * @since        Joomla 1.6 
 */
class VisformsModelVisform extends JModelAdmin
{
	/**
	 * Constructor that retrieves the ID from the request
	 *
	 * @access	public
	 * @return	void
	 */
	function __construct()
	{
		parent::__construct();

		$array = JRequest::getVar('cid',  0, '', 'array');
		$this->setId((int)$array[0]);
	}

	/**
	 * Method to set the form identifier
	 *
	 * @access	public
	 * @param	int form identifier
	 * @return	void
	 * @since 1.6
	 */
	function setId($id)
	{
		// Set id and wipe data
		$this->_id		= $id;
		$this->_data	= null;
	}

	function getId()
	{
		return $this->_id;
	}
	
	/**
	 * Method to get a form
	 * @return object with data
	 * @since 1.6
	 */
	function &getData()
	{
		// Load the data
		if (empty( $this->_data )) {
			$query = ' SELECT * FROM #__visforms '.
					'  WHERE id = '.$this->_id;
			$this->_db->setQuery( $query );
			$this->_data = $this->_db->loadObject();
			
		}
		if (!$this->_data) {
			$this->_data = new stdClass();
			$this->_data->id = 0;
			$this->_data->asset_id = null;
			$this->_data->name = null;
			$this->_data->title = null;
			$this->_data->checked_out = 0;
			$this->_data->checked_out_time = '0000-00-00 00:00:00';
			$this->_data->description = null;
			$this->_data->emailfrom = null;			
			$this->_data->emailto = null;			
			$this->_data->emailcc = null;			
			$this->_data->emailbcc = null;
			$this->_data->subject = null;
			$this->_data->created = null;
			$this->_data->created_by = null;
			$this->_data->hits = null;
			$this->_data->published = 1;
			$this->_data->saveresult = null;
			$this->_data->emailresult = null;
			$this->_data->textresult = null;
			$this->_data->redirecturl = null;			
			$this->_data->spambotcheck = 0;
			$this->_data->captcha = null;
			$this->_data->captchacustominfo = null;
			$this->_data->captchacustomerror = null;
			$this->_data->uploadpath = JPATH_SITE.DS.'tmp'.DS;
			$this->_data->maxfilesize = null;
			$this->_data->allowedextensions = "bmp,csv,doc,gif,ico,jpg,jpeg,odg,odp,ods,odt,pdf,png,ppt,swf,txt,xcf,xls,BMP,CSV,DOC,GIF,ICO,JPG,JPEG,ODG,ODP,ODS,ODT,PDF,PNG,PPT,SWF,TXT,XCF,XLS";
			$this->_data->poweredby = 1;
			$this->_data->emailresultincfile = 1; 
			$this->_data->emailreceipt = 0;
			$this->_data->emailreceiptsubject = null;
			$this->_data->emailreceipttext = null;
			$this->_data->emailreceiptincfield = 1;  
			$this->_data->emailreceiptincfile = 1;
			$this->_data->formCSSclass = null;
			$this->_data->displayip = 0;
			$this->_data->displaydetail = 0;
			$this->_data->fronttitle = null;
			$this->_data->frontdescription = null;
			$this->_data->autopublish = 1;
			$this->_data->language = "*";			
		}
		return $this->_data;
	}

	/**
	 * Method to store a record
	 *
	 * @access	public
	 * @return	boolean	True on success
	 * @since Joomla 1.6
	 */
	function store()
	{
		$row =  $this->getTable();
		
		$user =  JFactory::getUser(); 
				
		$data = JRequest::get('POST', JREQUEST_ALLOWHTML);

		// Bind the form fields to the form table
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Set complementary data
		$row->created_by = $user->id;
		$row->created = date("Y-m-d H:i:s");
		
		// Make sure the record is valid
		if (!$row->check()) 
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		// Store the form table to the database
		if (!$row->store()) {
			$this->setError( $row->getError() );
			
			return false;
		}
		else
		{
			$row->id = $row->get('id');
		}
		
		$this->_id = $row->id;

		if ($row->saveresult == 1) 
		{			
			//Create a new datatable if it doesn't allready exist
			if (!$this->createDataTable($this->_id)) 
			{
				//ToDo throw an error
				return false;
			}
		}
		
		return true;
	}
	
		
	/** Method to create a datatable if it doesn't allready exist
	 *
	 * @param int $fid formid
	 *
	 * @return boolean true
	 * @since 1.6
	 */
	 
	 public function createDataTable ($fid = Null) {
	 
		if (!$fid) 
		{
			//no formid given
			//ToDo throw an error
			return false;
		}
		$tn = "#__visforms_".$fid;		
		$dba	= JFactory::getDBO(); 
		$tnfull = $dba->getPrefix(). 'visforms_'.$fid;
		$tablesAllowed = $dba->getTableList(); 	

	 	// Create the table to save the data 
		if (!in_array($tnfull, $tablesAllowed)) 
		{
			// Create table
			$query = "create table ".$tn.
				" (id int(11) not null AUTO_INCREMENT,".
				"published tinyint,".
				"created datetime,".
				"primary key (id) ".
				") ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8";
			
			$dba->SetQuery($query);
			$dba->query();
		
					
			// Add IP Address Field
			$query = "ALTER TABLE ".$tn." ADD ipaddress TEXT NULL";
			$dba->SetQuery($query);
			if (!$dba->query())  
			{
				echo JText::_( 'COM_VISFORMS_PROBLEM_WITH' )." (".$query.")";
				return false;
			}
			// Add Article ID Field
			$query = "ALTER TABLE ".$tn." ADD articleid TEXT NULL";
			$dba->SetQuery($query);
			if (!$dba->query())  
			{
				echo JText::_( 'COM_VISFORMS_PROBLEM_WITH' )." (".$query.")";
				return false;
			}
		}
			
			// Add existing Fields
			$query = ' SELECT * from #__visfields c where c.fid='.$fid.' ';
			$fields = $this->_getList( $query );

			$tableFields = $dba->getTableColumns($tn,false);
			$n=count($fields );
			for ($i=0; $i < $n; $i++)
			{
				$rowField = $fields[$i];
				$fieldname = "F" . $rowField->id;
				
				if (!isset( $tableFields[$fieldname] )) 
				{
					$query = "ALTER TABLE ".$tn." ADD ".$fieldname." TEXT NULL";
					$dba->SetQuery($query);
					if (!$dba->query()) 
					{
						echo JText::_( 'COM_VISFORMS_PROBLEM_WITH' )." (".$query.")";
						return false;
					}
				}
				
			}

			return true;
		
	}


	/**
	 * Method to delete record(s)
	 *
	 * @param array $cid array of form id's
	 * @return	boolean	True on success
	 * @since Joomla 1.6
	 */
	function delete(&$cids)
	{
		
		$dba = JFactory::getDBO(); 
		$tablesAllowed = $dba->getTableList(); 

		$row = $this->getTable();

		if (count( $cids ))
		{
			foreach($cids as $cid) {
				if (!$row->delete( $cid )) 
				{
					$this->setError( $row->getErrorMsg() );
					return false;
				} else {
				
					//delete fields
					$query = "Delete FROM #__visfields WHERE fid = ".$cid;
					$dba->SetQuery($query);

					if (!$dba->query() )
					{
						$this->setError( $row->getErrorMsg() );
						return false;
					}
					else
					{
				
						/* Delete Forms Data */
						$tn = "visforms_" . $cid;
						$tnfull = $dba->getPrefix(). 'visforms_'.$cid;
						
						if (in_array($tnfull, $tablesAllowed)) 
						{
							
							$query = "drop table #__".$tn;						
							$dba->SetQuery($query);
							if (!$dba->query()) 
							{
								echo JText::_( 'COM_VISFORMS_PROBLEM_WITH' )." (".$query.")";
								return false;
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
		$form = $this->loadForm('com_visforms.visform', 'visform', array('control' => 'jform', 'load_data' => $loadData));
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
		$data = JFactory::getApplication()->getUserState('com_visforms.edit.visform.data', array());

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
	public function getTable($type = 'Visform', $prefix = 'Table', $config = array())
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
		return $condition;
	}

}
?>
