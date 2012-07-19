<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb" colspan="3">{lang:mod_name} - {lang:manage}</td>
  </tr>
  <tr>    
    <td class="leftb" style="width:40%">{icon:contents} {lang:total}: {head:count}</td>
    <td class="centerb"><a href="{url:newsletter_export}">{lang:export}</a></td>
    <td class="rightb" style="width:40%">{head:pages}</td>
  </tr>
</table>
<br />

{head:getmsg}

<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{sort:user} {lang:from}</td>
    <td class="headb">{lang:subject}</td>
    <td class="headb">{sort:date} {lang:date}</td>
    <td class="headb" colspan="2" rowspan="1">{lang:options}</td>
  </tr>
  {loop:newsletter}
  <tr>
    <td class="leftc">{newsletter:user}</td>
    <td class="leftc">{newsletter:subject}</td>
    <td class="leftc">{newsletter:date}</td>
    <td class="centerc"><a href="{url:newsletter_view:id={newsletter:id}}">{icon:info}</a></td>
    <td class="centerc"><a href="{url:newsletter_remove:id={newsletter:id}}">{icon:editdelete}</a></td>
  </tr>
  {stop:newsletter}
</table>