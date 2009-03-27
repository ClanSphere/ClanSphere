<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="3">{lang:mod} - {lang:teams}</td>
  </tr>
  <tr>
    <td class="leftc"><a href="{url:cups_manage}">{lang:back}</a></td>
    <td class="leftc">{icon:contents} {lang:total}: {count:all}</td>
    <td class="leftc">{pages:list} </td>
  </tr>
</table>
<br />
{var:message}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{sort:name} {lang:name}</td>
    <td class="headb">{sort:join} {lang:join}</td>
    <td class="headb">{lang:options}</td>
  </tr>{loop:teams}
  <tr>
    <td class="leftc">{teams:team}</td>
    <td class="leftc">{teams:join}</td>
    <td class="leftc"><a href="{url:cups_teamremove:id={teams:cupsquads_id}}" title="{lang:remove}">{icon:editdelete}</a></td>
  </tr>{stop:teams}
</table>