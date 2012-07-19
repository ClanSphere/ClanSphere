<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="2"> {head:mod} - {head:action}</td>
  </tr>
  <tr>
    <td class="leftb"> {head:body}</td>
    <td class="rightb"> {head:pages}</td>
  </tr>
</table>
<br />
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" style="width:40px">{lang:country}</td>
    <td class="headb">{sort:nick} {lang:nick}</td>
    <td class="headb">{sort:place} {lang:place}</td>
    <td class="headb">{sort:laston} {lang:laston}</td>
  </tr>
  {loop:users}
  <tr>
    <td class="centerc">{users:country}</td>
    <td class="leftc">{users:nick}</td>
    <td class="leftc"> {users:place}</td>
    <td class="leftc"> {users:laston}</td>
  </tr>
  {stop:users}
</table>