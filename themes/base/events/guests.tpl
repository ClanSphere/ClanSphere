<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="3">{lang:mod_name} - {lang:guests}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:total}: {head:count}</td>
    <td class="rightb">{head:pages}</td>
  </tr>
  <tr>
{if:admin}
    <td class="leftb"><a href="{url:events_guestsnew:events_id={events:events_id}}">{lang:new_guest}</a></td>
    <td class="rightb"><a href="{url:events_manage}">{lang:manage}</a></td>
{stop:admin}
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

{head:getmsg}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{sort:user} {lang:user}</td>
    <td class="headb">{sort:name} {lang:name}</td>
    <td class="headb">{sort:time} {lang:time}</td>
{if:admin}
    <td class="headb" colspan="2"> {lang:options} </td>
{stop:admin}
  </tr>
  {loop:eventguests}
  <tr>
    <td class="leftc">{eventguests:user}</td>
    <td class="leftc">{eventguests:name}</td>
    <td class="leftc">{eventguests:since}</td>
{if:admin}
    <td class="centerc">{eventguests:edit}</td>
    <td class="centerc">{eventguests:remove}</td>
{stop:admin}
  </tr>
  {stop:eventguests}
</table>