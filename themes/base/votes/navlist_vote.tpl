<form method="post" id="navlist" action="{url:action}">
{votes:question}<br />
{loop:answers}
  <input name="voted_answer{if:several_name}[{answers:value}]{stop:several_name}" value="{answers:value}"  type="{votes:type}" />{answers:answer}<br />
{stop:answers}
<input name="votes_id" value="{votes:id}"  type="hidden" />
{if:several}
<input name="votes_several" value="1"  type="hidden" />
{stop:several}
<input name="submit_votes" value="{lang:create}"  type="submit" />
</form>
