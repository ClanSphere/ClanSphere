<div class="container" style="width:{page:width}">
    <div class="headb">{lang:board} - {lang:report}</div>
    <div class="leftb">{lang:body}</div>
</div>
<br />
<form method="post" name="board_report" action="{action:form}">
  <table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
    <tr>
      <td class="leftc">{icon:special_paste} {lang:report} *</td>
      <td class="leftb"><textarea name="report" cols="50" rows="12" id="report" ></textarea>
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:ksysguard} {lang:options}</td>
      <td class="leftb"><input type="hidden" name="tid" value="{report:tid}" />
        <input type="hidden" name="cid" value="{report:cid}" />
        <input type="submit" name="submit" value="{lang:create}" />
        <input type="reset" name="reset" value="{lang:reset}" />
      </td>
    </tr>
  </table>
</form>
