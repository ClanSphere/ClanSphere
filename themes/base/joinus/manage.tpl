<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb" colspan="3">{lang:mod_name} - {lang:manage}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:editpaste} <a href="{url:joinus_new}">{lang:new_join}</a></td>
    <td class="leftb">{icon:contents} {lang:total}: {head:count}</td>
    <td class="rightb">{head:pages}</td>
  </tr>
</table>
<br />

{head:getmsg}

<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{lang:game}</td>
    <td class="headb">{sort:nick} {lang:nick}</td>
    <td class="headb">{sort:age} {lang:age}</td>
    <td class="headb">{sort:since} {lang:since}</td>
    <td class="headb" colspan="2">{lang:options}</td>
  </tr>
  {loop:join}
  <tr>
    <td class="leftc">{join:game}</td>
    <td class="leftc">{join:nick}</td>
    <td class="leftc">{join:age}</td>
    <td class="leftc">{join:since}</td>
    <td class="leftc"><a href="{join:url_convert}" title="{lang:convert}">{icon:kuser}</a></td>
    <td class="leftc"><a href="{join:url_remove}" title="{lang:remove}">{icon:editdelete}</a></td>
  </tr>
  {stop:join}
</table>