<?php// No direct access to this filedefined ( '_JEXEC' ) or die ( 'Restricted Access' );// Load the tooltip behavior.JHtml::_ ( 'behavior.framework' );JHtml::_ ( 'behavior.tooltip' );JHtml::_ ( 'behavior.formvalidation' );$document = JFactory::getDocument();$document->addStyleSheet('components/com_attendance/css/attendance.css');JHtml::script(Juri::base() . '/components/com_attendance/views/unkresponses/submitbutton.js', $mootools);		$user = JFactory::getUser();		$edit_all = $user->authorise('attendance.edit_all', 'com_attendance');		$edit_own = $user->authorise('attendance.edit_own', 'com_attendance');		$view_all = $user->authorise('attendance.view_all', 'com_attendance');		$edit_this = ($edit_all || ($edit_own && $user->id == $this->item->user_id ))?1:0;		$approve_this = $user->authorise('attendance.approver', 'com_attendance');		$div_id = "rsvp_details_" . $this->item->event_user. '" ';		$rsvp_details_pane = '';		switch ($this->item->rsvp_status) {			case 1 :				$rsvp_details_pane = ' style="display:none;" ';				$required='';				break;			case '' :				$rsvp_details_pane = ' style="display:none;" ';				$required='';				break;			case 0 :				$rsvp_details_pane = ' style="display:block;" ';				$required=' required ';				break;			case - 1 :				$rsvp_details_pane = ' style="display:block;" ';				$required='';				break;			default :				$rsvp_details_pane = ' style="display:none;" ';				$required='';				break;		}echo '<form action="' . JRoute::_('index.php?option=com_attendance&view=responsedetails') . '" method="post" name="adminForm" id="adminForm" class="form-validate">	';	?>	<h2>Response Details</h2>		<table>			<tr>				<td width="140">User: </td>				<td><?php echo $this -> item -> user_name; ?></td>			</tr>			<tr>				<td>Event: </td>				<td><?php echo $this -> item -> event_type . ' on ' . $this -> item -> event_dt; ?></td>			</tr>			<tr>				<td>Response: </td>				<td> <?php				$disabled = ($this->item->event_respond_by > 1 && ($this->item->event_respond_by < date ( "Y-m-d H:i:s" ) || $this->item->event_date < date ( "Y-m-d H:i:s" )) || !$edit_this)? ' disabled ' : '';				echo AttendanceHelper::yes_no_box ( '', $this->item->event_user, $this->item->rsvp_status, $disabled);				if (!$approve_this) {echo '<input type="hidden" class="required" id="response_required" value=""/>';}				?> </td>			</tr>			<tr><td colspan="2"><?php		echo '<div width="100%" id="' . $div_id . $yes_class . $rsvp_details_pane . '>';		echo '<table><tr><td width="130">Reason: </td><td>';		echo !$edit_this?$this->item->reason_name:AttendanceHelper::RSVP_reason ( $this->item->event_user, $this->item->rsvp_reason, $disabled, $required );		echo '</td></tr><td>Explanation: </td><td>';		echo AttendanceHelper::RSVP_details ( $this->item->event_user, $this->item->rsvp_details, $disabled, $required );		echo '</td></tr></table></div>';?>			</td></tr>			<tr>				<td>Response Submitted: </td>				<?php $date_submitted = $this->item -> rsvp_date_submitted < 1? 'No Response Yet': date ( "n/j/y g:i:s A" , strtotime($this->item -> rsvp_date_submitted)); ?>				<td><?php echo $date_submitted; ?></td>			</tr>		<?php echo attendanceHelper::display_review_status($this->item, $approve_this) ?>		</table>	<div>	<input type="hidden" name="task" value="" />	<input type="hidden" name="event_user" value="<?php echo $this->item->event_user; ?>" />	<input type="hidden" name="rsvp_event" value="<?php echo $this->item->event_id; ?>" />	<input type="hidden" name="rsvp_user" value="<?php echo $this->item->user_id; ?>" />	<input type="hidden" name="rsvp_id" value="<?php echo $this->item->rsvp_id; ?>" />	<input type="hidden" name="rsvp_active" default="1" value="1" />	<input type="hidden" name="rsvp_status_old" value="<?php echo $this->item->rsvp_status ; ?>" />	<input type="hidden" name="rsvp_reason_old" value="<?php echo $this->item->rsvp_reason; ?>" />	<input type="hidden" name="rsvp_details_old" value="<?php echo $this->item->rsvp_details; ?>" />	<input type="hidden" name="list_view" value="<?php echo $this -> list_view; ?>" />	<input type="hidden" name="boxchecked" value="0" />	<input type="hidden" name="group_val" value="<?php echo $this -> groupFilterVal; ?>" />	<input type="hidden" name="val_type" value="<?php echo $this -> groupFilterType; ?>" />	<input type="hidden" name="filter_order" value="<?php echo $this -> sortColumn; ?>" />	<input type="hidden" name="filter_order_Dir" value="<?php echo $this -> sortDirection; ?>" />	<input type="hidden" name="filter_order" value="<?php echo $this -> sortColumn; ?>" />	<input type="hidden" name="filter_order_Dir" value="<?php echo $this -> sortDirection; ?>" />	<?php echo JHtml::_('form.token'); ?>	</div><?php if ($edit_this){				echo '<button type="button" class="validate" onclick="Joomla.submitbutton(\'createResponses.process_response\');">';            echo JText::_('Submit Response');        echo '</button>'; } ?>	<BR><BR><?php if($edit_all || $view_all){ ?>	<h3>History</h3>	<table>		<thead>			<th>Date</th><th>Response</th><th>Reason</th><th>Details</th>		</thead>		<?php		$hist_items = attendanceHelper::get_rsvp_history($this -> item -> event_user);		foreach ($hist_items as $hist_item) :			echo '		<tr>			<td>' . $hist_item['rsvp_date_submitted'] . '</td>			<td>' . $hist_item['rsvp_eng_status'] . '</td>			<td>' . $hist_item['reason'] . '</td>			<td>' . $hist_item['rsvp_details'] . '</td>		</tr>';		endforeach;		?>	</table><?php } ?></form>