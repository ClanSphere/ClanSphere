<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
<tr>
<td class="headb">
{lang:mod_name} - {lang:summary}
</td>
</tr>
<tr>
<td class="leftc">
{lang:summary_info}
</td>
</tr>
</table>
{loop:days}
<br />
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
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