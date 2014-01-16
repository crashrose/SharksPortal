<?php
/**
 * Visforms default view for Visforms
 *
 * @author       Aicha Vack
 * @see           visforms is extended and rivised adaptation of ckforms from cookex (http://www.cookex.eu) for Joomla 2.5
 * @package      Joomla.Site
 * @subpackage   com_visforms
 * @link         http://www.vi-solutions.de 
 * @license      GNU General Public License version 2 or later; see license.txt
 * @copyright    2012 vi-solutions
 * @since        Joomla 1.6 
 */

// no direct access
defined('_JEXEC') or die('Restricted access'); 
	

	
	if ($this->visforms->published != '1') return;

	$nbFields=count($this->visforms->fields );
	
	$mandatory = false;
	$upload = false;
	$custominfo = false;
	$textareaRequired = false;
	for ($i=0;$i < $nbFields; $i++)
	{ 
		$field = $this->visforms->fields[$i];
		if ($field->mandatory == "1") $mandatory = true;
		if ($field->typefield == "fileupload") $upload = true;
		if ($field->custominfo != "") $custominfo = true;
		if ($field->typefield == 'textarea' && $field->mandatory == '1' && $field->t_HTMLEditor == '1') $textareaRequired = true;
	}
	
?>

<div class="visforms-form<?php echo $this->menu_params->get( 'pageclass_sfx' ); ?>" id="visformcontainer">
<?php if ($this->menu_params->get('show_page_heading') == 1) { 
		if (!$this->menu_params->get('page_heading') == "") { ?>
			<h1><?php echo $this->menu_params->get('page_heading'); ?></h1>
	<?php }
	else { ?>
		<h1><?php echo $this->visforms->title; ?></h1>
	<?php
	}
}?>

<script type="text/javascript">

window.addEvent('domready', function(){
	
<?php 
	if ($textareaRequired == true)
	{
?>		

	$('visform<?php echo $this->visforms->id; ?>').onsubmit = function(event){
<?php 
	for ($i=0;$i < $nbFields; $i++)
	{ 
		$field = $this->visforms->fields[$i];
		if ($field->typefield == 'textarea' && $field->mandatory == 1 && $field->t_HTMLEditor == 1) {
?>
		if ($chk($('<?php echo $field->name; ?>')) && $chk($('<?php echo $field->name; ?>Cont'))) {
			$('<?php echo $field->name; ?>Cont').setProperty('value', tinyMCE.get('<?php echo $field->name; ?>').getContent());
		}
<?php 
		}
	}
?>		
	};

<?php 
	}
?>

	var myForm = new FormCheck('visform<?php echo $this->visforms->id; ?>', {
		fieldErrorClass : 'error',
		validateDisabled : true,
		display : {
			showErrors : 1,
			errorsLocation : 1,
			indicateErrors : 2,
			tipsPosition : 'right', 
			addClassErrorToField : true,
			scrollToFirst : true
		},
		alerts : {
			required:'<?php echo addslashes(JText::_( 'COM_VISFORMS_FIELD_REQUERED' )); ?>',
			number:'<?php echo addslashes(JText::_( 'COM_VISFORMS_ENTER_VAILD_NUMBER' )); ?>',
			email:'<?php echo addslashes(JText::_( 'COM_VISFORMS_ENTER_VALID_EMAIL' )); ?>',
			url:'<?php echo addslashes(JText::_( 'COM_VISFORMS_ENTER_VALID_URL' )); ?>',
			confirm:'<?php echo addslashes(JText::_( 'COM_VISFORMS_ENTER_CONFIRM' )); ?>',
			length_str:'<?php echo addslashes(JText::_( 'COM_VISMORMS_LENGTH_INCORRECT' )); ?>',
			length_fix:'<?php echo addslashes(JText::_( 'COM_VISMORMS_LENGTH_FIX' )); ?>',
			lengthmax:'<?php echo addslashes(JText::_( 'COM_VISFORMS_MAXLENGTH_INCORRECT' )); ?>',
			lengthmin:'<?php echo addslashes(JText::_( 'COM_VISFORMS_MINLENGTH_INCORRECT' )); ?>',
			checkbox:'<?php echo addslashes(JText::_( 'COM_VISFORMS_CONFIRM_CHECKBOX' )); ?>',
			radios:'<?php echo addslashes(JText::_( 'COM_VISFORMS_SELECT_RADIO' )); ?>',
			select:'<?php echo addslashes(JText::_( 'COM_VISFORMS_SELECT_VALUE' )); ?>'
		}

	})

	$(document.body).getElements('.captcharefresh').addEvents({
		'click': function(){
			if($chk($('captchacode'))) { 
				$('captchacode').setProperty('src', 'index.php?option=com_visforms&task=captcha&sid=' + Math.random());
			}
		}
	});

	
	
});

