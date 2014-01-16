<?php
/**
 * Visform form view for Visforms
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

<?php 
	jimport( 'joomla.html.editor' ); 
	JHtml::_('behavior.framework');
	$document = JFactory::getDocument();
	$document->addScript(JURI::root(true).'/administrator/components/com_visforms/js/mootabs.js');
?>

<script type="text/javascript">

window.addEvent('domready', function(){
	var myTabs = new mootabs('tabcontainer');
});

Joomla.submitbutton = function(pressbutton)	{
	var form = document.adminForm;

	if (pressbutton == 'visform.cancel') {
		submitform( pressbutton );
		return;
	}

	// do field validation
	if (form.name.value == ""){
		alert( "<?php echo JText::_( 'COM_VISFORMS_FORM_NAME_MISSING', true ); ?>" );
	} else if (form.title.value == "") {
			alert( "<?php echo JText::_( 'COM_VISFORMS_FORM_LABEL_MISSING', true ); ?>" );
	} else if (form.name.value.match(/[a-zA-Z0-9]*/) != form.name.value) {
		alert( "<?php echo JText::_( 'COM_VISFORMS_BAD_CHARACTERS', true ); ?>" );
	} else {
		submitform( pressbutton );
	}
}


</script>


<form action="index.php" method="post" name="adminForm" id="adminForm">
 
    <div id="tabcontainer">
    
        <ul class="mootabs_title">
        	<li><a href="#fragment-1" class="active"><?php echo JText::_( 'COM_VISFORMS_TAB_GENERAL' ); ?></a></li>
          	<li><a href="#fragment-2"><?php echo JText::_( 'COM_VISFORMS_RESULT' ); ?></a></li>
          	<li><a href="#fragment-3"><?php echo JText::_( 'COM_VISFORMS_EMAIL' ); ?></a></li>
          	<li><a href="#fragment-4"><?php echo JText::_( 'COM_VISFORMS_TAB_ADVANCED' ); ?></a></li>
            <li><a href="#fragment-5"><?php echo JText::_( 'COM_VISFORMS_FRONTEND_DISPLAY' ); ?></a></li>
      	</ul>

		<div id="fragment-1" class="mootabs_panel active"> 
		<table class="admintable visadmintable"> 
		<tr>
			<td class="key">
				<label for="name">
					<?php echo JText::_( 'COM_VISFORMS_NAME' ); ?>:
				</label>
			</td>
			<td class="value">
				<input type="text" name="name" id="name" size="50" maxlength="50" value="<?php echo $this->visforms->name;?>" />
			</td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_FORM_NAME_DESC'); ?> </td>
		</tr>
        
		<tr>
			<td class="key">
				<label for="title">
					<?php echo JText::_( 'COM_VISFORMS_TITLE' ); ?>:
				</label>
			</td>
			<td class="value">
				<input type="text" name="title" id="title" size="50" maxlength="250" value="<?php echo $this->visforms->title;?>" />
			</td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_TITLE_DESC'); ?> </td>
		</tr>        
        <tr>
			<td class="key">
				<label for="published">
					<?php echo JText::_( 'COM_VISFORMS_PUBLISHED' ); ?>:
				</label>
			</td>
            <td class="value">
            <?php 
                echo JHTML::_('select.booleanlist',  'published', '', $this->visforms->published); 
            ?>
            </td>        
        </tr>
		<tr>
			<td class="key">
				
				<?php echo JText::_( 'COM_VISFORMS_LANGUAGE' ); ?>:
			</td>
            <td class="value">
            <?php echo JHTML::_('select.genericlist', JHtml::_('contentlanguage.existing', true, true), 'language', 'class="inputbox" size="1"','value', 'text', $this->visforms->language);?>
            </td>        
        </tr>

        <tr>
			<td class="key">
				<label for="title">
					<?php echo JText::_( 'COM_VISFORMS_DESCRIPTION' ); ?>:
				</label>
			</td>
            <td class="value">
            <?php
                $editorDesc = JFactory::getEditor();
                echo $editorDesc->display('description',$this->visforms->description, 600, 200, 10, 10);  
            ?>
            
            </td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_DESCRIPTION_DESC'); ?> </td>
        </tr>
		</table>
        </div>
        
		<div id="fragment-2" class="mootabs_panel ui-tabs-hide">
		<table class="admintable visadmintable"> 
        <tr>
			<td class="key">
				<label for="title">
					<?php echo JText::_( 'COM_VISFORMS_SAVE_RESULT' ); ?> :
				</label>
			</td>
            <td class="value">
                <?php echo JHTML::_('select.booleanlist',  'saveresult', '', $this->visforms->saveresult); ?>    
            </td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_SAVE_RESULT_DESC'); ?> </td>
        </tr>
        
        <tr>
			<td class="key">
				<label for="title"><?php echo JText::_( 'COM_VISFORMS_TEXT_RESULT' ); ?> :</label>
			</td>
            <td class="value">
                <?php 
                    $editorResult = JFactory::getEditor();
                    echo $editorResult->display('textresult',$this->visforms->textresult, 600, 200, 10, 10);  
                ?>
            </td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_TEXT_RESULT_DESC'); ?> </td>
        </tr>
		<tr>
			<td class="key">
				<label for="title">
					<?php echo JText::_( 'COM_VISFORMS_REDIRECT_URL' ); ?> :
				</label>
			</td>
			<td class="value">
				<input class="longfield" type="text" name="redirecturl" id="redirecturl" maxlength="250" value="<?php echo $this->visforms->redirecturl;?>" />
			</td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_REDIRECT_URL_DESC'); ?> </td>
		</tr>          
		</table>        
        </div>
        
        <div id="fragment-3" class="mootabs_panel ui-tabs-hide">
        <table class="admintable x-hide-display visadmintable" id="cktb3">
        <tr>
			<td class="key" nowrap="nowrap">
				<label for="title">
					<?php echo JText::_( 'COM_VISFORMS_EMAIL_RESULT' ); ?>:
				</label>
			</td>
        	<td class="value">
				<?php echo JHTML::_('select.booleanlist',  'emailresult', '', $this->visforms->emailresult); ?>
            </td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_EMAIL_RESULT_DESC'); ?> </td>			
        </tr>
		<tr>
			<td class="key" nowrap="nowrap">
				<label for="title">
					<?php echo JText::_( 'COM_VISFORMS_EMAIL_FROM' ); ?>:
				</label>
			</td>
			<td class="value">
				<input class="longfield" type="text" name="emailfrom" id="emailfrom" maxlength="250" value="<?php echo $this->visforms->emailfrom;?>" />
			</td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_EMAIL_FROM_DESC'); ?> </td>	
		</tr> 
		<tr>
			<td class="key" nowrap="nowrap">
				<label for="title">
					<?php echo JText::_( 'COM_VISFORMS_EMAIL_TO' ); ?>:
				</label>
			</td>
			<td class="value">
				<input class="longfield" type="text" name="emailto" id="emailto" maxlength="250" value="<?php echo $this->visforms->emailto;?>" />
			</td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_EMAIL_TO_DESC'); ?> </td>
		</tr> 
		<tr>
			<td class="key" nowrap="nowrap">
				<label for="title">
					<?php echo JText::_( 'COM_VISFORMS_EMAIL_CC' ); ?>:
				</label>
			</td>
			<td class="value">
				<input class="longfield" type="text" name="emailcc" id="emailcc" maxlength="250" value="<?php echo $this->visforms->emailcc;?>" />
			</td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_EMAIL_CC_DESC'); ?> </td>
		</tr> 
		<tr>
			<td class="key" nowrap="nowrap">
				<label for="title">
					<?php echo JText::_( 'COM_VISFORMS_EMAIL_BCC' ); ?>:
				</label>
			</td>
			<td class="value">
				<input class="longfield" type="text" name="emailbcc" id="emailbcc" maxlength="250" value="<?php echo $this->visforms->emailbcc;?>" />
			</td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_EMAIL_BCC_DESC'); ?> </td>
		</tr> 
		<tr>
			<td class="key" nowrap="nowrap">
				<label for="title">
					<?php echo JText::_( 'COM_VISFORMS_EMAIL_MAIL_SUBJECT' ); ?>:
				</label>
			</td>
			<td class="value">
				<input class="longfield" type="text" name="subject" id="subject" maxlength="250" value="<?php echo $this->visforms->subject;?>" />
			</td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_EMAIL_MAIL_SUBJECT_DESC'); ?> </td>
		</tr>    
                          
        <tr>
			<td class="key" nowrap="nowrap">
				<label for="title"><?php echo JText::_( 'COM_VISFORMS_INCLUDE_FILE_UPLOAD_FILES' ); ?>:</label>
			</td>
        	<td class="value">
			<?php echo JHTML::_('select.booleanlist',  'emailresultincfile', '', $this->visforms->emailresultincfile); ?>
            </td>  
			<td class="description"><?php echo JText::_('COM_VISFORMS_INCLUDE_FILE_UPLOAD_FILES_DESC'); ?> </td>  	          
        </tr>
		<tr><td><hr /></td><td><hr /></td></tr>
        <tr>
			<td class="key" nowrap="nowrap">
				<label for="title"><?php echo JText::_( 'COM_VISFORMS_EMAIL_RECEIPT' ); ?>:</label>
			</td>
        	<td class="value">
				<?php echo JHTML::_('select.booleanlist',  'emailreceipt', '', $this->visforms->emailreceipt); ?>
            </td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_EMAIL_RECEIPT_DESC'); ?> </td>
        </tr>
        <tr>
			<td class="key" nowrap="nowrap">
				<label for="title"><?php echo JText::_( 'COM_VISFORMS_EMAIL_RECEIPT_SUBJECT' ); ?>:</label>
			</td>
        	<td class="value">
			<input class="text_area" type="text" name="emailreceiptsubject" id="emailreceiptsubject" maxlength="250" value="<?php echo $this->visforms->emailreceiptsubject;?>" />
            </td>    
			<td class="description"><?php echo JText::_('COM_VISFORMS_EMAIL_RECEIPT_SUBJECT_DESC'); ?> </td>			
        </tr>
        <tr>
			<td class="key">
				<label for="title"><?php echo JText::_( 'COM_VISFORMS_EMAIL_RECEIPT_TEXT' ); ?>:</label>
			</td>
            <td class="value">  
            <?php 
                $editorResultEMR = JFactory::getEditor();
                echo $editorResultEMR->display('emailreceipttext',$this->visforms->emailreceipttext, 600, 150, 10, 10);  
            ?>
            </td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_EMAIL_RECEIPT_TEXT_DESC'); ?> </td>	
        </tr>
        <tr>
			<td class="key" nowrap="nowrap">
				<label for="title"><?php echo JText::_( 'COM_VISFORMS_INCLUDE_DATA' ); ?>:</label>
			</td>
        	<td class="value">
			<?php echo JHTML::_('select.booleanlist',  'emailreceiptincfield', '', $this->visforms->emailreceiptincfield); ?>
            </td>       
			<td class="description"><?php echo JText::_('COM_VISFORMS_INCLUDE_DATA_DESC'); ?> </td>
        </tr>
        <tr>
			<td class="key" nowrap="nowrap">
				<label for="title"><?php echo JText::_( 'COM_VISFORMS_INCLUDE_FILE_UPLOAD_FILES' ); ?>:</label>
			</td>
        	<td class="value">
			<?php echo JHTML::_('select.booleanlist',  'emailreceiptincfile', '', $this->visforms->emailreceiptincfile); ?>
            </td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_INCLUDE_FILE_UPLOAD_FILES_DESC'); ?> </td>  
        </tr>

       	</table>
    </div>
    
    <div id="fragment-4" class="mootabs_panel ui-tabs-hide">
		<table class="admintable visadmintable"> 
		<tr>
			<td class="key">
				<label for="title"><?php echo JText::_( 'COM_VISFORMS_USE_SPAMBOTCHECK' ); ?> :</label>
			</td>
            <td class="value">
                <?php 
                    echo JHTML::_('select.booleanlist',  'spambotcheck', '', $this->visforms->spambotcheck);  
                ?>
            </td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_USE_SPAMBOTCHECK_DESC'); ?> </td>
        </tr>
        <tr>
			<td class="key">
				<label for="title"><?php echo JText::_( 'COM_VISFORMS_USE_CAPTCHA' ); ?> :</label>
			</td>
            <td class="value">
                <?php 
                    echo JHTML::_('select.booleanlist',  'captcha', '', $this->visforms->captcha);  
                ?>
            </td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_USE_CAPTCHA_DESC'); ?> </td>
        </tr>
		<tr>
			<td class="key" nowrap="nowrap">
				<label for="title">
					<?php echo JText::_( 'COM_VISFORMS_CAPTCHA_TIPS_TEXT' ); ?>:
				</label>
			</td>
			<td class="value">
				<input class="text_area" type="text" name="captchacustominfo" id="captchacustominfo" maxlength="255" value="<?php echo $this->visforms->captchacustominfo;?>" />
			</td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_CAPTCHA_TIPS_TEXT_DESC'); ?> </td>
		</tr>
		<tr>
			<td class="key" nowrap="nowrap">
				<label for="title">
					<?php echo JText::_( 'COM_VISFORMS_CAPTCHA_CUSTOM_ERROR_TEXT' ); ?>:
				</label>
			</td>
			<td class="value">
				<input class="text_area" type="text" name="captchacustomerror" id="captchacustomerror" maxlength="255" value="<?php echo $this->visforms->captchacustomerror;?>" />
			</td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_CAPTCHA_CUSTOM_ERROR_TEXT_DESC'); ?> </td>
		</tr>
        
        <tr><td colspan="2"><hr /></td></tr>
            
		<tr>
			<td class="key" nowrap="nowrap">
				<label for="title">
					<?php echo JText::_( 'COM_VISFORMS_CSS_CLASS' ); ?>:
				</label>
			</td>
			<td class="value">
				<input class="text_area" type="text" name="formCSSclass" id="formCSSclass" maxlength="50" value="<?php echo $this->visforms->formCSSclass;?>" />
			</td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_CSS_CLASS_DESC'); ?> </td>
		</tr>
        
        <tr><td colspan="2"><hr /></td></tr>
            
        <tr>
			<td class="key" nowrap="nowrap">
				<label for="title">
					<?php echo JText::_( 'COM_VISFORMS_UPLOADED_FILE_PATH' ); ?>:
				</label>
			</td>
			<td class="value">
				<input class="text_area" type="text" name="uploadpath" id="uploadpath" maxlength="255" value="<?php echo $this->visforms->uploadpath;?>" /><br/>
                <?php 
				if ($this->visforms->uploadpath != null && trim($this->visforms->uploadpath) != "") 
                {
					if (file_exists ($this->visforms->uploadpath))					
					{
						echo "<span class=\"txtgreen\">(".JText::_( 'COM_VISFORMS_DIRECTORY_EXISTS' )."</span> - ";
						
						if (is_writable ($this->visforms->uploadpath))
						{
							echo "<span class=\"txtgreen\">".JText::_( 'COM_VISFORMS_DIRECTORY_WRITABLE' ).")</span>";
						} else {
							echo "<span class=\"txtred\">".JText::_( 'COM_VISFORMS_DIRECTORY_READONLY' )." !".")</span>";
						}
					} else {
						echo "<span class=\"txtred\">(".JText::_( 'COM_VISFORMS_DIRECTORY_DOESNT_EXISTS' )." !".")</span>";
					}
                }
				?>
			</td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_UPLOADED_FILE_PATH_DESC'); ?> </td>
		</tr>
		<tr>
			<td class="key" nowrap="nowrap">
				<label for="title">
					<?php echo JText::_( 'COM_VISFORMS_FILE_UPLOADED_MAX_SIZE' ); ?>:
				</label>
			</td>
			<td class="value">
				<input class="text_area" type="text" name="maxfilesize" id="maxfilesize" size="32" maxlength="32" value="<?php echo $this->visforms->maxfilesize;?>" />
			</td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_FILE_UPLOADED_MAX_SIZE_DESC'); ?> </td>
		</tr>
        <tr>
			<td class="key" nowrap="nowrap">
				<label for="title">
					<?php echo JText::_( 'COM_VISFORMS_UPLOADED_FILE_ALLOWED_EXTENSIONS' ); ?>:
				</label>
			</td>
			<td class="value">
				<input class="text_area" type="text" name="allowedextensions" id="allowedextensions"  maxlength="225" value="<?php echo $this->visforms->allowedextensions;?>" />
			</td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_UPLOADED_FILE_ALLOWED_EXTENSIONS_DESC'); ?> </td>
		</tr>
        <tr><td colspan="2"><hr /></td></tr>
            
		<tr>
			<td class="key" nowrap="nowrap">
				<label for="title">
					<?php echo JText::_( 'COM_VISFORMS_DISPLAY_POWERED_BY' ); ?>:
				</label>
			</td>
			<td class="value">
			<?php 
                echo JHTML::_('select.booleanlist',  'poweredby', '', $this->visforms->poweredby);  
            ?>

			</td>
			<td class="description"><?php echo JText::_('COM_VISFORMS_DISPLAY_POWERED_BY_DESC'); ?> </td>
		</tr>
        </table>
    </div>
        
    <div id="fragment-5" class="mootabs_panel ui-tabs-hide">
	<table class="admintable visadmintable">            
	<tr>
		<td class="key" nowrap="nowrap">
            <label for="title">
                <?php echo JText::_( 'COM_VISFORMS_DISPLAY_IP' ); ?>:
            </label>
		</td>
		<td class="value">
			<?php 
                echo JHTML::_('select.booleanlist',  'displayip', '', $this->visforms->displayip);  
            ?>
		</td><td class="description"><?php echo JText::_('COM_VISFORMS_DISPLAY_IP_DESC'); ?> </td>
	</tr>
	<tr>
		<td class="key" nowrap="nowrap">
            <label for="title">
                <?php echo JText::_( 'COM_VISFORMS_DISPLAY_DATA_DETAIL' ); ?>:
            </label>
		</td>
		<td class="value">
		<?php 
        	echo JHTML::_('select.booleanlist',  'displaydetail', '', $this->visforms->displaydetail);  
        ?>
		</td>
		<td class="description"><?php echo JText::_('COM_VISFORMS_DISPLAY_DATA_DETAIL_DESC'); ?> </td>
	</tr>
    
	<tr>
		<td class="key" nowrap="nowrap">
            <label for="title">
                <?php echo JText::_( 'COM_VISFORMS_AUTO_PUBLISH_DATA' ); ?>:
            </label>
		</td>
		<td class="value">
		<?php 
        	echo JHTML::_('select.booleanlist',  'autopublish', '', $this->visforms->autopublish);  
        ?>
		</td>
		<td class="description"><?php echo JText::_('COM_VISFORMS_AUTO_PUBLISH_DATA_DESC'); ?> </td>
	</tr>


    <tr>
        <td class="key">
            <label for="title">
                <?php echo JText::_( 'COM_VISFORMS_TITLE' ); ?>:
            </label>
        </td>
        <td class="value">
            <input type="text" name="fronttitle" id="fronttitle" size="50" maxlength="250" value="<?php echo $this->visforms->fronttitle;?>" />
        </td>
		<td class="description"><?php echo JText::_('COM_VISFORMS_DATALIST_TITLE_DESC'); ?> </td>
    </tr>        

    <tr>
        <td class="key">
            <label for="title">
                <?php echo JText::_( 'COM_VISFORMS_DESCRIPTION' ); ?>:
            </label>
        </td>
        <td class="value">
			<?php 	
                $editorDesc = JFactory::getEditor();
                echo $editorDesc->display('frontdescription',$this->visforms->frontdescription, 600, 200, 10, 10);  
            ?>
        </td>
		<td class="description"><?php echo JText::_('COM_VISFORMS_DATALIST_DESCRIPTION_DESC'); ?> </td>
    </tr>

    </table>
    </div>            
</div>

<input type="hidden" name="option" value="com_visforms" />
<input type="hidden" name="id" value="<?php echo $this->visforms->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="visforms" />
<input type="hidden" name="hits" value="<?php echo $this->visforms->hits; ?>" />
<?php echo JHtml::_('form.token'); ?>

</form>

<div class="visformbottom">
	visForms V1.0.0, &copy; 2012 Copyright by <a href="http://vi-solutions.de" target="_blank" class="smallgrey">vi-soluions</a>, all rights reserved. 
    visForms is Free Software released under the <a href="http://www.gnu.org/licenses/gpl-2.0.html"target="_blank" class="smallgrey">GNU/GPL License</a>.
</div>
