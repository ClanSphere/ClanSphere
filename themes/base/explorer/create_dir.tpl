<table class="forum" style="width: {page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{lang:explorer} - {lang:create_dir}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:folder_create}</td>
  </tr>
</table>
<br />

<form method="post" id="explorer_create_dir" action="{url:explorer_create_dir}">
<table class="forum" style="width: {page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="leftc">{icon:folder_yellow} {lang:directory}</td>
    <td class="leftb"><input type="text" name="data_folder" value="{var:dir}" maxlength="60" size="40" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:kate} {lang:dir_name} *</td>
    <td class="leftb"><input type="text" name="folder_name" value="" maxlength="50" size="30" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
      <input type="submit" name="submit" value="{lang:create}" />
      </td>
  </tr>
</table>
</form>
