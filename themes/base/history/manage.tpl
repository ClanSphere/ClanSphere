<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb" colspan="2">{lang:mod_name} - {lang:manage}</td>
 </tr>
 <tr>  
  <td class="leftb">{icon:contents} {lang:total}: {count:history}</td>
  <td class="rightb">{head:pages}</td>
 </tr>
</table>
<br />

{head:message}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb">{sort:time} {lang:date}</td>
  <td class="headb">{sort:text} {lang:text}</td>
  <td class="headb" colspan="2">{lang:options}</td>
 </tr>
{loop:history}
 <tr>
  <td class="leftc">{history:time}</td>
  <td class="leftc">{history:text}</td>
  <td class="leftc"><a href="{history:url_edit}" title="{lang:edit}">{icon:edit}</a></td>
  <td class="leftc"><a href="{history:url_remove}" title="{lang:remove}">{icon:editdelete}</a></td>
 </tr>
{stop:history}
</table>
