<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="{head:colspan}">{lang:mod_name} - {lang:manage}</td>
  </tr>
  <tr>    
    {if:access}<td class="leftb" style="width: 25%">{icon:download} <a href="{url:abcode_import}">{lang:import}</a></td>{stop:access}
    <td class="leftb">{icon:contents} {lang:total}: {lang:count}</td>
    <td class="rightb">{pages:list}</td>
  </tr>
  <tr>
    <td class="leftb" colspan="{head:colspan}">
      <form method="post" id="abcode_manage" action="{action:form}">
      <fieldset style="border: 0; padding: 0">
        {lang:function}
        <select name="type">
          <option value="0">----</option>
          <option value="img" {sel:img}>{lang:img}</option>
          <option value="str" {sel:str}>{lang:str}</option>
        </select>
        <input type="submit" name="submit" value="{lang:show}" />
      </fieldset>
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
    <td class="headb">{sort:order} {lang:order}</td>
    <td class="headb" colspan="2">{lang:options}</td>
  </tr>
  {loop:abcode}
  <tr>
    <td class="leftc">{abcode:function}</td>
    <td class="leftc">{abcode:pattern}</td>
    <td class="leftc">{abcode:result}</td>
    <td class="leftc">{abcode:order}</td>
    <td class="leftc">{abcode:edit}</td>
    <td class="leftc">{abcode:remove}</td>
  </tr>
  {stop:abcode}
</table>