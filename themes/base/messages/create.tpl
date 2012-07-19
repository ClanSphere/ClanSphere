{if:preview}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="2">{lang:mod_name} - {var:subject}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:subject}</td>
    <td class="leftb">{var:subject}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:date}</td>
    <td class="leftb">{var:date}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:to}</td>
    <td class="leftb">{loop:to}{to:users_nick}; {stop:to}</td>
  </tr>
  <tr>
    <td class="headb" colspan="2">{lang:mod_name} - {lang:text}</td>
  </tr>
  <tr>
    <td class="leftb" colspan="2">{var:text}</td>
  </tr>
</table>
<br />{stop:preview}

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:head_create}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:body_create}</td>
  </tr>
</table>
<br />

<form method="post" id="messages_create" action="{url:messages_create}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">

  <tr>
    <td class="leftc">{icon:personal} {lang:to} *</td>
    <td class="leftb">
    <input type="text" name="messages_to" id="messages_to" value="{msg:to}" autocomplete="off" onkeyup="Clansphere.ajax.user_autocomplete('messages_to', 'search_users_result' ,'{page:path}')" maxlength="200" size="50" /><br />
      <div id="search_users_result"></div>  
     </td>
  </tr>
  <tr>
    <td class="leftc">{icon:kedit} {lang:subject} *</td>
    <td class="leftb"><input type="text" name="messages_subject" value="{msg:subject}" maxlength="200" size="50" /></td>
  </tr>
  <tr>
    <td class="leftc">
      {icon:kate} {lang:text} *<br /><br />
      {msg:smileys}
     </td>
    <td class="leftb">
      {msg:abcode}
      <textarea class="rte_abcode" name="messages_text" cols="50" rows="15" id="messages_text">{msg:text}</textarea></td>
  </tr>
  <tr>
    <td class="leftc">{icon:configure} {lang:more}</td>
    <td class="leftb"><input type="checkbox" name="messages_show_sender" value="1"{checked:show_sender} /> {lang:messages_show_sender}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
      <input type="hidden" name="reply_id" value="{var:reply_id}" />
      <input type="submit" name="submit" value="{lang:send}" />
      <input type="submit" name="preview" value="{lang:preview}" />
           </td>
  </tr>
</table>
</form>