</script>

  <?php if (strcmp ( $this->visforms->description , "" ) != 0) { ?>
	<div class="category-desc"><?php echo $this->visforms->description; ?></div>
  <?php } ?>



	<form action="<?php echo JRoute::_($this->formLink); ?>" method="post" name="visform" id="visform<?php echo $this->visforms->id; ?>" class="visform <?php echo $this->visforms->formCSSclass; ?>"<?php if($upload == true) { ?> enctype="multipart/form-data"<?php } ?>>
		<fieldset>
		
<?php 
	//Explantion for * if at least one field is requiered
	if ($mandatory == true)
	{
?>
	<p class="vis_mandatory"><?php echo JText::_( 'COM_VISFORMS_REQUIRED' ); ?> *</p>
<?php } ?>
        <input name="id" id="id" type="hidden" value="<?php echo $this->visforms->id; ?>" />


<?php
 
	for ($i=0;$i < $nbFields; $i++)
	{ 
		$field = $this->visforms->fields[$i];
		if ($field->typefield == "hidden")
		{
?>
        <input name="<?php echo $field->name; ?>" id="<?php echo $field->name; ?>" type="hidden" value="<?php if ($field->t_filluid == "1") {echo uniqid($field->t_initvalueH,true);} else {echo $field->t_initvalueH;} ?>" />
<?php    
		}
	}

	for ($i=0;$i < $nbFields; $i++)
	{ 
		$field = $this->visforms->fields[$i];
		
		if ($field->typefield != "hidden" && $field->typefield != "button" && $field->typefield != "fieldsep")
		{
	
			$validationclass = "validate[";
									 
			if ($field->mandatory == "1") {
				$validationclass = $validationclass."'required',";
			}
			if ($field->typefield == 'text' || $field->typefield == 'textarea')
			{
				$min = "0";
				if ($field->t_minchar != '')
				{
					$min = $field->t_minchar;
				}
				$max = "-1";
				if ($field->t_maxchar != '')
				{
					$max = $field->t_maxchar;
				}
				if ($min != '0' || $max != '-1')
				{
					if ($field->typefield == 'text' && $field->t_texttype == 'number') 
					{
						$validationclass = $validationclass."'digit[".$min.",".$max."]',";
					} else {
						$validationclass = $validationclass."'length[".$min.",".$max."]',";
					}
				}
			}

			if ($field->typefield == 'text' && $field->t_texttype == 'email') {
				$validationclass = $validationclass."'email',";
			}
			
			else if ($field->typefield == 'text' && $field->t_texttype == 'number') {
				$validationclass = $validationclass."'number',";
				
			} 
			
			else if ($field->typefield == 'text' && $field->t_texttype == 'url') {
				$validationclass = $validationclass."'url',";
			}

			$validationclass = rtrim($validationclass,',')."]";	
			
			//Show Helptext in Tooltip
			if ($field->custominfo != "") {
				$tip = array();
				$tip = explode('##', $field->custominfo, 2);								 
?>       
				<div><label class="visCSSlabel<?php if ($field->custominfo != "" && $field->typefield == "textarea") echo " visCSSbot5"; ?> <?php echo $field->labelCSSclass; ?>" id="<?php echo $field->name."lbl"; ?>" <?php if ($field->typefield != "radiobutton") { echo 'for="field' . $field->id .'"';}?>> 
<?php 			if (!isset($tip[1])) {
					echo JHTML::_('tooltip', $tip[0],'','',$field->label);
					}
				else
					{echo JHTML::_('tooltip', $tip[1], $tip[0], '',$field->label);}
				 }
			else {?>
				<div><label class="visCSSlabel<?php if ($field->custominfo != "" && $field->typefield == "textarea") echo " visCSSbot5"; ?> <?php echo $field->labelCSSclass; ?>" id="<?php echo $field->name."lbl"; ?>" <?php if ($field->typefield != "radiobutton") { echo 'for="field' . $field->id .'"';}?>> <?php echo $field->label?>
<?php 		} ?>
<?php 
	if ($field->mandatory == '1') 
	{ 
?>
    	&nbsp;<span class="vis_mandatory">*</span>

<?php
	}
?>       
        </label>
<?php
	switch ($field->typefield)
	{
		case 'text':
?>
<?php        		
		
		if ($field->t_texttype == 'text' || $field->t_texttype == 'number' || $field->t_texttype == 'email' || $field->t_texttype == 'url')
		{
?>
		<input type="text" id="<?php echo 'field' . $field->id; ?>" name="<?php echo $field->name; ?>" value="<?php if (empty($this->post) ==false) {echo $this->post[$field->name];} else {echo $field->t_initvalueT;} ?>" class="<?php echo $validationclass; ?> inputbox visCSSinput <?php echo $field->fieldCSSclass; ?>"  <?php if ($field->readonly == "1") {echo ' readonly="true"';} ?> />
<?php        		
		}
		else if ($field->t_texttype == 'password' )
		{
?>		
        <input type="password" id="<?php echo 'field' . $field->id; ?>" name="<?php echo $field->name; ?>" value="<?php if (empty($this->post) ==false) {echo $this->post[$field->name];} else {echo $field->t_initvalueT;} ?>" class="<?php echo $validationclass; ?> inputbox visCSSinput <?php echo $field->fieldCSSclass; ?>" <?php if ($field->readonly == "1") {echo ' readonly="true"';} ?> />
<?php
		}
		else if ($field->t_texttype == 'date' )
		{
			
		// get dateformat for php and for javascript	
		$dformat = explode(";", $field->d_format);
		
		//check for default date values
		if (strcmp($field->d_initvalueD,'') == 0 && strcmp($field->t_texttype,'date') == 0 &&  strcmp($field->d_daydate,'1') == 0) 
				{
					$field->d_initvalueD = JHTML::_('date', 'now', $dformat[0]);
				}
		
		//php formcheck has failed and fields are refilled with user inputs
		if (empty($this->post) == false) 
		{
			//use default from post
			$defaultdate = $this->post[$field->name];
		} else 
		{
			//use default from form definition
			$defaultdate = ($field->d_initvalueD === '')? $field->d_initvalueD : JHTML::_('date', $field->d_initvalueD, $dformat[0]);
		}
		$attribs = array('class' => $validationclass . ' inputbox visCSStop10 ' . $field->fieldCSSclass, 'maxlength' => '10');
		if ($field->readonly == "1") 
		{
		$attribs['readonly'] = 'readonly'; ?>
		
		<input id="<?php echo 'field' . $field->id; ?>" class="<?php echo $validationclass; ?> inputbox visCSStop10 " type="text" maxlength="10" value="<?php if (0 !== (int) $defaultdate) {echo JHTML::date($defaultdate, $dformat[0]);} else { echo '';} ?>" name="<?php echo $field->name; ?>" title="<?php if (0 !== (int) $defaultdate) { echo JHtml::_('date', $defaultdate);} else {echo '';} ?>" readonly="readonly">
		<?php }
		else 
		{
			echo JHTML::calendar($defaultdate, $field->name, 'field' . $field->id, $dformat[1], $attribs);
		}
?>
		
<?php	
		}
		break; 		

		case 'fileupload':
?>
		<input  id="<?php echo 'field' . $field->id; ?>" name="<?php echo $field->name; ?>" type="file" class="<?php echo $validationclass; ?> visCSSinput <?php echo $field->fieldCSSclass; ?>" <?php if ($field->readonly == "1") {echo ' readonly="true"';} ?> />
<?php
		break; 	
	
		case 'textarea':
			if ($field->t_HTMLEditor == 1 &&  $field->readonly != "1") 
			{	
?>
		
        <div class="visCSSclear visCSSbot10">
        		<input id="<?php echo 'field' . $field->id; ?>" style="float: right; margin-right: 20px; height: 1px; visibility:hidden;" type="text" class="<?php echo $validationclass; ?>" name="<?php echo $field->name; ?>Cont" id="<?php echo $field->name; ?>Cont" value="" />
<?php
				$INIThtml = $field->t_initvalueTA;
				if (empty($this->post) ==false) 
				{
					$INIThtml = $this->post[$field->name];
				}				

				$editorDesc = JFactory::getEditor();
				$editor_param['smilies'] = '0';
				$editor_param['layer'] = '0';
				echo $editorDesc->display($field->name, $INIThtml, '97%', 200, $field->t_columns, $field->t_rows,true,$editor_param);
				
?>
        </div>    
<?php
			} else {
			
		$rows = (!$field->t_rows == '') ? ' rows="' . $field->t_rows . '"' : '';
		$cols = (!$field->t_columns == '') ? ' cols="' . $field->t_columns . '"' : '';
		$wrap = (!$field->t_wrap === 'Default') ? ' wrap="' . $field->t_wrap . '"' : '';
				
?>
        <textarea id="<?php echo 'field' . $field->id; ?>" class="<?php echo $validationclass; ?> visCSSinput <?php echo $field->fieldCSSclass; ?>" name="<?php echo $field->name; ?>" <?php echo $cols .  $rows . $wrap ?> <?php if ($field->readonly == "1") {echo ' readonly="true"';} ?>><?php if (empty($this->post) ==false) {echo $this->post[$field->name];} else {echo $field->t_initvalueTA;} ?></textarea>
<?php
            }
		break; 	
			
		case 'checkbox':
		
			if (empty($this->post) ==false && isset($this->post[$field->name])) 
			{
				$field->t_checkedCB = '1';
			}				

?>
		<input id="<?php echo 'field' . $field->id; ?>" class="<?php echo $validationclass; ?> visCSStop10 <?php echo $field->fieldCSSclass; ?>" name="<?php echo $field->name; ?>" type="checkbox" value="<?php echo $field->t_initvalueCB; ?>" <?php if ($field->t_checkedCB == '1') { ?> checked<?php } ?> <?php if ($field->readonly == "1") {echo ' readonly="true"';} ?> />
<?php
		break; 	
		
		case 'radiobutton':

			
				$opt = explode("[-]", $field->t_listHRB);
				$k=count($opt);
				if ($field->t_displayRB == 'LST')
					{echo '<div class="visCSSclear '.$field->fieldCSSclass.'">';}
				else 
					{echo '<p class="visCSStop0 '.$field->fieldCSSclass.'">';}
				for ($j=0; $j < $k; $j++)
				{	
					$checked = "";
					if (strpos($opt[0], '==') > 0)
					{
						$val = explode("==", $opt[$j]);
						$key = explode("||", $val[1]);
						$ipos = strpos ($key[1],' [default]');
						
						if (empty($this->post) == false && isset($this->post[$field->name]) && $this->post[$field->name] == $key[0]) 
						{
							$checked = 'checked="checked"';
						} 
						else if ($ipos != false && (empty($this->post) == true || isset($this->post[$field->name]) == false)) 
						{
							$checked = 'checked="checked"';
							$key[1] = substr($key[1],0,$ipos);
						}
						if ($field->t_displayRB == 'LST')
							{
							if($j!=0)
							{
								echo '<br />';
							}
						}
					
	?>
						<label class="<?php if ($field->t_displayRB == 'LST') {echo 'visCSSbot5 visCSSlabel visCSSclear';} else {echo 'visCSStop10';} ?> <?php echo $field->labelCSSclass; ?>" id="<?php echo $field->name."lbl" . '_' . $j; ?>" <?php  echo 'for="field' . $field->id . '_' . $j .'"'?>><?php echo $key[1]; ?></label>
						<input id="<?php echo 'field' . $field->id . '_' . $j; ?>" class="<?php echo $validationclass; ?> visCSSbot5 <?php echo $field->fieldCSSclass; ?>" name="<?php echo $field->name; ?>" type="radio" value="<?php echo $key[0]; ?>" <?php echo $checked; ?> <?php if ($field->readonly == "1") {echo ' readonly="readonly"';} ?> />

	<?php 				
					}
				} 
				if ($field->t_displayRB == 'LST') 
				{
					echo '</div>';
				}
				else 
				{
					echo '</p>';
				}
			
			
		break;
			
		case 'select':
			//split options into an array
			$opt = explode("[-]", $field->t_listHS);
			$k=count($opt);
			$options = array();
			$checked = array();
			
			//Has select no default value? Then we need an supplementary 'default' option for selects that are not "multiple" or have a height > 1. Otherwise the first option can not be selected properly.
			
			if (($field->t_multipleS != '1' && ($field->t_heightS == '' || $field->t_heightS <= 1) && strpos($field->t_listHS,' [default]') == false)) {
				$options[] = JHTML::_('select.option', '-1', JText::_('CHOOSE_A_VALUE'));
			}
			for ($j=0;$j < $k; $j++)
			{	
				//$checked = array();
				if (strpos($opt[0], '==') > 0)
				{
					//split options into key/value pairs
					$val = explode("==", $opt[$j]);
					$key = explode("||", $val[1]);
					//Is option an default option? (selected)
					$ipos = strpos ($key[1],' [default]');
					
					//Set Option to selected if set by post
					if (empty($this->post) == false && isset($this->post[$field->name])
						 && in_array($key[0], $this->post[$field->name]) ) 
					{
						$checked[] = $key[0];
						if ($ipos != false)
						{
							$key[1] = substr($key[1],0,$ipos);
						}
					} 
					
					//set option to selected acording to field default
					else if ($ipos != false && (empty($this->post) == true || isset($this->post[$field->name]) == false)) 
					{
						$checked[] = $key[0];
						$key[1] = substr($key[1],0,$ipos);
					}
					$options[] = JHTML::_('select.option', $key[0], $key[1]);	
				}
			}
			
			$listattr = array();
			$listattr['size'] = $field->t_heightS;
			($field->t_multipleS == '1') ? $listattr['multiple'] = 'multiple' : '';
			($field->readonly == "1") ? $listattr['disabled'] = 'disabled' : '';
			$listattr['class'] = $validationclass . ' visCSSinput ' . $field->fieldCSSclass;
			
			//selects must be an array to use multiple select
			echo JHTML::_('select.genericlist', $options, $field->name . '[]', array('id'=>'field' . $field->id,'list.attr'=>$listattr, 'list.select'=>$checked));
		 
		break;
	}
	
	if ($field->mandatory == "1" || ($field->typefield == 'text' && ($field->t_texttype == 'email' || $field->t_texttype == 'number' || $field->t_minchar != ''))) 
	{
		$idError = 'field' . $field->id;
		if ($field->typefield == 'textarea' && $field->t_HTMLEditor == 1 &&  $field->readonly != "1")
		{
			$idError = $field->name.'Cont';
		}
		
		if ($field->typefield == 'radiobutton') {
			$idError = 'field' . $field->id . '_0';
		}
		
		if ($field->customerror != "") 
		{
?>
 	<div class="error" id="error<?php echo $idError; ?>">
		<?php echo $field->customerror; ?>
    </div>
<?php
		}
	}

?>
</div>
<?php
	
	
	
?>

    <p class="visCSSclear"><!-- --></p>

<?php
	}   
	
	else if ($field->typefield == "fieldsep")
	{
		?><hr <?php if ($field->t_noborderFS == "1") {echo ' class="visNoBorder"';} ?> /><?php
	}
	
  
	if (($field->customtext != '') && ($field->typefield != "button")) {
 ?>
 		<div class="visCustomText <?php echo $field->customtextCSSclass; ?>"><?php echo $field->customtext; ?></div>
<?php
	}	
	
}
?>

