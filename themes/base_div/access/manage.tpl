<div class="container" style="width:{page:width}">
    <div class="headb">{lang:mod} - {lang:head_manage}</div>
  <div class="headc clearfix">
    <div class="leftb fl">{icon:editpaste} <a href="{lang:create}" >{lang:new_access}</a></div>
    <div class="rightb fr">{pages:list}</div>
  </div>
  <div class="headc clearfix">
    <div class="rightb fr">{icon:contents} {lang:total}: {lang:count}</div>
  </div>
</div>
<br />

<center>{lang:getmsg}</center>
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
  <tr>
    <td class="headb">{sort:name} {lang:name}</td>
    <td class="headb">{sort:access} {lang:access}</td>
    <td class="headb">{sort:clansphere} ClanSphere</td>
    <td class="headb" colspan="2">{lang:options}</td>
  </tr>
  {loop:access}
  <tr>
    <td class="leftc">{access:name}</td>
    <td class="leftc">{access:access}</td>
    <td class="leftc">{access:clansphere}</td>
    <td class="leftc">{access:edit}</td>
    <td class="leftc">{access:remove}</td>
  </tr>
  {stop:access}
</table>
