<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="2"><a href="{url:files}">{lang:mod_name}</a> - <a href="{url:files_listcat:where={category:id}}">{category:name}</a> - {file:name} </td>
  </tr>
  <tr>
    <td class="leftc">{icon:kedit} {lang:name}</td>
    <td class="leftb" style="width:60%">{file:name}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:package_editors} {lang:version}</td>
    <td class="leftb" style="width:60%">{file:version}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:fileshare} {lang:big}</td>
    <td class="leftb" style="width:60%">{file:size}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:personal} {lang:autor}</td>
    <td class="leftb" style="width:60%">{file:user}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:1day} {lang:date}</td>
    <td class="leftb" style="width:60%">{file:date}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:download} {lang:downloaded}</td>
    <td class="leftb" style="width:60%"><strong>{file:count}</strong> {lang:mal}</td>
  </tr>
  {if:brokenlink}
  <tr>
    <td class="leftc">{icon:db_status} {lang:brokenlink}</td>
    <td class="leftb" style="width:60%"><form method="post" action="{url:files_view:where={file:id}}">
      <input type="hidden" name="brokenlink" value="{file:id}" />
      <input type="submit" name="submit" value="{lang:report}" />
    </form></td>
  </tr>
  {stop:brokenlink}
  {if:vote}
  <tr>
    <td class="leftc">{icon:volume_manager} {lang:evaluation}</td>
    <td class="leftb">
    {if:unvoted}
    <form method="post" action="{url:files_view:where={file:id}}">
      <select name="voted_answer" id="voted_answer">
        {loop:votes}
          <option value="{votes:value}">{votes:name}</option>
        {stop:votes}
      </select>
      <input type="hidden" name="file_id" value="{file:id}" />
      <input type="submit" name="submit" value="{lang:ok}" />
    </form> 
    {stop:unvoted}
    {unless:unvoted}
      {vote:stars}
    {stop:unvoted}
    </td>
  </tr>
  {stop:vote}
  <tr>
    <td class="headb" colspan="2">{lang:info}</td>
  </tr>
  <tr>
    <td class="leftb" colspan="2">{file:description}</td>
  </tr> 
  {if:preview}
  <tr>
    <td class="headb" colspan="2">{lang:preview}</td>
  </tr>
  <tr>
    <td class="leftb" colspan="2">{loop:previews}
    <a href="{page:path}{previews:path}">{previews:image}</a>
    {stop:previews}</td>
  </tr>
  {stop:preview}
</table>
<br />
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="2">{lang:mirror}</td>
    <td class="headb" style="width:120px">{lang:typ}</td>
  </tr>
  {loop:mirrors}
  <tr>
    <td class="leftc">{icon:html}</td>
    <td class="leftc"><a href="{url:files_download:where={file:id}:target={mirrors:id}}" class="noajax" target="_blank">{mirrors:name}</a></td>
    <td class="leftc">{mirrors:filetype_image} ({mirrors:filetype_name}) </td>
  </tr>
  {stop:mirrors}
</table>
<br/>