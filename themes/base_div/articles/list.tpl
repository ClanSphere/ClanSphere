<div class="container" style="width:{page:width}">
    <div class="headb"> {lang:mod} - {lang:head_list} </div>
    <div class="leftb"> {head:body} </div>
</div>
<br />

<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
  <tr>
   <td class="headb"> {sort:category}{lang:category}</td>
	<td class="headb"> {lang:count}</td>
  </tr>
{loop:categories}
  <tr>
   		<td class="leftb"> {categories:categories_name}</td>
			<td class="rightb" style="width: 50px;"> {categories:articles_count}</td>
  </tr>
	<tr>
    	<td class="leftc" colspan="2"> {categories:categories_text}</td>
  </tr>
{stop:categories}
</table>

