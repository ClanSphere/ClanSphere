<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb" colspan="2">{lang:mod_name} - {lang:manage}</td>
  </tr>
  <tr>    
    <td class="leftb">{icon:contents} {lang:total}: {head:total}</td>
    <td class="rightb">{head:pages} </td>
  </tr>
  <tr>
    <td class="leftb" colspan="2">
      <form method="post" id="static_manage" action="{url:static_manage}">
      <fieldset style="border: 0; padding: 0">
        {lang:access}:
        <select name="where">
        {loop:access}
          <option value="{access:level_id}" {access:selected}>{access:level_id} - {access:level_name}</option>
        {stop:access}
         </select>
        <input type="submit" name="submit" value="{lang:show}" />
      </fieldset>
      </form>
    </td>
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
    <td class="leftc"><a href="{static:url_view}" title="{lang:show}">{static:static_title}</a></td>
    <td class="leftc">{static:static_access}</td>
    <td class="leftc" style="width:25px"><a href="{static:url_edit}" title="{lang:edit}">{icon:edit}</a></td>
    <td class="leftc" style="width:25px"><a href="{static:url_delete}" title="{lang:remove}">{icon:editdelete}</a> </td>
  </tr>
  {stop:static}
</table>