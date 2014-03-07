<?php
// No direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted Access' );

foreach($this->items as $i => $item): ?><tr class="row<?php echo $i % 2; ?>">	<td>		<?php echo JHtml::_('grid.id', $i, $item->id); ?>	</td>	<td>
		<a href="<?php echo JRoute::_('index.php?option=com_attendance&view=location&task=location.edit&id='.(int) $item->id); ?>">			<?php echo $item->loc_name; ?>
		</a>
	</td>	<td>		<?php echo $item->loc_address_1; ?>	</td>	<td>		<?php echo $item->loc_address_2; ?>	</td>	<td>		<?php echo $item->loc_city; ?>	</td>	<td>		<?php echo $item->loc_state; ?>
	</td>	<td>
		<?php echo $item->loc_zip; ?>	</td>	<td>		<?php echo $item->loc_country; ?>	</td>	<td>		<?php echo $item->loc_phone; ?>	</td>	<td>		<?php echo $item->loc_note; ?>	</td>	<td>		<?php echo $item->loc_website; ?>	</td>	<td>		<?php echo $item->loc_maplink; ?>	</td></tr><?php endforeach; ?>