<div class="container" style="width:{page:width}">
  <div class="headb">{lang:mod} - {lang:manage}</div>
 <div class="headc clearfix">
  <div class="leftc fl">{icon:editpaste} <a href="{url:maps_create}">{lang:new_map}</a></div>
  <div class="leftc fr"> {maps:maps_pages}</div>
  <div class="centerc">{icon:contents} {lang:total}: {maps:maps_count}</div>
 </div>
</div>
<br />
{head:message}
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
 <tr>
  <td class="headb">{lang:name}</td>
  <td class="headb" colspan="2">{lang:options}</td>
 </tr>{loop:maplist}
 <tr>
  <td class="leftb"><a href="{url:maps_view,id={maplist:maps_id}}">{maplist:maps_name}</a></td>
  <td class="leftb"><a href="{url:maps_edit,id={maplist:maps_id}}">{icon:edit}</a></td>
  <td class="leftb"><a href="{url:maps_remove,id={maplist:maps_id}}">{icon:editdelete}</a></td>
 </tr>{stop:maplist}
</table>	