<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
<tr><td class="headb" colspan="3">
{lang:mod_stats}
</td></tr>
<tr><td class="leftc">
{lang:all}{head:all}</td>
<td class="leftc">
{lang:month}{head:month}</td>
<td class="leftc">
{lang:today}{head:today}
</td></tr>
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
<tr><td class="headb" colspan="4" rowspan="1">
{lang:trend}
</td></tr>
<tr><td class="leftc">
{lang:yearmon}</td>
<td class="leftc">
{lang:average}</td>
<td class="leftc">
{lang:count}</td>
<td class="leftc" style="width:50%">
{lang:barp}
</td></tr>
{loop:count}
<tr><td class="leftb">
{count:year-mon}</td>
<td class="rightb">
{count:day}</td>
<td class="rightb">
{count:count}</td>
<td class="leftb">
{barp:start}{count:size}{barp:end}
{count:diff}
</td></tr>
{stop:count}
</table>