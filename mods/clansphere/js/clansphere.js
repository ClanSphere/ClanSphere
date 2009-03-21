// ClanSphere 2009 - www.clansphere.net
// $Id: clansphere.js 1430 2008-12-10 13:08:44Z Fr33z3m4n $

var cs_textarea_size = 0;

function cs_textarea_resize(id, operation) {

  cs_textarea_size = document.getElementById(id).rows;
  if(operation == '-' && cs_textarea_size > 1) {
    document.getElementById(id).rows = cs_textarea_size - 1;
  }
  else if(operation == '+') {
    document.getElementById(id).rows = cs_textarea_size + 1;
  }
  document.getElementById("span_" + id).innerHTML = document.getElementById(id).rows;
}

function passwordcheck(pass) {

	var password_numbers = '0';
	var password_letters = '0';
	var password_lower = '0';
	var password_upper = '0';
	var special = '0';
	var new_pass = pass.split("");
	
	for (x=0;x<new_pass.length;x++) {	
		if (isNaN(new_pass[x])) {
			password_letters++;
		} else {
			password_numbers++;
		}
		var letter = new_pass[x];
		if (letter.match(/[a-z]/)) {
			password_lower++;
		}
		if (letter.match(/[A-Z]/)) {
			password_upper++;
		}
		if (letter.match(/\W/)) {
			special++;
		}
	}
	
	width = "";
	
	if(new_pass.length >= 8) { width = "25%"; }
	if(new_pass.length >= 8 && password_numbers >= 2) {	width = "50%"; }
	if(new_pass.length >= 8 && password_lower >= 3 && password_upper >= 2 && password_numbers >= 2) {	width = "75%"; }
	if(new_pass.length >= 8 && password_lower >= 3 && password_upper >= 2 && password_numbers >= 2 && special > 0) {	width = "100%"; }
	
	document.getElementById("pass_secure").style.width = width;

	
}

var cs_clip_id = 0;

function cs_clip(id) {

	cs_clip_id = id;
  if(document.getElementById("span_" + id).style.display == 'none') {
    document.getElementById("img_" + id).src = document.getElementById("img_" + id).src.replace(/plus/g,'minus');
    document.getElementById("span_" + id).style.display = "block";
  }
  else {
    document.getElementById("img_" + id).src = document.getElementById("img_" + id).src.replace(/minus/g,'plus');
    document.getElementById("span_" + id).style.display = "none";
  }
}

function cs_select_multiple(id, status) {

  var cs_select = document.getElementById(id);
  if(status == 'reverse') {
    for(var i = 0; i < cs_select.options.length; i++) {
      cs_select.options[i].selected = cs_select.options[i].selected == 0 ? 1 : 0;
    }
  }
  else {
    for(var i = 0; i < cs_select.options.length; i++) {
      cs_select.options[i].selected = status;
    }
  }
}

function cs_gamechoose (formular) {
  img = document.getElementById('game_1');
  img.src = img.src.substr(0,img.src.lastIndexOf("/")) + "/" + formular.games_id.options[formular.games_id.selectedIndex].value + ".gif";
}

function abc_set(text, id) {
  
  document.getElementById(id).value = text;
  
}

