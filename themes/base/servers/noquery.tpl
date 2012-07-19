<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:mod_list}</td>
  </tr>
</table>
<br />
{loop:servers}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="2">{servers:name}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:ip}</td>
    <td class="leftc"><a href="HLSW;//{servers:url}">{servers:url}</a></td>
  </tr>
  <tr>
    <td class="leftb">{lang:type}</td>
    <td class="leftc">{servers:type}</td>
  </tr>  
  <tr>
    <td class="leftb">{lang:slots}</td>
    <td class="leftc">{lang:max} {servers:slots} {lang:slots}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:type}</td>
    <td class="leftc"><img src="{page:path}{servers:img}" alt="" /> {servers:game}</td>
  </tr> 
  <tr>
    <td class="leftb">{lang:serverinfo}</td>
    <td class="leftc">{servers:info}</td>
  </tr>   
</table>
<br />
{stop:servers}
<br />
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="rightb">
      <a href="http://gameq.sourceforge.net" target="_blank">based on GameQ</a></td>
  </tr>
</table>