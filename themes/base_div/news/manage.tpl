<div class="container" style="width:{page:width}">
  <div class="headb">{lang:mod} - {lang:manage}</div>
  	<div class="headc clearfix">
      <div class="leftb fl">{icon:editpaste} <a href="{url:news_create}">{lang:new_news}</a></div>
      <div class="rightb fr">{head:pages}</div>
	</div>
    <div class="headc clearfix">
      <div class="leftb fl">
       <form method="post" name="news_manage" action="{url:form}">
       {lang:category} 
       {head:dropdown}
       {head:button}
       </form>
      </div>
      <div class="leftb fr">{icon:contents}{lang:total}: {count:news}</div>
    </div>
</div>
<br />
{head:message}
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
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
  <td class="leftc"><a href="{news:url_user}">{news:users_nick}</a></td>
  <td class="leftc">{news:news_time}</td>
  <td class="leftc">{news:news_public}</td>
  <td class="leftc"><a href="{news:url_pictures}" title="{lang:pictures}">{icon:image}</a></td>
  <td class="leftc"><a href="{news:url_edit}" title="{lang:edit}">{icon:edit}</a></td>
  <td class="leftc"><a href="{news:url_remove}" title="{lang:remove}">{icon:editdelete}</a></td>
 </tr>
 {stop:news}
</table>