<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
?>
<form action="<?php echo JRoute::_('index.php?option=com_attendance&view=response&layout=edit&id='. $this->item->id); ?>"
      method="post" name="adminForm" id="adminForm">
        <fieldset class="adminform">
                <?php echo JText::_('Attendance Details for '.$this->eng_vals['event_name']);
                echo '<BR>';
				echo "Event Date/Time"; 
				echo $this->eng_vals['event_date'] . ' ' . $this->eng_vals['event_time'];
				echo '<BR>';
				echo "Event Location"; 
				echo $this->eng_vals['event_location']; 
				echo '<BR>';				
// 				echo $this->form->getLabel('rsvp_status'); 
				echo $this->form->getInput('rsvp_status'); 
				echo '<BR>';
				echo $this->form->getLabel('rsvp_reason_id'); ?>
				<?php echo $this->form->getInput('rsvp_reason_id'); ?>
<BR>
				<?php echo $this->form->getLabel('rsvp_details'); ?>
				<?php echo $this->form->getInput('rsvp_details'); ?>
<BR>
				<?php echo $this->form->getLabel('rsvp_date_submitted'); ?>
				<?php echo $this->form->getInput('rsvp_date_submitted'); ?>
                </ul>
        </fieldset>
        <div>
                <input type="hidden" name="task" value="" />
                <?php echo JHtml::_('form.token'); ?>
        </div>
</form>
