<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:charset}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:body_charset}</td>
  </tr>
</table>
<br />
{if:old_php}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="centerc">{icon:error} {lang:old_php}</td>
  </tr>
</table>
<br />
{stop:old_php}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:test}</td>
    <td class="headb" colspan="2">{lang:result}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:txt} {lang:setup_file}</td>
    <td class="leftb">{charset:check}</td>
    <td class="leftb">{charset:result}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:style} {lang:tpl_setting}</td>
    <td class="leftb">{charset:check}</td>
    <td class="leftb">{charset:result}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:web} {lang:web_setting}</td>
    <td class="leftb">{charset:check}</td>
    <td class="leftb">{charset:result}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:php} {lang:php_setting}</td>
    <td class="leftb">{charset:check}</td>
    <td class="leftb">{charset:result}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:db_status} {lang:sql_setting}</td>
    <td class="leftb">{charset:check}</td>
    <td class="leftb">{charset:result}</td>
  </tr>
</table>