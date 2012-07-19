<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:options}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:body_options}</td>
  </tr>
</table>
<br />

<form method="post" id="computers_options" action="{url:computers_options}">
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="leftc">{icon:resizecol} {lang:max_width}</td>
    <td class="leftb"><input type="text" name="max_width" value="{com:max_width}" maxlength="4" size="4" /> {lang:pixel}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:resizerow} {lang:max_height}</td>
    <td class="leftb"><input type="text" name="max_height" value="{com:max_height}" maxlength="4" size="4" /> {lang:pixel}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:fileshare} {lang:max_size}</td>
    <td class="leftb"><input type="text" name="max_size" value="{com:max_size}" maxlength="20" size="8" /> {lang:bytes}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
      <input type="submit" name="submit" value="{lang:edit}" />
          </td>
  </tr>
</table>
</form>
