<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:import}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:body}</td>
  </tr>
</table>
<br />
{if:actions}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="centerc"> {lang:actions_done} - {lang:cache_cleared} </td>
  </tr>
  <tr>
    <td class="leftb">{message:actions}
    </td>
  </tr>
</table>
<br />
{stop:actions}

{if:sql_content}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="centerb"> <a href="{link:continue}">{lang:continue}</a></td>
  </tr>
</table>
<br />
{stop:sql_content}
<form method="post" id="database_roots" action="{url:database_import}" enctype="multipart/form-data">
  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
    <tr>
      <td class="leftc">{icon:kate} {lang:sql_text}</td>
      <td class="leftb"><textarea name="text" cols="50" rows="12" id="text">{import:sql_text}</textarea>
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:download}{lang:sql_file}</td>
      <td class="leftb"><input type="file" name="update" value="" />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:ksysguard} {lang:options}</td>
      <td class="leftb"><input type="submit" name="submit" value="{lang:run}" />
      </td>
    </tr>
  </table>
</form>