function abc_insert(aTag,eTag, name) {

	//http://aktuell.de.selfhtml.org/tippstricks/javascript/bbcode/ modified
  var input = document.getElementById(name);
  input.focus();
  /* fuer Internet Explorer */
  
  if(typeof document.selection != 'undefined') {
    /* Einfuegen des Formatierungscodes */
    var range = document.selection.createRange();
    var insText = range.text;
    range.text = aTag + insText + eTag;
    /* Anpassen der Cursorposition */
    range = document.selection.createRange();
    if(insText.length == 0) {
      range.move('character', -eTag.length);
    } else {
      range.moveStart('character', aTag.length + insText.length + eTag.length);      
    }
    range.select();
  }
  /* fuer neuere auf Gecko basierende Browser */
  else if(typeof input.selectionStart != 'undefined')
  {
    /* Einfuegen des Formatierungscodes */
    var start = input.selectionStart;
    var end = input.selectionEnd;
    var insText = input.value.substring(start, end);
    input.value = input.value.substr(0, start) + aTag + insText + eTag + input.value.substr(end);
    /* Anpassen der Cursorposition */
    var pos;
    if(insText.length == 0) {
      pos = start + aTag.length;
    } else {
      pos = start + aTag.length + insText.length + eTag.length;
    }
    input.selectionStart = pos;
    input.selectionEnd = pos;
  }
  /* fuer die uebrigen Browser */
  else
  {
    /* Abfrage der Einfuegeposition */
    var pos;
    var re = new RegExp('^[0-9]{0,3}$');
    while(!re.test(pos)) {
      pos = prompt("Einfuegen an Position (0.." + input.value.length + "):", "0");
    }
    if(pos > input.value.length) {
      pos = input.value.length;
    }
    /* Einfuegen des Formatierungscodes */
    var insText = prompt("Bitte geben Sie den zu formatierenden Text ein:");
    input.value = input.value.substr(0, pos) + aTag + insText + eTag + input.value.substr(pos);
  }
}

function abc_insert_list(aTag,eTag, name) {

	//http://aktuell.de.selfhtml.org/tippstricks/javascript/bbcode/ modified
  var input = opener.document.getElementById(name);
  input.focus();
  /* fuer Internet Explorer */
  
  if(typeof opener.document.selection != 'undefined') {
    /* Einfuegen des Formatierungscodes */
    var range = opener.document.selection.createRange();
    var insText = range.text;
    range.text = aTag + insText + eTag;
    /* Anpassen der Cursorposition */
    range = opener.document.selection.createRange();
    if(insText.length == 0) {
      range.move('character', -eTag.length);
    } else {
      range.moveStart('character', aTag.length + insText.length + eTag.length);      
    }
    range.select();
  }
  /* fuer neuere auf Gecko basierende Browser */
  else if(typeof input.selectionStart != 'undefined')
  {
    /* Einfuegen des Formatierungscodes */
    var start = input.selectionStart;
    var end = input.selectionEnd;
    var insText = input.value.substring(start, end);
    input.value = input.value.substr(0, start) + aTag + insText + eTag + input.value.substr(end);
    /* Anpassen der Cursorposition */
    var pos;
    if(insText.length == 0) {
      pos = start + aTag.length;
    } else {
      pos = start + aTag.length + insText.length + eTag.length;
    }
    input.selectionStart = pos;
    input.selectionEnd = pos;
  }
  /* fuer die uebrigen Browser */
  else
  {
    /* Abfrage der Einfuegeposition */
    var pos;
    var re = new RegExp('^[0-9]{0,3}$');
    while(!re.test(pos)) {
      pos = prompt("Einfuegen an Position (0.." + input.value.length + "):", "0");
    }
    if(pos > input.value.length) {
      pos = input.value.length;
    }
    /* Einfuegen des Formatierungscodes */
    var insText = prompt("Bitte geben Sie den zu formatierenden Text ein:");
    input.value = input.value.substr(0, pos) + aTag + insText + eTag + input.value.substr(pos);
  }
}

function cs_visible(id) {

  if (document.getElementById(id).style.visibility == "hidden") func = "visible"; else func = "hidden";
  document.getElementById(id).style.visibility = func;
}

function cs_display(id) {

  if (document.getElementById(id).style.display == "none") func = "block"; else func = "none";
  document.getElementById(id).style.display = func;
}

function cs_validate(language, module) {
  
  modcontent = document.getElementById('mod_' + language + '_' + module);
  if (modcontent.style.display != "none") {
    modcontent.style.display = "none";
    return;
  }
  modcontent.style.display = "block";
  cs_ajax_getcontent('mods/clansphere/lang_modvalidate.php?language=' + language + '&module=' + module,'mod_' + language + '_' + module);
  
}

