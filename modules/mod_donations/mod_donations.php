<?php
/**
 * Donations Module Entry Point
 *
 * @package
 * @subpackage Modules
 * @link
 * @license        GNU/GPL, see LICENSE.php
 *  This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
require_once( dirname(__FILE__).DIRECTORY_SEPARATOR.'helper.php' );


$user = JFactory::getUser();
$total = modDonationsHelper::getPlayerTotal($user->id);

require( JModuleHelper::getLayoutPath( 'mod_donations' ) );
?>
