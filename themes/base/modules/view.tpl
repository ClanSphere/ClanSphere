<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:mods_details}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:body_mods_view}</td>
  </tr>
</table>
<br />

<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="leftc" style="width:140px">{icon:kedit} {lang:name}</td>
    <td class="leftb">{mod:name}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:kate} {lang:version}</td>
    <td class="leftb">{mod:version}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:1day} {lang:date}</td>
    <td class="leftb">{mod:released}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:lock} {lang:protected}</td>
    <td class="leftb">{mod:protected}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:personal} {lang:creator}</td>
    <td class="leftb">{mod:creator}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:kdmconfig} {lang:team}</td>
    <td class="leftb">{mod:team}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:gohome} {lang:homepage}</td>
    <td class="leftb">{mod:url}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:icons} {lang:icon}</td>
    <td class="leftb">{mod:icon_48}  - {mod:icon_16}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:kate} {lang:description}</td>
    <td class="leftb">{mod:text}</td>
  </tr>
  {if:access_explorer}
  <tr>
    <td class="leftc">{icon:configure} {lang:extended}</td>
    <td class="leftb">{icon:kfm} {extended:link}</td>
  </tr>
  {stop:access_explorer}
</table>
<br />

<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb" colspan="2">{lang:access_files}</td>
  </tr>
  <tr>
    <td class="leftc" style="width:50%">{sort:file} {lang:file_name}</td>
    <td class="leftc" style="width:50%">{sort:access} {lang:access_from}</td>
  </tr>
  {loop:axx}
  <tr>
    <td class="leftb">{axx:file}</td>
    <td class="leftb">{axx:access}</td>
  </tr>
  {stop:axx}
</table>