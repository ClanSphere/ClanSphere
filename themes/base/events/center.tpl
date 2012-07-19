<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="3">{lang:mod_name} - {lang:head_center}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:body_center}</td>
    <td class="centerb">{lang:agenda}</td>
  </tr>
</table>
<br />
{lang:getmsg}

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{sort:time} {lang:date}</td>
    <td class="headb">{sort:name} {lang:name}</td>
    <td class="headb">{lang:guests}</td>
    <td class="headb">{lang:status}</td>
    <td class="headb"> {lang:options} </td>
  </tr>
  {loop:events}
  <tr>
    <td class="leftc">{events:time}</td>
    <td class="leftc">{events:name}</td>
    <td class="leftc">{events:guests} / <strong>{events:guestsmax}</strong> {events:canceled}</td>
    <td class="leftc">{events:status}</td>
    <td class="centerc">{events:remove}</td>
  </tr>
  {stop:events}
</table>