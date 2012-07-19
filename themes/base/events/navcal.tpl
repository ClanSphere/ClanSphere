<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="calhead" style="width:9%">{lang:calweek}</td>
    <td class="calhead" style="width:13%">{lang:Mon}</td>
    <td class="calhead" style="width:13%">{lang:Tue}</td>
    <td class="calhead" style="width:13%">{lang:Wed}</td>
    <td class="calhead" style="width:13%">{lang:Thu}</td>
    <td class="calhead" style="width:13%">{lang:Fri}</td>
    <td class="calhead" style="width:13%">{lang:Sat}</td>
    <td class="calhead" style="width:13%">{lang:Sun}</td>
  </tr>
  <tr>
    <td class="calweek">{cal1:week}</td>
    {if:colspan}<td colspan="{cal1:colspan}">&nbsp;</td>{stop:colspan}
  {loop:cal}{if:row}</tr>
  <tr>
    <td class="calweek">{cal:week}</td>{stop:row}
    <td class="{cal:css}">{cal:out}</td>{stop:cal}
    {if:colspan2}<td colspan="{cal1:colspan2}">&nbsp;</td>{stop:colspan2}
  </tr>
  <tr>
    <td class="calhead" colspan="8">{cal1:bef_month} [ {cal1:now_month} ] {cal1:nxt_month}</td>
  </tr>
</table>