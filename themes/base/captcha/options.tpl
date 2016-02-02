<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
      <td class="headb">{lang:mod_name} - {lang:options}</td>
   </tr>
   <tr>
      <td class="leftb">{lang:manage_options}</td>
   </tr>
</table>
<br />

<form method="post" id="users_options" action="{url:captcha_options}" enctype="multipart/form-data">
  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
      <tr>
          <td class="leftc">{icon:kedit} {lang:methode}</td>
          <td class="leftb" colspan="2">
              <select name="method">
                  {loop:method}
                  <option value="{method:value}"{if:select} selected="selected"'{stop:select}>{method:name}</option>{stop:method}
              </select>
          </td>
      </tr>
      <tr>
          <td class="leftc">{icon:groupevent} {lang:recaptcha_publickey}</td>
          <td class="leftb"><input type="text" name="recaptcha_public_key" value="{options:recaptcha_public_key}" maxlength="50" size="50" /></td>
          <td class="leftb" rowspan="2">{lang:recaptcha_information}</td>
      </tr>
      <tr>
          <td class="leftc">{icon:personal} {lang:recaptcha_privatekey}</td>
          <td class="leftb"><input type="text" name="recaptcha_private_key" value="{options:recaptcha_private_key}" maxlength="50" size="50" /></td>
      </tr>
     <tr>
       <td class="leftc">{icon:ksysguard} {lang:options}</td>
        <td class="leftb" colspan="2"><input type="submit" name="submit" value="{lang:edit}" /></td>
     </tr>
  </table>
</form>