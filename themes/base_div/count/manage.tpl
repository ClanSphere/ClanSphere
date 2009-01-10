<div class="container" style="width:{page:width}">
    <div class="headb">{lang:mod} - {lang:manage}</div>
    <div class="headc clearfix">
        <div class="leftb fl"><a href="{url:count_empty}">{icon:edidivelete} {lang:empty}</a></div>
        <div class="rightb fr">{head:counter_pages}</div>
        <div class="centerb">{icon:contents} {lang:total}: {head:counter_count}</div>
    </div>
</div>
<br />
{head:message}
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
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