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
    <td class="headb">{lang:country}</td>
  <td class="headb">{sort:name}{lang:name}</td>
  <td class="headb">{sort:short}{lang:short}</td>
  </tr>
  {loop:results}
  <tr>
     <td class="leftc">{results:country}</td>
  <td class="leftc" style="font-weight:bold;">{results:clan}</td>
  <td class="leftc" style="width:15%;">{results:short}</td>
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