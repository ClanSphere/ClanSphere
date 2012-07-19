<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
    <tr>
      <td class="headb" colspan="2">{lang:mod_name}</td>
    </tr>
    <tr>
      <td class="leftb">{lang:mod_list}</td>
      <td class="rightb"><a href="{url:servers_list}">{lang:refresh}</a></td>
  </tr>
</table>
<br />
{if:server}
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
                      <td class="leftb"><a href="{servers:servers_link}">{servers:hostname}</a></td>
                  </tr>
                  <tr>
                      <td class="leftc" style="width:125px;">{lang:ip}</td>
                      <td class="leftb">{servers:gq_address}:{servers:port}</td>
                  </tr>
                  <tr>
                      <td class="leftc">{lang:game}</td>
                      <td class="leftb">{servers:game_descr}</td>
                  </tr>        
                  <tr>
                      <td class="leftc">{lang:map}</td>
                      <td class="leftb">{servers:map}</td>
                  </tr>
                  <tr>
                      <td class="leftc">{lang:players}</td>
                      <td class="leftb">{servers:num_players} / {servers:max_players}</td>
                  </tr>   
                  <tr>
                      <td class="leftc">{lang:pass}</td>
                      <td class="leftb">{servers:pass}</td>
                  </tr> 
                  <tr>
                      <td class="leftc">{lang:version}</td>
                      <td class="leftb">{servers:version}</td>
                  </tr>     
            </table>
            </td>
            <td class="centerb"><img src="{page:path}{servers:mappic}" alt="" /></td>
          </tr>
    {stop:live}
    {unless:live}
          <tr>
            <td class="centerb">
                <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:100%">
                  <tr>
                      <td class="leftc" style="width:125px;">{lang:host}</td>
                      <td class="leftb"><a href="{servers:servers_link}">{servers:hostname}</a></td>
                  </tr>
                  <tr>
                      <td class="leftc" style="width:125px;">{lang:ip}</td>
                      <td class="leftb">{servers:ip}:{servers:port}</td>
                  </tr>
                  <tr>
                      <td class="leftc">{lang:game}</td>
                      <td class="leftb">{servers:game}</td>
                  </tr>        
                  <tr>
                      <td class="leftc">{lang:players}</td>
                      <td class="leftb">{servers:slots}</td>
                  </tr>
                  <tr>
                      <td class="leftc">{lang:info}</td>
                      <td class="leftb">{servers:info}</td>
                  </tr>
            </table>
            </td>
            <td class="centerb"><img src="{page:path}{servers:mappic}" alt="" /></td>
          </tr>
    {stop:live}
    </table>
    <br />
    {if:playersexist}
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
    {stop:playersexist}
    <br /><br /> 
  {stop:servers}
{stop:server}

{unless:server}
  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
      <tr>
        <td class="centerb">{lang:no_server}</td>
      </tr>
  </table>
  <br />
  <br />
{stop:server}

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
    <tr>
      <td class="centerb">
          <a href="http://gameq.sourceforge.net" target="_blank">based on GameQ</a>
      </td>
    </tr>
</table>