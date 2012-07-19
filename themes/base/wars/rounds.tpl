<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="2">{lang:mod_name} - {lang:rounds}</td>
  </tr>
  <tr>
    <td class="leftc">{head:body}</td>
    <td class="rightc"><a href="{url:wars_manage}">{lang:manage}</a></td>
  </tr>
</table>
<br />

<form method="post" id="roundadd" action="{url:wars_rounds}">
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
      - <input type="text" name="new_map" value="{wars:new_map}" />
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:smallcal} {lang:result}</td>
    <td class="leftb">
      <input type="text" name="rounds_score1" value="{wars:rounds_score1}" maxlength="8" size="5" /> : 
      <input type="text" name="rounds_score2" value="{wars:rounds_score2}" maxlength="8" size="5" />
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:kate} {lang:text}<br />
      <br />
      {abcode:smileys}
    </td>
    <td class="leftb">
      {abcode:features}
      <textarea class="rte_abcode" name="rounds_description" cols="20" rows="15" id="rounds_description">{wars:rounds_description}</textarea>
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
      <input type="hidden" name="id" value="{wars:id}" />
      <input type="submit" name="submit" value="{lang:create}" />
          </td>
  </tr>
</table>
</form>
<br />

{get:msg}

{if:rounds}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:map}</td>
    <td class="headb">{lang:result}</td>
    <td class="headb" colspan="3" style="width:25%">{lang:options}</td>
  </tr>
  {loop:maps}
  <tr>
    <td class="leftc">{maps:name}</td>
    <td class="leftc">{maps:result}</td>
    <td class="leftc"><a href="{url:wars_roundsedit:id={maps:rounds_id}}" title="{lang:edit}">{icon:edit}</a></td>
    <td class="leftc"><a href="{url:wars_roundsremove:id={maps:rounds_id}}" title="{lang:remove}">{icon:editdelete}</a></td>
    <td class="leftc">{maps:up_down}</td>
  </tr>
  {stop:maps}
</table>
{stop:rounds}