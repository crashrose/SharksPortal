<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_attendance
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die();
jimport('joomla.form.helper');
/**
 *
 * @package Joomla.Site
 * @subpackage com_attendance
 */
class attendanceHelper {
    public static function yes_no_box($i, $id, $status, $disabled) {
        $yes_class = $disabled == '' ? ' class="att_yes_radio" ' : '';
        switch ($status) {
            case null :
                $yes_checked = "";
                $no_checked = "";
                $unsure_checked = "checked";
                break;
            case 0 :
                $yes_checked = "";
                $no_checked = "checked";
                $unsure_checked = "";
                break;
            case 1 :
                $yes_checked = "checked";
                $no_checked = "";
                $unsure_checked = "";
                break;
            case -1 :
                $yes_checked = "";
                $no_checked = "";
                $unsure_checked = "checked";
                break;
            default :
                $yes_checked = "";
                $no_checked = "";
                $unsure_checked = "checked";
                break;
        }
        $lines = array('<input  ' . $disabled . $yes_class . 'name="rsvp_status[' . $i . ']"' . $yes_checked . ' type="radio" id="status_' . $id . '_Y" value="1" onclick="$(\'rsvp_details_' . $id . '\' ).hide();$(\'rsvp_expl_' . $id . '\' ).removeClass(\'required\');$(\'rsvp_reason_' . $id . '\' ).removeClass(\'required\');">Yes', '<BR><input  ' . $disabled . ' name="rsvp_status[' . $i . ']"' . $no_checked . ' type="radio" id="status_' . $id . '_N" value="0" onclick="$(\'rsvp_details_' . $id . '\' ).show();$(\'rsvp_expl_' . $id . '\' ).addClass(\'required\');$(\'rsvp_reason_' . $id . '\' ).addClass(\'required\');">No', '<BR><input  ' . $disabled . ' name="rsvp_status[' . $i . ']"' . $unsure_checked . ' type="radio" id="status_' . $id . '_U" value="-1" onclick="$(\'rsvp_details_' . $id . '\' ).show();$(\'rsvp_expl_' . $id . '\' ).removeClass(\'required\');$(\'rsvp_reason_' . $id . '\' ).removeClass(\'required\');">Unsure', );
        $lines = implode("\n", $lines);
        $lines = $disabled ? $lines . '<input type="hidden" name="rsvp_status[]" default=' . $status . ' value="' . $status . '" />' : $lines;

        return $lines;
    }

    public static function RSVP_reason($id, $rsvp_reason, $disabled, $required) {
        // Create the batch selector to change the client on a selection list.
        $yes_class = $disabled == '' ? ' att_yesable ' : '';
        $lines = array('<select ' . $disabled . ' name="rsvp_reason[]" class="att_reason inputbox ' . $yes_class . $required . '" id="rsvp_reason_' . $id . '">', '<option value="0"> - Reason - </option>', JHtml::_('select.options', self::reasonlist(), 'value', 'rsvp_reason', $rsvp_reason), '</select>');
        $lines = implode("\n", $lines);
        $lines = $disabled ? $lines . '<input type="hidden" name="rsvp_reason[]" default=' . $rsvp_reason . ' value="' . $rsvp_reason . '" />' : $lines;

        return $lines;
    }

    public static function reasonlist() {
        $db = JFactory::getDbo();
        $query = $db -> getQuery(true);

        $query -> select('id As value, reason_name as rsvp_reason');
        $query -> from('#__sched_rsvp_reasons');
        $query -> order('reason_name');

        // Get the options.
        $db -> setQuery($query);

        $options = $db -> loadObjectList();

        // Check for a database error.
        if ($db -> getErrorNum()) {
            JError::raiseWarning(500, $db -> getErrorMsg());
        }

        return $options;
    }

    public static function RSVP_details($id, $rsvp_details, $disabled, $required) {
        $yes_class = $disabled == '' ? ' att_yesable ' : '';
        $lines = '<textarea  class="att_details ' . $required . $yes_class . '" ' . $disabled . ' rows="3" cols="18" name="rsvp_details[]" id="rsvp_expl_' . $id . '" />' . $rsvp_details . '</textarea>';
        $lines = $disabled ? $lines . '<input type="hidden" name="rsvp_details[]" default=' . $rsvp_details . ' value="' . $rsvp_details . '" />' : $lines;
        return $lines;
    }

    public static function getEvents() {
        // Initialize variables.
        $options = array();

        $db = JFactory::getDbo();
        $query = $db -> getQuery(true);

        $query -> select('id As value, event_name as text');
        $query -> from('#__sched_events AS a');
        $query -> order('a.event_name');

        // Get the options.
        $db -> setQuery($query);

        $options = $db -> loadObjectList();

        // Check for a database error.
        if ($db -> getErrorNum()) {
            JError::raiseWarning(500, $db -> getErrorMsg());
        }

        // Merge any additional options in the XML definition.
        // $options = array_merge(parent::getOptions(), $options);

        // array_unshift($options, JHtml::_('select.option', '0', JText::_('COM_BANNERS_NO_CLIENT')));
        return $options;
    }

