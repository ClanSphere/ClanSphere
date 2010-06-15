<form method="post" id="boardmods_manage" action="{url:boardmods_manage}">
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb" colspan="3">{lang:mod_name} - {lang:manage}</td>
  </tr>
  <tr>    
    <td class="leftb">{icon:contents} {lang:total}: {head:count}</td>
    <td class="rightb">{head:pages}</td>
  </tr>
  <tr>
    <td class="leftb" colspan="3">{lang:rank}:
      {head:cat_dropdown}
      <input type="submit" name="submit" value="{lang:show}" />
    </td>
  </tr>
</table>
</form>
<br />
{head:getmsg}

<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{sort:users_nick} {lang:user}</td>
    <td class="headb">{lang:modpanel}</td>
    <td class="headb">{lang:edit}</td>
    <td class="headb">{lang:remove}</td>
    <td class="headb" colspan="2">{lang:options}</td>
  </tr>
  {loop:bm}
  <tr>
    <td class="leftc">{bm:boardmods_user}</td>
    <td class="leftc">{bm:boardmods_modpanel}</td>
    <td class="leftc">{bm:boardmods_edit}</td>
    <td class="leftc">{bm:boardmods_del}</td>
    <td class="leftc"><a href="{bm:url_edit}" title="{lang:edit}">{icon:edit}</a></td>
    <td class="leftc"><a href="{bm:url_remove}" title="{lang:remove}">{icon:editdelete}</a></td>
  </tr>
  {stop:bm}
</table>
