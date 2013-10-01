<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb" colspan="2">{lang:mod_name} - {lang:head_center}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:contents} {lang:total}: {head:count}</td>
    <td class="rightb">{head:pages}</td>
  </tr>
</table>
<br />

<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  {if:no_kt}
  <tr>
    <td class="centerb">{lang:nonumber}</td>
  </tr>
  {stop:no_kt}
  {if:kt}
  <tr>
    <td class="headb" colspan="2">{lang:kt}</td>
  </tr>
  
  <tr>
    <td class="leftb" style="width:150px">{lang:owner}</td>
    <td class="leftc">{kt:account_owner}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:number}</td>
    <td class="leftc">{kt:account_number}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:bcn}</td>
    <td class="leftc">{kt:account_bcn}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:bank}</td>
    <td class="leftc">{kt:account_bank}</td>
  </tr>
  {if:iban}
  <tr>
    <td class="leftb">{lang:iban}</td>
    <td class="leftc">{kt:account_iban}</td>
  </tr>
  {stop:iban}
  {if:bic}
  <tr>
    <td class="leftb">{lang:bic}</td>
    <td class="leftc">{kt:account_bic}</td>
  </tr>
  {stop:bic}
  {stop:kt}
</table>
<br />

<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb" colspan="3">{lang:overview}</td>
  </tr>
  <tr>
    <td class="leftb" style="width:20px"><img src="{page:path}symbols/clansphere/green.gif" alt="" /></td>
    <td class="rightb">{lang:in}</td>
    <td class="leftb">{ov:in} {op:currency}</td>
  </tr>
  <tr>
    <td class="leftb"><img src="{page:path}symbols/clansphere/red.gif" alt="" /></td>
    <td class="rightb">{lang:out}</td>
    <td class="leftb">{ov:out} {op:currency}</td>
  </tr>
  <tr>
    <td class="leftc"><img src="{page:path}symbols/clansphere/grey.gif" alt="" /></td>
    <td class="rightc" style="width:20px">{lang:now}</td>
    <td class="leftc">{ov:now} {op:currency}</td>
  </tr>
</table>
<br />

<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb" colspan="4">{lang:mycash}</td>
  </tr>
  <tr>
    <td class="headb" style="width:20px"></td>
    <td class="headb" style="width:25%">{sort:date} {lang:date}</td>
    <td class="headb">{lang:for}</td>
    <td class="headb" style="width:20%">{sort:money} {lang:money}</td>
  </tr>
  {loop:in}
  <tr>
    <td class="centerc">{in:in_out}</td>
    <td class="leftc">{in:date}</td>
    <td class="leftc"><a href="{url:cash_view:id={in:id}}">{in:for}</a></td>
    <td class="leftc">{in:money} {op:currency}</td>
  </tr>
  {stop:in}
</table>
<br />

<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb" colspan="4">{lang:out}</td>
  </tr>
  <tr>
    <td class="headb" style="width:20px"></td>
    <td class="headb" style="width:25%">{sort2:date} {lang:date}</td>
    <td class="headb">{lang:for}</td>
    <td class="headb" style="width:20%">{sort2:money} {lang:money}</td>
  </tr>
  {loop:out}
  <tr>
    <td class="centerc">{out:in_out}</td>
    <td class="leftc">{out:date}</td>
    <td class="leftc"><a href="{url:cash_view:id={out:id}}">{out:for}</a></td>
    <td class="leftc">{out:money} {op:currency}</td>
  </tr>
  {stop:out}
</table>