<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width};" >
  <tr>
  	<td class="headb">{lang:head_import}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:import} {import:cms}</td>
  </tr>
  <tr>
    <td class="leftb">{head:msg}</td>
  </tr>
</table>

<div style="display:{display:cms_import};" id="cms_import">
<br />
<form method="post" id="converter" action="{url:converter_convert}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width};" >
  <tr>
  	<td class="headb">{lang:web_installation}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:place}</td>
    <td class="leftc"><input type="text" name="dbplace" value="{data:dbplace}" maxlength="200" size="80" class="form" /></td>
  </tr>
  <tr>
    <td class="leftb">{lang:user}</td>
    <td class="leftc"><input type="text" name="dbuser" value="{data:dbuser}" maxlength="200" size="80" class="form" /></td>
  </tr>
  <tr>
    <td class="leftb">{lang:pwd}</td>
    <td class="leftc"><input type="text" name="dbpwd" value="{data:dbpwd}" maxlength="200" size="80" class="form" /></td>
  </tr>
  <tr>
    <td class="leftb">{lang:dbname}</td>
    <td class="leftc"><input type="text" name="dbname" value="{data:dbname}" maxlength="200" size="80" class="form" /></td>
  </tr>
  <tr>
    <td class="leftb">{lang:prefix}</td>
    <td class="leftc"><input type="text" name="dbprefix" value="{data:dbprefix}" maxlength="200" size="80" class="form" /></td>
  </tr>
  <tr>
    <td class="leftb">{lang:options}</td>
	<td class="leftc"><input type="submit" name="submit" value="Starten" /></td>
  </tr>
</table>
</form>
<br />
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width};" >
  <tr>
  	<td class="headb">{lang:choice}</td>
  </tr>
  {loop:cmsmod}
  <tr>
    <td class="leftb">{cmsmod:lang_cmsmod}</td>
    <td class="centerc"><input type="checkbox" name="modules[]" value="{cmsmod:modules}" />
    </td>
  </tr>
  {stop:cmsmod}
</table>
</div>