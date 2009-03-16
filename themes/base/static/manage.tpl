<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb" colspan="3">{lang:mod} - {lang:manage}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:editpaste} <a href="{url:new_staticpage}">{lang:new_staticpage}</a></td>
    <td class="leftb">{icon:contents} {lang:total}: {head:total}</td>
    <td class="rightb">{head:pages} </td>
  </tr>
  <tr>
    <td class="leftb" colspan="3"> {lang:access}:
      <form method="post" id="static_manage" action="{url:form}">
        {head:dropdown}
        <input type="submit" name="submit" value="{lang:show}" />
      </form></td>
  </tr>
</table>
<br />
{head:message}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{sort:id}  {lang:id}</td>
    <td class="headb">{sort:title} {lang:title}</td>
    <td class="headb">{lang:access}</td>
    <td class="headb" colspan="2">{lang:options} </td>
  </tr>
  {loop:static}
  <tr>
    <td class="rightc">{static:static_id}</td>
    <td class="leftc"><a href="{static:url_view}" title="{lang:show}">{static:static_title}</td>
    <td class="leftc">{static:static_access}</td>
    <td class="leftc" style="width:25px"><a href="{static:url_edit}" title="{lang:edit}">{icon:edit}</a></td>
    <td class="leftc" style="width:25px"><a href="{static:url_delete}" title="{lang:remove}">{icon:editdelete}</a> </td>
  </tr>
  {stop:static}
</table>
