<?php
// No direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted Access' );

foreach ( $this->items as $i => $item ) :
$item->has_response= $item->rsvp_status>-1?1:0;
	$item->id = $item->event_id . '_' . $item->user_id;
	echo '<input type="hidden" name="list_view" default="user" value="user"/>';

	$item->loc_html = $item->loc_maplink!=''
	?'<a href="'.$item->loc_maplink.'" target="_blank">'.$item->loc_name.'</a>'
	:$item->loc_name;

	?>
<!-- Attendance User -->
<tr class="attrow<?php echo $i % 2; ?>">
	<td>
		<h3>
		<?php echo $item->user_name ;?>
		<input type="hidden" name="user_id[]" default="<?php echo $item->user_id ;?>" value="<?php echo $item->user_id ;?>"/>
		</h3>
	</td>
<!-- 	Attendance Status -->
	<td>
        <?php echo AttendanceHelper::Att_yes_no_box ( $i, $item->id, $item->attended_status);?>
    </td>
<!--    Attendance Arrival Time -->
	<td>
		<input type="text" name="time_arrived[]" default="<?php echo $item->time_arrived;?>" value="<?php echo $item->time_arrived;?>"/>
	</td>
</tr>
<?php endforeach; ?>