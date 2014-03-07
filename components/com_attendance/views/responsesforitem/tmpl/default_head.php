<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
	<?php
		echo '<BR>Showing responses for:<BR><h2>' . $this -> FilterName.'</h2>';
		echo ' <a href="' . JRoute::_('index.php?option=com_attendance&view=countresponses') . '">Clear</a>';
	?>
<tr>
	<th width="200"style="font-size:.9em"><?php echo JHTML::_('grid.sort', $this -> ItemType, 'item_order', $this -> sortDirection, $this -> sortColumn); ?></th>

	<th width="80"><?php echo JHTML::_('grid.sort', 'Response', 'item_status', $this -> sortDirection, $this -> sortColumn); ?></th>
	<th width="90"><?php echo JHTML::_('grid.sort', 'Reason', 'reason', $this -> sortDirection, $this -> sortColumn); ?></th>
	<th >Details</th>
	<th width="120"><?php echo JHTML::_('grid.sort', 'Approval Status', 'approval_status', $this -> sortDirection, $this -> sortColumn); ?></th>

</tr>