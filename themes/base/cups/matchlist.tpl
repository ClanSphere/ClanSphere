<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="3">{lang:mod_name} - {lang:matchlist}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:contents} {lang:total}: {vars:matchcount}</td>
    <td class="leftb"><a href="{url:cups_tree:id={cups:id}}">{lang:cupstree}</a></td>
    <td class="leftb">{pages:list}</td>
  </tr>
  <tr>
    <td class="leftb" colspan="3">{loop:rounds} -> {if:notselected}<a href="{url:cups_matchlist:where={cups:id}&amp;round={rounds:value}}">{stop:notselected}{lang:round} {rounds:name}{if:notselected}</a>{stop:notselected} {stop:rounds}</td>
  </tr>
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>{if:brackets}
    <td class="headb">{sort:bracket} {lang:bracket}</td>{stop:brackets}
    <td class="headb">{sort:team1} {lang:team} 1</td>
    <td class="headb">{lang:result}</td>
    <td class="headb">{lang:status}</td>
    <td class="headb">{sort:team2} {lang:team} 2</td>
    <td class="headb">{lang:match}</td>
  </tr>{loop:matches}
  <tr>{if:brackets}
    <td class="leftc">{matches:bracket}</td>{stop:brackets}
    <td class="leftc">{matches:team1}</td>
    <td class="leftc">{matches:cupmatches_score1} : {matches:cupmatches_score2}</td>
    <td class="leftc">{matches:status}</td>
    <td class="leftc">{matches:team2}</td>
    <td class="leftc"><a href="{url:cups_match:id={matches:cupmatches_id}}">{icon:demo}</a></td>
  </tr>{stop:matches}
</table>