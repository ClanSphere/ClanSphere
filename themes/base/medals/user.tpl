<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="3">{lang:mod} - {lang:manage}</td>
  </tr>
  <tr>
    <td class="leftb"><a href="{url:medals_manage}">{lang:back}</a></td>
    <td class="leftb">{icon:contents} {lang:total}: {count:medals_user}</td>
    <td class="rightb">{pages:list}</td>
  </tr>
</table>
<br />
<form method="post" id="medals_user" action="{url:medals_user}" enctype="multipart/form-data">
  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
    <tr>
      <td class="leftc">{icon:personal} {lang:user}</td>
      <td class="leftb">
        <input type="text" name="users_nick" id="name" value="" onkeyup="cs_ajax_getcontent('{form:dirname}mods/messages/getusers.php?name=' + document.getElementById('name').value,'names_list')" maxlength="200" size="50" class="form" />
        <input type="submit" value="{lang:awardingto}" name="submit" class="form" />
        <input type="hidden" value="{medals:id}" name="medals_id" class="form" />
        <div id="names_list"></div>
        </td>
    </tr>
  </table>
</form>
<br />
{message:medals}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{sort:date} {lang:date}</td>
    <td class="headb">{sort:users_nick} {lang:user}</td>
    <td class="headb">{lang:options}</td>
  </tr>
  {loop:medals_user}
  <tr>
    <td class="leftb">{medals_user:medals_date}</td>
    <td class="leftb">{medals_user:user}</td>
    <td class="centerb"><a href="{medals_user:remove_url}">{icon:editdelete}</a></td>
  </tr>
  {stop:medals_user}
</table>