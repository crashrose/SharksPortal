<?php
/**
 * Visforms model for Visforms
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

jimport( 'joomla.application.component.model' );
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

/**
 * Visforms modell
 *
 * @package		Joomla.Site
 * @subpackage	com_visforms
 * @since		1.6
 */
class VisformsModelVisforms extends JModel
{

	 var $_data;	 
	 
	 /**
	 * Method to retrieve the form and fields data structure from db
	 *
	 * @return array Array of objects containing the data from the database
	 * @since		1.6
	 */
	function getData()
	{
		$array = JRequest::getVar('id',  0, '', 'array');
		$id=(int)$array[0];
		if (is_numeric($id) == false) 
		{
			return null;
		}
		
		$query = ' SELECT * FROM #__visforms where id='.$id ;
						
		$this->_db->setQuery( $query );
		$this->_data = $this->_db->loadObject();

		$query = ' SELECT * FROM #__visfields where fid='.$id." and published=1 order by ordering asc" ;
		$fields = $this->_getList( $query );
		
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

		$this->_data->fields = $fields;
		
		return $this->_data;
	}
	
	
	/**
	 * Save Hits
	 * @return void
	 */
	function addHits()
	{
		$dba	= JFactory::getDBO();
		
		$visform = $this->getData();
		
		if (isset($visform->id))
		{
			$query = " update #__visforms set hits = ".($visform->hits + 1). " where id = ".$visform->id;

			$dba->SetQuery($query);		
			$dba->query();
		}
	}
	
	/**
	* Method to validate Post Data
	* @param  array $post Postdata
	* @param  array $fields Array of objects containing the data from the database
	* @return boolean true if valide
	*/
	
