<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="3">{lang:mod_name} - {lang:cache}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:total}: {count:total}</td>
    <td class="centerb">{lang:size}: {count:size}</td>
    <td class="rightb">{pages:show}</td>
  </tr>
</table>
<br />
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="centerb">{lang:body_cache}</td>
  </tr>
  <tr>
    <td class="centerc"><a href="{link:reload}">{lang:reload}</a> - <a href="{link:empty_cache}">{lang:empty_cache}</a>{info:cache_cleared}</td>
  </tr>
</table>
<br />
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:name}</td>
    <td class="headb">{lang:date}</td>
    <td class="headb">{lang:size}</td>
  </tr>
  {loop:cache}
  <tr>
    <td class="leftb">{cache:name}</td>
    <td class="leftb">{cache:date}</td>
    <td class="rightb">{cache:size}</td>
  </tr>
  {stop:cache}
</table>