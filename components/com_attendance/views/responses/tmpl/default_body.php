<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<?php foreach($this->items as $i => $item): ?>
        <tr class="row<?php echo $i % 2; ?>">
		        <td>
                       <?php echo $item->event_name; ?>
                </td>
                <td>
				<?php echo $item->rsvp_reason; ?>
                </td>
                <td>
                     
                </td>
				<td>
					<?php echo $item->event_id; ?>
                </td>
                <td>
                       <?php echo $item->rsvp_user_name; ?>
                </td>
                <td>
                       <?php echo $item->event_id; ?>
                </td>
                <td>
                     <td>
				<a href="<?php echo JRoute::_('index.php?option=com_attendance&view=response&id='.$item->id); ?>">
							Edit</a>
                </td>
        </tr>
<?php endforeach; ?>