<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:head_create}</td>
  </tr>
  <tr>
    <td class="leftb">{body:create}</td>
  </tr>
</table>
<br />
<form method="post" id="servers_create" action="{url:servers_create}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="leftc">{icon:kedit} {lang:servername} *</td>
    <td class="leftb"><input type="text" name="servers_name" value="{create:servers_name}" maxlength="200" size="50" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:kedit} {lang:serverip} *</td>
    <td class="leftb"><input type="text" name="servers_ip"  value="{create:servers_ip}" maxlength="200" size="50" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:kedit} {lang:serverport} *</td>
    <td class="leftb"><input type="text" name="servers_port"  value="{create:servers_port}" maxlength="15" size="10" /></td>
  </tr> 
  <tr>
    <td class="leftc">{icon:kedit} {lang:servergame} *</td>
    <td class="leftb">
      <select name="games_id" onchange="cs_gamechoose(this.form)">
        <option value="">----</option>
        {loop:games}
          <option value="{games:value}" {games:selected}>{games:name}</option>
        {stop:games}
      </select>
    <img src="{page:path}uploads/games/0.gif" id="game_1" alt="" />
      - <a href="{url:games_create}">{lang:create}</a>
    </td>
  </tr>  
  <tr>
    <td class="headb" colspan="2">{lang:advanced} - {lang:serverstatus}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:kate} {lang:serverstatus} *</td>
    <td class="leftb">
      <select name="servers_stats">
        {loop:stats}
          <option value="{stats:value}" {stats:selected}>{stats:name}</option>
        {stop:stats}
      </select>    
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:kate} {lang:proto} *</td>
    <td class="leftb">
      <select name="servers_class">
        <option value="">----</option>
        {loop:classes}
          <option value="{classes:class}" {classes:select} class="{classes:port}">{classes:name}</option>
        {stop:classes}
      </select>
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:kate} {lang:serverquery} *</td>
    <td class="leftb"><input type="text" name="servers_query"  value="{create:servers_query}" maxlength="200" size="10" /></td>
  </tr>
  <tr>
    <td class="headb" colspan="2">{lang:advanced} - {lang:order}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:kate} {lang:serverorder}</td>
    <td class="leftb"><input type="text" name="servers_order"  value="{create:servers_order}" maxlength="3" size="3" /></td>
  </tr>
  <tr>
    <td class="headb" colspan="2">{lang:advanced} - {lang:liveoff}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:kate} {lang:type} *</td>
    <td class="leftb">
      <select name="servers_type">
        <option value="">-----</option>
        {loop:typ}
          <option value="{typ:type}" {typ:selected}>{typ:name}</option>
        {stop:typ}
      </select>
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:kate} {lang:serverinfo}</td>
    <td class="leftb"><textarea class="rte_abcode" name="servers_info" cols="75" rows="5" id="servers_info">{create:servers_info}</textarea></td>
  </tr>
  <tr>
    <td class="leftc">{icon:kate} {lang:slots}</td>
    <td class="leftb"><input type="text" name="servers_slots"  value="{create:servers_slots}" maxlength="5" size="4" /></td>
  </tr>  
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb"><input type="submit" name="submit" value="{lang:create}" /></td>
  </tr>
</table>
</form>    