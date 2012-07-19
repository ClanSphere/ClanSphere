<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
<tr>
<td class="headb" colspan="2">
{lang:wizard} - {lang:roots}
</td>
</tr>
<tr>
<td class="leftb" style="width:50%">
{head:parts_done}
</td>
<td class="leftb">
{head:next_task}
</td>
</tr>
</table>
<br />
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
<tr>
<td class="headb">
{lang:task}
</td>
<td class="headb" style="width:100px">
{lang:done}
</td>
</tr>
{loop:wizard}
<tr>
<td class="left{wizard:class}">
<span style="float:left; padding-right:8px">{wizard:icon}</span>
{wizard:link} {wizard:next}
<hr style="width:100%" />
{wizard:text}
</td>
<td class="center{wizard:class}" style="vertical-align:middle">
{wizard:done}
</td>
</tr>
{stop:wizard}
</table>