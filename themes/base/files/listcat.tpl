<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="3"><a href="{url:files}">{lang:mod_name}</a> - {category:name} </td>
  </tr>
  <tr>
    <td class="leftb"> {icon:contents} {lang:total}: {category:count}</td>
    <td class="rightb">{category:paginator}</td>
  </tr>
</table>
<br />

{if:subcats}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb"> {lang:subcats}: </td>
  </tr>
  {loop:subs}
  <tr>
    <td class="leftc"><a href="{url:files_listcat:where={subs:id}}">{subs:name}</a> ({subs:count}) </td>
  </tr>
  {stop:subs}
</table>
<br />
{stop:subcats}

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb"> {sort:name} {lang:name}</td>
    <td class="headb"> {lang:user}</td>
    <td class="headb"> {sort:date} {lang:date}</td>
    <td class="headb"> {sort:big}{lang:big}</td>
    <td class="headb"> {lang:typ} </td>
  </tr>
  {loop:files}
  <tr>
    <td class="leftc"><a href="{url:files_view:id={files:id}}">{files:name}</a></td>
    <td class="leftc"> {files:user} </td>
    <td class="leftc"> {files:date}</td>
    <td class="leftc"> {files:size}</td>
    <td class="leftc"> {loop:filetypes}
      {filetypes:icon}
      {stop:filetypes} </td>
  </tr>
  {stop:files}
</table>