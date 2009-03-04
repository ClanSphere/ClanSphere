<table class="forum" style="width: {page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{lang:explorer} - {lang:chmod}</td>
  </tr>
  <tr>
    <td class="leftc">{lang:grant_rights}</td>
  </tr>
</table>
<br />

<form method="post" name="explorer_chmod" action="{url:explorer_chmod}">

<table class="forum" style="width: {page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="leftc">{icn:unknown} {lang:file}</td>
    <td class="leftb">{var:source}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:access} {lang:owner}</td>
    <td class="leftb">
      <input type="checkbox" name="owner_read" value="400" id="owner_read" onclick="cs_chmod_CheckChange('owner_read',400)" class="form"{check:o_r} /> {lang:read}<br />
      <input type="checkbox" name="owner_write" value="200" id="owner_write" onclick="cs_chmod_CheckChange('owner_write',200)" class="form"{check:o_w} /> {lang:write}<br />
      <input type="checkbox" name="owner_execute" value="100" id="owner_execute" onclick="cs_chmod_CheckChange('owner_execute',100)" class="form"{check:o_e} /> {lang:execute}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:access} {lang:group}</td>
    <td class="leftb">
      <input type="checkbox" name="group_read" value="40" id="group_read" onclick="cs_chmod_CheckChange('group_read',40)" class="form"{check:g_r} /> {lang:read}<br />
      <input type="checkbox" name="group_write" value="20" id="group_write"  onclick="cs_chmod_CheckChange('group_write',20)" class="form"{check:g_w} /> {lang:write}<br />
      <input type="checkbox" name="group_execute" value="10" id="group_execute" onclick="cs_chmod_CheckChange('group_execute',10)" class="form"{check:g_e} /> {lang:execute}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:access} {lang:public}</td>
    <td class="leftb">
      <input type="checkbox" name="public_read" value="40" id="public_read" onclick="cs_chmod_CheckChange('public_read',4)" class="form"{check:p_r} /> {lang:read}<br />
      <input type="checkbox" name="public_write" value="20" id="public_write" onclick="cs_chmod_CheckChange('public_write',2)" class="form"{check:p_w} /> {lang:write}<br />
      <input type="checkbox" name="public_execute" value="10" id="public_execute" onclick="cs_chmod_CheckChange('public_execute',1)" class="form"{check:p_e} /> {lang:execute}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:access} {lang:chmod}</td>
    <td class="leftb"><input type="text" name="chmod" value="{var:chmod}" id="chmod" onchange="cs_chmod_TextChange()" class="form" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
      <input type="hidden" name="file" value="{var:source}" class="form" />
      <input type="submit" name="submit" value="{lang:save}" class="form" />
      <input type="reset" name="reset" value="{lang:reset}" class="form" />
     </td>
  </tr>
</table>
</form>
