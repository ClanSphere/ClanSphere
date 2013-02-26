<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="3">{lang:person}</td>
  </tr>
  <tr>
    <td class="leftc" style="width:140px">{icon:personal} {lang:nick}</td>
    <td class="leftb">{users:nick} {if:buddies_active}<a href="{url:buddys_create:id={users:id}}" title="{lang:buddy_add}">{icon:xchat}</a>{stop:buddies_active} 
    <a href="{url:message_create}" title="{lang:message_send}">{icon:mail_send}</a>
    {if:old_nick}&nbsp;&nbsp;({lang:old_nick}: {users:old_nick}){stop:old_nick}
    </td>
    <td class="centerc" rowspan="9" style="width:160px"><br />
      {users:picture}
      {if:own_profile}
      <br /><br />
      <a href="{url:picture}">{lang:edit_picture}</a><br />
      <a href="{url:profile}">{lang:edit_profile}</a>
      {stop:own_profile}
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:personal} {lang:prename}</td>
    <td class="leftb">{users:name}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:personal} {lang:surname}</td>
    <td class="leftb">{users:surname}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:groupevent} {lang:sex}</td>
    <td class="leftb">{users:sex}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:1day} {lang:birth_age}</td>
    <td class="leftb">{users:age}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:kivio} {lang:height}</td>
    <td class="leftb">{users:height}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:kdm_home} {lang:adress}</td>
    <td class="leftb">{users:adress}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:starthere} {lang:postal_place}</td>
    <td class="leftb">{users:postal_place}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:locale} {lang:country}</td>
    <td class="leftb">{users:country}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:history_clear} {lang:registered}</td>
    <td class="leftb" colspan="2"> {users:registered}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:history} {lang:laston}</td>
    <td class="leftb" colspan="2">{users:laston}</td>
  </tr>
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="2">{lang:contact}</td>
  </tr>
  <tr>
    <td class="leftc" style="width:140px">{icon:mail_generic} {lang:email}</td>
    <td class="leftb">{users:email}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:gohome} {lang:url}</td>
    <td class="leftb">{users:url}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:licq} {lang:icq}</td>
    <td class="leftb">{users:icq}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:jabber_protocol} {lang:jabber}</td>
    <td class="leftb">{users:jabber}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:skype} {lang:skype}</td>
    <td class="leftb">{users:skype} </td>
  </tr>
  <tr>
    <td class="leftc">{icon:linphone} {lang:phone}</td>
    <td class="leftb">{users:phone}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:sms_protocol} {lang:mobile}</td>
    <td class="leftb">{users:mobile}</td>
  </tr>
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:info}</td>
  </tr>
  <tr>
    <td class="leftb">{users:info}</td>
  </tr>
</table>