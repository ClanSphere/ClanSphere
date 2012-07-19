<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="centerc">{votes:question}</td>
 </tr>
{loop:answers}
 <tr>
  <td class="leftb"><input name="voted_answer" value="{answers:value}" type="{votes:type}" /> {answers:answer}</td>
 </tr>
{stop:answers}
</table>
<br />