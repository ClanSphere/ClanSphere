<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:create}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:body_create}</td>
  </tr>
</table>
<br />
{if:error}
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="leftb">{create:errormsg}</td>
  </tr>
</table>
<br />
{stop:error}
{if:preview}
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="leftb" style="">{create:board_ico}</td>
    <td class="leftc">
      <strong>
        <a href="#">{create:board_name} </a>
      </strong>
      <br />
      {create:pre_text}
    </td>
    <td class="leftc"></td>
    <td class="leftb"></td>
    <td class="leftc"></td>
  </tr>
</table>
<br />
{stop:preview}
<form method="post" id="board_create" action="{url:board_create}">
  <table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
    <tr>
      <td class="leftc">{icon:kedit} {lang:name} *</td>
      <td class="leftb">
        <input name="board_name" value="{create:board_name}" maxlength="200" size="50" type="text" />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:folder_yellow} {lang:category} *</td>
      <td class="leftb">{create:cat_drop}</td>
    </tr>
    <tr>
      <td class="leftc">{icon:kate} {lang:text} *</td>
      <td class="leftb">
        {create:ab_box}
        <textarea class="rte_abcode" name="board_text" cols="50" rows="5" id="board_text">{create:board_text}</textarea>
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:access} {lang:access_req} *</td>
      <td class="leftb" colspan="2">
        <select name="board_access">
          {loop:access}
          {access:access_level}
          {stop:access}
        </select>
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:access} {lang:only_read} *</td>
      <td class="leftb">
        <input name="board_read" value="1" type="radio" />{lang:yes}
        <input name="board_read" value="0" checked="checked" type="radio" />{lang:no}
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:password} {lang:add_password}</td>
      <td class="leftb">
        <input name="board_pwd" value="{create:board_pwd}" onkeydown="javascript:passwordcheck(this.value);" onkeyup="javascript:passwordcheck(this.value);" maxlength="30" size="30" type="password" autocomplete="off" /><br />
        {lang:password1}
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:password} {lang:secure}</td>
      <td class="leftb">
        <div style="float: left; background-image: url({page:path}symbols/votes/vote03.png); width: 100px; height: 13px; margin-top: 3px; margin-left: 2px;">
          <div style="float: left; background-image: url({page:path}symbols/votes/vote01.png); width: 1px; height: 13px;" id="pass_secure"></div>
        </div>
        <div style="float: left; padding-left: 3px; padding-top: 3px; display: none;" id="pass_stage_1">{lang:stage_1}</div>
        <div style="float: left; padding-left: 3px; padding-top: 3px; display: none;" id="pass_stage_2">{lang:stage_2}</div>
        <div style="float: left; padding-left: 3px; padding-top: 3px; display: none;" id="pass_stage_3">{lang:stage_3}</div>
        <div style="float: left; padding-left: 3px; padding-top: 3px; display: none;" id="pass_stage_4">{lang:stage_4}</div>
        <br />
        {create:sec_level}
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:yast_group_add} {create:squad_lang}</td>
      <td class="leftb">{create:squad_drop}<br />{lang:squad_info2}</td>
    </tr>
    <tr>
      <td class="leftc">{icon:ksysguard} {lang:options}</td>
      <td class="leftb">
        <input name="submit" value="{lang:create}" type="submit" />
        <input name="preview" value="{lang:preview}" type="submit" />
      </td>
    </tr>
  </table>
</form>