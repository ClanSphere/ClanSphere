<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:charset}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:body_charset}</td>
  </tr>
</table>
<br />
{if:old_mysql}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="centerc">{icon:error} {lang:old_mysql}</td>
  </tr>
</table>
<br />
{stop:old_mysql}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" style="width: 170px">{lang:test}</td>
    <td class="headb" colspan="2">{lang:result}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:txt} {lang:setup_file}</td>
    <td class="centerb" style="width: 50px">{charset:check_setup_file}</td>
    <td class="leftb">{charset:result_setup_file}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:style} {lang:tpl_setting}</td>
    <td class="centerb">{charset:check_tpl_setting}</td>
    <td class="leftb">{charset:result_tpl_setting}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:web} {lang:web_setting}</td>
    <td class="centerb">{charset:check_web_setting}</td>
    <td class="leftb">{charset:result_web_setting}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:db_status} {lang:sql_setting}</td>
    <td class="centerb">{charset:check_sql_setting}</td>
    <td class="leftb">{charset:result_sql_setting}</td>
  </tr>
</table>