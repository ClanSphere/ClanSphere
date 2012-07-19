<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb"> {lang:mod_name} </td>
  </tr>
  <tr>
    <td class="leftb"> {lang:mod_list} </td>
  </tr>
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  {loop:categories}
  <tr>
    <td class="headb"><a href="{url:files_listcat:where={categories:id}}">{categories:name}</a> ({categories:count}) </td>
  </tr>
  <tr>
  <td class="leftb">{categories:text}</td>
  </tr>
  {if:subcats}
  <tr>
    <td class="leftc">{lang:subcats}: {loop:subs}<a href="{url:files_listcat:where={subs:id}}">{subs:name}</a> ({subs:count}) {stop:subs}</td>
  </tr>
  {stop:subcats}
  {stop:categories}
</table>