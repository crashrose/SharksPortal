<?php 
/**
 * Visfield field view for Visforms
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
 defined('_JEXEC') or die('Restricted access'); ?>

<script type="text/javascript">

	window.addEvent('domready', function(){
		var myTabs = new mootabs('tabcontainer');
	});

	Joomla.submitbutton = function(pressbutton)	{
	var form = document.adminForm;
	
		if (pressbutton == 'visfield.cancel') {
			submitform( pressbutton );
			return;
		}
	
		// do field validation
		if (form.name.value == "") {
			alert( "<?php echo JText::_( 'COM_VISFORMS_FIELD_NAME_MISSING', true ); ?>" );
		} else if (form.label.value == "") {
			alert( "<?php echo JText::_( 'COM_VISFORMS_FIELD_LABEL_MISSING', true ); ?>" );
		} else if (form.name.value.match(/[a-zA-Z0-9]*/) != form.name.value) {
			alert( "<?php echo JText::_( 'COM_VISFORMS_BAD_CHARACTERS', true ); ?>" );
		} else if (form.typefield.options[form.typefield.selectedIndex].value == "0") {
			alert( "<?php echo JText::_( 'COM_VISFORMS_SELECT_FIELD_TYP', true ); ?>" );		
		} else {
			submitform( pressbutton );
		}
	}

</script>

<form action="<?php echo JRoute::_('index.php?option=com_visforms&view=visfields&fid=' . JRequest::getVar( 'fid', -1 )); ?>" method="post" name="adminForm" id="adminForm">

<input type="hidden" id="t_listHS" name="t_listHS" value="<?php echo $this->visfield->t_listHS;?>" />
<input type="hidden" id="t_listHRB" name="t_listHRB" value="<?php echo $this->visfield->t_listHRB;?>" />
 
