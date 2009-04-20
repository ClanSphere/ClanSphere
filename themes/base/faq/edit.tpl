<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
	<tr>
		<td class="headb">{lang:mod_name} - {lang:head_edit}</td>
	</tr>
	<tr>
		<td class="leftb">{head:body}</td>
	</tr>
</table>
<br />

{if:preview}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
	<tr>
		<td class="headb">{preview:question}</td>
	</tr>
	<tr>
		<td class="leftb">{preview:answer}</td>
	</tr>
</table>
<br />
{stop:preview}

<form method="post" id="faq_edit" action="{url:faq_edit}" enctype="multipart/form-data">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
	<tr>
		<td class="leftc">{icon:folder_yellow} {lang:category} *</td>
		<td class="leftb">{faq:cat}</td>
	</tr>
	<tr>
		<td class="leftc">{icon:kedit} {lang:frage} *</td>
		<td class="leftb"><input type="text" name="faq_frage" value="{faq:frage}" maxlength="200" size="50"  /></td>
	</tr>
	{if:no_rte_html}
	<tr>
		<td class="leftc">{icon:kate} {lang:antwort} *<br />
			<br />
			{abcode:smileys}
		</td>
		<td class="leftb">{abcode:features}<br />
			<textarea name="faq_antwort" cols="99" rows="35" id="faq_antwort"  style="width: 98%;">{faq:antwort}</textarea>
		</td>
	</tr>
	{stop:no_rte_html}
	{if:rte_html}
	<tr>
		<td colspan="2" style="padding:0px">{faq:content}</td>
	</tr>
	{stop:rte_html}
	<tr>
		<td class="leftc">{icon:ksysguard} {lang:options}</td>
		<td class="leftb">
			<input type="hidden" name="id" value="{faq:id}" />
			<input type="submit" name="submit" value="{lang:edit}" />
			<input type="submit" name="preview" value="{lang:preview}" />
			<input type="reset" name="reset" value="{lang:reset}" />
		</td>
	</tr>
</table>
</form>