<div class="container" style="width:{page:width}">
	<div class="headb">{head:mod} - {lang:pic}</div>
	<div class="leftb">{body:picture} {error:icon} {error:error} {error:message}</div>
</div><br />
<form method="post" name="entry" action="{url:usersgallery_users_create}" enctype="multipart/form-data">
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
  <tr>
    <td class="leftc">{icon:download} {lang:upload} *</td>
    <td class="leftb"><input type="file" name="picture"  /> <br /> {data:infobox}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:kedit} {lang:titel} *</td>
    <td class="leftb"><input type="text" name="gallery_titel" value="{data:title}" maxlength="200" size="50"  /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:folder_yellow} {lang:folders} *</td>
    <td class="leftb">{data:folders} - <input type="text" name="folders_name" size="20"  /></td>
  </tr>
	<tr>
    <td class="leftc">{icon:access} {lang:access}</td>
    <td class="leftb">{data:access}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:xpaint} {lang:show}</td>
    <td class="leftb">{data:status}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:kate} {lang:comment} *<br /> <br /> {abcode:smileys}</td>
    <td class="leftb">{abcode:features} 
			<textarea name="description" cols="50" rows="15" id="description"  style="width: 98%;">{data:description}</textarea></td>
  </tr>
	<tr>
    <td class="leftc">{icon:configure} {lang:head}</td>
    <td class="leftb">{data:votes} <br /> {data:downloads} <br /> {data:gray} <br /> {data:comments}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
			<input type="hidden" name="id" value="{data:id}" />
			<input type="submit" name="submit" value="{lang:submit}" />
	</td>
  </tr>
</table>
</form>