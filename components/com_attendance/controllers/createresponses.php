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
defined ( '_JEXEC' ) or die ( 'Direct Access to this location is not allowed.' );

jimport ( 'joomla.application.component.controller' );
JTable::addIncludePath ( JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_attendance' . DS . 'tables' );

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
	public function process() {
		$jinput = JFactory::getApplication ()->input;
		$rsvp_details = $jinput->get ( 'rsvp_details', Array (), 'array' );
		$rsvp_reason = $jinput->get ( 'rsvp_reason', Array (), 'array' );
		$rsvp_event = $jinput->get ( 'rsvp_event', Array (), 'array' );
		$rsvp_user = $jinput->get ( 'rsvp_user', Array (), 'array' );
		$rsvp_status = $jinput->get ( 'rsvp_status', Array (), 'array' );
		$event_user = $jinput->get ( 'event_user', Array (), 'array' );
		$event_active = $jinput->get ( 'rsvp_active', Array (), 'array' );
		$rsvp_status_old = $jinput->get ( 'rsvp_status_old', Array (), 'array' );
		$rsvp_details_old = $jinput->get ( 'rsvp_details_old', Array (), 'array' );
		$rsvp_reason_old = $jinput->get ( 'rsvp_reason_old', Array (), 'array' );
// 		var_dump($jinput);
		foreach ( $event_active as $key => $val ) {
			$submitted_response [] = array (
					'rsvp_details' => $rsvp_details [$key],
					'rsvp_reason' => $rsvp_reason [$key],
					'rsvp_event' => $rsvp_event [$key],
					'rsvp_user' => $rsvp_user [$key],
					'rsvp_status' => $rsvp_status [$key],
					'event_user' => $event_user [$key],
					'rsvp_details_old' => $rsvp_details_old [$key],
					'rsvp_reason_old' => $rsvp_reason_old [$key],
					'rsvp_status_old' => $rsvp_status_old [$key],
					'rsvp_active' => 1,
					'id' => ''
			);

		}



		$table = & $this->getTable ();
		foreach ( $submitted_response as $item ) {
			$item ['rsvp_reason'] = $item ['rsvp_status']== "1"?'0':$item ['rsvp_reason'];
			$item ['rsvp_details'] = $item ['rsvp_status']== "1"?'': $item ['rsvp_details'];
			$keyArray = Array('rsvp_event'=>$item['rsvp_event'], 'rsvp_user'=>$item['rsvp_user']);
// 			dump ($item ['rsvp_status']) ;
			$no_change = (($item ['rsvp_status_old'] == $item ['rsvp_status'])
					&& ($item ['rsvp_reason_old'] == $item ['rsvp_reason'])
					&& ($item ['rsvp_details_old'] == $item ['rsvp_details']))
					? 1 : 0;
// 			echo $item ['rsvp_status_old'] .' : '. $item ['rsvp_status'] . '<BR>';
// 			echo $item ['rsvp_reason_old'] .' : '. $item ['rsvp_reason'] . '<BR>';
// 			echo $item ['rsvp_details_old'] .' : '. $item ['rsvp_details'] . '<BR>';
			$default_record = $item ['rsvp_status_old'] =='' && $item ['rsvp_reason']==0 && $item ['rsvp_details']==''&& $item ['rsvp_status']=="-1"?1:0;
// 			echo 'record: ' .$item ['rsvp_event'] . 'no change: '. $no_change . '<BR> $default_record: ' . $default_record . '<BR>----<BR>';
			if (!$no_change && !$default_record)
			{
				if (! $table->bind ( $item )) {
					JError::raiseWarning ( 500, $table->getError () );
				}
				if (! $table->store($keyArray, true )) {
					JError::raiseError ( 500, $table->getError () );
				}
			}
		}
		$view = $this->getView ( 'unkResponses', 'html', 'attendanceView' );
		$model = $this->getModel ( 'unkResponses', 'attendanceModel', array () );
		$view->setModel ( $model, true );
		$view->display ();
	}
	public function getTable($type = 'responses', $prefix = 'attendanceTable', $config = array()) {
		$table = JTable::getInstance ( $type, $prefix, $config );
		return $table;
	}

}

?>
