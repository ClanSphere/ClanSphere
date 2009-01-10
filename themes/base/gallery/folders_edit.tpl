<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
	<td class="headb">{lang:mod} - {lang:folders_edit}</td>
  </tr>
  <tr>
	<td class="leftb">{body:folders} {error:icon} {error:error} {error:message}</td>
  </tr>
</table>
<br />
<form method="post" name="folders_edit" action="{url:gallery_folders_edit}" enctype="multipart/form-data">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
		<td class="leftc">{icon:folder_yellow} {lang:name} *</td>
		<td class="leftb">
			<input name="folders_name1" type="text" value="{data:folders_name}" size="50" maxlength="200"   />		</td>
  </tr>
	<tr>
		<td class="leftc">{icon:kcmdf} {lang:sub_folder}</td>
		<td class="leftb">
			{data:folders_select}		</td>
  </tr>
	<tr>
		<td class="leftc">{icon:enumList} {lang:position}</td>
		<td class="leftb">
			<input name="folders_position" type="text" value="{data:folders_position}" size="5" maxlength="5"   />		</td>
  </tr>
	<tr>
		<td class="leftc">{icon:access} {lang:needed_access}</td>
		<td class="leftb">
			{data:folders_access}		</td>
  </tr>
	<tr>
		<td class="leftc">{icon:gohome} {lang:url}</td>
		<td class="leftb">
			<input name="folders_url" type="text" value="{data:folders_url}" size="50" maxlength="200"   />		</td>
  </tr>
  <tr>
    <td class="leftc">{icon:kate} {lang:text}</td>
    <td class="leftb"><textarea name="folders_text" cols="50" rows="15" id="folders_text"  style="width: 98%;">{data:folders_text}</textarea>		</td>
  </tr>
	<tr>
	  <td class="leftc">{icon:images} {lang:pic_current}</td>
	  <td class="leftb">{data:picture}</td>
	  </tr>
	<tr>
		<td class="leftc">{icon:download} {lang:pic_up}</td>
		<td class="leftb">
			{data:picture_upload}
			{data:info_clip}		</td>
  </tr>
  <tr>
    <td class="leftc">{icon:configure} {lang:advance}</td>
    <td class="leftb">{data:picture_delete} {lang:pic_remove}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
		{hidden:folders_picture}
		{hidden:folders_id}
		<input type="submit" name="submit" value="{lang:create}" />
    <input type="reset" name="reset" value="{lang:reset}" />	</td>
  </tr>
</table>
</form>