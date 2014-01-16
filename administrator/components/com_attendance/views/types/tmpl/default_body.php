<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<?php foreach($this->items as $i => $item): ?>
        <tr class="row<?php echo $i % 2; ?>">
		        <td>
                        <?php echo JHtml::_('grid.id', $i, $item->id); ?>
                </td>
                <td>
				<a href="<?php echo JRoute::_('index.php?option=com_attendance&view=type&task=type.edit&id='.(int) $item->id); ?>">
							<?php echo $item->event_type_name; ?></a>
                </td>
        </tr>
<?php endforeach; ?>