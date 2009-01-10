<div class="container" style="width:{page:width}">
    <div class="headb">{lang:mod} - {lang:manage}</div>
  <div class="headc clearfix">
    <div class="leftb fl">{icon:editpaste} {lang:new}</div>
    <div class="rightb fr">{pages:list}</div>
    <div class="centerb">{icon:contents} {lang:all} {lang:count}</div>
  </div>
</div>

<br />
{head:message}
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
  <tr>
    <td class="headb">{sort:name} {lang:name}</td>
    <td class="headb">{lang:genre}</td>
    <td class="headb">{lang:release}</td>
    <td class="headb" colspan="2" style="width:50px">{lang:options}</td>
  </tr>
  {loop:games}
  <tr>
    <td class="leftc">{games:name}</td>
    <td class="leftc">{games:genre}</td>
    <td class="leftc">{games:release}</td>
    <td class="leftc">{games:edit}</td>
    <td class="leftc">{games:del}</td>
  </tr>
  {stop:games}
</table>
