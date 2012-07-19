<form method="post" id="quotes_manage" action="{url:quotes_manage}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb" colspan="2">{lang:mod_name} - {lang:manage}</td>
 </tr>
 <tr>  
  <td class="leftb">{icon:contents} {lang:all} {head:count}</td>
  <td class="rightb">{head:pages}</td>
 </tr>
 <tr>
  <td class="leftb" colspan="2">
    {lang:category} {head:dropdown} <input type="submit" name="submit" value="{lang:show}" />
  </td>
 </tr>
</table>
</form>
<br />
{head:message}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb">{sort:quotes_headline} {lang:headline}</td>
  <td class="headb">{lang:user}</td>
  <td class="headb">{sort:quotes_time} {lang:date}</td>
  <td class="headb" colspan="2" style="width: 50px;">{lang:options}</td>
 </tr>
 {loop:quotes}
 <tr>
  <td class="leftc" style="width: 40%;"><a href="{quotes:url_quote}">{quotes:quotes_headline}</a></td>
  <td class="leftc">{quotes:url_user}</td>
  <td class="leftc">{quotes:quotes_time}</td>
  <td class="leftc"><a href="{quotes:url_edit}" title="{lang:edit}">{icon:edit}</a></td>
  <td class="leftc"><a href="{quotes:url_remove}" title="{lang:remove}">{icon:editdelete}</a></td>
 </tr>
 {stop:quotes}
</table>