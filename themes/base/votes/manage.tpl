<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb" colspan="2">{lang:mod_name} - {lang:manage}</td>
 </tr>
 <tr>  
  <td class="leftb">{icon:contents} {lang:total}: {head:votes_count}</td>
  <td class="rightb">{head:pages}</td>
 </tr>
</table>
<br />
{head:message}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
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
  <td class="leftc"><a href="{url:votes_view:where={votes:id}}">{votes:question}</a></td>
  <td class="leftc"><a href="{url:votes_edit:id={votes:id}}">{icon:edit}</a></td>
  <td class="leftc"><a href="{url:votes_remove:id={votes:id}}">{icon:editdelete}</a></td>
 </tr>
{stop:votes}
</table>