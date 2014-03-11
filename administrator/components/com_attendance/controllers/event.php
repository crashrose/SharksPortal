<?php
// No direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted access' );
// import Joomla controllerform library
jimport ( 'joomla.application.component.controllerform' );

/**
 * Event Controller
 */
class attendanceControllerEvent extends JControllerForm {
	protected $view_list = 'events';

	public function save($data){
		$jinput = JFactory::getApplication()->input;
		$submitted_data = $jinput -> get('jform', Array(), 'array');
		$groups = $submitted_data['groups'];
		$event_id = $submitted_data['id'];
		$insert = $event_id . ', ' . implode('), (' . $event_id . ', ', $groups);

		// Store the group data if the user data was saved.

			// Delete the old user group maps.
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->delete();
			$query->from($db->quoteName('#__sched_event_mand_grps'));
			$query->where($db->quoteName('event_id') . ' = ' . (int) $event_id);
			$db->setQuery($query);
			$db->execute();

			// Check for a database error.
			if ($db->getErrorNum())
			{
				$this->setError($db->getErrorMsg());
				return false;
			}

			// Set the new user group maps.
			$query->clear();
			$query->insert($db->quoteName('#__sched_event_mand_grps'));
			$query->columns(array($db->quoteName('event_id'), $db->quoteName('group_id')));
			$query->values($event_id . ', ' . implode('), (' . $event_id . ', ', $groups));
			$db->setQuery($query);
			$db->execute();

			// Check for a database error.
			if ($db->getErrorNum())
			{
				$this->setError($db->getErrorMsg());
				return false;
			}
		parent::save($data);
	}
}