<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb" colspan="3">{lang:mod} - {lang:manage}</td>
 </tr>
 <tr>
  <td class="leftb">{icon:editpaste} <a href="{url:news_create}">{lang:new_news}</a></td>
  <td class="leftb">{icon:contents}{lang:total}: {count:news}</td>
  <td class="rightb">{head:pages}</td>
 </tr>
 <tr>
  <td class="leftb" colspan="3">
   <form method="post" name="news_manage" action="{url:form}">
   {lang:category} 
   {head:dropdown}
   {head:button}
   </form>
  </td>
 </tr>
</table>
<br />
{head:message}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb">{sort:news_headline} {lang:headline}</td>
  <td class="headb">{lang:user}</td>
  <td class="headb">{sort:news_time} {lang:date}</td>
  <td class="headb">{sort:news_public} {lang:public}</td>
  <td class="headb" colspan="3">{lang:options}</td>
 </tr>
 {loop:news}
 <tr>
  <td class="leftc"><a href="{news:url_news}">{news:news_headline}</a></td>
  <td class="leftc">{news:url_user}</td>
  <td class="leftc">{news:news_time}</td>
  <td class="leftc">{news:news_public}</td>
  <td class="leftc"><a href="{news:url_pictures}" title="{lang:pictures}">{icon:image}</a></td>
  <td class="leftc"><a href="{news:url_edit}" title="{lang:edit}">{icon:edit}</a></td>
  <td class="leftc"><a href="{news:url_remove}" title="{lang:remove}">{icon:editdelete}</a></td>
 </tr>
 {stop:news}
</table>