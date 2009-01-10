<form method="post" name="gbook_create" action="{url:gbook_manage}">
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
  <tr>
	<td class="leftb" colspan="3">
		{icon:editpaste} {head:users_gb} 
		<input type="text" name="user_gb" value="{head:user_gb}" maxlength="200" size="20"  />
		<input type="submit" name="submit" value="{lang:submit}" />
	</td>
  </tr>
</table>
</form>
<br />
{lang:getmsg}
{head:message}

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
    <td class="centerc">{gbook:lock} {gbook:edit} {gbook:remove} {gbook:ip}</td>
  </tr>
  {stop:gbook}
</table>
