<?php
/**
 * Visfield table class
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
 * ckfield Table class
 *
 * @package    CK.Joomla
 * @subpackage Components
 */
class TableVisfield extends JTable
{
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id = null;
	
	/**
	 * @var int
	 */
	var $fid = null;
	
	/**
	 * @var string
	 */
	var $label = null;
	
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
	var $name = null;

	/**
	 * @var string
	 */
	var $typefield = null;

	/**
	 * @var int
	 */
	var $ordering = null;

	/**
	 * @var int
	 */
	var $published = 1;

	/**
	 * @var int
	 */
	var $mandatory = 0;
	
	/**
	 * @var int
	 */
	var $readonly = 0;

	/**
	 * @var string
	 */
	var $custominfo = null;

	/**
	 * @var string
	 */
	var $customerror = null;

	/**
	 * @var string
	 */
	var $customvalidation = null;

	/**
	 * @var string
	 */
	var $fieldCSSclass = null;

	/**
	 * @var string
	 */
	var $labelCSSclass = null;
	
	/**
	 * @var string
	 */
	var $customtext = null;
	
	/**
	 * @var int
	 */
	var $frontdisplay = 1;
	
	var $fillwith = null;
	
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function TableVisfield(& $db) {			
		parent::__construct('#__visfields', 'id', $db);
	}
	
	function store($updateNulls = false) {

		return parent::store($updateNulls = false);
	}
}
?>
