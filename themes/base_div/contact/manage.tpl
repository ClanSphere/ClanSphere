<div class="container" style="width:{page:width}">
	<div class="headb">{lang:mod} - {lang:manage}</div>
        <div class="leftb">{lang:head_manage}</div>
    <div class="headc clearfix">
        <div class="leftb fl">{icon:folder_yellow} <a href="{url:contact_archive}">{lang:archive}</a></div>
        <div class="rightb fr">{head:pages}</div>
    </div>
</div>
<br />
{head:message}
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
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
<td class="leftb"><a href="{url:contact_view,id={mail:mail_id}}">{mail:mail_subject}</a></td>
<td class="leftb">{mail:mail_date}</td>
<td class="leftb">
<a href="{url:contact_answer,id={mail:mail_id}}">{icon:mail}</a>
<a href="{url:contact_delete,id={mail:mail_id}}">{icon:editdelete}</a>
</td></tr>
{stop:mail}
</table>
<br />

<div class="container" style="width:{page:width}">
    <div class="headb">
    {lang:imprinttxt}
    </div>
    <div class="headc clearfix">
        <div class="leftb fl"><a href="{url:imp_edit}">{lang:imp_edit}</a></div>
        <div class="leftb fr">{lang:lastchange} {body:date}</div>
    </div>
</div>