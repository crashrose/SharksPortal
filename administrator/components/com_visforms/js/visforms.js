/* 
 *Creates dynamically view visfield appearance
 *according to selected field type and subtype

 *for Joomla 2.5
*/

var editValue = null;

if (window.addEventListener)
{
	window.addEventListener("load", initPage, false);
} 
else if (window.attachEvent)
{ 
	var r = window.attachEvent("onload", initPage); 
} 
else 
{
	window.alert("Problem to add EventListener to Window Object !");  
}

function initPage() 
{
	initList('t_listRB','t_listHRB','t_valueRB','t_defaultRB');
	initList('t_listS','t_listHS','t_valueS','t_defaultS');
	
	typeFieldChange();
	
	if ($('typefield').getProperty('value') == "text") 
	{
		typeFieldTextChange();
	}
}

function addValueToList(elemlist,elemhidden,elemval,elemlab,elemcheck) 
{
	var $chk = function(obj){ return !!(obj || obj === 0);};
	
	if ($chk($(elemlist)) && $chk($(elemhidden)) && $chk($(elemval)) && $chk($(elemlab)) && $chk($(elemcheck))) 
	{
		
		var value = $(elemval).getProperty('value');
		var label = $(elemlab).getProperty('value');
		var check = 0;
				
		if (value != '') 
		{

			value = value + "||" + label;
			if ($(elemcheck).checked) 
			{
				value = value + ' [default]';
				check = 1;
				cleanOptions(elemlist);
			}
			
			if (editValue == null) 
			{				
				addOption(elemlist,value,elemval,elemcheck);
			} 
			else 
			{
				if ($chk($(editValue))) 
				{
					$(editValue).setProperty('value',value);
					$(editValue).set('text', value);
					editValue = null;
				}
			}
			
			$(elemval).setProperty('value','');
			$(elemlab).setProperty('value','');
			$(elemcheck).checked = false;
			
			buildHiddenField(elemlist,elemhidden);
			
		} 		
		else 
		{
			window.alert("Value field cannot be empty !");
		}
		
	} 
	else 
	{
		window.alert("addValueToList : Problem to retreive values ");
	}
}

function buildHiddenField(selectbox,elemhidden) 
{
	var selBox = $(selectbox);
	var elHid = $(elemhidden);
	var $chk = function(obj){ return !!(obj || obj === 0);};
	
	if ($chk(selBox) && $chk(elHid)) 
	{
		var value = "";
		for(var i=0;i<selBox.options.length;i++) 
		{
			value = value + selBox.options[i].id+"=="+selBox.options[i].value;
			if (i<(selBox.options.length-1)) value = value +"[-]"; 
		}
		elHid.value = value;
	} 
	else 
	{
		window.alert("buildHiddenField : Problem to retreive values /n" + selectbox + " : " + elemhidden);
	}
}

function editValueList(elemlist,elemval,elemlab,elemcheck) 
{
	
	var elemlist=document.getElementById(elemlist);
	var elemval=document.getElementById(elemval);
	var elemlab=document.getElementById(elemlab);
	var elemcheck=document.getElementById(elemcheck);
	
	if (elemlist && elemval && elemlab && elemcheck) 
	{
		
		var objSelected = elemlist.options[elemlist.selectedIndex];
		if (!objSelected) 
		{
			window.alert("No options selected !");
			return false;
		}
		
		for (i=elemlist.options.length-1;i>=0;i--) 
		{
			if (elemlist.options[i].selected) {
				var sep = elemlist.options[i].value.indexOf('||');
				var label = "";
				var value = "";
								
				if(index != -1) 
				{
					value = elemlist.options[i].value.substring(0,sep); 
					label = elemlist.options[i].value.substring(sep+2); 
				}
				
				elemval.value = value;
				
				var index = label.indexOf(' [default]');
				if(index != -1) 
				{
					elemlab.value = label.substring(0,index); 
					elemcheck.checked = true;
				} 
				else 
				{
					elemlab.value = label; 
					elemcheck.checked = false;
				}
				
				editValue = objSelected.id;
			}
		}
	} 
	else 
	{
		window.alert("editValueList : Problem to retreive values \n" +  elemlist + " : " + elemval + " : " + elemcheck);
	}
}

