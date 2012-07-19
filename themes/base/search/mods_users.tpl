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
    <td class="headb" style="width:40px;">{lang:country}</td>
    <td class="headb">{sort:nick}{lang:nick}</td>
    <td class="headb">{sort:laston}{lang:laston}</td>  
    <td class="headb" style="width:40px;">{lang:status}</td>  
  {if:access}
  <td class="headb">&nbsp;</td>
  {stop:access}
  </tr>
  {loop:results}
  <tr>
  <td class="leftc">{results:img}</td>
  <td class="leftc" style="font-weight:bold;">{results:user}</td>
  <td class="leftc">{results:date}</td>
  <td class="leftc">{results:icon}</td>
  {if:access}
  <td class="leftc">{results:msg}</td>
  {stop:access}
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
<br />