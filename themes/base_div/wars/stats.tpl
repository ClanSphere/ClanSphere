<div class="container" style="width:{page:width}">
  <div class="headb">{lang:mod} - {lang:stats}</div>
  <div class="leftc">{lang:see_stats}</div>
</div>
<br />

<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
 <tr>
  <td class="leftc" style="width:50%">{icon:contents} {lang:total}</td>
  <td class="leftb" style="width:50%">{wars:all} ({wars:played} {lang:played})</td>
 </tr>
 <tr>
  <td class="leftc">{icon:favorites} {lang:wins}</td>
  <td class="leftb">{wars:won_count} -&gt; {wars:won_percent}%</td>
 </tr>
 <tr>
  <td class="leftc">{icon:favorites1} {lang:draws}</td>
  <td class="leftb">{wars:draw_count} -&gt; {wars:draw_percent}%</td>
 </tr>
 <tr>
  <td class="leftc">{icon:favorites1} {lang:looses}</td>
  <td class="leftb">{wars:lost_count} -&gt; {wars:lost_percent}%</td>
 </tr>
 <tr>
  <td class="leftc">{icon:reload} {lang:rounds}</td>
  <td class="leftb">{rounds:count}</td>
 </tr>
 <tr>
  <td class="leftc">{icon:groupevent} {lang:players}</td>
  <td class="leftb">{wars:players_count}</td>
 </tr>
</table>
<br />

<div class="container" style="width:{page:width}">
  <div class="headb">{lang:players}</div>
 {loop:players}
  <div class="leftc" style="width:50%"><a href="{players:url}">{players:users_nick}</a></div>
  <div class="leftb" style="width:50%">{players:wars} {lang:mod}</div>
 {stop:players}
</div>
<br />

<div class="container" style="width:{page:width}">
  <div class="headb">{lang:categories}</div>
 {loop:categories}
  <div class="leftc" style="width:50%"><a href="{categories:url}">{categories:categories_name}</a></div>
  <div class="leftb" style="width:50%">{categories:wars} {lang:mod}</div>
 {stop:categories}
</div>
<br />

<div class="container" style="width:{page:width}">
  <div class="headb" colspan="2">{lang:maps}</div>
 {loop:maps}
  <div class="leftc" style="width:50%"><a href="{url:maps_view,id={maps:maps_id}}">{maps:maps_name}</a></div>
  <div class="leftb" style="width:50%">{maps:rounds} {lang:rounds}</div>
 {stop:maps}
</div>