<div class="container" style="width:{page:width}">
  <div class="headb">{lang:mod} - {lang:manage}</div>
  <div class="headc clearfix">
  	<div class="leftb fl">{icon:contents} {lang:total}: {count:all}</div>
  	<div class="leftb fr">{page:list}</div>
  </div>
</div>
<br />
{head:message}
<form method="post" action="{url:shoutbox_multiremove}">
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
 <tr>
  <td class="headb">{sort:nick} {lang:nick}</td>
  <td class="headb">{sort:date} {lang:date}</td>
  <td class="headb" colspan="4">{lang:options}</td>
 </tr>{loop:shoutbox}
 <tr>
  <td class="leftb">{shoutbox:shoutbox_name}</td>
  <td class="leftb">{shoutbox:time}</td>
  <td class="leftb"><input name="select_{shoutbox:shoutbox_id}" type="checkbox" value="1" /></td>
  <td class="leftb"><a href="{shoutbox:url_edit}" title="{lang:edit}">{icon:edit}</a></td>
  <td class="leftb"><a href="{shoutbox:url_remove}" title="{lang:remove}">{icon:editdelete}</a></td>
  <td class="leftb"><a href="{shoutbox:url_ip}" title="{lang:ip}">{icon:important}</a></td>
 </tr>{stop:shoutbox}
 <tr>
  <td class="rightc" colspan="6">
    <input type="button" value="{lang:select_all}"  onclick="return cs_shoutbox_select();" />
    <input type="submit" value="{lang:delete_selected}"  />
    <input type="reset" value="{lang:remove_selection}"  />
   </td>
 </tr>
</table>
</form>