<form method="post" action="{url:articles_manage}">
<div class="container" style="width:{page:width}">
    <div class="headb"> {lang:mod} - {lang:head_manage} </div>
  <div class="headc clearfix">
    <div class="leftb fl"> {icon:editpaste}{link:new_article}</div>
	<div class="rightb fr"> {head:pages} </div>
  </div>
  <div class="headc clearfix">
    <div class="leftb fl"> {lang:category}{head:dropdown}{head:button}</div>
    <div class="rightb fr"> {icon:contents} {lang:all} {head:articles_count} </div>
  </div>
</div>
</form>
<br />
{head:message}
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
  <tr>
    <td class="headb"> {sort:headline}{lang:headline}</td>
	<td class="headb"> {lang:user}</td>
	<td class="headb"> {sort:date}{lang:date}</td>
	<td class="headb" colspan="2"> {lang:options}</td>
  </tr>
{loop:articles}
  <tr>
    <td class="leftc"> {articles:articles_headline}</td>
	<td class="leftc"> {articles:users_link}</td>
	<td class="leftc"> {articles:articles_date}</td>
	<td class="leftc"> {articles:articles_edit}</td>
	<td class="leftc"> {articles:articles_remove}</td>
  </tr>
{stop:articles}
</table>

