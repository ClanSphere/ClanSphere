<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="3">{lang:mod_name} - {lang:languages}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:body}</td>
    <td class="centerb">{icon:ark} <a href="{link:cache}">{lang:cache}</a></td>
    <td class="rightb"><a href="http://lang.clansphere.net" target="_blank">{lang:more_languages}</a> </td>
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
    <td class="headb">{lang:lang}</td>
    <td class="headb">{lang:version}</td>
    <td class="headb">{lang:date}</td>
    <td class="headb">{lang:active}</td>
  </tr>
  {loop:lang_list}
  <tr>
    <td class="leftc"><img src="{page:path}symbols/countries/{lang_list:icon}.png" alt="" /> <a href="{lang_list:link}">{lang_list:name}</a></td>
    <td class="leftc">{lang_list:version}</td>
    <td class="leftc">{lang_list:date}</td>
    <td class="centerc">{lang_list:active}</td>
  </tr>
  {stop:lang_list}
</table>
