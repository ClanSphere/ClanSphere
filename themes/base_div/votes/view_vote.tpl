
<form method="post" name="vote" action="{votes:action}">
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
 <tr>
  <td class="leftc">{votes:question}</td>
 </tr>
{loop:answers}
 <tr>
  <td class="leftb"><input name="voted_answer" value="{answers:value}"  type="radio"/>{answers:answer}</td>
 </tr>
{stop:answers}
 <tr>
  <td class="leftc">
   <input name="votes_id" value="{votes:id}"  type="hidden" />
   <input name="submit" value="{lang:create}"  type="submit" />
  </td>
 </tr>
</table>
</form>
