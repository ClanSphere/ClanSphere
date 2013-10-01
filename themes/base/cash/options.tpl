<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:options}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:body_info}</td>
  </tr>
</table>
<br />

<form method="post" id="cash_options" action="{url:cash_options}">
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb" colspan="2">{lang:options}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:money} {lang:currency}</td>
    <td class="leftb"><input type="text" name="currency" value="{op:currency}" maxlength="40" size="20" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:money} {lang:month_out}</td>
    <td class="leftb"><input type="text" name="month_out" value="{op:month_out}" maxlength="10" size="7" /> {op:currency}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
      <input type="submit" name="submit" value="{lang:edit}" />
    </td>
  </tr>
</table>
</form>