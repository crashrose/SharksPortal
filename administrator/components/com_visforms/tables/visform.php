<?php
/**
 * Visform table class
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
defined('_JEXEC') or die('Restricted access');


/**
 * Form Table class
 *
 * @package    CK.Joomla
 * @subpackage Components
 */
class TableVisform extends JTable
{
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id = null;
	
	 /*
	 * @var int
	 */
	var $asset_id = 0;
	
	/**
	 * @var string
	 */
	var $name = null;

	/**
	 * @var string
	 */
	var $title = null;
	
	/**
	 * @var int
	 */
	var $checked_out = 0;
	
	/**
	 * @var string
	 */
	var $checked_out_time = "0000-00-00 00:00:00";

	/**
	 * @var string
	 */
	var $description = null;
	
	/**
	 * @var string
	 */
	var $emailfrom = null;

	/**
	 * @var string
	 */
	var $emailto = null;

	/**
	 * @var string
	 */
	var $emailcc = null;

	/**
	 * @var string
	 */
	var $emailbcc = null;

	/**
	 * @var string
	 */
	var $subject = null;
	
	/**
	 * @var datetime
	 */
	var $created = null;
	
	/**
	 * @var int
	 */	
	var $created_by = 0;

	/**
	 * @var int
	 */	
	var $hits = 0;

	/**
	 * @var int
	 */
	var $published = 1;
	
	/**
	 * @var int
	 */
	var $saveresult = 0;

	/**
	 * @var int
	 */
	var $emailresult = 0;

	/**
	 * @var string
	 */
	var $textresult = null;
	
	/**
	 * @var int
	 */
	var $redirecturl = 0;
	
	/**
	 * @var int
	 */
	var $spambotcheck = 0;
	
	/**
	 * @var int
	 */	
	var $captcha = 0;

	/**
	 * @var string
	 */
	var $captchacustominfo = null;
	
	/**
	 * @var string
	 */
	var $captchacustomerror = null;
	
	/**
	 * @var string
	 */
	var $uploadpath = null;
	
	/**
	 * @var int
	 */	
	var $maxfilesize = 0;
	
	/**
	 * var string
	*/
	var $allowedextensions = null;
	
	/**
	 * @var int
	 */	
	var $poweredby = 0;
	
	/**
	 * @var int
	 */	
	var $emailreceipt = 0;
	
	/**
	 * var string
	*/
	var $emailreceipttext = null;
	
	/**
	 * var string
	*/
	var $emailreceiptsubject = null;
	
	/**
	 * @var int
	 */	
	var $emailreceiptincfield = 0;
	
	/**
	 * @var int
	 */	
	var $emailreceiptincfile = 0;
	
	/**
	 * @var int
	 */	
	var $emailresultincfile = 0;
	
	/**
	 * var string
	*/
	var $formCSSclass = null;
	
	/**
	 * @var int
	 */
	var $displayip = 1;

	/**
	 * @var int
	 */
	var $displaydetail = 0;

   	/**
	 * var string
	*/
	var $fronttitle = null;
	
   	/**
	 * var string
	*/
	var $frontdescription = null;

   	/**
	 * @var int
	 */
	var $autopublish = 1;
	
	/**
	 * var string
	*/
	var $language = "";
	
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function TableVisform(& $db) 
	{	
		$user = JFactory::getUser();
		$created_by = $user->id;
		parent::__construct('#__visforms', 'id', $db);
	}
	
	public function bind($array, $ignore = '')
	{
			// Bind the rules. 
			if (isset($array['rules']) && is_array($array['rules'])) { 
					$rules = new JRules($array['rules']); 
					$this->setRules($rules); 
			}
			return parent::bind($array, $ignore);
	}
	
	function store($updateNulls=false) 
	{
		return parent::store($updateNulls=false);
	}
	
	/**
	* Method to compute the name of the asset
	*
	* @return  string  The asset name
	* @since   2.0
	*/
	protected function _getAssetName()
	{
	return 'com_visforms.form.'.$this->id;
	}
	
	 /**
	 * Redefined asset name, as we support action control
	 */
	protected function _getAssetTitle() {
			return $this->title;
	}
}
?>
