<div class="container" style="width:{page:width}">
    <div class="headb">{lang:visitors} - {lang:mod_stats}</div>
    <div class="headc clearfix">
        <div class="leftc fl">{lang:all}{head:all}</div>
        <div class="rightc fr">{lang:month}{head:month}</div>
        <div class="centerc">{lang:today}{head:today}</div>
    </div>
</div>
<br />

<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
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