<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb">{lang:addaccount}</td>
 </tr>
 <tr>
  <td class="leftb">{table:body}</td>
 </tr>{if:ready}
 <tr>
  <td class="centerb">{account:continue}</td>
 </tr>{stop:ready}
</table>

{if:form}
<br />
<form method="post" name="account_create" action="{url:cash_account}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="leftb">{lang:owner} * </td>
  <td class="leftc"><input type="text" name="owner" size="40" maxlength="40"  value="{account:account_owner}"/></td>
 </tr>
 <tr>
  <td class="leftb">{lang:number} * </td>
  <td class="leftc"><input type="text" name="number" size="15" maxlength="15"  value="{account:account_number}"/></td>
 </tr>
 <tr>
  <td class="leftb">{lang:bcn} * </td>
  <td class="leftc"><input type="text" name="bcn" size="15" maxlength="15"  value="{account:account_bcn}"/></td>
 </tr>  
 <tr>
  <td class="leftb">{lang:bank} * </td>
  <td class="leftc"><input type="text" name="bank" size="40" maxlength="40"  value="{account:account_bank}"/></td>
 </tr>
 <tr>
  <td class="headb" colspan="2">{lang:optional}</td>
 </tr>
 <tr>
  <td class="leftb">{lang:iban}</td>
  <td class="leftc"><input type="text" name="iban" size="25" maxlength="25"  value="{account:account_iban}"/></td>
 </tr> 
 <tr>
  <td class="leftb">{lang:bic}</td>
  <td class="leftc"><input type="text" name="bic" size="25" maxlength="25"  value="{account:account_bic}"/></td>
 </tr>
  
 <tr>
  <td class="leftb">{icon:ksysguard} {lang:options}</td>
  <td class="leftc">{if:id}<input type="hidden" name="id" value="{id:account_id}" />{stop:id}
    <input type="submit" name="submit" value="{lang:edit}" />
    <input type="reset" name="reset" value="{lang:reset}" />
   </td>
 </tr>
</table>
</form>
{stop:form}
