<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb" colspan="3">{lang:mod_name} - {lang:manage}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:contents} {lang:total}: {head:total}</td>
    <td class="rightb">{head:pages}</td>
  </tr>
</table>
<br />
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb"> {sort:title} {lang:title}</td>
  </tr>
  {loop:static}
  <tr>
    <td class="leftc"><a href="{static:url_view}" title="{lang:show}">{static:static_title}</a></td>
  </tr>
  {stop:static}
</table>
