<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:attachments}</td>
  </tr>
  <tr>
    <td class="leftb"><div style="float:left"><a href="{url:board_manage}">{lang:back}</a></div><div style="float:right">
    {lang:all} {count:all}</div></td>
  </tr>
</table>
<br />
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="2">{lang:filename}</td>
    <td class="headb">{lang:size}</td>
    <td class="headb">{lang:topics}</td>
    <td class="headb">{lang:downloaded}</td>
    <td class="headb">{lang:user}</td>
    <td class="headb">{lang:options}</td>
  </tr>
  {loop:attachments}
  <tr>
    <td class="leftc">{attachments:icon}</td>
    <td class="leftc">{attachments:filename}</td>
    <td class="leftc">{attachments:size}</td>
    <td class="leftc"><a href="{attachments:topics_link}" title="{attachments:threads_headline}">{attachments:topics}</a></td>
    <td class="leftc">{attachments:downloaded} {lang:times}</td>
    <td class="leftc"><a href="{attachments:user_link}">{attachments:user}</a></td>
    <td class="centerc" style="width:10"><a href="{attachments:remove}" title="{lang:remove}">{icon:editdelete}</a> </td>
  </tr>
  {stop:attachments}
</table>
