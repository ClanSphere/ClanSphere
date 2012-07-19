<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:head_users}</td>
  </tr>
  <tr>
    <td class="leftb">{users:addons}</td>
  </tr>
</table>
<br />
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="rightb">{pages:list}</td>
  </tr>
</table>
<br />
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{sort:name} {lang:name}</td>
    <td class="headb">{sort:since} {lang:since}</td>
  </tr>
  {loop:computers}
  <tr>
    <td class="leftc">{computers:name}</td>
    <td class="rightc">{computers:since}</td>
  </tr>
  {stop:computers}
</table>
