<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
	<tr>
		<td class="headb">
			{lang:mod} - {lang:create}
 		</td>
	</tr>
	<tr>
  	<td class="leftb">
			{lang:body_create}
		</td>
  </tr>
</table>
<br />
{if:error}
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="leftc">{create:errormsg}</td>
  </tr>
</table>
{stop:error}
{if:preview}
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="leftb" style="">{create:board_ico} </td>
    <td class="leftc"><strong><a href="#">{create:board_name} </a></strong><br />
    {create:pre_text} </td>
    <td class="leftb"></td>
    <td class="leftc"></td>
    <td class="leftb"></td>
  </tr>
</table>
{stop:preview}
<br />
<form method="post" name="board_create" action="/trunk/index.php?mod=board&amp;action=create">

<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
<tbody><tr><td class="leftc">
{icon:kedit} {lang:name} *</td><td class="leftb">

 <input name="board_name" value="{create:board_name}" maxlength="200" size="50" class="form" type="text">

 </td></tr><tr><td class="leftc">
{icon:folder_yellow} {lang:category} *</td><td class="leftb">
{create:cat_drop}
 </td></tr><tr><td class="leftc">
{icon:kate} {lang:text} *</td><td class="leftb">
{create:ab_box}

<textarea name="board_text" cols="50" rows="5" id="board_text" class="form">{create:board_text}</textarea>

 </td></tr><tr><td class="leftc">
{icon:access} {lang:access} *</td><td class="leftb" colspan="2">
<select name="board_access" class="form">
{loop:access}
{access:access_level}
{stop:access}
</select>

 </td></tr><tr><td class="leftc">
{icon:access} {lang:only_read} *</td><td class="leftb">

 <input name="board_read" value="1" class="form" type="radio">{lang:yes}
 <input name="board_read" value="0" checked="checked" class="form" type="radio">{lang:no}
 </td></tr><tr><td class="leftc">

{icon:password} {lang:add_password}</td><td class="leftb">

 <input name="board_pwd" value="{create:board_pwd}" onkeydown="javascript:passwordcheck(this.value);" onkeyup="javascript:passwordcheck(this.value);" maxlength="30" size="30" class="form" type="password"><br />
{lang:password1}
 </td></tr><tr><td class="leftc">
{icon:password} Sicherheitsstufe:</td><td class="leftb">
<div style="float: left; background-image: url({page:path}symbols/votes/vote03.png); width: 100px; height: 13px; margin-top: 3px; margin-left: 2px;">
<div style="float: left; background-image: url({page:path}symbols/votes/vote01.png); width: 1px; height: 13px;" id="pass_secure"></div>
</div>
<div style="float: left; padding-left: 3px; padding-top: 3px; display: none;" id="pass_stage_1">Stufe 1</div><div style="float: left; padding-left: 3px; padding-top: 3px; display: none;" id="pass_stage_2">Stufe 2</div>
<div style="float: left; padding-left: 3px; padding-top: 3px; display: none;" id="pass_stage_3">Stufe 3</div><div style="float: left; padding-left: 3px; padding-top: 3px; display: none;" id="pass_stage_4">Stufe 4</div>
<br />
{create:sec_level} </td></tr><tr><td class="leftc">
{icon:yast_group_add} {create:squad_lang}</td>
<td class="leftb">

{create:squad_drop}

 </td></tr><tr><td class="leftc">
{icon:ksysguard} {lang:options}</td><td class="leftb">

 <input name="submit" value="{lang:create}" class="form" type="submit">
 <input name="preview" value="{lang:preview}" class="form" type="submit">
 <input name="reset" value="{lang:reset}" class="form" type="reset">

 </td></tr></tbody></table>
</form>
