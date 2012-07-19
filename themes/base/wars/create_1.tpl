<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb">{lang:mod_name} - {lang:create}</td>
 </tr>
 <tr>
  <td class="leftc">{var:message}</td>
 </tr>
</table>
<br />

<form method="post" id="wars_create" action="{url:wars_create}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="leftc">{icon:package_games} {lang:game} *</td>
  <td class="leftb">
    <select name="games_id"  onchange="cs_gamechoose(this.form)">
     <option value="0">----</option>{loop:games}
     <option value="{games:games_id}"{games:selection}>{games:games_name}</option>{stop:games}
    </select>
  {img:game}
   - <a href="{url:games_create}">{lang:create}</a>
  </td>
 </tr>
 <tr>
  <td class="leftc">{icon:folder_yellow} {lang:category} *</td>
  <td class="leftb">
    <select name="categories_id">
     <option value="0">----</option>{loop:categories}
     <option value="{categories:categories_id}"{categories:selection}>{categories:categories_name}</option>{stop:categories}
    </select> -
    <input type="text" name="categories_name" value="" maxlength="80" size="20" />
  </td>
 </tr>
 <tr>
  <td class="leftc">{icon:kdmconfig} {lang:enemy} *</td>
  <td class="leftb">
    <select name="clans_id">
     <option value="0">----</option>{loop:clans}
     <option value="{clans:clans_id}"{clans:selection}>{clans:clans_name}</option>{stop:clans}
    </select> -
    <input type="text" name="new_enemy" value="" maxlength="30" size="20" />
    <br />
    {lang:players}:
    <input type="text" name="wars_opponents" value="{value:opponents}" maxlength="90" size="50" />
  </td>
 </tr>
 <tr>
  <td class="leftc">{icon:yast_group_add} {lang:squad} *</td>
  <td class="leftb">
    <select name="squads_id">
     <option value="0">----</option>{loop:squads}
     <option value="{squads:squads_id}"{squads:selection}>{squads:squads_name}</option>{stop:squads}
    </select> -
    <a href="{url:squads_create}">{lang:create}</a>
  </td>
 </tr>
 <tr>
  <td class="leftc">{icon:kdmconfig} {lang:players}</td>
  <td class="leftb">
    <input type="text" name="wars_players1" value="{value:players1}" maxlength="4" size="4" />
    {lang:on}
    <input type="text" name="wars_players2" value="{value:players2}" maxlength="4" size="4" />
  </td>
 </tr>
 <tr>
  <td class="leftc">{icon:personal} {lang:player}</td>
  <td class="leftb">
    {loop:players}
    <input type="text" name="player{players:run}" value="{players:value}" maxlength="35" size="25" /> -
    {players:dropdown}
    <br />
    {stop:players}
    <input type="submit" name="playeradd" value="{lang:add_player}" />
  </td>
 </tr>
 <tr>
  <td class="leftc">{icon:1day} {lang:date} *</td>
  <td class="leftb">{dropdown:date}</td>
 </tr>
 <tr>
  <td class="leftc">{icon:demo} {lang:status} *</td>
  <td class="leftb">
    <select name="wars_status">
     <option value="0">----</option>
     <option value="upcoming"{upcoming:selection}>{lang:upcoming}</option>
     <option value="running"{running:selection}>{lang:running}</option>
     <option value="canceled"{canceled:selection}>{lang:canceled}</option>
     <option value="played"{played:selection}>{lang:played}</option>
    </select>
  </td>
 </tr>
 <tr>
  <td class="leftc">{icon:bookmark} {lang:top}</td>
  <td class="leftb"><input type="checkbox" name="wars_topmatch" value="1" {value:wars_topmatch_check} /></td>
 </tr>
 <tr>
  <td class="leftc">{icon:smallcal} {lang:score}</td>
  <td class="leftb">
    <input type="text" name="wars_score1" value="{value:score1}" maxlength="5" size="5" /> :
    <input type="text" name="wars_score2" value="{value:score2}" maxlength="5" size="5" />
  </td>
 </tr>
 <tr>
  <td class="leftc">{icon:gohome} {lang:url}</td>
  <td class="leftb" colspan="2">http://
    <input type="text" name="wars_url" value="{value:url}" maxlength="80" size="50" />
  </td>
 </tr>
 <tr>
  <td class="leftc">{icon:kate} {lang:report}
    <br /><br />
    {abcode:smileys}
  </td>
  <td class="leftb">{abcode:features}
    <br />
    <textarea class="rte_abcode" name="wars_report" cols="50" rows="8" id="wars_report">{value:report}</textarea>
  </td>
 </tr>
  <tr>
  <td class="leftc">{icon:kate} {lang:report2}
    <br /><br />
    {abcode:smileys2}
  </td>
  <td class="leftb">{abcode:features2}
    <br />
    <textarea class="rte_abcode" name="wars_report2" cols="50" rows="8" id="wars_report2">{value:report2}</textarea>
  </td>
 </tr>
   <tr>
    <td class="leftc">{icon:configure} {lang:more}</td>
    <td class="leftb"><input type="checkbox" name="wars_close" value="1" {value:close_check} /> {lang:close}</td>
  </tr>
 <tr>
  <td class="leftc">{icon:ksysguard} {lang:options}</td>
  <td class="leftb">
    <input type="hidden" name="players" value="{form:players}" />
    <input type="submit" name="submit" value="{lang:create}" />
      </td>
 </tr>
</table>
</form>