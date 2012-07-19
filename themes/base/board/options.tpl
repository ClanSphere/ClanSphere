<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="3">{lang:mod_name} - {lang:head_options}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:body_options}</td>
  </tr>
</table>
<br />
{lang:getmsg}
<form method="post" id="board_edit" action="{action:form}">
  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
    <tr>
      <td class="leftc">{icon:kedit} {lang:max_text}</td>
      <td class="leftb"><input type="text" name="max_text" value="{options:max_text}" maxlength="5" size="5" /> {lang:indi}</td>
    </tr>
    <tr>
      <td class="leftc">{icon:kedit} {lang:max_signatur}</td>
      <td class="leftb"><input type="text" name="max_signatur" value="{options:max_signatur}" maxlength="4" size="4" /> {lang:indi}</td>
    </tr>
    <tr>
      <td class="leftc">{icon:resizerow} {lang:max_high}</td>
      <td class="leftb"><input type="text" name="avatar_height" value="{options:max_high}" maxlength="4" size="4" /> {lang:pix}</td>
    </tr>
    <tr>
      <td class="leftc">{icon:resizecol} {lang:max_avatar_width}</td>
      <td class="leftb"><input type="text" name="avatar_width" value="{options:max_avatar_width}" maxlength="4" size="4" /> {lang:pix}</td>
    </tr>
    <tr>
      <td class="leftc">{icon:fileshare} {lang:max_avatar_size}</td>
      <td class="leftb"><input type="text" name="avatar_size" value="{options:max_avatar_size}" maxlength="4" size="4" /> KiB</td>
    </tr>
    <tr>
      <td class="leftc">{icon:fileshare} {lang:max_filesize}</td>
      <td class="leftb"><input type="text" name="file_size" value="{options:max_filesize}" maxlength="4" size="4" /> KiB</td>
    </tr>
    <tr>
      <td class="leftc">{icon:fileshare} {lang:filetypes}</td>
      <td class="leftb"><input type="text" name="file_types" value="{options:filetypes}" maxlength="80" size="50" />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:agt_reload} {lang:sort}</td>
      <td class="leftb"><select name="sort">
          <option value="ASC" {check:asc}>{lang:sort_asc}</option>
          <option value="DESC" {check:desc}>{lang:sort_desc}</option>
        </select>
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:agt_reload} {lang:double_posts}</td>
      <td class="leftb">
        <input type="checkbox" name="doublep_allowed" value="1" {options:double_posts} /><br /><br />
          {lang:days_after1} <input type="text" name="doubleposts" value="{options:doubleposts}" maxlength="5" size="5" /> {lang:days_after2}
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:add_sub_task} {lang:list_subforums}</td>
      <td class="leftb"><input type="checkbox" name="list_subforums" value="1"{options:list_subforums} /></td>
    </tr>
   <tr>
      <td class="leftc">{icon:playlist} {lang:max_navlist}</td>
      <td class="leftb"><input type="text" name="max_navlist" value="{options:max_navlist}" maxlength="2" size="2" /></td>
   </tr>
   <tr>
      <td class="leftc">{icon:playlist} {lang:max_headline}</td>
      <td class="leftb"><input type="text" name="max_headline" value="{options:max_headline}" maxlength="3" size="3" /></td>
   </tr>  
   <tr>
      <td class="leftc">{icon:playlist} {lang:max_navtop}</td>
      <td class="leftb"><input type="text" name="max_navtop" value="{options:max_navtop}" maxlength="3" size="3" /></td>
   </tr> 
   <tr>
      <td class="leftc">{icon:playlist} {lang:max_navtop2}</td>
      <td class="leftb"><input type="text" name="max_navtop2" value="{options:max_navtop2}" maxlength="3" size="3" /></td>
   </tr>     
    <tr>
      <td class="leftc">{icon:ksysguard} {lang:options}</td>
      <td class="leftb"><input type="hidden" name="id" value="1" />
        <input type="submit" name="submit" value="{lang:edit}" />
              </td>
    </tr>
  </table>
</form>