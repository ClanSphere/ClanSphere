<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:new_guest}</td>
  </tr>
  <tr>
    <td class="leftb">{head:info}</td>
  </tr>
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="leftc" rowspan="2">{icon:cal} {lang:event}</td>
    <td class="leftb"><a href="{url:events_view:id={events:events_id}}">{events:events_name}</a></td>
  </tr>
  <tr>
    <td class="leftb">{events:time}</td>
  </tr>
	<tr>
		<td class="leftc">{icon:organizer} {lang:needage}</td>
		<td class="leftb" colspan="2">{events:events_needage}</td>
	</tr>
</table>
<br />

<form method="post" id="events_guestsnew" action="{url:form}">
  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
    <tr>
      <td class="leftc">{icon:personal} {lang:user}</td>
      <td class="leftb">
        <input type="text" name="users_nick" id="users_nick" value="{users:nick}" onkeyup="cs_ajax_getcontent('{page:path}mods/ajax/search_users.php?term=' + document.getElementById('users_nick').value, 'search_users_result')" maxlength="80" size="40" />
        - <a href="{url:users_create}">{lang:create}</a><br />
        <div id="search_users_result"></div>
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:yast_user_add} {lang:guest}</td>
      <td class="leftb">
        {lang:req_name}<br />
        <input type="text" name="eventguests_name" value="{eventguests:eventguests_name}" maxlength="80" size="40" /><br />
        {lang:req_surname}<br />
        <input type="text" name="eventguests_surname" value="{eventguests:eventguests_surname}" maxlength="80" size="40" /><br />
        {lang:req_phone}<br />
        <input type="text" name="eventguests_phone" value="{eventguests:eventguests_phone}" maxlength="40" size="20" /><br />
        {lang:req_mobile}<br />
        <input type="text" name="eventguests_mobile" value="{eventguests:eventguests_mobile}" maxlength="40" size="20" /><br />
        {lang:req_fulladress}<br />
        <textarea class="rte_abcode" name="eventguests_residence" cols="50" rows="4">{eventguests:eventguests_residence}</textarea>
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:kedit} {lang:notice}</td>
      <td class="leftb">
        <textarea class="rte_abcode" name="eventguests_notice" cols="50" rows="4">{eventguests:eventguests_notice}</textarea>
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:ksysguard} {lang:options}</td>
      <td class="leftb">
        <input type="hidden" name="events_id" value="{events:events_id}" />
        <input type="submit" name="submit" value="{lang:create}" />
      </td>
    </tr>
  </table>
</form>