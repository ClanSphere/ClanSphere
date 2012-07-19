<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb" colspan="2">{lang:mod_name} - {lang:head_manage}</td>
  </tr>
  <tr>    
    <td class="leftb">{icon:contents} {lang:total}: {head:count}</td>
    <td class="rightb">{head:pages}</td>
  </tr>
</table>
<br />

{head:getmsg}

<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{sort:name} {lang:name}</td>
    <td class="headb" colspan="2" style="width:20%">{lang:options}</td>
  </tr>
  {loop:ranks}
  <tr>
    <td class="leftc">{ranks:name}</td>
    <td class="leftc"><a href="{url:ranks_edit:id={ranks:id}}" title="{lang:edit}">{icon:edit}</a></td>
    <td class="leftc"><a href="{url:ranks_remove:id={ranks:id}}" title="{lang:remove}">{icon:editdelete}</a></td>
  </tr>
  {stop:ranks}
</table>