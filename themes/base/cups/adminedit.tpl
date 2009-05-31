<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="2">{lang:mod_name} - {lang:adminedit}</td>
  </tr>
  <tr>
    <td class="leftc">{lang:errors_here}</td>
  </tr>
</table>
<br />

<form method="post" id="adminedit" action="{url:cups_matchedit}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="leftc">{icon:smallcal} {lang:result} {match:team1_name}</td>
    <td class="leftb"><input type="text" name="cupmatches_score1" value="{match:cupmatches_score1}" maxlength="5" size="5" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:smallcal} {lang:result} {match:team2_name}</td>
    <td class="leftb"><input type="text" name="cupmatches_score2" value="{match:cupmatches_score2}" maxlength="5" size="5" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:configure} {lang:confirmed}</td>
    <td class="leftb">
      <input type="checkbox" name="cupmatches_accepted1" value="1"{checked:team1} /> {match:team1_name}<br />
      <input type="checkbox" name="cupmatches_accepted2" value="1"{checked:team2} /> {match:team2_name}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
      <input type="hidden" name="squad1_id" value="{match:team1_id}" />
      <input type="hidden" name="squad2_id" value="{match:team2_id}" />
      <input type="hidden" name="cupmatches_id" value="{match:id}" />
      <input type="submit" name="admin_submit" value="{lang:edit}" />
      </td>
  </tr>
</table>
</form>