<div class="container" style="width:{page:width}">
    <div class="headb">
    {lang:board} - {lang:reportlist}
    </div>
    <div class="headc">
        <div class="leftb fl">
        {lang:all} {head:boardreport_count}
        </div>
        <div class="rightb fr">
        {head:pages}
        </div>
    </div>
</div>
<br />
{lang:getmsg}
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
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