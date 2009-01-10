<div class="container" style="width:{page:width}">
 <div class="headb">{lang:mod} - {lang:summary}</div>
 <div class="leftc">{lang:summary_info}</div>
</div>
{loop:days}
<br />
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
<tr>
<td class="headb" colspan="2">
{days:content}
</td>
</tr>
{loop:news}
<tr>
<td class="leftc" style="width:120px">
{news:news_time}
</td>
<td class="leftb">
{news:news_headline}
</td>
</tr>
{stop:news}
</table>
{stop:days}