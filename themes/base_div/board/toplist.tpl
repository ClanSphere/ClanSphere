<div class="container" style="width:{page:width}">
    <div class="headb">{lang:mod} - {lang:toplist}</div>
    <div class="leftc">{pages:list}</div>
</div>
<br />
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
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
