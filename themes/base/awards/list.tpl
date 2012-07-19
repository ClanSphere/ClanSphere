<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="3">{lang:mod_name}</td>
  </tr>
  <tr>
    <td class="leftb" style="width: 50%;">{head:all}</td>
    <td class="rightb">{head:pages}</td>
  </tr>
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{sort:date} {lang:date}</td>
    <td class="headb">{sort:event} {lang:event}</td>
    <td class="headb">{sort:game} {lang:game}</td>
    <td class="headb">{sort:squad} {lang:squad}</td>
    <td class="headb" colspan="2">{sort:place} {lang:place}</td>
  </tr>
  {loop:awards}
  <tr>
    <td class="leftc">{awards:awards_time}</td>
    <td class="leftc"><a href="http://{awards:awards_event_url}">{awards:awards_event}</a></td>
    <td class="leftc"><a href="{url:games_view:id={awards:awards_game_id}}">{awards:awards_game_name}</a></td>
    <td class="leftc"><a href="{url:squads_view:id={awards:squads_id}}">{awards:squads_name}</a></td>
    <td class="leftc">{awards:awards_place}</td>
  </tr>
  {stop:awards}
</table>
