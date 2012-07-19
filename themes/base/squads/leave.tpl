<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{head:mod} - {lang:head_leave}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:body_leave}</td>
  </tr>
</table>
<br />

<form method="post" id="squads_leave" action="{url:squads_leave}">
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="leftc">{icon:yast_group_add} {lang:label} *</td>
    <td class="leftb">
      {squads:squad_sel}
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
      <input type="submit" name="agree" value="{lang:confirm}" />
      <input type="submit" name="cancel" value="{lang:cancel}" />
    </td>
  </tr>
</table>
</form>
