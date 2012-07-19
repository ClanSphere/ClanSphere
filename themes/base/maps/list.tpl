<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb" colspan="2">{lang:mod_name} - {lang:list}</td>
 </tr>
 <tr>
  <td class="leftc">{lang:curr_maps}</td>
  <td class="rightc">{pages:list}</td>
 </tr>
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb" style="width:30%">{sort:games_name} {lang:game}</td>
  <td class="headb" style="width:70%">{sort:maps_name} {lang:name}</td>
 </tr>{loop:maps}
 <tr>
  <td class="leftc"><a href="{url:games_view:id={maps:games_id}}">{maps:games_name}</a></td>
  <td class="leftc"><a href="{url:maps_view:id={maps:maps_id}}">{maps:maps_name}</a></td>
 </tr>{stop:maps}
</table>