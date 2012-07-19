<div style="width:{page:width}; text-align:center; margin: auto;">
  <div style="float: left; width: 48%;">
    <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:100%">
      <tr>
        <td class="headb">{icon:xchat}{lang:on_buddies}</td>
      </tr>
      {loop:bon}
      <tr>
        <td class="leftc">
          <div style="float: left;">
            {bon:users_country}
            {bon:users_link}
          </div>
          <div style="float: right;"><a href="{url:messages_create:to={bon:users_nick}}">{icon:mail_send}</a></div></td>
      </tr>
      {stop:bon}
    </table>
  </div>
  <div style="float: right; width: 48%;">
    <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:100%">
      <tr>
        <td class="headb">{icon:xchat}{lang:off_buddies}</td>
      </tr>
      {loop:boff}
      <tr>
        <td class="leftc">
          <div style="float: left;">
            {boff:users_country}
            {boff:users_link}
          </div>
          <div style="float:right;"><a href="{url:messages_create:to={boff:users_nick}}">{icon:mail_send}</a></div></td>
      </tr>
      {stop:boff}
    </table>
  </div>
</div>
