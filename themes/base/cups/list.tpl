<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb">{lang:mod} - {lang:list}</td>
 </tr>
 <tr>
  <td class="leftb">{icon:contents} {lang:total}: {count:all}</td>
 </tr>
 <tr>
  <td class="leftb">
    <form method="post" id="gamechoice" action="{url:cups_list}">
    {lang:game}:
    <select name="games_id" >
      <option value="0">----</option>{loop:games}
      <option value="{games:games_id}"{games:selection}>{games:games_name}</option>{stop:games}
    </select>
    <input type="submit" name="submit" value="{lang:show}" /></form>
  </td>
 </tr>
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb">{lang:game}</td>
  <td class="headb">{lang:name}</td>
  <td class="headb">{lang:join_end}</td>
  <td class="headb">{lang:teams}</td>
  <td class="headb">{lang:matchlist}</td>
 </tr>{loop:cups}
 <tr>
  <td class="leftc"></td>
  <td class="leftc"><a href="{url:cups_view:id={cups:cups_id}}">{cups:cups_name}</a></td>
  <td class="leftc">{cups:start}</td>
  <td class="leftc">{cups:cups_joined} {lang:of} {cups:cups_teams}</td>
  <td class="leftc"><a href="{url:cups_matchlist:where={cups:cups_id}}">{icon:demo}</a></td>
 </tr>{stop:cups}
</table>