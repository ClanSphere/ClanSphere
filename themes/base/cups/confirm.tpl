<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:confirm}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:really_confirm}</td>
  </tr>
  <tr>
    <td class="centerb">
     <form method="post" id="accept_submit" action="{url:cups_matchedit}">
      <input type="hidden" name="cupmatches_id" value="{match:id}" />
      <input type="hidden" name="squad" value="{match:squadnr}" />
      <input type="submit" name="accept_submit" value="{lang:confirm}" />
     </form>
    </td>
  </tr>
</table>