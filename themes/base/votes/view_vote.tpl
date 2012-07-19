
<form method="post" id="vote" action="{votes:action}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="leftc">{votes:question}</td>
 </tr>
{loop:answers}
 <tr>
  <td class="leftb">
    <input name="voted_answer{if:several_name}[{answers:value}]{stop:several_name}" value="{answers:value}"  type="{votes:type}" />    
    {answers:answer}
  </td>
 </tr>
{stop:answers}
 <tr>
  <td class="leftc">
    {if:several}
       <input name="votes_several" value="1"  type="hidden" />
    {stop:several}
   <input name="votes_id" value="{votes:id}"  type="hidden" />
   <input name="submit" value="{lang:create}"  type="submit" />
  </td>
 </tr>
</table>
</form>
