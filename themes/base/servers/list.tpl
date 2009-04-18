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
          <td class="leftc" style="width:125px;">{lang:host}</td>
          <td class="leftb"><a href="{servers:proto}{servers:servers_ip}:{servers:servers_port}">{servers:hostname}</a></td>
        </tr>
		<tr>
          <td class="leftc" style="width:125px;">{lang:ip}</td>
          <td class="leftb">{servers:servers_ip}:{servers:servers_port}</td>
        </tr>
        <tr>
          <td class="leftc">{lang:type}</td>
          <td class="leftb">{servers:gametype}</td>
        </tr>
        <tr>
          <td class="leftc">{lang:map}</td>
          <td class="leftb">{servers:mapname}</td>
        </tr>
        <tr>
          <td class="leftc">{lang:players}</td>
          <td class="leftb">{servers:nowplayers} / {servers:maxplayers}</td>
        </tr>   
        <tr>
          <td class="leftc">{lang:ping}</td>
          <td class="leftb">{servers:response}</td>
        </tr> 
        <tr>
          <td class="leftc">{lang:pass}</td>
          <td class="leftb">{servers:pass}</td>
        </tr> 
        <tr>
          <td class="leftc">{lang:version}</td>
          <td class="leftb">{servers:os}</td>
        </tr>     
        <tr>
          <td class="leftc">{lang:privileges}</td>
          <td class="leftb">{servers:sets}</td>
        </tr>                       
      </table>
    </td>
    <td class="centerb"><img src="{page:path}{servers:map}" alt="" /></td>
  </tr>
</table>
<br />

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
    <td class="centerb"><img src="{page:path}{servers:map}" alt="" /></td>
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
<br />
{stop:server}

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="rightb">
      <a href="http://phgstats.sourceforge.net" target="_blank">based on phgstats</a>
    </td>
  </tr>
</table>