<?php
// No direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted Access' );

foreach ( $this->items as $i => $item ) :
$item->has_response= $item->rsvp_status>-1?1:0;
	$item->id = $item->event_id . '_' . $item->user_id;
	$item->respond_by = date("n/j/Y",strtotime($item->event_respond_by)) == '1/1/1970'?$item->event_date:$item->event_respond_by;
	$item->expired = $item->event_respond_by > 1 && $item->event_respond_by < date ( "Y-m-d H:i:s" ) ? ' disabled ' : '';
	echo '<input type="hidden" name="list_view" default="user" value="user"/>';
	echo '<input type="hidden" name="event_user[]" default=' . $item->id . ' value="' . $item->id . '" />';
	echo '<input type="hidden" name="rsvp_event[]" default=' . $item->event_id . ' value="' . $item->event_id . '" />';
	echo '<input type="hidden" name="rsvp_user[]" default=' . $item->user_id . ' value="' . $item->user_id . '" />';
	echo '<input type="hidden" name="rsvp_active[]" default="1" value="1" />';
	echo '<input type="hidden" name="rsvp_status_old[]" default=' . $item->rsvp_status . ' value="' . $item->rsvp_status . '" />';
	echo '<input type="hidden" name="rsvp_reason_old[]" default=' . $item->rsvp_reason . ' value="' . $item->rsvp_reason . '" />';
	echo '<input type="hidden" name="rsvp_details_old[]" default=' . $item->rsvp_details . ' value="' . $item->rsvp_details . '" />';
	$item->loc_html = $item->loc_maplink!=''
	?'<a href="'.$item->loc_maplink.'" target="_blank">'.$item->loc_name.'</a>'
	:$item->loc_name;

	?>
<!-- RSVP Event Header: Date Time -->
<tr class="attrow<?php echo $i % 2; ?>">
	<td colspan="3" class="rsvp_head rsvp_top"><h3>
		<?php echo
		'<a href="'.JRoute::_('index.php?option=com_attendance&view=ResponseDetails&list_view=user&id='.$item->rsvp_id.'&event_user='.$item->event_user).'">'
		. date("D. M j, ",strtotime($item->event_date)) . ' ' . date("g:ia", strtotime($item->event_time)) .'</a>';?>
	</h3><?php
	echo $item->has_response==0
		? '<p class="atturgent">Respond by: '. date("n/j/Y",strtotime($item->respond_by))
		: '<p class="attnormal">You responded on '. date("n/j/Y",strtotime($item->rsvp_date_submitted))
		;?>
<!-- 	RSVP Response Status -->
	<td rowspan="2" class="rsvp_yn rsvp_top rsvp_bottom">
		<h3 style="padding-bottom:4px">Response:</h3>
        <?php echo AttendanceHelper::yes_no_box ( $i, $item->id, $item->rsvp_status, $item->expired );?>

    </td>
<!--     RSVP Details (Reason/Explanation) -->
	<td rowspan="2" class="rsvp_details rsvp_top rsvp_bottom">
		<?php
		$yes_class = $item->expired == '' ? ' class="att_yesable_div" ' : '';
		$div_id = "rsvp_details_" . $item->id. '" ';
		$rsvp_details_pane = '';
		switch ($item->rsvp_status) {
			case 1 :
				$rsvp_details_pane = ' style="display:none;" ';
				$required='';
				break;
			case null :
				$rsvp_details_pane = ' style="display:none;" ';
				$required='';
				break;
			case 0 :
				$rsvp_details_pane = ' style="display:block;" ';
				$required=' required ';
				break;
			case - 1 :
				$rsvp_details_pane = ' style="display:block;" ';
				$required='';
				break;
			default :
				$rsvp_details_pane = ' style="display:none;" ';
				$required='';
				break;
		}
		echo '<div width="100%" id="' . $div_id . $yes_class . $rsvp_details_pane . '><div class="rsvp_details" style="float: left;">';
		echo "<h3>Select reason:</h3>";
		echo AttendanceHelper::RSVP_reason ( $item->id, $item->rsvp_reason, $item->expired, $required );

		echo '</div><div class="rsvp_details" style="float: right;"><h3>Explain:</h3>';
		echo AttendanceHelper::RSVP_details ( $item->id, $item->rsvp_details, $item->expired, $required );
		echo "</div></div>";
		?>
	</td>
	<tr class="attrow<?php echo $i % 2; ?>">
<!-- 	RSVP Event Type -->
		<td class="rsvp_type rsvp_bottom">
			<h3>Event:</h3>
			<?php echo $item->event_type;?>
	    </td>
<!-- 	    RSVP Event Location -->
		<td colspan="2" class="rsvp_loc rsvp_bottom">
			<h3>Location:</h3>
			<?php
                echo '<span class="hasTip" title="'.AttendanceHelper::location_tooltip ($item).'">'.$item->loc_html.'</span>';
            ?>

		</td>
	</tr>
</tr>
<?php endforeach; ?>