<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="2">{lang:mod} - {lang:head_list}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:all} {lang:count}</td>
	<td class="rightb">{pages:list}</td>
  </tr>
  <tr>
    <td class="leftb" colspan="2">{lang:select_lan}
    <form method="post" name="lanrooms_list" action="{url:form}">
      <select name="lanpartys_id" >
        <option value="0">----</option>
        {loop:lan}
		<option value="{lan:id}">{lan:name}</option>
		{stop:lan}
      </select>
      <input type="submit" name="submit" value="{lang:show}" />
    </form></td>
  </tr>
</table>

<br />
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{sort:name} {lang:name}</td>
  </tr>
  {loop:lanrooms}
  <tr>
    <td class="leftc">{lanrooms:name}</td>
  </tr>
  {stop:lanrooms}
</table>