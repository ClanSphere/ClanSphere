<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:rounds_edit}</td>
  </tr>
  <tr>
    <td class="leftc">{head:body}</td>
  </tr>
</table>
<br />

<form method="post" id="roundsedit" action="{url:wars_roundsedit}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="2">{lang:new_round}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:atlantikdesigner} {lang:map} *</td>
    <td class="leftb">
      <select name="maps_id">
        <option value="0">----</option>
        {loop:map}
        {map:sel}
        {stop:map}
      </select>
      - <input type="text" name="new_map" value="{rounds:new_map}" />
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:smallcal} {lang:result}</td>
    <td class="leftb">
      <input type="text" name="rounds_score1" value="{rounds:rounds_score1}" maxlength="8" size="5" /> : 
      <input type="text" name="rounds_score2" value="{rounds:rounds_score2}" maxlength="8" size="5" />
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:kate} {lang:text}<br />
      <br />
      {abcode:smileys}
    </td>
    <td class="leftb">
      {abcode:features}
      <textarea class="rte_abcode" name="rounds_description" cols="20" rows="15" id="rounds_description">{rounds:rounds_description}</textarea>
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
      <input type="hidden" name="id" value="{rounds:id}" />
      <input type="submit" name="submit" value="{lang:edit}" />
          </td>
  </tr>
</table>
</form>