	function validatePostData($post, $fields) {
	
		$valid = true;
		$return = true;
		$n = count($fields);
		for ($i=0; $i<$n; $i++) {
			$field=$fields[$i];
			
			if (isset($post[$field->name])){
			
				//Check that mandatory fields are not empty
				if ($field->mandatory == 1) {
					//if radiobuttons, selects and checkboxes are submitted by post, they have a value selected. Therefore they are not empty (if mandatory)
					//these form field types can be excluded from check
					if (($field->typefield !== 'select') && ($field->typefield !== 'checkbox') && ($field->typefield !== 'radiobutton')) {
						$regex = '/[^.*]/';
						$valid = $this->validateField ($field->label, $post[$field->name], $regex, 'COM_VISFORMS_FIELD_REQUIRED');
						if (($return === true) && ($valid === false)) {
							$return = false;
						}
					}
				}
				
				// Check that special text-fields that are not empty have right format
				if (($field->typefield == 'text') && (!($post[$field->name] == ""))) { 
					switch ($field->t_texttype) {
						case 'number' :
						//Check for numbers
							$regex = '/^[-+]?[0-9]+$/';
							//Allow floats as well, is not supported by javascript validation
							/*if (is_numeric($post[$field->name]) === false) {
								$valid = false;
								$this->setError(JText::sprintf('COM_VISFORMS_FIELD_NOT_A_NUMBER', $field->label));
							}*/
							 $valid = $this->validateField ($field->label, $post[$field->name], $regex , 'COM_VISFORMS_FIELD_NOT_A_NUMBER');
							if (($return === true) && ($valid === false)) {
								$return = false;
							}
							break;
						case 'email':
							// Check for e-mail
							$regex = '/^([a-zA-Z0-9_\.\-\+%])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/';
							$valid = $this->validateField ($field->label, $post[$field->name], $regex, 'COM_VISFORMS_FIELD_EMAIL_NOT_VALIDE');
							if (($return === true) && ($valid === false)) {
								$return = false;
							}
							break;
						case 'url' :
							// Check for url
							$regex = '/^(http|https|ftp)\:\/\/[a-z0-9\-\.]+\.[a-z]{2,3}(:[a-z0-9]*)?\/?([a-z0-9\-\._\?\,\'\/\\\+&amp;%\$#\=~])*$/i';
							$valid = $this->validateField ($field->label, $post[$field->name], $regex, 'COM_VISFORMS_FIELD_NO_VALIDE_URL');
							if (($return === true) && ($valid === false)) {
								$return = false;
							}
							break;
						case 'date' :
							//check for right date format
							$dformat = explode(";", $field->d_format);
							if (strpos($post[$field->name], '.') > 0 ) 
							{
								$valid = $this->validateDate($field->label, $post[$field->name], '.', 'COM_VISFORMS_FIELD_DATE_FORMAT', $dformat[0]);
								if ($valid === false) {
									$_POST[$field->name] = "";
								}
								if (($return === true) && ($valid === false)) {
									$return = false;
								}
							}
							if (strpos($post[$field->name], '/') > 0 ) 
							{
								$valid = $this->validateDate($field->label, $post[$field->name], '/', 'COM_VISFORMS_FIELD_DATE_FORMAT', $dformat[0]);
								if ($valid === false) {
									$_POST[$field->name] = "";
								}
								if (($return === true) && ($valid === false)) {
									$return = false;
								}
							}							
							if (strpos($post[$field->name], '-') > 0 ) 
							{
								$valid = $this->validateDate($field->label, $post[$field->name], '-', 'COM_VISFORMS_FIELD_DATE_FORMAT', $dformat[0]);
								if ($valid === false) {
									$_POST[$field->name] = "";
								}
								if (($return === true) && ($valid === false)) {
									$return = false;
								}
							}
							if (strlen($post[$field->name]) != 10)
							{
								$this->setError(JText::sprintf('COM_VISFORMS_FIELD_DATE_FORMAT', $field->label, $dformat[0]));
								$return = false;
								break;
							}
						break;
						default : 
						break;
					}
				}
				
				//Check for right length of input
				if (($field->typefield == 'text' || $field->typefield == 'textarea') && (!($post[$field->name] == ""))) {
						$min = "0";
						if ($field->t_minchar != '') {
							$min = $field->t_minchar;
							if ($min != '0') {
								if ($field->typefield == 'text' && $field->t_texttype == 'number') {
									// Check min number value
									if (is_numeric($post[$field->name])) {
										$number = floatval($post[$field->name]);
										$minnumber = floatval($min);
										if ($number < $minnumber) {
											$this->setError(JText::sprintf('COM_VISFORMS_FIELD_MIN_VALUE', $field->label, $minnumber));
											$valid = false;
										}
										if (($return === true) && ($valid === false)) {
											$return = false;
										}
									}								
								}
								else {
									// Check minlength
									$regex = "/^[\\s\\S]{" . $min . ",}$/";
									$valid = $this->validateField ($field->label, $post[$field->name], $regex, 'COM_VISFORMS_FIELD_MIN_LENGTH', $min);
									if (($return === true) && ($valid === false)) {
										$return = false;
									}
								}
							}
						}
						
						$max = "-1";
						if ($field->t_maxchar != '') {
							$max = $field->t_maxchar;
							if ($max != '-1') {
								if ($field->typefield == 'text' && $field->t_texttype == 'number') {
									//check max number value
									if (is_numeric($post[$field->name])) {
										$number = floatval($post[$field->name]);
										$maxnumber = floatval($max);
										if ($number > $maxnumber) {
										$valid = false;
											$this->setError(JText::sprintf('COM_VISFORMS_FIELD_MAX_VALUE', $field->label, $maxnumber));
										}
										
										if (($return === true) && ($valid === false)) {
											$return = false;
										}
									}
								}
								else {
									// Check max-length
									$regex = "/^[\\s\\S]{0," . $max . "}$/";
									$valid = $this->validateField ($field->label, $post[$field->name], $regex, 'COM_VISFORMS_FIELD_MAX_LENGTH', $max);
									if (($return === true) && ($valid === false)) {
										$return = false;
									}
								}
							}
						}
					}				
				} else {
					//check for select, radiobuttons and checkboxes that must have a value selected
					if ($field->mandatory == 1) {
						switch($field->typefield) {
							case "select" :
								$this->setError(JText::sprintf('COM_VISFORMS_FIELD_REQUIRED_RADIO_SELECT', $field->label));
								$valid = false;
								break;
							case "radiobutton" :
								$this->setError(JText::sprintf('COM_VISFORMS_FIELD_REQUIRED_RADIO_SELECT', $field->label));
								$valid = false;
								break;
							case "checkbox" :
								$this->setError(JText::sprintf('COM_VISFORMS_FIELD_REQUIRED_CHECKBOX', $field->label));
								$valid = false;
								break;
								//We have to look in $_FILES to see, if a file is selected
							case "fileupload":
								if ((isset($_FILES[$field->name]['name']) === false) || (isset($_FILES[$field->name]['name']) && $_FILES[$field->name]['name'] ==''))
								{
									$this->setError(JText::sprintf('COM_VISFORMS_FIELD_REQUIRED_UPLOAD', $field->label));
									$valid = false;
									break;
								}
								else
								{
									//A file is selected, that is o.k. from mandantory point of view
									break;
								}
							default : 
								break;
						}
						
						if (($return === true) && ($valid === false)) {
							$return = false;
						}
					} 
				}
			}
		return $return;
	}
	
