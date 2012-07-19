<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="3">{lang:mod_name} - {lang:templates}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:body}</td>
    <td class="centerb">{icon:ark} <a href="{link:cache}">{lang:cache}</a></td>
    <td class="rightb"><a href="http://design.clansphere.net" target="_blank">{lang:more_templates}</a> </td>
  </tr>
  {if:done}
  <tr>
    <td class="leftc" colspan="3"> {lang:wizard}: {link:wizard}</td>
  </tr>
  {stop:done}
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
    <td class="leftc"><a href="{url:clansphere_temp_view:dir={temp_list:dir}}">{temp_list:name}</a></td>
    <td class="leftc">{temp_list:version}</td>
    <td class="leftc">{temp_list:date}</td>
    <td class="centerc">{if:active}{icon:submit}{stop:active}{unless:active}<a href="{url:clansphere_temp_list:template={temp_list:dir}}" class="noajax">{icon:cancel}</a>{stop:active}</td>
    <td class="centerc">{if:def}{icon:submit}{stop:def}{unless:def}<a href="{url:clansphere_temp_list:activate={temp_list:dir}}" class="noajax">{icon:cancel}</a>{stop:def}</td>
  </tr>
  {stop:temp_list}
</table>
