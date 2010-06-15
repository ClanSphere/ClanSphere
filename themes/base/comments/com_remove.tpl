<form method="post" id="{com:form_name}" action="{com:form_url}">
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{head:mod} - {lang:head_com_remove}</td>
  </tr>
  <tr>
    <td class="leftb">{head:body_com_remove}</td>
  </tr>
  <tr>
    <td class="centerc">
      <input type="hidden" name="id" value="{com:id}" />
      <input type="submit" name="agree" value="{lang:confirm}" />
      <input type="submit" name="cancel" value="{lang:cancel}" />
    </td>
  </tr>
</table>
</form>