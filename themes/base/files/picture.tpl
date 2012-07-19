<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb"> {lang:mod_name} - {lang:head_picture} </td>
  </tr>
  <tr>
    <td class="leftb"> {head:text} </td>
  </tr>
</table>
<br />
{head:message}
<form method="post" id="files_picture" action="{url:files_picture}" enctype="multipart/form-data">
  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
    <tr>
      <td class="leftc" style="width:140px"> {icon:download} {lang:upload}</td>
      <td class="leftb"><input type="file" name="picture" value="" />
        <br />
        <br />
        {upload:clip}
        </td>
    </tr>
    <tr>
      <td class="leftc"> {icon:ksysguard} {lang:options}</td>
      <td class="leftb"><input type="hidden" name="where" value="{file:id}" />
        <input type="submit" name="submit" value="{lang:save}" /></td>
    </tr>
  </table>
</form>
<br />
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="leftc" style="width:140px"> {icon:images} {lang:current}</td>
    <td class="leftb">
      {if:nopics}
        {lang:nopic}
      {stop:nopics}
      
      {loop:pictures} 
        <a href="{pictures:picpath}" target="_blank"><img src="{page:path}{pictures:thumbpath}" alt="" /></a><br />
        <a href="{url:files_picture:id={file:id}:delete={pictures:id}}">{lang:remove}</a><br />
        <br />
      {stop:pictures} 
      </td>
  </tr>
</table>
