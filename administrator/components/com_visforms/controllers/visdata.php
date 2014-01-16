<?php
/**
 * visdata controller for Visforms
 *
 * @author       Aicha Vack
 * @see          visforms is extended and rivised adaptation of ckforms from cookex (http://www.cookex.eu) for Joomla 2.5
 * @package      Joomla.Administrator
 * @subpackage   com_visforms
 * @link         http://www.vi-solutions.de 
 * @license      GNU General Public License version 2 or later; see license.txt
 * @copyright    2012 vi-solutions
 * @since        Joomla 1.6 
 */

// no direct access
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.controller' );
/**
 * Visdata controller class for Visforms
 *
 * @package      Joomla.Administrator
 * @subpackage   com_visforms
 *
 * @since        Joomla 1.6 
 */
class VisformsControllerVisdata extends JController
{

	/**
	 * Class constructor.
	 *
	 * @param   array  $config  A named array of configuration variables.
	 *
	 * @since	1.6
	 */
	public function __construct($config = array())
	{
		parent::__construct($config);

		// Register Extra tasks
		$this->registerTask('unpublish',	'publish');
	}

	/**
	 * Export data saved in database to csv
	 *
	 * @return void
	 *
	 * @since Joomla 1.6 
	 */
	function export() {
			
		// Check for request forgeries
		JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		
		//get the Model
		$model = $this->getModel('visdata');
		
		//get formdata from Database
		$items = $model->getData();
		//get fiels from database
		$fields = $model->getDatafields();
		$ipfieldname = "ipaddress";
			
		header("Expires: Sun, 1 Jan 2000 12:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header( "Content-type: application/vnd.ms-excel"); 
		header("Content-disposition: attachment; filename=visforms_" . date("Ymd").".csv");  

		$data = "";
		$isIPaddress = false;
		$nbItems=count( $items );
		$nbFields=count( $fields );
		
		
		/* Test if ipaddress field exist */
		if ($nbItems > 0)
		{			
			$row = $items[0];
			
			foreach($row as $key => $value) {
				if (strcmp($key,$ipfieldname) == 0)
				{
					$isIPaddress = true;
				}
			}
			
		}
		
		for ($i=0; $i < $nbFields; $i++)
		{
			$rowField = $fields[$i];
			if ($rowField->typefield != 'button' && $rowField->typefield != 'fieldsep')
			{

				$unicode_str_for_Excel = iconv("UTF-8", "windows-1250",$rowField->label);

				$unicode_str_for_Excel = str_replace("\"", "\"\"", $unicode_str_for_Excel);
				
				$pos = strpos($unicode_str_for_Excel, ';');
				if ($pos === false) 
				{
					$data .= $unicode_str_for_Excel;
				} else {
					$data .= "\"".$unicode_str_for_Excel."\"";
				}
				
				if ($i < $nbFields-1) $data .= ";";				
			}			
		}
		if ($isIPaddress == true)
		{
			$data .= ";".JText::_( 'COM_VISFORMS_IP' );
		}

		echo $data." \n";
		
		for ($i=0; $i < $nbItems; $i++)
		{
			$row = $items[$i];
			
			$data = '';
			for ($j=0; $j < $nbFields; $j++)
			{
				$rowField = $fields[$j];
				if ($rowField->typefield != 'button' && $rowField->typefield != 'fieldsep')
				{
					$prop="F".$rowField->id;
					$unicode_str_for_Excel = iconv("UTF-8", "windows-1250",$row->$prop);

					$unicode_str_for_Excel = str_replace("\"", "\"\"", $unicode_str_for_Excel);

					$pos = strpos($unicode_str_for_Excel, ';');
					if ($pos === false) 
					{
						$data .= $unicode_str_for_Excel;
					} else {
						$data .= "\"".$unicode_str_for_Excel."\"";
					}
	
					if ($j < $nbFields-1) $data .= ";";			
				}
			}

			if ($isIPaddress == true)
			{
				$data .= ";".$row->$ipfieldname;
			}

			echo $data." \n";
		}

		JFactory::getApplication()->close();
	}	

	/**
	 * remove record(s) from database
	 *
	 * @return void
	 *
	 * @since Joomla 1.6 
	 */
	function remove()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		
		$model = $this->getModel('visdata');
		$fid = JRequest::getVar( 'fid', -1 );
		
		if(!$model->delete()) {
			$msg = JText::_( 'COM_VISFORMS_DELETE_ERROR' );
		} else {
			$msg = JText::_( 'COM_VISFORMS_DELETE_FIELD_SUCCESS' );
		}

		$this->setRedirect('index.php?option=com_visforms&task=visdata.&fid='.$fid, $msg );
	}
	
	/**
	 * Method to display a data view.
	 *
	 * @param   boolean  $cachable   If true, the view output will be cached
	 * @param   array    $urlparams  An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return	JController          This object to support chaining.
	 *
	 * @since	1.5
	 */
	public function display($cachable = false, $urlparams = false)
	{	
		$fid = JRequest::getVar('fid', -1);
		$this->setRedirect('index.php?option=com_visforms&view=visdata&fid='.$fid);
	}

	/**
	 * Method to display a detail view.
	 *
	 * @param   boolean  $cachable   If true, the view output will be cached
	 * @param   array    $urlparams  An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return	JController          This object to support chaining.
	 *
	 * @since	1.5
	 */
	function detail()
	{
		$fid = JRequest::getVar('fid', -1);
		$cid = JRequest::getVar('cid', 0);
		if (is_array($cid))
		{
			$cid = $cid[0];
		}
		$this->setRedirect('index.php?option=com_visforms&view=visdata&layout=detail&cid[]='. $cid . '&fid='.$fid);
	}
	
	
	/**
	 * Method to publish/unpublish recordsets
	 *
	 * @return void
	 *
	 * @since	1.6
	 */
	function publish()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		
		// Initialize variables
		$db			= JFactory::getDBO();
		$user		= JFactory::getUser();
		$cid		= JRequest::getVar( 'cid', array(), 'post', 'array' );
		$task 		= $this->getTask();
		$publish	= ($task == 'publish');
		$n			= count( $cid );
		$fid = JRequest::getVar( 'fid', -1 );

		if (empty( $cid )) {
			return JError::raiseWarning( 500, JText::_( 'COM_VISFORMS_NO_ITEMS_SELECTED' ) );
		}

		$link = 'index.php?option=com_visforms&task=visdata.display&fid='. $fid ;

		JArrayHelper::toInteger( $cid );
		$cids = implode( ',', $cid );

		$query = 'UPDATE #__visforms_'.$fid
		. ' SET published = ' . (int) $publish
		. ' WHERE id IN ( '. $cids.'  )';
		
		$db->setQuery( $query );
		if (!$db->query()) {
			return JError::raiseWarning( 500, $row->getError() );
		}
		
		$this->setMessage( JText::sprintf( $publish ? JText::_('COM_VISFORMS_PUBLISHED') : JText::_('COM_VISFORMS_UNPUBLISHED'), $n ) );
		
		$this->setRedirect($link);		
	}
	
}
?>
