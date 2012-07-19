<form method="post" id="users_remove" action="{url:usersgallery_users_remove}">
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:remove}</td>
  </tr>
  <tr>
    <td class="leftb">{head:body}</td>
  </tr>
</table>
<br />

<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="centerb">{this:img}</td>
  </tr>
</table>
<br />

<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="centerc">
      <input type="hidden" name="id" value="{hidden:id}" />
      <input type="submit" name="agree" value="{lang:confirm}" />
      <input type="submit" name="cancel" value="{lang:cancel}" />
    </td>
  </tr>
</table>
</form>