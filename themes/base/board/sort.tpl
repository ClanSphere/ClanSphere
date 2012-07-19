<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="2">{lang:mod_name} - {lang:sort}</td>
  </tr>
  <tr>
    <td class="leftb"><a href="{link:back}">{lang:back}</a> </td>
    <td class="rightb"><a href="{link:delall}">{lang:delall}</a> </td>
  </tr>
</table>
<br />
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name}</td>
    <td class="headb">{lang:sort_num}</td>
    <td class="headb" colspan="2">{lang:using}</td>
  </tr>
  {loop:cat}
  <tr>
    <td class="leftc"><strong>{cat:categories_name}</strong></td>
    <td class="leftc" style="width:5%"><strong>{cat:categories_order}</strong></td>
    <td class="leftc" style="width:10%">{cat:categories_up}</td>
    <td class="leftc" style="width:10%">{cat:categories_down}</td>
  </tr>
  {loop:board}
  <tr>
    <td class="leftc">{board:board_name}</td>
    <td class="leftc" style="width:5%">{board:board_order}</td>
    <td class="leftc" style="width:10%">{board:board_up}</td>
    <td class="leftc" style="width:10%">{board:board_down}</td>
  </tr>
  {stop:board}
  {stop:cat}
</table>
