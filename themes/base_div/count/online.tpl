<div class="container" style="width:{page:width}">
    <div class="headb">{lang:head}</div>
    <div class="headc clearfix">
        <div class="leftb fl">{lang:text1}&nbsp;<b>{online:online}</b>&nbsp;{lang:text2}</div>
        <div class="rightb fr">{head:pages}</a></div>
    </div>
</div>
<br />

<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
<tr><td class="headb">
{lang:last}</td>
<td class="headb" colspan="2">
{lang:now}
</td></tr>
 
{loop:count}
<tr><td class="leftc">
{count:count_time}</td>
<td class="leftc">
{count:count_location}
</td></tr>
{stop:count}
</table>