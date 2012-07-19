{if:result}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width};">
  <tr>
    <td class="headb" colspan="2">{lang:result}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:contents}{lang:hit}: {result:count}</td>
  <td class="rightb">{result:pages}</td>
  </tr>
</table>
<br />
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width};">
  <tr>
    <td class="headb">{sort:name}{lang:name}</td>
  <td class="headb">{sort:cat}{lang:cat}</td>
  <td class="headb">{sort:time}{lang:time}</td>
  <td class="headb">{lang:creator}</td>
  </tr>
  {loop:results}
  <tr>
     <td class="leftc" style="font-weight:bold;">{results:name}</td>
  <td class="leftc">{results:cat}</td>
  <td class="leftc">{results:date}</td>
  <td class="leftc">{results:user}</td>
  </tr>
  {stop:results}
</table>
{stop:result}
{if:noresults}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width};">
  <tr>
    <td class="leftb" colspan="3">{icon:important}{lang:nohit}</td>
  </tr>
 </table>
{stop:noresults}