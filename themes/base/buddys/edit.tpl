<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
<tr><td class="headb">
{lang:mod_name} - {lang:head_edit}
</td></tr>
<tr><td class="leftb">
{lang:body}
</td></tr>
</table>
<br />

{if:preview}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
<tr><td class="leftb" style="width:150px">{icon:kedit} {lang:notice}</td>
<td class="leftb">
{edit:buddys_notice}
</td></tr>
</table>
<br />
{stop:preview}

{if:form}
<form method="post" id="buddys_edit" action="{url:buddys_edit}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
<tr><td class="leftc">
{icon:kate} {lang:notice}<br /><br />
{edit:abcode_smileys}
</td><td class="leftb">
{edit:abcode_features}
<textarea class="rte_abcode" name="buddys_notice" cols="50" rows="20" id="buddys_notice">{edit:buddys_notice}</textarea>
</td></tr>
<tr><td class="leftc">
{icon:ksysguard} {lang:options}</td>
<td class="leftb">
<input type="hidden" name="id" value="{edit:id}" />
<input type="submit" name="submit" value="{lang:edit}" />
<input type="submit" name="preview" value="{lang:preview}" />
</td></tr>
</table>
</form>
{stop:form}

{if:done}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
<tr><td class="centerc">
<a href="{url:buddys_center}">{lang:continue}</a>
</td></tr>
</table>
{stop:done}