<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="5">{lang:mod_name} - {lang:head_outbox}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:mail_new} <a href="{url:messages_create}">{lang:new_message}</a></td>
    <td class="leftb">{icon:inbox} <a href="{url:messages_inbox}">{lang:inbox} {count:inbox}</a></td>
    <td class="leftb">{icon:outbox} <a href="{url:messages_outbox}">{lang:outbox} {count:outbox}</a></td>
    <td class="leftb">{icon:queue} <a href="{url:messages_archivbox}">{lang:archivbox} {count:archivbox}</a></td>
    <td class="rightb">{var:pages}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:email} <a href="{url:messages_inbox:page=new}">{var:new_msgs} {lang:new_messages}</a></td>
    <td class="leftb" colspan="4">
    <form method="post" id="messages_filter" action="{url:messages_outbox}">
     <fieldset style="border: 0; padding: 0">
     <select name="messages_filter">
      <option value="0">----</option>
      <option value="1">{lang:last_day}</option>
      <option value="2">{lang:last_2days}</option>
      <option value="3">{lang:last_4days}</option>
      <option value="4">{lang:last_week}</option>
      <option value="5">{lang:last_2weeks}</option>
      <option value="6">{lang:last_3weeks}</option>
      <option value="7">{lang:last_50days}</option>
      <option value="8">{lang:last_100days}</option>
      <option value="9">{lang:last_year}</option>
      <option value="10">{lang:last_2years}</option>
     </select> <input type="submit" name="submit" value="{lang:show}" />
     </fieldset>
     </form>
    </td>
  </tr>
</table>
<br />

<form method="post" id="messages_outbox" name="messages_outbox" action="{url:messages_multiremove}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" style="width: 40px">{sort:view}</td>
    <td class="headb">{sort:subject} {lang:subject}</td>
    <td class="headb">{sort:sender} {lang:to}</td>
    <td class="headb">{sort:date} {lang:date}</td>
    <td class="headb" colspan="3" style="width: 80px">{lang:options}</td>
  </tr>{loop:msgs}{if:new_period}
  <tr>
    <td class="leftb" colspan="7">
    <div style="float: left">{msgs:period_name}</div>
    <div style="float: right">{lang:mod_name}: {msgs:period_count}</div>
    </td>
  </tr>{stop:new_period}
  <tr>
    <td class="centerc">{msgs:icon}</td>
    <td class="leftc"><a href="{url:messages_view:id={msgs:messages_id}}">{msgs:messages_subject}</a></td>
    <td class="leftc">{msgs:user_to}</td>
    <td class="leftc">{msgs:messages_time}</td>
    <td class="centerc"><input type="checkbox" name="select_{msgs:messages_id}" value="1" /></td>
    <td class="centerc"><a href="{url:messages_remove:id={msgs:messages_id}}" title="{lang:remove}">{icon:mail_delete}</a></td>
    <td class="centerc"><a href="{url:messages_archiv:id={msgs:messages_id}}" title="{lang:archiv}">{icon:ark}</a></td>
  </tr>{stop:msgs}
  <tr>
    <td class="rightb" colspan="7">
      <input type="hidden" name="outbox" value="outbox" />
      <input type="button" name="sel_all" value="{lang:select_all}" onclick="return cs_select_checkboxes(this);" />
      <input type="submit" name="submit" value="{lang:remove_selected}" />
      <input type="reset" name="reset_sel" value="{lang:drop_selection}" />
     </td>
  </tr>
</table>
</form>
