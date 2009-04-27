<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">Turniere - Starten</td>
  </tr>
  <tr>
    <td class="leftc">{lang:reduce}</td>
  </tr>
  <tr>
    <td class="centerb">
      <form method="post" id="cupsreduce" action="{url:cups_start}">
        <input type="hidden" name="id" value="{var:cups_id}" />
        <input type="hidden" name="teams" value="{var:teams}" />
        <input type="submit" name="reduce" value="{lang:confirm}" />
      </form>
    </td>
  </tr>
</table>
