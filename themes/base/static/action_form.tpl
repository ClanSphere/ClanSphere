<form method="post" id="static" action="{url:action}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="leftc" style="width: 100px;">{icon:kedit} {lang:title} *</td>
    <td class="leftb"><input name="static_title" value="{static:title}" maxlength="50" size="50"  type="text" />
   </td>
  </tr>
  <tr>
    <td class="leftc">{icon:enumList} {lang:access} *</td>
    <td class="leftb">   <select name="static_access" >
{loop:access}
    <option value="{access:level_id}" {access:selected}>{access:level_id} - {access:level_name}</option>
{stop:access}
   </select>
   </td>
  </tr>
{if:nofckeditor}
<tr>
<td class="leftc">{icon:kedit} {lang:content} *</td>
<td class="leftb">{abcode:features} {static:phpcode}
<textarea name="static_text" cols="99" rows="35" id="static_text"  style="width: 98%;">{static:content}</textarea></td>
</tr>
{stop:nofckeditor}
{if:fckeditor}
<tr>
<td class="leftc" colspan="2">{icon:kedit} {lang:content} *</td>
</tr>
<tr>
<td colspan="2" style="padding:0px">{static:content}</td>
</tr>
{stop:fckeditor}
  <tr>
  	<td class="leftc">{icon:configure} {lang:config}</td>
    <td class="leftb">{static:admins}
	<input type="checkbox" name="static_table" value="1"  {static:table} /> {lang:tablelayout}<br />
<input type="checkbox" name="static_comments" value="1"  {static:comments} /> {lang:activate_comments}<br /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
		<input type="submit" name="submit" value="{static:lang_form}" />
		<input type="submit" name="preview" value="{lang:preview}" />
 		<input type="reset" name="reset" value="{lang:reset}" />
		<input type="hidden" name="id" value="{static:id}" />
		 </td>
  </tr>
</table>
</form>
