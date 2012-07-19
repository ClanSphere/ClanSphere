<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:head_lang_view}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:body_lang_view}</td>
  </tr>
</table>
<br />
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="leftc" style="width:140px">{icon:kedit} {lang:name}</td>
    <td class="leftb">{lang_view:name}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:kate} {lang:version}</td>
    <td class="leftb">{lang_view:version}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:1day} {lang:mod_released}</td>
    <td class="leftb">{lang_view:mod_released}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:personal} {lang:creator}</td>
    <td class="leftb">{lang_view:creator}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:kdmconfig} {lang:mod_team}</td>
    <td class="leftb">{lang_view:mod_team}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:gohome} {lang:mod_url}</td>
    <td class="leftb">{lang_view:mod_url}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:kate} {lang:mod_desc}</td>
    <td class="leftb">{lang_view:mod_desc}</td>
  </tr>
</table>
<br />
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="2">{lang:translation_status}</td>
  </tr>
  <tr>
    <td class="leftc">{lang:file}</td>
    <td class="leftc">{lang:diff}</td>
  </tr>
  {loop:diff}
  <tr>
    <td class="leftb">{diff:file}</td>
    <td class="leftb">{diff:diff}</td>
  </tr>
  {stop:diff}
  <tr>
    <td class="centerb" colspan="2">{count:total}<br /><br />{count:stats}</td>
  </tr>
</table>
