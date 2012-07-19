<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:body}</td>
  </tr>
</table>
<br />
{lang:getmsg}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:name}</td>
    <td class="headb">{lang:version}</td>
    <td class="headb">{lang:date}</td>
    <td class="headb">{lang:preview}</td>
    <td class="headb">{lang:active}</td>
  </tr>
  {loop:temp_list}
  <tr>
    <td class="leftc">{temp_list:name}</td>
    <td class="leftb">{temp_list:version}</td>
    <td class="leftb">{temp_list:date}</td>
    <td class="centerb">{temp_list:preview}</td>
    <td class="centerb">{temp_list:active}</td>
  </tr>
  {stop:temp_list}
</table>
