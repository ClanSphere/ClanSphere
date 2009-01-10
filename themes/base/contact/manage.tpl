<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
<tr><td class="headb" colspan="3">
{lang:mod} - {lang:manage}
</td></tr>
<tr><td class="leftb">
{lang:head_manage}</td>
<td class="leftb">{icon:folder_yellow} <a href="{url:contact_archive}">{lang:archive}</a></td>
<td class="rightb">
{head:pages}
</td></tr>
</table>
<br />
{head:message}
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
<td class="leftb">{mail:mail_name}</td>
<td class="leftb">{mail:categories_name}</td>
<td class="leftb"><a href="{url:contact_view:id={mail:mail_id}}">{mail:mail_subject}</a></td>
<td class="leftb">{mail:mail_date}</td>
<td class="leftb">
<a href="{url:contact_answer:id={mail:mail_id}}">{icon:mail}</a>
<a href="{url:contact_delete:id={mail:mail_id}}">{icon:editdelete}</a>
</td></tr>
{stop:mail}
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
<tr><td class="headb" colspan="2">
{lang:imprinttxt}
</td></tr>
<tr><td class="leftb">
<a href="{url:imp_edit}">{lang:imp_edit}</a></td>
<td class="leftb">{lang:lastchange} {body:date}
</td></tr>
</table>