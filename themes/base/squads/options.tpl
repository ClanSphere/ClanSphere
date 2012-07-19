<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{head:mod} - {lang:options}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:body_options}</td>
  </tr>
</table>
<br />

{head:getmsg}

<form method="post" id="squads_options" action="{url:squads_options}">
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="leftc">{icon:kdmconfig} {lang:label}</td>
    <td class="leftb">
      <select name="label">
        <option value="squad" {op:squad}>{lang:squads}</option>
        <option value="group" {op:group}>{lang:groups}</option>
        <option value="section" {op:section}>{lang:sections}</option>
        <option value="team" {op:team}>{lang:teams}</option>
        <option value="class" {op:class}>{lang:classs}</option>
      </select>
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:resizecol} {lang:max_width}</td>
    <td class="leftb"><input type="text" name="max_width" value="{op:max_width}" maxlength="4" size="4" /> {lang:pixel}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:resizerow} {lang:max_height}</td>
    <td class="leftb"><input type="text" name="max_height" value="{op:max_height}" maxlength="4" size="4" /> {lang:pixel}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:fileshare} {lang:max_size}</td>
    <td class="leftb"><input type="text" name="max_size" value="{op:max_size}" maxlength="20" size="8" /> {lang:bytes}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:enumList} {lang:def_order}</td>
    <td class="leftb"><input type="text" name="def_order" value="{op:def_order}" maxlength="4" size="4" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
      <input type="submit" name="submit" value="{lang:edit}" />
          </td>
  </tr>
</table>
</form>