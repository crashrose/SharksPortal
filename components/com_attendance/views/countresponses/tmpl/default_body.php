<?php
// No direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted Access' );

foreach ( $this->items as $i => $item ) :
	?>
		<?php
		$item_display = $item->group_type == 'event_date'?
		date("D. M j, Y",strtotime($item->group_name)) 
		: $item->group_name;
		 ?>
<tr class="attrow<?php echo $i % 2; ?>">
<!-- Group Value Name -->
	<td><a href="<?php echo JRoute::_('index.php?option=com_attendance&view=countresponses&group_val='.$item->group_val.'&val_type='.$item->group_type); ?>">
	<?php echo $item_display; ?></a>
	</td>
<!-- 	RSVP None -->
	<td>
		<?php echo $item->rsvp_none;?>
	</td>
<!-- 	RSVP Yes -->
	<td>
		<?php echo $item->rsvp_yes;?>
	</td>
<!-- 	RSVP No -->
	<td>
		<?php echo $item->rsvp_no;?>
	</td>
<!-- 	RSVP Total -->
	<td>
		<?php echo $item->rsvp_unsure;?>
	</td>
<!-- 	RSVP Total Events -->
	<td>
		<?php echo $item->total_events;?>
	</td>
</tr>
<?php endforeach; ?>