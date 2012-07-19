<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:head}</td>
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
  {if:pre_votes}
  <tr>
    <td class="leftb">{icon:volume_manager} {preview:question}</td>
  </tr>
  <tr>
    <td class="leftb">
      {loop:pre_answers}
      <input type="{if:vote_several}checkbox{stop:vote_several}{unless:vote_several}radio{stop:vote_several}" name="voted_answer{if:vote_several}[]{stop:vote_several}" value="{pre_answers:run}" /> {pre_answers:answer}<br />
      {stop:pre_answers}
    </td>
  </tr>
  {stop:pre_votes}
  <tr>
    <td class="leftc">
      {preview:text}
    </td>
  </tr>
</table>
<br />
{stop:preview}

<form method="post" id="thread_create" action="{url:board_thread_add}" enctype="multipart/form-data">
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
  {if:vote}
  <tr>
    <td class="headb" colspan="2">{icon:volume_manager} {lang:votes}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:today} {lang:votes_end} *</td>
    <td class="leftb">
      {time:select}
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:enumList} {lang:votes_access} *</td>
    <td class="leftb">
      <select name="votes_access">
        {access:options}
      </select>
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:kedit} {lang:votes_question} *</td>
    <td class="leftb"><input type="text" name="votes_question" value="{data:votes_question}" maxlength="50" size="50" /></td>
  </tr>
  {loop:answers}
  <tr>
    <td class="leftc">{icon:kate} {lang:votes_election} {answers:num} *</td>
    <td class="leftb"><input type="text" name="votes_election_{answers:num}" value="{answers:answer}" maxlength="50" size="50" /></td>
  </tr>
  {stop:answers}
  <tr>
    <td class="leftc">{icon:configure} {lang:more}</td>
    <td class="leftb"><input type="checkbox" name="votes_several" value="1" {several:checked} /> {lang:several}</td>
  </tr>
  {stop:vote}
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
      <!--  <div style="float:left;padding:3px;border:1px solid black;background:gainsboro;">
      <a href="{page:path}mods/gallery/image.php?boardpic={files:name}" target="_blank"><img src="{page:path}mods/gallery/image.php?boardpic={files:name}&boardthumb" alt="" /></a>
      </div>
      <div style="float:left;padding:3px;margin-left:10px;">  -->
      {files:ext} {files:name}<br />
        <input type="submit" name="remove_file_{files:num}" value="{lang:remove}" />
      <!--  </div>  -->
      {stop:file_is_picture}
      {if:file_is_other}
      {files:ext} {files:name}<br />
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
      {if:new_votes}<input type="submit" name="new_votes" value="{lang:vote_create}" />{stop:new_votes}
      {if:add_answer}<input type="hidden" name="votes" value="1" />
      <input type="hidden" name="run_loop" value="{hidden:votes_loop}" />
      <input type="submit" name="election" value="{lang:election+}" />{stop:add_answer}
      {if:add_file}<input type="hidden" name="files" value="1" />
      <input type="hidden" name="run_loop_files" value="{hidden:files_loop}" />
      <input type="submit" name="files+" value="{lang:add_file}" />{stop:add_file}
      {if:new_file}<input type="submit" name="new_file" value="{lang:add_file}" />{stop:new_file}
    </td>
  </tr>
  {if:advanced}
  <tr>
    <td class="leftc">{icon:configure} {lang:more}</td>
    <td class="leftb">
      <input type="checkbox" name="threads_important" value="1" {check:important}/> {lang:thread_addpin}<br />
      <input type="checkbox" name="threads_close" value="1" {check:close}/> {lang:thread_close}
    </td>
  </tr>
  {stop:advanced}
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
      <input type="hidden" name="where" value="{board:id}" />
      <input type="submit" name="submit" value="{lang:create}" />
      <input type="submit" name="preview" value="{lang:preview}" />
          </td>
  </tr>
</table>
</form>