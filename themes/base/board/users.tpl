<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:users}</td>
  </tr>
  <tr>
    <td class="leftb">{users:addons}</td>
  </tr>
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="2">{lang:stats}</td>
  </tr>
  <tr>
    <td class="leftc" style="width:140px">{lang:com}</td>
    <td class="leftb">{count:com} ( {count_com:per_day} )</td>
  </tr>
  <tr>
    <td class="leftc">{lang:rank}</td>
    <td class="leftb">{count:rank}</td>
  </tr>
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="4">{last:com}</td>
  </tr>
  <tr>
    <td class="leftc">{lang:cat}</td>
    <td class="leftc">{lang:board}</td>
    <td class="leftc">{lang:thread}</td>
    <td class="leftc">{lang:date}</td>
  </tr>
  {loop:com}
  <tr>
    <td class="leftb"><a href="{com:cat_link}">{com:cat}</a></td>
    <td class="leftb"><a href="{com:board_link}">{com:board}</a></td>
    <td class="leftb"><a href="{com:thread_link}">{com:thread}</a></td>
    <td class="leftb">{com:date}</td>
  </tr>
  {stop:com}
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="4">{last:thr}</td>
  </tr>
  <tr>
    <td class="leftc">{lang:cat}</td>
    <td class="leftc">{lang:board}</td>
    <td class="leftc">{lang:thread}</td>
    <td class="leftc">{lang:date}</td>
  </tr>
  {loop:thr}
  <tr>
    <td class="leftb"><a href="{thr:cat_link}">{thr:cat}</a></td>
    <td class="leftb"><a href="{thr:board_link}">{thr:board}</a></td>
    <td class="leftb"><a href="{thr:thread_link}">{thr:thread}</a></td>
    <td class="leftb">{thr:date}</td>
  </tr>
  {stop:thr}
</table>