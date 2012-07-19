<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="3">{lang:mod_name} - {lang:guests_latest}</td>
  </tr>
  <tr>
    <td class="leftb" style="min-width: 30%">{lang:total}: {head:count}</td>
    <td class="centerb"><a href="{url:events_manage}">{lang:manage}</a></td>
    <td class="rightb" style="min-width: 30%">{head:pages}</td>
  </tr>
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" style="min-width: 100px">{lang:event}</td>
    <td class="headb" style="min-width: 100px">{lang:user}</td>
    <td class="headb" style="min-width: 100px">{sort:name} {lang:name}</td>
    <td class="headb">{sort:time} {lang:time}</td>
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
    <td class="leftc">{eventguests:since}</td>
    <td class="centerc">{eventguests:notice}</td>
    <td class="centerc">{eventguests:edit}</td>
    <td class="centerc">{eventguests:remove}</td>
  </tr>
  {stop:eventguests}
</table>