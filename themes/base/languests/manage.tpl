<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="3">{lang:mod} - {lang:manage}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:editpaste} {lang:new}</td>
    <td class="leftb">{icon:contents} {lang:total}: {count:all}</td>
    <td class="rightb">{pages:list}</td>
  </tr>
  <tr>
    <td class="leftb" colspan="2"> {lang:select_lan}
      <form method="post" name="languests_manage" action="{url:form}">
        <select name="where" >
          <option value="0">----</option>
          {loop:lanpartys}
		  <option value="{lanpartys:id}">{lanpartys:name}</option>
          {stop:lanpartys}
        </select>
        <input type="submit" name="submit" value="{lang:show}" />
      </form></td>
    <td class="rightb">{lang:notices}</td>
  </tr>
</table>
<br />
{head:message}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{sort:user} {lang:user}</td>
    <td class="headb">{sort:since} {lang:since}</td>
    <td class="headb">{sort:status} {lang:status}</td>
    <td class="headb" colspan="3">{lang:options}</td>
  </tr>
  {loop:languests}
  <tr>
    <td class="leftc">{languests:user}</td>
    <td class="leftc">{languests:since}</td>
    <td class="leftc">{languests:status}</td>
    <td class="leftc">{languests:map}</td>
    <td class="leftc">{languests:edit}</td>
    <td class="leftc">{languests:remove}</td>
  </tr>
  {stop:languests}
</table>