    public static function getEventDetails($event_id) {
        // Initialize variables.
        $options = array();

        $db = JFactory::getDBO();
        $query = $db -> getQuery(true);
        // Select some fields
        $query -> select('event.event_name as event_name,event.event_date, time.time_val as event_time,type.event_type_name as event_type,loc.loc_name as event_location,owner.name as event_owner, event.event_respond_by as event_respond_by');
        // From the schedule views table
        $query -> from('#__sched_events AS event');
        $query -> join('INNER', '#__sched_locations loc ON event.event_location = loc.id');
        $query -> join('INNER', '#__users owner ON event.event_owner = owner.id');
        $query -> join('INNER', '#__sched_event_types type ON event.event_type = type.id');
        $query -> join('INNER', '#__sched_times time ON event.event_time = time.id');
        $query -> where('event.id = ' . (int)$event_id);
        $db -> setQuery($query);

        $options = $db -> loadAssocList();

        // Check for a database error.
        if ($db -> getErrorNum()) {
            JError::raiseWarning(500, $db -> getErrorMsg());
        }

        return $options[0];
    }

    public static function response_list_options($state) {
        switch ($state) {
            case null :
                $ALL_checked = "";
                $OUT_checked = "checked";
                $CMPL_checked = "";
                break;
            case "ALL" :
                $ALL_checked = "checked";
                $OUT_checked = "";
                $CMPL_checked = "";
                break;
            case "OUTSTANDING" :
                $ALL_checked = "";
                $OUT_checked = "checked";
                $CMPL_checked = "";
                break;
            case "COMPLETE" :
                $ALL_checked = "";
                $OUT_checked = "";
                $CMPL_checked = "checked";
                break;
            default :
                $ALL_checked = "";
                $OUT_checked = "checked";
                $CMPL_checked = "";
                break;
        }
        $lines = array('<input name="filter_response_complete"' . $ALL_checked . ' type="radio"  value="ALL" onchange="this.form.submit()">Show ALL events', '<BR><input name="filter_response_complete"' . $OUT_checked . ' type="radio" value="OUTSTANDING" onchange="this.form.submit()">Show only events you haven\'t responsed to (including "unsure" responses).', '<BR><input name="filter_response_complete"' . $CMPL_checked . ' type="radio" value="COMPLETE" onchange="this.form.submit()">Show only events you have responded to.', );
        return implode("\n", $lines);
    }

    public static function reporting_group_by($current_grouping) {
        // Create the batch selector to change the client on a selection list.
        $user_checked = '';
        $event_checked = '';
        $user_checked = $current_grouping == '' || $current_grouping == 'user_id' ? ' selected ' : '';
        $event_checked = $current_grouping == 'event_date' ? ' selected ' : '';
        $lines = array('<select name="list_groupby" class="inputbox" class="inputbox" onchange="this.form.submit()">', '<option ' . $user_checked . ' value="user_id">User Name</option>', '<option ' . $event_checked . 'value="event_date">Event Date</option>', '</select>');
        return implode("\n", $lines);
    }

    public static function report_compl_filter($state) {
        switch ($state) {
            case null :
                $ALL_checked = "";
                $OUT_checked = "checked";
                $CMPL_checked = "";
                break;
            case "ALL" :
                $ALL_checked = "checked";
                $OUT_checked = "";
                $CMPL_checked = "";
                break;
            case "OUTSTANDING" :
                $ALL_checked = "";
                $OUT_checked = "checked";
                $CMPL_checked = "";
                break;
            default :
                $ALL_checked = "";
                $OUT_checked = "checked";
                $CMPL_checked = "";
                break;
        }
        $lines = array('Show: <input name="filter_cmpl"' . $ALL_checked . ' type="radio"  value="ALL" onchange="this.form.submit()">All ', '<input name="filter_cmpl"' . $OUT_checked . ' type="radio" value="OUTSTANDING" onchange="this.form.submit()">Outstanding/Unsure', );
        return implode("\n", $lines);
    }

    public static function outstanding_for_user() {
        $user = JFactory::getUser();
        $db = JFactory::getDBO();
        $subquery = $db -> getQuery(true);
        $query = $db -> getQuery(true);
        $subquery -> select('distinct event.event_name');
        $subquery -> from('#__sched_events event');
        $subquery -> join('INNER', '#__sched_event_mand_grps event_grps on event.id = event_grps.event_id');
        $subquery -> join('INNER', '#__user_usergroup_map users_grps on event_grps.group_id = users_grps.group_id');
        $subquery -> join('INNER', '#__users user on user.id = users_grps.user_id');
        $subquery -> join('LEFT OUTER', '#__sched_responses responses on (responses.rsvp_user = user.id and responses.rsvp_event = event.id)');
        $subquery -> where('event.event_date > now()');
        $subquery -> where('user.id = ' . $user -> id . ' AND ( responses.id is null OR (rsvp_active=1 and rsvp_status=-1))');
        $query -> select('count(*) as count');
        $query -> from('(' . $subquery . ') responses');
        $db -> setQuery($query);
        $results = $db -> loadObjectList();
        //var_dump($results);
        // 				$items[0]->filtered_val
        return $results[0] -> count;
    }

    public static function location_tooltip($item){
        $tooltip_text = $item->name.'::';
        $tooltip_text .= $item->loc_address_1.'<BR>';
        $tooltip_text .= $item->loc_address_2==''? '' : $item->loc_address_2.'<BR>';
        $tooltip_text .= $item->loc_city==''? '' : $item->loc_city. ', ';
        $tooltip_text .= $item->loc_state==''? '' : $item->loc_state;
        $tooltip_text .= $item->loc_zip==0? '' : ' ' . $item->loc_zip. '<BR>';
        $tooltip_text .= $item->loc_website==''? '' : '<BR>Website: '.$item->loc_website;
        $tooltip_text .= $item->loc_note==''? '' : '<BR>Note: '.$item->loc_note;
           return $tooltip_text;
    }
}
