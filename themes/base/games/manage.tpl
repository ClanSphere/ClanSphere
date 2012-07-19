<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="2">{lang:mod_name} - {lang:manage}</td>
  </tr>
  <tr>    
    <td class="leftb">{icon:contents} {lang:all} {lang:count}</td>
    <td class="rightb">{pages:list}</td>
  </tr>
</table>

<br />
{head:message}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{sort:name} {lang:name}</td>
    <td class="headb">{lang:genre}</td>
    <td class="headb">{lang:release}</td>
    <td class="headb" colspan="2" style="width:50px">{lang:options}</td>
  </tr>
  {loop:games}
  <tr>
    <td class="leftc">{games:name}</td>
    <td class="leftc">{games:genre}</td>
    <td class="leftc">{games:release}</td>
    <td class="leftc">{games:edit}</td>
    <td class="leftc">{games:del}</td>
  </tr>
  {stop:games}
</table>
