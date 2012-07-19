<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{head:mod} - {lang:create}</td>
  </tr>
  <tr>
    <td class="leftc">{head:body}</td>
  </tr>
</table>
<br />

<form method="post" id="squads_new" action="{url:squads_new}" enctype="multipart/form-data">
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="leftc">{icon:yast_group_add} {lang:name} *</td>
    <td class="leftb"><input type="text" name="squads_name" value="{squads:squads_name}" maxlength="80" size="40" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:kdmconfig} {lang:clan_label} *</td>
    <td class="leftb">              
        {squads:clan_sel}      
      - <input type="text" name="new_clan" value="" maxlength="40" size="20" /><br />
      {lang:password}<br />
      <input type="password" name="clans_pwd" value="{squads:clans_pwd}" onkeydown="javascript:passwordcheck(this.value);" onkeyup="javascript:passwordcheck(this.value);" maxlength="30" size="30" autocomplete="off" />
    </td>
  </tr>
  {if:gamesmod}
  <tr>
    <td class="leftc">{icon:package_games} {lang:game}</td>
    <td class="leftb">
      <select name="games_id" onchange="document.getElementById('game_1').src='{page:path}uploads/games/' + this.form.games_id.options[this.form.games_id.selectedIndex].value + '.gif'">
        <option value="0">----</option>
        {squads:games_sel}
      </select>
      {squads:games_img}
    </td>
  </tr>
  {stop:gamesmod}
  <tr>
    <td class="leftc">{icon:enumList} {lang:order}</td>
    <td class="leftb"><input type="text" name="squads_order" value="{squads:squads_order}" maxlength="4" size="4" /></td>
  </tr>
  <tr>
    <td class="leftc" rowspan="2">{icon:password} {lang:password}</td>
    <td class="leftb">
      <input type="password" name="squads_pwd" value="" onkeydown="javascript:passwordcheck(this.value);" onkeyup="javascript:passwordcheck(this.value);" maxlength="30" size="30" autocomplete="off" /></td>
  </tr>
  <tr>
    <td class="leftb">
      <div style="float:left; background-image:url({page:path}symbols/votes/vote03.png); width:100px; height:13px; margin-top: 3px; margin-left: 2px;">
        <div style="float:left; background-image:url({page:path}symbols/votes/vote01.png); width: 1px; height: 13px;" id="pass_secure"></div>
      </div>
      <div style="float:left; padding-left: 3px; padding-top: 3px; display:none" id="pass_stage_1">{lang:stage_1}</div>
      <div style="float:left; padding-left: 3px; padding-top: 3px; display:none" id="pass_stage_2">{lang:stage_2}</div>
      <div style="float:left; padding-left: 3px; padding-top: 3px; display:none" id="pass_stage_3">{lang:stage_3}</div>
      <div style="float:left; padding-left: 3px; padding-top: 3px; display:none" id="pass_stage_4">{lang:stage_4}</div>
      <div style="clear:both">
        {squads:secure_clip}
      </div>
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:download} {lang:pic_up}</td>
    <td class="leftb">
      <input type="file" name="picture" value="" /><br />
      <br />
      {squads:picup_clip}
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
      <input type="submit" name="submit" value="{lang:create}" />
          </td>
  </tr>
</table>
</form>
