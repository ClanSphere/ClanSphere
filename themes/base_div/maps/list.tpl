<div class="container" style="width:{page:width}">
  <div class="headb">{lang:mod} - {lang:list}</div>
 <div class="headc clearfix">
  <div class="leftc fl">{lang:curr_maps}</div>
  <div class="rightc fr">{pages:list}</div>
 </div>
</div>
<br />

<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
 <tr>
  <td class="headb" style="width:30%">{sort:games_name} {lang:game}</td>
  <td class="headb" style="width:70%">{sort:maps_name} {lang:name}</td>
 </tr>{loop:maps}
 <tr>
  <td class="leftb"><a href="{url:games_view,id={maps:games_id}}">{maps:games_name}</a></td>
  <td class="leftb"><a href="{url:maps_view,id={maps:maps_id}}">{maps:maps_name}</a></td>
 </tr>{stop:maps}
</table>