<div class="container" style="width:{page:width}">
  <div class="headb">{lang:members} - {lang:list}</div>
  <div class="headc clearfix">
  	<div class="leftb fl">{icon:contents}{lang:total}: {count:members}</div>
  	<div class="rightb fr"><a href="{pictured:url}">{pictured:name}</a></div>
  </div>
</div>
<br />

{loop:squads}
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
 <tr>
  <td class="headb" colspan="5">
    <div style="float:left">{squads:gameicon} {squads:name}</div>
    <div style="float:right">{squads:membercount}</div>
  </td>
 </tr>
 <tr>
  <td class="leftc" style="width:35px" align="center">{lang:country}</td>
  <td class="leftc" style="width:150px">{lang:nick}</td>
  <td class="leftc" >{lang:task}</td>
  <td class="leftc" style="width:80px">{lang:since}</td>
  <td class="leftc" style="width:30px" align="center">{lang:page}</td>
 </tr>
 {loop:members}
 <tr>
  <td class="leftb">{members:country}</td>
  <td class="leftb">{members:nick}</td>
  <td class="leftb">{members:task}</td>
  <td class="leftb">{members:since}</td>
  <td class="leftb">{members:status}</td>
 </tr>
 {stop:members}
</table>
<br />
{stop:squads}