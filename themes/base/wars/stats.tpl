<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb">{lang:mod_name} - {lang:stats}</td>
 </tr>
 <tr>
  <td class="leftb">
    {lang:squad}
    <form method="post" id="wars_stats" action="{url:wars_stats}">
      {head:dropdown}
      <input type="submit" name="submit" value="{lang:show}" />
    </form></td>
 </tr>
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="leftc" style="width:25%">{icon:contents} {lang:total}</td>
  <td class="leftb">{lang:total}: {wars:all} ({lang:played}: {wars:played} - {lang:upcoming}: {wars:upcoming} - {lang:canceled}: {wars:canceled} - {lang:running}: {wars:running})</td>
 </tr>
 <tr>
  <td class="leftc"><img src="{page:path}symbols/clansphere/green.gif" alt="" /> {lang:wins}</td>
  <td class="leftb">{wars:won_count} {lang:mod_name} ({wars:won_percent}%)</td>
 </tr>
 <tr>
  <td class="leftc"><img src="{page:path}symbols/clansphere/grey.gif" alt="" /> {lang:draws}</td>
  <td class="leftb">{wars:draw_count} {lang:mod_name} ({wars:draw_percent}%)</td>
 </tr>
 <tr>
  <td class="leftc"><img src="{page:path}symbols/clansphere/red.gif" alt="" /> {lang:looses}</td>
  <td class="leftb">{wars:lost_count} {lang:mod_name} ({wars:lost_percent}%)</td>
 </tr>
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb" colspan="2">{lang:players}</td>
 </tr>
  <tr>
  <td class="leftb" colspan="2">{lang:total}: {wars:players_count} - {lang:missions}: {wars:missions}</td>
 </tr>
 {loop:players}
 <tr>
  <td class="leftc" style="width:25%">{players:users_nick}</td>
  <td class="leftb">{players:wars} {lang:mod_name}</td>
 </tr>
 {stop:players}
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb" colspan="2">{lang:categories}</td>
 </tr>
   <tr>
  <td class="leftb" colspan="2">{lang:total}: {wars:cats_count}</td>
 </tr>
 {loop:categories}
 <tr>
  <td class="leftc" style="width:25%"><a href="{url:categories_view:id={categories:categories_id}}">{categories:categories_name}</a></td>
  <td class="leftb">{categories:wars} {lang:mod_name}</td>
 </tr>
 {stop:categories}
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb" colspan="2">{lang:maps}</td>
 </tr>
    <tr>
  <td class="leftb" colspan="2">{lang:total}: {rounds:count} - {lang:missions}: {rounds:missions}</td>
 </tr>
 {loop:maps}
 <tr>
  <td class="leftc" style="width:25%"><a href="{url:maps_view:id={maps:maps_id}}">{maps:maps_name}</a></td>
  <td class="leftb">{maps:rounds} {lang:rounds}</td>
 </tr>
 {stop:maps}
</table>