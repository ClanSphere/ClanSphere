<div style="width:{page:width}; text-align:center; margin: auto;">
  <div style="float: left; width: 48%;">
    <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:100%">
      <tr>
        <td class="headb">{icon:xchat}{lang:on_buddies}</td>
      </tr>
      {loop:buddys_on}
      <tr>
        <td class="leftb"><div style="float: left;">
		  <img src="symbols/countries/{buddys_on:users_country}.png" width="16" height="11" alt="" />
        <a href="{url:users_view:id={buddys_on:buddys_user}}">{buddys_on:users_nick}</a> </div>
          <div style="float: right;"><a href="{url:messages_create:to={buddys_on:users_nick}}">{icon:mail_send}</a></div></td>
      </tr>
      {stop:buddys_on}
    </table>
  </div>
  <div style="float: right; width: 48%;">
    <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:100%">
      <tr>
        <td class="headb">{icon:xchat}{lang:off_buddies}</td>
      </tr>
      {loop:buddys_off}
      <tr>
        <td class="leftb"><div style="float: left;">
		  <img src="symbols/countries/{buddys_off:users_country}.png" width="16" height="11" alt="" />
        <a href="{url:users_view:id={buddys_off:buddys_user}}">{buddys_off:users_nick}</a> </div>
          <div style="float: right;"><a href="{url:messages_create:to={buddys_off:users_nick}}">{icon:mail_send}</a></div></td>
      </tr>
      {stop:buddys_off}
    </table>
  </div>
</div>
