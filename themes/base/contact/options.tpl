<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:options}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:body_options}</td>
  </tr>
</table>
<br />

<form method="post" id="contact_options" action="{url:contact_options}">
  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
    <tr>
      <td class="leftc">{icon:kontact} {lang:imprinttxt}</td>
      <td class="leftb"><a href="{imprint:url}">{lang:imp_edit}</a><br />{lang:lastchange} {imprint:date}
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:colors} {lang:mailsig}</td>
      <td class="leftb"><a href="{mailsig:url}">{lang:edit}</a><br />{lang:lastchange} {mailsig:date}
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:mail_find} {lang:def_org}</td>
      <td class="leftb"><input type="text" name="def_org" value="{options:def_org}" maxlength="80" size="40" />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:mail} {lang:def_mail}</td>
      <td class="leftb"><input type="text" name="def_mail" value="{options:def_mail}" maxlength="80" size="50" />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:nfs_unmount} {lang:smtp_host}</td>
      <td class="leftb">
        {lang:empty_uses_default}<br />
        <input type="text" name="smtp_host" value="{options:smtp_host}" maxlength="80" size="40" />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:pipe} {lang:smtp_port}</td>
      <td class="leftb"><input type="text" name="smtp_port" value="{options:smtp_port}" maxlength="20" size="8" />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:personal} {lang:smtp_user}</td>
      <td class="leftb"><input type="text" name="smtp_user" value="{options:smtp_user}" maxlength="80" size="20" />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:password} {lang:smtp_pw}</td>
      <td class="leftb"><input type="text" name="smtp_pw" value="{options:smtp_pw}" maxlength="40" size="20" />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:ksysguard} {lang:options}</td>
      <td class="leftb"><input type="submit" name="submit" value="{lang:edit}" /></td>
    </tr>
  </table>
</form>