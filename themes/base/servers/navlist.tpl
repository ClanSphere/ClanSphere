{loop:servers}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:100%">
  <tr>
    <td class="centerb">{servers:hostname}</td>
  </tr>   
  <tr>
    <td class="centerb"><img src="{servers:map}" alt="" /></td>
  </tr> 
  {if:live}
  <tr>
    <td class="leftb">
      <b>{lang:host_navlist}</b><br />
      <a href="{servers:proto}{servers:servers_ip}">{servers:servers_ip}</a>
    </td>
  </tr>
  <tr>
    <td class="leftb">
      <b>{lang:game_navlist}</b><br />
      {servers:gametype}
    </td>
  </tr>
  <tr>
    <td class="leftb">
      <b>{lang:map_navlist}</b><br />
      {servers:mapname}
    </td>
  </tr>
  <tr>
    <td class="leftb">
      <b>{lang:players_navlist}</b><br />
      {servers:nowplayers} / {servers:maxplayers}
    </td>
  </tr>
  <tr>
    <td class="leftb">
      <b>{lang:response_navlist}</b><br />
      {servers:response}
    </td>
  </tr>  
  <tr>
    <td class="centerb"><a href="{url:servers_list}&id={servers:id}">Weitere Infos</a>
  </tr>
  {stop:live}
  {unless:live}
  <tr>
    <td class="centerb">Keine Verbindung zum Server. Live Status nicht möglich.</td>
  </tr>
  {stop:live}
</table>
<br />
{stop:servers}