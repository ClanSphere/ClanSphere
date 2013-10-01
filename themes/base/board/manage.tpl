<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="4">{lang:mod_name} - {lang:head_manage}</td>
  </tr>
  <tr>    
    <td class="leftb">{icon:agt_reload} <a href="{url:board_sort}">{lang:sort}</a></td>
    <td class="leftb">{icon:special_paste} <a href="{url:board_reportlist}">{lang:reports}</a> ({head:count_reports})</td>
    <td class="leftb">{icon:attach} <a href="{url:board_attachments_admin}">{lang:attachments}</a> ({head:count_attachments})</td>
    <td class="leftb">{icon:db_status} <a href="{url:board_metadata}">{lang:repair}</a></td>
  </tr>
  <tr>
    <td class="leftb">{icon:contents} {lang:total}: {head:count}</td>
    <td class="rightb" colspan="3">{head:pages}</td>
  </tr>
</table>
<br />

{head:getmsg}

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{sort:name} {lang:name}</td>
    <td class="headb">{sort:cat} {lang:cat}</td>
    <td class="headb" colspan="2" style="width:15%;">{lang:options}</td>
  </tr>
  {loop:board}
  <tr>
    <td class="leftc">{board:name}</td>
    <td class="leftc">{board:cat}</td>
    <td class="leftc"><a href="{url:board_edit:id={board:id}}" title="{lang:edit}">{icon:edit}</a></td>
    <td class="leftc"><a href="{url:board_remove:id={board:id}}" title="{lang:remove}">{icon:editdelete}</a></td>
  </tr>
  {stop:board}
</table>