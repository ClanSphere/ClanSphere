<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="4">{lang:mod_name} - {lang:head_center}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:mail_new} <a href="{url:messages_create}">{lang:new_message}</a></td>
    <td class="leftb">{icon:inbox} <a href="{url:messages_inbox}">{lang:inbox} {count:inbox}</a></td>
    <td class="leftb">{icon:outbox} <a href="{url:messages_outbox}">{lang:outbox} {count:outbox}</a></td>
    <td class="leftb">{icon:queue} <a href="{url:messages_archivbox}">{lang:archivbox} {count:archivbox}</a></td>
  </tr>
</table>
<br />
{head:message}

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="leftc" colspan="2">{icon:email} <a href="{url:messages_inbox:page=new}">{count:new_messages} {lang:new_messages}</a></td>
  </tr>
  <tr>
    <td class="leftc">{icon:kedit} <a href="{url:messages_autoresponder}">{lang:autoresponder}</a></td>
    <td class="rightb">{var:autoresponder}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:mail_send} <a href="{url:messages_mail}">{lang:mail_message}</a></td>
    <td class="rightb">{var:mailmessage}</td>
  </tr>
{if:buddies}
  <tr>
    <td class="leftc">{icon:xchat} <a href="{url:buddys_center}">{lang:buddys}</a></td>
    <td class="rightb">{count:buddys}</td>
  </tr>
{stop:buddies}
  <tr>
    <td class="leftc">{icon:inbox} {lang:in_inbox}</td>
    <td class="rightb">{count:inbox}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:outbox} {lang:in_outbox}</td>
    <td class="rightb">{count:outbox}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:queue} {lang:in_archiv}</td>
    <td class="rightb">{count:archivbox}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:mail_delete} {lang:auto_del}</td>
    <td class="rightb">{option:del_time} {lang:days}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:mail_generic} {lang:max_mails}</td>
    <td class="rightb">{option:max_space}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:nfs_unmount} {lang:space}</td>
    <td class="leftb">
      <div style="float: right; text-align: right; height: 13px; width: 35px; vertical-align: middle">{var:space_used}%</div>
      <div style="background-image: url({page:path}symbols/messages/messages03.png); width: 100px; height: 13px;">
        <div style="background-image: url({page:path}symbols/messages/messages01{var:color}.png); width: {var:space_used}px; text-align: right; padding-left: 1px">
          <img src="{page:path}symbols/messages/messages02{var:color}.png" style="height: 13px; width: 2px" alt="" />
        </div>
      </div>
    </td>
  </tr>
</table>