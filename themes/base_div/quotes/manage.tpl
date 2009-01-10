<form method="post" name="quotes_manage" action="{url:form}">
<div class="container" style="width:{page:width}">
  <div class="headb">{lang:mod} - {lang:manage}</div>
  <div class="headc clearfix">
  	<div class="leftb fl">{icon:editpaste} {head:create}</div>
  	<div class="rightb fr">{head:pages}</div>
  </div>
  <div class="headc clearfix">
  	<div class="leftb fr">{icon:contents} {lang:all} {head:count}</div>
	<div class="leftb fl">{lang:category} {head:dropdown} <input type="submit" name="submit" value="{lang:show}" /></div>
  </div>
</div>
</form>
<br />
{head:message}
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
 <tr>
  <td class="headb">{sort:quotes_headline} {lang:headline}</td>
  <td class="headb">{lang:user}</td>
  <td class="headb">{sort:quotes_time} {lang:date}</td>
  <td class="headb" colspan="2" style="width: 50px;">{lang:options}</td>
 </tr>
 {loop:quotes}
 <tr>
  <td class="leftc" style="width: 40%;"><a href="{quotes:url_quote}">{quotes:quotes_headline}</a></td>
  <td class="leftc"><a href="{quotes:url_user}">{quotes:users_nick}</a></td>
  <td class="leftc">{quotes:quotes_time}</td>
  <td class="leftc"><a href="{quotes:url_edit}" title="{lang:edit}">{icon:edit}</a></td>
  <td class="leftc"><a href="{quotes:url_remove}" title="{lang:remove}">{icon:editdelete}</a></td>
 </tr>
 {stop:quotes}
</table>