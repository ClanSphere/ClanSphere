<div class="container" style="width:{page:width}">
    <div class="headb">{lang:mod} - {lang:head_delabo}</div>
  {if:account}
    <div class="leftb">{lang:body}</div>
    <div class="centerc"><form method="post" name="abo_remove" action="{action:form}">
        <input type="hidden" name="id" value="{abo:id}" />
        <input type="submit" name="agree" value="{lang:confirm}" />
        <input type="submit" name="cancel" value="{lang:cancel}" />
      </form></div>
  {stop:account}
  {if:not_account} 
    <div class="centerb">{lang:error_header}</div>
  {stop:not_account}
</div>
