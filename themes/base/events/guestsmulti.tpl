<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:guests_multi}</td>
  </tr>
  <tr>
    <td class="leftb">{head:info}</td>
  </tr>
</table>
<br />

<form method="post" id="events_guestsnew" action="{url:events_guestsmulti}">
  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
    <tr>
      <td class="leftc">{icon:personal} {lang:user}</td>
      <td class="leftb">
        <input type="text" name="users_nick" id="users_nick" value="{users:nick}" autocomplete="off" onkeyup="Clansphere.ajax.user_autocomplete('users_nick', 'search_users_result' ,'{page:path}')" maxlength="80" size="40" />
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
        {lang:age}<br />
        <input type="text" name="eventguests_age" value="{eventguests:eventguests_age}" maxlength="4" size="4" /><br />
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
  </table>
  <div><br /></div>
  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
   <tr>
    <td class="headb" colspan="2">{lang:status}</td>
    <td class="headb">{lang:date}</td>
    <td class="headb">{lang:name}</td>
   </tr>
   {loop:events}
   <tr>
    <td class="centerc"><input type="checkbox" name="events_checked[{events:events_id}]" value="1"{events:events_checked} /></td>
    <td class="centerc">
      <select name="events_status[{events:events_id}]">
        <option value="0"{events:events_status_0}>{lang:status_0}</option>
        <option value="3"{events:events_status_3}>{lang:status_3}</option>
        <option value="4"{events:events_status_4}>{lang:status_4}</option>
        <option value="5"{events:events_status_5}>{lang:status_5}</option>
      </select>
    </td>
    <td class="centerc">{events:time}</td>
    <td class="leftc" style="min-width: 40%"><a href="{url:events_view:id={events:events_id}}">{events:events_name}</a></td>
   </tr>
   {stop:events}
  </table>
  <div><br /></div>
  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
    <tr>
      <td class="leftc">{icon:ksysguard} {lang:options}</td>
      <td class="leftb" style="width: 50%">
        <input type="hidden" name="events_id" value="{events:events_id}" />
        <input type="submit" name="submit" value="{lang:create}" />
      </td>
    </tr>
  </table>
</form>