<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="1">
  <tr>
    <td class="headb" colspan="2">{lang:mod} - {lang:edit}</td>
  </tr>
  <tr>
    <td class="leftb">{medals:message}</td>
  </tr>
</table>
<br />

<form method="post" action="{url:medals_edit}" name="medals_edit" enctype="multipart/form-data">
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="1">
  <tr>
    <td class="leftc">{icon:kedit} {lang:name} *</td>
    <td class="leftb"><input type="text" value="{medals:medals_name}" name="medals_name" class="form" maxlength="150" size="30" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:personal} {lang:user} *</td>
    <td class="leftb"><input type="text" name="users_nick" id="name" value="{medals:users_nick}" onkeyup="cs_ajax_getcontent('{form:dirname}mods/messages/getusers.php?name=' + document.getElementById('name').value,'names_list')" maxlength="200" size="50" class="form" /><div id="names_list"></div></td>
  </tr>
  <tr>
    <td class="leftc">{icon:download} {lang:current_picture}</td>
    <td class="leftb">{if:current_pic}
       <img src="{form:img_path}" alt="" />
       <br />
       <input type="checkbox" name="delete_picture" value="{medals:medals_extension}" class="form" /> {lang:remove_pic}
     {stop:current_pic}
     </td>
  </tr>
  <tr>
    <td class="leftc">{icon:download} {lang:new_picture}</td>
    <td class="leftb"><input type="file" name="medals_picture" class="form" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:kate} {lang:description}</td>
    <td class="leftb">{form:abcode}<br /><textarea name="medals_text" id="medals_text" class="form" rows="15">{medals:medals_text}</textarea></td>
  </tr>
  <tr>
    <td class="leftc">{icon:configure} {lang:extended}</td>
    <td class="leftb"><input type="checkbox" name="update_date" value="1" class="form" /> {lang:update_date}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
      <input type="hidden" value="{form:medals_id}" name="medals_id" />
      <input type="submit" value="{lang:edit}" name="submit" class="form" />
      <input type="reset" value="{lang:reset}" name="reset" class="form" />
     </td>
  </tr>
</table>
</form>