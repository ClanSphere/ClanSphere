<select name="{date:name}_year">
	<option value="0">----</option>
	{year:options}
</select> -
<select name="{date:name}_month">
	<option value="0">----</option>
	{month:options}
</select> -
<select name="{date:name}_day">
	<option value="0">----</option>
	{day:options}
</select> 
{if:unix}
T <input type="text" name="{date:name}_hours" value="{expl:hours}" maxlength="2" size="2" /> :
<input type="text" name="{date:name}_mins" value="{expl:mins}" maxlength="2" size="2" /> 
{if:ampm}
<select name="{date:name}_ampm">
	{ampm:options}
</select> 
{stop:ampm}
{stop:unix}