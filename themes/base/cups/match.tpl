<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod} - {lang:match}</td>
  </tr>
  <tr>
    <td class="leftc">{lang:matchdetails}</td>
  </tr>
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="leftc">{icon:personal} {lang:team} 1</td>
    <td class="leftb">{match:team1}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:personal} {lang:team} 2</td>
    <td class="leftb">{match:team2}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:kreversi} {lang:cup}</td>
    <td class="leftb"><a href="{url:cups_view:id={match:cups_id}}">{match:cups_name}</a></td>
  </tr>
  <tr>
    <td class="leftc">{icon:package_games} {lang:game}</td>
    <td class="leftb"><a href="{url:games_view:id={match:games_id}}">{match:games_name}</a>
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:smallcal} {lang:result}</td>
    <td class="leftb">{if:showscore}{match:cupmatches_score1} : {match:cupmatches_score2}{stop:showscore}{unless:showscore}-{stop:showscore}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:demo} {lang:status}</td>
    <td class="leftb">{match:status}</td>
  </tr>
</table>{if:participator}
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="centerb">
      <form method="post" name="matchadmin" action="{url:cups_matchedit}">
        <input type="hidden" name="cupmatches_id" value="{match:id}" />
        {if:nothingyet}<input type="hidden" name="team" value="{match:teamnr}" />
        <input type="submit" name="result" value="{lang:enter_result}" class="form" />{stop:nothingyet}
        {if:accept}<input type="submit" name="accept{match:teamnr}" value="{lang:accept_result}" class="form" />{stop:accept}
        {if:confirmed}{lang:both_confirmed}{stop:confirmed}
        {if:waiting}{lang:waiting}{stop:waiting}
        {if:admin}<input type="submit" name="adminedit" value="{lang:adminedit}" class="form" />{stop:admin}
      </form>
    </td>
  </tr>
</table>{stop:participator}
<br />