<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
<tr>
<td class="headb" colspan="2">
{lang:mod_name} - {lang:blocklist}
</td>
</tr>
<tr>
<td class="leftb">{lang:blocklist_head}</td>
<td class="rightb">{head:pages}</td>
</tr>
</table>
<br />
{head:message}
<form method="post" id="contact_blocklist" action="{url:contact_blocklist}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
<tr>
<td class="leftc" style="min-width: 15%">{lang:domain}</td>
<td class="leftb">
<input type="text" name="blocklist_entry" value="" maxlength="200" size="50" />
<input type="submit" name="submit" value="{lang:create}" />
</td>
</tr>
</table>
</form>
<br />
{if:status}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
<tr>
<td class="centerc">{status:msg}</td>
</tr>
</table>
<br />
{stop:status}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
<tr>
<td class="headb">{head:sort_name} {lang:domain}</td>
<td class="headb" style="width: 150px">{lang:options}</td>
</tr>
{loop:trash}
<tr>
<td class="leftc">{trash:trashmail_entry}</td>
<td class="centerc">
<a href="{url:contact_blocklist:delete={trash:trashmail_id}}">{icon:editdelete}</a>
</td></tr>
{stop:trash}
</table>