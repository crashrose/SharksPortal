<?php
// No direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted Access' );

foreach ( $this->items as $i => $item ) :
$item_display = //$item->rsvp_status=='0'?
'<a href="'.JRoute::_('index.php?option=com_attendance&view=ResponseDetails&list_view=admin&id='.$item->rsvp_id.'&event_user='.$item->event_user).'">'.$item->item_val.'</a>'
//:
//$item->item_val
;


?>

<tr class="attrow<?php echo $i % 2; ?>">
	<!-- Item Name -->
	<td><?php echo $item_display; ?></td>
	<!-- 	RSVP Status -->
	<td><?php echo $item -> item_status; ?></td>
	<!-- 	Response Reason -->
	<td><?php echo $item -> reason; ?></td>
	<!-- 	Response Details -->
	<td><?php echo $item -> details; ?></td>
	<!-- 	Approval Status -->
	<td><?php echo $item -> approval_status; ?></td>
</tr>
<?php endforeach; ?>