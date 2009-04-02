<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
<tr>
  <td class="headb" colspan="3">{lang:mod_stats}</td>
</tr>
<tr>
  <td class="leftb">{lang:all}{head:all}</td>
  <td class="leftb">{lang:month}{head:month}</td>
  <td class="leftb">{lang:today}{head:today}</td>
</tr>
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
<tr>
  <td class="headb" colspan="5" rowspan="1">{lang:trend}</td>
</tr>
<tr>
  <td class="leftc">{lang:yearmon}</td>
  <td class="leftc">{lang:average}</td>
  <td class="leftc">{lang:count}</td>
  <td class="leftc" colspan="2">{lang:barp}</td>
</tr>
{loop:count}
<tr>
  <td class="leftb">{count:year-mon}</td>
  <td class="rightb">{count:day}</td>
  <td class="rightb">{count:count}</td>
  <td class="leftb">{count:barp_start}{count:size}{count:barp_end}</td>
  <td class="leftb">{count:diff}</td>
</tr>
{stop:count}
</table>