function resetValues(elemval,elemlab,elemcheck) 
{
	
	var elemval=document.getElementById(elemval);
	var elemlab=document.getElementById(elemlab);
	var elemcheck=document.getElementById(elemcheck);
	
	if (elemval && elemlab && elemcheck) 
	{
		
		elemval.value = "";
		elemlab.value = "";
		elemcheck.checked = false;
		editValue = null;
	} 
	else 
	{
		window.alert("editValueList : Problem to retreive values \n" +  elemlist + " : " + elemval + " : " + elemcheck);
	}
}

function cleanOptions(selectbox) 
{
	var selBox = $(selectbox);
	var $chk = function(obj){ return !!(obj || obj === 0);};
	
	if ($chk(selBox)) 
	{
		for(var i=selBox.options.length-1;i>=0;i--) 
		{
			var index = selBox.options[i].value.indexOf(' [default]');
			if(index != -1) 
			{
				selBox.options[i].value = selBox.options[i].value.substring(0,index); 
				selBox.options[i].text = selBox.options[i].value;
			}
		}
	} 
	else 
	{
		window.alert("cleanOptions : Problem to retreive values \n" + selectbox);
	}
}

function addOption(selectbox,text,elemval,elemcheck) 
{
	
	var selBox = $(selectbox);
	var optn = document.createElement("OPTION");
	
	optn.text = text;
	optn.value = text;
	optn.id = "optrb" + selBox.options.length;
	
	selBox.options.add(optn);	
}

function removeOptions(selectbox,elemhidden,elemval,elemlab,elemcheck) 
{
	var selectbox=document.getElementById(selectbox);
	var elemhidden=document.getElementById(elemhidden);
	
	var i;
	for(i=selectbox.options.length-1;i>=0;i--) 
	{
		if(selectbox.options[i].selected)
			selectbox.remove(i);
	}
	
	// Rebuild IDs list
	for(i=0;i<selectbox.options.length;i++) 
	{
		selectbox.options[i].id = "optrb" + i;
	}	
	
	buildHiddenField(selectbox,elemhidden);	
	
	resetValues(elemval,elemlab,elemcheck);
}

function initList(elemlist,elemhidden,elemval,elemlab,elemcheck) 
{
	var hiddenfield=document.getElementById(elemhidden);
	var selectbox=document.getElementById(elemlist);
	var elemval=document.getElementById(elemval);
	var elemlab=document.getElementById(elemlab);
	var elemcheck=document.getElementById(elemcheck);
	
	if (hiddenfield && selectbox ) 
	{
		var pair=hiddenfield.value.split("[-]");
		for (var i=0; i<pair.length; i++) {
			var key=pair[i].split("==");
			if (key.length>1) {
				addOption(selectbox,key[1],elemval,elemlab,elemcheck);
			}
		}
		
		buildHiddenField(selectbox,hiddenfield);	
	} 
	else 
	{
		window.alert("initListRB : Problem to retreive values \n" +  hiddenfield + " : " + selectbox);
	}	
}

function hiddenProperties() 
{
	
	$('visf_text').setStyle('display','none');
	$('visf_hidden').setStyle('display','none');
	$('visf_textarea').setStyle('display','none');
	$('visf_checkbox').setStyle('display','none');
	$('visf_radiobutton').setStyle('display','none');
	$('visf_select').setStyle('display','none');
	$('visf_button').setStyle('display','none');
	$('visf_fieldsep').setStyle('display','none');
	$('mandatory_row').setStyle('display','none');
	$('readonly_row').setStyle('display','none');
	$('custominfo_row').setStyle('display','none');
	$('customerror_row').setStyle('display','none');
	$('visf_length').setStyle('display','none');

}

function typeFieldChange() 
{
	
	hiddenProperties();
	
	var ffield = 'visf_' + $('typefield').getProperty('value');
	
	if (ffield != 'visf_0') 
	{
		$(ffield).setStyle('display','');
		
		if (ffield == "visf_select" || ffield == "visf_radiobutton" || ffield == "visf_fileupload" || ffield == "visf_checkbox"
			 || ffield == "visf_text" || ffield == "visf_textarea") 
			 {
			$('mandatory_row').setStyle('display','');
			$('custominfo_row').setStyle('display','');
			$('customerror_row').setStyle('display','');
			if (ffield != "visf_select" && ffield != "visf_radiobutton" && ffield != "visf_fileupload") 
			{
				$('readonly_row').setStyle('display','');
			}
			
			if (ffield == "visf_text")
			{
				typeFieldTextChange();
			}
		} 
		
		if (ffield != "visf_hidden" && ffield != "visf_checkbox" && ffield != "visf_radiobutton" 
				&& ffield != "visf_select" && ffield != "visf_button" && ffield != "visf_fileupload"
				 && ffield != "visf_fieldsep") 
				 { 
			$('visf_length').setStyle('display','');
		}
	}

}

