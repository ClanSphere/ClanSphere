<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width};">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:details}</td>
  </tr>
  <tr>
    <td class="leftc">{lang:mapdetails}</td>
  </tr>
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width};">
  <tr>
    <td class="leftc">{lang:name}</td>
    <td class="leftb">{maps:maps_name}</td>
  </tr>
  <tr>
    <td class="leftc">{lang:game}</td>
    <td class="leftb">{games:games_name} {games:games_picture}</td>
  </tr>
  <tr>
    <td class="leftc">{lang:text}</td>
    <td class="leftb">{maps:maps_text}</td>
  </tr>
  {if:picture_set_map}
  <tr>
    <td class="leftc">{lang:picture}</td>
    <td class="leftb">{maps:maps_picture}</td>
  </tr>
  {stop:picture_set_map}
</table>