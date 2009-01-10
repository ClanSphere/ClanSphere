<div class="container" style="width:{page:width}">
<div class="headb">
{lang:wizard} - {lang:roots}
</div>
<div class="headc clearfix">
<div class="leftb fl" style="width:50%">
{head:parts_done}
</div>
<div class="leftb fr">
{head:next_task}
</div>
</div>
</div>
<br />
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
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
<hr noshade="noshade" style="width:100%" />
{wizard:text}
</td>
<td class="center{wizard:class}" style="vertical-align:middle">
{wizard:done}
</td>
</tr>
{stop:wizard}
</table>