<div class="container" style="width:{page:width}">
    <div class="headb">{lang:mod} - {lang:head_create}</div>
    <div class="leftb">{head:body}</div>
</div>
<br />

{if:preview}
<div class="container" style="width:{page:width}">
    <div class="headb"> {preview:question} </div>
    <div class="leftb"> {preview:answer} </div>
</div>
<br />
{stop:preview}

<form method="post" name="faq_create" action="{url:faq_create}" enctype="multipart/form-data">
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
	<tr>
		<td class="leftc">{icon:folder_yellow} {lang:category} *</td>
		<td class="leftb">{faq:cat}</td>
	</tr>
	<tr>
		<td class="leftc">{icon:kedit} {lang:frage} *</td>
		<td class="leftb"><input type="text" name="faq_frage" value="{faq:frage}" maxlength="200" size="50"  /></td>
	</tr>
	{if:nofckeditor}
	<tr>
		<td class="leftc">{icon:kate} {lang:antwort} *<br />
			<br />
			{abcode:smileys}
		</td>
		<td class="leftb">{abcode:features}<br />
			<textarea name="faq_antwort" cols="99" rows="35" id="faq_antwort"  style="width: 98%;">{faq:antwort}</textarea>
		</td>
	</tr>
	{stop:nofckeditor}
	{if:fckeditor}
	<tr>
		<td colspan="2" style="padding:0px">{faq:content}</td>
	</tr>
	{stop:fckeditor}
	<tr>
		<td class="leftc">{icon:ksysguard} {lang:options}</td>
		<td class="leftb">
			<input type="submit" name="submit" value="{lang:create}" />
			<input type="submit" name="preview" value="{lang:preview}" />
			<input type="reset" name="reset" value="{lang:reset}" />
		</td>
	</tr>
</table>
</form>
