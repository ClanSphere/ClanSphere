<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod} - {lang:toplist}</td>
  </tr>
  <tr>
    <td class="leftc">{pages:list}</td>
  </tr>
</table>
<br />
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:number}</td>
    <td class="headb">{lang:nick}</td>
    <td class="headb">{lang:comments}</td>
    <td class="headb">{lang:rank}</td>
  </tr>
  {loop:toplist}
  <tr>
    <td class="{toplist:class}">{toplist:number}</td>
    <td class="{toplist:class}"><a href="{toplist:nick_link}">{toplist:nick}</a></td>
    <td class="{toplist:class}">{toplist:comments}</td>
    <td class="{toplist:class}">{toplist:rank}</td>
  </tr>
  {stop:toplist}
</table>
