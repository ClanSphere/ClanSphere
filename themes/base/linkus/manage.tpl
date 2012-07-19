<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb" colspan="2">{lang:mod_name} - {lang:manage}</td>
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
    <td class="headb">{sort:banner} {lang:banner}</td>
    <td class="headb">{lang:mass}</td>
    <td class="headb" colspan="2">{lang:options}</td>
  </tr>
  {loop:linkus}
  <tr>
    <td class="leftc">{linkus:name}</td>
    <td class="leftc">{linkus:banner}</td>
    <td class="leftc">{linkus:mass}</td>
    <td class="leftc"><a href="{url:linkus_edit:id={linkus:id}}" title="{lang:edit}">{icon:edit}</a></td>
    <td class="leftc"><a href="{url:linkus_remove:id={linkus:id}}" title="{lang:remove}">{icon:editdelete}</a></td>
  </tr>
  {stop:linkus}
</table>