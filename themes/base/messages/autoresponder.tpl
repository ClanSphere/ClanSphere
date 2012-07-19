<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:edit}</td>
  </tr>
  <tr>
    <td class="leftb">{head:body}</td>
  </tr>
</table>
<br />

{if:preview}
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb" colspan="2">{lang:mod_name} - {lang:text}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:subject}</td>
    <td class="leftb">{lang:autoresponder} {autoresponder:subject}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:date}</td>
    <td class="leftb">{autoresponder:time}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:to}</td>
    <td class="leftb"></td>
  </tr>
  <tr>
    <td class="leftb">{lang:options}</td>
    <td class="leftb">
      {icon:back}
      {icon:mail_replay}
      {icon:mail_delete}
    </td>
  </tr>
  <tr>
    <td class="headb" colspan="2">{autoresponder:subject}</td>
  </tr>
  <tr>
    <td class="leftb" colspan="2">
      {autoresponder:text}
    </td>
  </tr>
</table>
<br />
{stop:preview}

<form method="post" id="messages_autoresponder" action="{url:messages_autoresponder}">
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="leftc">{icon:kedit} {lang:subject} *</td>
    <td class="leftb"><input type="text" name="autoresponder_subject" value="{autoresponder2:subject}" maxlength="200" size="50" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:kate} {lang:text} *<br />
      <br />
      {abcode:smileys}
    </td>
    <td class="leftb">
      {abcode:features}
      <textarea class="rte_abcode" name="autoresponder_text" cols="50" rows="20" id="autoresponder_text">{autoresponder2:text}</textarea>
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:configure} {lang:more}</td>
    <td class="leftb"><input type="checkbox" name="autoresponder_close" value="1" {check:close}/> {lang:messages_autoresponder}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
      <input type="hidden" name="autoresponder_id" value="{autoresponder:id}" />
      <input type="hidden" name="update" value="{autoresponder:update}" />
      <input type="submit" name="submit" value="{lang:edit}" />
      <input type="submit" name="preview" value="{lang:preview}" />
    </td>
  </tr>
</table>
</form>