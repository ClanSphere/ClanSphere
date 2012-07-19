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
    <td class="centerc">
      <form method="post" id="servers_remove" action="{url:servers_remove}">
        <input type="hidden" name="id" value="{servers:id}" />
        <input type="submit" name="agree" value="{lang:confirm}" />
        <input type="submit" name="cancel" value="{lang:cancel}" />
      </form>
    </td>
  </tr>
</table>