<div id="tabcontainer">

    <ul class="mootabs_title">
        <li><a href="#fragment-1" class="active"><?php echo JText::_( 'COM_VISFORMS_TAB_GENERAL' ); ?></a></li>
        <li><a href="#fragment-2"><?php echo JText::_( 'COM_VISFORMS_TAB_LAYOUT' ); ?></a></li>
        <li><a href="#fragment-3"><?php echo JText::_( 'COM_VISFORMS_TAB_ADVANCED' ); ?></a></li>
    </ul>

	<div id="fragment-1" class="mootabs_panel active"> 

		<table class="admintable visadmintable"> 
		<tr>
			<td class="key">
				<label for="name"><?php echo  JText::_( 'COM_VISFORMS_NAME' ); ?> :</label>
			</td>
			<td class="value">
				<input class="normalField" type="text" name="name" id="name" maxlength="50" value="<?php echo $this->visfield->name;?>" />
			</td>  
			<td class="description"><?php echo JText::_('COM_VISFORMS_NAME_DESC'); ?> </td>
		</tr>
		<tr>
			<td class="key">
				<label for="label"><?php echo JText::_( 'COM_VISFORMS_LABEL' ); ?> :</label>
			</td>
			<td class="value">
				<input class="normalField" type="text" name="label" id="label" maxlength="250" value="<?php echo $this->visfield->label;?>" />
			</td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_LABEL_DESC'); ?> </td>
		</tr>        
        <tr>
			<td class="key">
				<label for="tpublished"><?php echo JText::_( 'COM_VISFORMS_PUBLISHED' ); ?> :</label>
			</td>
            <td class="value">
            <?php
                echo JHTML::_('select.booleanlist',  'published', '', $this->visfield->published);  
            ?>
            </td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_PUBLISHED_DESC'); ?> </td>
        </tr>
                        
        <tr>
			<td class="key">
				<label for="typefield"><?php echo JText::_( 'COM_VISFORMS_TYPE' ); ?> :</label>
			</td>
            <td class="value">
            	<?php echo $this->listtypes; ?>
            </td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_TYPE_DESC'); ?> </td>
        </tr>        
		</table>
            
        <table class="admintable visadmintable" >    
		<tr id="mandatory_row">
        	<td class="key"><label for="mandatory"><?php echo JText::_( 'COM_VISFORMS_REQUIRED' ); ?> :</label></td>
			<td class="value"><input name="mandatory" id="mandatory" type="checkbox" value="1" <?php if ($this->visfield->mandatory == '1') { ?> checked <?php } ?> /></td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_REQUIRED_DESC'); ?> </td>
		</tr> 
		<tr id="readonly_row">
        	<td class="key">
				<label for="readonly"><?php echo JText::_( 'COM_VISFORMS_READ_ONLY' ); ?> :</label>
			</td>
			<td class="value">
				<input name="readonly" id="readonly" type="checkbox" value="1" <?php if ($this->visfield->readonly == '1') { ?> checked <?php } ?> />
			</td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_READ_ONLY_DESC'); ?> </td>
		</tr> 

		<tr id="custominfo_row">
			<td class="key">
				<label for="custominfo"><?php echo JText::_( 'COM_VISFORMS_TIPS_TEXT' ); ?> :</label>
			</td>
			<td class="value">
				<input type="text" class="longfield" name="custominfo" id="custominfo" maxlength="500" value="<?php echo $this->visfield->custominfo;?>" />
			</td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_TIPS_TEXT_DESC'); ?> </td>
		</tr>        

		<tr id="customerror_row">
			<td class="key">
				<label for="customerror">
					<?php echo JText::_( 'COM_VISFORMS_CUSTOM_ERROR_TEXT' ); ?>:
				</label>
			</td>
			<td class="value">
				<input  class="longfield" type="text" name="customerror" id="customerror" maxlength="500" value="<?php echo $this->visfield->customerror;?>" />
			</td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_CUSTOM_ERROR_TEXT_DESC'); ?> </td>
		</tr>        
        </table>
            
        <table class="admintable visadmintable" id="visf_length">
        <tr>
			<td class="key">
				<label for="t_maxchar">
					<?php echo JText::_( 'COM_VISFORMS_MAX_LENGTH' ); ?>:
				</label>
			</td>
			<td class="value">
				<input name="t_maxchar" type="text" id="t_maxchar" value="<?php if (Isset($this->visfield->t_maxchar)) echo $this->visfield->t_maxchar;?>" maxlength="5" />
			</td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_MAX_LENGTH_DESC'); ?> </td>
		</tr>
 		<tr>
			<td class="key">
				<label for="t_minchar">
					<?php echo JText::_( 'COM_VISFORMS_MIN_LENGTH' ); ?>:
				</label>
			</td>
			<td class="value">
				<input name="t_minchar" type="text" id="t_minchar" value="<?php if (Isset($this->visfield->t_minchar)) echo $this->visfield->t_minchar;?>" maxlength="5" />
			</td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_MIN_LENGTH_DESC'); ?> </td>
		</tr>
        </table>
        
        <?php // FORM - TEXT ?>
        <table class="admintable visadmintable" id="visf_text">
		<tr id="initial_value">
			<td class="key">
				<label for="t_initvalueT">
					<?php echo JText::_( 'COM_VISFORMS_INITIAL_VALUE' ); ?>:
				</label>
			</td>
			<td class="value">
				<input class="longfield" type="text" name="t_initvalueT" id="t_initvalueT" value="<?php if (Isset($this->visfield->t_initvalueT)) echo $this->visfield->t_initvalueT;?>" />
			</td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_INITIAL_VALUE_DESC'); ?> </td>
		</tr>
        
        <tr>
			<td class="key">
				<label for="t_texttype">
					<?php echo JText::_( 'COM_VISFORMS_TEXT_TYPE' ); ?>:
				</label>
			</td>
            <td class="value">
            <?php
                echo $this->texttype;
            ?>
            </td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_TEXT_TYPE_DESC'); ?> </td>
        </tr> 
               
        <tr id="tfillwithtext_row">
			<td class="key">
				<label for="fillwith">
					<?php echo JText::_( 'COM_VISFORMS_FILL_FIELD_WITH' ); ?>:
				</label>
			</td>
            <td class="value">
            <?php
                echo $this->fillwithtext;
            ?>
            </td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_FILL_FIELD_WITH_DESC'); ?> </td>
        </tr>  
		<tr id="tfillwithemail_row">
			<td class="key">
				<label for="fillwithemail">
					<?php echo JText::_( 'COM_VISFORMS_FILL_FIELD_WITH' ); ?>:
				</label>
			</td>
            <td class="value">
            <?php
                echo $this->fillwithemail;
            ?>
            </td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_FILL_FIELD_WITH_DESC'); ?> </td>
        </tr>  
               
        <tr id="tdateformat_row">
			<td class="key">
				<label for="d_format">
					<?php echo JText::_( 'COM_VISFORMS_DATE_FORMAT' ); ?>:
				</label>
			</td>
            <td class="value">
            <?php
                echo $this->dateformat;
            ?>
            </td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_DATE_FORMAT_DESC'); ?> </td>
        </tr>  
		
		<tr id="tdate_calender">
			<td class="key">
				<label for="t_initvalueD">
					<?php echo JText::_( 'COM_VISFORMS_INITIAL_VALUE' ); ?>:
				</label>
			</td>
            <td class="value">
            <?php
                echo $this->calendar;
            ?>
            </td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_DATE_INITIAL_VALUE_DESC'); ?> </td>
        </tr>  
		
		<tr id="tdateday_row">
			<td class="key">
				<label for="d_daydate">
					<?php echo JText::_( 'COM_VISFORMS_DAY_DATE' ); ?>:
				</label>
			</td>
			<td class="value">
				<input name="d_daydate" id="d_daydate" type="checkbox" value="1" <?php if ($this->visfield->d_daydate == '1') { ?> checked <?php } ?> />
			</td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_DAY_DATE_DESC'); ?> </td>
		</tr> 
                                
        </table>
        
        <?php // FORM - HIDDEN ?>
        <table class="admintable visadmintable" id="visf_hidden">
		<tr id="filluid_row">
			<td class="key">
				<label for="t_filluid">
					<?php echo JText::_( 'COM_VISFORMS_ADD_UNIQUE_ID' ); ?>:
				</label>
			</td>
			<td class="value">
				<input name="t_filluid" id="t_filluid" type="checkbox" value="1" <?php if ($this->visfield->t_filluid == '1') { ?> checked <?php } ?> />
			</td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_ADD_UNIQUE_ID_DESC'); ?> </td>
		</tr> 
		<tr>
			<td class="key">
				<label for="t_initvalueH">
					<?php echo JText::_( 'COM_VISFORMS_VALUE' ); ?>:
				</label>
			</td>
			<td class="value">
				<input class="field300" type="text" name="t_initvalueH" id="t_initvalueH" value="<?php if (Isset($this->visfield->t_initvalueH)) echo $this->visfield->t_initvalueH;?>" />
			</td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_VALUE_HIDDEN_DESC'); ?> </td>
		</tr>                   
        </table>
            
        <?php // FORM - TEXTAREA ?>
        <table class="admintable visadmintable" id="visf_textarea">
		<tr>
			<td class="key">
				<label for="t_initvalueTA">
					<?php echo JText::_( 'COM_VISFORMS_INITIAL_VALUE' ); ?>:
				</label>
			</td>
			<td class="value">
				<input class="field300" type="text" name="t_initvalueTA" id="t_initvalueTA" value="<?php if (Isset($this->visfield->t_initvalueTA)) echo $this->visfield->t_initvalueTA;?>" />
			</td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_INITIAL_VALUE_DESC'); ?> </td>
		</tr>
		<tr>
			<td class="key">
				<label for="t_HTMLEditor">
					<?php echo JText::_( 'COM_VISFORMS_HTML_EDITOR' ); ?>:
				</label>
			</td>
			<td class="value">
				<input name="t_HTMLEditor" id="t_HTMLEditor" type="checkbox" value="1" <?php if (Isset($this->visfield->t_HTMLEditor)) { if ($this->visfield->t_HTMLEditor == '1') { ?> checked <?php }} ?>/>
			</td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_HTML_EDITOR_DESC'); ?> </td>
		</tr>
                 
 		<tr>
			<td class="key">
				<label for="t_columns">
					<?php echo JText::_( 'COM_VISFORMS_COLUMNS' ); ?>:
				</label>
			</td>
			<td class="value">
				<input name="t_columns" type="text" id="t_columns" value="<?php if (Isset($this->visfield->t_columns)) echo $this->visfield->t_columns;?>" maxlength="5" />
			</td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_COLUMNS_DESC'); ?> </td>
		</tr>
 		<tr>
			<td class="key">
				<label for="t_rows">
					<?php echo JText::_( 'COM_VISFORMS_ROWS' ); ?>:
				</label>
			</td>
			<td class="value">
				<input name="t_rows" type="text" id="t_rows" value="<?php if (Isset($this->visfield->t_rows)) echo $this->visfield->t_rows;?>"  maxlength="5" />
			</td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_ROWS_DESC'); ?> </td>
		</tr>
        <tr>
			<td class="key">
				<label for="t_wrap">
					<?php echo JText::_( 'COM_VISFORMS_WRAP' ); ?>:
				</label>
			</td>
            <td class="value">
            <?php
                echo $this->listwrap;
            ?>
            </td>   
			<td class="description"><?php echo JText::_('COM_VISFORMS_WRAP_DESC'); ?> </td>			
        </tr>                                             
        </table>
                
        <?php // FORM - CHECKBOX ?>
        <table class="admintable visadmintable" id="visf_checkbox">
		<tr>
			<td class="key">
				<label for="t_initvalueCB">
					<?php echo JText::_( 'COM_VISFORMS_VALUE' ); ?>:
				</label>
			</td>
			<td class="value">
				<input class="field300" type="text" name="t_initvalueCB" id="t_initvalueCB" value="<?php if (Isset($this->visfield->t_initvalueCB)) echo $this->visfield->t_initvalueCB;?>" />
			</td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_CHECKBOX_VALUE_DESC'); ?> </td>	
		</tr>                   
		<tr>
			<td class="key">
				<label for="t_checkedCB">
					<?php echo JText::_( 'COM_VISFORMS_CHECKED' ); ?>:
				</label>
			</td>
			<td class="value">
				<input name="t_checkedCB" id="t_checkedCB" type="checkbox" value="1" <?php if (Isset($this->visfield->t_checkedCB)) { if ($this->visfield->t_checkedCB == '1') { ?> checked <?php }} ?>/>
			</td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_CHECKED_DESC'); ?> </td>
		</tr>  
        </table>
        
        <?php // FORM - RADIOBUTTON ?>
        <table class="admintable visadmintable" id="visf_radiobutton">
        <tr>
			<td class="key">
				<label for="t_displayRB">
					<?php echo JText::_( 'COM_VISFORMS_DISPLAY' ); ?>:
				</label>
			</td>
           <td colspan="3">
            <?php
			
			$name = 't_displayRB';
			$attribs = null;
			$selected = $this->visfield->t_displayRB ? $this->visfield->t_displayRB : 'INL';
			$id=false;
			$disable = false;
			
			$inl = new stdClass();
			$inl->text = JText::_( 'COM_VISFORMS_INLINE' );
			$inl->value = 'INL';
			$lst = new stdClass();
			$lst->text = JText::_( 'COM_VISFORMS_AS_LIST' );
			$lst->value = 'LST';
			
			$arr = array( $inl, $lst );    
			
				echo JHTML::_('select.radiolist',  $arr, $name, $attribs, 'value', 'text', $selected, $id );  
            ?>
            </td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_DISPLAY_DESC'); ?> </td>
        </tr>  
   		<tr>
			<td class="key">
				<label for="t_valueRB">
					<?php echo JText::_( 'COM_VISFORMS_VALUE' ); ?>:
				</label>
			</td>
			<td width="360px">
				<input class="field300" type="text" name="t_valueRB" id="t_valueRB" value="" />
			</td>
			<td width="75" align="right">
				<label for="t_defaultRB">
					<?php echo JText::_( 'COM_VISFORMS_DEFAULT' ); ?>:
				</label>
			</td>
			<td>
				<input name="t_defaultRB" id="t_defaultRB" type="checkbox" value="1" />
			</td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_RADIO_VALUE_DESC'); ?> </td>
		</tr> 
		<tr>
			<td class="key">
				<label for="t_labelRB">
					<?php echo JText::_( 'COM_VISFORMS_LABEL' ); ?>:
				</label>
			</td>
			<td>
				<input class="field300" type="text" name="t_labelRB" id="t_labelRB" value="" />
			</td>
			<td colspan="2">
            	<input name="add" onclick="addValueToList('t_listRB','t_listHRB','t_valueRB','t_labelRB','t_defaultRB');" type="button" value="<?php echo JText::_('COM_VISFORMS_ADD'); ?>" />
                &nbsp;<input onclick="resetValues('t_valueRB','t_labelRB','t_defaultRB');" name="reset" type="button" value="<?php echo JText::_('COM_VISFORMS_RESET'); ?>" />
			</td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_RADIO_LABEL_DESC'); ?> </td>
		</tr>  
		<tr>
			<td class="key">
				<label for="t_listRB">
					<?php echo JText::_( 'COM_VISFORMS_RADIO_LIST' ); ?>:
				</label>
			</td>
			<td>
            	<select class="field300" id="t_listRB" name="t_listRB" size="3" multiple onchange="editValueList('t_listRB','t_valueRB','t_labelRB','t_defaultRB')">
  				</select>
			</td>
			<td colspan="2">
                <input onclick="removeOptions('t_listRB','t_listHRB','t_valueRB','t_labelRB','t_defaultRB');" name="del" type="button" value="<?php echo JText::_('COM_VISFORMS_DEL'); ?>" />
			</td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_RADIO_LIST_DESC'); ?> </td>
		</tr>                   
        </table>
                    
        <?php // FORM - SELECT ?>
        <table class="admintable visadmintable" id="visf_select">
		<tr>
			<td class="key">
				<label for="t_multipleS">
					<?php echo JText::_( 'COM_VISFORMS_ALLOW_MULTIPLE_SELECTION' ); ?>:
				</label>
			</td>
			<td colspan="3">
				<input name="t_multipleS" id="t_multipleS" type="checkbox" value="1" <?php if (Isset($this->visfield->t_multipleS)) { if ($this->visfield->t_multipleS == '1') { ?> checked <?php }} ?>/>
			</td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_ALLOW_MULTIPLE_SELECTION_DESC'); ?> </td>
		</tr>  
		<tr>
			<td class="key">
				<label for="t_heightS">
					<?php echo JText::_( 'COM_VISFORMS_HEIGHT' ); ?>:
				</label>
			</td>
			<td>
				<input type="text" name="t_heightS" id="t_heightS" value="<?php if (Isset($this->visfield->t_heightS)) echo $this->visfield->t_heightS; ?>" />
			</td>
            <td colspan="2">
            </td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_HEIGHT_DESC'); ?> </td>
		</tr>                   
    
		<tr>
			<td class="key">
				<label for="t_valueS">
					<?php echo JText::_( 'COM_VISFORMS_VALUE' ); ?>:
				</label>
			</td>
			<td width="360px">
				<input class="field300" type="text" name="t_valueS" id="t_valueS" value="" />
			</td>
			<td align="right"  width="75">
				<label for="t_defaultS">
					<?php echo JText::_( 'COM_VISFORMS_SELECTED' ); ?>:
				</label>
			</td>
			<td>
				<input name="t_defaultS" id="t_defaultS" type="checkbox" value="1" />
			</td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_SELECT_VALUE_DESC'); ?> </td>
		</tr> 
		<tr>
			<td class="key">
				<label for="t_labelS">
					<?php echo JText::_( 'COM_VISFORMS_LABEL' ); ?>:
				</label>
			</td>
			<td>
				<input class="field300" type="text" name="t_labelS" id="t_labelS" value="" />
			</td>
			<td colspan="2">
            	<input name="add" onclick="addValueToList('t_listS','t_listHS','t_valueS','t_labelS','t_defaultS');" type="button" value="<?php echo JText::_('COM_VISFORMS_ADD'); ?>"" />
                &nbsp;<input onclick="resetValues('t_valueS','t_labelS','t_defaultS');" name="reset" type="button" value="<?php echo JText::_('COM_VISFORMS_RESET'); ?>"" />
			</td>
            <td class="description"><?php echo JText::_('COM_VISFORMS_SELECT_LABEL_DESC'); ?> </td>
		</tr>           
		<tr>
			<td class="key">
				<label for="t_listS">
					<?php echo JText::_( 'COM_VISFORMS_LISTBOX_LIST' ); ?>:
				</label>
			</td>
			<td>
            	<select class="field300" id="t_listS" name="t_listS" size="3" multiple onchange="editValueList('t_listS','t_valueS','t_labelS','t_defaultS')">
  				</select>
			</td>
			<td colspan="2">
            	<input onclick="removeOptions('t_listS','t_listHS','t_valueS','t_labelS','t_defaultS');" name="del" type="button" value="<?php echo JText::_('COM_VISFORMS_DEL'); ?>" />
			</td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_LISTBOX_LIST_DESC'); ?> </td>
		</tr>                   
        </table>
                    
        
        <?php // FORM - FILEUPLOAD ?>
        <table class="admintable visadmintable" id="visf_fileupload">
                 
        </table>
                    
        <?php // FORM - Button ?>
        <table class="admintable visadmintable" id="visf_button">
        <tr>
			<td class="key">
				<label for="t_typeBT">
					<?php echo JText::_( 'COM_VISFORMS_TYPE' ); ?>:
				</label>
			</td>
            <td>
            <?php
                echo $this->listbuttontype;
            ?>
            </td>  
			<td class="description"><?php echo JText::_('COM_VISFORMS_BUTTON_TYPE_DESC'); ?> </td>			
        </tr>                                             
        </table>
        
        <?php // FORM - FIELD SEPARATOR ?>
        <table class="admintable visadmintable" id="visf_fieldsep">
		<tr id="filluid_row">
			<td class="key">
				<label for="t_noborderFS">
					<?php echo JText::_( 'COM_VISFORMS_BORDER_NOT_VISIBLE' ); ?>:
				</label>
			</td>
			<td>
				<input name="t_noborderFS" id="t_noborderFS" type="checkbox" value="1" <?php if ($this->visfield->t_noborderFS == '1') { ?> checked <?php } ?> />
			</td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_BORDER_NOT_VISIBLE_DESC'); ?> </td>
		</tr> 
    	</table>         
    
    </div> 

	<div id="fragment-2" class="mootabs_panel">
        <table class="admintable visadmintable">
		<tr>
			<td class="key">
				<label for="labelCSSclass">
					<?php echo JText::_( 'COM_VISFORMS_CSS_CLASS_FOR_LABEL' ); ?>:
				</label>
			</td>
			<td class="value">
				<input class="normalField" type="text" name="labelCSSclass" id="labelCSSclass" maxlength="50" value="<?php echo $this->visfield->labelCSSclass;?>" />
			</td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_CSS_CLASS_FOR_LABEL_DESC'); ?> </td>
		</tr>   
		<tr>
			<td class="key">
				<label for="fieldCSSclass">
					<?php echo JText::_( 'COM_VISFORMS_CSS_CLASS_FOR_FIELD' ); ?>:
				</label>
			</td>
			<td class="value">
				<input class="normalField" type="text" name="fieldCSSclass" id="fieldCSSclass" maxlength="50" value="<?php echo $this->visfield->fieldCSSclass;?>" />
			</td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_CSS_CLASS_FOR_FIELD_DESC'); ?> </td>
		</tr>
        </table>
    </div> 

	<div id="fragment-3" class="mootabs_panel">
        <table class="admintable visadmintable">
            
		<tr>
			<td class="key" nowrap="nowrap">
				<label for="frontenddisplay">
					<?php echo JText::_( 'COM_VISFORMS_FRONTEND_DISPLAY' ); ?>:
				</label>
			</td>
			<td class="value">
			<?php 
                echo JHTML::_('select.booleanlist',  'frontdisplay', '', $this->visfield->frontdisplay);  
            ?>
			</td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_FRONTEND_DISPLAY_DESC'); ?> </td>
		</tr>
        
        <tr><td colspan="2"><hr /></td></tr>
        
		<tr>
			<td class="key">
				<label for="textseparator">
					<?php echo JText::_( 'COM_VISFORMS_CUSTOM_TEXT' ); ?>:
				</label>
			</td>
           	<td class="value">
            <?php		
                $editorDesc = JFactory::getEditor();
                echo $editorDesc->display('customtext',$this->visfield->customtext, 600, 150, 10, 10);  
            ?>
            </td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_CUSTOM_TEXT_DESC'); ?> </td>
		</tr>                   
        </table>   
    </div>               

</div>

	<div>
		<input type="hidden" name="option" value="com_visforms" />
		<input type="hidden" name="id" value="<?php echo $this->visfield->id; ?>" />
		<input type="hidden" name="fid" value="<?php echo $this->fid; ?>" />
		<input type="hidden" name="ordering" value="<?php echo $this->visfield->ordering; ?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="controller" value="visfields" />
		<?php echo JHtml::_('form.token'); ?>
	</div>

</form>

<div class="visformbottom">
	visForms V1.0.0, &copy; 2012 Copyright by <a href="http://vi-solutions.de" target="_blank" class="smallgrey">vi-solutions</a>, all rights reserved. 
    visForms is Free Software released under the GNU/GPL License. 
</div>