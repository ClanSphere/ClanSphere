<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="3">{lang:mod} - {lang:manage}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:editpaste} {lang:create} {if:access} / <a href="{url:abcode_import}">{lang:import}</a>{stop:access}</td>
    <td class="leftb">{icon:contents} {lang:total}: {lang:count}</td>
    <td class="rightb">{pages:list}</td>
  </tr>
  <tr>
    <td class="leftb" colspan="3">{lang:function}
      <form method="post" id="abcode_manage" action="{action:form}">
        <select name="type" >
          <option value="0">----</option>
          <option value="img">{lang:img}</option>
          <option value="str">{lang:str}</option>
        </select>
        <input type="submit" name="submit" value="{lang:show}" />
      </form></td>
  </tr>
</table>
<br />
{lang:getmsg}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{sort:function} {lang:function}</td>
    <td class="headb">{sort:pattern} {lang:pattern}</td>
    <td class="headb">{lang:result}</td>
    <td class="headb" colspan="2">{lang:options}</td>
  </tr>
  {loop:abcode}
  <tr>
    <td class="leftc">{abcode:function}</td>
    <td class="leftc">{abcode:pattern}</td>
    <td class="leftc">{abcode:result}</td>
    <td class="leftc">{abcode:edit}</td>
    <td class="leftc">{abcode:remove}</td>
  </tr>
  {stop:abcode}
</table>
