<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="3">{lang:mod_name} - {lang:head1}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:body}</td>
    <td class="rightb">{pages:list}</td>
  </tr>
</table>
<br />
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{sort:name} {lang:name}</td>
    <td class="headb">{lang:genre}</td>
    <td class="headb">{sort:usk} {lang:usk}</td>
    <td class="headb" colspan="2">{lang:release}</td>
  </tr>
  {loop:games}
  <tr>
    <td class="leftc">{games:name}</td>
    <td class="leftc">{games:genre}</td>
    <td class="leftc">{games:usk}</td>
    <td class="leftc">{games:release}</td>
  </tr>
  {stop:games}
</table>
