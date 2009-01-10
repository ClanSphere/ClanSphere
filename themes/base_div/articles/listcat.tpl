<div class="container" style="width:{page:width}">
    <div class="headb"> {lang:mod} - {head:categories_name} </div>
  <div class="headc clearfix">
    <div class="leftb fl"> {icon:contents}{lang:total}: {head:articles_count} </div>
    <div class="rightb fr"> {head:pages} </div>
  </div>
</div>
<br />

<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
  <tr>
    <td class="headb"> {sort:headline}{lang:headline}</td>
	<td class="headb"> {lang:user}</td>
	<td class="headb"> {sort:date}{lang:release}</td>
	<td class="headb"> {lang:views}</td>
  </tr>
{loop:articles}
  <tr>
    <td class="leftc"> {articles:articles_headline}</td>
	<td class="leftc"> {articles:articles_user}</td>
	<td class="leftc"> {articles:articles_date}</td>
	<td class="leftc"> {articles:articles_views}</td>
  </tr>
{stop:articles}
</table>

