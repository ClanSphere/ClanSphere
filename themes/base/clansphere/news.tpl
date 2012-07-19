{if:one}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:new_info}</td>
  </tr>
  <tr>
    <td class="leftb">{info:text}</td>
  </tr>
  <tr>
    <td class="centerc">{info:view} - {info:read} - {info:showall}</td>
  </tr>
</table>
<br />
{stop:one}
{if:all}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="2">{lang:mod_name} - {lang:new_infos}</td>
  </tr>
  {loop:infos}
  <tr>
    <td class="leftb">{infos:text}</td>
    <td class="leftb" style="width:50px">{infos:view}</td>
  </tr>
  {stop:infos}
</table>
{stop:all}