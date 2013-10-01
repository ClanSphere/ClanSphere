<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb" colspan="2">{lang:mod_name} - {lang:manage}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:contents} {lang:total}: {head:count}</td>
    <td class="rightb">{head:pages}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:business} <a href="{url:cash_manage}">{lang:overview}</a>
    <td class="leftb">{icon:editpaste} <a href="{url:cash_account}">{lang:kt}</a></td>    
  </tr>
</table>
<br />

{head:getmsg}

{if:all}
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb" colspan="3">{lang:mod_name} - {lang:overview}</td>
  </tr>
  <tr>
    <td class="leftb" style="width:20px">{icon:money}</td>
    <td class="rightb">{lang:month_out}</td>
    <td class="leftb">{ov:month_out} {op:currency}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:money}</td>
    <td class="rightb">{lang:user_money}</td>
    <td class="leftb">{ov:user_money} {op:currency}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:personal}</td>
    <td class="rightb">{lang:akt_users_month}</td>
    <td class="leftb"><a href="{url:cash_view_cash}">{ov:view_cash}</a></td>
  </tr>
  <tr>
    <td class="leftb"><img src="{page:path}symbols/clansphere/green.gif" alt="" /></td>
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
    <td class="rightc">{lang:now}</td>
    <td class="leftc">{ov:now} {op:currency}</td>
  </tr>
</table>
<br />
{stop:all}

{if:only_user}
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb" colspan="3">{lang:mod_name} - {lang:user}</td>
  </tr>
  <tr>
    <td class="leftb" style="width:20px"><img src="{page:path}symbols/clansphere/green.gif" alt="" /></td>
    <td class="rightb">{lang:payments_in}</td>
    <td class="leftb">{ov:in} {op:currency}</td>
  </tr>
  <tr>
    <td class="leftb"><img src="{page:path}symbols/clansphere/red.gif" alt="" /></td>
    <td class="rightb">{lang:out}</td>
    <td class="leftb">{ov:out} {op:currency}</td>
  </tr>
  <tr>
    <td class="leftc"><img src="{page:path}symbols/clansphere/grey.gif" alt="" /></td>
    <td class="rightc">{lang:now}</td>
    <td class="leftc">{ov:now} {op:currency}</td>
  </tr>
</table>
<br />
{stop:only_user}

<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{sort:nick} {lang:nick}</td>
    <td class="headb">{sort:date} {lang:date}</td>
    <td class="headb">{lang:for}</td>
    <td class="headb">{sort:money} {lang:money}</td>
    <td class="headb">{sort:in_out}</td>
    <td class="headb" colspan="2">{lang:options}</td>
  </tr>
  {loop:cash}
  <tr>
    <td class="leftc">{cash:users_link}</td>
    <td class="leftc">{cash:date}</td>
    <td class="leftc"><a href="{url:cash_view:id={cash:id}}">{cash:text}</a></td>
    <td class="leftc">{cash:money} {op:currency}</td>
    <td class="leftc">{cash:in_out}</td>
    <td class="leftc"><a href="{url:cash_edit:id={cash:id}}" title="{lang:edit}">{icon:edit}</a></td>
    <td class="leftc"><a href="{url:cash_remove:id={cash:id}}" title="{lang:remove}">{icon:editdelete}</a></td>
  </tr>
  {stop:cash}
</table>