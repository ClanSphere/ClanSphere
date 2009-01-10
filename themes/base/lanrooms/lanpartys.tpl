<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb"> LAN-Sitzplan - LAN-Partys </td>
  </tr>
  <tr>
    <td class="leftb" colspan="2">{lang:addons}</td>
  </tr>
  <tr>
    <td class="leftb"><form method="post" name="lanrooms_lanpartys" action="{url:form}">
        {lang:area}
        <select name="lanrooms_id" >
		  <option value="0">----</option>
		  {loop:lan}
		<option value="{lan:id}">{lan:name}</option>
		{stop:lan}
        </select>
        <input type="hidden" name="id" value="{data:id}" />
        <input type="submit" name="submit" value="{lang:show}" />
      </form></td>
  </tr>
  <tr>
    <td class="leftc">{lang:body}
    </td>
  </tr>
</table>
<br />
