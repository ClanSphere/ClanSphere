<table cellpadding="0" cellspacing="{page:cellspacing}" style="width:100%">
  {loop:replays}<tr>
    <td rowspan="2">{replays:game_icon}</td>
    <td>{replays:date}</td>
  </tr>
  <tr>
    <td><a href="{replays:view_url}" title="{replays:team1} vs. {replays:team2}">{replays:team1_short} vs. {replays:team2_short}</a></td>
  </tr>{stop:replays}
</table>
