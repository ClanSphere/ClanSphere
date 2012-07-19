<table style="width:100%; overflow:hidden" cellpadding="0" cellspacing="0">
 {loop:wars}
 <tr>
  <td class="center" colspan="6">{wars:date}</td>
 </tr>
 <tr>
  <td class="left">{wars:game_icon}</td>
  <td class="left">{wars:matchup}</td>
  <td class="right">{wars:wars_score1}</td>
  <td class="center">:</td>
  <td class="left">{wars:wars_score2}</td>
  <td class="left">{wars:icon}</td>
  </tr>
 {stop:wars}
</table>