function cs_chmod_CheckChange(Checkbox, Value) {
	
	if (document.getElementById(Checkbox).checked == true) {
	
		document.getElementById('chmod').value = parseInt(document.getElementById('chmod').value) + Value;
	
	} else {
		
		document.getElementById('chmod').value = parseInt(document.getElementById('chmod').value) - Value;
		
	}
	
}

function cs_chmod_TextChange() {
	
	var chmod = parseInt(document.getElementById('chmod').value);
	
	document.getElementById('owner_read').checked = false;
	document.getElementById('owner_write').checked = false;
	document.getElementById('owner_execute').checked = false;
	
	document.getElementById('group_read').checked = false;
	document.getElementById('group_write').checked = false;
	document.getElementById('group_execute').checked = false;
	
	document.getElementById('public_read').checked = false;
	document.getElementById('public_write').checked = false;
	document.getElementById('public_execute').checked = false;
	
	if (chmod >= 400) {
		document.getElementById('owner_read').checked = true;
		chmod = chmod - 400;
	}
	if (chmod >= 200) {
		document.getElementById('owner_write').checked = true;
		chmod = chmod - 200;
	}
	if (chmod >= 100) {
		document.getElementById('owner_execute').checked = true;
		chmod = chmod - 100;
	}
	
	if (chmod >= 40) {
		document.getElementById('group_read').checked = true;
		chmod = chmod - 40;
	}
	if (chmod >= 20) {
		document.getElementById('group_write').checked = true;
		chmod = chmod - 20;
	}
	if (chmod >= 10) {
		document.getElementById('group_execute').checked = true;
		chmod = chmod - 10;
	}
	
	if (chmod >= 4) {
		document.getElementById('public_read').checked = true;
		chmod = chmod - 4;
	}
	if (chmod >= 2) {
		document.getElementById('public_write').checked = true;
		chmod = chmod - 2;
	}
	if (chmod >= 1) {
		document.getElementById('public_execute').checked = true;
		chmod = chmod - 1;
	}
}

function cs_shoutbox_select() {
  
  elements = document.getElementsByTagName('input');
  
  for (run = 0; run < elements.length; run++) {
    if (elements[run].name.substr(0,7) == 'select_') {
      elements[run].checked = true;
    }
  }
  
}

function js_toggle_all(formobj, formtype, option, exclude, setto) {
	for (var i =0; i < formobj.elements.length; i++)
	{
		var elm = formobj.elements[i];
		if (elm.type == formtype)
		{
			switch (formtype)
			{
				case 'radio':
					if (elm.value == option) // option == '' evaluates true when option = 0
					{
						elm.checked = setto;
					}
				break;
				case 'select-one':
					elm.selectedIndex = setto;
				break;
				default:
					elm.checked = setto;
				break;
			}
		}
	}
}

function js_check_all(formobj) {

    exclude = new Array();
    exclude[0] = 'keepattachments';
    exclude[1] = 'allbox';
    exclude[2] = 'removeall';
    js_toggle_all(formobj, 'checkbox', '', exclude, formobj.allbox.checked);
}

var cs_debugheight = 0;

function cs_debugmode() {

  if(cs_debugheight == 0)
    cs_debugheight = document.getElementById('debug').style.height;
  if(cs_debugheight == 0)
    cs_debugheight = document.getElementById('debug').offsetHeight + 'px';
  if(cs_debugheight == 0)
    cs_debugheight = document.getElementById('debug').clientHeight + 'px';

  height = document.getElementById('debug').style.height;
  document.getElementById('debug').style.height = height == '100%' ? cs_debugheight : '100%';
}

function cs_visible(id) {

  var cs_lines_shown = document.getElementById(id).style.visibility;

  if(cs_lines_shown == 'hidden')
    document.getElementById(id).style.visibility = 'visible';
  else
    document.getElementById(id).style.visibility = 'hidden';
}