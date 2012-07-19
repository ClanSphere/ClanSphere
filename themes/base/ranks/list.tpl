<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb" colspan="2">{lang:mod_name} - {lang:head_list}</td>
  </tr>
  <tr>
    <td class="leftb">{head:body}</td>
    <td class="rightb">{head:pages}</td>
  </tr>
</table>
<br />

<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{sort:name} {lang:name}</td>
    <td class="headb">{lang:content}</td>
  </tr>
  {loop:ranks}
  <tr>
    <td class="leftc">{ranks:name}</td>
    <td class="leftc">{ranks:picture}</td>
  </tr>
  {stop:ranks}
</table>