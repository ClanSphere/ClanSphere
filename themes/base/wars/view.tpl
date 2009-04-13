<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb">{lang:mod} - {lang:details}</td>
 </tr>
 <tr>
  <td class="leftb">{head:topline}</td>
 </tr>
</table>
<br />
{lang:getmsg}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="leftc">{icon:package_games}{lang:game}</td>
  <td class="leftb" colspan="2">{game:icon}{game:link}</td>
 </tr>
 <tr>
  <td class="leftc" style="width:140px">{icon:folder_yellow}{lang:category}</td>
  <td class="leftb">{category:link}</td>
 </tr>
 <tr>
  <td class="leftc">{icon:kdmconfig}{lang:enemy}</td>
  <td class="leftb">{enemy:link}<br />{wars:opponents}</td>
 </tr>
 <tr>
  <td class="leftc">{icon:yast_group_add}{lang:squad}</td>
  <td class="leftb">{squad:link}</td>
 </tr>
 <tr>
  <td class="leftc">{icon:kdmconfig}{lang:players}</td>
  <td class="leftb">{wars:players1} {lang:on} {wars:players2}</td>
 </tr>
 <tr>
  <td class="leftc">{icon:kdmconfig}{lang:players}</td>
  <td class="leftb">{wars:players}</td>
 </tr>
 <tr>
  <td class="leftc">{icon:1day}{lang:date}</td>
  <td class="leftb">{date:show}</td>
 </tr>
 <tr>
  <td class="leftc">{icon:demo}{lang:status}</td>
  <td class="leftb">{war:status}</td>
 </tr>
 <tr>
  <td class="leftc">{icon:smallcal}{lang:score}</td>
  <td class="leftb">{war:score1} : {war:score2} {result:img}</td>
 </tr>
 <tr>
  <td class="leftc">{icon:gohome}{lang:url}</td>
  <td class="leftb" colspan="2">{war:link}</td>
 </tr>
 <tr>
  <td class="leftc">{icon:images}{lang:pictures}</td>
  <td class="leftb">{pictures:show}</td>
 </tr>
 <tr>
  <td class="leftc">{icon:kate}{lang:report}</td>
  <td class="leftb">{war:report}</td>
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
			</from>
		</td>
	</tr>
	{stop:status}
</table>
{stop:squadmember}