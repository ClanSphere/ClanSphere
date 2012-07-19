<form method="post" action="{form:register}">
  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
    <tr>
      <td class="leftc" style="width: 150px;"> {icon:locale} {lang:lang}</td>
      <td class="leftb"><select name="lang">
                   
{register:languages}        
        
        </select>
      </td>
    </tr>
    <tr>
      <td class="leftc"> {icon:personal} {lang:nick} *</td>
      <td class="leftb"><input type="text" name="nick" value="" maxlength="40" size="40" />
      </td>
    </tr>
        <tr>
      <td class="leftc"> {icon:password} {lang:password} *</td>
      <td class="leftb"><input type="password" name="password" value="" maxlength="30" size="30"  onkeydown="javascript:passwordcheck(this.value);" onkeyup="javascript:passwordcheck(this.value);" autocomplete="off" />
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
      <td class="leftc"> {icon:mail_generic} {lang:email} *</td>
      <td class="leftb"><input type="text" name="email" value="" maxlength="40" size="40" />
      </td>
    </tr>
    <tr>
      <td class="leftc"> {icon:configure} {lang:extended}</td>
      <td class="leftb">
      {if:reg_mail}<input type="checkbox" name="send_mail" value="1" {checked:email} />{lang:send_mail}<br />{stop:reg_mail}
      <input type="checkbox" name="newsletter" value="1" {checked:newsletter} />{lang:newsletter_reg}
    </td>
    </tr>
    {if:captcha}
    <tr>
      <td class="leftc">{icon:lockoverlay} {lang:security_code} *</td>
      <td class="leftb">
        {captcha:img}<br />
        <input type="text" name="captcha" value="" maxlength="8" size="8" />
      </td>
    </tr>
    {stop:captcha}
    <tr>
      <td class="leftc"> {icon:ksysguard} {lang:options}</td>
      <td class="leftb"><input type="submit" name="submit" value="{lang:signup}" />
              </td>
    </tr>
  </table>
</form>
