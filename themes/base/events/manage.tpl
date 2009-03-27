<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb" colspan="3">{lang:mod} - {lang:manage}</td>
 </tr>
 <tr>
  <td class="leftc">{icon:editpaste} <a href="{url:events_create}">{lang:new_event}</a></td>
  <td class="leftc">{icon:contents} {lang:total}: {count:all}</td>
  <td class="rightc">{pages:list}</td>
 </tr>
 <tr>
  <td class="leftb" colspan="3">
    <form method="post" id="events_manage" action="{url:events_manage}">
      <fieldset style="border: 0; padding: 0">
        {lang:category}
        {head:categories}
        <input type="submit" name="submit" value="{lang:show}" />
      </fieldset>
      </form>
  </td>
 </tr>
</table>
<br />
{head:message}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb">{sort:date} {lang:date}</td>
  <td class="headb">{sort:name} {lang:name}</td>
  <td class="headb">{lang:guests}</td>
  <td class="headb" colspan="4">{lang:options}</td>
 </tr>{loop:events}
 <tr>
  <td class="leftc">{events:time}</td>
  <td class="leftc"><a href="{url:events_view:id={events:events_id}}">{events:events_name}</a></td>
  <td class="leftc">{events:guests} / <strong>{events:events_guestsmax}</strong> {events:canceled}</td>
  <td class="leftc"><a href="{url:events_guests:id={events:events_id}}" title="{lang:guests}">{icon:kdmconfig}</a></td>
  <td class="leftc"><a href="{url:events_picture:id={events:events_id}}" title="{lang:pictures}">{icon:image}</a></td>
  <td class="leftc"><a href="{url:events_edit:id={events:events_id}}" title="{lang:edit}">{icon:edit}</a></td>
  <td class="leftc"><a href="{url:events_remove:id={events:events_id}}" title="{lang:remove}">{icon:editdelete}</a></td>
 </tr>{stop:events}
</table>