<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb" colspan="3">{lang:mod} - {lang:head_manage}</td>
 </tr>
 <tr>
  <td class="leftb">{icon:editpaste} {lang:new}</td>
  <td class="rightb">{icon:contents} {lang:all} {lang:count}</td>
  <td class="rightb">{pages:list}</td>
 </tr>
 <tr>
  <td class="leftb" colspan="3">{lang:select_lan}
    <form method="post" name="lanrooms_manage" action="{url:form}">
      <select name="lanpartys_id" >
        <option value="0">----</option>
        {loop:lan}
		<option value="{lan:id}">{lan:name}</option>
		{stop:lan}
      </select>
      <input type="submit" name="submit" value="{lang:show}" />
    </form>
  </td>
 </tr>
</table>
<br />
{head:message}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb">{sort:name}{lang:name}</td>
  <td class="headb" style="width:200px"colspan="3">{lang:options}</td>
 </tr>
 {loop:lanrooms}
 <tr>
  <td class="leftc">{lanrooms:name}</td>
  <td class="leftc">{lanrooms:map}</td>
  <td class="leftc">{lanrooms:edit}</td>
  <td class="leftc">{lanrooms:del}</td>
 </tr>
 {stop:lanrooms}
</table>