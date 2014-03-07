<?php
// No direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted Access' );

foreach($this->items as $i => $item):
?>
<tr class="row<?php echo $i % 2; ?>">
	<td>		<?php echo JHtml::_('grid.id', $i, $item->id); ?>	</td>	<td>
		<a href="<?php echo JRoute::_('index.php?option=com_attendance&view=event&task=event.edit&id='.(int) $item->id); ?>">		<?php echo $item->event_name; ?>
		</a>
	</td>	<td>		<?php echo $item->event_date . ' ' . $item->event_time; ?>	</td>	<td>		<?php echo $item->event_type; ?>
	</td>	<td>		<?php echo $item->event_location; ?>	</td>	<td>		<?php echo $item->event_owner; ?>	</td></tr><?php endforeach; ?>