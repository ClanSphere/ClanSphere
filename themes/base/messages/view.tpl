<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="2"><a href="{url:messages_center}">{lang:mod_name}</a> - {lang:text}</td>
  </tr>
  <tr>
    <td class="leftc">{lang:from}</td>
    <td class="leftb">{msg:from}</td>
  </tr>
  <tr>
    <td class="leftc">{lang:date}</td>
    <td class="leftb">{msg:messages_time}</td>
  </tr>
  <tr>
    <td class="leftc">{lang:options}</td>
    <td class="leftb">
      <a href="javascript:history.back()" title="{lang:back}">{icon:back}</a>
      {if:reply}
        <a href="{url:messages_create:rep={msg:messages_id}}" title="{lang:replay}">{icon:mail_replay}</a>
      {stop:reply}
      {if:forward}
        <a href="{url:messages_create:forward={msg:messages_id}}" title="{lang:forward}">{icon:mail_forward}</a>
      {stop:forward}      
      <a href="{url:messages_remove:id={msg:messages_id}}" title="{lang:remove}">{icon:mail_delete}</a>
      {if:archiv}
        <a href="{url:messages_archiv:id={msg:messages_id}}" title="{lang:archiv}">{icon:ark}</a></td>
      {stop:archiv}
  </tr>
  <tr>
    <td class="headb" colspan="2">{msg:messages_subject}</td>
  </tr>
  <tr>
    <td class="leftb" colspan="2">{msg:messages_text}</td>
  </tr>
</table>