<?php 
	if ($this->visforms->captcha == 1)
	{
		
?>
	<div class="captchaCont">
        <img id="captchacode" class="captchacode" src="<?php echo JRoute::_('index.php?option=com_visforms&task=captcha&sid=c4ce9d9bffcf8ba3357da92fd49c2457'); ?>" align="absmiddle"> &nbsp;           
        <img alt="<?php echo JText::_( 'COM_VISFORMS_REFRESH_CAPTCHA' ); ?>" class="captcharefresh" src='<?php echo JURI::root(true).'/components/com_visforms/'; ?>captcha/images/refresh.gif' align="absmiddle"> &nbsp;
        <input class="validate['required']" type="text" id="vis_captcha_code" name="vis_captcha_code" />        
        <?php 	
			if ($this->visforms->captchacustominfo != "") 
			{
				?> 
        		<img class="visform_tooltip<?php echo $this->visforms->id; ?> visform_tooltipcss" src="<?php echo JURI::root(true).'/media/com_visforms/'; ?>img/info.png" title="<?php echo $this->visforms->captchacustominfo; ?>" />
				<?php
			}
		?>        
        <div class="error" id="errorvis_captcha_code">
        <?php 	
			if ($this->visforms->captchacustomerror != "") 
			{
				echo $this->visforms->captchacustomerror;
			}
		?>
        </div>    
    </div>
<?php
	} 
