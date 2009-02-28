<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="2">{lang:mod} - {lang:matchlist}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:contents} {lang:total}: {vars:matchcount}</td>
    <td class="leftc">{pages:list}</td>
  </tr>
  <tr>
    <td class="leftc" colspan="2">
    <form method="post" name="cups_tree" action="{url:cups_matchlist}">
      <input type="hidden" name="where" value="{vars:cups_id}" />
      <select name="round" class="form">{loop:rounds}
	      <option value="{rounds:value}"{rounds:selected}>{lang:round} {rounds:value}</option>{stop:rounds}
      </select>
      <input type="submit" name="submit" value="{lang:show}" class="form" />
    </form>
    </td>
  </tr>
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>{if:brackets}
    <td class="headb">{sort:bracket} {lang:bracket}</td>{stop:brackets}
    <td class="headb">{sort:team1} {lang:team} 1</td>
    <td class="headb">{lang:result}</td>
    <td class="headb">{sort:team2} {lang:team} 2</td>
    <td class="headb">{lang:match}</td>
  </tr>{loop:matches}
  <tr>{if:brackets}
    <td class="leftb">{matches:bracket}</td>{stop:brackets}
    <td class="leftb">{matches:team1}</td>
    <td class="leftb">{matches:cupmatches_score1} : {matches:cupmatches_score2}</td>
    <td class="leftb">{matches:team2}</td>
    <td class="leftb"><a href="{url:cups_match:id={matches:cupmatches_id}}">{icon:demo}</a></td>
  </tr>{stop:matches}
</table>