<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:create}</td>
  </tr>
  <tr>
    <td class="leftc">{maps:message}</td>
  </tr>
</table>
<br />
<form method="post" id="maps_create" action="{maps:action}" enctype="multipart/form-data">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="leftc">{icon:folder_yellow} {lang:name} *</td>
    <td class="leftb"><input type="text" name="maps_name" value="{maps:maps_name}" maxlength="80" size="40" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:folder_yellow} {lang:servername}</td>
    <td class="leftb"><input type="text" name="server_name" value="{maps:server_name}" maxlength="100" size="40" /></td>
  </tr>  
  <tr>
    <td class="leftc">{icon:package_games} {lang:game} *</td>
    <td class="leftb">
      <select name="games_id"  onchange="cs_gamechoose(this.form)">
      <option value="0">----</option>{loop:games}
      <option value="{games:games_id}"{games:selection}>{games:games_name}</option>{stop:games}
      </select>
      <img src="{page:path}uploads/games/0.gif" id="game_1" alt="" />
       - <a href="{url:games_create}">{lang:create}</a>
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:kate} {lang:text}<br />
        <br />
        {abcode:smileys}</td>
    <td class="leftb">{abcode:features}
      <textarea class="rte_abcode" name="maps_text" cols="50" rows="8" id="maps_text"  style="width: 98%;">{maps:maps_text}</textarea>
    </td>
    </tr>
  <tr>
    <td class="leftc">{icon:download} {lang:pic_up}</td>
    <td class="leftb"><input type="file" name="picture" value="" /><br /><br />{maps:matches}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
      <input type="submit" name="submit" value="{lang:create}" />
          </td>
  </tr>
</table>
</form>