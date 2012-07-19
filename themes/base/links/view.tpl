<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb" colspan="2">{lang:mod_name} - {lang:details}</td>
  </tr>
  <tr>
    <td class="leftc" style="width:140px">{icon:kedit} {lang:name}</td>
    <td class="leftb">{links:name}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:gohome} {lang:url}</td>
    <td class="leftb"><a href="http://{links:url}" target="_blank">{links:url}</a></td>
  </tr>
  <tr>
    <td class="leftc">{icon:multimedia} {lang:status}</td>
    <td class="leftb"><span style="color:{links:color}">{links:on_off}</span></td>
  </tr>
  {if:img}
  <tr>
    <td class="leftc">{icon:thumbnail} {lang:icon}</td>
    <td class="leftb">{links:img}</td>
  </tr>
  {stop:img}
  <tr>
    <td class="headb" colspan="2">{lang:info}</td>
  </tr>
  <tr>
    <td class="leftc" colspan="2">{links:info}</td>
  </tr>
</table>