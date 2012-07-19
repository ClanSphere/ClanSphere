<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:remove}</td>
  </tr>
  <tr>
    <td class="leftb">{head:body}</td>
  </tr>
</table>
<br />

<form method="post" id="gbook_remove" action="{url:gbook_remove}">
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="centerb">
      <input type="hidden" name="from" value="{hidden:from}" />
      <input type="hidden" name="id" value="{hidden:id}" />
      <input type="submit" name="submit" value="{lang:confirm}" />
      <input type="submit" name="cancel" value="{lang:cancel}" />        
    </td>
  </tr>
</table>
</form>