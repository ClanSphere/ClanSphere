<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:create}</td>
  </tr>
  <tr>
    <td class="leftb">{head:body}</td>
  </tr>
</table>
<br />

<form method="post" id="newsletter_create" action="{url:newsletter_create}">
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="leftc">{icon:kate} {lang:subject} *</td>
    <td class="leftb"><input type="text" name="newsletter_subject" value="{nl:newsletter_subject}" maxlength="50" size="30" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:personal} {lang:to} *</td>
    <td class="leftb">
      <select name="newsletter_to">
        {nl:to_dropdown}
      </select>
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:kedit} {lang:text} *</td>
    <td class="leftb"><textarea class="rte_abcode" name="newsletter_text" cols="50" rows="30" id="newsletter_text">{nl:newsletter_text}</textarea></td>
  </tr>
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
      <input type="submit" name="submit" value="{lang:create}" />
    </td>
  </tr>
</table>
</form>