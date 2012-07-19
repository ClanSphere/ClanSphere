{if:form}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
<tr><td class="headb">
{lang:mailsig} - {lang:head_edit}
</td></tr>
<tr><td class="leftb">
{lang:body_edit}
</td></tr>
</table>
<br />

<form method="post" id="mailsig_edit" action="{url:contact_mailsig_edit}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
<tr>
  <td class="leftc">{icon:kate} {lang:mailsig}</td>
  <td class="leftb">
    <textarea name="mailsig" cols="50" rows="20" id="mailsig">{mailsig:content}</textarea>
  </td>
</tr>
<tr><td class="leftc">
{icon:ksysguard} {lang:options}</td><td class="leftb">
<input type="submit" name="submit" value="{lang:edit}" />
</td></tr>
</table>
</form>
{stop:form}

{if:done}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
<tr><td class="headb">
{lang:mailsig} - {lang:head_edit}
</td></tr>
<tr><td class="leftc">
{lang:changes_done}
</td></tr>
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
<tr><td class="centerb">
<a href="{url:contact_options}">{lang:continue}</a>
</td></tr>
</table>
<br />
{stop:done}