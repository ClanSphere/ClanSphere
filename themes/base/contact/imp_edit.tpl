{if:form}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
<tr><td class="headb">
{lang:mod_imp} - {lang:head_edit}
</td></tr>
<tr><td class="leftb">
{lang:body_edit}
</td></tr>
</table>
<br />

<form method="post" id="imprint_edit" action="{url:contact_imp_edit}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
<tr><td class="leftc">
{icon:kate} {lang:text} *
</td>
<td class="leftb">
{imprint:abcode_features}
<textarea name="imprint" cols="55" rows="30" id="imprint" >{imprint:content}</textarea>
</td></tr>
<tr><td class="leftc">
{icon:ksysguard} {lang:options}</td><td class="leftb">
<input type="submit" name="submit" value="{lang:edit}" />
<input type="reset" name="reset" value="{lang:reset}" />
</td></tr>
</table>
</form>
{stop:form}

{if:done}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
<tr><td class="headb">
{lang:mod_imp} - {lang:head_edit}
</td></tr>
<tr><td class="leftc">
{lang:changes_done}
</td></tr>
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
<tr><td class="centerb">
<a href="{url:contact_manage}">{lang:continue}</a>
</td></tr>
</table>
<br />
{stop:done}

{if:wizzard}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
<tr><td class="leftb">
{lang:wizard}: <a href="{url:wizard_roots}">{lang:show}</a> - 
<a href="{url:wizard_roots:handler=cont&amp;done=1}">{lang:task_done}</a>
</td></tr>
</table>
<br />
{stop:wizzard}