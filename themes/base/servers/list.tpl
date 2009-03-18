<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:mod_list}</td>
  </tr>
</table>
<br />
{if:server}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="centerb" colspan="3"><a href="{url:servers_list}">{lang:refresh}</a></td>
  </tr>
</table>
<br />
{loop:servers}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="2">{servers:hostname}</td>
  </tr>
  <tr>
    <td class="centerb">{lang:server} - {lang:info}</td>
    <td class="centerb" style="width:150px;">{lang:map}</td>
  </tr>
  {if:live}  
  <tr>
    <td class="centerb">
      <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:100%">
        <tr>
          <td class="leftb" style="width:125px;">{lang:ip}</td>
          <td class="leftc"><a href="{servers:proto}{servers:servers_ip}">{servers:hostname}</td>
        </tr>
        <tr>
          <td class="leftb">{lang:type}</td>
          <td class="leftc">{servers:gametype}</td>
        </tr>
        <tr>
          <td class="leftb">{lang:map}</td>
          <td class="leftc">{servers:mapname}</td>
        </tr>
        <tr>
          <td class="leftb">{lang:players}</td>
          <td class="leftc">{servers:nowplayers} / {servers:maxplayers}</td>
        </tr>   
        <tr>
          <td class="leftb">{lang:ping}</td>
          <td class="leftc">{servers:response}</td>
        </tr> 
        <tr>
          <td class="leftb">{lang:pass}</td>
          <td class="leftc">{servers:pass}</td>
        </tr> 
        <tr>
          <td class="leftb">{lang:version}</td>
          <td class="leftc">{servers:os}</td>
        </tr>     
        <tr>
          <td class="leftb">{lang:privileges}</td>
          <td class="leftc">{servers:sets}</td>
        </tr>                       
      </table>
    </td>
    <td class="centerb"><img src="{servers:map}" alt="" /></td>
  </tr>
</table>
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    {loop:playershead}
      <td class="centerb" style="font-weight:bold;">{playershead:name}</td>
    {stop:playershead}
  </tr>
  {loop:players}
  <tr>
    {players:0}
  </tr>
  {stop:players}
</table>
{stop:live}
{unless:live}
  <tr>
    <td class="centerb">{servers:info}</td>
    <td class="centerb"><img src="{servers:map}" alt="" /></td>
  </tr>
</table>
{stop:live}
<br />
{stop:servers}
{stop:server}
{unless:server}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="centerb">{lang:no_server}</td>
  </tr>
</table>
{stop:server}
<br />
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="rightb">
      <a href="http://phgstats.sourceforge.net" target="_blank">based on phgstats</a>
    </td>
  </tr>
</table>