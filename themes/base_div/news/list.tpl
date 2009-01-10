<form method="post" action="{url:news_list}">
<div class="container" style="width:{page:width}">
	<div class="headb">{head:mod} - {head:action}</div>
		<div class="headc clearfix">
			<div class="leftb fl">{lang:all} {head:news_count}</div>
			<div class="rightb fr">{head:pages}</div>
		</div> 
  <div class="leftb">{lang:category} {head:dropdown} {head:button}</div>
</div>
</form>
<br />

<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
 <tr>
  <td class="headb">{sort:news_time} {lang:date}</td>
  <td class="headb">{sort:news_headline} {lang:headline}</td>
 </tr>{loop:news}
 <tr>
  <td class="leftc">{news:news_time}</td>
  <td class="leftc">{news:news_headline}</td>
  </tr>{stop:news}
</table>