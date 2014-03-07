<?php
/**
 * Import controller
 *
 * @package		CSVI
 * @author 		Roland Dalmulder
 * @link 		http://www.csvimproved.com
 * @copyright 	Copyright (C) 2006 - 2013 RolandD Cyber Produksi. All rights reserved.
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: importfile.php 2275 2013-01-03 21:08:43Z RolandD $
 */
defined('_JEXEC') or die('Direct Access to this location is not allowed.');
jimport('joomla.application.component.controller');

JTable::addIncludePath(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_attendance' . DS . 'tables');
/**
 * Import Controller
 *
 * Importing a file follows this process:
 * 1. controllers/importfile.php -> importFile
 * 2. models/importfile.php -> prepareImport (sets session values)
 * 3. views/importfile/view.html.php -> display
 * 4. views/importfile/tmpl/default.php JS calls import
 * 5. controllers/importfile.json.php -> doImport
 * 6. models/importfile.php -> getDoImport (sets session values)
 * 7. views/importfile/view.json.php -> return result
 *
 * @package CSVI
 */
class attendanceControllerCreateResponses extends JControllerLegacy {
	private $task_var = 'process';
	public function process() {
require_once JPATH_COMPONENT.'/helpers/attendance.php';
		$jinput = JFactory::getApplication() -> input;
		$list_view = $jinput -> get('list_view', '', 'string');

		switch ($this->task_var) {
			case 'response' :

				$rsvp_details = $jinput -> get('rsvp_details', Array(), 'array');
				$rsvp_reason = $jinput -> get('rsvp_reason', Array(), 'array');
				$rsvp_event = $jinput -> get('rsvp_event', Array(), 'array');
				$rsvp_user = $jinput -> get('rsvp_user', Array(), 'array');
				$rsvp_status = $jinput -> get('rsvp_status', Array(), 'array');
				$event_user = $jinput -> get('event_user', Array(), 'array');
				$event_active = $jinput -> get('rsvp_active', Array(), 'array');
				$rsvp_status_old = $jinput -> get('rsvp_status_old', Array(), 'array');
				$rsvp_details_old = $jinput -> get('rsvp_details_old', Array(), 'array');
				$rsvp_reason_old = $jinput -> get('rsvp_reason_old', Array(), 'array');

				foreach ($event_active as $key => $val) {
					$no_change = ((intval($rsvp_status_old[$key]) == intval($rsvp_status[$key])) && (intval($rsvp_reason_old[$key]) == intval($rsvp_reason[$key])) && (intval($rsvp_details_old[$key]) == intval($rsvp_details[$key]))) ? 1 : 0;
					$default_record = $rsvp_status[$key] == -2 ? 1 : 0;
					if (!$no_change && !$default_record) {
						$submitted_responses[] = array('rsvp_details' => $rsvp_status[$key] == '1' ? '' : $rsvp_details[$key], 'rsvp_reason' => $rsvp_status[$key] == '1' ? '' : $rsvp_reason[$key], 'rsvp_event' => $rsvp_event[$key], 'rsvp_user' => $rsvp_user[$key], 'rsvp_status' => $rsvp_status[$key], 'event_user' => $event_user[$key], 'rsvp_details_old' => $rsvp_details_old[$key], 'rsvp_reason_old' => $rsvp_reason_old[$key], 'rsvp_status_old' => $rsvp_status_old[$key], 'rsvp_active' => 1, 'rsvp_updated_by' => JFactory::getUser() -> id, 'id' => '');
					}
					//
					//var_dump($no_change);
					//var_dump($rsvp_status_old [$key] == $rsvp_status [$key]);
					//var_dump($rsvp_reason_old [$key] == $rsvp_reason [$key]);
					//var_dump($rsvp_details_old [$key] == $rsvp_details [$key]);
				}		$this -> make_updates($submitted_responses, 'event_user', false, true, $list_view);
				break;


		case 'approve' :

		case 'reject' :


				$rsvp_id = $jinput -> get('rsvp_id', Array(), 'array');
				foreach ($rsvp_id as $key => $val) {
					$review_status = attendanceHelper::reviewlist($this->task_var) ;
					$items[] = Array('id' => $rsvp_id[$key]
					, 'rsvp_review_status' => $review_status[0]->id
					, 'rsvp_date_reviewed' => date('Y-m-d H:i:s')
					, 'rsvp_reviewed_by_user' => JFactory::getUser() -> id);
				}
				$this -> make_updates($items, 'id', false, false, $list_view);
				break;
		}
	}

	public function make_updates($items, $keyItem, $updateNulls, $createOnly, $list_view) {
		$table = &$this -> getTable();
		foreach ($items as $item) {
			if (!$table -> bind($item)) {
				JError::raiseWarning(500, $table -> getError());
			}
			if (!$table -> store($item[$keyItem], $updateNulls, $createOnly)) {
				JError::raiseError(500, $table -> getError());
			}
		}
		$redirect_name = $list_view == 'admin' ? 'ResponsesForItem' : 'UnkResponses';
		$view = $this -> getView($redirect_name, 'html', 'attendanceView');
		$model = $this -> getModel($redirect_name, 'attendanceModel', array());
		$view -> setModel($model, true);
		$view -> display();
	}

	public function execute($task) {

		list($task, $task_var) = explode('_', $task);
		$this -> task_var = $task_var;

		parent::execute($task);
	}

	public function getTable($type = 'responses', $prefix = 'attendanceTable', $config = array()) {
		$table = JTable::getInstance($type, $prefix, $config);
		return $table;
	}

}
?>
