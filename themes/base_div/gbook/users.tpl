<div class="container" style="width:{page:width}">
	<div class="headb">{head:mod} - {head:action}</div>
	<div class="leftc">{head:addons}</div>
</div>
<br />
<div class="container" style="width:{page:width}">
  <div class="headc clearfix">
    <div class="leftb fl">{body:users}</div>
    <div class="leftb fr">{body:pages}</div>
  </div>
  <div class="headc clearfix">
    <div class="leftb fl">{icon:editpaste} {body:gbook_entry}</div>
    <div class="leftb fr">{icon:contents} {body:all} {body:gbook_count}</div>
  </div>
</div>
<br />
{lang:getmsg}
{loop:gbook}
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
  <tr>
    <td class="bottom" style="width:160px"># {gbook:entry_count} <br />
		{icon:personal} {gbook:users_nick} <br />
		{gbook:icon_town} {gbook:town} <br />
		{gbook:icon_mail} {gbook:icon_icq} {gbook:icon_msn} {gbook:icon_skype} {gbook:icon_url}<br />
	</td>
    <td class="leftb">{gbook:text}</td>
  </tr>
  <tr>
    <td class="bottom">{gbook:time}</td>
    <td class="leftb"><div style="float:right">{gbook:icon_edit} {gbook:icon_remove} {gbook:icon_ip}</div></td>
  </tr>
</table>
<br />
{stop:gbook}