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
    {lang:category}
      <form method="post" name="events_manage" action="{url:events_manage}">
        {head:categories} 
      <input type="submit" name="submit" value="{lang:show}" />
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
  <td class="headb">{lang:category}</td>
  <td class="headb" colspan="3">{lang:options}</td>
 </tr>{loop:events}
 <tr>
  <td class="leftb">{events:time}</td>
  <td class="leftb"><a href="{url:events_view:id={events:events_id}}">{events:events_name}</a></td>
  <td class="leftb"><a href="{url:categories_view:id={events:categories_id}}">{events:categories_name}</a></td>
  <td class="leftb"><a href="{url:events_picture:id={events:events_id}}" title="{lang:pictures}">{icon:image}</a></td>
  <td class="leftb"><a href="{url:events_edit:id={events:events_id}}" title="{lang:edit}">{icon:edit}</a></td>
  <td class="leftb"><a href="{url:events_remove:id={events:events_id}}" title="{lang:remove}">{icon:editdelete}</a></td>
 </tr>{stop:events}
</table>