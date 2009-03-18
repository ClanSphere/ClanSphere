<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="3">{lang:mod} - {lang:head_manage}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:editpaste} <a href="{url:servers_create}">{lang:new_serv}</a></td>
    <td class="leftb">{icon:contents} {lang:total} {server:count}</td>
    <td class="rightb">{server:pages}</td>
  </tr>
  <tr>
    <td class="leftb" colspan="3"><a href="http://www.clansphere.net/index/files/view/where/9" onclick="window.open('http://www.clansphere.net/index/files/view/where/9'); return false">{lang:mapsdl}</a></td>
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
    <td class="headb">{lang:gameclass}</td>
    <td class="headb" colspan="2">{lang:options}</td>
  </tr>
  {loop:servers}
    <tr>
      <td class="leftb">{servers:id}</td>
      <td class="leftb">{servers:name}</td>
      <td class="leftb">{servers:game}</td>
      <td class="leftb">{servers:class}</td>
      <td class="leftb">{servers:edit}</td>
      <td class="leftb">{servers:remove}</td>
    </tr>
  {stop:servers}
</table>