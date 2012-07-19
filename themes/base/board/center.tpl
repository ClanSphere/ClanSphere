<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="4">{lang:mod_name} - {lang:abos}</td>
  </tr>
  <tr>
    <td class="leftb" style="width:25%">{lang:abos} ({count:abos})</td>
    <td class="leftb" style="width:25%"><a href="{link:attachments}">{lang:attachments}</a> ({count:attachments})</td>
    <td class="leftb" style="width:25%"><a href="{link:avatar}">{lang:avatar}</a></td>
    <td class="leftb" style="width:25%"><a href="{link:signature}">{lang:signature}</a> </td>
  </tr>
</table>
<br />
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:topics}</td>
    <td class="headb">{lang:created_by}</td>
    <td class="headb">{lang:replies}</td>
    <td class="headb">{lang:lastpost}</td>
    <td class="headb">{lang:options}</td>
  </tr>
  {loop:abos}
  <tr>
    <td class="leftc"><a href="{abos:topics_link}">{abos:topics}</a></td>
    <td class="leftc">{abos:created_by}</td>
    <td class="centerc" style="width:10px">{abos:replies}</td>
    <td class="leftc"><a href="{abos:date_link}">{abos:date}</a><br />
      {lang:created_by} {abos:lastpost_user}</td>
    <td class="centerc" style="width:10px">
      <a href="{abos:remove}" title="{lang:remove}">{icon:editdelete}</a>
    </td>
  </tr>
  {stop:abos}
</table>
