<div><a href="#" onclick="window.print(); return false">{icon:printmgr}</a></div>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="3">{lang:mod_name} - {lang:guests}</td>
  </tr>
  <tr>
    <td class="leftc" rowspan="2" style="width: 50%">{icon:cal} {lang:event}</td>
    <td class="leftb" colspan="2">{events:events_name}</td>
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
          {lang:signed}
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
    <td class="headb">{lang:number}</td>
    <td class="headb">{lang:req_surname}</td>
    <td class="headb">{lang:req_name}</td>
    <td class="headb">{lang:age}</td>
    <td class="headb" style="min-width: 140px">{lang:contact}</td>
    <td class="headb" style="min-width: 100px">{lang:notice}</td>
  </tr>
  {loop:eventguests}
  <tr>
    <td class="rightc">{eventguests:number}</td>
    <td class="leftc">{eventguests:surname}</td>
    <td class="leftc">{eventguests:name}</td>
    <td class="centerc">{eventguests:age}</td>
    <td class="leftc">{eventguests:phone}<br />{eventguests:mobile}</td>
    <td class="leftc">{eventguests:notice}</td>
  </tr>
  {stop:eventguests}
</table>