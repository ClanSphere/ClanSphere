<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="4">{lang:mod} - {lang:head_manage}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:editpaste} <a href="{link:new_board}">{lang:new_board}</a></td>
    <td class="leftb">{icon:agt_reload} <a href="{link:sort}">{lang:sort}</a></td>
    <td class="leftb">{icon:special_paste} <a href="{link:reports}">{lang:reports}</a></td>
    <td class="leftb">{icon:attach} <a href="{link:attachments}">{lang:attachments}</a>: {count:attachments}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:contents} {lang:all}: {count:all}</td>
    <td class="rightb" colspan="3">{pages:list}</td>
  </tr>
</table>
<br />
{lang:getmsg}
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
  <tr>
    <td class="headb">{sort:name} {lang:name}</td>
    <td class="headb">{sort:cat} {lang:cat}</td>
    <td class="headb" colspan="2">{lang:options}</td>
  </tr>
  {loop:board}
  <tr>
    <td class="leftc">{board:name}</td>
    <td class="leftc">{board:cat}</td>
    <td class="leftc"><a href="{board:edit}" title="{lang:edit}"><img src="symbols/crystal_project/16/edit.png" style="height:16px;width:16px" alt="{lang:edit}" /> </a></td>
    <td class="leftc"><a href="{board:remove}" title="{lang:remove}"><img src="symbols/crystal_project/16/editdelete.png" style="height:16px;width:16px" alt="{lang:remove}" /> </a> </td>
  </tr>
  {stop:board}
</table>
