<form method="post" name="navlist" action="{url:action}">
{votes:question}<br />
{loop:answers}
	<input name="voted_answer" value="{answers:value}"  type="radio"/>{answers:answer}<br />
{stop:answers}
<input name="votes_id" value="{votes:id}"  type="hidden" />
<input name="submit_votes" value="{lang:create}"  type="submit" />
</form>
