<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="2">{lang:mod_name} - {lang:guests}</td>
  </tr>
  <tr>
    <td class="leftb" style="width: 50%">{lang:total}: {head:count}</td>
    <td class="rightb">{head:pages}</td>
  </tr>
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="leftc" rowspan="2">{icon:cal} {lang:event}</td>
    <td class="leftb" colspan="2"><a href="{url:events_view:id={events:events_id}}">{events:events_name}</a></td>
  </tr>
  <tr>
    <td class="leftb" colspan="2">{events:time}</td>
  </tr>
	<tr>
		<td class="leftc">{icon:organizer} {lang:needage}</td>
		<td class="leftb" colspan="2">{events:events_needage}</td>
	</tr>
	<tr>
		<td class="leftc" rowspan="2">{icon:kdmconfig} {lang:guests}</td>
		<td class="leftb">{lang:min}</td>
		<td class="leftc"><span style="text-decoration: underline">{events:events_guestsmin}</span></td>
	</tr>
	<tr>
		<td class="leftb">{lang:max}</td>
		<td class="leftc"><strong>{events:events_guestsmax}</strong></td>
	</tr>
</table>
<br />

{if:admin}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="centerb">{icon:yast_user_add} <a href="{url:events_guestsnew:events_id={events:events_id}}">{lang:new_guest}</a></td>
    <td class="centerb">{icon:printmgr} <a href="#" onclick="window.open('{page:path}print.php', '{lang:print_view}', 'width=800,height=600,scrollbars=yes'); return false">{lang:print_view}</a></td>
    <td class="centerb">{icon:view_text} <a href="{url:events_manage}">{lang:manage}</a></td>
  </tr>
</table>
<br />
{stop:admin}

{head:getmsg}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" style="min-width: 100px">{sort:user} {lang:user}</td>
    <td class="headb">{sort:name} {lang:name}</td>
    <td class="headb">{sort:time} {lang:time}</td>
{if:admin}
    <td class="headb" style="min-width: 140px">{lang:contact}</td>
    <td class="headb" colspan="2">{lang:options}</td>
{stop:admin}
  </tr>
  {loop:eventguests}
  <tr>
    <td class="leftc">{eventguests:user}</td>
    <td class="leftc">{eventguests:name}</td>
    <td class="leftc">{eventguests:since}</td>
{if:admin}
    <td class="leftc">{eventguests:phone}<br />{eventguests:mobile}</td>
    <td class="centerc">{eventguests:edit}</td>
    <td class="centerc">{eventguests:remove}</td>
{stop:admin}
  </tr>
  {stop:eventguests}
</table>