<form method="post" id="board_listcat" action="{action:form}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="2">{pw:body}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:password} {lang:password}</td>
    <td class="leftb"><input type="password" name="sec_pw" value="" maxlength="30" size="30" autocomplete="off" />
      <input type="hidden" name="id" value="{pw:id}" />
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb"><input type="submit" name="submit" value="{lang:create}" />
</table>
</form>
