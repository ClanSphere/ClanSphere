<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="2">{lang:mod_name} - {lang:enter_result}</td>
  </tr>
  <tr>
    <td class="leftc">{lang:correct_inputs}</td>
  </tr>
</table>
<br />

<form method="post" id="matchresult" action="{url:cups_matchedit}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="leftc">{icon:yast_group_add} {lang:winner}</td>
    <td class="leftb">
      <select name="cupmatches_winner">
        <option value="0">----</option>
        <option value="{match:team1_id}">{match:team1_name}</option>
        <option value="{match:team2_id}">{match:team2_name}</option>
      </select>
     </td>
  </tr>
  <tr>
    <td class="leftc">{icon:smallcal} {lang:result} {match:team1_name}</td>
    <td class="leftb"><input type="text" name="cupmatches_score1" value="" maxlength="5" size="5" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:smallcal} {lang:result} {match:team2_name}</td>
    <td class="leftb"><input type="text" name="cupmatches_score2" value="" maxlength="5" size="5" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
      <input type="hidden" name="squad1_id" value="{match:team1_id}" />
      <input type="hidden" name="squad2_id" value="{match:team2_id}" />
      <input type="hidden" name="cupmatches_id" value="{match:id}" />
      <input type="hidden" name="team" value="{match:teamnr}" />
      <input type="submit" name="result_submit" value="{lang:insert}" /></td>
  </tr>
</table>
</form>