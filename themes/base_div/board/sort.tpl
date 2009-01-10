<div class="container" style="width:{page:width}">
    <div class="headb">{lang:mod} - {lang:sort}</div>
    <div class="leftb"><a href="{link:back}">{lang:back}</a> </div>
</div>
<br />
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod}</td>
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
    <td class="leftb">{board:board_name}</td>
    <td class="leftb" style="width:5%">{board:board_order}</td>
    <td class="leftb" style="width:10%">{board:board_up}</td>
    <td class="leftb" style="width:10%">{board:board_down}</td>
  </tr>
  {stop:board}
  {stop:cat}
</table>
