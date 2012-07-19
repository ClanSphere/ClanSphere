<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="4">{lang:mod_name} - {lang:attachments}</td>
  </tr>
  <tr>
    <td class="leftb" style="width:25%"><a href="{url:board_center}">{lang:abos}</a> ({link:abos_count})</td>
    <td class="leftb" style="width:25%">{lang:attachments} ({link:attachments_count})</td>
    <td class="leftb" style="width:25%"><a href="{url:board_avatar}">{lang:avatar}</a></td>
    <td class="leftb" style="width:25%"><a href="{url:board_signature}">{lang:signature}</a> </td>
  </tr>
</table>
<br />
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="2">{lang:filename}</td>
    <td class="headb">{lang:size}</td>
    <td class="headb">{lang:topics}</td>
    <td class="headb">{lang:downloaded}</td>
    <td class="headb">{lang:options}</td>
  </tr>
  {loop:attachments}
  <tr>
    <td class="leftc">{attachments:img}</td>
    <td class="leftc">{attachments:filename}</td>
    <td class="leftc">{attachments:size}</td>
    <td class="leftc">{attachments:topics}</td>
    <td class="leftc">{attachments:downloaded} {lang:times}</td>
    <td class="centerc" style="width:10">{attachments:remove}</td>
  </tr>
  {stop:attachments}
</table>
