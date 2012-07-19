<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="2"> {lang:mod_name} - {lang:manage} </td>
  </tr>
  <tr>    
    <td class="leftb">{icon:contents} {lang:total}: {head:count}</td>
    <td class="rightb">{head:paginator}</td>
  </tr>
  <tr>
    <td class="leftb" colspan="2"> {lang:category}
      <form method="post" id="files_manage" action="{url:files_manage}">
        <select name="where">
          <option value="0">----</option>
          {head:categories}
        </select>
        <input type="submit" name="submit" value="{lang:show}" />
      </form></td>
  </tr>
</table>
{head:message}
<br />
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:typ}</td>
    <td class="headb">{sort:headline}{lang:headline}</td>
    <td class="headb">{lang:user}</td>
    <td class="headb">{sort:date}{lang:date}</td>
    <td class="headb" colspan="3">{lang:options}</td>
  </tr>
  {loop:files}
  <tr>
    <td class="leftc">{loop:filetypes}{filetypes:icon}{stop:filetypes}</td>
    <td class="leftc"><a href="{url:files_view:id={files:id}}">{files:name}</a></td>
    <td class="leftc">{files:user}</td>
    <td class="leftc">{files:date}</td>
    <td class="leftc"><a href="{url:files_picture:id={files:id}}" title="{lang:preview}">{icon:image}</a></td>
    <td class="leftc"><a href="{url:files_edit:id={files:id}}" title="{lang:edit}">{icon:edit}</a></td>
    <td class="leftc"><a href="{url:files_remove:id={files:id}}" title="{lang:remove}">{icon:editdelete}</a></td>
  </tr>
  {stop:files}
</table>
