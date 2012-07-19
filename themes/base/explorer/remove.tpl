<table class="forum" style="width: {page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{lang:explorer} - {lang:remove}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:really_delete}</td>
  </tr>
  <tr>
    <td class="centerb">
      <form method="post" id="upload_del" action="{url:explorer_remove}">
       <input type="hidden" name="file" value="{var:source}" />
       <input type="submit" name="submit" value="{lang:confirm}" />
       <input type="submit" name="cancel" value="{lang:cancel}" />
      </form>
    </td>
  </tr>
</table>