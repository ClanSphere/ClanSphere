<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="headb">ClanSphere - {lang:mod}</td>
	</tr>
	<tr>
		<td class="leftb">{lang:mod_text}</td>
	</tr>
</table>
<br />

{if:error}
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="leftb">
			{updates:errors}
		</td>
	</tr>
</table>
<br />
{stop:error}

{if:no_error}
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="centerb">{icon:submit} {lang:success_update}</td>
	</tr>
</table>
<br />
{stop:no_error}

<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="centerc"><a href="{url:updates_roots}">{lang:continue}</a></td>
	</tr>
</table>