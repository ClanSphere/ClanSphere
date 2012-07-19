<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="5">{lang:mod_name} - {lang:archivbox}</td>
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
    <form method="post" id="messages_filter" action="{url:messages_archivbox}">
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
     </select> <input type="submit" name="submit" value="{lang:show}" /></form>
    </td>
  </tr>
</table>
<br />

<form method="post" id="messages_archivbox1" name="messages_archivbox1" action="{url:messages_multiremove}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" style="width: 40px">{sort:view}</td>
    <td class="headb">{sort:subject} {lang:subject}</td>
    <td class="headb">{sort:sender} {lang:from}</td>
    <td class="headb">{sort:date} {lang:date}</td>
    <td class="headb" colspan="2" style="width: 80px">{lang:options}</td>
  </tr>{loop:msgs_in}{if:new_period}
  <tr>
    <td class="leftb" colspan="6">
    <div style="float: left">{msgs_in:period_name}</div>
    <div style="float: right">{lang:mod_name}: {msgs_in:period_count}</div>
    </td>
  </tr>{stop:new_period}
  <tr>
    <td class="centerc">{msgs_in:icon}</td>
    <td class="leftc"><a href="{url:messages_view:id={msgs_in:messages_id}}">{msgs_in:messages_subject}</a></td>
    <td class="leftc"><a href="{url:users_view:id={msgs_in:users_id_from}}">{msgs_in:user_from}</a></td>
    <td class="leftc">{msgs_in:messages_time}</td>
    <td class="centerc"><input type="checkbox" name="select_{msgs_in:messages_id}" value="1" /></td>
    <td class="centerc"><a href="{url:messages_remove:id={msgs_in:messages_id}}" title="{lang:remove}">{icon:mail_delete}</a></td>
  </tr>{stop:msgs_in}
  <tr>
    <td class="rightb" colspan="6">
      <input type="button" name="sel_all" value="{lang:select_all}" onclick="return cs_select_checkboxes(this);" />
      <input type="submit" name="submit" value="{lang:remove_selected}" />
      <input type="reset" name="reset_sel" value="{lang:drop_selection}" />
     </td>
  </tr>
</table>
<br />
</form>

<form method="post" id="messages_archivbox2" name="messages_archivbox2" action="{url:messages_multiremove}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" style="width: 40px">{sort:view}</td>
    <td class="headb">{sort:subject} {lang:subject}</td>
    <td class="headb">{sort:sender} {lang:to}</td>
    <td class="headb">{sort:date} {lang:date}</td>
    <td class="headb" colspan="2" style="width: 80px">{lang:options}</td>
  </tr>{loop:msgs_out}{if:new_period}
  <tr>
    <td class="leftb" colspan="6">
    <div style="float: left">{msgs_out:period_name}</div>
    <div style="float: right">{lang:mod_name}: {msgs_out:period_count}</div>
    </td>
  </tr>{stop:new_period}
  <tr>
    <td class="centerc">{msgs_out:icon}</td>
    <td class="leftc"><a href="{url:messages_view:id={msgs_out:messages_id}}">{msgs_out:messages_subject}</a></td>
    <td class="leftc"><a href="{url:users_view:id={msgs_out:users_id_from}}">{msgs_out:user_to}</a></td>
    <td class="leftc">{msgs_out:messages_time}</td>
    <td class="centerc"><input type="checkbox" name="select_{msgs_out:messages_id}" value="1" /></td>
    <td class="centerc"><a href="{url:messages_remove:id={msgs_out:messages_id}}" title="{lang:remove}">{icon:mail_delete}</a></td>
  </tr>{stop:msgs_out}
  <tr>
    <td class="rightb" colspan="6">
      <input type="button" name="sel_all" value="{lang:select_all}" onclick="return cs_select_checkboxes(this);" />
      <input type="submit" name="submit" value="{lang:remove_selected}" />
      <input type="reset" name="reset_sel" value="{lang:drop_selection}" />
     </td>
  </tr>
</table>
</form>