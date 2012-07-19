<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
  <td class="headb">{lang:mod_name} - {lang:folders_edit}</td>
  </tr>
  <tr>
  <td class="leftb">{head:body}</td>
  </tr>
</table>
<br />

<form method="post" id="folders_edit" action="{url:usersgallery_folders_edit}" enctype="multipart/form-data">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="leftb">{icon:folder_yellow} {lang:name} *</td>
    <td class="leftc">
      <input name="folders_name1" type="text" value="{data:folders_name}" size="50" maxlength="200" /></td>
  </tr>
  <tr>
    <td class="leftb">{icon:kcmdf} {lang:sub_folder}</td>
    <td class="leftc">
      {data:folders_select}
    </td>
  </tr>
  <tr>
    <td class="leftb">{icon:enumList} {lang:position}</td>
    <td class="leftc">
      <input name="folders_position" type="text" value="{data:folders_position}" size="5" maxlength="5" /></td>
  </tr>
  <tr>
    <td class="leftb">{icon:access} {lang:needed_access}</td>
    <td class="leftc">
      <select name="folders_access">
        {data:folders_access}
      </select>
    </td>
  </tr>
  <tr>
    <td class="leftb">{icon:gohome} {lang:url}</td>
    <td class="leftc">
      <input name="folders_url" type="text" value="{data:folders_url}" size="50" maxlength="200" /></td>
  </tr>
  <tr>
    <td class="leftb">{icon:kate} {lang:text}</td>
    <td class="leftc"><textarea class="rte_abcode" name="folders_text" cols="50" rows="12" id="folders_text" style="width:98%;">{data:folders_text}</textarea></td>
  </tr>
  <tr>
    <td class="leftb">{icon:images} {lang:pic_current}</td>
    <td class="leftc">{data:picture}</td>
    </tr>
  <tr>
    <td class="leftb">{icon:download} {lang:pic_up}</td>
    <td class="leftc">
      <input type="file" name="picture" value="" />
      {data:info_clip}
    </td>
  </tr>
  {if:picture_exists}
  <tr>
    <td class="leftb">{icon:configure} {lang:advance}</td>
    <td class="leftc"><input type="checkbox" name="delete" value="1" /> {lang:pic_remove}</td>
  </tr>
  {stop:picture_exists}
  <tr>
    <td class="leftb">{icon:configure} {lang:in_this_folder}</td>
    <td class="leftc">
      <input type="checkbox" name="adv_vote" value="1" {check:vote}/> {lang:vote_endi}<br />
      <input type="checkbox" name="adv_close" value="1" {check:close}/> {lang:gallery_close}<br />
      <input type="checkbox" name="adv_download" value="1" {check:dl}/> {lang:download_endi}<br />
    </td>
  </tr>
  <tr>
    <td class="leftb">{icon:ksysguard} {lang:options}</td>
    <td class="leftc">
      <input type="hidden" name="folders_picture" value="{hidden:folders_picture}" />
      <input type="hidden" name="id" value="{hidden:folders_id}" />
      <input type="submit" name="submit" value="{lang:edit}" />
          </td>
  </tr>
</table>
</form>