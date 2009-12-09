<div><a href="#" onclick="window.print(); return false">{icon:printmgr}</a></div>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="3">{lang:mod_name} - {lang:guests}</td>
  </tr>
  <tr>
    <td class="leftc" rowspan="2" style="width: 50%">{icon:cal} {lang:event}</td>
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
		<td class="leftc" rowspan="3">{icon:kdmconfig} {lang:guests}</td>
		<td class="leftb" style="width:140px">
          <a href="{url:events_guests:id={data:events_id}}">{lang:signed}</a>
        </td>
        <td class="leftc">{head:count}</td>
	</tr>
	<tr>
		<td class="leftb">{lang:min}</td>
		<td class="leftc"><span style="text-decoration: underline">{events:events_guestsmin}</span></td>
	</tr>
	<tr>
		<td class="leftb">{lang:max}</td>
		<td class="leftc"><strong>{events:events_guestsmax}</strong></td>
	</tr>
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:req_surname}</td>
    <td class="headb">{lang:req_name}</td>
    <td class="headb">{lang:time}</td>
    <td class="headb">{lang:contact}</td>
  </tr>
  {loop:eventguests}
  <tr>
    <td class="leftc">{eventguests:surname}</td>
    <td class="leftc">{eventguests:name}</td>
    <td class="leftc">{eventguests:since}</td>
    <td class="leftc">{eventguests:phone}<br />{eventguests:mobile}</td>
  </tr>
  {stop:eventguests}
</table>