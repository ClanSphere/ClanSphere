<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
<tr><td class="headb" colspan="3">
{lang:mod_name} - {lang:head_archive}
</td></tr>
<tr><td class="leftb">
{lang:body_archive}</td>
<td class="leftb">{icon:kontact} <a href="{url:contact_manage}">{lang:manage}</a></td>
<td class="rightb">
{head:pages}
</td>
</tr>
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
<tr>
<td class="headb">{head:sort_name} {lang:name}</td>
<td class="headb">{lang:request}</td>
<td class="headb">{head:sort_subject} {lang:subject}</td>
<td class="headb">{head:sort_date} {lang:date}</td>
<td class="headb" style="width:50px">{lang:options}</td>
</tr>

{loop:mail}
<tr>
<td class="leftc">{mail:mail_name}</td>
<td class="leftc">{mail:categories_name}</td>
<td class="leftc"><a href="{url:contact_view:id={mail:mail_id}}">{mail:mail_subject}</a></td>
<td class="leftc">{mail:mail_date}</td>
<td class="leftc">
<a href="{url:contact_delete:id={mail:mail_id}}">{icon:editdelete}</a>
</td></tr>
{stop:mail}
</table>
<br />
