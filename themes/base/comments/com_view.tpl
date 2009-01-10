{comments:message}

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
<tr>
  <td class="bottom" colspan="2"><div style="float:left">{lang:comments} {comments:sum}</div>
    <div style="float:right">{comments:pages}</div></td>
</tr>
{loop:content}
<tr>
  <td class="{content:class}" style="width:150px"><img src="{page:path}{content:img_url}" style="height:11px;width:16px" alt="" /> {content:users_link}<br />
    {content:users_avatar}<br />
    {content:users_status} {content:users_laston}<br />
    <br />
    {lang:place} {content:content_place}<br />
    {lang:posts} {content:posts}</td>
  <td class="{content:class}"> # {content:current} - {content:comments_time}<a href="#" name="com{content:run}"></a>
    <hr style="width:100%" noshade="noshade" />
    <br />
    {content:comments_text}
    {content:comments_edit}
    {content:edit_delete}</td>
</tr>
{stop:content}
</table>