<form method="post" name="users_sendpw" action="{url:users_sendpw}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="leftc"> {icon:unlock} {lang:key} *</td>
    <td class="leftb"><input type="password" name="key" value="" maxlength="30" size="30"  />
    </td>
  </tr>
  <tr>
    <td class="leftc"> {icon:password} {lang:new_pwd} *</td>
    <td class="leftb"><input type="password" name="new_pwd" value="" maxlength="30" size="30"  />
      <input type="hidden" name="email" value="{hidden:email}"  />
      <input type="hidden" name="email_send" value="1"  />
    </td>
  </tr>
  <tr>
    <td class="leftc"> {icon:ksysguard} {lang:options}</td>
    <td class="leftb"><input type="submit" name="submit" value="{lang:save}" />
      <input type="reset" name="reset" value="{lang:reset}" />
    </td>
  </tr>
</table>
