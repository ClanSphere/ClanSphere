<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
<tr><td class="headb" colspan="3">
{lang:mod} - {lang:manage}
</td></tr>
<tr><td class="leftb">
<a href="{url:count_empty}">{icon:editdelete} {lang:empty}</a></td>
<td class="leftb">
{icon:contents} {lang:total}: {head:counter_count}</td>
<td class="rightb">
{head:counter_pages}
</td></tr>
</table>
<br />
{head:message}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
<tr><td class="headb">
{sort:count_id} {lang:id}</td>
<td class="headb">
{lang:ip}</td>
<td class="headb">
{lang:locate}</td>
<td class="headb">
{sort:count_time} {lang:date}
</td></tr>
 
{loop:count}
<tr>
	<td class="leftc">{count:count_id}</td>
  <td class="leftc">{count:count_ip}</td>
  <td class="leftc">{count:count_locate}</td>
  <td class="leftc">{count:count_time}</td>
</tr>
{stop:count}
</table>