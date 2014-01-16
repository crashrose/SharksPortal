<?php
/**
 * Visforms default view for Visforms
 *
 * @author       Aicha Vack
 * @see           visforms is extended and rivised adaptation of ckforms from cookex (http://www.cookex.eu) for Joomla 2.5
 * @package      Joomla.Administrator
 * @subpackage   com_visforms
 * @link         http://www.vi-solutions.de 
 * @license      GNU General Public License version 2 or later; see license.txt
 * @copyright    2012 vi-solutions
 * @since        Joomla 1.6 
 */

//no direct access
 defined('_JEXEC') or die('Restricted access'); 

$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
?>

<form action="<?php echo JRoute::_('index.php?option=com_visforms');?>" method="post" name="adminForm">
<fieldset id="filter-bar">
		<div class="filter-search fltlft">
			<label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
			<input type="text" name="filter_search" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_CONTENT_FILTER_SEARCH_DESC'); ?>" />

			<button type="submit" class="btn"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
			<button type="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
		</div>
<div class="filter-select fltrt">
	
	<select name="filter_published" class="inputbox" onchange="this.form.submit()">
		<option value=""><?php echo JText::_('JOPTION_SELECT_PUBLISHED');?></option>
		<?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions', array('trash'=>false, 'archived'=>false)), 'value', 'text', $this->state->get('filter.published'), true);?>
	</select>

	<select name="filter_language" class="inputbox" onchange="this.form.submit()">
		<option value=""><?php echo JText::_('JOPTION_SELECT_LANGUAGE');?></option>
		<?php echo JHtml::_('select.options', JHtml::_('contentlanguage.existing', true, true), 'value', 'text', $this->state->get('filter.language'));?>
	</select>
	
</div>	</fieldset>
	<div class="clr"> </div>

	<table class="adminlist">
	<thead>
		<tr>
			<th width="3%">
				<input type="checkbox" name="toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
			</th>			
			<th width="40%">
				<?php echo JHtml::_('grid.sort', 'COM_VISFORMS_TITLE', 'a.title', $listDirn, $listOrder); ?>
			</th>
            <th width="5%">
                <?php echo JHtml::_('grid.sort', 'COM_VISFORMS_PUBLISHED', 'a.published', $listDirn, $listOrder); ?>	
            </th>
			<th width="5%">
				<?php echo JHtml::_('grid.sort', 'COM_VISFORMS_FIELDS', 'nbfields', $listDirn, $listOrder); ?>
			</th>
			<th width="5%">
				<?php echo JHtml::_('grid.sort', 'COM_VISFORMS_AUTHOR', 'username', $listDirn, $listOrder); ?>
			</th>
			<th width="10%">
				<?php echo JHtml::_('grid.sort', 'COM_VISFORMS_DATE', 'a.created', $listDirn, $listOrder); ?>
			</th>
			<th width="15%">
				<?php echo JText::_( 'COM_VISFORMS_DATA' ); ?>
			</th>
			<th width="5%">
				<?php echo JHtml::_('grid.sort', 'COM_VISFORMS_HITS', 'a.hits', $listDirn, $listOrder); ?>
			</th>
			<th width="5%">
					<?php echo JHtml::_('grid.sort', 'JGRID_HEADING_LANGUAGE', 'language', $listDirn, $listOrder); ?>
				</th>
			<th width="3%" nowrap="nowrap">
				<?php echo JHtml::_('grid.sort', 'COM_VISFORMS_ID', 'a.id', $listDirn, $listOrder); ?>
			</th>
		</tr>			
	</thead>
	<?php
	$k = 0;
	$n=count( $this->items );
	for ($i=0; $i < $n; $i++)
	{
		$row = &$this->items[$i];
		$published	= JHTML::_('jgrid.published', $row->published, $i, 'visforms.', true );
		$checked 	= JHTML::_('grid.id',   $i, $row->id );
		$link 		= JRoute::_( 'index.php?option=com_visforms&task=visform.edit&cid[]='. $row->id );
		$fields		= JRoute::_( 'index.php?option=com_visforms&view=visfields&fid='. $row->id );
		$savedData 	= JRoute::_( 'index.php?option=com_visforms&task=visdata.display&fid='. $row->id );

		?>
			<td class="center">
				<?php echo $checked; ?>
			</td>
			<td>
				<a href="<?php echo $link; ?>"><?php echo $this->escape($row->title); ?></a>
				<p class="smallsub">
					<?php echo JText::sprintf('JGLOBAL_LIST_ALIAS', $this->escape($row->name));?>
				</p>
			</td>
            <td class="center">
                <?php echo $published;?>
            </td>
            <td class="center">
            	<a href="<?php echo $fields; ?>"><img src="<?php echo JURI::root(); ?>includes/js/ThemeOffice/mainmenu.png" border="0" /></a>
                &nbsp;
				<a href="<?php echo $fields; ?>"><?php echo $row->nbfields; ?></a>
            </td>
			<td class="center">
				<?php echo $this->escape($row->username); ?>
			</td>
			<td class="center">
				<?php //echo $row->created; 
				?>
				<?php echo JHtml::_('date', $row->created, JText::_('DATE_FORMAT_LC4')); ?>
			</td>
			<td class="center">
            <?php 
				if ($row->saveresult == '1')
				{
			?>
				<a href="<?php echo $savedData; ?>"><?php echo JText::_( 'COM_VISFORMS_DISPLAY_DATA' ); ?></a>
            <?php 
				} else {
			?>
            	&nbsp;
            <?php 
				}
			?>
			</td>			
           	<td class="center">
				<?php echo $row->hits; ?>
			</td>
			<td class="center">
					<?php if ($row->language=='*'):?>
						<?php echo JText::alt('JALL', 'language'); ?>
					<?php else:?>
						<?php echo $row->language_title ? $this->escape($row->language_title) : JText::_('JUNDEFINED'); ?>
					<?php endif;?>
				</td>
           	<td>
				<?php echo $row->id; ?>
			</td>
		</tr>
		<?php
		$k = 1 - $k;
	}
	?>
    
    
    <tfoot>
    <tr>
      <td colspan="11"><?php echo $this->pagination->getListFooter(); ?></td>
    </tr>
  	</tfoot>
    
	</table>
<div>
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
	<?php echo JHtml::_('form.token'); ?>
</div>
</form>

<div class="visformbottom">
	visForms V1.0.0, &copy; 2012 Copyright by <a href="http://vi-solutiosn.de" target="_blank" class="smallgrey">vi-solutions</a>, all rights reserved. 
    visForms is Free Software released under the GNU/GPL License. 
</div>