?>
    
    <div class="visBtnCon">
	<?php 
	for ($i=0;$i < $nbFields; $i++)
	{ 
		$field = $this->visforms->fields[$i];
		if ($field->typefield == "button")
		{
			if ($field->customtext != '')  {
 ?>
			<div class="visCustomText <?php echo $field->customtextCSSclass; ?>"><?php echo $field->customtext; ?></div>
<?php
	}	
			$jsbutton = "";
			if ($field->t_typeBT == "submit") {
	?>
    			<input name="submit_bt" id="submit_bt" type="submit" value="<?php echo $field->label; ?>" <?php echo $jsbutton; ?> />
   			&nbsp;
<?php 		
		} else if ($field->t_typeBT == "reset") {
		
	?>
    		<input name="reset_bt" id="reset_bt" type="reset" value="<?php echo $field->label; ?>" />&nbsp;
    <?php 
		}?>
    <?php    
	}
}

?>
	</div>
    </fieldset>
	<?php echo JHtml::_( 'form.token' ); ?>
</form>

<?php if ($this->visforms->poweredby == '1') { ?>
	<div id="vispoweredby"><a href="http://vi-solutions.de" target="_blank"><?php echo JText::_( 'COM_VISFORMS_POWERED_BY' ); ?></a></div>
<?php } ?>

</div>
