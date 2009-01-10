<div class="container" style="width:{page:width}">
    <div class="headb">{lang:mod} - {lang:head_users}</div>
    <div class="leftc">{users:addons}</div>
</div>
<br />
<div class="container" style="width:{page:width}">
  <div class="headc clearfix">
    <div class="leftb">{lang:body}</div>
    <div class="rightb">{pages:list}</div>
  </div>
</div>
<br />
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
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
