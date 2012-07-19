<form method="post" id="users_login" action="{url:users_login}">
  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
    <tr>
      <td class="leftc">{icon:personal} {lang:nick}</td>
      <td class="leftb"><input type="text" name="nick" value="" maxlength="40" size="40" /></td>
    </tr>
    <tr>
      <td class="leftc">{icon:password} {lang:password}</td>
      <td class="leftb"><input type="password" name="password" value="" maxlength="40" size="40" /></td>
    </tr>
    <tr>
      <td class="leftc">{icon:cookie}  {lang:cookie}</td>
      <td class="leftb">
        <input type="radio" name="cookie" value="1" />{lang:yes}
         <input type="radio" name="cookie" value="0" checked="checked" />{lang:no}
       </td>
     </tr>
     <tr>
       <td class="leftc">{icon:ksysguard} {lang:options}</td>
       <td class="leftb"><input type="submit" name="login" value="{lang:submit}" /></td>
     </tr>
   </table>
</form>