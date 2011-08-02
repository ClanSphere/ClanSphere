// ClanSphere 2010 - www.clansphere.net
// $Id$


$(function(){

  $(".clip").live('click', function () { 
    $(this).children('img').toggle();
    $(this).next('div').slideToggle("slow");
    return false;
  }).next('div').hide();

  $(document).bind('csAjaxLoad', function(e,ele) {
    $(ele).find('.clip').next('div').hide();
  });
  
  $(".visible").live('click', function () { 
    $(this).prev('div').toggle(function() {
       $(this).css('visibility', 'hidden');
     }, function() {
       $(this).css('visibility', 'visibile');
     });
  });

});

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

  w = "";

  if(new_pass.length >= 8) { w = "25%"; }
  if(new_pass.length >= 8 && password_numbers >= 2) {  w = "50%"; }
  if(new_pass.length >= 8 && password_lower >= 3 && password_upper >= 2 && password_numbers >= 2) {  w = "75%"; }
  if(new_pass.length >= 8 && password_lower >= 3 && password_upper >= 2 && password_numbers >= 2 && special > 0) {  w = "100%"; }

  $("#pass_secure").css('width', w);
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

function cs_display(id) {

  $("#" + id).slideToggle('slow');
}

function cs_visible(id) {

  if($("#" + id).css('visibility') == 'visible')
    $("#" + id).css('visibility', 'hidden');
  else
    $("#" + id).css('visibility', 'visible');
}


function cs_validate(language, module) {
  
  modcontent = $('#mod_' + language + '_' + module);
  if (modcontent.style.display != "none") {
    modcontent.style.display = "none";
    return;
  }
  modcontent.style.display = "block";
  $.ajax({ url: 'mods/clansphere/lang_modvalidate.php?language=' + language + '&module=' + module, context: '#mod_' + language + '_' + module });
  
}

function cs_chmod_CheckChange(Checkbox, Value) {
  
  if ($("#" + Checkbox).is(':checked') == true) {
  
    $('#chmod').attr('value', parseInt($('#chmod').attr('value')) + Value);
  
  } else {
    
    $('#chmod').attr('value', parseInt($('#chmod').attr('value')) - Value);
    
  }
  
}

function cs_chmod_TextChange() {
  
  var chmod = parseInt($('#chmod').attr('value'));
  
    $('form#explorer_chmod :checkbox').attr('checked', false);

  if (chmod >= 400) {
    $('#owner_read').attr('checked', true);
    chmod = chmod - 400;
  }
  if (chmod >= 200) {
    $('#owner_write').attr('checked', true);
    chmod = chmod - 200;
  }
  if (chmod >= 100) {
    $('#owner_execute').attr('checked', true);
    chmod = chmod - 100;
  }
  
  if (chmod >= 40) {
    $('#group_read').attr('checked', true);
    chmod = chmod - 40;
  }
  if (chmod >= 20) {
    $('#group_write').attr('checked', true);
    chmod = chmod - 20;
  }
  if (chmod >= 10) {
    $('#group_execute').attr('checked', true);
    chmod = chmod - 10;
  }
  
  if (chmod >= 4) {
    $('#public_read').attr('checked', true);
    chmod = chmod - 4;
  }
  if (chmod >= 2) {
    $('#public_write').attr('checked', true);
    chmod = chmod - 2;
  }
  if (chmod >= 1) {
    $('#public_execute').attr('checked', true);
    chmod = chmod - 1;
  }
}

function cs_select_checkboxes(formcontent) {

  elements = formcontent.form.getElementsByTagName('input');
  
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
    cs_debugheight = $('#debug').css('height');

  height = $('#debug').css('height');
  $('#debug').css('height', height == '100%' ? cs_debugheight : '100%');
}

function cs_bookmark(uri, title) {

  // trident + ie
  if(window.external && document.all) {
    window.external.AddFavorite(uri, title);
  }
  // mozilla + firefox and presto + opera
  else if(window.sidebar) {
    window.sidebar.addPanel(title, uri, '');
  }
  // handle opera hotlist
  else if(window.opera && window.print) {
    return true;
  }
}
