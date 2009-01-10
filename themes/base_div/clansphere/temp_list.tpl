<div class="container" style="width:{page:width}">
    <div class="headb">{lang:mod} - {lang:templates}</div>
  <div class="headc clearfix">
    <div class="leftb fl">{lang:body}</div>
    <div class="rightb fr"><a href="http://design.clansphere.net" target="cs1" >{lang:more_templates}</a> </div>
    <div class="centerb">{icon:ark} <a href="{link:cache}">{lang:cache}</a></div>
  </div>
  {if:done}
    <div class="leftc"> {lang:wizard}: {link:wizard}</div>
  {stop:done}
</div>
<br />
{lang:getmsg}
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:name}</td>
    <td class="headb">{lang:version}</td>
    <td class="headb">{lang:date}</td>
    <td class="headb">{lang:preview}</td>
    <td class="headb">{lang:active}</td>
  </tr>
  {loop:temp_list}
  <tr>
    <td class="leftc"><a href="{temp_list:link}" >{temp_list:name}</a></td>
    <td class="leftb">{temp_list:version}</td>
    <td class="leftb">{temp_list:date}</td>
    <td class="centerb">{temp_list:preview}</td>
    <td class="centerb">{temp_list:active}</td>
  </tr>
  {stop:temp_list}
</table>