function hiddenTextProperties() 
{
	
	$('tdateformat_row').setStyle('display','none');
	$('tdateday_row').setStyle('display','none');
	$('tfillwithtext_row').setStyle('display','none');
	$('tfillwithemail_row').setStyle('display','none');
	$('initial_value').setStyle('display','none');
	$('visf_length').setStyle('display','none');
	$('tdate_calender').setStyle('display', 'none');
}

function typeFieldTextChange() 
{
	
	hiddenTextProperties();
	
	var value = $('t_texttype').getProperty('value');
	
	if (value == 'date') 
	{
		$('tdateformat_row').setStyle('display','');
		$('tdateday_row').setStyle('display','');
		$('tdate_calender').setStyle('display', '');
	} 
	else if (value == 'text' || value == 'email') 
	{
		if (value == 'text') 
		{
			$('tfillwithtext_row').setStyle('display','');
			$('initial_value').setStyle('display','');
			$('visf_length').setStyle('display','');
		}
		else
		{
			$('tfillwithemail_row').setStyle('display','');
			$('initial_value').setStyle('display','');
			$('visf_length').setStyle('display','');
		}
	} 
	else if (value == 'number' || value == 'password') 
	{
		$('initial_value').setStyle('display','');
		$('visf_length').setStyle('display','');
	} 
	else if (value == 'url') 
	{
		$('initial_value').setStyle('display','');
	}	
}

function formatFieldDateChange() 
{
	// set selected in dateformat select list to new value
	formatFieldDateChangeSelected ();
	
	// setup calendar with correct dateformat
	formatDateCalendarChange ();
	
	// display date in input field in correct format
	formatDateChangeInputValue ();
	
}

function formatDateChangeInputValue () 
{

	// get value of initial Date field
	var date = $('d_initvalueD').getProperty('value');
	
	// if there is a date value set, change date format acording to selected listbox value
	if (! date == "") 
	{
	
		// find date delimiter
		var date_delimiter = date.match(/\/|-|\./);
		var date_parts = date.split(date_delimiter[0]);

		// get date parts. Each date_delimiter represents a defined date format and a fix position of date parts
		switch (date_delimiter[0]) {
			case "/" :
				var month = date_parts[0];
				var day = date_parts[1];
				var year = date_parts[2];
				break;
			case "-" :
				var year = date_parts[0];
				var month = date_parts[1];
				var day = date_parts[2];
				break;
			case "." :
				var day = date_parts[0];
				var month = date_parts[1];
				var year = date_parts[2];
				break;
		}

		// get new date output format
		var d_format = $('d_format').getProperty('value');
	
		//find date format delimiter
		var d_format_delimiter = d_format.match(/\/|-|\./);
		//alert(d_format_delimiter);
		
		// construct the formated date string. Each date format delimiter represents a defined dat format and a fix position on date parts
		switch (d_format_delimiter[0]) 
		{
			case '/' :
				var formatted_date = month + d_format_delimiter + day + d_format_delimiter + year;
				break;
			case '-' :
				var formatted_date = year + d_format_delimiter + month + d_format_delimiter + day;
				break;
			case '.' :
				var formatted_date = day + d_format_delimiter + month + d_format_delimiter + year;
				break;
		}
		// set date value with formatted date string
		$('d_initvalueD').setProperty('value',formatted_date);
	}
}

function formatFieldDateChangeSelected () 
{
	for(i=$('d_format').options.length-1;i>=0;i--) {
		if($('d_format').options[i].getAttribute('selected')) {
			$('d_format').options[i].removeAttribute('selected');
		}
		if($('d_format').options[i].selected) {
			$('d_format').options[i].setAttribute('selected', 'selected');
		}
	}
}

function formatDateCalendarChange () 
{
	// get new date output format
	var d_format = $('d_format').getProperty('value');
	
	// get dateformat for php and for javascript
	d_format = d_format.split(';');
	
	Calendar.setup({
		// Id of the input field
		inputField: "d_initvalueD",
		// Format of the input field
		ifFormat: d_format[1], //"%d.%m.%Y",
		// Trigger for the calendar (button ID)
		button: "d_initvalueD_img",
		// Alignment (defaults to "Bl")
		align: "Tl",
		singleClick: true,
		firstDay: 0
	}); 
}