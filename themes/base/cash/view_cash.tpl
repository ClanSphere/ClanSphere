<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb" colspan="2">{lang:mod_name} - {lang:akt_users_month}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:user_cash_month}</td>
    <td class="centerb">{icon:business}<a href="{url:cash_manage}">{lang:back}</a></td>
  </tr>
</table>
<br />

<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{lang:nick}</td>  
    <td class="headb">{lang:date}</td>
    <td class="headb">{lang:for}</td>
    <td class="headb">{lang:money}</td>    
  </tr>
  {loop:cash}
  <tr>
    <td class="leftb">{cash:user}</td>
    <td class="leftb">{cash:date}</td>
    <td class="leftb"><a href="{url:cash_view:id={cash:cash_id}}">{cash:cash_text}</a></td>
    <td class="leftb">{cash:cash_money} {op:currency}</td>    
  </tr>
  {stop:cash}
</table>
<br />