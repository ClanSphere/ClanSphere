<div class="container" style="width:{page:width}">
  <div class="headb">{lang:mod} - {lang:manage}</div>
  <div class="headc clearfix">
  <div class="leftb fl">{icon:editpaste} <a href="{url:votes_create}">{lang:new_vote}</a></div>
  <div class="rightb fr">{head:pages}</div>
  </div>
  <div class="headc clearfix">
  <div class="leftb fr">{icon:contents} {lang:total}: {head:votes_count}</div>
  </div>
</div>
<br />

{head:message}
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
 <tr>
  <td class="headb">{sort:start} {lang:votes_start}</td>
  <td class="headb">{sort:end} {lang:votes_end}</td>
  <td class="headb">{sort:question} {lang:question}</td>
  <td class="headb" colspan="2">{lang:options}</td>
 </tr>
{loop:votes}
 <tr>
  <td class="leftc">{votes:start}</td>
  <td class="leftc">{votes:end}</td>
  <td class="leftc">{votes:question}</td>
  <td class="leftc"><a href="{url:votes_edit,id={votes:id}}">{icon:edit}</a></td>
  <td class="leftc"><a href="{url:votes_remove,id={votes:id}}">{icon:editdelete}</a></td>
 </tr>
{stop:votes}
</table>
