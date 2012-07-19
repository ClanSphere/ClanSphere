<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:edit}</td>
  </tr>
  <tr>
    <td class="leftc">{head:body}</td>
  </tr>
</table>
<br />

<form method="post" id="ranks_edit" action="{url:ranks_edit}" enctype="multipart/form-data">
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="leftc">{icon:playlist} {lang:name} *</td>
    <td class="leftb"><input type="text" name="ranks_name" value="{ranks:ranks_name}" maxlength="80" size="40" /></td>
  </tr>
  <tr>
  <td class="leftc">{icon:yast_group_add} {lang:squad}</td>
  <td class="leftb">
    <select name="squads_id">
     <option value="0">----</option>{loop:squads}
     <option value="{squads:squads_id}"{squads:selection}>{squads:squads_name}</option>{stop:squads}
    </select>
  </td>
 </tr>
  <tr>
    <td class="leftc">{icon:gohome} {lang:url} *</td>
    <td class="leftb">http://<input type="text" name="ranks_url" value="{ranks:ranks_url}" maxlength="80" size="50" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:images} {lang:img} *</td>
    <td class="leftb">http://<input type="text" name="ranks_img" value="{ranks:ranks_img}" maxlength="80" size="50" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:html} {lang:code}</td>
    <td class="leftb">
      <textarea class="rte_abcode" name="ranks_code" cols="50" rows="12" id="ranks_code">{ranks:ranks_code}</textarea><br />
      <br />
      {lang:code_info}
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
      <input type="hidden" name="id" value="{ranks:id}" />
      <input type="submit" name="submit" value="{lang:edit}" />
          </td>
  </tr>
</table>
</form>