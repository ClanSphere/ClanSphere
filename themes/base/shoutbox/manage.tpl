<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb" colspan="2">{lang:mod_name} - {lang:manage}</td>
 </tr>
 <tr>
  <td class="leftb">{icon:contents} {lang:total}: {count:all}</td>
  <td class="leftb">{page:list}</td>
 </tr>
</table>
<br />
{head:message}
<form method="post" id="shoutbox_manage" name="shoutbox_manage" action="{url:shoutbox_multiremove}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb">{sort:nick} {lang:nick}</td>
  <td class="headb">{sort:date} {lang:date}</td>
  <td class="headb" colspan="4">{lang:options}</td>
 </tr>{loop:shoutbox}
 <tr>
  <td class="leftc">{shoutbox:shoutbox_name}</td>
  <td class="leftc">{shoutbox:time}</td>
  <td class="leftc"><input name="select_{shoutbox:shoutbox_id}" type="checkbox" value="1" /></td>
  <td class="leftc"><a href="{shoutbox:url_edit}" title="{lang:edit}">{icon:edit}</a></td>
  <td class="leftc"><a href="{shoutbox:url_remove}" title="{lang:remove}">{icon:editdelete}</a></td>
  <td class="leftc"><a href="{shoutbox:url_ip}" title="{lang:ip}">{icon:important}</a></td>
 </tr>{stop:shoutbox}
 <tr>
  <td class="rightb" colspan="6">
    <input type="button" value="{lang:select_all}"  onclick="return cs_select_checkboxes(this);" />
    <input type="submit" value="{lang:delete_selected}" />
    <input type="reset" value="{lang:remove_selection}" />
   </td>
 </tr>
</table>
</form>