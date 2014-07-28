<form method="post" id="users_sendpw" action="{url:users_sendpw}">

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
<tr><td class="leftc">
{icon:mail_generic} {lang:email} *</td><td class="leftb">

 <input type="text" name="email" value="" maxlength="40" size="40" />
 </td></tr><tr><td class="leftc">
{icon:lockoverlay} {lang:security_code} *</td><td class="leftb">
{captcha:img}
 </td></tr><tr><td class="leftc">
{icon:ksysguard} {lang:options}</td><td class="leftb">

 <input type="submit" name="submit" value="{lang:request}" />
  </td></tr></table>
</form>