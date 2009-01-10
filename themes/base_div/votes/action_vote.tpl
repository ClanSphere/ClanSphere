<div class="container" style="width:{page:width}">
  <div class="centerc">{votes:question}</div>
{loop:answers}
  <div class="leftb"><input name="voted_answer" value="{answers:value}" type="radio"/>{answers:answer}</div>
{stop:answers}
</div>
<br />
