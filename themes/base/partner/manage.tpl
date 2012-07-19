<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb" colspan="2">{lang:mod_name} - {lang:manage}</td>
  </tr>
  <tr>    
    <td class="leftb">{icon:contents} {lang:total}: {head:total}</td>
    <td class="rightb">{head:pages} </td>
  </tr>
</table>
<br />
{head:message}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb"> {sort:name} {lang:name}</td>
    <td class="headb"> {sort:category} {lang:category}</td>
    <td class="headb" style="width:100px"> {sort:priority} {lang:priority}</td>
    <td class="headb" colspan="2" style="width:50px"> {lang:options} </td>
  </tr>
  {loop:partner}
  <tr>
    <td class="leftc">{partner:name}</td>
    <td class="leftc">{partner:categories_name}</td>
    <td class="rightc">{partner:priority}</td>
    <td class="leftc"><a href="{partner:url_edit}" title="{lang:edit}">{icon:edit}</a></td>
    <td class="leftc"><a href="{partner:url_delete}" title="{lang:remove}">{icon:editdelete}</a> </td>
  </tr>
  {stop:partner}
</table>
