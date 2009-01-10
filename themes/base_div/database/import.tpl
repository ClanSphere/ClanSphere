<div class="container" style="width:{page:width}">
    <div class="headb">{lang:mod} - {lang:import}</div>
    <div class="leftc">{lang:body}</div>
</div>
<br />
{if:actions}
<div class="container" style="width:{page:width}">
    <div class="centerc"> {lang:actions_done} - {lang:cache_cleared} </div>
    <div class="leftb">{message:actions}
    </div>
</div>
<br />
{stop:actions}

{if:sql_content}
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
  <tr>
    <td class="centerb"> <a href="{link:continue}">{lang:continue}</a></td>
  </tr>
</table>
<br />
{stop:sql_content}
<form method="post" name="database_roots" action="{url:database_import}" enctype="multipart/form-data">
  <table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
    <tr>
      <td class="leftc">{icon:kate} {lang:sql_text}</td>
      <td class="leftb"><textarea name="text" cols="50" rows="12" id="text" >{import:sql_text}</textarea>
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:download}{lang:sql_file}</td>
      <td class="leftb"><input type="file" name="update" value=""  />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:ksysguard} {lang:options}</td>
      <td class="leftb"><input type="submit" name="submit" value="{lang:run}" />
      </td>
    </tr>
  </table>
</form>
