<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>

<tr> 
        <th colspan="3">
                <?php echo JText::_('Event Details'); ?>
        </th>               

        <th>
                <?php echo JText::_('Attending?'); ?>
        </th>
        <th>
                <?php echo JText::_('RSVP Notes'); ?>
        </th>
</tr>
<tr> 
        <th style="font-size:.7em">
                <?php echo JHTML::_( 'grid.sort', 'Date Sort', 'event_date', $this->sortDirection, $this->sortColumn); ?>
        </th>               
        <th style="font-size:.7em">
                <?php echo JHTML::_( 'grid.sort', 'Event Sort', 'type.event_type_name', $this->sortDirection, $this->sortColumn); ?>
        </th>    
        <th style="font-size:.7em">
                <?php echo JHTML::_( 'grid.sort', 'Location Sort', 'loc.loc_name', $this->sortDirection, $this->sortColumn); ?>
        </th>    

        <th style="font-size:.8em">Yes to All:
                <input type="radio" name="toggle" value="1" onclick="rsvp_all_yes()" />
        </th>
        <th width="300" style="font-size:.8em">
                <?php echo JText::_('Reason and Explanation'); ?>
        </th>

</tr>
