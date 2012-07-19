<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:options}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:body_opt}</td>
  </tr>
</table>
<br />

{head:getmsg}

<form method="post" id="messages_options" action="{url:messages_options}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="leftc">{icon:insert_table_row} {lang:del_time}</td>
    <td class="leftb"><input type="text" name="del_time" value="{op:del_time}" maxlength="3" size="4" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:insert_table_row} {lang:max_space}</td>
    <td class="leftb"><input type="text" name="max_space" value="{op:max_space}" maxlength="4" size="4" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
      <input type="submit" name="submit" value="{lang:edit}" />
    </td>
  </tr>
</table>
</form>