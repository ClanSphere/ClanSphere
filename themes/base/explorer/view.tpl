<table class="forum" style="width: {page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{lang:explorer} - {lang:show}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:view_file} <a href="{url:explorer_roots:dir={var:dir}}">{lang:back}</a>
    </td>
  </tr>
</table>
<br />

{if:showtable}
<table class="forum" style="width: {page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{lang:show} - {var:file}</td>
  </tr>
  <tr>
    <td class="leftb">

{var:content}

    </td>
  </tr>
</table>
{stop:showtable}{unless:showtable}
{var:content}
{stop:showtable}