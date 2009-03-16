<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
	<tr>
		<td class="headb">{lang:mod} - {lang:head_create}</td>
	</tr>
	<tr>
		<td class="leftc">{head:body}</td>
	</tr>
</table>
<br />

<form method="post" id="watermark_edit" action="{url:gallery_wat_edit}" enctype="multipart/form-data">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
	<tr>
		<td class="leftb">{icon:xpaint} {lang:name} *</td>
		<td class="leftc"><input type="text" name="categories_name" value="{data:categories_name}" maxlength="80" size="40" /></td>
	</tr>
	<tr>
		<td class="leftb">{icon:images} {lang:current}</td>
		<td class="leftc">{wm:current}</td>
	</tr>
	<tr>
		<td class="leftb">{icon:download} {lang:pic_up} *</td>
		<td class="leftc"><input type="file" name="picture" value="" /><br />
			<br />
			{picup:clip}
		</td>
	</tr>
	<tr>
		<td class="leftb">{icon:ksysguard} {lang:options}</td>
		<td class="leftc">
			<input type="hidden" name="id" value="{wm:id}" />
			<input type="submit" name="submit" value="{lang:edit}" />
			<input type="reset" name="reset" value="{lang:reset}" />
		</td>
	</tr>
</table>
</form>