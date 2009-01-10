<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod} - {lang:head_rooms}</td>
  </tr>
  <tr>
    <td class="leftb"><form method="post" name="lanpartys_rooms" action="{url:form}">
        {lang:area}
        <select name="lanrooms_id" >
          <option value="0">----</option>
		  {loop:room}
		  <option value="{room:id}">{room:name}</option>
		  {stop:room}
        </select>
        <input type="hidden" name="id" value="{data:id}" />
        <input type="submit" name="submit" value="Anzeigen" />
      </form></td>
  </tr>
  <tr>
    <td class="leftc">{lang:body}</td>
  </tr>
</table>
<br />
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="leftc">{languests:map}</td>
  </tr>
</table>
