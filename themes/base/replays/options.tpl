<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:options}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:body_options}</td>
  </tr>
</table>
<br />

<form method="post" id="replays_options" action="{url:replays_options}">
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="leftc">{icon:fileshare} {lang:max_size}</td>
    <td class="leftb"><input type="text" name="file_size" value="{op:filesize}" maxlength="20" size="6" /> KiB</td>
  </tr>
  <tr>
    <td class="leftc">{icon:fileshare} {lang:filetypes}</td>
    <td class="leftb"><input type="text" name="file_type" value="{op:file_type}" maxlength="80" size="50" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
      <input type="submit" name="submit" value="{lang:save}" />
          </td>
  </tr>
</table>
</form>