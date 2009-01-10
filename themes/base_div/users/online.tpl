<div class="container" style="width:{page:width}">
    <div class="headb"> {head:mod} - {head:action}</div>
    <div class="headc clearfix">
    <div class="leftb fl"> {head:body}</div>
    <div class="rightb fr"> {head:pages}</div>
    </div>
</div>
<br />
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
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