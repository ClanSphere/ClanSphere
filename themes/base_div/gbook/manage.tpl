<form method="post" name="gbook_create" action="{url:gbook_manage}">
<div class="container" style="width:{page:width}">
  <div class="headb">{head:mod} - {head:action}</div>
  <div class="headc clearfix">
	<div class="leftb fl">{icon:editpaste} {head:gbook_entry}</div>
	<div class="rightb fr">{head:pages}</div>
	<div class="centerb">{icon:contents} {head:all} {head:gbook_count}</div>
  </div>
  <div class="leftb">
		{icon:editpaste} {head:users_gb} 
		<input type="text" name="user_gb" value="{head:user_gb}" maxlength="200" size="20"  />
		<input type="submit" name="submit" value="{lang:submit}" />
  </div>
</div>
</form>
<br />
{lang:getmsg}
{head:message}

<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
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
    <td class="centerc">{gbook:edit} {gbook:remove} {gbook:ip}</td>
  </tr>
  {stop:gbook}
</table>
