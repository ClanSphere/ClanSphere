{if:result}
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb" colspan="2">{lang:result}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:contents}{lang:hit}: {result:count}</td>
    <td class="rightb">{result:pages}</td>
  </tr>
</table>
<br />

<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{sort:headline}{lang:headline}</td>
    <td class="headb">{sort:date}{lang:date}</td>
  </tr>
  {loop:results}
  <tr>
    <td class="leftc" style="font-weight:bold;">{results:headline}</td>
    <td class="leftc">{results:date}</td>
  </tr>
  {stop:results}
</table>
{stop:result}
{if:noresults}
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="leftb" colspan="3">{icon:important}{lang:nohit}</td>
  </tr>
</table>
{stop:noresults}