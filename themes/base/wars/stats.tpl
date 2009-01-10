<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb">{lang:mod} - {lang:stats}</td>
 </tr>
 <tr>
  <td class="leftc">{lang:see_stats}</td>
 </tr>
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
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

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb" colspan="2">{lang:players}</td>
 </tr>
 {loop:players}
 <tr>
  <td class="leftc" style="width:50%"><a href="{players:url}">{players:users_nick}</a></td>
  <td class="leftb" style="width:50%">{players:wars} {lang:mod}</td>
 </tr>
 {stop:players}
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb" colspan="2">{lang:categories}</td>
 </tr>
 {loop:categories}
 <tr>
  <td class="leftc" style="width:50%"><a href="{categories:url}">{categories:categories_name}</a></td>
  <td class="leftb" style="width:50%">{categories:wars} {lang:mod}</td>
 </tr>
 {stop:categories}
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb" colspan="2">{lang:maps}</td>
 </tr>
 {loop:maps}
 <tr>
  <td class="leftc" style="width:50%"><a href="{url:maps_view:id={maps:maps_id}}">{maps:maps_name}</a></td>
  <td class="leftb" style="width:50%">{maps:rounds} {lang:rounds}</td>
 </tr>
 {stop:maps}
</table>