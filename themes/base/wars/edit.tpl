<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:edit}</td>
  </tr>
  <tr>
    <td class="leftb">{head:body}</td>
  </tr>
</table>
<br />

<form method="post" id="wars_edit" action="{url:wars_edit}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="leftc">{icon:package_games} {lang:game} *</td>
    <td class="leftb">
      <select name="games_id" onchange="cs_gamechoose(this.form)">
        <option value="0">----</option>
        {loop:games}
        {games:choose}
        {stop:games}
      </select>
      {wars:game_img}
      - <a href="{url:games_create}">{lang:create}</a>
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:folder_yellow} {lang:category} *</td>
    <td class="leftb">
      {wars:category_sel}
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:kdmconfig} {lang:enemy} *</td>
    <td class="leftb">
      {wars:enemy_sel}
      <br />
      {lang:players}: <input type="text" name="wars_opponents" value="{wars:wars_opponents}" maxlength="90" size="50" />
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:yast_group_add} {lang:squad} *</td>
    <td class="leftb">
      {wars:squad_sel}      
      - <a href="{url:squads_create}">{lang:create}</a>
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:kdmconfig} {lang:players}</td>
    <td class="leftb">
      <input type="text" name="wars_players1" value="{wars:wars_players1}" maxlength="4" size="4" /> {lang:on}
      <input type="text" name="wars_players2" value="{wars:wars_players2}" maxlength="4" size="4" />
    </td>
  </tr>  
  <tr>
    <td class="leftc">{icon:personal} {lang:players}</td>
    <td class="leftb">
    {loop:player}
      <input type="text" name="player{player:x}" value="{player:player_name}" maxlength="35" size="25" /> -
      {player:user_sel}
      <br />
      {stop:player}
      <input type="submit" name="playeradd" value="{lang:add_player}" />
    </td>
  </tr>  
  <tr>
    <td class="leftc">{icon:1day} {lang:date} *</td>
    <td class="leftb">
      {wars:date_sel}
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:demo} {lang:status} *</td>
    <td class="leftb">
      {wars:status_dropdown}
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:bookmark} {lang:top}</td>
    <td class="leftb"><input type="checkbox" name="wars_topmatch" value="1" {value:wars_topmatch_check} /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:smallcal} {lang:score}</td>
    <td class="leftb">
      <input type="text" name="wars_score1" value="{wars:wars_score1}" maxlength="5" size="5" /> :
      <input type="text" name="wars_score2" value="{wars:wars_score2}" maxlength="5" size="5" />
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:gohome} {lang:url}</td>
    <td class="leftb">
      http://<input type="text" name="wars_url" value="{wars:wars_url}" maxlength="80" size="50" />
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:kate} {lang:report}<br />
      <br />
      {abcode:smileys}
    </td>
    <td class="leftb">
      {abcode:features}
      <textarea class="rte_abcode" name="wars_report" cols="50" rows="8" id="wars_report">{wars:wars_report}</textarea>
    </td>
  </tr>
    <tr>
    <td class="leftc">{icon:kate} {lang:report2}<br />
      <br />
      {abcode:smileys2}
    </td>
    <td class="leftb">
      {abcode:features2}
      <textarea class="rte_abcode" name="wars_report2" cols="50" rows="8" id="wars_report2">{wars:wars_report2}</textarea>
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:configure} {lang:more}</td>
    <td class="leftb"><input type="checkbox" name="wars_close" value="1" {wars:close_check} /> {lang:close}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
      <input type="hidden" name="players" value="{wars:check_player}" />
      <input type="hidden" name="id" value="{wars:id}" />
      <input type="submit" name="submit" value="{lang:edit}" />
            <input type="submit" name="playeradd" value="{lang:add_player}" />
    </td>
  </tr>
</table>
</form>