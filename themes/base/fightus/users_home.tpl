<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="4">{lang:last_fightus}</td>
  </tr>
  <tr>
    <td class="leftc">{lang:game}</td>
    <td class="leftc">{lang:clan}</td>
    <td class="leftc">{lang:fight_date}</td>
    <td class="leftc" style="width:180px">{lang:since}</td>
  </tr>
  {loop:fightus}
  <tr>
    <td class="leftb">{fightus:game}</td>
    <td class="leftb"><a href="{fightus:url_view}">{fightus:clan}</a></td>
    <td class="leftb">{fightus:date}</td>
    <td class="leftb">{fightus:since}</td>
  </tr>
  {stop:fightus}
</table>
<br />