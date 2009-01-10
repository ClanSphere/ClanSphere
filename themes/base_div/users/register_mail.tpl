<form method="post" action="{form:register}">
  <table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
    <tr>
      <td class="leftc" style="width: 150px;"> {icon:locale} {lang:lang}</td>
      <td class="leftb"><select name="lang" >
                   {register:languages}               
        </select>
      </td>
    </tr>
    <tr>
      <td class="leftc"> {icon:personal} {lang:nick} *</td>
      <td class="leftb"><input type="text" name="nick" value="" maxlength="40" size="40"  />
      </td>
    </tr>
    <tr>
      <td class="leftc"> {icon:password} {lang:password} *</td>
      <td class="leftb"><input type="password" name="password" value="" maxlength="30" size="30"  />
      </td>
    </tr>
    <tr>
      <td class="leftc"> {icon:mail_generic} {lang:email} *</td>
      <td class="leftb"><input type="text" name="email" value="" maxlength="40" size="40"  />
      </td>
    </tr>
    <tr>
      <td class="leftc"> {icon:ksysguard} {lang:options}</td>
      <td class="leftb"><input type="submit" name="submit" value="{lang:signup}" />
        <input type="reset" name="reset" value="{lang:reset}" />
      </td>
    </tr>
  </table>
</form>
