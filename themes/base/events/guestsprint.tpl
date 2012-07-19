<div class="left" style="float:left">{icon:printmgr} <a href="#" onclick="window.print(); return false">{lang:print}</a></div>
<div class="right" style="float:right">{lang:time}: {time:now}</div>
<br style="clear:both" /><br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="leftc" rowspan="2">{icon:cal} {lang:event}</td>
    <td class="leftb" colspan="4"><a href="{url:events_view:id={events:events_id}}">{events:events_name}</a></td>
  </tr>
  <tr>
    <td class="leftb" colspan="4">{events:time}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:organizer} {lang:needage}</td>
    <td class="leftb" colspan="4">{events:events_needage}</td>
  </tr>
  <tr>
    <td class="leftc" rowspan="2">{icon:kdmconfig} {lang:guests}</td>
    <td class="centerc">{lang:min}</td>
    <td class="centerc">{lang:max}</td>
    <td class="centerc">{lang:booked}</td>
    <td class="centerc">{lang:bookable}</td>
  </tr>
  <tr>
    <td class="centerb"><span style="text-decoration: underline">{events:events_guestsmin}</span></td>
    <td class="centerb"><strong>{events:events_guestsmax}</strong></td>
    <td class="centerb">{count:status_booked}</td>
    <td class="centerb">{count:status_available}</td>
  </tr>
  <tr>
    <td class="leftc" rowspan="2">{icon:status_unknown} {lang:status}</td>
    <td class="centerc">{lang:status_0}</td>
    <td class="centerc">{lang:status_3}</td>
    <td class="centerc">{lang:status_4}</td>
    <td class="centerc">{lang:status_5}</td>
  </tr>
  <tr>
    <td class="centerb">{count:status_0}</td>
    <td class="centerb">{count:status_3}</td>
    <td class="centerb">{count:status_4}</td>
    <td class="centerb">{count:status_5}</td>
  </tr>
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:number}</td>
    <td class="headb">{lang:req_surname}</td>
    <td class="headb">{lang:req_name}</td>
    <td class="headb">{lang:age}</td>
    <td class="headb">{lang:status}</td>
    <td class="headb" style="min-width: 100px">{lang:contact}</td>
    <td class="headb" style="min-width: 100px">{lang:notice}</td>
  </tr>
  {loop:eventguests}
  <tr>
    <td class="rightc">{eventguests:number}</td>
    <td class="leftc">{eventguests:surname}</td>
    <td class="leftc">{eventguests:name}</td>
    <td class="centerc">{eventguests:age}</td>
    <td class="leftc">{eventguests:status}</td>
    <td class="leftc">{eventguests:phone}<br />{eventguests:mobile}</td>
    <td class="leftc">{eventguests:notice}</td>
  </tr>
  {stop:eventguests}
</table>