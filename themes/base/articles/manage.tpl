<form method="post" action="{url:articles_manage}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="2"> {lang:mod_name} - {lang:head_manage} </td>
  </tr>
  <tr>    
    <td class="leftb"> {icon:contents} {lang:all} {head:articles_count} </td>
    <td class="rightb"> {head:pages} </td>
  </tr>
    <tr>
    <td class="leftb" colspan="2"> {lang:category}{head:dropdown} <input name="submit" value="{lang:show}" type="submit" /></td>
  </tr>
</table>
</form>
<br />
{head:message}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
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
  <td class="leftc"> <a href="{articles:url_edit}" title="{lang:edit}">{icon:edit}</a></td>
  <td class="leftc"> <a href="{articles:url_remove}" title="{lang:remove}">{icon:editdelete}</a></td>
  </tr>
{stop:articles}
</table>

