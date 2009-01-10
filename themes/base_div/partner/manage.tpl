<div class="container" style="width:{page:width};">
  <div class="headb">{lang:mod} - {lang:manage}</div>
  <div class="headc clearfix">
    <div class="leftb fl">{icon:editpaste} <a href="{link:create}">{lang:new_partner}</a></div>
    <div class="rightb fr">{head:pages} </div>
  </div>
  <div class="headc clearfix">
    <div class="leftb fr">{icon:contents} {lang:total}: {head:total}</div>
  </div>
</div>
<br />
{head:message}
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width};">
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
