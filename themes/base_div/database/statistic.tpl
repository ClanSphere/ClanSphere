<div class="container" style="width:{page:width}">
    <div class="headb">{lang:mod} - {lang:statistic}</div>
    <div class="leftc">{lang:body_statistic}</div>
</div>
<br />
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:modul}</td>
    <td class="headb" style="width:25%">{lang:sql_tables}</td>
    <td class="headb" style="width:25%">{lang:sql_datasets}</td>
  </tr>
  {loop:statistic}
  <tr>
    <td class="leftc">{statistic:icon} <a href="{statistic:url}">{statistic:name}</a></td>
    <td class="leftb">{statistic:tables}<br />
    </td>
    <td class="rightb">{statistic:counts}<br />
    </td>
  </tr>
  {stop:statistic}


</table>
<br />
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="2">{lang:total}</td>
  </tr>
  <tr>
    <td class="leftc" style="width:50%">{lang:sql_tables}</td>
    <td class="leftb">{data:tables}</td>
  </tr>
  <tr>
    <td class="leftc">{lang:sql_datasets}</td>
    <td class="leftb">{data:dataset}</td>
  </tr>
</table>
