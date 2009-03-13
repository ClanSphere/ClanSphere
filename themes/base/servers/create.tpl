<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod} - {lang:head_create}</td>
  </tr>
  <tr>
    <td class="leftb">{body:create}</td>
  </tr>
</table>
<br />
<form action="{url:servers_create}" method="post" name="Servers Create">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="leftb">{icon:kedit} {lang:servername} *</td>
    <td class="leftc"><input type="text" name="servers_name" value="{create:servers_name}" maxlength="200" size="50" /></td>
  </tr>
  <tr>
    <td class="leftb">{icon:kedit} {lang:serverip} *</td>
    <td class="leftc"><input type="text" name="servers_ip"  value="{create:servers_ip}" maxlength="200" size="50" /></td>
  </tr>
  <tr>
    <td class="leftb">{icon:kedit} {lang:serverport} *</td>
    <td class="leftc"><input type="text" name="servers_port"  value="{create:servers_port}" maxlength="15" size="10" /></td>
  </tr> 
  <tr>
    <td class="leftb">{icon:kedit} {lang:serverspiel} *</td>
    <td class="leftc">
      <select name="games_id" onchange="cs_gamechoose(this.form)">
        <option value="">----</option>
        {loop:games}
          <option value="games:games_id">{games:games_name}</option>
        {stop:games}
      </select>
      <img src="uploads/games/0.gif" id="game_1" alt="" />
      - <a href="{url:games_create}">{lang:create}</a>
    </td>
  </tr>  
  <tr>
    <td class="headb" colspan="2">{lang:Erweiterter} - {lang:Serverstatus}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:kate} {lang:Serverstatus} *</td>
    <td class="leftc">
      <select name="servers_stats">
        {loop:stats}
          <option value="{stats:value}" {stats:selected}>{stats:name}</option>
        {stop:stats}
      </select>    
    </td>
  </tr>
  <tr>
    <td class="leftb">{icon:kate} {lang:proto} *</td>
    <td class="leftc">
      <select name="servers_class">
        <option value="">----</option>
        {loop:classes}
          <option value="{classes:class}" {classes:select}>{classes:name}</option>
        {stop:classes}
      </select>
    </td>
  </tr>
  <tr>
    <td class="leftb">{icon:kate} {lang:serverquerry} *</td>
    <td class="leftc"><input type="text" name="servers_query"  value="{create:servers_query}" maxlength="200" size="10" /></td>
  </tr>
  <tr>
    <td class="headb" colspan="2">{lang:Erweiterter} - {lang:order}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:kate} {lang:serverorder}</td>
    <td class="leftc"><input type="text" name="servers_order"  value="{create:servers_order}" maxlength="3" size="3" /></td>
  </tr>
  <tr>
    <td class="headb" colspan="2">{lang:Erweiterter} - {lang:liveoff}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:kate} {lang:type}</td>
    <td class="leftc">
      <select name="servers_type">
        <option value="">-----</option>
        {loop:typ}
          <option value="{typ:type}" {typ:selected}>{typ:name}</option>
        {stop:typ}
      </select>
    </td>
  </tr>
  <tr>
    <td class="leftb">{icon:kate} {lang:serverinfo}</td>
    <td class="leftc"><textarea name="servers_info" cols="75" rows="5" id="servers_info" class="form">{create:servers_info}</textarea></td>
  </tr>
  <tr>
    <td class="leftb">{icon:kate} {lang:slots}</td>
    <td class="leftc"><input type="text" name="servers_slots"  value="{create:servers_slots}" maxlength="5" size="4" /></td>
  </tr>  
  <tr>
    <td class="leftb">{icon:ksysguard} {lang:options}</td>
    <td class="leftc"><input type="submit" name="submit" value="{lang:create}" /></td>
  </tr>
</table>
</form>    