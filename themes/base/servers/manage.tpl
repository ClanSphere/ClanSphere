<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="2">{lang:mod_name} - {lang:head_manage}</td>
  </tr>
  <tr>    
    <td class="leftb">{icon:contents} {lang:total} {server:count}</td>
    <td class="rightb">{server:pages}</td>
  </tr>
  <tr>
    <td class="leftb" colspan="2"><a href="http://www.clansphere.net/index/files/view/where/9" target="_blank">{lang:mapsdl}</a></td>
  </tr>
</table>
<br />
{server:headmsg}
{if:viewfsock}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="leftb">{lang:fsockoff}</td>
  </tr>
</table>
<br />
{stop:viewfsock}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:id}</td>
    <td class="headb">{server:sort} {lang:headline}</td>
    <td class="headb">{lang:gametype}</td>
    <td class="headb">{lang:stats}</td>
    <td class="headb">{lang:gameclass}</td>
    <td class="headb" colspan="2">{lang:options}</td>
  </tr>
  {loop:servers}
    <tr>
      <td class="leftc">{servers:id}</td>
      <td class="leftc">{servers:name}</td>
      <td class="leftc">{servers:game}</td>
      <td class="centerc">{servers:stats}</td>
      <td class="leftc">{servers:class}</td>
      <td class="leftc">{servers:edit}</td>
      <td class="leftc">{servers:remove}</td>
    </tr>
  {stop:servers}
</table>