<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:join}</td>
  </tr>
  <tr>
    <td class="leftc">{lang:which_squad}</td>
  </tr>
</table>
<br />

<form method="post" id="cupsjoin" action="{url:cups_join}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="leftc">{icon:yast_group_add} {lang:squad}</td>
    <td class="leftb">
      <select name="squads_id">
        <option value="0" selected="selected">----</option>{loop:squads}
        <option value="{squads:squads_id}">{squads:squads_name}</option>{stop:squads}
       </select>
     </td>
  </tr>
  <tr>
    <td class="leftc">{icon:configure} {lang:options}</td>
    <td class="leftb">
      <input type="hidden" name="cups_id" value="{cup:id}" />
      <input type="hidden" name="system" value="teams" />
      <input type="submit" name="submit" value="{lang:take_part}" />
     </td>
  </tr>
</table>
</form>