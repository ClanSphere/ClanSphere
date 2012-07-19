<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:thread_edit}</td>
  </tr>
  <tr>
    <td class="leftb">{head:boardlinks}</td>
  </tr>
</table>
<br />

{if:error}
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="leftb">{show:errors}</td>
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
      {preview:text}
    </td>
  </tr>
</table>
<br />
{stop:preview}

<form method="post" id="thread_edit" action="{url:board_thread_edit}" enctype="multipart/form-data">
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="leftc">{icon:kedit} {lang:headline} *</td>
    <td class="leftb"><input type="text" name="threads_headline" value="{data:threads_headline}" maxlength="200" size="50" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:kate} {lang:text} *<br />
      <br />
      {abcode:smileys}<br />
      <br />
      max. {max:text} {lang:indi}
    </td>
    <td class="leftb">
      {abcode:features}
      <textarea class="rte_abcode" name="threads_text" cols="50" rows="20" id="threads_text" style="width:98%">{data:threads_text}</textarea>
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
      <input type="hidden" name="file_id_{files:num}" value="{files:b_id}" />
      <input type="hidden" name="file_user_{files:num}" value="{files:user}" />
      <input type="hidden" name="file_del_{files:num}" value="{files:del}" />
      {if:file_is_picture}
      <!--  <div style="float:left;padding:3px;border:1px solid black;background:gainsboro;">
      <a href="{page:path}mods/gallery/image.php?boardpic={files:name}" target="_blank">
        <img src="{page:path}mods/gallery/image.php?boardpic={files:name}&boardthumb" alt="" />
      </a>
      </div>
      <div style="float:left;padding:3px;margin-left:10px;">  -->
      {files:ext} {files:name}<br />
        {if:del_button}<input type="submit" name="remove_file_{files:num}" value="{lang:remove}" />{stop:del_button}
        {files:file_del}
      <!--  </div>  -->
      {stop:file_is_picture}
      {if:file_is_other}
      {files:ext} {files:name}<br />
      {if:del_button}<input type="submit" name="remove_file_{files:num}" value="{lang:remove}" />{stop:del_button}
      {files:file_del}
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
      <input type="hidden" name="id" value="{thread:id}" />
      <input type="submit" name="submit" value="{lang:edit}" />
      <input type="submit" name="preview" value="{lang:preview}" />
          </td>
  </tr>
</table>
</form>