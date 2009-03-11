<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="2">{lang:mod} - {lang:edit}</td>
  </tr>
  <tr>
    <td class="leftb">{medals:message}</td>
  </tr>
</table>
<br />

<form method="post" action="{url:medals_edit}" name="medals_edit" enctype="multipart/form-data">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="leftc">{icon:kedit} {lang:name} *</td>
    <td class="leftb"><input type="text" value="{medals:medals_name}" name="medals_name" class="form" maxlength="150" size="30" /></td>
  </tr>
  {if:current_pic}
  <tr>
    <td class="leftc">{icon:download} {lang:current_picture}</td>
    <td class="leftb">
       <img src="{form:img_path}" alt="" />
       <br />
       <input type="checkbox" name="delete_picture" value="{medals:medals_extension}" class="form" /> {lang:remove_pic}
     </td>
  </tr>
  {stop:current_pic}
  <tr>
    <td class="leftc">{icon:download} {lang:new_picture}</td>
    <td class="leftb"><input type="file" name="medals_picture" class="form" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:kate} {lang:description}</td>
    <td class="leftb">{form:abcode}<br /><textarea name="medals_text" id="medals_text" class="form" rows="15">{medals:medals_text}</textarea></td>
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