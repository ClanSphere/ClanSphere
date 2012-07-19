<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:head_delabo}</td>
  </tr>
  {if:account}
  <tr>
    <td class="leftb">{lang:body}</td>
  </tr>
  <tr>
    <td class="centerc"><form method="post" id="abo_remove" action="{action:form}">
        <input type="hidden" name="id" value="{abo:id}" />
        <input type="submit" name="agree" value="{lang:confirm}" />
        <input type="submit" name="cancel" value="{lang:cancel}" />
      </form></td>
  </tr>
  {stop:account}
  {if:not_account} 
  <tr>
    <td class="centerb">{lang:error_header}</td>
  </tr>
  {stop:not_account}
</table>
