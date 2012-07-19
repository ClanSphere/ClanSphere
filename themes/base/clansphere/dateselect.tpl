<div style="float: left; text-align: left; padding-right: 10px">
{lang:year}<br />
<select name="{date:name}_year">
  {year:options}
</select>
</div>
<div style="float: left; text-align: left; padding-right: 10px">
{lang:month}<br />
<select name="{date:name}_month">
  {month:options}
</select>
</div>
<div style="float: left; text-align: left; padding-right: 10px">
{lang:day}<br />
<select name="{date:name}_day">
  {day:options}
</select>
</div>
{if:unix}
<div style="float: left; text-align: left; padding-right: 10px">
{lang:time}<br />
<input type="text" name="{date:name}_hours" value="{expl:hours}" maxlength="2" size="2" /> :
<input type="text" name="{date:name}_mins" value="{expl:mins}" maxlength="2" size="2" /> 
{if:ampm}
<select name="{date:name}_ampm">
  {ampm:options}
</select> 
{stop:ampm}
</div>
{stop:unix}