<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:import}</td>
  </tr>
  <tr>
    <td class="leftb">{head:msg}</td>
  </tr>
</table>
<br />
{if:smileys}
<form method="post" action="{url:abcode_import}">
  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
    <tr>
      <td class="headb">{lang:name}</td>
      <td class="headb">{lang:preview}</td>
      <td class="headb">{lang:pattern} *</td>
      <td class="headb">{lang:order}</td>
    </tr>
    {loop:file}
    <tr>
      <td class="leftb"><input type="hidden" name="file[]" value="{file:name}" />{file:name}</td>
      <td class="leftb">{file:preview}</td>
      <td class="leftb"><input type="text" name="pattern[]" value="{file:run}" /></td>
      <td class="leftb"><input type="text" name="order_{file:counter}" value="{file:order}" size="2" maxlength="2"/></td>
    </tr>
    {stop:file}
    <tr>
      <td class="centerb" colspan="4"><input type="submit" name="submit" value="{lang:submit}" /></td>
    </tr>
  </table>
</form>
{stop:smileys}
{if:no_smileys}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="centerb">{lang:no_smileys}<br /><a href="{url:abcode_manage}">{lang:back}</a></td>
  </tr>
</table>
{stop:no_smileys}