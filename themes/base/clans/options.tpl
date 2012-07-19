<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:options}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:body_options}</td>
  </tr>
</table>
<br />
{lang:getmsg}
<form method="post" id="clans_options" action="{url:clans_options}">
  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
    <tr>
      <td class="leftc">{icon:kdmconfig} {lang:label}</td>
      <td class="leftb"><select name="label">
      <option value="clan" {clans:clan}>{lang:clan}</option>
          <option value="association" {clans:association}>{lang:association}</option>
          <option value="club" {clans:club}>{lang:club}</option>
          <option value="guild" {clans:guild}>{lang:guild}</option>
          <option value="enterprise" {clans:enterprise}>{lang:enterprise}</option>
          <option value="school" {clans:school}>{lang:school}</option>
        </select>
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:resizecol} {lang:max_width}</td>
      <td class="leftb"><input type="text" name="max_width" value="{clans:max_width}" maxlength="4" size="4" />
        {lang:pixel}</td>
    </tr>
    <tr>
      <td class="leftc">{icon:resizerow} {lang:max_height}</td>
      <td class="leftb"><input type="text" name="max_height" value="{clans:max_height}" maxlength="4" size="4" />
      {lang:pixel}</td>
    </tr>
    <tr>
      <td class="leftc">{icon:fileshare} {lang:max_size}</td>
      <td class="leftb"><input type="text" name="max_size" value="{clans:max_size}" maxlength="20" size="8" />
        {lang:bytes}</td>
    </tr>
    <tr>
      <td class="leftc">{icon:ksysguard} {lang:options}</td>
      <td class="leftb"><input type="submit" name="submit" value="{lang:edit}" />
              </td>
    </tr>
  </table>
</form>
