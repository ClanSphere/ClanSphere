<form method="post" action="{form:navlogin}">
<fieldset style="border: 0; padding: 0">
<input type="text" name="nick" value="{login:nick}" onfocus="if(this.value=='Nick') this.value=''" onblur="if(this.value=='')this.value='Nick'" maxlength="40" size="22" /><br />
<input type="password" name="password" value="{login:password}" onfocus="if(this.value=='Pass') this.value=''" onblur="if(this.value=='')this.value='Pass'" maxlength="40" size="22" /><br />
<input type="checkbox" name="cookie" value="1" /> {lang:cookie}<br />
<input type="hidden" name="uri" value="{link:uri}" />
<input type="submit" name="login" value="{lang:submit}" />
</fieldset>
</form>
<a href="{url:users_register}">{lang:register}</a><br />
<a href="{url:users_sendpw}">{lang:sendpw}</a>