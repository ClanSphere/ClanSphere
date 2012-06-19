<div class="leftb">{alert:query}
{alert:session_exists}</div>
{if:session_exists}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td width="40%" class="headb">{lang:last_active}</td>
    <td width="40%" class="headb">{lang:last_IP}</td>
    <td width="20%" class="headb">{lang:remove}</td>
  </tr>
</table>
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
  	<td class="headb" colspan="4">{lang:saved_logins}</td>
  </tr>
  {loop:sessions}
  <tr style="{sessions:color}">
    <td width="40%" class="leftb">{sessions:time}</td>
    <td width="40%" class="leftb">{sessions:ip}</td>
    <td width="20%" class="leftb">
    	<form method="post">
        	<input name="session_id" type="hidden" value="{sessions:id}" />
            <input type="submit" value="Remove" />
        </form>
    </td>
  </tr>
  {stop:sessions}
</table>
<br />
{stop:session_exists}
<div class="leftb" style="text-align: center;">{lang:inactivity}<br />
<span style="color: #c16a6a">{lang:red}</span> {lang:this_session}</div>