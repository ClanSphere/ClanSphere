<div class="container" style="width:{page:width}">
    <div class="headb">{lang:mod} - {lang:center}</div>
  <div class="headc clearfix">
    <div class="leftb fl">{icon:editpaste} {lang:new}</div>
    <div class="rightb fr">{pages:list}</div>
    <div class="leftb fr">{icon:contents} {lang:all} {lang:count}</div>
  </div>
</div>
<br />
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:name}</td>
    <td class="headb">{lang:short}</td>
    <td class="headb" colspan="2" style="width:50px">{lang:options}</td>
  </tr>
  {loop:clans}
  <tr>
    <td class="leftc">{clans:name}</td>
    <td class="leftc">{clans:short}</td>
    <td class="leftc" style="width:25px">{clans:edit}</td>
    <td class="leftc" style="width:25px">{clans:remove}</td>
  </tr>
  {stop:clans}
</table>

