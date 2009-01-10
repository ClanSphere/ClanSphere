<div class="container" style="width:{page:width}">
    <div class="headb">{lang:mod} - {lang:head_users}</div>
    <div class="leftc">{lang:addons}</div>
</div>
<br />
<div class="container" style="width:{page:width}">
    <div class="leftb">{lang:body}</div>
    <div class="rightb">{pages:list}</div>
</div>
<br />
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
  <tr>
    <td class="headb">{sort:name} {lang:name}</td>
    <td class="headb">{sort:start} {lang:start}</td>
    <td class="headb">{sort:status} {lang:status}</td>
  </tr>
  {loop:lanpartys}
  <tr>
    <td class="leftc">{lanpartys:name}</td>
    <td class="leftc">{lanpartys:start}</td>
    <td class="leftc">{lanpartys:status}</td>
  </tr>
  {stop:lanpartys}
</table>
