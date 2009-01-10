<div class="container" style="width:{page:width}">
    <div class="headb">{lang:mod} - {lang:head_list}</div>
  <div class="headc clearfix">
    <div class="leftb fl">{icon:contents} {lang:all} {lang:count}</div>
    <div class="rightb fr">{pages:list}</div>
  </div>
</div>
<br />
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:country}</td>
    <td class="headb">{sort:name} {lang:name}</td>
    <td class="headb">{sort:short} {lang:short} </td>
  </tr>
  {loop:clans}
  <tr>
    <td class="leftc" style="width:5%">{clans:country}</td>
    <td class="leftc" style="width:60%">{clans:name}</td>
    <td class="leftc" style="width:35%">{clans:short}</td>
  </tr>
  {stop:clans}
</table>
