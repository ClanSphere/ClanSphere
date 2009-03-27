<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb" colspan="3">{lang:mod} - {lang:manage}</td>
 </tr>
 <tr>
  <td class="leftc">{icon:editpaste} <a href="{url:maps_create}">{lang:new_map}</a></td>
  <td class="leftc">{icon:contents} {lang:total}: {maps:maps_count}</td>
  <td class="leftc"> {maps:maps_pages}</td>
 </tr>
</table>
<br />
{head:message}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb">{lang:name}</td>
  <td class="headb" colspan="2">{lang:options}</td>
 </tr>{loop:maplist}
 <tr>
  <td class="leftc"><a href="{url:maps_view:id={maplist:maps_id}}">{maplist:maps_name}</a></td>
  <td class="leftc"><a href="{url:maps_edit:id={maplist:maps_id}}">{icon:edit}</a></td>
  <td class="leftc"><a href="{url:maps_remove:id={maplist:maps_id}}">{icon:editdelete}</a></td>
 </tr>{stop:maplist}
</table>	