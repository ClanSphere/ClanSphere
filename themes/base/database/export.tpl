<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:export}</td>
  </tr>
  <tr>
    <td class="leftb">{head:body}</td>
  </tr>
</table>
<br />

{if:form}
<form method="post" id="database_export" action="{url:database_export}">
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb" style="width:200px">{lang:sql_tables}</td>
    <td class="headb" colspan="2">{lang:sql_options}</td>
  </tr>
  <tr>
    <td class="centerb" rowspan="4">
      <select name="tables[]" id="sql_tables" multiple="multiple" size="8" style="width:90%">
        {loop:tables}
        {tables:option}
        {stop:tables}
      </select><br />
      <a href="javascript:cs_select_multiple('sql_tables',1)">{lang:all}</a> -
      <a href="javascript:cs_select_multiple('sql_tables',0)">{lang:none}</a> -
      <a href="javascript:cs_select_multiple('sql_tables','reverse')">{lang:reverse}</a>
    </td>
    <td class="leftc">{lang:prefix}</td>
    <td class="leftb"><input type="text" name="prefix" value="&#123;pre&#125;" maxlength="20" size="20" /></td>
  </tr>
  <tr>
    <td class="leftc">{lang:datasets}</td>
    <td class="leftb"><input type="checkbox" name="truncate" value="1" /> {lang:send_truncate}</td>
  </tr>
  <tr>
    <td class="leftc">{lang:output}</td>
    <td class="leftb">
      <input type="radio" name="output" value="text" checked="checked" /> {lang:text}
      <input type="radio" name="output" value="file" /> {lang:file}
    </td>
  </tr>
  <tr>
    <td class="leftc">{lang:options}</td>
    <td class="leftb"><input type="submit" name="submit" value="{lang:export}" /></td>
  </tr>
</table>
</form>
{stop:form}

{if:output_text}
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="leftb">
      {output:text}
    </td>
  </tr>
</table>
{stop:output_text}