<form method="post" action="{url:news_list}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb" colspan="2">{head:mod} - {head:action}</td>
 </tr>
 <tr>
  <td class="leftb">{lang:all} {head:news_count}</td>
  <td class="rightb">{head:pages}</td>
 </tr>
 <tr>
  <td class="leftb" colspan="2">{lang:category} {head:dropdown} {head:button}</td>
 </tr>
</table>
</form>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb">{sort:news_time} {lang:date}</td>
  <td class="headb">{sort:news_headline} {lang:headline}</td>
 </tr>{loop:news}
 <tr>
  <td class="leftc">{news:news_time}</td>
  <td class="leftc">{news:news_headline}</td>
  </tr>{stop:news}
</table>