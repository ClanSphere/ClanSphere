
<form method="post" id="vote" action="{form:action}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="leftc">{icon:1day} {lang:start} *</td>
  <td class="leftb">{votes:start_dateselect}</td>
 </tr>
 <tr>
  <td class="leftc">{icon:today} {lang:end} *</td>
  <td class="leftb">{votes:end_dateselect}</td>
 </tr>
 <tr>
  <td class="leftc">{icon:enumList} {lang:access} *</td>
  <td class="leftb">
   <select name="votes_access">
{loop:access}
    <option value="{access:level_id}" {access:selected}>{access:level_id} - {access:level_name}</option>
{stop:access}
   </select>
  </td>
 </tr>
 <tr>
  <td class="leftc">{icon:kedit} {lang:question} *</td>
  <td class="leftb"><input name="votes_question" value="{votes:question}" maxlength="50" size="50"  type="text" /></td>
 </tr>
{loop:form_answers}
 <tr>
  <td class="leftc">{icon:kate} {lang:answer} {form_answers:number} *</td>
  <td class="leftb"><input type="text" name="{form_answers:name}" value="{form_answers:value}" maxlength="80" size="50" /></td>
 </tr>
{stop:form_answers}
 <tr>
  <td class="leftc">{icon:configure} {lang:more}</td>
  <td class="leftb">
    <input type="checkbox" name="votes_close" value="1" />{lang:restrict_comments}<br />
  <input type="checkbox" name="votes_several" value="1"  {several:checked} />{lang:several}
  
  </td>
 </tr>
 <tr>
  <td class="leftc">{icon:ksysguard} {lang:options}</td>
  <td class="leftb">
   <input type="submit" name="submit" value="{votes:lang_submit}" />
   <input type="submit" name="preview" value="{lang:preview}" />
      <input type="submit" name="election" value="{lang:add_election}" />
   <input type="hidden" name="run_loop" value="{votes:answers_count}" />
   <input type="hidden" name="id" value="{votes:id}" />
   </td>
 </tr>
</table>
</form>
