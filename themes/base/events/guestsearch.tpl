<form method="post" action="{url:events_guestsearch}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb" colspan="3">{lang:mod_name} - {lang:guests_search}</td>
  </tr>
  <tr>
    <td class="leftb"><a href="{url:events_manage}">{lang:manage}</a></td>
    <td class="leftb">{lang:total}: {head:count}</td>
    <td class="rightb">{head:pages}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:search}</td>
    <td class="leftb" colspan="2">
      <input type="text" name="guests_search" id="guests_search" value="{guests:search}" size="50" maxlength="100" />
      <input type="submit" name="{lang:submit}" />
    </td>
  </tr>
</table>
</form>
<br />
{if:search}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" style="min-width: 100px">{lang:event}</td>
    <td class="headb" style="min-width: 100px">{sort:user} {lang:user}</td>
    <td class="headb" style="min-width: 100px">{sort:name} {lang:name}</td>
    <td class="headb" colspan="2">{lang:contact}</td>
    <td class="headb" colspan="3">{lang:options}</td>
  </tr>
  {loop:eventguests}
  <tr>
    <td class="leftc">
      <a href="{url:events_view:id={eventguests:events_id}}">{eventguests:events_name}</a><br />
      {eventguests:events_date}
    </td>
    <td class="leftc">{eventguests:user}</td>
    <td class="leftc">{eventguests:name}</td>
    <td class="centerc">{eventguests:phone}</td>
    <td class="centerc">{eventguests:mobile}</td>
    <td class="centerc">{eventguests:notice}</td>
    <td class="centerc">{eventguests:edit}</td>
    <td class="centerc">{eventguests:remove}</td>
  </tr>
  {stop:eventguests}
</table>
{stop:search}