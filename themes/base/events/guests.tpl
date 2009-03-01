<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="3">{lang:mod} - {lang:guests}</td>
  </tr>
  <tr>
    <td class="leftb"><a href="{url:events_manage}">{lang:manage}</a></td>
    <td class="leftb">{lang:total}: {head:count}</td>
    <td class="rightb">{head:pages}</td>
  </tr>
  <tr>
    <td class="centerb" colspan="3">{events:time} - <a href="{url:events_view:id={events:events_id}}">{events:events_name}</a></td>
  </tr>
</table>
<br />
{head:getmsg}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{sort:user} {lang:user}</td>
    <td class="headb">{sort:name} {lang:name}</td>
    <td class="headb">{sort:time} {lang:time}</td>
    <td class="headb"> {lang:options} </td>
  </tr>
  {loop:eventguests}
  <tr>
    <td class="leftc">{eventguests:user}</td>
    <td class="leftc">{eventguests:name}</td>
    <td class="leftc">{eventguests:since}</td>
    <td class="centerc">{eventguests:remove}</td>
  </tr>
  {stop:eventguests}
</table>