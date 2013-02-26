<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:create}</td>
  </tr>
  <tr>
    <td class="leftc">{head:body}</td>
  </tr>
</table>
<br />
<form method="post" id="users_create" action="{url:users_create}">
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="leftc" style="width:25%">{icon:locale} {lang:lang} *</td>
    <td class="leftb" style="width:75%">
      <select name="lang">
        {lang:opts}
      </select>
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:personal} {lang:nick} *</td>
    <td class="leftb"><input type="text" name="nick" value="{data:users_nick}" maxlength="40" size="40" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:mail_generic} {lang:email} *</td>
    <td class="leftb"><input type="text" name="email" value="{data:users_email}" maxlength="40" size="40" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:access} {lang:access} *</td>
    <td class="leftb">
      {access:dropdown}
    </td>
  </tr>
  {if:simple}
  <tr>
    <td class="leftc">{icon:password} {lang:password} *</td>
    <td class="leftb"><input type="password" name="password" value="" onkeydown="javascript:passwordcheck(this.value);" onkeyup="javascript:passwordcheck(this.value);" maxlength="30" size="30" autocomplete="off" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:password} {lang:secure}</td>
    <td class="leftb">
      <div style="float:left; background-image:url({page:path}symbols/votes/vote03.png); width:100px; height:13px;">
        <div style="float:left; background-image:url({page:path}symbols/votes/vote01.png); width: 1%; height:13px;" id="pass_secure"></div>
      </div>
      <div style="clear:both">
        {clip:pw_sec}
      </div>
    </td>
  </tr>
  {stop:simple}
  {if:convert}
  <tr>
    <td class="leftc">{icon:password} {lang:password}</td>
    <td class="leftb">{lang:auto_pass}
      <input type="hidden" name="users_pwd" value="{data:users_pwd}" />
      <input type="hidden" name="password" value="{hidden:password}" />
      <input type="hidden" name="conv_joinus" value="{hidden:conv}" />
      <input type="hidden" name="users_age" value="{data:users_age}" />
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:personal} {lang:prename}</td>
    <td class="leftb"><input type="text" name="users_name" value="{data:users_name}" maxlength="80" size="50" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:personal} {lang:surname}</td>
    <td class="leftb"><input type="text" name="users_surname" value="{data:users_surname}" maxlength="80" size="50" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:starthere} {lang:place}</td>
    <td class="leftb"><input type="text" name="users_place" value="{data:users_place}" maxlength="40" size="40" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:licq} {lang:icq}</td>
    <td class="leftb" colspan="2"><input type="text" name="users_icq" value="{data:users_icq}" maxlength="12" size="12" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:jabber_protocol} {lang:jabber}</td>
    <td class="leftb" colspan="2">{lang:jabber_info}<br /><input type="text" name="users_jabber" value="{data:users_jabber}" maxlength="40" size="40" /></td>
  </tr>
  {stop:convert}
  <tr>
    <td class="leftc">{icon:configure} {lang:extended}</td>
    <td class="leftb"><input type="checkbox" name="send_mail" value="1" /> {lang:send_mail}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
      <input type="hidden" name="country" value="{hidden:flag}" />
      <input type="submit" name="submit" value="{lang:create}" />
          </td>
  </tr>
</table>
</form>