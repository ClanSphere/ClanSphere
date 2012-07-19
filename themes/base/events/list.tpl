<table class="forum" style="width: {page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
 <tr>
  <td class="headb" colspan="2">{lang:mod_name} - {lang:head_list}</td>
 </tr>
 <tr>
  <td class="leftb">{lang:all}: {head:count_all}</td>
  <td class="rightb">{head:pages}</td>
 </tr>
 <tr>
  <td class="leftb" colspan="2">
    <form method="post" id="events_list" action="{url:events_list}">
      <fieldset style="border: 0; padding: 0">
        {lang:category}
        {head:dropdown}
        <input type="submit" name="submit" value="{lang:show}" />
      </fieldset>
      </form>
   </td>
 </tr>
</table>
<br />

<table class="forum" style="width: {page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
 <tr>
  <td class="headb" style="width:170px">{sort:date} {lang:date}</td>
  <td class="headb">{sort:name} {lang:name}</td>
  <td class="headb" style="width:170px">{lang:venue}</td>
 </tr>{loop:events}
 <tr>
  <td class="leftc">
    {events:time} {events:canceled}
  </td>
  <td class="leftc">
    <span style="float:left; padding-right:8px">
      {events:categories_picture}
    </span> 
    {events:categories_name}
    <hr style="width:100%" />
    <a href="{url:events_view:id={events:events_id}}">{events:events_name}</a>
  </td>
  <td class="leftc">{events:events_venue}</td>
 </tr>{stop:events}
</table>