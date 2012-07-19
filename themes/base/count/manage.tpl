<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
<tr><td class="headb" colspan="3">
{lang:mod_name} - {lang:manage}
</td></tr>
<tr><td class="leftb">
{icon:editdelete} <a href="{url:count_empty}">{lang:empty}</a></td>
<td class="leftb">
{icon:contents} {lang:total}: {head:counter_count}</td>
<td class="rightb">
{head:counter_pages}
</td></tr>
</table>
<br />
{head:message}

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="centerb">{icon:1day} <a href="{url:count_stats}">{lang:mod_stats}</a></td>
    <td class="centerb">{icon:5days} <a href="{url:count_statsyear}">{lang:yearoverview}</a></td>
    <td class="centerb">{icon:7days} <a href="{url:count_statsall}">{lang:alloverview}</a></td>
  </tr>
</table>
<br />

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