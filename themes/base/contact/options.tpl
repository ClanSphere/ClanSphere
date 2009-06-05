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
      <td class="leftc">{icon:ksysguard} {lang:options}</td>
      <td class="leftb"><input type="submit" name="submit" value="{lang:edit}" /></td>
    </tr>
  </table>
</form>