<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:password}</td>
  </tr>
  <tr>
    <td class="leftb">{head:body}</td>
  </tr>
</table>
<br />

<form method="post" id="users_password" action="{url:users_password}">
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="leftc" style="width:200px">{icon:password} {lang:pwd_current} *</td>
    <td class="leftb"><input type="password" name="pwd_current" value="{users:current_pwd}" maxlength="30" size="30" autocomplete="off" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:password} {lang:pwd_new} *</td>
    <td class="leftb"><input type="password" name="pwd_new" value="{users:new_pwd}" onkeydown="javascript:passwordcheck(this.value);" onkeyup="javascript:passwordcheck(this.value);" maxlength="30" size="30" autocomplete="off" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:password} {lang:pwd_again} *</td>
    <td class="leftb"><input type="password" name="pwd_again" value="{users:pwd_again}" onkeydown="javascript:passwordcheck(this.value);" onkeyup="javascript:passwordcheck(this.value);" maxlength="30" size="30" autocomplete="off" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:password} {lang:secure}</td>
    <td class="leftb">
      <div style="float:left; background-image:url({page:path}symbols/votes/vote03.png); width:100px; height:13px; margin-top: 3px; margin-left: 2px;">
        <div style="float:left; background-image:url({page:path}symbols/votes/vote01.png); width: 1px; height: 13px;" id="pass_secure"></div>
      </div>
      <div style="float:left; padding-left: 3px; padding-top: 3px; display:none" id="pass_stage_1">{lang:stage_1}</div>
      <div style="float:left; padding-left: 3px; padding-top: 3px; display:none" id="pass_stage_2">{lang:stage_2}</div>
      <div style="float:left; padding-left: 3px; padding-top: 3px; display:none" id="pass_stage_3">{lang:stage_3}</div>
      <div style="float:left; padding-left: 3px; padding-top: 3px; display:none" id="pass_stage_4">{lang:stage_4}</div>
      <div style="clear:both">
        {users:secure_clip}
      </div>
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
      <input type="submit" name="submit" value="{lang:edit}" />
          </td>
  </tr>
</table>
</form>