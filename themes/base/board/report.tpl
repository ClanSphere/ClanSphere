<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:board} - {lang:report}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:body}</td>
  </tr>
</table>
<br />
<form method="post" id="board_report" action="{action:form}">
  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
    <tr>
      <td class="leftc">{icon:special_paste} {lang:report} *</td>
      <td class="leftb"><textarea class="rte_abcode" name="report" cols="50" rows="12" id="report"></textarea>
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:ksysguard} {lang:options}</td>
      <td class="leftb"><input type="hidden" name="tid" value="{report:tid}" />
        <input type="hidden" name="cid" value="{report:cid}" />
        <input type="submit" name="submit" value="{lang:create}" />
              </td>
    </tr>
  </table>
</form>
