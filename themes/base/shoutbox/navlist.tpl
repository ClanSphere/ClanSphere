<div style="overflow:auto" id="cs_shoutbox_navlist2">
  {loop:shoutbox}
  {shoutbox:shoutbox_name}: {shoutbox:shoutbox_text}<br />
  <hr style="width:100%" noshade="noshade" />
  {stop:shoutbox}
</div>
<br />

<form method="post" name="shout_navlist" action="{form:url}">
<input type="text" name="sh_nick" value="{form:nick}" onfocus="if(this.value=='Nick') this.value=''" onblur="if(this.value=='')this.value='Nick'" maxlength="40" size="15"  /><br />
<textarea name="sh_text" cols="15" rows="2" ></textarea><br />
{form:captcha}<br />
<input type="submit" name="submit" value="{lang:save}"  />
<input type="hidden" name="uri" value="{form:uri}" />
</form>
<br /><br />
<a href="{url:archieve}">{lang:archieve}</a>