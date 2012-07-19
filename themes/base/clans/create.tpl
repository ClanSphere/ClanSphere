<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
    <tr>
      <td class="headb">{lang:mod_name} - {lang:create}</td>
    </tr>
    <tr>
      <td class="leftc">{lang:body}</td>
    </tr>
</table>
<br />
<form method="post" id="clans_create" action="{url:clans_create}" enctype="multipart/form-data">
  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
    <tr>
      <td class="leftc" style="width:140px">{icon:kdmconfig} {lang:name} *</td>
      <td class="leftb"><input type="text" name="clans_name" value="{clans:name}" maxlength="200" size="50" />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:signature} {lang:short} *</td>
      <td class="leftb"><input type="text" name="clans_short" value="{clans:short}" maxlength="20" size="12" />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:attach} {lang:tag}</td>
      <td class="leftb"><input type="text" name="clans_tag" value="{clans:tag}" maxlength="40" size="20" />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:reload} {lang:tagpos}</td>
      <td class="leftb"><select name="tag_pos">
          <option value="0">----</option>
          <option value="1">{lang:before}</option>
          <option value="2">{lang:next}</option>
        </select>
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:locale} {lang:country}</td>
      <td class="leftb">{clans:country}</td>
    </tr>
    <tr>
      <td class="leftc">{icon:gohome} {lang:url}</td>
      <td class="leftb" colspan="2"> http://
        <input type="text" name="clans_url" value="{clans:url}" maxlength="80" size="50" />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:1day} {lang:since}</td>
      <td class="leftb">{clans:since}
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:password} {lang:password}</td>
      <td class="leftb"><input type="password" name="clans_pwd" value="{clans:pw}" maxlength="30" size="30"  onkeydown="javascript:passwordcheck(this.value);" onkeyup="javascript:passwordcheck(this.value);" autocomplete="off" />
      </td>
    </tr>
  <tr>
    <td class="leftc"> {icon:password} {lang:secure}</td>
    <td class="leftb">
      <div style="float:left; background-image:url({page:path}symbols/votes/vote03.png); width:100px; height:13px; margin-top: 3px; margin-left: 2px;">
      <div style="float:left; background-image:url({page:path}symbols/votes/vote01.png); width: 1px; height: 13px;" id="pass_secure">
      </div>
    </div>
    <div style="float:left; padding-left: 3px; padding-top: 3px; display:none" id="pass_stage_1">
      {lang:stage_1}
    </div>
    <div style="float:left; padding-left: 3px; padding-top: 3px; display:none" id="pass_stage_2">
      {lang:stage_2}
    </div>
    <div style="float:left; padding-left: 3px; padding-top: 3px; display:none" id="pass_stage_3">
      {lang:stage_3}
    </div>
    <div style="float:left; padding-left: 3px; padding-top: 3px; display:none" id="pass_stage_4">
      {lang:stage_4}
    </div>
    <div style="clear:both">
      <a class="clip" href="#">{lang:secure_stages}
      <img src="{page:path}symbols/clansphere/plus.gif" alt="+" />
      <img src="{page:path}symbols/clansphere/minus.gif" style="display:none" alt="-" /></a>
      <div style="display:none">
        {lang:stage_1}{lang:stage_1_text}<br />
          {lang:stage_2}{lang:stage_2_text}<br />
          {lang:stage_3}{lang:stage_3_text}<br />
          {lang:stage_4}{lang:stage_4_text}
      </div>
      </div>
      </td>    
  </tr>
    <tr>
      <td class="leftc">{icon:personal} {lang:owner}</td>
      <td class="leftb">
        <input type="text" name="users_nick" id="users_nick" value="{users:nick}" autocomplete="off" onkeyup="Clansphere.ajax.user_autocomplete('users_nick', 'search_users_result' ,'{page:path}')" maxlength="80" size="40" /><br />
        <div id="search_users_result"></div>
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:download} {lang:pic_up}</td>
      <td class="leftb"><input type="file" name="picture" value="" />
        <br />
        <br />
        {clans:clip}</td>
    </tr>
    <tr>
      <td class="leftc">{icon:ksysguard} {lang:options}</td>
      <td class="leftb"><input type="submit" name="submit" value="{lang:create}" />
              </td>
    </tr>
  </table>
</form>