<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:cache}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:body_cache}</td>
  </tr>
</table>
<br />
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="centerc"><a href="{link:reload}">{lang:reload}</a> - <a href="{link:empty_cache}">{lang:empty_cache}</a>{lang:cache_cleared}</td>
  </tr>
</table>
<br />
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:file}</td>
    <td class="headb">{lang:date}</td>
    <td class="headb">{lang:size}</td>
  </tr>
  {loop:cache}
  <tr>
    <td class="leftb">{cache:file}</td>
    <td class="leftb">{cache:date}</td>
    <td class="rightb">{cache:size}</td>
  </tr>
  {stop:cache}
  <tr>
    <td class="leftc" colspan="2">{lang:total}: {count:files}</td>
    <td class="rightc">{count:total}</td>
  </tr>
</table>
