<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:options}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:option}</td>
  </tr>
</table>
<br />

<form method="post" id="gbook_options" action="{url:gbook_options}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="leftc" style="width:50%">{icon:password} {lang:lock}</td>
  <td class="leftb">
    <select name="lock">
      <option value="0" {select:no}>{lang:no}</option>
      <option value="1" {select:yes}>{lang:yes}</option>
    </select>
  </td>
  </tr>
  <tr>
    <td class="leftc">{icon:lockoverlay} {lang:captcha_users}</td>
  <td class="leftb">
    <select name="captcha_users">
      <option value="0" {captcha:no}>{lang:no}</option>
      <option value="1" {captcha:yes}>{lang:yes}</option>
    </select>
  </td>
  </tr>
  <tr>
  <td class="leftc">{icon:ksysguard} {lang:options}</td>
  <td class="leftb"><input type="submit" name="submit" value="{lang:edit}" /></td>
 </tr>
</table>
</form>