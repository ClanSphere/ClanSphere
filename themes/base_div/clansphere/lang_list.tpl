<div class="forum" style="width:{page:width}">
    <div class="headb">{lang:mod} - {lang:languages}</div>
  <div class="headc clearfix">
    <div class="leftb fl">{lang:body}</div>
    <div class="rightb fr"><a href="http://lang.clansphere.net" target="cs1">{lang:more_languages}</a> </div>
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
    <td class="headb">{lang:lang}</td>
    <td class="headb">{lang:version}</td>
    <td class="headb">{lang:date}</td>
    <td class="headb">{lang:active}</td>
  </tr>
  {loop:lang_list}
  <tr>
    <td class="leftc"><img src="symbols/countries/{lang_list:icon}.png" alt="" /> <a href="{lang_list:link}" >{lang_list:name}</a></td>
    <td class="leftb">{lang_list:version}</td>
    <td class="leftb">{lang_list:date}</td>
    <td class="centerb">{lang_list:active}</td>
  </tr>
  {stop:lang_list}
</table>
