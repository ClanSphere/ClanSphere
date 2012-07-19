<div style="overflow:auto" id="cs_shoutbox_navlist2">
  {loop:shoutbox}
  {shoutbox:shoutbox_name}: {shoutbox:shoutbox_text}<br />
  <hr style="width:100%" />
  {stop:shoutbox}
</div>
<br />

{if:form}
<form method="post" id="shout_navlist" action="{form:url}">
<fieldset style="border: 0; padding: 0">
  <input type="text" name="sh_nick" value="{form:nick}" onfocus="if(this.value=='Nick') this.value=''" onblur="if(this.value=='')this.value='Nick'" maxlength="40" size="15" /><br />
  <textarea name="sh_text" cols="15" rows="2"></textarea><br />
  {if:captcha}
  {captcha:img}<br />
  <input type="text" name="captcha" value="" maxlength="3" size="3" />
  {stop:captcha}<br />
<input type="submit" name="submit" value="{lang:save}" />
<input type="hidden" name="uri" value="{form:uri}" />
</fieldset>
</form>
<br />{stop:form}

<a href="{url:archieve}">{lang:archieve}</a>