<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb" colspan="3">{lang:mod_name} - {lang:head_center}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:editpaste} <a href="{url:computers_create}">{lang:new_computer}</a></td>
    <td class="leftb">{icon:contents} {lang:total}: {head:count}</td>
    <td class="rightb">{head:pages}</td>
  </tr>
</table>
<br />

{head:getmsg}

<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{sort:name} {lang:name}</td>
    <td class="headb">{sort:since} {lang:date}</td>
    <td class="headb" colspan="3" style="width:20%">{lang:options}</td>
  </tr>
  {loop:com}
  <tr>
    <td class="leftc"><a href="{url:computers_view:id={com:id}}">{com:name}</a></td>
    <td class="rightc">{com:since}</td>
    <td class="leftc"><a href="{url:computers_picture:id={com:id}}" title="{lang:picture}">{icon:image}</a></td>
    <td class="leftc"><a href="{url:computers_edit:id={com:id}}" title="{lang:edit}">{icon:edit}</a></td>
    <td class="leftc"><a href="{url:computers_remove:id={com:id}}" title="{lang:remove}">{icon:editdelete}</a></td>
  </tr>
  {stop:com}
</table>