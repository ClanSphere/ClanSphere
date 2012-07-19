<table class="forum" style="width: {page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
 <tr>
  <td class="headb" colspan="2">{lang:mod_name} - {lang:agenda}</td>
 </tr>
 <tr>
  <td class="leftb" style="width:220px">
    {lang:time}: {head:time}
  </td>
  <td class="centerb">
    {lang:year}: &lt; {year:last} - {year:current} - {year:next} &gt;
  </td>
 </tr>
</table>
<br />

<table class="forum" style="width: {page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
 <tr>
    <td class="centerc" style="width:17%">{month:1}</td>
    <td class="centerc" style="width:16%">{month:2}</td>
    <td class="centerc" style="width:17%">{month:3}</td>
    <td class="centerc" style="width:16%">{month:4}</td>
    <td class="centerc" style="width:17%">{month:5}</td>
    <td class="centerc">{month:6}</td>
  </tr>
  <tr>
    <td class="centerc">{month:7}</td>
    <td class="centerc">{month:8}</td>
    <td class="centerc">{month:9}</td>
    <td class="centerc">{month:10}</td>
    <td class="centerc">{month:11}</td>
    <td class="centerc">{month:12}</td>
  </tr>
</table>
<br />

<table class="forum" style="width: {page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
 <tr>
  <td class="headb" style="width:20%">{lang:date}</td>
  <td class="headb">{lang:name}</td>
  <td class="headb" style="width:30%">{lang:guests}</td>
 </tr>{loop:events}
 <tr>
  <td class="left{events:class}">
    {events:time}<br />
    {events:signed}<br />
    {events:canceled}
  </td>
  <td class="left{events:class}">
    <span style="float:left; padding-right:8px">
      {events:categories_picture}
    </span> 
    {events:categories_name}
    <hr style="width:100%" />
    <a href="{url:events_view:id={events:events_id}}">{events:events_name}</a>
  </td>
  <td class="left{events:class}">
    {if:access}
    {events:bar}<br />
    {lang:signed}: {events:eventguests} {events:perc}<br />
    {stop:access}
    {if:no_access}
    {events:indicator}<br style="margin-bottom: 4px" />
    {stop:no_access}
    {lang:max}: <strong>{events:events_guestsmax}</strong>
  </td>
 </tr>{stop:events}
</table>