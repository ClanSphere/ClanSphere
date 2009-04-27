<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:join}</td>
  </tr>
  <tr>
    <td class="leftc">{lang:really}</td>
  </tr>
  <tr>
    <td class="centerb">
      <form method="post" id="cupsjoin" action="{url:cups_join}">
        <input type="hidden" name="cups_id" value="{cup:id}" />
        <input type="hidden" name="system" value="users" />
        <input type="submit" name="submit" value="{lang:confirm}" />
       </form>
    </td>
  </tr>
</table>