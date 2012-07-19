<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:head_options}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:body_options}</td>
  </tr>
</table>
<br />
{lang:getmsg}
<form method="post" id="banners_options" action="{action:form}">
  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
    <tr>
      <td class="leftc">{icon:resizecol} {lang:max_width} </td>
      <td class="leftb"><input type="text" name="max_width" value="{options:max_width}" maxlength="4" size="4" />
        {lang:pixel}</td>
    </tr>
    <tr>
      <td class="leftc">{icon:resizerow} {lang:max_height}</td>
      <td class="leftb"><input type="text" name="max_height" value="{options:max_height}" maxlength="4" size="4" />
        {lang:pixel} </td>
    </tr>
    <tr>
      <td class="leftc">{icon:fileshare} {lang:max_size}</td>
      <td class="leftb"><input type="text" name="max_size" value="{options:max_size}" maxlength="20" size="8" />
        {lang:bytes} </td>
    </tr>
    <tr>
      <td class="leftc">{icon:ksysguard} {lang:options}</td>
      <td class="leftb"><input type="submit" name="submit" value="{lang:edit}" />
              </td>
    </tr>
  </table>
</form>
