<table class="forum" style="width: {page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
 <tr>
  <td class="headb" colspan="2">{lang:mod} - {lang:head_list}</td>
 </tr>
 <tr>
  <td class="leftb">{icon:contents} {lang:all} {head:count_all}</td>
  <td class="rightb">{head:pages}</td>
 </tr>
 <tr>
  <td class="leftb">{lang:category} 
    <form method="post" name="events_list" action="{url:events_list}">
    {head:dropdown}
    <input name="submit" value="{lang:show}" class="form" type="submit"></form>
   </td>
  <td class="rightb"><a href="{url:events_calendar}">{lang:calendar}</a></td>
 </tr>
</table>
<br />

<table class="forum" style="width: {page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
 <tr>
  <td class="headb">{sort:name} {lang:name}</td>
  <td class="headb">{sort:date} {lang:date}</td>
 </tr>{loop:events}
 <tr>
  <td class="leftc"><a href="{url:events_view:id={events:events_id}}">{events:events_name}</a></td>
  <td class="leftc">{events:time}</td>
 </tr>{stop:events}
</table>