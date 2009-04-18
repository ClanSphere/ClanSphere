<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:remove}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:del_rly}</td>
  </tr>
  <tr>
    <td class="centerc">
      <form method="post" id="cups_remove" action="{url:cups_remove}">
        <input type="hidden" name="id" value="{cup:id}" />
        <input type="submit" name="submit" value="{lang:confirm}" class="form" />
        <input type="submit" name="cancel" value="{lang:cancel}" class="form" />
       </form>
    </td>
  </tr>
</table>