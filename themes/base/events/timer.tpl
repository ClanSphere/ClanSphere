<table class="forum" style="width: {page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
 <tr>
  <td class="headb">{lang:mod_name} - {lang:head_list}</td>
 </tr>
 <tr>
  <td class="leftb" colspan="2">
    <form method="post" id="events_timer" action="{url:events_timer}">
      <fieldset style="border: 0; padding: 0">
        {lang:date}
        {head:dropdown}
        <input type="submit" name="submit" value="{lang:show}" />
      </fieldset>
      </form>
   </td>
 </tr>
</table>
<br />

{if:av_events}
<table class="forum" style="width: {page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
 <tr>
  <td class="headb" style="width:170px">{lang:date}</td>
  <td class="headb">{lang:name}</td>
 </tr>
{loop:events}
 <tr>
  <td class="leftc">
    {events:time}
  </td>
  <td class="leftc">
    {events:link}
  </td>
 </tr>
{stop:events}
</table>
<br />
{stop:av_events}

{if:av_users}
<table class="forum" style="width: {page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
 <tr>
  <td class="headb" style="width:35%">{lang:user}</td>
  <td class="headb" style="width:25%">{lang:new_age}</td>
  <td class="headb" style="width:40%">{lang:place}</td>
 </tr>
{loop:users}
 <tr>
  <td class="leftc">
    {users:link}
  </td>
  <td class="leftc">
    {users:new_age}
  </td>
  <td class="leftc">
    {users:place}
  </td>
 </tr>
{stop:users}
</table>
{stop:av_users}