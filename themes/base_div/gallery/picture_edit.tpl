<div class="container" style="width:{page:width}">
	<div class="headb">{lang:mod} - {lang:picture} {lang:edit}</div>
	<div class="leftb">{body:picture_create} {error:icon} {error:error} {error:message}</div>
</div>
<br />
<form method="post" name="picture_edit" action="{url:gallery_picture_edit}" enctype="multipart/form-data">
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
  <tr>
		<td width="150" class="leftc">{icon:download} {lang:upload} *</td>
		<td class="leftb">
			{data:picture}</td>
  </tr>
	<tr>
		<td class="leftc">{icon:kedit} {lang:titel} *</td>
		<td class="leftb">
			<input name="gallery_titel" type="text" value="{data:gallery_titel}" size="50" maxlength="80"   />
		</td>
  </tr>
	<tr>
		<td class="leftc">{icon:folder_yellow} {lang:folders} *</td>
		<td class="leftb">
			{data:folders_select}
		</td>
  </tr>
	<tr>
		<td class="leftc">{icon:access} {lang:needed_access}</td>
		<td class="leftb">
			{data:gallery_access}
		</td>
  </tr>
	<tr>
		<td class="leftc">{icon:xpaint} {lang:show}</td>
		<td class="leftb">
			{data:gallery_status}
		</td>
  </tr>
  <tr>
    <td class="leftc">{icon:xpaint} {lang:watermark}</td>
    <td class="leftb">{data:w_select}{data:w_position}{lang:wm_trans}{data:w_trans}% {data:w_img}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:kate} {lang:text} <br /> <br />
  	 {abcode:smileys}</td>
    <td class="leftb">{abcode:features} <br />
    	<textarea name="gallery_description" cols="50" rows="5" id="gallery_description"  style="width: 98%;">{data:gallery_description}</textarea> 
    </td>
  </tr>
	<tr>
		<td class="leftc">{icon:configure} {lang:more}</td>
		<td class="leftb">
			{data:vote} {lang:vote_endi} <br />
			{data:download} {lang:download_endi} <br />
			{data:download_zip} {lang:download_original} <br />
			{data:new_time} {lang:new_date} <br />
			{data:reset_counter} {lang:gallery_count_reset} <br />
			{data:close} {lang:gallery_close}
		</td>
  </tr>
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
		{data:hidden_name}
		{data:hidden_id}
		<input type="submit" name="submit" value="{lang:edit}" />
    <input type="reset" name="reset" value="{lang:reset}" />
	</td>
  </tr>
</table>
</form>