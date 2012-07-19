<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:create}</td>
  </tr>
  <tr>
    <td class="leftc">{head:body}</td>
  </tr>
</table>
<br />

<form method="post" id="replays_create" action="{url:replays_create}" enctype="multipart/form-data">
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="leftc">{icon:folder_yellow} {lang:category} *</td>
    <td class="leftb">
      {replays:cat_dropdown}
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:package_games} {lang:game} *</td>
    <td class="leftb">
      <select name="games_id" onchange="document.getElementById('game_1').src='{page:path}uploads/games/' + this.form.games_id.options[this.form.games_id.selectedIndex].value + '.gif'">
        <option value="0">----</option>
        {loop:games}
        {games:op}
        {stop:games}
      </select>
      {replays:games_img}
      - <a href="{url:games_create}">{lang:create}</a>
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:kate} {lang:version} *</td>
    <td class="leftb"><input type="text" name="replays_version" value="{replays:replays_version}" maxlength="40" size="20" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:kdmconfig} {lang:team1} *</td>
    <td class="leftb"><input type="text" name="replays_team1" value="{replays:replays_team1}" maxlength="80" size="40" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:yast_group_add} {lang:team2} *</td>
    <td class="leftb"><input type="text" name="replays_team2" value="{replays:replays_team2}" maxlength="80" size="40" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:1day} {lang:date} *</td>
    <td class="leftb">
      {replays:date_sel}
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:openterm} {lang:map}</td>
    <td class="leftb" colspan="2"><input type="text" name="replays_map" value="{replays:replays_map}" maxlength="80" size="40" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:download} {lang:upload}</td>
    <td class="leftb">
      <input type="file" name="replay" value="" /><br />
      <br />
      {replays:upload_clip}
    </td>
  </tr>
  <tr>  
    <td class="leftc">{icon:download} {lang:mirror_urls}<br /></td>
    <td class="leftb">
      <textarea class="rte_abcode" name="replays_mirror_urls" id="replays_mirror_urls" cols="50" rows="4">{replays:replays_mirror_urls}</textarea>
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:download} {lang:mirror_names}</td>
    <td class="leftb">
      <textarea class="rte_abcode" name="replays_mirror_names" id="replays_mirror_names" cols="50" rows="4">{replays:replays_mirror_names}</textarea>
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:documentinfo} {lang:info}<br />
      <br />
      {replays:abcode_smileys}
    </td>
    <td class="leftb">
      {replays:abcode_features}
      <textarea class="rte_abcode" name="replays_info" cols="50" rows="8" id="replays_info">{replays:replays_info}</textarea>
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:configure} {lang:more}</td>
    <td class="leftb"><input type="checkbox" name="replays_close" value="1" {replays:close_check} /> {lang:close}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
      <input type="submit" name="submit" value="{lang:create}" />
          </td>
  </tr>
</table>
</form>