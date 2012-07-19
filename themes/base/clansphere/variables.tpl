<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:head_variables}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:body_variables}</td>
  </tr>
</table>
<br />
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  {loop:com}
  <tr>
    <td class="leftc" style="width:40%">{com:var}</td>
    <td class="leftb">{com:value}</td>
  </tr>
  {stop:com}
</table>
<br />
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  {loop:main}
  <tr>
    <td class="leftc" style="width:40%">{main:var}</td>
    <td class="leftb">{main:value}</td>
  </tr>
  {stop:main}
</table>
<br />
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  {loop:log}
  <tr>
    <td class="leftc" style="width:40%">{log:var}</td>
    <td class="leftb">{log:value}</td>
  </tr>
  {stop:log}
</table>
<br />
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  {loop:account}
  <tr>
    <td class="leftc" style="width:40%">{account:var}</td>
    <td class="leftb">{account:value}</td>
  </tr>
  {stop:account}
</table>
