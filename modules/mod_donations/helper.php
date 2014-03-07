<?php
/**
 * Helper class for Hello World! module
 *
 * @package    Joomla.Tutorials
 * @subpackage Modules
 * @link http://dev.joomla.org/component/option,com_jd-wiki/Itemid,31/id,tutorials:modules/
 * @license        GNU/GPL, see LICENSE.php
 * mod_helloworld is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */
class modDonationsHelper
{
    /**
     * Retrieves the donation data
     */

    public static function getPlayerTotal($user_id)
    {


$db = JFactory::getDbo();
$query = $db->getQuery(true);
$query->select('SUM(amount) as total');
$query->from('#__player_donations as donations');
$query->join('INNER','#__player_id_translate old_to_new ON old_to_new.old_player_id = donations.player_id_old');
$query->join('INNER','#__users new_players ON old_to_new.new_player_id = new_players.id');
$query->where('new_players.id = '.$user_id);
// Reset the query using our newly populated query object.

$db->setQuery($query);
$donations = $db->loadResult();
return $donations;
    }
}