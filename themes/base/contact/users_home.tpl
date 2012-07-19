<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
<tr><td class="headb" colspan="3">
{lang:last_mails}
</td></tr>
<tr>
<td class="leftc">{lang:name}</td>
<td class="leftc">{lang:subject}</td>
<td class="leftc">{lang:date}</td>
</tr>

{loop:mail}
<tr>
<td class="leftb">{mail:name}</td>
<td class="leftb"><a href="{url:contact_view:id={mail:id}}">{mail:subject}</a></td>
<td class="leftb" style="width:200px">{mail:date}</td>
</tr>
{stop:mail}
</table>