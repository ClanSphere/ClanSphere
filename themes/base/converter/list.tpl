<form method="post" id="converter" action="{url:converter}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width};" >
  <tr>
  	<td class="headb" width="100%" colspan="2">{lang:head_import}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:import}
      <select name="cms" class="form">
        <option value="">---</option>
        {loop:cms}
          <option value="{cms:dir}">{cms:name}</option>
        {stop:cms}
      </select>
    </td>
  </tr>
  <tr>
    <td class="leftb"><input type="submit" name="submit" value="Weiter" /></td>
  </tr>
</table>
</form>
<br />
<div style="display:{data:display}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width};" >
  <tr>
    <td class="leftb">{head:message}</td>
  </tr>
</table>
</div>