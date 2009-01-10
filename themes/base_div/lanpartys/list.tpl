<div class="container" style="width:{page:width}">
    <div class="headb">{lang:mod} - {lang:head_list}</div>
    <div class="leftb fl">{lang:body}</div>
    <div class="rightb fr">{pages:list}</div>
</div>
<br />
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
  <tr>
    <td class="headb">{sort:name} {lang:name}</td>
    <td class="headb">{sort:start} {lang:start}</td>
    <td class="headb">{sort:postal_place} {lang:postal_place}</td>
  </tr>
  {loop:lanpartys}
  <tr>
    <td class="leftc">{lanpartys:name}</td>
    <td class="leftc">{lanpartys:start}</td>
    <td class="leftc">{lanpartys:lanpartys_postalcode} - {lanpartys:lanpartys_place}</td>
  </tr>
  {stop:lanpartys}
</table>
