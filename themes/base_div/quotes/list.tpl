<form method="post" action="{url:quotes_list}">
<div class="container" style="width:{page:width}">
  		<div class="headb">{head:mod} - {head:action}</div>
    <div class="headc clearfix">
  		<div class="leftb fl">{icon:contents} {lang:all} {head:count}</div>
  		<div class="rightb fr">{head:pages}</div>
    </div>
  		<div class="leftb">{lang:category} {head:dropdown} {head:button}</div>
</div>
</form>
<br />

<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
 <tr>
  <td class="headb" style="width:30%;">{sort:quotes_time} {lang:date}</td>
  <td class="headb">{sort:quotes_headline} {lang:headline}</td>
 </tr>{loop:quotes}
 <tr>
  <td class="leftc">{quotes:quotes_time}</td>
  <td class="leftc">{quotes:quotes_headline}</td>
 </tr>{stop:quotes}
</table>