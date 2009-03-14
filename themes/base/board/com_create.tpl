<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
<tr>
    <td class="headb">
        {lang:board} - Kommentare Eintragen
    </td>
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
            {thread:errormsg}
        </td>
    </tr>
</table>
<br />
{stop:error}
{if:preview}
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
<tbody><tr><td class="headb">
{lang:preview}</td></tr><tr><td class="leftc">
{thread:preview_text}
 </td></tr></tbody></table>
{stop:preview}
<br />
<form method="post" name="board_com_create" action="/trunk/index.php?mod=board&amp;action=com_create" enctype="multipart/form-data">

<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
<tr><td class="leftc">
{icon:kate} {lang:text} *<br /><br />

{thread:smileys_box}
<br /><br />
max.{thread:text_size} {lang:indi}</td><td class="leftb">

{thread:abcode_box}
<textarea name="comments_text" cols="50" rows="20" id="comments_text" class="form">{thread:comments_text}</textarea>

 </td></tr><tr><td class="leftc">
{icon:ksysguard} {lang:options+}</td><td class="leftb">
{if:file}
	{thread:up_icon}<br />
{stop:file}
	{loop:files}
	{files:do_icon}
 	{files:file_num}
{if:no_file}
	{files:file_matches}
{stop:no_file}
	{files:file_name}
	{files:file_name_hidden}
	{files:file_up_name}
	{files:file_link}
	{files:file_symbol}
	{files:remove_file}<br />
	{stop:files}
{if:addfile2}
	{thread:files_loop_hidden}
	{thread:files_hidden}
	{thread:new_file}
{stop:addfile2}
{if:addfile}
	{thread:new_file}
{stop:addfile}
 </td></tr><tr><td class="leftc">
{icon:ksysguard} {lang:options}</td><td class="leftb">

 <input type="hidden" name="id" value="{thread:fid}" class="form"/>
 <input type="submit" name="submit" value="Eintragen" class="form"/>
 <input type="submit" name="preview" value="Vorschau" class="form"/>
 <input type="reset" name="reset" value="Nochmal" class="form"/>
 </td></tr></table>

</form>
<br /><br />