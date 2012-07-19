<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb" colspan="2">{lang:members} - {lang:list}</td>
 </tr>
 <tr>
  <td class="leftb">{icon:contents}{lang:total}: {count:members}</td>
  <td class="rightb"><a href="{pictured:url}">{pictured:name}</a></td>
 </tr>
</table>
<br />

{loop:squads}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb" colspan="5">
    <div style="float:left">{squads:gameicon} {squads:name}</div>
    <div style="float:right">{squads:membercount}</div>
  </td>
 </tr>
 <tr>
  <td class="leftc" style="width:35px" align="center">{lang:country}</td>
  <td class="leftc" style="width:150px">{lang:nick}</td>
  <td class="leftc">{lang:task}</td>
  <td class="leftc" style="width:80px">{lang:since}</td>
  <td class="leftc" style="width:30px" align="center">{lang:status}</td>
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
 {if:text}
 <tr>
  <td class="leftc" colspan="5">{squads:squads_text}</td>
 </tr>{stop:text}
</table>
<br />
{stop:squads}