<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:head_edit}</td>
  </tr>
  <tr>
    <td class="leftb">{head:message}</td>
  </tr>
</table>
<br />
<form method="post" id="files_edit" action="{url:files_edit}" enctype="multipart/form-data">
  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
    <tr>
      <td class="leftc">{icon:kedit} {lang:name} *</td>
      <td class="leftb" colspan="2"><input type="text" name="files_name" value="{file:files_name}" maxlength="200" size="50" class="form" /></td>
    </tr>
    <tr>
      <td class="leftc">{icon:package_editors} {lang:version} *</td>
      <td class="leftb" colspan="2"><input type="text" name="files_version" value="{file:files_version}" maxlength="5" size="5" class="form" /></td>
    </tr>
    <tr>
      <td class="leftc">{icon:fileshare} {lang:big} *</td>
      <td class="leftb" colspan="2"><input type="text" name="files_size" value="{file:files_size}" maxlength="20" size="5" class="form" />
        <select name="size" class="form">
        {loop:levels}
          <option value="{levels:value}" {if:selected}selected="selected"{stop:selected}>{levels:name}</option>
        {stop:levels}
        </select></td>
    </tr>
    <tr>
      <td class="leftc">{icon:folder_yellow} {lang:category} *</td>
      <td class="leftb" colspan="2">{categories:dropdown}</td>
    </tr>
    <tr>
      <td class="leftc">{icon:kate} {lang:text} *<br />
        <br />
        {text:smileys}
        </td>
      <td class="leftb" colspan="2">
      	{text:features}
      	<textarea class="rte_abcode" name="files_description" cols="50" rows="10" id="files_description">{file:files_description}</textarea>
      </td>
    </tr>
    {loop:mirrors}
    <tr>
      <td class="leftc" rowspan="2">{icon:kedit} {lang:mirrors} {mirrors:run} *</td>
      <td class="leftb">{icon:html} {lang:url} *
        <input type="text" name="files_mirror_url_{mirrors:num}" value="{mirrors:url}" maxlength="200" size="30" class="form" /></td>
      <td class="leftb">{icon:kedit} {lang:name}
        <input type="text" name="files_mirror_name_{mirrors:num}" value="{mirrors:name}" maxlength="50" size="20" class="form" />
    </td>
    </tr>
    <tr>
    <td class="leftb"> {lang:extension} *
        <input type="text" name="files_mirror_ext_{mirrors:num}" value="{mirrors:ext}" maxlength="10" size="5" class="form" /></td>
      <td class="leftb">{icon:access} {lang:access}
        <select name="files_access_{mirrors:num}" class="form">
        {loop:accesses}
          <option value="{accesses:value}">{accesses:name}</option>
        {stop:accesses}
        </select></td>
    </tr>
    {stop:mirrors}
    <tr>
      <td class="leftc">{icon:configure} {lang:more}</td>
      <td class="leftb" colspan="2">
        <input type="checkbox" name="files_close" value="1" class="form" {if:closed}checked="checked"{stop:closed}/>
        {lang:close}<br />
        <input type="checkbox" name="files_vote" value="1" class="form" {if:votes}checked="checked"{stop:votes}/>
        {lang:votes}<br />
        <input type="checkbox" name="files_newtime" value="1" class="form"/>
        {lang:new_date}<br />
        <input type="checkbox" name="files_newcount" value="1" class="form"/>
        {lang:new_count} </td>
    </tr>
    <tr>
      <td class="leftc">{icon:ksysguard} {lang:options}</td>
      <td class="leftb" colspan="2"><input type="hidden" name="id" value="{file:files_id}" class="form"/>
        <input type="submit" name="submit" value="{lang:edit}" class="form"/>
        <input type="reset" name="reset" value="{lang:reset}" class="form"/>
        <input type="hidden" name="run_loop" value="{mirror:run_loop}" class="form"/>
        <input type="submit" name="mirror" value="{lang:mirrors+}" class="form"/></td>
    </tr>
  </table>
</form>