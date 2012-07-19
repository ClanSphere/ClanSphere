<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="2">{lang:mod_name} - {lang:themes}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:body}</td>
    <td class="centerb">{icon:ark} <a href="{link:cache}">{lang:cache}</a> </td>
  </tr>
</table>
<br />
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:name}</td>
    <td class="headb">{lang:active}</td>
  </tr>
  {loop:themes_list}
  <tr>
    <td class="leftc">{themes_list:name}</td>
    <td class="leftc">{themes_list:active}</td>
  </tr>
  {stop:themes_list}
</table>
