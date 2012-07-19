<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:edit}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:body_edit_email}</td>
  </tr>
</table>
<br />

<form method="post" id="messages_mail" action="{url:messages_mail}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="leftc">{icon:configure} {lang:more}</td>
    <td class="leftb"><input type="checkbox" name="autoresponder_mail" value="1" {check:responder}/> {lang:autoresponder_mail}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
      <input type="hidden" name="autoresponder_id" value="{hidden:id}" />
      <input type="hidden" name="update" value="{hidden:update}" />
      <input type="submit" name="submit" value="{lang:edit}" />
          </td>
  </tr>
</table>
</form>