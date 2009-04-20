<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:head_new}</td>
  </tr>
  <tr>
    <td class="leftc">{lang:body}</td>
  </tr>
</table>
<br />

{head:getmsg}

{if:form}
<form method="post" action="{url:joinus_new}">
  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
    <tr>
	  <td class="leftc">{icon:personal} {lang:nick} *</td>
	  <td class="leftb"><input type="text" name="joinus_nick" value="{join:joinus_nick}" size="40" maxlength="40"  /></td>
	</tr>
	<tr>
	  <td class="leftc">{icon:personal} {lang:vorname}</td>
	  <td class="leftb"><input type="text" name="joinus_name" value="{join:joinus_name}" size="50" maxlength="80"  /></td>	
	</tr>
	<tr>
	  <td class="leftc">{icon:personal} {lang:surname}</td>
	  <td class="leftb"><input type="text" name="joinus_surname" value="{join:joinus_surname}" size="50" maxlength="80"  /></td>	
	</tr>	
    {if:nopass}
	<tr>
      <td class="leftc"> {icon:password} {lang:password} *</td>
      <td class="leftb"><input type="password" name="users_pwd" value="" maxlength="30" size="30"  onkeydown="javascript:passwordcheck(this.value);" onkeyup="javascript:passwordcheck(this.value);"/>
      </td>
    </tr>
	<tr>
	  <td class="leftc"> {icon:password} {lang:secure}</td>
	  <td class="leftb">
	    <div style="float:left; background-image:url({page:path}symbols/votes/vote03.png); width:100px; height:13px; margin-top: 3px; margin-left: 2px;">
		  <div style="float:left; background-image:url({page:path}symbols/votes/vote01.png); width: 1px; height: 13px;" id="pass_secure">
		  </div>
		</div>
		<div style="float:left; padding-left: 3px; padding-top: 3px; display:none" id="pass_stage_1">
		  {lang:stage_1}
		</div>
		<div style="float:left; padding-left: 3px; padding-top: 3px; display:none" id="pass_stage_2">
		  {lang:stage_2}
		</div>
		<div style="float:left; padding-left: 3px; padding-top: 3px; display:none" id="pass_stage_3">
		  {lang:stage_3}
		</div>
		<div style="float:left; padding-left: 3px; padding-top: 3px; display:none" id="pass_stage_4">
		  {lang:stage_4}
		</div>
		<div style="clear:both;">
		  {clip:plus} <a href="javascript:cs_clip('pass')">{lang:secure_stages}</a>
		  <div style="display:none" id="span_pass">
		    {lang:stage_1}{lang:stage_1_text}<br />
  		    {lang:stage_2}{lang:stage_2_text}<br />
  		    {lang:stage_3}{lang:stage_3_text}<br />
  		    {lang:stage_4}{lang:stage_4_text}
		  </div>
      </div>
      </td>	  
	</tr>
	{stop:nopass}
	{if:pass}
	<tr>
      <td class="leftc">{icon:password} {lang:password}</td>
	  <td class="leftb">*****</td>
	</tr>
	{stop:pass}
	<tr>
	  <td class="leftc">{icon:1day} {lang:birthday} *</td>
	  <td class="leftb">{join:date}</td>
	</tr>
	<tr>
	  <td class="leftc">{icon:starthere} {lang:place}</td>
	  <td class="leftb"><input type="text" name="joinus_place" value="{join:joinus_place}" size="40" maxlength="40"  /></td>
	</tr>
    <tr>
      <td class="leftc">{icon:locale} {lang:country}</td>
      <td class="leftb">
        <select name="joinus_country"  onchange="document.getElementById('country_1').src='{page:path}symbols/countries/' + this.form.joinus_country.options[this.form.joinus_country.selectedIndex].value + '.png'">
       {loop:country}
       <option value="{country:short}"{country:selection}>{country:full}</option>{stop:country}
      </select>
      {join:country_url}
	  </td>
    </tr>
	<tr>
	  <td class="leftc">{icon:mail_generic} {lang:email} *</td>
	  <td class="leftb"><input type="text" name="joinus_email" value="{join:joinus_email}" size="40" maxlength="40"  /></td>
	</tr>
	<tr>
	  <td class="leftc">{icon:licq} {lang:icq}</td>
	  <td class="leftb"><input type="text" name="joinus_icq" value="{join:joinus_icq}" size="12" maxlength="12"  /></td>
	</tr>
	<tr>
	  <td class="leftc">{icon:msn_protocol} {lang:msn}</td>
	  <td class="leftb"><input type="text" name="joinus_msn" value="{join:joinus_msn}" size="40" maxlength="40"  /></td>
	</tr>	
	<tr>
	  <td class="leftc">{icon:package_games} {lang:game}</td>
	  <td class="leftb">
	   <select name="games_id"  onchange="document.getElementById('game').src='{page:path}uploads/games/' + this.form.games_id.options[this.form.games_id.selectedIndex].value + '.gif'">
		 <option value="0">---</option>
	   {loop:games}
	     <option value="{games:short}"{games:selection}>{games:name}</option>
	   {stop:games}
	    </select>
		{join:games_url}
	  </td>
	</tr>
	<tr>
	  <td class="leftc">{icon:yast_group_add} {lang:squad}</td>
	  <td class="leftb">{squad:list}</td>
	</tr>
	<tr>
	  <td class="leftc">{icon:network} {lang:webcon}</td>
	  <td class="leftb"><input type="text" name="joinus_webcon" value="{join:joinus_webcon}" size="50" maxlength="80"  /></td>
	</tr>
	<tr>
	  <td class="leftc">{icon:network_local} {lang:lanact}</td>
	  <td class="leftb"><input type="text" name="joinus_lanact" value="{join:joinus_lanact}" size="50" maxlength="80"  /></td>
    </tr>
	<tr>
	  <td class="leftc">{icon:1day} {lang:joindate} *</td>
	  <td class="leftb">{date:join}</td>
	</tr>
	<tr>
	  <td class="leftc">{icon:documentinfo} {lang:info}<br /><br />{abcode:smileys}</td>
	  <td class="leftb">{abcode:features}<br />
	  	<textarea class="rte_abcode" name="joinus_more" cols="50" rows="12" id="joinus_more" >{join:joinus_more}</textarea>
	  </td>
	</tr>
	{if:captcha}
	<tr>
	  <td class="leftc">{icon:lockoverlay} {lang:security_code} *</td>
	  <td class="leftb"><img src="{page:path}mods/captcha/generate.php" alt="" />
	  	<input type="text" name="captcha" value="" size="8" maxlength="8"  />
	  </td>
	</tr>
	{stop:captcha}
	<tr>
	  <td class="leftc">{icon:documentinfo} {lang:rules} *</td>
	  <td class="leftb"><input type="checkbox" name="joinus_rules" value="1" {joinus:rules_selected} /> {rules:link} {lang:rules2}</td>
	</tr>	
    <tr>
      <td class="leftc"> {icon:ksysguard} {lang:options}</td>
      <td class="leftb"><input type="submit" name="submit" value="{lang:submit}" />
        <input type="reset" name="reset" value="{lang:reset}" />
      </td>
    </tr>
  </table>
</form>
{stop:form}