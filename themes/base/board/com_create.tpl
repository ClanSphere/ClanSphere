<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="headb">{lang:board} - {lang:adv_com}</td>
	</tr>
	<tr>
    <td class="leftc">
        {thread:head_link}    
    </td>
</tr>
</table>
<br />

{if:error}
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
    <tr>
        <td class="leftb">
            {show:error}
        </td>
    </tr>
</table>
<br />
{stop:error}

{if:preview}
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="headb">{lang:preview}</td>
	</tr>
	<tr>
		<td class="leftc">
			{thread:preview_text}
		</td>
	</tr>
</table>
<br />
{stop:preview}

<form method="post" id="board_com_create" action="{url:board_com_create}" enctype="multipart/form-data">
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="leftc">{icon:kate} {lang:text} *<br />
			<br />
			{abcode:smileys}
			<br /><br />
			max.{thread:text_size} {lang:indi}
		</td>
		<td class="leftb">
			{abcode:features}
			<textarea name="comments_text" cols="50" rows="20" id="comments_text">{data:comments_text}</textarea>
		</td>
	</tr>
	{if:file}
	<tr>
		<td class="headb" colspan="2">{icon:download} {lang:uploads}</td>
	</tr>
	{loop:files}
	<tr>
		<td class="leftc">{icon:download} {lang:file} {files:num}</td>
		<td class="leftb">
			{if:empty_file}
			<input type="file" name="file_{files:num}" value="" />
			{files:clip}
			{stop:empty_file}
			{if:file_exists}
			<input type="hidden" name="file_name_{files:num}" value="{files:name}" />
			<input type="hidden" name="file_upload_name_{files:num}" value="{files:up_name}" />
			{if:file_is_picture}
			<div style="float:left;padding:3px;border:1px solid black;background:gainsboro;">
      <a href="/mods/gallery/image.php?boardpic={files:name}" onclick="window.open('/mods/gallery/image.php?boardpic={files:name}'); return false"><img src="/mods/gallery/image.php?boardpic={files:name}&boardthumb" alt="" /></a>
			</div>
			<div style="float:left;padding:3px;margin-left:10px;"><img src="/symbols/files/filetypes/{files:ext}.gif" alt="{files:ext}" /> {files:name}<br />
				<input type="submit" name="remove_file_{files:num}" value="{lang:remove}" />
			</div>
			{stop:file_is_picture}
			{if:file_is_other}
			<img src="/symbols/files/filetypes/{files:ext}.gif" alt="{files:ext}" /> {files:name}<br />
			<input type="submit" name="remove_file_{files:num}" value="{lang:remove}" />
			{stop:file_is_other}
			{stop:file_exists}
		</td>
	</tr>
	{stop:files}
	{stop:file}
	<tr>
		<td class="leftc">{icon:ksysguard} {lang:options+}</td>
		<td class="leftb">
			{if:add_file}<input type="hidden" name="files" value="1" />
			<input type="hidden" name="run_loop_files" value="{hidden:files_loop}" />
			<input type="submit" name="files+" value="{lang:add_file}" />{stop:add_file}
			{if:new_file}<input type="submit" name="new_file" value="{lang:add_file}" />{stop:new_file}
		</td>
	</tr>
	<tr>
 		<td class="leftc">{icon:ksysguard} {lang:options}</td>
 		<td class="leftb">
			<input type="hidden" name="id" value="{com:fid}" />
			<input type="submit" name="submit" value="{lang:submit}" />
			<input type="submit" name="preview" value="{lang:preview}" />
			<input type="reset" name="reset" value="{lang:reset}" />
		</td>
	</tr>
</table>
</form>
<br /><br />