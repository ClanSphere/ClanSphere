<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:head_edit}</td>
  </tr>
  <tr>
    <td class="leftb">{head:body}</td>
  </tr>
</table>
<br />

{if:preview}
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="leftb" style="width:36px">{prev:icon}</td>
    <td class="leftb">
      <strong><a href="#">{data:board_name}</a></strong><br />
      {prev:text}
    </td>
    <td class="leftb" style="width:60px">-</td>
    <td class="leftb" style="width:60px">-</td>
    <td class="leftb" style="width:160px">-</td>
  </tr>
</table>
<br />
{stop:preview}

<form method="post" id="board_edit" action="{url:board_edit}">
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="leftc" style="width:140px">{icon:kedit} {lang:name} *</td>
    <td class="leftb"><input type="text" name="board_name" value="{data:board_name}" maxlength="200" size="50" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:folder_yellow} {lang:category} *</td>
    <td class="leftb">
      {categories:dropdown}
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:kate} {lang:text} *</td>
    <td class="leftb">
      {abcode:features}
      <textarea class="rte_abcode" name="board_text" cols="50" rows="5" id="board_text">{data:board_text}</textarea>
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:access} {lang:access_req} *</td>
    <td class="leftb" colspan="2">
      <select name="board_access">
        {access:options}
      </select>
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:access} {lang:only_read} *</td>
    <td class="leftb">
      <input type="radio" name="board_read" value="1" {check:yes}/> {lang:yes}
      <input type="radio" name="board_read" value="0" {check:no}/> {lang:no}
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:password} {lang:add_password}</td>
    <td class="leftb">
      <input name="new_board_pwd" value="" onkeydown="javascript:passwordcheck(this.value);" onkeyup="javascript:passwordcheck(this.value);" maxlength="30" size="30" type="password" autocomplete="off" /><br />
        {lang:password2}
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:password} {lang:secure}</td>
    <td class="leftb">
      <div style="float:left; background-image:url({page:path}symbols/votes/vote03.png); width:100px; height:13px; margin-top:3px; margin-left:2px;">
          <div style="float:left; background-image:url({page:path}symbols/votes/vote01.png); width:1px; height:13px;" id="pass_secure"></div>
      </div>
      <div style="float: left; padding-left: 3px; padding-top: 3px; display: none;" id="pass_stage_1">{lang:stage_1}</div>
      <div style="float: left; padding-left: 3px; padding-top: 3px; display: none;" id="pass_stage_2">{lang:stage_2}</div>
      <div style="float: left; padding-left: 3px; padding-top: 3px; display: none;" id="pass_stage_3">{lang:stage_3}</div>
      <div style="float: left; padding-left: 3px; padding-top: 3px; display: none;" id="pass_stage_4">{lang:stage_4}</div>
      <br />
      {clip:sec_level}
    </td>
  </tr>
  {if:pwd_remove}
  <tr>
    <td class="leftc">{icon:configure} {lang:more}</td>
    <td class="leftb"><input type="checkbox" name="board_pwdel" value="1" /> {lang:board_pwddel}</td>
  </tr>
  {stop:pwd_remove}
  <tr>
    <td class="leftc">{icon:yast_group_add} {squads:lang}</td>
    <td class="leftb">
      {squads:dropdown}<br />
      {lang:squad_info2}
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
      <input type="hidden" name="id" value="{board:id}" />
      <input type="hidden" name="board_pwd" value="{data:board_pwd}" />
      <input type="submit" name="submit" value="{lang:edit}" />
      <input type="submit" name="preview" value="{lang:preview}" />
          </td>
  </tr>
</table>
</form>