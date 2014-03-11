<?php
/**
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
defined ( '_JEXEC' ) or die ();

/**
 * Banners component helper.
 * @package Joomla.Administrator
 * @subpackage com_attendance
 */
class attendanceHelper {

	/**
	 * Configure the Linkbar.
	 * @param string	The name of the active view.
	 */
	public static function addSubmenu($vName) {
		JSubMenuHelper::addEntry ( JText::_ ( 'COM_ATTENDANCE_SUBMENU_EVENTS' ), 'index.php?option=com_attendance&view=events', $vName == 'events' );
		JSubMenuHelper::addEntry ( JText::_ ( 'COM_ATTENDANCE_SUBMENU_LOCATIONS' ), 'index.php?option=com_attendance&view=locations', $vName == 'locations' );
		JSubMenuHelper::addEntry ( JText::_ ( 'COM_ATTENDANCE_SUBMENU_EVENT_TYPES' ), 'index.php?option=com_attendance&view=types', $vName == 'types' );
	}

	public static function RSVPStatus() {
		// Create the batch selector to change the client on a selection list.
		$lines = array (
				'<select name="batch[rsvp-YN-val]" class="radio" id="batch-rsvpYN-id">',
				'<option value="">' . JText::_ ( 'COM_ATTENDANCE_BATCH_CLIENT_NOCHANGE' ) . '</option>',
				'<option value="0">' . JText::_ ( 'COM_BANNERS_NO_CLIENT' ) . '</option>',
				JHtml::_ ( 'select.options', self::clientlist (), 'value', 'text' ),
				'</select>'
		);
		return implode ( "\n", $lines );
	}


	public static function getGroups(){
		$db = JFactory::getDBO();
		$AttendeeList = 'Attendees';

		// Build the base query.
		$query = $db->getQuery(true);
		$query->select('rules');
		$query->from('#__viewlevels');
		$query->where('title = \'Attendees\'');
		$db->setQuery($query);

		// Set the query for execution.
		$groups = json_decode($db->loadResult());
		return $groups;
	}

	public static function getAssignedGroups($eventID){
		$db = JFactory::getDBO();

		// Build the base query.
		$query = $db->getQuery(true);
		$query->select('group_id');
		$query->from('#__sched_event_mand_grps');
		$query->where('event_id = '. $eventID);
		$db->setQuery($query);

		// Set the query for execution.
		$groups = $db->loadColumn();
		return $groups;
	}

	public static function usergroups($grouplist, $name, $selected, $checkSuperAdmin = false)
	{
		static $count;

		$count++;

// 		$isSuperAdmin = JFactory::getUser()->authorise('core.admin');
$grouplist = implode(', ',$grouplist);

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('a.*, COUNT(DISTINCT b.id) AS level');
		$query->from($db->quoteName('#__usergroups') . ' AS a');
		$query->join('LEFT', $db->quoteName('#__usergroups') . ' AS b ON a.lft > b.lft AND a.rgt < b.rgt');
		$query->where('a.id in ('. $grouplist .')');
		$query->group('a.id, a.title, a.lft, a.rgt, a.parent_id');
		$query->order('a.lft ASC');
		$db->setQuery($query);
		$groups = $db->loadObjectList();

		// Check for a database error.
		if ($db->getErrorNum())
		{
			JError::raiseNotice(500, $db->getErrorMsg());
			return null;
		}

		$html = array();

		$html[] = '<ul class="checklist usergroups">';

		for ($i = 0, $n = count($groups); $i < $n; $i++)
		{
		$item = &$groups[$i];

		// If checkSuperAdmin is true, only add item if the user is superadmin or the group is not super admin
		if ((!$checkSuperAdmin) || $isSuperAdmin || (!JAccess::checkGroup($item->id, 'core.admin')))
		{
				// Setup  the variable attributes.
			$eid = $count . 'group_' . $item->id;
			// Don't call in_array unless something is selected
			$checked = '';
			if ($selected)
			{
			$checked = in_array($item->id, $selected) ? ' checked="checked"' : '';
				}
				$rel = ($item->parent_id > 0) ? ' rel="' . $count . 'group_' . $item->parent_id . '"' : '';

					// Build the HTML for the item.
			$html[] = '	<li>';
			$html[] = '		<input type="checkbox" name="' . $name . '[]" value="' . $item->id . '" id="' . $eid . '"';
			$html[] = '				' . $checked . $rel . ' />';
			$html[] = '		<label for="' . $eid . '">';
			$html[] = '		' . str_repeat('<span class="gi">|&mdash;</span>', $item->level) . $item->title;
			$html[] = '		</label>';
			$html[] = '	</li>';
		}
		}
		$html[] = '</ul>';

			return implode("\n", $html);
	}
}


