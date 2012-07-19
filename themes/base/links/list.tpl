<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:head_list}</td>
  </tr>
  <tr>
    <td class="leftb">{head:body}</td>
  </tr>
</table>
<br />

{loop:categories}
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb"><a href="{categories:url}">{categories:name}</a> ({categories:count_links})</td>
  </tr>
  <tr>
    <td class="leftb">{categories:text}</td>
  </tr>
</table>
<br />
{stop:categories}