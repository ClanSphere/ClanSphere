{if:manage}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb" colspan="3">{lang:mod_name} - {lang:manage}</td>
 </tr>
 <tr>
  <td class="leftb">{icon:editpaste} <a href="{url:buddys_create}">{lang:new_buddy}</a></td>
  <td class="leftb">{icon:contents} {lang:total}: {head:buddys_count}</td>
  <td class="rightb">{head:pages}</td>
 </tr>
</table>
<br />
{head:message}

<div style="width:{page:width}; text-align:center; margin: auto;">
  <div style="float: left; width: 48%;">
    <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:100%">
      <tr>
        <td class="headb">{icon:xchat}{lang:on_buddies}</td>
      </tr>
      {loop:buddys_on}
      <tr>
        <td class="leftb"><div style="float: left;">
      <img src="{page:path}symbols/countries/{buddys_on:users_country}.png" width="16" height="11" alt="" />
        {buddys_on:users_link} </div>
          <div style="float: right;">
          <a href="{url:buddys_center:notice={buddys_on:buddys_id}}">{icon:documentinfo}</a>
          <a href="{url:messages_create:to={buddys_on:users_nick}}">{icon:mail_send}</a>
          <a href="{url:buddys_edit:id={buddys_on:buddys_id}}">{icon:edit}</a>
          <a href="{url:buddys_remove:id={buddys_on:buddys_id}}">{icon:editdelete}</a>
          </div></td>
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
      <img src="{page:path}symbols/countries/{buddys_off:users_country}.png" width="16" height="11" alt="" />
        {buddys_off:users_link} </div>
          <div style="float: right;">
          <a href="{url:buddys_center:notice={buddys_off:buddys_id}}">{icon:documentinfo}</a>
          <a href="{url:messages_create:to={buddys_off:users_nick}}">{icon:mail_send}</a>
          <a href="{url:buddys_edit:id={buddys_off:buddys_id}}">{icon:edit}</a>
          <a href="{url:buddys_remove:id={buddys_off:buddys_id}}">{icon:editdelete}</a>
          </div></td>
      </tr>
      {stop:buddys_off}
    </table>
  </div>
</div>
{stop:manage}

{if:notice}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb">{lang:mod_name} - {lang:buddys_notice_head}</td>
 </tr>
 <tr>
  <td class="leftb">{lang:buddys_notice_body}</td>
 </tr>
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="leftc">{icon:personal} {lang:buddys_notice_nick}</td>
  <td class="leftb">{buddys:users_link}</td>
 </tr>
 <tr>
  <td class="leftc">{icon:history} {lang:buddys_notice_laston}</td>
  <td class="leftb">{buddys:users_laston}</td>
 </tr>
 <tr>
  <td class="leftc">{icon:history_clear} {lang:buddys_notice_add}</td>
  <td class="leftb">{buddys:buddys_time}</td>
 </tr>
 <tr>
  <td class="leftc">{icon:kate} {lang:buddys_notice}</td>
  <td class="leftb">{buddys:buddys_notice}</td>
 </tr>
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="centerb"><a href="{url:buddys_center}">{lang:back}</a></td>
 </tr>
</table>
{stop:notice}