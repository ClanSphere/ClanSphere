<form method="post" action="{form:navlogin}" class="noajax">
<fieldset style="border: 0">
<input type="hidden" name="uri" value="{link:uri}" />
{icon:personal} <input type="text" name="nick" value="{login:nick}" onfocus="if(this.value=='Nick') this.value=''" onblur="if(this.value=='')this.value='Nick'" maxlength="40" size="20" /><br />
{icon:password} <input type="password" name="password" value="{login:password}" onfocus="if(this.value=='Pass') this.value=''" onblur="if(this.value=='')this.value='Pass'" maxlength="40" size="20" /><br />
{icon:cookie} <input type="checkbox" name="cookie" value="1" /> {lang:cookie}<br />
<input type="submit" name="login" value="{lang:submit}" />
</fieldset>
</form>
{icon:kuser} <a href="{url:users_register}">{lang:register}</a><br />
{icon:password} <a href="{url:users_sendpw}">{lang:sendpw}</a>