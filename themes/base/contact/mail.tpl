<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:head_mail}</td>
  </tr>
  <tr>
    <td class="leftc">{lang:head}</td>
  </tr>
</table>
<br />

{if:form}
<form method="post" id="contact_mail" action="{url:contact_mail}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="leftc">{icon:personal} {lang:name} *</td>
    <td class="leftb"><input type="text" name="name" value="{mail:name}" maxlength="80" size="30" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:kdmconfig} {lang:firm}</td>
  <td class="leftb"><input type="text" name="firm" value="{mail:firm}" maxlength="80" size="40" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:mail_generic} {lang:email} *</td>
  <td class="leftb"><input type="text" name="email" value="{mail:email}" maxlength="40" size="40" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:licq} {lang:icq}</td>
  <td class="leftb"><input type="text" name="icq" value="{mail:icq}" maxlength="20" size="20" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:jabber_protocol} {lang:jabber}</td>
  <td class="leftb"><input type="text" name="jabber" value="{mail:jabber}" maxlength="40" size="40" /></td>
  </tr>  
  <tr>
    <td class="leftc">{icon:kfind} {lang:request} *</td>
  <td class="leftb">{mail:categories_id}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:kedit} {lang:subject} *</td>
  <td class="leftb"><input type="text" name="why" value="{mail:why}" maxlength="200" size="50" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:kate} {lang:text} *</td>
  <td class="leftb"><textarea class="rte_abcode" name="text" cols="50" rows="12" id="text">{mail:text}</textarea></td>
  </tr>
  {if:captcha}
  <tr>
    <td class="leftc">{icon:lockoverlay} {lang:security_code} *</td>
  <td class="leftb">{captcha:img}<input type="text" name="captcha" value="" maxlength="8" size="8" /></td>
  </tr>
  {stop:captcha}
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
  <td class="leftb">
    <input type="submit" name="submit" value="{lang:send}" />
      </td>
  </tr>
</table>
</form>
{stop:form}

{if:done}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="centerb"><a href="{page:path}">{lang:continue}</a></td>
  </tr>
</table>
{stop:done}