<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb" colspan="2">{lang:mod_name} - {lang:details}</td>
 </tr>
 <tr>
  <td class="leftb">{head:topline}</td>
  <td class="rightb">{lang:status}: {war:status} {result:img}</td> 
 </tr>
</table>
<br />
{lang:getmsg}

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="centerb" style="width:45%">{squad:logo}<br />{squad:country} {squad:link}</td> 
  <td class="centerb" style="vertical-align:middle;font-size:14px;font-weight:bold;"><span style="color:{result:color1}">{war:score1}</span> : <span style="color:{result:color2}">{war:score2}</span></td>   
  <td class="centerb" style="width:45%">{enemy:logo}<br />{enemy:country} {enemy:link}</td>
 </tr>
 <tr>
  <td class="centerb">{wars:players}</td>
  <td class="centerb">{wars:players1} {lang:on} {wars:players2}</td>
  <td class="centerb">{wars:opponents}</td>
 </tr>
</table>
<br />
 
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}"> 
 <tr>
  <td class="headb" colspan="2">{lang:details}</td>
 </tr>
 <tr>
  <td class="leftc">{icon:package_games}{lang:game}</td>
  <td class="leftb" colspan="2">{game:icon}{game:link}</td>
 </tr>
 <tr>
  <td class="leftc" style="width:140px">{icon:folder_yellow}{lang:category}</td>
  <td class="leftb">{category:link}</td>
 </tr>
 <tr>
  <td class="leftc">{icon:1day}{lang:date}</td>
  <td class="leftb">{date:show}</td>
 </tr>
 <tr>
  <td class="leftc">{icon:gohome}{lang:url}</td>
  <td class="leftb" colspan="2">{war:link}</td>
 </tr>
 <tr>
  <td class="leftc">{icon:images}{lang:pictures}</td>
  <td class="leftb">{pictures:show}</td>
 </tr>
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb" style="width:50%">{lang:report}</td>
  <td class="headb">{lang:report2}</td>  
 </tr>
 <tr>
  <td class="leftb">{war:report}</td>
  <td class="leftb">{war:report2}</td>  
 </tr>
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb" colspan="4">{lang:rounds}</td>
 </tr>
 <tr>
  <td class="leftc" style="width:15%">{lang:map}</td>
  <td class="leftc" colspan="2" style="width:15%">{lang:result}</td>
  <td class="leftc" style="width:70%">{lang:comment}</td>
 </tr>
 {loop:rounds}
 <tr>
  <td class="leftb"><a href="{rounds:mapurl}">{rounds:maps_name}</a></td>
  <td class="leftb">{rounds:rounds_score1} : {rounds:rounds_score2}</td>
  <td class="leftb">{rounds:resulticon}</td>
  <td class="leftb">{rounds:rounds_description}</td>
 </tr>
 {stop:rounds}
</table>

{if:squadmember}
<br />
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="3">{lang:players}</td>
  </tr>
  <tr>
    <td class="leftc">{lang:player}</td>
    <td class="leftc">{lang:plays}</td>
    <td class="leftc">{lang:date}</td>
  </tr>
  {if:no_players}
  <tr>
    <td class="leftb" colspan="3">{lang:no_players}</td>
  </tr>
  {stop:no_players}
  {loop:nplayers}
  <tr>
    <td class="leftb">{nplayers:user}</td>
    <td class="leftb">{nplayers:status}</td>
    <td class="leftb">{nplayers:date}</td>
  </tr>
  {stop:nplayers}
  {if:status}
  <tr>
    <td class="rightb" colspan="3">{lang:join_war}
      <form method="post" id="statusedit" action="{url:wars_view:id={status:wars_id}}">
        <select name="players_status">
          <option value="yes" {status:yes}>{lang:yes}</option>
          <option value="maybe" {status:maybe}>{lang:maybe}</option>
          <option value="no" {status:no}>{lang:no}</option>
        </select>
        <input type="hidden" name="players_id" value="{status:players_id}" />
        <input type="hidden" name="wars_id" value="{status:wars_id}" />
        <input type="submit" name="status" value="{lang:submit}" />
      </form>
    </td>
  </tr>
  {stop:status}
</table>
{stop:squadmember}