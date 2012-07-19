<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
<tr>
<td class="headb" colspan="2">
{lang:board} - {lang:reportlist}
</td>
</tr>
<tr>
<td class="leftb">
{lang:all} {head:boardreport_count}
</td>
<td class="rightb">
{head:pages}
</td>
</tr>
</table>
<br />
{lang:getmsg}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
<tr>
<td class="headb">
{sort:boardreport_time} {lang:date}
</td>
<td class="headb">
{sort:boardreport_done} {lang:done}
<td class="headb">
{sort:threads_headline} {lang:thread}
</td>
</tr>
{loop:boardreport}
<tr>
<td class="leftc">
{boardreport:boardreport_time}
</td>
<td class="leftc">
{boardreport:boardreport_done}
<td class="leftc">
{boardreport:threads_headline}
</td>
</tr>
{stop:boardreport}
</table>