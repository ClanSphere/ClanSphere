<div class="container" style="width:{page:width}">
    <div class="headb">{lang:mod} - {lang:users}</div>
    <div class="leftc">{lang:addons}</div>
</div>
<br />
<div class="container" style="width:{page:width}">
  <div class="headc clearfix">
    <div class="leftb fl">{lang:body}</div>
    <div class="rightb fr">{pages:list}</div>
  </div>
</div>
<br />
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
  <tr>
    <td class="headb">{sort:clans} {lang:clans}</td>
    <td class="headb">{sort:squads} {lang:squads}</td>
    <td class="headb">{lang:task}</td>
    <td class="headb">{sort:joined} {lang:joined}</td>
  </tr>
  {loop:clans}
  <tr>
    <td class="leftc">{clans:name}</td>
    <td class="leftc">{clans:short}</td>
    <td class="leftc">{clans:task}</td>
    <td class="leftc">{clans:since}</td>
  </tr>
  {stop:clans}
</table>
