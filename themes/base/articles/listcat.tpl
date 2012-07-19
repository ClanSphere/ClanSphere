<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="2"> {lang:mod_name} - {head:categories_name} </td>
  </tr>
  <tr>
    <td class="leftb"> {icon:contents}{lang:total}: {head:articles_count} </td>
    <td class="rightb"> {head:pages} </td>
  </tr>
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
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

