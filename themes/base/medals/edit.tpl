<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="2">{lang:mod_name} - {lang:edit}</td>
  </tr>
  <tr>
    <td class="leftb">{medals:message}</td>
  </tr>
</table>
<br />

<form method="post" id="medals_edit" action="{url:medals_edit}" enctype="multipart/form-data">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="leftc">{icon:kedit} {lang:name} *</td>
    <td class="leftb"><input type="text" value="{medals:medals_name}" name="medals_name" maxlength="150" size="30" /></td>
  </tr>
  {if:current_pic}
  <tr>
    <td class="leftc">{icon:download} {lang:current_picture}</td>
    <td class="leftb">
       <img src="{page:path}{form:img_path}" alt="" />
       <br />
       <input type="checkbox" name="delete_picture" value="{medals:medals_extension}" /> {lang:remove_pic}
     </td>
  </tr>
  {stop:current_pic}
  <tr>
    <td class="leftc">{icon:download} {lang:new_picture}</td>
    <td class="leftb"><input type="file" name="medals_picture" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:kate} {lang:description}</td>
    <td class="leftb">{form:abcode}<br /><textarea class="rte_abcode" name="medals_text" id="medals_text" rows="15">{medals:medals_text}</textarea></td>
  </tr>
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
      <input type="hidden" value="{form:medals_id}" name="medals_id" />
      <input type="submit" value="{lang:edit}" name="submit" />
     </td>
  </tr>
</table>
</form>