<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:remove}</td>
  </tr>
  <tr>
    <td class="centerb">{maps:message}</td>
  </tr>
  <tr>
    <td class="centerb">
      <form method="post" id="maps_remove" action="{maps:action}">
        <input type="hidden" name="id" value="{maps:maps_id}" />
        <input type="submit" name="agree" value="{lang:confirm}" />
        <input type="submit" name="cancel" value="{lang:cancel}" />
      </form>
    </td>
  </tr>
</table>