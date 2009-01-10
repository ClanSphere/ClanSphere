<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
	<td class="headb" colspan="3">
		{head:mod} - {head:action}
	</td>
  </tr>
  <tr>
	<td class="leftb">
		{icon:editpaste} {head:gbook_entry}
	</td>
	<td class="leftb">
		{icon:contents} {head:all} {head:gbook_count}
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
    <td class="headb">{lang:nick}</td>
    <td class="headb">{sort:email} {lang:email}</td>
    <td class="headb">{sort:time} {lang:time}</td>
    <td class="headb">{lang:options}</td>
  </tr>
  {loop:gbook}
  <tr>
    <td class="leftc">{gbook:nick}</td>
    <td class="leftc">{gbook:email}</td>
    <td class="leftc">{gbook:time}</td>
    <td class="centerc">{gbook:edit} {gbook:remove}</td>
  </tr>
  {stop:gbook}
</table>