	/* regex's used in formcheck.js
	required : /[^.*]/,
	alpha : /^[a-z ._-]+$/i,
	alphanum : /^[a-z0-9 ._-]+$/i,
	digit : /^[-+]?[0-9]+$/,
	nodigit : /^[^0-9]+$/,
	number : /^[-+]?\d*\.?\d+$/,
	email : /^([a-zA-Z0-9_\.\-\+%])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/,
	image : /.(jpg|jpeg|png|gif|bmp)$/i,
	phone : /^\+{0,1}[0-9 \(\)\.\-]+$/,
	phone_inter : /^\+{0,1}[0-9 \(\)\.\-]+$/,
	url : /^(http|https|ftp)\:\/\/[a-z0-9\-\.]+\.[a-z]{2,3}(:[a-z0-9]*)?\/?([a-z0-9\-\._\?\,\'\/\\\+&amp;%\$#\=~])*$/i
	minlength : RegExp("^.{0,"+ ruleArgs[0] +"}$");
	*/
	
	/*
	* method to validate user input of field
	*
	* @param string $name Form field label
	* @param string $value user input from $_POST
	* @param string $regex regex to validate the value against
	* @param string $text error message
	* @param string $text length additional sprintf parameter, used for number validation
	*
	* @return boolean (true if input is valid)
	* @since Joomla 1.6
	*/	
	function validateField ($name, $value, $regex="", $text="", $length="") {
		if (!(preg_match($regex, $value) == true)) {
			$this->setError(JText::sprintf($text, $name, $length));
			return false;
		} else {
			return true;
		}
	}
	
	/*
	* method to validate format of date input
	* @param string $name Form field label
	* @param string $dateString date string from $_POST
	* @param string $delimiter delimiter in date string
	* @param string $text error message
	* @param string $dforamt date format string
	*
	* @return boolean (true if input is valid)
	* @since Joomla 1.6
	*/
	
	function validateDate ($name, $dateString, $delimiter, $text, $dformat) {
		(int)$day = 0;
		(int)$month = 0;
		(int)$year = 0;
		$checkdate = true;
		$date = explode($delimiter, $dateString);
		if (count($date) !== 3) 
		{
			$checkdate = false;
		} 
		else if (!(strpos($dformat, $delimiter) > 0))
		{
			$checkdate = false;
		}
		else
		{
			switch ($delimiter) {
				case  '.' :
				$day = (isset($date[0]) === true) ? (int)$date[0] : (int)0;
				$month = (isset($date[1]) === true) ? (int)$date[1] : (int)0;
				$year = (isset($date[2]) === true) ? (int)$date[2] : (int)0;
				break;
				case  '/' :
				$month = (isset($date[0]) === true) ? (int)$date[0] : (int)0;
				$day = (isset($date[1]) === true) ? (int)$date[1] : (int)0;
				$year = (isset($date[2]) === true) ? (int)$date[2] : (int)0;
				break;
				case  '-' :
				$year = (isset($date[0]) === true) ? (int)$date[0] : (int)0;
				$month = (isset($date[1]) === true) ? (int)$date[1] : (int)0;
				$day = (isset($date[2]) === true) ? (int)$date[2] : (int)0;
				break;
				default : 
				break;
			}
			$checkdate = checkdate($month, $day, $year);
		}
		if ($checkdate === false) {
			$this->setError(JText::sprintf($text, $name, $dformat));
			//ToDo Rausfinden wie wert entfernt werden kann und if SChleife für / - wiederholen wenn es funktionier
			return false;
		}
	}
	
