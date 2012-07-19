<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
<tr><td class="headb">
{lang:mod_name} - {lang:answer}
</td></tr><tr><td class="leftc">
{lang:head}
</td></tr>
</table>
<br />

{if:form}
<form method="post" id="contact_mail" action="{url:contact_answer}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
<tr><td class="leftc">
{icon:personal} {lang:sender}</td>
<td class="leftb">{mail:users_name} {mail:users_surname} &lt;{mail:users_email}&gt;</td></tr>
<tr><td class="leftc">{icon:personal} {lang:receiver}</td>
<td class="leftb">{mail:mail_name} &lt;{mail:mail_email}&gt;</td></tr>
<tr><td class="leftc">{icon:kedit} {lang:subject} *</td>
<td class="leftb"><input type="text" name="subject" value="{mail:subject}" maxlength="200" size="50" />
</td></tr>
<tr><td class="leftc">{icon:mail_generic} {lang:message} *</td>
<td class="leftb">
<textarea class="rte_abcode" name="message" cols="50" rows="20" id="message">{mail:message}</textarea>
</td></tr><tr><td class="leftc">
{icon:ksysguard} {lang:options}</td>
<td class="leftb">
<input type="hidden" name="id" value="{mail:id}" />
<input type="submit" name="submit" value="{lang:send}" />
</td></tr>
</table>
</form>
{stop:form}

{if:done}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
<tr><td class="centerb">
<a href="{url:contact_manage}">{lang:continue}</a>
</td></tr>
</table>
{stop:done}