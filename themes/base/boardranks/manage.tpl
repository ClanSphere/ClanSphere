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
    <td class="headb">{sort:boardranks_min} {lang:min}</td>
    <td class="headb">{sort:boardranks_name} {lang:rankname}</td>
    <td class="headb" colspan="2">{lang:options}</td>
  </tr>
  {loop:bora}
  <tr>
    <td class="leftc">{bora:boardranks_min}</td>
    <td class="leftc">{bora:boardranks_name}</td>
    <td class="leftc"><a href="{bora:url_edit}" title="{lang:edit}">{icon:edit}</a></td>
    <td class="leftc"><a href="{bora:url_remove}" title="{lang:remove}">{icon:editdelete}</a></td>
  </tr>
  {stop:bora}
</table>