	/**
	 * Method to save data user input
	 *
	 * @paran array $post user input from $_POST
	 * @return void
	 * @since Joomla 1.6
	 */
	function saveData($post)
	{		
		//Form and Field structure and info from db
		$visform = $this->getData();
		$n=count($visform->fields );
		
		// set some parameters
		$maxfilesize = $visform->maxfilesize;
		$allowedextensions = $visform->allowedextensions;
		$spambotcheck = $visform->spambotcheck;
		
		// include plugin spambotcheck
		if ($spambotcheck == 1)
		{
		JPluginHelper::importPlugin( 'visforms' ); 
		$dispatcher = JDispatcher::getInstance();
		$results = $dispatcher->trigger('onBeforeFormSubmit');
		}
		
		//upload files
		//controll upload success
		$uploadsuccess = true;
		
		if (file_exists ($visform->uploadpath) == true)
		{
			
			for ($i=0; $i < $n; $i++)
			{		
				$field = $visform->fields[$i];
				//Request has an fileupload with values
				if ($field->typefield == 'fileupload' && isset($_FILES[$field->name]['name']) && $_FILES[$field->name]['name'] !='' )
				{
					//get some variables
					$file[$i] = JRequest::getVar($field->name, '', 'files', 'array');
					$folder		= $visform->uploadpath;	
					
					// Set FTP credentials, if given
					JClientHelper::setCredentialsFromRequest('ftp');
					
					// Make the filename safe
					$file[$i]['name_org'] = $file[$i]['name'];
					$file[$i]['name']	= JFile::makeSafe($file[$i]['name']);
					
					// Check upload conditions
					$err = null;
					if (!$this->canUpload($file[$i], $err, $maxfilesize, $allowedextensions))
					{
						// The file can't be upload
						JError::raiseNotice(100, JText::sprintf($err, $file[$i]['name_org'], $maxfilesize));
						$uploadsuccess = false;
					}
					else
					{
						//get a unique id to rename uploadfiles
						$fileuid = uniqid('');
						
						//rename file
						$PathInf = pathinfo($file[$i]['name']);
						$ext = $PathInf['extension'];
						$file[$i]['new_name'] = basename($file[$i]['name'],".".$ext) . "_" . $fileuid . "." . $ext;
						
						//get complete upload path with filename of renamed file
						$filepath = JPath::clean($folder . '/' . strtolower($file[$i]['new_name']));
						$file[$i]['filepath'] = $filepath;					


						//try to upload file
						if (JFile::exists($file[$i]['filepath']))
						{
							// File exists
							JError::raiseWarning(100, JText::sprintf('COM_VISFORMS_ERROR_FILE_EXISTS', $file[$i]['name_org']));
							$uploadsuccess = false;
						}
						else
						{
							if (!JFile::upload($file[$i]['tmp_name'], $file[$i]['filepath']))
							{
								// Error in upload
								JError::raiseWarning(100, JText::sprintf('COM_VISFORMS_ERROR_UNABLE_TO_UPLOAD_FILE', $file[$i]['name_org']));
								$uploadsuccess = false;
							}
						}
					}
				}				
			}
		}
		
		//control save success
		$savesuccess = true;
		if ($visform->saveresult == 1 and $uploadsuccess == true) 
		{			
	
			$dba	= JFactory::getDBO();
			
			$query = ' insert into #__visforms_'.$visform->id."(" ;
		  	$query2 = ' insert into #__visforms_'.$visform->id."(" ;
			
			//$n=count($visform->fields ) already set above;
			for ($i=0; $i < $n; $i++)
			{	
				$field = $visform->fields[$i];
				if ($field->typefield != 'button' && $field->typefield != 'fieldsep')
				{
					$query = $query."F".$field->id.",";
					$query2 = $query2.$field->name.",";
				}
			}

			$query = $query."created,ipaddress,published,articleid) values(";
			$query2 = $query2."created,ipaddress,published,articleid) values(";
     
			//$n=count($visform->fields ); already set above;
			for ($i=0; $i < $n; $i++)
			{	
				$field = $visform->fields[$i];
				if ($field->typefield != 'button' && $field->typefield != 'fieldsep')
				{				
					if ($field->typefield == 'fileupload' && isset($_FILES[$field->name]['name']) && $_FILES[$field->name]['name'] !='' )
					{ 
						$fieldValue = $file[$i]['filepath'];
					} else if (Isset($post[$field->name]))
					{
						$fieldValue = $post[$field->name];
					} 
					else 
					{
						$fieldValue = '';
					}
					
					if (is_array ($fieldValue))	
					{
						$arrayVal = "";
						foreach($fieldValue as $selectValue){					
							$arrayVal = $arrayVal.$selectValue.",";
						}
						if (strcasecmp(substr($arrayVal, strlen($arrayVal) - strlen(",")),",") == 0)
						{
							$arrayVal = substr($arrayVal, 0,strlen($arrayVal) - strlen(","));
						}
						$fieldValue = $arrayVal;
					}
					
					$query = $query."'".addslashes($fieldValue)."',";
					$query2 = $query2."'".addslashes($fieldValue)."',";
				}
			}
			
			$autopublish = "0";
			if($visform->autopublish == 1) 
			{
				$autopublish = "1";
			}
			
			$query = $query."'".date("Y-m-d H:i:s")."','".$_SERVER['REMOTE_ADDR']."',".$autopublish.",";
			$query2 = $query2."'".date("Y-m-d H:i:s")."','".$_SERVER['REMOTE_ADDR']."',".$autopublish.",";

			$articleid = JRequest::getCmd('articleid');
			if (isset($articleid) && ($articleid != ''))
			{
				$query = $query."'".JRequest::getCmd('articleid')."'";
				$query2 = $query2."'".JRequest::getCmd('articleid')."'";
			} else {
				$query = $query."null";
				$query2 = $query2."null";
			}
			
			$query = $query.")";
			$query2 = $query2.")";
			$dba->SetQuery($query);
			
			if (!$dba->query()) 
			{
				$errMsg = JText::_( 'COM_VISFORMS_PROBLEM_WITH' )." (".$query.")"."<br />". $dba->getErrorMsg();
				$dba->SetQuery($query2);
				if (!$dba->query()) 
				{					
					echo JText::_( 'COM_VISFORMS_PROBLEM_WITH' )." (".$query2.")";
					echo $dba->getErrorMsg();
					echo $errMsg;
					$savesuccess = false;
				}
			}
						
		}		
		
		/* ************************* */
		/*     Send Email Result     */
		/* ************************* */
		if ($visform->emailresult == 1 and $savesuccess == true and $uploadsuccess == true) {
	
			$mail = JFactory::getMailer();
			$mail->CharSet = "utf-8";
		
			$mailBody = "Form : ".$visform->title." [".$visform->name."]<br />\n";
			$mailBody = $mailBody."registered at ".date("Y-m-d H:i:s")."<br /><br />\n\n";

			//$n=count($visform->fields ); already set above
			for ($i=0; $i < $n; $i++)
			{	
				$field = $visform->fields[$i];
				if ($field->typefield != 'button' && $field->typefield != 'fieldsep')
				{
					if ($field->typefield == 'fileupload' && isset($_FILES[$field->name]['name']) && $_FILES[$field->name]['name'] !='' )
					{
						$fieldValue = $file[$i]['filepath'];
						//Attach file to email
						if ($file[$i]['filepath'] != "" && $visform->emailresultincfile == "1") 
						{
							$mail->addAttachment($file[$i]['filepath']);
						}

					}
					else if (Isset($post[$field->name]))
					{
						$fieldValue = $post[$field->name];
					} 
					else 
					{
						$fieldValue = '';
					}
					
					if (is_array ($fieldValue))	
					{
						$arrayVal = "";
						foreach($fieldValue as $selectValue){					
							$arrayVal = $arrayVal.$selectValue.",";
						}
						if (strcasecmp(substr($arrayVal, strlen($arrayVal) - strlen(",")),",") == 0)
						{
							$arrayVal = substr($arrayVal, 0,strlen($arrayVal) - strlen(","));
						}
						$fieldValue = $arrayVal;
					}
									
					$isEmail = false;
					if ($field->typefield == 'text') {
						$opt = explode("[--]", $field->defaultvalue);
						$key1 = explode("===", $opt[0]);
						$key2 = explode("===", $opt[1]);
						$key3 = explode("===", $opt[2]);
						$t_texttype = $key3[1];
						
						if ($t_texttype == 'email') {
							$isEmail = true;
						}
						
					}
					
					if ($isEmail == true) 
					{
						$fieldValue = '<a href="mailto:'.$fieldValue.'">'.$fieldValue.'</a>';
					} 
				
					$mailBody = $mailBody.$field->label . " : " . $fieldValue . "<br />\n";
				}
			}
			
			$mailBody = $mailBody.JText::_( 'COM_VISFORMS_IP_ADDRESS' ) . " : " . $_SERVER['REMOTE_ADDR'] . "<br />\n";
			
			$articleid = JRequest::getCmd('articleid');
			if (isset($articleid) && ($articleid != ''))
			{
				$mailBody = $mailBody.JText::_( 'COM_VISFORMS_ARTICLE_ID' ) . " : " . $articleid . "<br />\n";
			}
			
			if (strcmp($visform->emailto,"") != 0)
			{
				$mail->addRecipient( explode(",", $visform->emailto) );
			}
			if (strcmp($visform->emailcc,"") != 0)
			{
				$mail->addCC( explode(",", $visform->emailcc) );
			}
			if (strcmp($visform->emailbcc,"") != 0)
			{
				$mail->addBCC( explode(",", $visform->emailbcc) );
			}
			
			$mail->setSender( array( $visform->emailfrom, "" ) );
			$mail->setSubject( $visform->subject );
			$mail->setBody( $mailBody );

			$mail->IsHTML (true);			
			$sent = $mail->Send();
			
		}		
		
		/* ************************** */
		/*     Send Email Receipt     */
		/* ************************** */
		if ($visform->emailreceipt == 1 and $savesuccess == true and $uploadsuccess == true) 
		{
		
			$IsSendMail = false;
			$emailReceiptTo = '';
			
			$mail = JFactory::getMailer();
			$mail->CharSet = "utf-8";
		
			$mailBody = $visform->emailreceipttext;
			
			$mailBody = $mailBody."<br/><br/>Form : ".$visform->title."<br />\n";
			$mailBody = $mailBody.JText::_( 'COM_VISFORMS_REGISTERD_AT' )." ".date("Y-m-d H:i:s")."<br /><br />\n\n";

			$n=count($visform->fields );
			for ($i=0; $i < $n; $i++)
			{	
				$field = $visform->fields[$i];
				
				if ($field->typefield == 'text')
				{
					$opt = explode("[--]", $field->defaultvalue);
					if (count($opt) > 2) {
						$key3 = explode("===", $opt[2]);
						if ($key3[1] == 'email') 
						{
							$IsSendMail = true;
							$emailReceiptTo = $post[$field->name];
						}
					}						
				}
			}
			
			if ($visform->emailreceiptincfield == 1) {				
				for ($i=0; $i < $n; $i++)
				{	
					$field = $visform->fields[$i];
					if ($field->typefield != 'button' && $field->typefield != 'fieldsep')
					{
							
						if ($field->typefield == 'fileupload' && isset($_FILES[$field->name]['name']) && $_FILES[$field->name]['name'] !='' )
						{
							$fieldValue = $file[$i]['new_name'];
						} 
						else if (Isset($post[$field->name]))
						{
							$fieldValue = $post[$field->name];
						}
						else 
						{
							$fieldValue = '';
						}
							
						if (is_array ($fieldValue))	
						{
							$arrayVal = "";
							foreach($fieldValue as $selectValue)
							{					
								$arrayVal = $arrayVal.$selectValue.",";
							}
							if (strcasecmp(substr($arrayVal, strlen($arrayVal) - strlen(",")),",") == 0)
							{
								$arrayVal = substr($arrayVal, 0,strlen($arrayVal) - strlen(","));
							}
							$fieldValue = $arrayVal;
						}
						
						$mailBody = $mailBody.$field->label . " : " . $fieldValue . "<br />\n";
					}
					
				}	
				
				$mailBody = $mailBody.JText::_( 'COM_VISFORMS_IP_ADDRESS' ) . " : " . $_SERVER['REMOTE_ADDR'] . "<br />\n";
				
			}
			
			//Attach filed to email
			if ($visform->emailreceiptincfile == 1)
			{
				for ($i=0; $i < $n; $i++) {
					$field = $visform->fields[$i];
					if ($field->typefield == 'fileupload' && isset($_FILES[$field->name]['name']) && $_FILES[$field->name]['name'] !='' )
					{
						if ($file[$i]['filepath'] != '') 
						{
							$mail->addAttachment($file[$i]['filepath']);
						}
					} 
				}
			}
			
			
			if (strcmp($emailReceiptTo,"") != 0 && $IsSendMail == true)
			{
				$mail->addRecipient($emailReceiptTo);
						
				$mail->setSender( array( $visform->emailfrom, "" ) );
				$mail->setSubject( $visform->emailreceiptsubject );
				$mail->setBody( $mailBody );
		
				$mail->IsHTML (true);
			
				$sent = $mail->Send();
			}
		}		
		if ($uploadsuccess === false || $savesuccess === false) 
		{
			return false;
		}
		return true;
	}
	
	
	/**
	  * Method to retrieve menu params
	  *
	  * @return array Array of objects containing the params from active menu
	  * @since Joomla 1.6
	  */
	
