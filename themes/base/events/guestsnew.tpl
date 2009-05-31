<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:create}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:body}</td>
  </tr>
</table>
<br />

<form method="post" id="events_guestsnew" action="{url:form}">
  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
    <tr>
      <td class="leftc" rowspan="2">{icon:cal} {lang:event} *</td>
      <td class="leftb"><a href="{url:events_view:id={events:id}}">{events:name}</a></td>
    </tr>
    <tr>
      <td class="leftb">{events:time}</td>      
    </tr>
    <tr>
      <td class="leftc">{icon:personal} {lang:user} *</td>
      <td class="leftb">
        <input type="text" name="users_nick" id="users_nick" value="{users:nick}" onkeyup="cs_ajax_getcontent('{page:path}mods/ajax/search_users.php?term=' + document.getElementById('users_nick').value, 'search_users_result')" maxlength="80" size="40" />
        - <a href="{url:users_create}">{lang:create}</a><br />
        <div id="search_users_result"></div>
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:ksysguard} {lang:options}</td>
      <td class="leftb">
        <input type="hidden" name="events_id" value="{events:id}" />
        <input type="submit" name="submit" value="{lang:create}" />
              </td>
    </tr>
  </table>
</form>