<table class="forum" style="width: {page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
 <tr>
  <td class="headb">{lang:mod} - {lang:head_list}</td>
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

{if:events}
<table class="forum" style="width: {page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
 <tr>
  <td class="headb" style="width:170px">{lang:date}</td>
  <td class="headb" >{lang:name}</td>
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
{stop:events}