	function getMenuparams () 
	{
		$app = JFactory::getApplication();
		$menu_params = $app->getParams();
		$this->setState('menu_params', $menu_params);		
		return $menu_params;
	}
	
	/**
	 * Checks if the file can be uploaded
	 *
	 * @param array File information
	 * @param string An error message to be returned
	 *
	 * @return boolean
	 * @since Joomla 1.6
	 */
	public function canUpload($file, &$err, $maxfilesize, $allowedextensions)
	{

		if (empty($file['name'])) {
			$err = 'COM_VISFORMS_ERROR_UPLOAD_INPUT';
			return false;
		}

		jimport('joomla.filesystem.file');
		if ($file['name'] !== JFile::makesafe($file['name'])) {
			$err = 'COM_VISFORMS_ERROR_WARNFILENAME';
			return false;
		}

		$format = strtolower(JFile::getExt($file['name']));

		$allowable = explode(',', $allowedextensions);		
		if (!in_array($format, $allowable))
		{
			$err = 'COM_VISFORMS_ERROR_WARNFILETYPE';
			return false;
		}

		$maxSize = (int) ($maxfilesize  * 1024);
		if ($maxSize > 0 && (int) $file['size'] > $maxSize)
		{
			$err = 'COM_VISFORMS_ERROR_WARNFILETOOLARGE';
			return false;
		}

		$imginfo = null;

		$images = explode(',', "bmp,gif,jpg,jpeg,png");
		if (in_array($format, $images)) { // if its an image run it through getimagesize
			// if tmp_name is empty, then the file was bigger than the PHP limit
			if (!empty($file['tmp_name'])) {
				if (($imginfo = getimagesize($file['tmp_name'])) === FALSE) {
					$err = 'COM_VISFORMS_ERROR_WARNINVALID_IMG';
					return false;
				}
			} else {
				$err = 'COM_VISFORMS_ERROR_WARNFILETOOLARGE';
				return false;
			}
		}

		$xss_check =  JFile::read($file['tmp_name'], false, 256);
		$html_tags = array('abbr', 'acronym', 'address', 'applet', 'area', 'audioscope', 'base', 'basefont', 'bdo', 'bgsound', 'big', 'blackface', 'blink', 'blockquote', 'body', 'bq', 'br', 'button', 'caption', 'center', 'cite', 'code', 'col', 'colgroup', 'comment', 'custom', 'dd', 'del', 'dfn', 'dir', 'div', 'dl', 'dt', 'em', 'embed', 'fieldset', 'fn', 'font', 'form', 'frame', 'frameset', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'head', 'hr', 'html', 'iframe', 'ilayer', 'img', 'input', 'ins', 'isindex', 'keygen', 'kbd', 'label', 'layer', 'legend', 'li', 'limittext', 'link', 'listing', 'map', 'marquee', 'menu', 'meta', 'multicol', 'nobr', 'noembed', 'noframes', 'noscript', 'nosmartquotes', 'object', 'ol', 'optgroup', 'option', 'param', 'plaintext', 'pre', 'rt', 'ruby', 's', 'samp', 'script', 'select', 'server', 'shadow', 'sidebar', 'small', 'spacer', 'span', 'strike', 'strong', 'style', 'sub', 'sup', 'table', 'tbody', 'td', 'textarea', 'tfoot', 'th', 'thead', 'title', 'tr', 'tt', 'ul', 'var', 'wbr', 'xml', 'xmp', '!DOCTYPE', '!--');
		foreach($html_tags as $tag) {
			// A tag is '<tagname ', so we need to add < and a space or '<tagname>'
			if (stristr($xss_check, '<'.$tag.' ') || stristr($xss_check, '<'.$tag.'>')) {
				$err = 'COM_VISFORMS_ERROR_WARNIEXSS';
				return false;
			}
		}
		return true;
	}
}
