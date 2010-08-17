<br />
<form method="post" id="{comments:mod}_com_create" action="{url:create}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="leftc" colspan="2"><input type="submit" name="advanced" value="{lang:adv_com}" /></td>
  </tr>
  {if:guest}
  <tr>
    <td class="leftc">{icon:personal} {lang:guestnick} *</td>
    <td class="leftb"><input type="text" name="comments_guestnick" value="" maxlength="40" size="40" /></td>
  </tr>
  {stop:guest}
  <tr>
    <td class="leftc" style="width: 115px;">{icon:kopete} {lang:comment} *<br />
      <br />
      {comments:smileys}
    </td>
    <td class="leftb">
      {comments:abcode}
      <textarea class="rte_abcode" name="comments_text" cols="50" rows="8" id="comments_text"></textarea>
    </td>
  </tr>
  {if:captcha}
  <tr>
    <td class="leftc">{icon:lockoverlay} {lang:security_code} *</td>
    <td class="leftb">
      {captcha:img}
      <input type="text" name="captcha" value="" size="8" maxlength="8" />
    </td>
  </tr>
  {stop:captcha}
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
      <input type="hidden" name="fid" value="{comments:fid}" />
      <input type="submit" name="submit" value="{lang:create}" />
      <input type="submit" name="preview" value="{lang:preview}" />
          </td>
  </tr>
</table>
</form>