<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
<tr><td class="headb">
{lang:mod} - {lang:head_create}
</td></tr>
<tr><td class="leftb">
{lang:head}
</td></tr>
</table>
<br />

{if:form}
<form method="post" id="buddys_create" action="{url:buddys_create}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
<tr><td class="leftc">
{icon:personal} {lang:user} *</td><td class="leftb">
{create:buddys_nick}
</td></tr>
<tr><td class="leftc">
{icon:kate} {lang:notice}
<br /><br />
{create:abcode_smilies}
</td><td class="leftb">
{create:abcode_features}
<textarea name="buddys_notice" cols="50" rows="15" id="buddys_notice" >{create:buddys_notice}</textarea>
</td></tr><tr><td class="leftc">
{icon:ksysguard} {lang:options}</td>
<td class="leftb">
<input type="submit" name="submit" value="{lang:create}" />
<input type="reset" name="reset" value="{lang:reset}" />
</td></tr>
</table>
</form>
{stop:form}

{if:done}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
<tr><td class="centerb">
<a href="{url:buddys_center}">{lang:continue}</a>
</td></tr>
</table>
{stop:done}