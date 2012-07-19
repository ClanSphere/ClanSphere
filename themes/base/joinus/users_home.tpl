<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb" colspan="4">{lang:last_joinus}</td>
  </tr>
  <tr>
    <td class="leftc">{lang:game}</td>
    <td class="leftc">{lang:nick}</td>
    <td class="leftc">{lang:age}</td>
    <td class="leftc" style="width:180px">{lang:since}</td>
  </tr>
  {loop:join}
  <tr>
    <td class="leftb">{join:game}</td>
    <td class="leftb">{join:nick}</td>
    <td class="leftb">{join:age}</td>
    <td class="leftb">{join:since}</td>
  </tr>
  {stop:join}
</table>
<br />
