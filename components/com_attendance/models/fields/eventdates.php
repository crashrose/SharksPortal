<?php

defined('JPATH_BASE') or die;

jimport('joomla.html.html');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

/**
 * Custom Field class for the Joomla Framework.
 *
 * @package             Joomla.Administrator
 * @subpackage          com_my
 * @since               1.6
*/
class JFormFieldEventDates extends JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var         string
	 * @since       1.6
	 */
	protected $type = 'eventDates';

	/**
	 * Method to get the field options.
	 *
	 * @return      array   The field option objects.
	 * @since       1.6
	 */
	public function getOptions()
	{
		// Initialize variables.
		$options = array();

		$db     = JFactory::getDbo();
		$query  = $db->getQuery(true);

		$query->select ( 'distinct event_date As value, event_date As event_date' );
		$query->from ( '#__sched_events' );
		$query->order ( 'event_date' );

		// Get the options.
		$db->setQuery($query);

		$options = $db->loadObjectList();
		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}

		return $options;
	}
}