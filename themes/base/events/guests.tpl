<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="3">{lang:mod} - {lang:guests}</td>
  </tr>
  <tr>
    <td class="leftb" style="width:40%">{events:time}</td>
    <td class="leftb">{lang:total}: {head:count}</td>
    <td class="rightb">{head:pages}</td>
  </tr>
  <tr>
{if:other}
    <td class="leftb" colspan="3"><a href="{url:events_view:id={events:events_id}}">{events:events_name}</a></td>
{stop:other}
{if:admin}
    <td class="leftb"><a href="{url:events_view:id={events:events_id}}">{events:events_name}</a></td>
    <td class="leftb"><a href="{url:events_guestsnew:events_id={events:events_id}}">{lang:new_guest}</a></td>
    <td class="rightb"><a href="{url:events_manage}">{lang:manage}</a></td>
{stop:admin}
  </tr>
</table>
<br />
{head:getmsg}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{sort:user} {lang:user}</td>
    <td class="headb">{sort:name} {lang:name}</td>
    <td class="headb">{sort:time} {lang:time}</td>
{if:admin}
    <td class="headb"> {lang:options} </td>
{stop:admin}
  </tr>
  {loop:eventguests}
  <tr>
    <td class="leftc">{eventguests:user}</td>
    <td class="leftc">{eventguests:name}</td>
    <td class="leftc">{eventguests:since}</td>
{if:admin}
    <td class="centerc">{eventguests:remove}</td>
{stop:admin}
  </tr>
  {stop:eventguests}
</table>