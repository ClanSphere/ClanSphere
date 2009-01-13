<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="headb">ClanSphere - {lang:mod}</td>
	</tr>
	<tr>
		<td class="leftb">{lang:mod_text}</td>
	</tr>
</table>
<br />

<form method="post" name="roots" action="{url:updates_roots}">
{if:details}
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="headb">{lang:packet} #{details:num_name}</td>
	</tr>
	<tr>
		<td class="leftb">{details:changes}</td>
	</tr>
	<tr>
		<td class="rightc">
			<input type="hidden" name="file" value="{details:file}" />
			<input type="submit" name="cancel" value="{lang:cancel}" />
			<input type="submit" name="update" value="{lang:update}" />
		</td>
	</tr>
</table>
<br />
{stop:details}

{if:update}
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="headb">{lang:notification_update} #{update:num_name}</td>
	</tr>
	<tr>
		<td class="centerb">
			<textarea name="notice" cols="99" rows="10" readonly="readonly" id="notice" style="width: 98%;">{lang:notice}</textarea>
		</td>
	</tr>
	<tr>
		<td class="centerc">
			<input type="hidden" name="file" value="{update:file}" />
			<input type="submit" name="agree" value="{lang:agree}" />
			<input type="submit" name="cancel" value="{lang:disagree}" />
		</td>
	</tr>
</table>
<br />
{stop:update}

{if:update_check}
{loop:updatecheck}
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="headb">{lang:packed} #{updatecheck:num_name}</td>
	</tr>
	<tr>
		<td class="leftb">
			{updatecheck:changes}<br />
			<br />
			<strong>{lang:complete_changelog}/strong>
		</td>
	</tr>
	<tr>
		<td class="rightc">
			<input type="hidden" name="file" value="{updatecheck:file}" />
			<input type="submit" name="details" value="{lang:details}" />
			<input type="submit" name="update" value="{lang:update}" />
		</td>
	</tr>
</table>
<br />
{stop:updatecheck}
{stop:update_check}

{if:no_updates}
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="headb">{lang:notification}</td>
	</tr>
	<tr>
		<td class="leftb">{lang:no_updates}</td>
	</tr>
</table>
{stop:no_updates}

{if:error}
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="headb">{lang:error}</td>
	</tr>
	<tr>
		<td class="leftb">
			{lang:not_availble}<br />
			<br />
			<a href="http://de3.php.net/manual/en/book.zip.php">http://de3.php.net/manual/en/book.zip.php</a>
		</td>
	</tr>
</table>
{stop:error}
</form>